<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Category Template
 *
 *
 * @file           taxonomy-topic.php
 * @package        Ubuntu blog theme
 * @author         Canonical Web Team
 * @copyright      2012 Canonical Ltd
 * @license
 * @version        Release: 1.0
 * @filesource     wp-content/themes/insights-theme/category.php
 * @link           http://codex.wordpress.org/Theme_Development#Archive_.28category.php.29
 * @since          available since Release 1.0
 */

 /* Template Name: Category page */
?>

<?php get_header();
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; // Needed for pagination
	$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
	$post = $wp_query->get_queried_object();
	$current_cat = basename(get_permalink());
?>
<div class="row glossary-box glossary-box-category no-border<?php if( is_single() ) : echo ' box box-highlight'; endif; ?>">
    <div class="inner-wrapper">
        <div class="six-col no-margin-bottom">
            <h1><?php wp_title(''); ?></h1>
        </div>
    </div>
</div>

<div class="row no-border">
<div class="inner-wrapper">
<div class="eight-col no-margin-bottom">

<div class="featured box box-highlight eight-col<?php if(in_category( $press_cats )) echo ' has-time'; ?>">
<?php
/* ============== pull in featured ============== */
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; // Needed for pagination
	$query = new WP_Query( array(
	'posts_per_page' => 1,
	'category_name' => $current_cat,
	'meta_key' => 'dbt_checkbox_featured',
    'post_type' => 'post',
	'paged'=>$paged
	));
?>
<?php if ($query->have_posts()) : ?>
	<h2>Featured</h2>
	<?php
		while( $query->have_posts() ):
		$query->the_post();
		$do_not_duplicate[] = $post->ID ?>
        <?php get_template_part("content_home_featured"); ?>
	<?php endwhile; ?>
<?php else : ?>
<?php
// The Query
	$new_query = new WP_Query( array(
	'posts_per_page' => 1,
	'category_name' => $current_cat,
    'post_type' => 'post',
	'paged'=>$paged
	));
?>
<?php
	while( $new_query->have_posts() ):
	$new_query->the_post();
	$do_not_duplicate[] = $post->ID
?>
	<?php get_template_part("content_home"); ?>

<?php endwhile; wp_reset_postdata(); ?>

<?php endif; // if have_posts ends
/* ============== end pull in featured ============== */
?>
</div><!-- /.featured -->

<?php /* ============== pull in latest articles ============== */
  wp_reset_query();
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; // Needed for pagination
	$query = new WP_Query( array(
	'posts_per_page' => 2,
	'category_name' => $current_cat,
    'post_type' => 'post',
    'post__not_in' => $do_not_duplicate,
	'paged'=>$paged
	));
?>

<?php if ($query->have_posts()) : ?>
<div class="box box-highlight eight-col">
	<h2>Latest <?php echo strtolower(wp_title( '', false, 'right' )); ?></h2>
	<ul class="no-bullets">
	<?php
		while( $query->have_posts() ):
		$query->the_post();
		$do_not_duplicate[] = $post->ID ?>

		<?php if ( is_page('events') ) : ?>
			<?php get_template_part("/includes/_event_meta"); ?>
		<?php else : ?>
			<?php get_template_part("content_home"); ?>
		<?php endif; ?>
	<?php endwhile; ?>
	</ul>
</div><!-- /.eight-col -->
<?php endif; // if have_posts ends

/* ============== end pull in latest articles ============== */ ?>

<?php
/* ============== pull in most viewed articles ============== */
  wp_reset_query();
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; // Needed for pagination
	$query = new WP_Query( array(
	'posts_per_page' => 2,
	'category_name' => $current_cat,
    'post_type' => 'post',
    'post__not_in' => $do_not_duplicate,
    'meta_key' => 'post_views_count',
    'orderby' => 'meta_value_num',
	'paged'=>$paged
	));
?>

<?php if ($query->have_posts()) : ?>
<div class="box box-highlight eight-col">
	<h2>Most viewed <span><?php echo strtolower(wp_title( '', false, 'right' )); ?></span></h2>
	<ul class="no-bullets">
	<?php
		while( $query->have_posts() ):
		$query->the_post();
		$do_not_duplicate[] = $post->ID ?>
        <?php get_template_part("content_home"); ?>
	<?php endwhile; ?>
	</ul>
</div><!-- /.eight-col -->
<?php endif; // if have_posts ends

/* ============== end pull in most viewed articles ============== */
  wp_reset_query();
?>


</div><!-- /.eight-col -->

<aside id="sidebar" class="four-col last-col">
    <div class="box box-highlight four-col">
	<h2><?php wp_title(''); ?> by topic</h2>
		<ul class="no-bullets">
		<?php
			$current_tax = basename(get_permalink());
			$category = get_category_by_slug($current_tax);
			$the_id = $category->term_id;
      $term_args = array(
          'taxonomy' => 'topic',
          'orderby' => 'slug',
          'order' => 'ASC'
      );
	$cats = get_categories($term_args);
	// loop through the categries
		foreach ($cats as $cat) :
			// setup the cateogory ID
      $query_args = array(
    				'post_type' => 'any',
    				'posts_per_page' => '1',
    				'cat' => $the_id,
    				'topic' => $cat->name
    			);
    
      query_posts($query_args); //create our own custom query based on above arguments
    			// start the wordpress loop!
    	      if (have_posts()) : while (have_posts()) : the_post();
    					echo "<li><a href='/category/" . $current_tax . "?topic=".$cat->slug."'>".$cat->name." (" .$wp_query->found_posts . ")</a></li>";
    	      ?>
    				<?php endwhile; endif; // done our wordpress loop. Will start again for each category ?>
    		<?php endforeach; // done the foreach statement ?>
		</ul>
    </div>
<?php /* ============== end links to all topics ============== */
wp_reset_query();
?>
<div class="box box-highlight four-col">
<?php get_template_part("includes/_share_links"); ?>
</div>

</aside>
</div><!-- /.inner-wrapper -->
</div><!-- /.row -->

<?php get_footer(); ?>
