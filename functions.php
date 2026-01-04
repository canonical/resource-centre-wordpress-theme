<?php
/**
 * Resource Centre Theme Functions
 *
 * @package ResourceCentre
 */

// Load the new modular bootstrap
require_once get_stylesheet_directory() . '/functions/bootstrap.php';

// Legacy files kept for backwards compatibility (to be reviewed)
require_once get_stylesheet_directory() . '/functions/rss.php';
require_once get_stylesheet_directory() . '/functions/profile.php';

// Note: The following old files have been consolidated into the new structure:
// - post-types.php -> functions/post-types/*.php
// - custom_taxonomies.php -> functions/taxonomies/*.php
// - event-posts.php -> functions/post-types/event.php + functions/rest/event-fields.php + functions/admin/metaboxes.php
// - categories.php -> functions/admin/menu.php (partial)
// - general.php -> functions/helpers/*.php + functions/admin/menu.php (partial)
// - metaboxes.php -> kept for CMB framework, may be deprecated
