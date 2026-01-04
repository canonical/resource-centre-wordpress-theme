<?php

// make topics required
add_action('admin_print_scripts-post.php', 'my_publish_admin_hook');
add_action('admin_print_scripts-post-new.php', 'my_publish_admin_hook');
function my_publish_admin_hook(){
    global $typenow;
    if (in_array($typenow, array('post','page'))){
        ?>
        <script language="javascript" type="text/javascript">
            jQuery(document).ready(function() {
                jQuery('#post').submit(function() {
                    if (jQuery("#set-post-thumbnail").find('img').size() > 0) {
                        jQuery('#ajax-loading').hide();
                        jQuery('#publish').removeClass('button-primary-disabled');
                        return true;
                    }else{
                        alert("please set a featured image!!!");
                        jQuery('#ajax-loading').hide();
                        jQuery('#publish').removeClass('button-primary-disabled');
                        return false;
                    }
                    return false;
                });
            });
        </script>

        <?php
    }
}

// automatically add posts to groups based on selected topic/s
function add_group_automatically($post_ID) {
	global $wpdb;
	if (has_term( array( 'cloud', 'server' ), 'topic', $post->ID )) {
        // 422 = cloud-and-server
		$cat = array('cloud-and-server');
		wp_set_object_terms($post_ID, $cat, 'group', true);
	}

	elseif (has_term( array( 'phone', 'tablet' ), 'topic', $post->ID )) {
        // 415 = phone-and-tablet
		$cat = array('phone-and-tablet');
		wp_set_object_terms($post_ID, $cat, 'group', true);
	}

	elseif (has_term( 'internet-of-things', 'topic', $post->ID )) {
        // 415 = phone-and-tablet
		$cat = array('internet-of-things');
		wp_set_object_terms($post_ID, $cat, 'group', true);
	}

	elseif (has_term( 'canonical-announcements', 'topic', $post->ID )) {
        // 172 = phone-and-tablet
		$cat = array('canonical-announcements');
		wp_set_object_terms($post_ID, $cat, 'group', true);
	}

	elseif (has_term( 'people-and-culture', 'topic', $post->ID )) {
        // 172 = phone-and-tablet
		$cat = array('people-and-culture');
		wp_set_object_terms($post_ID, $cat, 'group', true);
	}

	elseif (has_term( 'internet-of-things', 'topic', $post->ID )) {
        // 172 = phone-and-tablet
		$cat = array('internet-of-things');
		wp_set_object_terms($post_ID, $cat, 'group', true);
	}

	elseif (has_term( 'desktop', 'topic', $post->ID )) {
        // 172 = phone-and-tablet
		$cat = array('desktop');
		wp_set_object_terms($post_ID, $cat, 'group', true);
	}
}
add_action('save_post', 'add_group_automatically');

// post types - add new post types here and at the top of post-types.php
$post_types = array('whitepaper', 'post', 'ebook', 'video', 'attachment', 'casestudy', 'infographic', 'webinar', 'event', 'case-study', 'presskits');

add_filter( 'upload_size_limit', 'b5f_increase_upload' );
function b5f_increase_upload( $bytes ) {
    return 33554432; // 32 megabytes
}

add_filter( 'wp_image_editors', 'change_graphic_lib' );
function change_graphic_lib($array) {
  return array( 'WP_Image_Editor_GD', 'WP_Image_Editor_Imagick' );
}

// add excerpts to pages
function gb_add_excerpts_to_pages() {
     add_post_type_support( 'page', 'excerpt' );
}
add_action( 'init', 'gb_add_excerpts_to_pages' );

function wpse31422_init() {
    add_rewrite_endpoint( 'year', EP_CATEGORIES );
}
add_action( 'init', 'wpse31422_init' );

/*
 * hide specified categories by username
 */
function gb_do_terms_exclusion() {
$current_user = wp_get_current_user();
$_menu_unrestricted_users = array( 'admin', 'root', 'gbancroft-canonical', 'peterm-ubuntu', 'yaili', 'yaili-2', 'tom.callway', 'tom-callway', 'carolinetarbett', 'amrisha-prashar', 'canonical', 'deadlight', 'inayaili', 'rebeccacradick' );

	if(! in_array( $current_user->user_login, $_menu_unrestricted_users ) ) {
		remove_menu_page( 'edit.php?post_type=productbusinesscard' );
		remove_menu_page( 'edit.php?post_type=topiccta' );
		remove_menu_page( 'edit.php?post_type=download' );
		remove_meta_box('download-typediv', 'Post', 'side');
		add_filter( 'list_terms_exclusions', 'gb_list_terms_exclusions', 10, 2 );
	}

}
add_action( 'admin_init', 'gb_do_terms_exclusion' );

