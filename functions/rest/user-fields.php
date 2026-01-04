<?php
/**
 * User REST API Field Registration
 *
 * @package ResourceCentre
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register custom fields for User in REST API
 */
function rc_register_user_rest_fields() {
	$fields = array(
		'user_job_title',
		'user_google',
		'user_twitter',
		'user_facebook',
		'user_photo',
		'user_location',
	);

	foreach ( $fields as $field ) {
		register_rest_field(
			'user',
			$field,
			array(
				'get_callback'    => 'rc_get_user_meta',
				'update_callback' => null,
				'schema'          => null,
			)
		);
	}
}
add_action( 'rest_api_init', 'rc_register_user_rest_fields' );

/**
 * Callback to get user meta data
 *
 * @param array  $object     The user object.
 * @param string $field_name The field name.
 * @param object $request    The request object.
 * @return mixed The meta value.
 */
function rc_get_user_meta( $object, $field_name, $request ) {
	return get_user_meta( $object['id'], $field_name, true );
}
