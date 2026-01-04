<?php
/**
 * Theme Bootstrap
 *
 * Loads all theme functionality in a modular, organized way.
 *
 * @package ResourceCentre
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define theme constants
define( 'RC_THEME_DIR', get_stylesheet_directory() );
define( 'RC_THEME_URI', get_stylesheet_directory_uri() );
define( 'RC_FUNCTIONS_DIR', RC_THEME_DIR . '/functions' );

/**
 * Load Post Types
 */
require_once RC_FUNCTIONS_DIR . '/post-types/event.php';
require_once RC_FUNCTIONS_DIR . '/post-types/webinar.php';
require_once RC_FUNCTIONS_DIR . '/post-types/internal.php';

/**
 * Load Taxonomies
 */
require_once RC_FUNCTIONS_DIR . '/taxonomies/topic.php';
require_once RC_FUNCTIONS_DIR . '/taxonomies/group.php';

/**
 * Load REST API Extensions
 */
require_once RC_FUNCTIONS_DIR . '/rest/event-fields.php';
require_once RC_FUNCTIONS_DIR . '/rest/user-fields.php';

/**
 * Load Admin Customizations (only in admin)
 */
if ( is_admin() ) {
	require_once RC_FUNCTIONS_DIR . '/admin/menu.php';
	require_once RC_FUNCTIONS_DIR . '/admin/metaboxes.php';
}

/**
 * Load Helpers
 */
require_once RC_FUNCTIONS_DIR . '/helpers/taxonomy-sync.php';
require_once RC_FUNCTIONS_DIR . '/helpers/validation.php';

/**
 * Theme Setup
 */
function rc_theme_setup() {
	// Add theme support
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );

	// Set content width
	if ( ! isset( $content_width ) ) {
		$content_width = 540;
	}

	// Register nav menus
	register_nav_menus(
		array(
			'primary-products'   => __( 'Primary Products', 'resource-centre' ),
			'primary-categories' => __( 'Primary Categories', 'resource-centre' ),
			'press-centre'       => __( 'Press Centre', 'resource-centre' ),
		)
	);

	// Add excerpt support to pages
	add_post_type_support( 'page', 'excerpt' );
}
add_action( 'after_setup_theme', 'rc_theme_setup' );

/**
 * Register widgets
 */
function rc_register_widgets() {
	register_sidebar(
		array(
			'name'          => __( 'Search Sidebar', 'resource-centre' ),
			'id'            => 'search-sidebar',
			'before_widget' => '<div class="widget">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'rc_register_widgets' );

/**
 * Include multiple post types in category queries
 */
function rc_category_query_post_types( $query ) {
	if ( is_category() && $query->is_main_query() && ! is_admin() ) {
		$query->set(
			'post_type',
			array( 'post', 'event', 'webinar', 'productbusinesscard', 'topiccta' )
		);
	}
	return $query;
}
add_filter( 'pre_get_posts', 'rc_category_query_post_types' );