function gb_list_terms_exclusions($exclusions,$args) {
    return $exclusions . " AND ( t.name <> 'Downloads' )";
}

/**
 * Get a post per shortcode.
 *
 * @param  array $atts There are three possible attributes:
 *					id: A post ID. Wins always, works always.
 *					title: A page title. Show the latest if there is more than one post
 *					with the same title.
 *					type: A post type. Only to be used in combination with one of the
 *					first two attributes. Might help to find the best match.
 *					Defaults to 'page'.
 * @return string|void
 */

function t5_embed_post( $atts ) {
	$defaults = array (
		'id'    			=> FALSE,
		'title' 			=> FALSE,
		'show_title' 	=> TRUE,
		'excerpt'			=> FALSE,
		'type'  			=> 'page'
	);
	extract( shortcode_atts( $defaults, $atts ) );

	//$page_title = apply_filters( 'the_title', get_the_title() );

	// Not enough input data.
	if ( ! $id and ! $title )
	{
		return;
	}

	$post = FALSE;

	if ( $id )
	{
		$post = get_post( $id );
	}
	elseif ( $title )
	{
		$posts = get_posts( array(
			'post_type'      => $type,
			'title'          => $title,
			'posts_per_page' => 1,
			'post_status'    => 'publish',
		) );
		$post = ! empty( $posts ) ? $posts[0] : null;
	}

	if ( $post )
	{
		if ( $excerpt )
		{
			$page_excerpt = apply_filters( 'the_excerpt', $post->post_excerpt );
			if ( $show_title )
			{
				$page_title = strip_tags(apply_filters( 'the_content', $post->post_title ));
			}
			return '<h2>'. $page_title . '</h2>' . $page_excerpt . '';
		} else {
			$page_content = apply_filters( 'the_content', $post->post_content );
			if ( $show_title )
			{
				$page_title = strip_tags(apply_filters( 'the_content', $post->post_title ));
			}
			return '<h2>'. $page_title . '</h2>' . $page_content . '';
		}
	}
}
add_shortcode( 'embed_post', 't5_embed_post' );

// make friendly mime names
function friendly_mime( $mime ){
	$mime_map = array(
		"application/pdf"		=> "<abbr title='Portable Document Format'>PDF</abbr>",
		"application/zip"		=> "ZIP",
		"image/jpeg"				=> "JPEG",
		"image/png"					=> "PNG",
		"image/gif"					=> "GIF"
	);
	// if $mime not present in the array, return it unchanged
	if( empty( $mime_map[ $mime ] ) ){ return $mime; }

	// otherwise, return the friendly mime-type
	return $mime_map[ $mime ];
}

function ep_event_query( $query ) {

	// http://codex.wordpress.org/Function_Reference/current_time
	$current_time = current_time('mysql');
	list( $today_year, $today_month, $today_day, $hour, $minute, $second ) = preg_split( '([^0-9])', $current_time );
	$current_timestamp = $today_year . $today_month . $today_day . $hour . $minute;

	global $wp_the_query;

	if ( $wp_the_query === $query && !is_admin() && is_post_type_archive( 'event' ) ) {
		$meta_query = array(
			array(
				'key' => '_start_eventtimestamp',
				'value' => $current_timestamp,
				'compare' => '>'
			)
		);
		$query->set( 'meta_query', $meta_query );
		$query->set( 'orderby', 'meta_value_num' );
		$query->set( 'meta_key', '_start_eventtimestamp' );
		$query->set( 'order', 'ASC' );
		$query->set( 'posts_per_page', '5' );
	}

}

add_action( 'pre_get_posts', 'ep_event_query' );

// Remove recent comments wp_head CSS
function remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
}
add_action('widgets_init', 'remove_recent_comments_style');

