<?php
/**
 * Validation Helpers
 *
 * @package ResourceCentre
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Require featured image before publishing
 */
function rc_require_featured_image_script() {
	global $post_type;

	$require_featured_types = array( 'post', 'event', 'webinar' );

	if ( ! in_array( $post_type, $require_featured_types, true ) ) {
		return;
	}
	?>
	<script type="text/javascript">
	(function($) {
		$(document).ready(function() {
			var $publishButton = $('#publish');

			$publishButton.on('click', function(e) {
				var hasFeaturedImage = $('#postimagediv').find('img').length > 0;

				if (!hasFeaturedImage && $('#post_status').val() === 'publish') {
					alert('Please set a featured image before publishing.');
					e.preventDefault();
					return false;
				}
			});
		});
	})(jQuery);
	</script>
	<?php
}
add_action( 'admin_print_scripts-post.php', 'rc_require_featured_image_script' );
add_action( 'admin_print_scripts-post-new.php', 'rc_require_featured_image_script' );

/**
 * Exclude certain post types from search results
 */
function rc_exclude_from_search( $query ) {
	if ( ! is_admin() && $query->is_main_query() && $query->is_search() ) {
		$excluded_types = array( 'productbusinesscard', 'topiccta' );
		$query->set( 'post_type', array_diff( get_post_types( array( 'public' => true ) ), $excluded_types ) );
	}
}
add_action( 'pre_get_posts', 'rc_exclude_from_search' );

/**
 * Force display name format to "First Last"
 */
function rc_set_display_name( $user_id ) {
	$user = get_userdata( $user_id );

	if ( ! $user ) {
		return;
	}

	$first_name = $user->first_name;
	$last_name  = $user->last_name;

	if ( $first_name && $last_name ) {
		$display_name = $first_name . ' ' . $last_name;

		if ( $user->display_name !== $display_name ) {
			wp_update_user(
				array(
					'ID'           => $user_id,
					'display_name' => $display_name,
				)
			);
		}
	}
}
add_action( 'personal_options_update', 'rc_set_display_name' );
add_action( 'edit_user_profile_update', 'rc_set_display_name' );
