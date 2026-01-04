<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Category Template
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

get_header();
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; // Needed for pagination
$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
$category = get_the_category();
$press_cats = array('press-releases', 'news'); ?>
    <div class="row glossary-box glossary-box-<?php echo strtolower(wp_title( '', false, 'right' )); ?> no-border<?php if( is_single() ) : echo ' box box-highlight'; endif; ?>">
	<div class="inner-wrapper">
		<h1 class="eight-col"><?php if(is_taxonomy('topic', 'category')) : echo 'We&#39;ve found '; endif ; ?><?php printf( __( ' %d %s' ), $wp_query->found_posts, _n( 'result', 'results', $wp_query->found_posts), get_posts() ); ?> for "<?php $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); ?><?php if( $term != '' ) : ?><span class="taxonomy-title"><?php echo $term->name; ?>&nbsp;</span><?php endif; ?><?php if( $year != '' ) : ?><?php echo $year, ' '; ?><?php endif ; ?><span><?php single_cat_title(); ?></span><?php if(is_taxonomy('topic', 'category')) : echo '"'; endif ; ?></h1>
	</div><!-- /.inner-wrapper -->
</div><!-- /.row -->

<ul class="article-list infinitescroll no-bullets">
<?php
/* ============== pull in latest articles (specific to the current taxonomy term/s) ============== */
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; // Needed for pagination
	$current_cat = get_query_var('category_name');
	query_posts( $args );
	$args=array(
	'posts_per_page'=> '-1',
	'post_type'=> 'any',
	'post__not_in' => $do_not_duplicate,
	'paged'=>$paged,
	'tax_query' => array(
        'relation' => 'OR',
        array(
            'taxonomy' => 'topic',
            'field' => 'slug',
            'terms' => array('cloud'),
        ),
        array(
            'taxonomy' => 'category',
            'field' => 'slug',
            'terms' => array('events'),
            'operator' => 'IN',
        ),
		)
);
wp_reset_query();
?>
<?php
	while ( have_posts() ) : the_post();
	$do_not_duplicate[] = $post->ID ?>

	<li class="row article">
		<div class="inner-wrapper">
			<div class="eight-col no-margin-bottom<?php if(in_category( $press_cats )) echo ' has-time'; ?>">
			<?php if ('event' == get_post_type()) : ?>
				<?php get_template_part("includes/_event_meta"); ?>
			<?php else : ?>
				<?php get_template_part("content_home_featured"); ?>
			<?php endif ; ?>
      </div><!-- /.eight-col -->
		</div><!-- /.inner-wrapper -->
	</li><!-- /.row -->
<?php endwhile; // if have_posts ends
/* ============== end pull in latest articles ============== */
?>
</ul>
	<?php get_template_part("includes/_pagination"); ?>
</div><!-- /.article-list -->

<?php get_footer(); ?>