// replace "current-cat-" with class "active"
function current_to_active($text){
	$replace = array(
		// List of classes to replace with "active"
		'current-menu-item' => 'active',
		'current-cat' => 'active',
	);
	$text = str_replace(array_keys($replace), $replace, $text);
	return $text;
}
add_filter ('wp_nav_menu','current_to_active');
// end replace "current-cat-" with class "active"

// Add custom taxonomies and custom post types counts to dashboard
add_action( 'right_now_content_table_end', 'my_add_counts_to_dashboard' );

function my_add_counts_to_dashboard() {
	$showTaxonomies = 0;
	// Custom taxonomies counts
	if ($showTaxonomies) {
		$taxonomies = get_taxonomies( array( '_builtin' => false ), 'objects' );
		foreach ( $taxonomies as $taxonomy ) {
			$num_terms  = wp_count_terms( $taxonomy->name );
			$num = number_format_i18n( $num_terms );
			$text = _n( $taxonomy->labels->singular_name, $taxonomy->labels->name, $num_terms );
			$associated_post_type = $taxonomy->object_type;
			if ( current_user_can( 'manage_categories' ) ) {
				$num = '<a href="edit-tags.php?taxonomy=' . $taxonomy->name . '&post_type=' . $associated_post_type[0] . '">' . $num . '</a>';
				$text = '<a href="edit-tags.php?taxonomy=' . $taxonomy->name . '&post_type=' . $associated_post_type[0] . '">' . $text . '</a>';
			}
			echo '<td class="first b b-' . $taxonomy->name . 's">' . $num . '</td>';
			echo '<td class="t ' . $taxonomy->name . 's">' . $text . '</td>';
			echo '</tr><tr>';
		}
	}
	// Custom post types counts
	$post_types = get_post_types( array( '_builtin' => false ), 'objects' );
	foreach ( $post_types as $post_type ) {
		$num_posts = wp_count_posts( $post_type->name );
		$num = number_format_i18n( $num_posts->publish );
		$text = _n( $post_type->labels->singular_name, $post_type->labels->name, $num_posts->publish );
		if ( current_user_can( 'edit_posts' ) ) {
			$num = '<a href="edit.php?post_type=' . $post_type->name . '">' . $num . '</a>';
			$text = '<a href="edit.php?post_type=' . $post_type->name . '">' . $text . '</a>';
		}
		echo '<td class="first b b-' . $post_type->name . 's">' . $num . '</td>';
		echo '<td class="t ' . $post_type->name . 's">' . $text . '</td>';
		echo '</tr>';

		if ( $num_posts->pending > 0 ) {
			$num = number_format_i18n( $num_posts->pending );
			$text = _n( $post_type->labels->singular_name . ' pending', $post_type->labels->name . ' pending', $num_posts->pending );
			if ( current_user_can( 'edit_posts' ) ) {
				$num = '<a href="edit.php?post_status=pending&post_type=' . $post_type->name . '">' . $num . '</a>';
				$text = '<a href="edit.php?post_status=pending&post_type=' . $post_type->name . '">' . $text . '</a>';
			}
			echo '<td class="first b b-' . $post_type->name . 's">' . $num . '</td>';
			echo '<td class="t ' . $post_type->name . 's">' . $text . '</td>';
			echo '</tr>';
		}
	}
}

// prevent business cards from apearing in search results
function searchfilter($query) {
	if ($query->is_search) {
		$query->set('post_type',array('whitepaper', 'ebook', 'post', 'video', 'attachment', 'casestudy', 'attachment', 'infographic', 'checklists', 'webinar', 'event', 'presskits'));
	}
	return $query;
}
add_filter('pre_get_posts','searchfilter');
// end prevent business cards from apearing in search results

// add class to pagination links
add_filter('next_posts_link_attributes', 'posts_link_attributes_1');
add_filter('previous_posts_link_attributes', 'posts_link_attributes_2');

function posts_link_attributes_1() {
	return 'class="prev-post"';
}
function posts_link_attributes_2() {
	return 'class="next-post"';
}
// end add class to pagination links

// force display-name of users to Firstname Lastname
function force_pretty_displaynames() {
	$current_user = wp_get_current_user();
	if ($current_user->display_name != $current_user->first_name." ".$current_user->last_name){
		update_user_meta($current_user->ID, 'display_name', $current_user->first_name." ".$current_user->last_name);
	}

}
add_action('admin_head','force_pretty_displaynames');
// end force display-name of users to Firstname Lastname

