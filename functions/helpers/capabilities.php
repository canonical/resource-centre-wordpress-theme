<?php
/**
 * Taxonomy Lockdown
 *
 * Three vocabularies, three policies:
 *
 * - Categories mean exactly one thing since the site split — which blog a
 *   post appears on. The consuming apps filter on an allowlist of the five
 *   site category IDs, so a new category is a post that appears nowhere.
 *   The set is closed: Administrators only.
 * - Groups are a curated list from the stakeholder taxonomy sheet:
 *   Administrators only. (Capabilities set in taxonomies/group.php.)
 * - Tags are the open topic vocabulary, but creation must be a deliberate
 *   act on the Posts > Tags screen — never a side effect of typing in the
 *   post editor, which is how the vocabulary sprawled to ~2,100 terms.
 *
 * @package ResourceCentre
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Categories: create, rename and delete are Administrator-only.
 *
 * Remapped at registration rather than through map_meta_cap so every
 * consumer (admin screens, REST, the block editor's create affordance)
 * reads the same answer. `assign_terms` stays `edit_posts`, so filing
 * posts under the site categories is unchanged. Tags are deliberately
 * NOT remapped: editors keep full tag management on the Tags screen,
 * and rc_require_tags_screen_for_tag_creation() below handles the rest.
 */
function rc_lock_taxonomy_terms( $args, $taxonomy ) {
	if ( 'category' === $taxonomy ) {
		$args['capabilities'] = array(
			'manage_terms' => 'manage_categories', // Screen stays visible to editors.
			'edit_terms'   => 'manage_options',    // Create/rename: Administrators only.
			'delete_terms' => 'manage_options',
			'assign_terms' => 'edit_posts',        // Applying existing terms, unchanged.
		);
	}

	return $args;
}
add_filter( 'register_taxonomy_args', 'rc_lock_taxonomy_terms', 10, 2 );

/**
 * Backstop for categories and groups: pre_insert_term fires inside
 * wp_insert_term() itself, covering REST, classic admin and ajax alike.
 * No-user contexts (WP-CLI, imports, migration scripts) are exempt.
 */
function rc_block_term_creation( $term, $taxonomy ) {
	if (
		in_array( $taxonomy, array( 'category', 'group' ), true )
		&& get_current_user_id()
		&& ! current_user_can( 'manage_options' )
	) {
		return new WP_Error(
			'rc_term_creation_locked',
			__( 'New categories and groups can only be added by an administrator.', 'resource-centre' ),
			array( 'status' => 403 )
		);
	}

	return $term;
}
add_filter( 'pre_insert_term', 'rc_block_term_creation', 10, 2 );

/**
 * Tags: creation is allowed on the Posts > Tags screen only.
 *
 * Capabilities cannot express a per-screen rule, but the insert path can be
 * identified here: the Tags screen's add form submits the `add-tag` admin
 * action, while the post editor creates tags over REST (Gutenberg) or as a
 * side effect of saving tax_input (classic, quick edit, bulk edit) — none
 * of which carry that action. Editors keep core's default tag capabilities,
 * so the Tags screen itself needs no special-casing; Administrators and
 * no-user contexts (WP-CLI, migrations) are exempt entirely.
 */
function rc_require_tags_screen_for_tag_creation( $term, $taxonomy ) {
	if ( 'post_tag' !== $taxonomy ) {
		return $term;
	}

	if ( ! get_current_user_id() || current_user_can( 'manage_options' ) ) {
		return $term;
	}

	// Nonce checking happens in the add-tag handler itself, before
	// wp_insert_term() runs; this only identifies the submission path.
	if ( isset( $_POST['action'] ) && 'add-tag' === $_POST['action'] ) {
		return $term;
	}

	return new WP_Error(
		'rc_tag_creation_locked',
		__( 'New tags are added from the Posts → Tags screen, not while editing a post.', 'resource-centre' ),
		array( 'status' => 403 )
	);
}
add_filter( 'pre_insert_term', 'rc_require_tags_screen_for_tag_creation', 10, 2 );
