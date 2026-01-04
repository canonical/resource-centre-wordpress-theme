/*
		Plugin Name: Post Reading Time Extended
		Plugin URI: http://wpmu.org
		Description: An extended version of Bostjan Cigan's Post Reading Time Plugin (http://wpplugz.is-leet.com)
		Version: 1.0
		Author: Chris Knowles
		Author URI: http://wpmu.org
		License: GPL v2
	*/

// First we register all the functions
register_activation_hook(__FILE__, 'post_readtime_install');
register_deactivation_hook(__FILE__, 'post_readtime_uninstall');
add_action('admin_menu', 'post_readtime_admin_menu_create');
add_action('widgets_init', function() {
	register_widget('post_readtime_widget');
}); // Register the widget

// Options when activating the plugin
function post_readtime_install() {
	// Yeah I know, could be stored in one array, but for update purposes and back-legacy support lets leave it at that
	add_option('post_readtime_format', ' %min% min read ', '', 'yes'); // Add the option for prefix to string
	add_option('post_readtime_wpm', '200', '', 'yes'); // Add the words per second option (default 200 wps)
}

// Options when deactivating the plugin (delete the options from DB)
function post_readtime_uninstall() {
	delete_option('post_readtime_format');
	delete_option('post_readtime_wpm');
}

function post_readtime_admin_menu_create() {
	add_options_page('Post Read Time Settings', 'Post Reading Time', 'administrator', __FILE__, 'post_readtime_settings');
}

// The admin interface
function post_readtime_settings() {

	$message = "";

	if(is_admin()) {

		if(isset($_POST['pr_wpm'])) {
			$wpm = $_POST['pr_wpm'];
			$format = html_entity_decode($_POST['pr_format']);
			update_option('post_readtime_format', $format);
			update_option('post_readtime_wpm', $wpm);
			$message = "Options updated.";
		}

		$wpm = get_option('post_readtime_wpm');
		$suffix = stripslashes(htmlentities(get_option('post_readtime_format')));

?>

		  <div id="icon-options-general" class="icon32"></div><h2>Post Reading Time</h2>
		  <div id="poststuff">
			  <div class="postbox"><h3>Settings</h3>
				  <div class="inside less">
					  <p><strong><font color="red"><?php echo $message; ?></font></strong></p>
					  <form method="post" action="">
					  <p><strong>Words per minute</strong> <br /><input type="text" name="pr_wpm" value="<?php echo $wpm; ?>" /></p>
					  <p><strong>Format</strong> <br /><input type="text" name="pr_format" value="<?php echo $format; ?>" /> ( Format of the output. Use %min% and %sec% as placeholders. Example: %min% min read ) </p>
					  <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Update options') ?>" />
					  </form>
				  </div>
			  </div>
			  <div class="postbox"><h3>About</h3>
				  <div class="inside less">
				  <p>An average person reads 250 - 300 words for minute, so you can change the
				  default settings any way you like, the default here is 200 words per minute.</p>
				  <p>To use it, add <pre>< ?php post_read_time(); ? ></pre> to your template (where you want to output the
				  text).</p>
				  </div>
			  </div>
		  </div>

  <?php

	}

}

// Here, the widget code begins
class post_readtime_widget extends WP_Widget {

	public function __construct() {
		parent::__construct('post_readtime_widget', 'Post reading time');
	}

	function widget($args, $instance) {

		extract($args);
		$title = apply_filters('widget_title', $instance['title']);

		if(is_single()) {

			echo $before_widget;

			if($title) {
				echo $before_title . $title . $after_title;
			}

			echo set_readtime( get_the_ID() );

			echo $after_widget;

		}

	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}

	function form($instance) {

		$title = esc_attr($instance['title']);

?>

			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>">
					<?php _e('Title: '); ?>
	            </label>
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			</p>

<?php

	}

}

function post_read_time() {
	echo set_readtime( get_the_ID() );
}

function set_readtime( $post_id ) {

	if ( get_post_type( $post_id ) != 'post' ) return '';

	$words_per_second_option = get_option('post_readtime_wpm');
	$format = get_option('post_readtime_format');

	$num_words = get_post_meta( $post_id , 'word_count' , true);

	// if the word count is not set - existing content - then let's set it now
	if ( $num_words == '') {

		readtime_publish_post( $post_id );

		$num_words = get_post_meta( $post_id , 'word_count' , true);

		// still no word count? outta here
		if ( $num_words == '' ) return '';

	}

	$minutes = floor($num_words / $words_per_second_option);
	$seconds = floor($num_words % $words_per_second_option / ($words_per_second_option / 60));

	// if no %sec% found in format then round up the minutes
	if( strpos( $format , '%sec%' ) === false ) {

		if( $seconds >= 30 ) {
			$minutes = $minutes + 1;
			$seconds = 0;
		}
	}

	$readtime = str_replace( '%min%' , $minutes , $format );

	if ( $seconds > 0 ) $readtime = str_replace( '%sec%' , $seconds , $readtime );

	if ( $minutes == 1 ) {
		$readtime = str_replace( 'minutes', 'minute' , $readtime );
		$readtime = str_replace( 'mins', 'min' , $readtime );
	}

	return $readtime;
}
// Calculate the number of words for a post and add this to a custom field

function readtime_publish_post( $post_id ) {
	$content = apply_filters('the_content', get_post_field('post_content', $post_id));
	$num_words = str_word_count(strip_tags($content));

	update_post_meta($post_id, 'word_count' , $num_words );
}
add_action( 'publish_post', 'readtime_publish_post' );
