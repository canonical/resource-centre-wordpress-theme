<?php
/**
 * Group Taxonomy Registration
 *
 * @package ResourceCentre
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Group taxonomy
 */
function rc_register_group_taxonomy() {
	$post_types = array(
		'post',
		'event',
		'webinar',
		'productbusinesscard',
		'topiccta',
		'attachment',
	);

	$labels = array(
		'name'              => _x( 'Group', 'taxonomy general name', 'resource-centre' ),
		'singular_name'     => _x( 'Group', 'taxonomy singular name', 'resource-centre' ),
		'search_items'      => __( 'Search groups', 'resource-centre' ),
		'all_items'         => __( 'All groups', 'resource-centre' ),
		'parent_item'       => __( 'Parent group', 'resource-centre' ),
		'parent_item_colon' => __( 'Parent group:', 'resource-centre' ),
		'edit_item'         => __( 'Edit group', 'resource-centre' ),
		'update_item'       => __( 'Update group', 'resource-centre' ),
		'add_new_item'      => __( 'Add new group', 'resource-centre' ),
		'new_item_name'     => __( 'New group name', 'resource-centre' ),
		'menu_name'         => __( 'Groups', 'resource-centre' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,
		'query_var'         => true,
		'rewrite'           => array(
			'slug'         => 'group',
			'with_front'   => false,
			'hierarchical' => true,
		),
	);

	register_taxonomy( 'group', $post_types, $args );
}
add_action( 'init', 'rc_register_group_taxonomy', 0 );
