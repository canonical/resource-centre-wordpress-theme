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
 
 /* Template Name: Categories */
?>

<?php get_header(); 
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; // Needed for pagination
	$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
	$post = $wp_query->get_queried_object();
	$current_cat = 'video';
?>
<div class="no-border">
	<h1 class="cat-title cat-page-title row no-border"><?php wp_title(''); ?></h1>
<div class="eight-col no-margin-bottom">

<?php
/* ============== pull in business card ============== */
  wp_reset_query();
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; // Needed for pagination
	$query = new WP_Query( array(
	'posts_per_page' => 1,
	'category_name' => $current_cat,
  'post_type' => 'productbusinesscard',
  'post__not_in' => $do_not_duplicate,
	'paged'=>$paged
	));
?>

<?php if ($query->have_posts()) : ?>

<?php 
	while( $query->have_posts() ): 
	$query->the_post(); 
	$do_not_duplicate[] = $post->ID ?>
	
			<div class="row glossary-box no-border<?php if( is_single() ) : echo ' box box-highlight'; endif; ?>">
				<div class="clearfix">
					<h2<?php if( ! is_single() ) : echo ' class="accessibility-aid"'; endif; ?>><span>What is&hellip;</span><?php the_title(); ?></h2>
					<?php the_content(); ?>
				</div>
			</div>

<?php endwhile; ?>

<?php endif; // if have_posts ends 

/* ============== end pull in business card ============== */
?>

<?php
/* ============== pull in featured ============== */
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; // Needed for pagination
	$query = new WP_Query( array(
	'posts_per_page' => 1,
	'category_name' => $current_cat,
	'meta_key' => 'dbt_checkbox_featured',
  'post_type' => 'any',
	'paged'=>$paged
	));
?>
<?php if ($query->have_posts()) : ?>
	<div class="row featured-article">
		<h2>Editor's pick</h2>
		<ul class="no-bullets">
<?php 
	while( $query->have_posts() ): 
	$query->the_post(); 
	$do_not_duplicate[] = $post->ID ?>
 
	<?php get_template_part("content_home"); ?>	
<?php endwhile; ?>
		</ul>
	</div>

<?php else : ?>	
<?php 
// The Query
	$new_query = new WP_Query( array(
	'posts_per_page' => 1,
	'category_name' => $current_cat,
  'post_type' => 'any',
	'paged'=>$paged
	));
?>
	<div class="row featured-article">
		<ul class="no-bullets">
<?php 
	while( $new_query->have_posts() ): 
	$new_query->the_post(); 
	$do_not_duplicate[] = $post->ID
?>
	<?php get_template_part("content_home"); ?>	
		
<?php endwhile; wp_reset_postdata(); ?>
			</ul>
	</div>

<?php endif; // if have_posts ends 
/* ============== end pull in featured ============== */
?>

<ul class="article-list  no-bullets">
<?php
/* ============== pull in latest events ============== */
  wp_reset_query();
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; // Needed for pagination
	$query = new WP_Query( array(
	'posts_per_page' => 2,
	'post_type' => 'event',
	'category_name' => $current_cat,
  'post__not_in' => $do_not_duplicate,
	'paged'=>$paged
	));
?>

<?php if ($query->have_posts()) : ?>
	<li class="row<?php if ( is_page('events') ) : echo ' row-events-latest'; endif ; ?>">
		<h2>Upcoming and recent events</h2>
		<ul class="no-bullets">
<?php 
	while( $query->have_posts() ): 
	$query->the_post(); 
	$do_not_duplicate[] = $post->ID ?>

	<li>
		<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<?php get_template_part("/includes/_event_meta"); ?>
	</li>

<?php endwhile; ?>
		</ul>
	</li>
<?php endif; // if have_posts ends 

/* ============== end pull in latest events ============== */
?>  
		
<?php
/* ============== pull in latest articles ============== */
  wp_reset_query();
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; // Needed for pagination
	$query = new WP_Query( array(
	'posts_per_page' => 2,
	'category_name' => $current_cat,
  'post_type' => 'any',
  'post__not_in' => $do_not_duplicate,
	'paged'=>$paged
	));
?>
 
<?php if ($query->have_posts()) : ?>
	<li class="row">
		<h2>Latest <?php echo strtolower(wp_title( '', false, 'right' )); ?></h2>
		<ul class="no-bullets">
<?php 
	while( $query->have_posts() ): 
	$query->the_post(); 
	$do_not_duplicate[] = $post->ID ?>
	
	<?php if ( is_page('events') ) : ?>
		<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<?php get_template_part("/includes/_event_meta"); ?>
	<?php else : ?>
		<?php get_template_part("content_home"); ?>	
	<?php endif; ?>
	
<?php endwhile; ?>
		</ul>
	</li>
<?php endif; // if have_posts ends 

/* ============== end pull in latest articles ============== */
?>

<?php
/* ============== pull in most viewed articles ============== */
  wp_reset_query();
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; // Needed for pagination
	$query = new WP_Query( array(
	'posts_per_page' => 2,
	'category_name' => $current_cat,
  'post_type' => 'any',
  'post__not_in' => $do_not_duplicate,
  'meta_key' => 'post_views_count',
  'orderby' => 'meta_value_num',
	'paged'=>$paged
	));
?>

 
<?php if ($query->have_posts()) : ?>
	<li class="row<?php if ( is_page('events') ) : echo ' row-events'; endif ; ?>">
		<h2>Most viewed <span><?php echo strtolower(wp_title( '', false, 'right' )); ?></span></h2>
		<ul class="no-bullets">
<?php 
	while( $query->have_posts() ): 
	$query->the_post(); 
	$do_not_duplicate[] = $post->ID ?>
	
	<?php if ( is_page('events') ) : ?>
		<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<?php get_template_part("/includes/_event_meta"); ?>
	<?php else : ?>
		<?php get_template_part("content_home"); ?>	
	<?php endif; ?>

<?php endwhile; ?>
		</ul>
	</li>
<?php endif; // if have_posts ends 

/* ============== end pull in most viewed articles ============== */
  wp_reset_query();
?>

<?php /* ============== links to all topics ============== */ ?>
	<li class="row row-resource-list">
	<h2><?php wp_title(''); ?> by topic</h2>
		<ul class="no-bullets">
			<?php 
				$taxonomy = 'topic';
				$categories = get_terms( $taxonomy, '' );
				$current_ctx = basename(get_permalink());

				if ($categories) {
					foreach($categories as $category) {
						echo '<li>' . '<a href="/type/'.$current_ctx.'?topic=' . $category->slug . '" ' . '>' . $category->name.' </a></li> ';
						//(' . $category->count . ')
					}
				} 
				//$taxonomies = array('category','post_tags','topic');
			?>						
		</ul>
	</li>	
<?php /* ============== end links to all topics ============== */ ?>

</ul>
	
</div><!-- /.eight-col -->
	
<?php get_footer(); ?>