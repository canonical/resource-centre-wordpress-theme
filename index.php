<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Index Template
 *
 *
 * @file           index.php
 * @package        Ubuntu blog theme
 * @author         Canonical Web Team
 * @copyright      2012 Canonical Ltd
 * @license
 * @version        Release: 1.0
 * @filesource     wp-content/themes/insights-theme/index.php
 * @link           http://codex.wordpress.org/Theme_Development#Index_.28index.php.29
 * @since          available since Release 1.0
 */

get_header(); ?>
<div class="row glossary-box glossary-box--home no-border<?php if( is_single() ) : echo ' box box-highlight'; endif; ?>">
  <div class="inner-wrapper">
    <div class="six-col">
      <h1>Ubuntu Insights</h1>
      <p class="intro">Your source for Ubuntu news, articles, tutorials, e-books and everything else in-between.</p>
    </div>
    <div class="six-col last-col"></div>
  </div>
</div>

<?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; // Needed for pagination
$style_classes = array('','',' last-col'); // cycle last col
$style_index = 0; // count for cycle
$postCount = 0;
$post_type = get_post_type_object( get_post_type($post) );
$category = get_the_category();
$press_cats = array('press-releases', 'news');
?>

<section class="row <?php the_category_unlinked(' post-'); ?><?php if(in_category( $press_cats )) echo ' has-time'; ?>">
    <div class="inner-wrapper">
        <div class="eight-col">
        
<?php /* ============== pull in featured ============== */
if(is_home() && !is_paged()) :
$exclude_cat = 'downloads';
$category = get_category_by_slug($exclude_cat);
$my_query = new WP_Query( array(
	'cat'             => -$category->cat_ID,
    'post__in'  => get_option( 'sticky_posts' ),
	'ignore_sticky_posts' => 1,
	'order'           => 'DESC',
	'orderby'         => 'date',
	'post_type'       => 'post',
	'posts_per_page'  => 1
));
while ($my_query->have_posts()) : $my_query->the_post();
$post_type = get_post_type_object( get_post_type($post));
$do_not_duplicate[] = $post->ID;
?>
<div class="box box-highlight eight-col">
    <h2 class="section-title">Featured</h2>
    <?php get_template_part("content_home_featured"); ?>	
</div><!-- /.featured-article -->
<?php endwhile; ?><?php endif;
/* ============== end pull in featured ============== */ ?>

<?php /* ============== pull in latest cloud and server articles ============== */
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; // Needed for pagination
$exclude_cat = 'downloads';
$category = get_category_by_slug($exclude_cat);
$query = new WP_Query( array(
    'cat'	            => -$category->cat_ID,
    'paged'           => $paged,
    'post__not_in'    => $do_not_duplicate,
    'post_type'       => 'post',
    'posts_per_page'  => 5,
    'group'           => 'cloud-and-server'
));
?><?php if (have_posts()) : ?>

<section class="box eight-col">
	<h2 class="section-title"><a href="/cloud-and-server/">Cloud and Server</a></h2>
    <?php
        while( $query->have_posts() ):
        $query->the_post();
        $do_not_duplicate[] = $post->ID ?>
        <?php get_template_part("content_home"); ?><?php endwhile; ?>
</section><!-- ./eight-col -->
<?php endif; // if have_posts ends
wp_reset_query();
/* ============== end pull in latest cloud articles ============== */ ?>

<?php /* ============== pull in latest internet-of-things articles ============== */
$section = 'internet-of-things';
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; // Needed for pagination
$exclude_cat = 'downloads';
$category = get_category_by_slug($exclude_cat);
$query = new WP_Query( array(
    'cat'             => -$category->cat_ID,
    'paged'           => $paged,
    'post__not_in'    => $do_not_duplicate,
    'post_type'       => 'post',
    'posts_per_page'  => 5,
    'topic'           => $section
));
?><?php if (have_posts()) : ?>
<section class="box eight-col">
  <h2 class="section-title"><a href="/<?php echo $section; ?>">Internet of Things</a></h2>

  <?php
    while( $query->have_posts() ):
    $query->the_post();
    $do_not_duplicate[] = $post->ID ?>
    <?php get_template_part("content_home"); ?><?php endwhile; ?>
</section><!-- /.eight-col -->
<?php endif; // if have_posts ends
wp_reset_query();
/* ============== end pull in latest internet-of-things articles ============== */ ?>

