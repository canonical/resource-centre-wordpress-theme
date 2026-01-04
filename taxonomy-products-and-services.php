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
?>

<?php get_header(); 
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; // Needed for pagination
	$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
?>
<div class="no-border">
<h1 class="row no-border"><?php single_tag_title(); ?></h1>

<?php //get_template_part("featured_category"); ?>

	<div class="eight-col">
		<ul class="article-list  no-bullets">
			<?php if ( have_posts() ) : while (have_posts()) : the_post(); ?>
			<?php if (is_sticky()) continue; ?>
<?php if ( is_search() ) : ?>
<?php $title = get_the_title(); $keys= explode(" ",$s); $title = preg_replace('/('.implode('|', $keys) .')/iu', '<strong class="search-term">\0</strong>', $title); ?>
<?php $excerpt = get_excerpt(); $keys= explode(" ",$s); $excerpt = preg_replace('/('.implode('|', $keys) .')/iu', '<strong class="search-term">\0</strong>', $excerpt); ?>
<?php endif; ?>				
					<li class="row article <?php if(($postCount++ == 0)) { echo ' featured-article'; } ?>"> 
					<?php if(has_post_thumbnail()) : ?>
						<div class="article-image three-col">
						<?php if('$video_content' == get_post_type()) : ?>
							<a href="<?php the_permalink(); ?>"><img src="http://img.youtube.com/vi/<?php echo $video_content; ?>/0.jpg" width="100" height="100" alt="" /></a>
						<?php else : ?>	
							<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
						<?php endif; ?>
						</div>
					<?php endif; ?>	
					<h2><a href="<?php the_permalink() ?>"><?php if ( is_search() ) : echo $title; else : echo  the_title(); endif; ?></a></h2>
						<?php get_template_part("includes/_article_meta"); ?>
			<?php if('event' == get_post_type()) : ?>
				<?php 
					$current_time = current_time('mysql');
					list( $today_year, $today_month, $today_day, $hour, $minute, $second ) = preg_split( '/[^0-9]+/', $current_time );
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
				<dd class="event-date">
					<?php if ($start_day != $end_day && $start_month == $end_month) : ?>
						<?php echo ltrim($start_day, '0') . '-' . ltrim($end_day, '0') . ' ' . $start_month . ' ' . $end_year; ?>
					<?php endif; ?>
					<?php if ($start_month != $end_month) : ?>
						<?php echo ltrim($start_day, '0') . ' ' . $start_month . ' - ' . ltrim($end_day, '0') . ' ' . $end_month . ' ' . $end_year; ?>
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
		<?php endif; // event ?>
					<?php if(has_post_thumbnail()) : ?>
						<div class="five-col last-col">
					<?php endif; ?>	
					<?php if(has_post_thumbnail()) : ?>
						<p><?php if ( is_search() ) : echo $excerpt; else : echo get_excerpt(); endif; ?></p>
					</div>
					<?php else : ?>
						<p><?php if ( is_search() ) : echo $excerpt; else : echo get_excerpt(); endif; ?></p>
					<?php endif; ?>
					</li><?php endwhile; else: ?><div class=""><p><?php _e('Sorry, no posts matched your criteria.'); ?></p></div><?php endif; ?>
		</ul>
	</div><!-- /.eight-col -->
	<div class="eight-col">
		<?php get_template_part("includes/_pagination"); ?>
	</div><!-- /.eight-col -->

</div><!-- /.row -->

<div class="aside three-col last-col">
	<h2>Filter <span class="lowercase"><?php single_tag_title() ?></span> by type</h2>
	<ul class="no-bullets">	 
	<li<?php if (!$term) echo ' class="current"'; ?>><a href="/topics/<?php $cat = get_term_by('name', single_tag_title('',false), 'category'); echo $cat->slug; ?>">All <span class="lowercase"><?php single_tag_title() ?></span></a></li>
	<?php 
		$pagecat = $this_category->category_nicename;
		$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
		$services = get_terms( 'topic', 'hide_empty=1&pad_counts=1');
    $args = array();
    $args['paged'] = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
    if ( isset( $_GET['service'] ) ) {
        $args['service'] = $_GET['topic'];
        $page_link = add_query_arg( 'topic', $_GET['topic'], $page_link );
    }
    if ( is_array( $services ) ) {
        foreach ( $services as $service ) {
        		if ( $term->slug == $service->slug ) {
        			echo '<li class="current">';
        		} else {
        			echo '<li>';
            }
            	echo '<a href="' . htmlentities( add_query_arg( 'topic', $service->slug, $page_link ) ) . '">' . $service->name . '';
            	//$cat = get_term_by('name', single_cat_title('',false), 'category'); 
            	//echo $cat->slug;
            	echo '</a></li>';
        }
     
 ?>
 
   <?php } ?>
   </ul>
	
</div>

<!--<div class="row four-col last-col no-border">
	<?php
	wp_reset_query();
	$taxonomy = 'topic';
	$queried_term = get_query_var($taxonomy);
	$args = array( 'numberposts' => 1, 'topic' => $queried_term, 'post_type' => productbusinesscard );
	$myposts = get_posts( $args );	foreach( $myposts as $post ) : setup_postdata($post); ?>
		<div class="glossary-box box box-highlight <?php echo ' promo-', $queried_term; ?>">
			<h2><span>What is&hellip;</span><?php the_title(); ?></h2>
			<?php the_content(); ?>
		</div>
	<?php endforeach; ?>
</div> -->

<?php get_footer(); ?>
