<?php
/**
 * Event REST API Field Registration
 *
 * @package ResourceCentre
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register custom fields for Event post type in REST API
 */
function rc_register_event_rest_fields() {
	$fields = array(
		'_event_location',
		'_event_venue',
		'_event_registration',
		'_start_day',
		'_start_month',
		'_start_year',
		'_end_day',
		'_end_month',
		'_end_year',
	);

	foreach ( $fields as $field ) {
		// Register for event post type
		register_rest_field(
			'event',
			$field,
			array(
				'get_callback'    => 'rc_get_event_meta',
				'update_callback' => null,
				'schema'          => null,
			)
		);

		// Also register for regular posts (for backwards compatibility)
		register_rest_field(
			'post',
			$field,
			array(
				'get_callback'    => 'rc_get_event_meta',
				'update_callback' => null,
				'schema'          => null,
			)
		);
	}
}
add_action( 'rest_api_init', 'rc_register_event_rest_fields' );

/**
 * Callback to get event meta data
 *
 * @param array  $object     The post object.
 * @param string $field_name The field name.
 * @param object $request    The request object.
 * @return mixed The meta value.
 */
function rc_get_event_meta( $object, $field_name, $request ) {
	return get_post_meta( $object['id'], $field_name, true );
}
