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
 * Require a site category before an article can go live.
 *
 * Every consumer blog filters posts on an allowlist of the five site
 * categories, so a post carrying none of them is published into invisibility.
 * Guarded only at the transition into `publish` or `future` (`future` because
 * cron later publishes via wp_publish_post(), which bypasses these filters) —
 * never on edits to posts already live, which would demote existing
 * uncategorised posts to draft the moment anyone touched them.
 */

/** Term IDs of the five site categories, resolved by slug and cached per request. */
function rc_site_category_ids() {
	static $ids = null;

	if ( null === $ids ) {
		$slugs = array( 'ubuntu-tech-blog', 'canonical-blog', 'cn-blog', 'jp-blog', 'announcements' );
		$ids   = array();
		foreach ( $slugs as $slug ) {
			$term = get_term_by( 'slug', $slug, 'category' );
			if ( $term ) {
				$ids[] = (int) $term->term_id;
			}
		}
	}

	return $ids;
}

/**
 * Would this save take the post live without a site category?
 *
 * @param int        $post_id  Post being saved, 0 for a new post.
 * @param string     $status   Status the post is being saved into.
 * @param array|null $incoming Categories submitted with the request, null if untouched.
 * @return bool True when the save must be refused.
 */
function rc_missing_site_category( $post_id, $status, $incoming ) {
	$goes_live = array( 'publish', 'future' );

	if ( ! in_array( $status, $goes_live, true ) ) {
		return false;
	}

	// Already live or scheduled: edits are not re-checked.
	if ( $post_id && in_array( get_post_status( $post_id ), $goes_live, true ) ) {
		return false;
	}

	$categories = is_array( $incoming )
		? array_map( 'intval', $incoming )
		: ( $post_id ? wp_get_post_categories( $post_id ) : array() );

	return ! array_intersect( $categories, rc_site_category_ids() );
}

function rc_missing_site_category_message() {
	return __(
		'This article needs a site category (Ubuntu tech blog, Canonical blog, Cn blog, Jp blog or Announcements) before it can be published — without one it will not appear on any blog.',
		'resource-centre'
	);
}

/** Block editor and REST clients: refuse the write with a proper error. */
function rc_rest_require_site_category( $prepared_post, $request ) {
	$post_id = isset( $prepared_post->ID ) ? (int) $prepared_post->ID : 0;
	$status  = isset( $prepared_post->post_status )
		? $prepared_post->post_status
		: ( $post_id ? get_post_status( $post_id ) : 'draft' );
	$incoming = isset( $request['categories'] ) ? (array) $request['categories'] : null;

	if ( rc_missing_site_category( $post_id, $status, $incoming ) ) {
		return new WP_Error(
			'rc_missing_site_category',
			rc_missing_site_category_message(),
			array( 'status' => 400 )
		);
	}

	return $prepared_post;
}
add_filter( 'rest_pre_insert_post', 'rc_rest_require_site_category', 10, 2 );

/** Classic editor, quick-edit and bulk-edit: hold the post back as a draft. */
function rc_require_site_category_on_publish( $data, $postarr ) {
	if ( ( defined( 'REST_REQUEST' ) && REST_REQUEST ) || 'post' !== $data['post_type'] ) {
		return $data;
	}

	$post_id  = isset( $postarr['ID'] ) ? (int) $postarr['ID'] : 0;
	$incoming = isset( $postarr['post_category'] ) ? (array) $postarr['post_category'] : null;

	if ( rc_missing_site_category( $post_id, $data['post_status'], $incoming ) ) {
		$data['post_status'] = 'draft';
		set_transient( 'rc_no_site_cat_' . get_current_user_id(), rc_missing_site_category_message(), 60 );
	}

	return $data;
}
add_filter( 'wp_insert_post_data', 'rc_require_site_category_on_publish', 10, 2 );

/** Surface the reason a publish was held back. */
function rc_missing_site_category_notice() {
	$key     = 'rc_no_site_cat_' . get_current_user_id();
	$message = get_transient( $key );

	if ( $message ) {
		delete_transient( $key );
		printf( '<div class="notice notice-error"><p>%s</p></div>', esc_html( $message ) );
	}
}
add_action( 'admin_notices', 'rc_missing_site_category_notice' );

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
