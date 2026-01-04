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
?>

		<!--		<?php if('event' == get_post_type()) : ?>
				<?php $event_timestamp = get_post_meta( $post->ID, '_start_eventtimestamp', true ); ?>
					<?php // only show the register link if event not started
						if($current_timestamp <= $event_timestamp) :  ?>
							<p><a class="link-cta-ubuntu" href="<?php echo $registration; ?>">Register now</a></p>
					<?php endif; ?>
				<?php endif; ?>
-->


<?php get_header(); 
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; // Needed for pagination
?>
<div class="no-border">
<h1 class="cat-title row no-border"><?php $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); ?><?php if( $term != '' ) : ?><span class="taxonomy-title"><?php echo $term->name; ?></span><?php endif; ?> <span><?php single_cat_title(); ?></span></h1>

<?php // get_template_part("featured_category"); ?>

<?php 
	wp_reset_query();
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$args = array(	
		'order'		=> 'DESC',
		'orderby'	=> 'meta_value',
		'products-and-services' => $term->slug,
		'meta_key' 	=> '_start_eventtimestamp' );
	$eventslist = new WP_Query();
	$eventslist->query( $args );	
	$event_timestamp = get_post_meta( $post->ID, '_start_eventtimestamp', true );	
	$style_index = 0;
	$postCount = 0;
	if ( have_posts() ) : 
?>

<div class="eight-col">
<ul class="article-list no-bullets">

<?php while ($eventslist->have_posts()) : $eventslist->the_post(); ?>
	<?php if($thePostID == $post->ID) { } else { ?>
		<li class="row article<?php $k = $style_index%3; echo "$style_classes[$k]"; $style_index++; ?><?php $post_type = get_post_type_object( get_post_type($post) ); echo ' post-', $post_type->labels->css_friendly; ?>">
        	<?php
				$lock = 'dbt_checkbox';
				$gated_content = get_post_meta($post->ID, $lock, TRUE);
        	?>
				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<?php get_template_part("includes/_article_meta"); ?>
				<?php 
					$current_time = current_time('mysql'); 
					list( $today_year, $today_month, $today_day, $hour, $minute, $second ) = split( '([^0-9])', $current_time );
					$current_timestamp = $today_year . $today_month . $today_day . $hour . $minute;
					// Gets the event start month from the meta field
					$start_nummonth = get_post_meta( $post->ID, '_start_month', true );
					$start_month = get_post_meta( $post->ID, '_start_month', true );
					// Converts the month number to the month name
					$start_month = $wp_locale->get_month( $start_month );
					// Gets the event start day
					$start_day = get_post_meta( $post->ID, '_start_day', true );
					// Gets the event start year
					$start_year = get_post_meta( $post->ID, '_start_year', true );
					// Gets the event start hour
					$start_hour = get_post_meta( $post->ID, '_start_hour', true );
					// Gets the event start minute
					$start_minute = get_post_meta( $post->ID, '_start_minute', true );
					$end_nummonth = get_post_meta( $post->ID, '_end_month', true );
					$end_month = get_post_meta( $post->ID, '_end_month', true );
					// Converts the month number to the month name
					$end_month = $wp_locale->get_month( $end_month );
					// Gets the event start day
					$end_day = get_post_meta( $post->ID, '_end_day', true );
					// Gets the event start year
					$end_year = get_post_meta( $post->ID, '_end_year', true );
					// Gets the event start hour
					$end_hour = get_post_meta( $post->ID, '_end_hour', true );
					// Gets the event start minute
					$end_minute = get_post_meta( $post->ID, '_end_minute', true );
					$location = get_post_meta( $post->ID, '_event_location', true );
					$registration = get_post_meta( $post->ID, '_event_registration', true );
				?>
				</p>
				<dl class="event-details clearfix">
				<dt class="accessibility-aid">Location:</dt>
				<?php if ( $location ) : ?><dd class="location" itemprop="location" itemscope itemtype="http://schema.org/PostalAddress"><?php echo $location; ?></dd><?php endif; ?>
				<dt class="accessibility-aid">Date:</dt>
				<dd>
					<?php if ($start_day != $end_day && $start_month == $end_month) : ?>
						<?php echo $start_day . '-' . $end_day . ' ' . $start_month . ' ' . $end_year; ?>
					<?php endif; ?>
					<?php if ($start_month != $end_month) : ?>
						<?php echo $start_day . ' ' . $start_month . ' - ' .$end_day . ' ' . $end_month . ' ' . $end_year; ?>
					<?php endif; ?>
					<?php if ($start_day == $end_day) : ?>
						<?php echo $start_day. ' ' . $start_month . ' ' . $end_year; ?>
					<?php endif; ?>
					<span class="accesibilty-aid">
						<time itemprop="startDate" datetime="<?php echo $start_year .'-' . $start_nummonth . '-' . $start_day . 'T' . $start_hour . ':' . $start_minute; ?>"></time></dd>
						<time itemprop="endDate" datetime="<?php echo $end_year .'-' . $end_nummonth . '-' . $end_day . 'T' . $end_hour . ':' . $end_minute; ?>"></time>
					</span>
				</dd>
			</dl>
				<?php if(has_post_thumbnail()) : ?><div class="article-image three-col"><?php if(has_post_thumbnail()) { the_post_thumbnail(); } ?></div><?php endif; ?>
				<?php if(has_post_thumbnail()) : ?>
				<div class="five-col last-col">
				<?php the_excerpt(); ?>	
				</div>
				<?php else : ?>
				<?php the_excerpt(); ?>	
				<?php endif; ?>
<?php if (comments_open()): ?>
<?php else : ?>
	<?php 
		if($number == 0):
		else : ?>
	<?php 
		endif; ?>	
<?php endif; // end if comments open ?>
        </li>

    <?php } // end if($thePostID == $post->ID) ?>
		<?php endwhile;?>
</ul>
</div><!-- /.eight-col -->

<div class="eight-col">
<?php get_template_part("includes/_pagination"); ?>
</div><!-- /.eight-col -->

<?php 
	endif;
	wp_reset_query();
?>
<div class="aside three-col last-col">
	<h2>Filter <span class="lowercase"><?php single_cat_title() ?></span> by product or service</h2>
	<ul class="no-bullets">	 
	<li<?php if (!$term) echo ' class="current"'; ?>><a href="/topics/<?php $cat = get_term_by('name', single_cat_title('',false), 'category'); echo $cat->slug; ?>">All <span class="lowercase"><?php single_cat_title() ?></span></li>
	<?php 
		$pagecat = $this_category->category_nicename;
		$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
		$services = get_terms( 'products-and-services', 'hide_empty=1&pad_counts=1');
    $args = array();
    $args['paged'] = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
    if ( isset( $_GET['service'] ) ) {
        $args['service'] = $_GET['products-and-services'];
        $page_link = add_query_arg( 'products-and-services', $_GET['products-and-services'], $page_link );
    }
    if ( is_array( $services ) ) {
        foreach ( $services as $service ) {
        		if ( $term->slug == $service->slug ) {
        			echo '<li class="current">';
        		} else {
        			echo '<li>';
            }
            	echo '<a href="' . htmlentities( add_query_arg( 'products-and-services', $service->slug, $page_link ) ) . '">' . $service->name . '';
            	//$cat = get_term_by('name', single_cat_title('',false), 'category'); 
            	//echo $cat->slug;
            	echo '</a></li>';
        }
     
 ?>
 
   <?php } ?>
   </ul>
	<?php //get_template_part("includes/_promo"); ?>
	
</div><!-- /.row -->

<?php get_footer(); ?>
