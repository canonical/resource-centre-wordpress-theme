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

/* Template Name: Downloads */
?>

<?php get_header();
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; // Needed for pagination
?>
<div class="row row-hero cat-page-title no-border">
	<h1 class="cat-title inner-wrapper no-border"><?php wp_title(''); ?></h1>
</div>

<div class="article-list">

<?php 
$custom_terms = get_terms('download-type');
$attachment_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_parent = '$post->ID' AND post_status = 'inherit' AND post_type='attachment' ORDER BY post_date DESC LIMIT 1");

foreach($custom_terms as $custom_term) :
$args = array('
	post_type'	=> 'any',
	'order'			=> 'ASC',
	'orderby'		=> 'slug',
	'tax_query' => array(
		array(
			'field'			=> 'slug',
			'taxonomy'	=> 'download-type',
			'terms'			=> $custom_term->slug
		),
	),
);

query_posts($args);
if(have_posts()) : ?>
	<div class="row article">
		<div class="inner-wrapper">
			<h2 id="download-<?php echo $custom_term->slug; ?>"><?php echo $custom_term->name; ?></h2>
			<ul class="no-bullets">
     <?php $c = 0; while(have_posts()) : the_post(); $c++; 
     	if( $c == 3) {
				 $style = 'last-col';
				 $c = 0;
			}
			else $style='';
     ?>
		 <li class="four-col<?php echo $style; ?>">
				<?php 
					$attachments = get_posts(array( 
				    'post_type' => 'attachment',
				    'numberposts' => -1,
				    'post_status' =>'any',
				    'post_parent' => $post->ID
				));

				if ($attachments) :
				    foreach ( $attachments as $attachment ) : 
				    $type = friendly_mime( $mimetype );
						$alt = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);
						$image_title = $attachment->post_title;
						$bytes = filesize(get_attached_file($attachment->ID));
						$mimetype = $attachment->post_mime_type;
				    ?>
		<a href="<?php echo wp_get_attachment_url( $attachment->ID); ?>"><?php echo the_title(); echo '&nbsp;[', $type, '&nbsp;', size_format($bytes), ']'; ?>&nbsp;&rsaquo;</a>
				   <?php endforeach; endif; ?>
			</li>
		<?php endwhile; endif; ?>
			</ul>
		</div><!-- /.inner-wrapper -->
	</div><!-- /.row -->
<?php endforeach; wp_reset_query(); ?>
</div><!-- /.article-list -->

<?php get_footer(); ?>