// set max image
if ( ! isset( $content_width ) ) $content_width = 540;
// end set max image

// get category to output as list
function the_category_unlinked($separator = ' ') {
	$categories = (array) get_the_category();
	$thelist = '';
	foreach($categories as $category) {    // concate
		$thelist .= $separator . $category->category_nicename;
	}
	echo $thelist;
}
// end get category to output as list

add_action( 'pre_get_posts', 'wpse7687_pre_get_posts' );
function wpse7687_pre_get_posts( &$wp_query ) {
	if ( $wp_query->is_category && 'latest-news' == $wp_query->get_queried_object()->slug ) {
		$wp_query->set( 'posts_per_page', 4 );
	}
}

add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 100, 100, true );
add_theme_support( 'automatic-feed-links' );

function add_custom_fields_to_rss() {
    if(get_post_type() == 'event') {
      $start_date =  get_post_meta(get_the_ID(), '_start_eventtimestamp', true);
      $end_date =  get_post_meta(get_the_ID(), '_end_eventtimestamp', true);
      $location =  get_post_meta(get_the_ID(), '_event_location', true);
      $venue =  get_post_meta(get_the_ID(), '_event_venue', true);
        ?>
        <?php if($start_date != '') { echo '<eventStartDate><![CDATA[', $start_date, ']]></eventStartDate>'; } ?>
        <?php if($end_date != '') { echo '<eventEndDate><![CDATA[', $end_date, ']]></eventEndDate>'; } ?>
        <?php if($location != '') { echo '<eventLocation><![CDATA[', $location, ']]></eventLocation>'; } ?>
        <?php if($venue != '') { echo '<eventVenue><![CDATA[', $venue, ']]></eventVenue>'; } ?>
        <?php
    }
    if(get_post_type() == 'post') {
      $videoID =  get_post_meta(get_the_ID(), 'postVideo', true);
        ?>
        <?php if($videoID != '') { echo '<videoID><![CDATA[', $videoID, ']]></videoID>'; } ?>
        <?php
    }
}
add_action('rss2_item', 'add_custom_fields_to_rss');

// This theme uses wp_nav_menu() in one location.
register_nav_menu( 'primary-products', __( 'Products and services menu', 'Insights PLUS' ) );
register_nav_menu( 'primary-categories', __( 'Category menu', 'Insights PLUS' ) );
register_nav_menu( 'press-centre', __( 'Press centre', 'Insights PLUS' ) );


if (function_exists('register_sidebar'))
	register_sidebar(array(
			'name' => __( 'Search Sidebar' ),
			'id' => 'search-sidebar',
			'description' => __( 'Widgets in this area will be shown on the right-hand side.' ),
			'before_title' => '<h1>',
			'after_title' => '</h1>'
		));

// limit titles to 70 characters long
function gb_limit_title() {
$current_user = wp_get_current_user();
$_menu_unrestricted_users = array( 'admin', 'gbancroft-canonical', 'peterm-ubuntu', 'yaili', 'yaili-2', 'sian-aherne', 'sian.aherne', 'canonical', 'deadlight', 'inayaili' );

	if(! in_array( $current_user->user_login, $_menu_unrestricted_users ) ) {?>

       <script type="text/javascript">
            jQuery(document).ready( function($)
            {
                $('#title').keyup( function()
                {
                    var $this = $(this);
                    if($this.val().length > 70)
                        $this.val($this.val().substr(0, 70));
                });
            });
        </script>
    <?php
	}
}
add_action('admin_head', 'gb_limit_title');
// end limit titles to 70 characters long

// remove 'Press and 'Product business card' from categories
// 245 = press
// 180 = product business card
function gb_remove_press() {
?>
    <script type="text/javascript">
			jQuery(document).ready( function($) {
				$("#categorychecklist #category-245, #categorychecklist #category-180").hide();
			});
    </script>
    <?php
}
add_action('admin_head', 'gb_remove_press');
// end remove 'Press' from categories

// Removes ul class from wp_nav_menu
function remove_ul ( $menu ){
	return preg_replace( array( '#^<ul[^>]*>#', '#</ul>$#' ), '', $menu );
}
add_filter( 'wp_nav_menu', 'remove_ul' );

