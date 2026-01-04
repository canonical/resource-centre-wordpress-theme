<?php
/**
 * Main Template File
 *
 * This is a headless theme - the frontend is served by a separate application.
 * This file is required by WordPress but not used for public output.
 *
 * @package ResourceCentre
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Redirect to admin if accessed directly on frontend
if ( ! is_admin() && ! wp_doing_ajax() && ! defined( 'REST_REQUEST' ) ) {
	wp_safe_redirect( admin_url() );
	exit;
}
