<?php
	wp_reset_query();
	global $post, $wp_locale;
	$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
	$current_cat = basename(get_permalink());
	$current_catt = get_query_var('category_name');
	$category = get_category_by_slug($current_tax);
?>

<?php if (is_home()) : ?>
	<a href="<?php bloginfo('url'); ?>/feed/">RSS feed</a>

<?php elseif (is_search()) : $key = wp_specialchars($s, 1); ?>
	<a href="<?php bloginfo('url'); ?>/feed<?php echo $_SERVER['REQUEST_URI']; ?>">RSS feed</a>

<?php elseif ( is_page_template('page-category.php') ) : ?>
	<a href="<?php bloginfo('url'); ?>/category/<?php echo $current_cat; ?>/feed/">RSS feed</a>

<?php elseif ( is_page_template('page-topics.php') ) : ?>
	<a href="<?php bloginfo('url'); ?>/topic/<?php echo $current_cat; ?>/feed/">RSS feed</a>

<?php elseif ( is_page_template('page-group.php') ) : ?>
	<a href="<?php bloginfo('url'); ?>/group/<?php echo $current_cat; ?>/feed/">RSS feed</a>

<?php elseif ( is_page_template('page-events.php') ) : ?>
	<a href="<?php bloginfo('url'); ?>/category/events/feed/">RSS feed</a>

<?php elseif ( is_page_template('page-press.php') ) : ?>
	<a href="<?php bloginfo('url'); ?>/category/news/feed/">RSS feed</a>

<?php elseif ( is_single()) : ?>
	<a href="<?php bloginfo('url'); ?>/feed/">RSS feed</a>

<?php else : ?>
	<a href="<?php bloginfo('url'); ?>/topic/<?php echo $term->slug; ?>/feed/">RSS feed</a>
<?php endif; // end is_category ?>