function get_excerpt(){
	$excerpt = get_the_content();
	$excerpt = preg_replace(" (\[.*?\])",'',$excerpt);
	$excerpt = strip_shortcodes($excerpt);
	$excerpt = strip_tags($excerpt);
	if ( is_search() ) {
		$excerpt = substr($excerpt, 0, 250);
	} elseif ( is_mobile_phone() ) {
		$excerpt = substr($excerpt, 0, 120);
	} else {
		$excerpt = substr($excerpt, 0, 140);
	}
	$excerpt = substr($excerpt, 0, strripos($excerpt, " "));
	$excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
	$excerpt = $excerpt.'&hellip;';
	return $excerpt;
}

// get popular posts based on view count
function getPostViews($postID){
	$count_key = 'post_views_count';
	$count = get_post_meta($postID, $count_key, true);
	if($count==''){
		delete_post_meta($postID, $count_key);
		add_post_meta($postID, $count_key, '0');
		return "0 View";
	}
	return $count.' Views';
}
function setPostViews($postID) {
	$count_key = 'post_views_count';
	$count = get_post_meta($postID, $count_key, true);
	if($count==''){
		$count = 0;
		delete_post_meta($postID, $count_key);
		add_post_meta($postID, $count_key, '0');
	}else{
		$count++;
		update_post_meta($postID, $count_key, $count);
	}
}
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
// end get popular posts based on view count

// redirect to single post if there is one post in category/tag
/*function stf_redirect_to_post(){
    global $wp_query;

    // If there is one post on archive page
    if( is_archive() && $wp_query->post_count == 1 ){
        // Setup post data
        the_post();
        // Get permalink
        $post_url = get_permalink();
        // Redirect to post page
        wp_redirect( $post_url );
    }

} add_action('template_redirect', 'stf_redirect_to_post');
*/
// end redirect to single post if there is one post in category/tag

// remove unnecessary items from wp_head
remove_action( 'wp_head', 'feed_links_extra', 3 ); // Display the links to the extra feeds such as category feeds
remove_action( 'wp_head', 'feed_links', 2 ); // Display the links to the general feeds: Post and Comment Feed
remove_action( 'wp_head', 'rsd_link' ); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action( 'wp_head', 'wlwmanifest_link' ); // Display the link to the Windows Live Writer manifest file.
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); // prev link
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); // start link
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 ); // Display relational links for the posts adjacent to the current post.
remove_action( 'wp_head', 'wp_generator' ); // Display the XHTML generator that is generated on the wp_head hook, WP version
// end remove unnecessary items from wp_head

/*
if(strstr($_SERVER['REQUEST_URI'], 'wp-admin/post-new.php')) {
ob_start('one_category_only');
}
function one_category_only($content) {
$content = str_replace('type="checkbox" ', 'type="radio" ', $content);
return $content;
}
*/

//Google Maps Shortcode
function do_googleMaps($atts, $content = null) {
	extract(shortcode_atts(array(
				"width" => '640',
				"height" => '480',
				"src" => ''
			), $atts));
	return '<iframe width="'.$width.'" height="'.$height.'" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://goo.gl/maps/1WyTM&amp;output=embed" ></iframe>';
}
add_shortcode("googlemap", "do_googleMaps");

function fjarrett_custom_taxonomy_dropdown( $taxonomy ) {
	$terms = get_terms( $taxonomy );
	if ( $terms ) {
		foreach ( $terms as $term ) {
			printf( '<label><input type="checkbox" value="%s" />%s</label>', esc_attr( $term->slug ), esc_html( $term->name ) );
		}
		print( '</select>' );
	}
}

// usage < fjarrett_custom_taxonomy_dropdown( 'topic' );

