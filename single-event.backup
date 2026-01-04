<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Single Template
 *
 *
 * @file           single.php
 * @package        Ubuntu blog theme 
 * @author         Canonical Web Team 
 * @copyright      2012 Canonical Ltd
 * @license
 * @version        Release: 1.0
 * @filesource     wp-content/themes/insights-theme/single.php
 * @link           http://codex.wordpress.org/Theme_Development#Footer_.28footer.php.29
 * @since          available since Release 1.0
 */
get_header(); 
	$field = 'dbt_ga_tracking_label';
	$ga_conversion = get_post_meta($post->ID, $field, TRUE);
	$the_ga_code = $ga_conversion;
	$key = 'postVideo';
	$video_content = get_post_meta($post->ID, $key, TRUE); 
	$lock = 'dbt_checkbox_gated';
	$gated_content = get_post_meta($post->ID, $lock, TRUE);
	$posted = $_GET['posted'];
	$postdate = get_the_time('sgymd');
	$postid = get_the_ID();
	$post_type = get_post_type_object( get_post_type($post) );
	global $wpdb;
	global $posted;
	$attachment_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_parent = '$post->ID' AND post_status = 'inherit' AND post_type='attachment' ORDER BY post_date DESC LIMIT 1");
	$articlecat = $category = get_the_category()->category_nicename;
	$current_time = current_time('mysql'); 
	list( $today_year, $today_month, $today_day, $hour, $minute, $second ) = split( '([^0-9])', $current_time );
	$current_timestamp = $today_year . $today_month . $today_day . $hour . $minute;
?>

<div itemscope itemtype="http://schema.org/BusinessEvent" class="row no-border">
	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
		<?php if(!current_user_can('administrator')){ echo setPostViews(get_the_ID()); } ?>
	<div class="twelve-col no-margin-bottom">
			<?php get_template_part("includes/_cat_headings"); ?>
		<h1><?php the_title(); ?></h1>
	</div>
	<div class="twelve-col no-margin-bottom">
	<div class="no-margin-bottom">
		<?php get_template_part("/includes/_event_meta"); ?>
			<?php if('post' != get_post_type() && $gated_content == 'on') { the_content(); } ?>
<?php if(($gated_content == 'on') && ($posted != $postdate . $postid)) { ?>
					<?php if($posted == $postdate . $postid ) { // check if the form has been posted ?>
					<?php } else { // show this if the form has not been posted ?>
					<?php if('post' == get_post_type()) the_excerpt(); ?>
					<div id="gated-content">
						<p>Please enter your details to view the <?php echo $post_type->labels->title_friendly; ?>  '<?php the_title(); ?>'</p>
						
					<?php $theurl = rtrim(get_permalink(),'/'); ?>
					<iframe height="620" width="420" src="https://pages.ubuntu.com/confirmed-download<?php the_category_unlinked('-'); ?>.html?url_param=<?php echo $theurl; ?>&amp;posted_param=<?php echo $postdate . $postid; ?>&amp;cat=<?php the_category_unlinked(''); ?>" name="iframe_w_param" id="iframe_w_param"></iframe>
					</div><!-- /#gated-content -->
					<?php } // end if market_form completed ?>
<?php } elseif(($gated_content == 'on' && $posted == $postdate . $postid)) { // show this if is gated and the form has been posted ?>
		<?php if('video' == get_post_type()) : ?>
					<iframe class="post-video" width="540" height="389" src="http://www.youtube.com/embed/<?php echo $video_content; ?>?rel=0&showinfo=0" frameborder="0" allowfullscreen></iframe>
					<?php the_content(); ?>
		<?php else : ?>
		<?php if('post' == get_post_type()) : ?>
				<?php the_content(); ?>
		<?php else : ?>
					<iframe width="1" height="1" frameborder="0" src="<?php echo wp_get_attachment_url( $attachment_id ); ?>"></iframe>
		<?php endif; ?>
		<?php endif; // if video  ?>
			<?php } else { // show this if the post is not gated ?>
		<?php if('video' == get_post_type()) : ?>
				<?php the_excerpt(); ?>
					<iframe class="post-video" width="540" height="389" src="http://www.youtube.com/embed/<?php echo $video_content; ?>?rel=0&showinfo=0" frameborder="0" allowfullscreen></iframe>
				<?php the_content(); ?>
		<?php elseif('post' == get_post_type()) : ?>
					<?php the_content(); ?>
		<?php else : ?>
					<div itemprop="description"><?php the_content(); ?></div>
				<?php if('event' == get_post_type()) : ?>
				<?php $event_timestamp = get_post_meta( $post->ID, '_start_eventtimestamp', true ); ?>
					<?php // only show the register link if event not started
						if($current_timestamp <= $event_timestamp) :  ?>
					<div id="download-item">
						<p><a itemprop="url" class="link-cta-ubuntu" href="<?php echo $registration; ?>">Register now</a></p>
					</div>
					<?php endif; ?>
				<?php endif; // if event ?>
		<?php if(!$gated_content && $posted) : ?>
					<iframe width="1" height="1" src="<?php echo wp_get_attachment_url( $attachment_id ); ?>" style='display:none;'></iframe>
		<?php else : ?>
						<?php $attachments = get_children( array('post_parent' => get_the_ID(), 'post_type' => 'attachment') );
							if ( $attachments ) { ?>
					<div id="download-item">
						<p><a class="link-cta-ubuntu" href="<?php echo wp_get_attachment_url( $attachment_id ); ?>">Download <?php echo $post_type->labels->title_friendly, ''; ?></a></p>
					</div><?php } // end if ( $attachments ) ?>
		<?php endif; ?>
		<?php endif; // if video  ?>
<?php } // end if gated ?>
	</div><!-- /.eight-col -->
</div><!-- /.twelve-col -->
<div class="instapaper_ignore">
<?php //get_template_part("includes/_subscribe"); ?>
<?php get_template_part("includes/_related_posts"); ?>
</div>
<?php endwhile; // while have_posts ends ?> 
<?php endif; // if have_posts ends ?> 
	<div class="eight-col<?php $tags = wp_get_post_tags($post->ID); if ($tags) { echo ' has-related'; } ?>">
		<?php //comments_template(); ?> 
	</div>

<?php
wp_reset_query();
global $wpdb;
global $posted;
$queried_object = get_queried_object();  
$term_slug = $queried_object->slug; 
$custom_taxterms = wp_get_object_terms( $post->ID, 'topic', array('fields' => 'ids') );

  $args=array(
    'post_type' => 'productbusinesscard',
    'tax_query' => array(
	    array(
	        'taxonomy' 	=> 'topic',
	        'field' 		=> 'id',
	        'terms'			=> $custom_taxterms
	    )
	),
    'post_status' => 'publish',
    'posts_per_page' => 1,
    'order' => 'ASC',
    'caller_get_posts'=> 1,
    'orderby' => 'rand'
  );

    $my_query = null;
    $my_query = new WP_Query($args);
    if( $my_query->have_posts() ) {
      while ($my_query->have_posts()) : $my_query->the_post(); ?>
      <?php echo $title; ?>
			<div class="row product-business-card no-border<?php if( is_single() ) : echo ' box box-highlight'; endif; ?>">
				<div class="clearfix">
					<h2<?php if( ! is_single() ) : echo ' class="accessibility-aid"'; endif; ?>><span>What is&hellip;</span><?php the_title(); ?></h2>
					<?php the_content(); ?>
				</div>
			</div>
        
<?php endwhile; } wp_reset_query(); ?>
</div><!-- /.row --> 

<?php get_footer(); ?>
