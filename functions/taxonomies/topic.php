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
		'hierarchical'       => true,
		'labels'             => $labels,
		'show_ui'            => true,
		'show_admin_column'  => true,
		'show_in_rest'       => true,
		// Topics are phased out of the authoring flow — editors should use
		// Tags (topic browsing) or Groups instead. The taxonomy stays
		// registered and REST-readable for existing content, but every
		// fillable surface is removed from the post editor: the classic
		// metabox and quick edit here, the block-editor panel via the
		// rest_prepare_taxonomy filter below.
		'meta_box_cb'        => false,
		'show_in_quick_edit' => false,
		'query_var'          => true,
		'rewrite'           => array(
			'slug'         => 'topic',
			'with_front'   => false,
			'hierarchical' => true,
		),
	);

	register_taxonomy( 'topic', $post_types, $args );
}
add_action( 'init', 'rc_register_topic_taxonomy', 0 );

/**
 * Hide the Topics panel in the block editor.
 *
 * The block editor builds its taxonomy panels from the REST taxonomy
 * object's `visibility.show_ui`, not from `meta_box_cb`, so it needs its
 * own switch. Reading topic data over REST is unaffected.
 */
function rc_hide_topic_editor_panel( $response, $taxonomy ) {
	if ( 'topic' === $taxonomy->name ) {
		$data = $response->get_data();
		if ( isset( $data['visibility'] ) ) {
			$data['visibility']['show_ui'] = false;
		}
		$response->set_data( $data );
	}

	return $response;
}
add_filter( 'rest_prepare_taxonomy', 'rc_hide_topic_editor_panel', 10, 2 );
