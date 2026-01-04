<?php
/**
 * The sidebar containing the secondary widget area
 *
 * Displays on posts and pages.
 *
 * If no active widgets are in this sidebar, hide it completely.
 *
 * @package WordPress
 * @since available since Release 1.0
 */

if ( is_active_sidebar( 'search-sidebar' ) ) : ?>
	<div id="tertiary" class="sidebar-container" role="complementary">
		<div class="sidebar-inner">
			<div class="widget-area">
				<?php dynamic_sidebar( 'search-sidebar' ); ?>
			</div><!-- .widget-area -->
		</div><!-- .sidebar-inner -->
	</div><!-- #tertiary -->
<?php endif; ?>