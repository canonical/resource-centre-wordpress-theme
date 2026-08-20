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
		// Groups are a curated vocabulary: only Administrators create,
		// rename or delete them. Hierarchical taxonomies derive the block
		// editor's "Add new group" affordance from `edit_terms`, so this
		// also removes that link for editors. Assigning stays open.
		'capabilities'      => array(
			'manage_terms' => 'manage_categories',
			'edit_terms'   => 'manage_options',
			'delete_terms' => 'manage_options',
			'assign_terms' => 'edit_posts',
		),
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

/**
 * The approved group slugs from the stakeholder taxonomy sheet.
 *
 * While this list is EMPTY the editor panel shows every group (filter
 * inactive). Once filled in, logged-in users only see these groups in the
 * editor's Groups panel; unauthenticated REST reads — which is how the
 * consumer sites fetch groups — are untouched, so existing /group/<slug>
 * pages keep working while legacy groups await cleanup. Legacy groups
 * already assigned to old posts stay assigned; they are only hidden from
 * the picker.
 */
const RC_APPROVED_GROUP_SLUGS = array();

/**
 * Restrict the editor's group picker to the approved list.
 */
function rc_limit_group_choices( $prepared_args, $request ) {
	$slugs = apply_filters( 'rc_approved_group_slugs', RC_APPROVED_GROUP_SLUGS );

	if ( empty( $slugs ) || ! is_user_logged_in() ) {
		return $prepared_args;
	}

	$ids = array();
	foreach ( $slugs as $slug ) {
		$term = get_term_by( 'slug', $slug, 'group' );
		if ( $term ) {
			$ids[] = (int) $term->term_id;
		}
	}

	if ( $ids ) {
		$prepared_args['include'] = empty( $prepared_args['include'] )
			? $ids
			: array_values( array_intersect( (array) $prepared_args['include'], $ids ) );
	}

	return $prepared_args;
}
add_filter( 'rest_group_query', 'rc_limit_group_choices', 10, 2 );