function wdd_in_category_count($catslugs = '', $display = true) {
	global $wpdb;

	$post_count = 0;
	$slug_where = '';
	$catslugs_arr = explode(',', $catslugs);

	foreach ($catslugs_arr as $catslugkey => $catslug) {
		if ( $catslugkey > 0 ) {
			$slug_where .= ', ';
		}

		$slug_where .= "'" . trim($catslug) . "'";
	}

	$slug_where = "cat_terms.slug IN (" . $slug_where . ")";

	$sql = "SELECT	COUNT( DISTINCT cat_posts.ID ) AS post_count " .
		"FROM 	" . $wpdb->term_taxonomy . " AS cat_term_taxonomy INNER JOIN " . $wpdb->terms . " AS cat_terms ON " .
		"cat_term_taxonomy.term_id = cat_terms.term_id " .
		"INNER JOIN " . $wpdb->term_relationships . " AS cat_term_relationships ON " .
		"cat_term_taxonomy.term_taxonomy_id = cat_term_relationships.term_taxonomy_id " .
		"INNER JOIN " . $wpdb->posts . " AS cat_posts ON " .
		"cat_term_relationships.object_id = cat_posts.ID " .
		"WHERE 	cat_posts.post_status = 'publish' AND " .
		"cat_posts.post_type = 'post' AND " .
		"cat_term_taxonomy.taxonomy = 'topic' AND " .
		$slug_where;

	$post_count = $wpdb->get_var($sql);

	if ( $display ) {
		echo $post_count;
	}

	return $post_count;

}

function get_term_post_count_by_type($term,$taxonomy,$type){
	$args = array(
		'fields' =>'ids', //we don't really need all post data so just id wil do fine.
		'posts_per_page' => -1, //-1 to get all post
		'post_type' => $type,
		'tax_query' => array(
			array(
				'taxonomy' => $taxonomy,
				'field' => 'slug',
				'terms' => $term
			)
		)
	);
	$ps = get_posts( $args );
	if (count($ps) > 0){return count($ps);}else{return 0;}
}

function get_category_id($cat_slug) {
	$cat_slug = (int) $cat_slug;
	$category = &get_category($cat_slug);
	return $category->id;
}

// rewrite all the slugs to be structured by date
function wpa37911_permastructs(){
	global $wp_rewrite;
	$wp_rewrite->extra_permastructs['category']['struct'] = '/category/%category%';
	$wp_rewrite->extra_permastructs['post_tag']['struct'] = '/tag/%post_tag%';
}
add_action( 'init', 'wpa37911_permastructs' );

// so we can show an image caption
/*function the_post_thumbnail_caption() {
	global $post;

	$thumbnail_id    = get_post_thumbnail_id($post->ID);
	$thumbnail_image = get_posts(array('p' => $thumbnail_id, 'post_type' => 'attachment'));

	if ($thumbnail_image && isset($thumbnail_image[0])) {
		echo '<p class="image-meta">'.$thumbnail_image[0]->post_excerpt.'</span>';
	}
}*/

//include the main class file
require_once("Tax-meta-class/Tax-meta-class.php");
if (is_admin()){
	/*
   * prefix of meta keys, optional
   */
	$prefix = 'ba_';
	/*
   * configure your meta box
   */
	$config = array(
		'id' => 'demo_meta_box',          // meta box id, unique per meta box
		'title' => 'Demo Meta Box',          // meta box title
		'pages' => array('category'),        // taxonomy name, accept categories, post_tag and custom taxonomies
		'context' => 'normal',            // where the meta box appear: normal (default), advanced, side; optional
		'fields' => array(),            // list of meta fields (can be added by field arrays)
		'local_images' => false,          // Use local or hosted images (meta box images for add/remove)
		'use_with_theme' => true          //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
	);

	/*
   * Initiate your meta box
   */
	$my_meta =  new Tax_Meta_Class($config);

	/* * Add fields to your meta box */

	//text field
	$my_meta->addText($prefix.'singular',array('name'=> __('Singular ','tax-meta')));
	$my_meta->addText($prefix.'plural',array('name'=> __('Plural ','tax-meta')));
	/*
   * To Create a reapeater Block first create an array of fields
   * use the same functions as above but add true as a last param
   */

	$repeater_fields[] = $my_meta->addText($prefix.'re_text_field_id',array('name'=> __('My Text ','tax-meta')),true);
	$repeater_fields[] = $my_meta->addTextarea($prefix.'re_textarea_field_id',array('name'=> __('My Textarea ','tax-meta')),true);
	$repeater_fields[] = $my_meta->addCheckbox($prefix.'re_checkbox_field_id',array('name'=> __('My Checkbox ','tax-meta')),true);
	$repeater_fields[] = $my_meta->addImage($prefix.'image_field_id',array('name'=> __('My Image ','tax-meta')),true);

	/*
   * Don't Forget to Close up the meta box decleration
   */
	//Finish Meta Box Decleration
	$my_meta->Finish();
}

