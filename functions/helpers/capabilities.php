<?php
/**
 * Taxonomy Lockdown
 *
 * Since the site split a category means exactly one thing — which blog a post
 * appears on — and the consuming apps filter on an allowlist of the five site
 * category IDs, so a new category is a post that appears nowhere. The ~2,100
 * tags grew out of the editor's press-Enter-to-create field. Both
 * vocabularies are therefore closed: only Administrators create, rename or
 * delete terms, from the normal Categories / Tags screens.
 *
 * Nothing else changes: `assign_terms` stays `edit_posts` so editors keep
 * applying existing terms, and `manage_terms` stays `manage_categories` so
 * the term screens remain visible to them. The block editor enforces this
 * without any JavaScript of ours — category creation checks `edit_terms`
 * up front, and tag creation fails server-side with an error notice.
 *
 * @package ResourceCentre
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function rc_lock_taxonomy_terms( $args, $taxonomy ) {
	if ( in_array( $taxonomy, array( 'category', 'post_tag' ), true ) ) {
		$args['capabilities'] = array(
			'manage_terms' => 'manage_categories', // Screens stay visible to editors.
			'edit_terms'   => 'manage_options',    // Create/rename: Administrators only.
			'delete_terms' => 'manage_options',
			'assign_terms' => 'edit_posts',        // Applying existing terms, unchanged.
		);
	}
	return $args;
}
add_filter( 'register_taxonomy_args', 'rc_lock_taxonomy_terms', 10, 2 );

/**
 * Backstop for flat taxonomies: core's REST controller lets anyone with
 * `assign_terms` CREATE a term in a non-hierarchical taxonomy (tags), so the
 * capability mapping above cannot block Enter-to-create in the editor without
 * also breaking tag assignment. `pre_insert_term` fires inside
 * wp_insert_term() itself, covering REST, classic admin and ajax alike.
 * No-user contexts (WP-CLI, imports, migration scripts) are exempt.
 */
function rc_block_term_creation( $term, $taxonomy ) {
	if (
		in_array( $taxonomy, array( 'category', 'post_tag' ), true )
		&& get_current_user_id()
		&& ! current_user_can( 'manage_options' )
	) {
		return new WP_Error(
			'rc_term_creation_locked',
			__( 'New categories and tags can only be added by an administrator, from the Categories / Tags screens.', 'resource-centre' ),
			array( 'status' => 403 )
		);
	}

	return $term;
}
add_filter( 'pre_insert_term', 'rc_block_term_creation', 10, 2 );
