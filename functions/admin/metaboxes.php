<?php
/**
 * Event Metaboxes
 *
 * @package ResourceCentre
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register event metaboxes
 */
function rc_register_event_metaboxes() {
	$post_types = array( 'event', 'post' );

	foreach ( $post_types as $post_type ) {
		add_meta_box(
			'rc_event_date_start',
			'Start Date',
			'rc_render_event_date_metabox',
			$post_type,
			'side',
			'default',
			array( 'id' => '_start' )
		);

		add_meta_box(
			'rc_event_date_end',
			'End Date',
			'rc_render_event_date_metabox',
			$post_type,
			'side',
			'default',
			array( 'id' => '_end' )
		);

		add_meta_box(
			'rc_event_location',
			'Event Location',
			'rc_render_event_location_metabox',
			$post_type,
			'normal',
			'default'
		);

		add_meta_box(
			'rc_event_venue',
			'Event Venue',
			'rc_render_event_venue_metabox',
			$post_type,
			'normal',
			'default'
		);

		add_meta_box(
			'rc_event_registration',
			'Event Registration',
			'rc_render_event_registration_metabox',
			$post_type,
			'normal',
			'default'
		);
	}
}
add_action( 'admin_init', 'rc_register_event_metaboxes' );

/**
 * Render event date metabox
 */
function rc_render_event_date_metabox( $post, $args ) {
	$metabox_id = $args['args']['id'];
	global $wp_locale;

	wp_nonce_field( 'rc_event_metabox', 'rc_event_metabox_nonce' );

	$time_adj = current_time( 'timestamp' );

	$month = get_post_meta( $post->ID, $metabox_id . '_month', true );
	if ( empty( $month ) ) {
		$month = gmdate( 'm', $time_adj );
	}

	$day = get_post_meta( $post->ID, $metabox_id . '_day', true );
	if ( empty( $day ) ) {
		$day = gmdate( 'j', $time_adj );
	}

	$year = get_post_meta( $post->ID, $metabox_id . '_year', true );
	if ( empty( $year ) ) {
		$year = gmdate( 'Y', $time_adj );
	}

	// Month dropdown
	echo '<select name="' . esc_attr( $metabox_id ) . '_month">';
	for ( $i = 1; $i < 13; $i++ ) {
		$selected = ( $i == $month ) ? ' selected="selected"' : '';
		echo '<option value="' . esc_attr( zeroise( $i, 2 ) ) . '"' . $selected . '>';
		echo esc_html( $wp_locale->get_month_abbrev( $wp_locale->get_month( $i ) ) );
		echo '</option>';
	}
	echo '</select> ';

	// Day input
	echo '<input type="text" name="' . esc_attr( $metabox_id ) . '_day" value="' . esc_attr( $day ) . '" size="2" maxlength="2" /> ';

	// Year input
	echo '<input type="text" name="' . esc_attr( $metabox_id ) . '_year" value="' . esc_attr( $year ) . '" size="4" maxlength="4" />';
}

/**
 * Render event location metabox
 */
function rc_render_event_location_metabox( $post ) {
	$event_location = get_post_meta( $post->ID, '_event_location', true );
	echo '<label for="_event_location">Location: </label>';
	echo '<input type="text" name="_event_location" value="' . esc_attr( $event_location ) . '" class="widefat" />';
}

/**
 * Render event venue metabox
 */
function rc_render_event_venue_metabox( $post ) {
	$event_venue = get_post_meta( $post->ID, '_event_venue', true );
	echo '<label for="_event_venue">Venue: </label>';
	echo '<input type="text" name="_event_venue" value="' . esc_attr( $event_venue ) . '" class="widefat" />';
}

/**
 * Render event registration metabox
 */
function rc_render_event_registration_metabox( $post ) {
	$event_registration = get_post_meta( $post->ID, '_event_registration', true );
	echo '<label for="_event_registration">Registration URL: </label>';
	echo '<input type="url" name="_event_registration" value="' . esc_attr( $event_registration ) . '" class="widefat" />';
}

/**
 * Save event metabox data
 */
function rc_save_event_metabox( $post_id, $post ) {
	// Verify nonce
	if ( ! isset( $_POST['rc_event_metabox_nonce'] ) ||
		 ! wp_verify_nonce( $_POST['rc_event_metabox_nonce'], 'rc_event_metabox' ) ) {
		return;
	}

	// Check autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check permissions
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	// Don't save for revisions
	if ( 'revision' === $post->post_type ) {
		return;
	}

	// Save date fields
	$metabox_ids = array( '_start', '_end' );

	foreach ( $metabox_ids as $key ) {
		$year   = isset( $_POST[ $key . '_year' ] ) ? absint( $_POST[ $key . '_year' ] ) : date( 'Y' );
		$month  = isset( $_POST[ $key . '_month' ] ) ? sanitize_text_field( $_POST[ $key . '_month' ] ) : date( 'm' );
		$day    = isset( $_POST[ $key . '_day' ] ) ? absint( $_POST[ $key . '_day' ] ) : date( 'd' );

		$year  = ( $year <= 0 ) ? date( 'Y' ) : $year;
		$month = ( $month <= 0 ) ? date( 'm' ) : $month;
		$day   = ( $day > 31 ) ? 31 : $day;
		$day   = ( $day <= 0 ) ? date( 'd' ) : $day;
		$day   = sprintf( '%02d', $day );

		update_post_meta( $post_id, $key . '_year', $year );
		update_post_meta( $post_id, $key . '_month', $month );
		update_post_meta( $post_id, $key . '_day', $day );
		update_post_meta( $post_id, $key . '_eventtimestamp', $year . $month . $day . '0000' );
	}

	// Save location, venue, registration
	if ( isset( $_POST['_event_location'] ) ) {
		update_post_meta( $post_id, '_event_location', sanitize_text_field( $_POST['_event_location'] ) );
	}

	if ( isset( $_POST['_event_venue'] ) ) {
		update_post_meta( $post_id, '_event_venue', sanitize_text_field( $_POST['_event_venue'] ) );
	}

	if ( isset( $_POST['_event_registration'] ) ) {
		update_post_meta( $post_id, '_event_registration', esc_url_raw( $_POST['_event_registration'] ) );
	}
}
add_action( 'save_post', 'rc_save_event_metabox', 10, 2 );
