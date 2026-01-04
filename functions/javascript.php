<?php
/*
	Contents:
		add jquery
		add google plus and marketo for single only (atm)
		add facebook social gubbin's
		add ie conditional html5 shim to header
		add infinite Scroll and masonry
		add author javascript
		add google analytics
		add marketo to footer
*/

// add jquery
function jquery_init() {
	if (!is_admin()) :
		wp_deregister_script('jquery');
		wp_register_script('jquery', get_template_directory_uri() . '/static/js/jquery.min.js', false, '1.9.1', true);
		
		wp_enqueue_script('jquery');

		// load infinite scroll jquery
		wp_deregister_script('infinite_scroll');
		wp_register_script( 'infinite_scroll',  get_template_directory_uri() . '/static/js/jquery.infinitescroll.min.js', array('jquery'),null,true );

		// load manual-trigger.js jquery
		wp_deregister_script('infinite_scroll_trigger');
		wp_register_script( 'infinite_scroll_trigger',  get_template_directory_uri() . '/static/js/manual-trigger.js', array('jquery'),null,true );
		
		wp_enqueue_script('infinite_scroll');
		wp_enqueue_script('infinite_scroll_trigger');
	endif;
}
add_action('wp_footer', 'jquery_init');
// end add jquery

?>
