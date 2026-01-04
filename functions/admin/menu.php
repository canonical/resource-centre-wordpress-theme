<?php
/**
 * Admin Menu Customizations
 *
 * @package ResourceCentre
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Change Posts menu label to Articles
 */
function rc_change_post_menu_label() {
	global $menu;
	global $submenu;

	$menu[5][0]                 = 'Articles';
	$submenu['edit.php'][5][0]  = 'All articles';
	$submenu['edit.php'][10][0] = 'Add an article';
}
add_action( 'admin_menu', 'rc_change_post_menu_label' );

/**
 * Change post object labels
 */
function rc_change_post_object_label() {
	global $wp_post_types;

	$labels                     = &$wp_post_types['post']->labels;
	$labels->name               = 'Articles';
	$labels->singular_name      = 'Article';
	$labels->add_new            = 'Add an article';
	$labels->add_new_item       = 'Add article';
	$labels->edit_item          = 'Edit articles';
	$labels->new_item           = 'Article';
	$labels->view_item          = 'View articles';
	$labels->search_items       = 'Search articles';
	$labels->not_found          = 'No articles found';
	$labels->not_found_in_trash = 'No articles found in trash';
}
add_action( 'init', 'rc_change_post_object_label' );

/**
 * Hide certain menu items for non-whitelisted users
 */
function rc_restrict_admin_menu() {
	$current_user = wp_get_current_user();
	$allowed_users = array(
		'admin',
		'root',
		'gbancroft-canonical',
		'peterm-ubuntu',
		'yaili',
		'anthony.dillon',
		'peterg-canonical',
		'pmac',
	);

	if ( ! in_array( $current_user->user_login, $allowed_users, true ) ) {
		remove_menu_page( 'edit.php?post_type=productbusinesscard' );
		remove_menu_page( 'edit.php?post_type=topiccta' );
	}
}
add_action( 'admin_init', 'rc_restrict_admin_menu' );

/**
 * Hide specific categories from non-admin users in category checklist
 */
function rc_hide_categories_in_admin() {
	if ( ! current_user_can( 'manage_options' ) ) {
		$hidden_categories = array( 245, 180 ); // Press, Product Business Card
		?>
		<style>
			<?php foreach ( $hidden_categories as $cat_id ) : ?>
			#in-category-<?php echo esc_attr( $cat_id ); ?>,
			#in-popular-category-<?php echo esc_attr( $cat_id ); ?> {
				display: none !important;
			}
			<?php endforeach; ?>
		</style>
		<?php
	}
}
add_action( 'admin_head', 'rc_hide_categories_in_admin' );
