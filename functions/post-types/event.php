<?php
/**
 * Event Custom Post Type Registration
 *
 * @package ResourceCentre
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Event post type
 */
function rc_register_event_post_type() {
	$labels = array(
		'name'               => _x( 'Events', 'post type general name', 'resource-centre' ),
		'singular_name'      => _x( 'Event', 'post type singular name', 'resource-centre' ),
		'add_new'            => _x( 'Add New Event', 'event', 'resource-centre' ),
		'add_new_item'       => __( 'Add New Event', 'resource-centre' ),
		'edit_item'          => __( 'Edit Event', 'resource-centre' ),
		'new_item'           => __( 'Add New Event', 'resource-centre' ),
		'view_item'          => __( 'View Event', 'resource-centre' ),
		'search_items'       => __( 'Search Events', 'resource-centre' ),
		'not_found'          => __( 'No events found', 'resource-centre' ),
		'not_found_in_trash' => __( 'No events found in trash', 'resource-centre' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_nav_menus'  => true,
		'show_in_rest'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'event' ),
		'capability_type'    => 'post',
		'hierarchical'       => true,
		'has_archive'        => true,
		'menu_position'      => 5,
		'menu_icon'          => get_stylesheet_directory_uri() . '/static/img/admin/calendar-day.png',
		'supports'           => array( 'title', 'editor', 'thumbnail', 'comments', 'revisions', 'author' ),
		'taxonomies'         => array( 'category', 'post_tag' ),
	);

	register_post_type( 'event', $args );
}
add_action( 'init', 'rc_register_event_post_type' );

/**
 * Customize Event archive query
 */
function rc_event_archive_query( $query ) {
	if ( $query->is_main_query() && ! $query->is_feed() && ! is_admin() && $query->is_post_type_archive( 'event' ) ) {
		$meta_query = array(
			array(
				'key'     => '_end_eventtimestamp',
				'value'   => date( 'YmdHi' ),
				'compare' => '>',
			),
		);
		$query->set( 'meta_query', $meta_query );
		$query->set( 'orderby', 'meta_value_num' );
		$query->set( 'meta_key', '_start_eventtimestamp' );
		$query->set( 'order', 'ASC' );
		$query->set( 'posts_per_page', 6 );
	}
}
add_action( 'pre_get_posts', 'rc_event_archive_query' );
