<?php
/**
 * Taxonomy Sync Helpers
 *
 * Auto-assigns group taxonomy based on selected topic.
 *
 * @package ResourceCentre
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Auto-assign group taxonomy based on topic selection
 *
 * When a post is saved with certain topics, automatically assign the corresponding group.
 */
function rc_auto_assign_group_from_topic( $post_id ) {
	// Don't run on autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check permissions
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	// Get post topics
	$topics = wp_get_post_terms( $post_id, 'topic', array( 'fields' => 'slugs' ) );

	if ( is_wp_error( $topics ) || empty( $topics ) ) {
		return;
	}

	// Define topic to group mappings
	$topic_to_group = array(
		'cloud'              => 'cloud-and-server',
		'server'             => 'cloud-and-server',
		'openstack'          => 'cloud-and-server',
		'juju'               => 'cloud-and-server',
		'maas'               => 'cloud-and-server',
		'ubuntu-core'        => 'internet-of-things',
		'iot'                => 'internet-of-things',
		'internet-of-things' => 'internet-of-things',
		'desktop'            => 'desktop',
		'phone'              => 'phone-and-tablet',
		'tablet'             => 'phone-and-tablet',
	);

	$groups_to_assign = array();

	foreach ( $topics as $topic_slug ) {
		if ( isset( $topic_to_group[ $topic_slug ] ) ) {
			$groups_to_assign[] = $topic_to_group[ $topic_slug ];
		}
	}

	if ( ! empty( $groups_to_assign ) ) {
		$groups_to_assign = array_unique( $groups_to_assign );
		wp_set_post_terms( $post_id, $groups_to_assign, 'group', true );
	}
}
add_action( 'save_post', 'rc_auto_assign_group_from_topic', 20 );