// Facebook Open Graph gubbin's
add_action('wp_head', 'add_fb_open_graph_tags');
function add_fb_open_graph_tags() {
	global $post;
	if (is_single()) {
		if(get_the_post_thumbnail($post->ID, 'thumbnail')) :
			$thumbnail_id = get_post_thumbnail_id($post->ID);
		$thumbnail_object = get_post($thumbnail_id);
		$image = $thumbnail_object->guid;
		else :
			$image = '/wp-content/themes/resource-centre/static/img/facebook.png';
		endif ;
		//$description = get_bloginfo('description');
		$description = my_excerpt( $post->post_content, $post->post_excerpt );
		$description = strip_tags($description);
		$description = str_replace("\"", "'", $description); ?>
	<meta property="og:title" content="<?php the_title(); ?>" />
	<meta property="og:type" content="article" />
	<meta property="og:image" content="<?php echo $image; ?>" />
	<meta property="og:url" content="<?php the_permalink(); ?>" />
	<meta property="og:description" content="<?php echo $description ?>" />
<?php } elseif (is_home()) { ?>
	<meta property="og:title" content="<?php echo get_bloginfo('name'); ?>" />
	<meta property="og:url" content="<?php echo get_option('home'); ?>" />
	<meta property="og:description" content="I've just visited the <?php echo get_bloginfo('name'); ?> website and thought you would like it." />
	<meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/static/img/facebook.png">
<?php } elseif ( is_search() ) {
		$key = wp_specialchars($s, 1);
		$search_title = ('Search results for "' . $key . '"');
		global $wpdb;
		global $posted;
?>
	<meta property="og:description" content="I've just searched for '<?php $key = wp_specialchars($s, 1); echo $key; _e(''); ?>' on the Ubuntu Insights website and thought I'd share the results." />
<?php  } elseif (is_taxonomy('topic', 'category')) {
		$post_type = get_post_type_object( get_post_type($post));
		$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
		$cat_desc = get_category(get_query_var('cat'))->category_description;
		$category = basename(get_permalink());
		$current_tax = basename(get_permalink());
		$the_category = get_category_by_slug($current_tax);
		$get_page_name = basename(get_permalink());
		$cat_plural = get_tax_meta($the_category,'ba_plural');
		global $wpdb;
		global $posted;
?>
	<meta property="og:title" content="<?php echo get_bloginfo('name'); ?> <?php if($cat_plural == '') : ?><?php echo $get_page_name; ?> resources<?php else : ?><?php echo $cat_plural; ?><?php endif ; ?>" />
	<meta property="og:url" content="<?php echo "http://" . $_SERVER['HTTP_HOST']  . $_SERVER['REQUEST_URI']; ?>" />
	<meta property="og:description" content="See all <?php if($cat_plural == '') : ?> <?php echo $get_page_name; ?> resources<?php else : ?><?php echo $cat_plural; ?><?php endif ; ?> on Ubuntu Insights." />
	<meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/static/img/facebook.png">
<?php } ?>
	<meta property="og:site_name" content="<?php echo get_bloginfo('name'); ?>" />
<?php }
function my_excerpt($text, $excerpt){

	if ($excerpt) return $excerpt;

	$text = strip_shortcodes( $text );
	$text = apply_filters('the_content', $text);
	$text = str_replace(']]>', ']]&gt;', $text);
	$text = strip_tags($text);
	$excerpt_length = apply_filters('excerpt_length', 55);
	$excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
	$words = preg_split("/[\n
	 ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
	if ( count($words) > $excerpt_length ) {
		array_pop($words);
		$text = implode(' ', $words);
		$text = $text . $excerpt_more;
	} else {
		$text = implode(' ', $words);
	}

	return apply_filters('wp_trim_excerpt', $text, $raw_excerpt);
}

// proper is mobile, ignores tablet. Is good.
function is_mobile_phone() {
	$useragent=$_SERVER['HTTP_USER_AGENT'];
	if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
		return true;
}

// remove tax name from html title
function gb_remove_tax_name( $title, $sep, $seplocation ) {
	if ( is_tax() ) {
		$term_title = single_term_title( '', false );

		// Determines position of separator
		if ( 'right' == $seplocation ) {
			$title = $term_title . " $sep ";
		} else {
			$title = " $sep " . $term_title;
		}
	}

	return $title;
}
add_filter( 'wp_title', 'gb_remove_tax_name', 10, 3 );

//require_once("ultimate-wp-query-search-filter/ultimate-wpqsf.php");

//filter to add button to media library UI
function unattach_media_row_action( $actions, $post ) {
	if ($post->post_parent) {
		$url = admin_url('tools.php?page=unattach&noheader=true&&id=' . $post->ID);
		$actions['unattach'] = '<a href="' . esc_url( $url ) . '" title="' . __( "Unattach this media item.") . '">' . __( 'Unattach') . '</a>';
	}

	return $actions;
}

//action to set post_parent to 0 on attachment
function unattach_do_it() {
	global $wpdb;

	if (!empty($_REQUEST['id'])) {
		$wpdb->update($wpdb->posts, array('post_parent'=>0), array('id'=>$_REQUEST['id'], 'post_type'=>'attachment'));
	}

	wp_redirect(admin_url('upload.php'));
	exit;
}

//set it up
add_action( 'admin_menu', 'unattach_init' );
function unattach_init() {
	if ( current_user_can( 'upload_files' ) ) {
		add_filter('media_row_actions',  'unattach_media_row_action', 10, 2);
		//this is hacky but couldn't find the right hook
		add_submenu_page('tools.php', 'Unattach Media', 'Unattach', 'upload_files', 'unattach', 'unattach_do_it');
		remove_submenu_page('tools.php', 'unattach');
	}
}

function show_categories($atts, $content) {
		$exclude = array('Product business card', 'Uncategorized');
    extract( shortcode_atts( array('taxonomy' => 'topic'), $atts ) );
    $cats = get_categories(array('exclude' => $exclude, 'taxonomy' => $taxonomy,'hide_empty' => 1, 'hierarchical' => 0, 'parent' => 0));
    return show_categories_level($cats, '', '', $taxonomy);
}

function show_categories_level($cats, $names, $ids,$taxonomy) {
    $res = '';
    foreach ($cats as $cat) {
        if($names)$n = "$names, $cat->name"; else $n = $cat->name;
        if($ids)$i = "$ids, $cat->term_id"; else $i = $cat->term_id;
				$res = $res."<label for='cat-$i'><input id='cat-$i' name='cat[]' type='checkbox' value='$i' />$n</label>";
    }
    return $res."";
}
add_shortcode('show-categories', 'show_categories');

function show_terms($atts, $content) {
    extract( shortcode_atts( array('taxonomy' => 'topic'), $atts ) );
    $cats = get_categories(array('taxonomy' => $taxonomy,'hide_empty' => 1, 'hierarchical' => 0, 'parent' => 0));
    return show_terms_level($cats, '', '', $taxonomy);
}

function show_terms_level($cats, $names, $ids,$taxonomy) {
    $res = '';
    foreach ($cats as $cat) {
        if($names)$n = "$names, $cat->name"; else $n = $cat->name;
        if($ids)$i = "$ids, $cat->term_id"; else $i = $cat->slug;
				$res = $res."<label for='topic-$i'><input id='topic-$i' name='topic[]' type='checkbox' value='$cat->slug' />$n</label>";
    }
    return $res."";
}
add_shortcode('show-terms', 'show_terms');

require_once('wp-advanced-search/wpas.php');

// advanced search functionality
function advanced_search_query($query) {

	if($query->is_search()) {

    // categpory and term search
    if (isset($_GET['termlist']) && is_array($_GET['termlist']) OR isset($_GET['topiclist']) && is_array($_GET['topiclist'])) {
		$tax_query_args = array(
		'relation' => 'OR',
					array(
						'taxonomy' => 'category',
						'field' => 'slug',
						'terms' => $_GET['termlist'],
					),
					array(
						'taxonomy' => 'topic',
						'field' => 'slug',
						'terms' => $_GET['topiclist']					)
        );

        $query->set('tax_query', $tax_query_args);

    }

    return $query;
	}
}
add_action('pre_get_posts', 'advanced_search_query', 1001);

// add custom classes to default avatars
add_filter('get_avatar','change_avatar_css');
function change_avatar_css($class) {
$class = str_replace("class='avatar", "class='avatar-140 photo", $class) ;
return $class;
}
