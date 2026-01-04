<?php
/**
 * Topic Taxonomy Registration
 *
 * @package ResourceCentre
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Topic taxonomy
 */
function rc_register_topic_taxonomy() {
	$post_types = array(
		'post',
		'event',
		'webinar',
		'productbusinesscard',
		'topiccta',
		'attachment',
	);

	$labels = array(
		'name'              => _x( 'Topic', 'taxonomy general name', 'resource-centre' ),
		'singular_name'     => _x( 'Topic', 'taxonomy singular name', 'resource-centre' ),
		'search_items'      => __( 'Search topics', 'resource-centre' ),
		'all_items'         => __( 'All topics', 'resource-centre' ),
		'parent_item'       => __( 'Parent topic', 'resource-centre' ),
		'parent_item_colon' => __( 'Parent topic:', 'resource-centre' ),
		'edit_item'         => __( 'Edit topic', 'resource-centre' ),
		'update_item'       => __( 'Update topic', 'resource-centre' ),
		'add_new_item'      => __( 'Add new topic', 'resource-centre' ),
		'new_item_name'     => __( 'New topic name', 'resource-centre' ),
		'menu_name'         => __( 'Topics', 'resource-centre' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,
		'query_var'         => true,
		'rewrite'           => array(
			'slug'         => 'topic',
			'with_front'   => false,
			'hierarchical' => true,
		),
	);

	register_taxonomy( 'topic', $post_types, $args );
}
add_action( 'init', 'rc_register_topic_taxonomy', 0 );
