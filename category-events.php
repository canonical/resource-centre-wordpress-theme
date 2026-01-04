<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Event category Template
 *
 *
 * @file           category.php
 * @package        Ubuntu blog theme
 * @author         Canonical Web Team
 * @copyright      2012 Canonical Ltd
 * @license
 * @version        Release: 1.0
 * @filesource     wp-content/themes/insights-theme/category.php
 * @link           http://codex.wordpress.org/Theme_Development#Archive_.28category.php.29
 * @since          available since Release 1.0
 */
 
 /* Template Name: Events category */

get_header();
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; // Needed for pagination
$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
$category = get_the_category();
$post = $wp_query->get_queried_object();
//$current_cat = basename(get_permalink());
$current_tax = $term->slug;
$post = $wp_query->get_queried_object();
?>
<div class="row row-hero no-border">
	<div class="inner-wrapper">
		<h1 class="cat-title no-border"><?php $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); ?><?php if( $term != '' ) : ?><span class="taxonomy-title"><?php echo $term->name; ?></span><?php endif; ?> <span><?php single_cat_title(); ?></span></h1>
	</div><!-- /.inner-wrapper -->
</div><!-- /.row -->

<ul class="article-list infinitescroll no-bullets">

<?php /* ============== pull in latest articles ============== */
  wp_reset_query();
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; // Needed for pagination
	$query = new WP_Query( array(
	'posts_per_page' => 10,
	'category_name' => 'events',
	'topic' => $current_tax,
    'post_type' => 'event',
    'post__not_in' => $do_not_duplicate,
    'meta_key' => '_start_eventtimestamp',
	'orderby' => 'meta_value',
	'order' => 'DESC',
	));
  wp_reset_query();
?>
 
<?php if ($query->have_posts()) :
	while ( $query->have_posts() ) : $query->the_post();
	$post_type = get_post_type_object( get_post_type($post));
	$do_not_duplicate[] = $post->ID ?>
<?php 
	global $post, $wp_locale;
	$current_time = current_time('timestamp'); 
	list( $today_year, $today_month, $today_day, $hour, $minute, $second ) = preg_split( '/[^0-9]+/', $current_time );
	$end_month = get_post_meta( $post->ID, '_end_month', true );
	$end_day = get_post_meta( $post->ID, '_end_day', true );
	$end_year = get_post_meta( $post->ID, '_end_year', true );
	$eventend = $end_year . $end_month . $end_day;
	$current_timestamp = $today_year . $today_month . $today_day;
?>

	<li class="row article<?php if($eventend >= $current_timestamp) : ?> upcoming<?php endif; ?>
">
		<div class="inner-wrapper">
			<div class="eight-col no-margin-bottom">
				<?php get_template_part("includes/_event_meta"); ?>
      </div><!-- /.eight-col -->
		</div><!-- /.inner-wrapper -->
	</li><!-- /.row -->
<?php endwhile; // while have_posts ends ?>
<?php endif; // if have_posts ends ; 
/* ============== end pull in latest articles ============== */
wp_reset_query();
?>
</ul>
	<?php //get_template_part("includes/_pagination"); ?>
</div><!-- /.article-list -->

<?php get_footer(); ?>
