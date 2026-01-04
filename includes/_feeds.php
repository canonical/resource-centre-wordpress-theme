<?php
	wp_reset_query();
	global $post, $wp_locale;
	$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
	$current_cat = basename(get_permalink());
	$current_catt = get_query_var('category_name');
?>

<?php if (is_home()) : ?>
	<link rel="alternate" type="application/rss+xml" title="Ubuntu Insights feed" href="<?php bloginfo('url'); ?>/feed/" />

<?php elseif (is_search()) : $key = wp_specialchars($s, 1); ?>
	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('url'); ?>/feed<?php echo $_SERVER['REQUEST_URI']; ?>" />

<?php elseif ( is_page_template('page-category.php') ) : ?>
	<link rel="alternate" type="application/rss+xml" title="Ubuntu Insights '<?php echo $current_cat; ?>' feed" href="<?php bloginfo('url'); ?>/category/<?php echo $current_cat; ?>/feed/" />

<?php elseif ( is_page_template('page-topics.php') ) : ?>
	<link rel="alternate" type="application/rss+xml" title="Ubuntu Insights topic feed" href="<?php bloginfo('url'); ?>/topic/<?php echo $current_cat; ?>/feed/" />

<?php elseif ( is_page_template('page-group.php') ) : ?>
	<link rel="alternate" type="application/rss+xml" title="Ubuntu Insights group feed" href="<?php bloginfo('url'); ?>/group/<?php echo $current_cat; ?>/feed/" />

<?php elseif ( is_page_template('page-events.php') ) : ?>
	<link rel="alternate" type="application/rss+xml" title="Ubuntu Insights 'events' feed" href="<?php bloginfo('url'); ?>/category/events/feed/" />

<?php elseif ( is_page_template('page-press.php') ) : ?>
	<link rel="alternate" type="application/rss+xml" title="Ubuntu Insights 'events' feed" href="<?php bloginfo('url'); ?>/category/news/feed/" />

<?php elseif ( is_single()) : ?>
	<link rel="alternate" type="application/rss+xml" title="Ubuntu Insights feed" href="<?php bloginfo('url'); ?>/feed/" />

<?php else : ?>
	<link rel="alternate" type="application/rss+xml" title="Ubuntu Insights <?php echo $term->slug; ?> <?php echo $current_catt; ?> feed" href="<?php bloginfo('url'); ?>/topic/<?php echo $term->slug; ?>/feed/" />
<?php endif; // end is_category ?>