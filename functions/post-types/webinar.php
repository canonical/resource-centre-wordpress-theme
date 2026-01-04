<?php
/**
 * Webinar Custom Post Type Registration
 *
 * @package ResourceCentre
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Webinar post type
 */
function rc_register_webinar_post_type() {
	$labels = array(
		'name'               => _x( 'Webinar', 'post type general name', 'resource-centre' ),
		'singular_name'      => _x( 'Webinar', 'post type singular name', 'resource-centre' ),
		'add_new'            => _x( 'Add New', 'webinar', 'resource-centre' ),
		'add_new_item'       => __( 'Add New Webinar', 'resource-centre' ),
		'edit_item'          => __( 'Edit Webinar', 'resource-centre' ),
		'new_item'           => __( 'Add New Webinar', 'resource-centre' ),
		'view_item'          => __( 'View Webinar', 'resource-centre' ),
		'search_items'       => __( 'Search Webinars', 'resource-centre' ),
		'not_found'          => __( 'No webinars found', 'resource-centre' ),
		'not_found_in_trash' => __( 'No webinars found in trash', 'resource-centre' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_nav_menus'  => true,
		'show_in_rest'       => false, // Confirmed: admin-only
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'webinar' ),
		'capability_type'    => 'post',
		'hierarchical'       => true,
		'has_archive'        => true,
		'menu_position'      => 6,
		'menu_icon'          => get_stylesheet_directory_uri() . '/static/img/admin/film.png',
		'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail', 'author', 'comments', 'revisions' ),
		'taxonomies'         => array( 'category', 'post_tag' ),
	);

	register_post_type( 'webinar', $args );
}
add_action( 'init', 'rc_register_webinar_post_type' );