<?php /* ============== pull in latest desktop articles ============== */
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; // Needed for pagination
$exclude_cat = 'downloads';
$category = get_category_by_slug($exclude_cat);
$query = new WP_Query( array(
    'cat'             => -$category->cat_ID,
    'paged'           => $paged,
    'post__not_in'    => $do_not_duplicate,
    'post_type'       => 'post',
    'posts_per_page'  => 5,
    'topic'           => 'desktop'
));
?><?php if (have_posts()) : ?>
<section class="box eight-col">
  <h2 class="section-title"><a href="/desktop">Ubuntu Desktop</a></h2>

  <?php
    while( $query->have_posts() ):
    $query->the_post();
    $do_not_duplicate[] = $post->ID ?>
    <?php get_template_part("content_home"); ?><?php endwhile; ?>
</section><!-- /.eight-col -->
<?php endif; // if have_posts ends
wp_reset_query();
/* ============== end pull in latest desktop articles ============== */ ?>

<?php /* ============== pull in latest events ============== */
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; // Needed for pagination
$exclude_cat = 'downloads';
$category = get_category_by_slug($exclude_cat);
$current_time = current_time('mysql'); 
list( $today_year, $today_month, $today_day, $hour, $minute, $second ) = explode( '([^0-9])', $current_time );
$end_month = get_post_meta( $post->ID, '_end_month', true );
$end_day = get_post_meta( $post->ID, '_end_day', true );
$end_year = get_post_meta( $post->ID, '_end_year', true );
$eventend = $end_year . $end_month . $end_day;
$todayistheday = date('Ymd');

$meta_query = array(
	array(
		'key' => $eventend,
		'value' => $todayistheday,
		'compare' => '>'
	)
);

$query = new WP_Query( array(
	'group'           => $current_tax,
  'meta_compare'    => '>',
  'meta_key'        => '_end_eventtimestamp',
	'order'           => 'ASC',
  'meta_value'      => $todayistheday,
  'orderby'         => 'meta_value',
  'post__not_in'    => $do_not_duplicate,
  'post_type'       => 'event'
));

?><?php if ( $query->have_posts() ) : ?>

<div class="eight-col box no-margin-bottom">
  <h2 class="section-title">Upcoming events</h2>
  <ul class="no-bullets">
    <?php
      while( $query->have_posts() ):
      $query->the_post();
      $do_not_duplicate[] = $post->ID ;
      // get time gubbin's
      $current_time = current_time('mysql'); 
      list( $today_year, $today_month, $today_day, $hour, $minute, $second ) = explode( '([^0-9])', $current_time );
      $end_month = get_post_meta( $post->ID, '_end_month', true );
      $end_day = get_post_meta( $post->ID, '_end_day', true );
      $end_year = get_post_meta( $post->ID, '_end_year', true );
      $eventend = $end_year . $end_month . $end_day;
      ?>
      <?php if($eventend >= $todayistheday) : ?>
    <li><?php get_template_part("/includes/_event_meta"); ?></li><?php endif; ?><?php endwhile; ?>
  </ul>
<p><a href="/category/events">View all events</a></p>
</div><!-- /.eight-col -->
<?php endif; // if have_posts ends
 wp_reset_query();
/* ============== end pull in latest events ============== */ ?>
</div><!-- /.eight-col -->
  
<?php /* ============== links to all topics ============== */ ?>
<aside id="sidebar" class="four-col last-col">
<?php get_template_part("includes/_digest"); ?>
	<div class="box box-highlight four-col">
    <h2 class="section-title">All topics</h2>
    <ul class="no-bullets">
        <?php
        $style_classes = array('',' last-col');
        $style_index = 0;
        $taxonomy = 'group';
        $terms = get_terms( $taxonomy, '' );
        if ($terms) {
            foreach($terms as $term) {
                if(($term->slug) != "canonical-announcements") echo '<li class="' . $style_classes[$style_index%2] . '">' . '<a href="' . $term->slug . '" ' . '>' . $term->name.'</a></li> ';
                $style_index++;
            }
        }
        ?>
        <li><a href="/canonical-announcements">Canonical announcements</a></li>
    </ul>
	</div>
</aside>
<?php //$terms = get_terms_by_post_type('tag','','snippet','name');
wp_reset_query(); ?>
<?php /* ============== end links to all topics ============== */ ?>
        
    </div>
</section>
<?php get_footer(); ?>