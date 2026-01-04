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
 /* Template Name: Press */
?>

<?php get_header();
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; // Needed for pagination
	$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
	$post = $wp_query->get_queried_object();
?>

<div class="row glossary-box no-border glossary-box-<?php global $post; $slug = get_post( $post )->post_name; echo $slug; ?>">
    <div class="inner-wrapper">
        <div class="six-col">
            <h1><?php wp_title(''); ?></h1>
            <?php echo do_shortcode("[embed_post title='Contact' show_title='']"); ?>
        </div>
    </div>
</div>

<div class="row no-border">
<div class="inner-wrapper">
<div class="eight-col no-margin-bottom">
<?php
/* ============== pull in featured ============== */
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; // Needed for pagination
	$query = new WP_Query( array(
    	'posts_per_page'    => 1,
    	'category_name'     => 'press-release,news',
        'post_type'         => 'any',
    	'paged'             => $paged
	));
?>
<?php if ($query->have_posts()) : ?>
    <div class="featured box box-highlight eight-col">
        <h2>Featured</h2>
		<?php
			while( $query->have_posts() ):
			$query->the_post();
			$do_not_duplicate[] = $post->ID ?>
            <?php get_template_part("content_home_featured"); ?>
		<?php endwhile; ?>
    </div><!-- /.eight-col -->

<?php else :

// The Query
	$new_query = new WP_Query( array(
    	'posts_per_page'    => 1,
    	'category_name'     => 'press-release,news',
        'post_type'         => 'any',
    	'paged'             => $paged
	));
?>

<div class="box box-highlight eight-col clear">
<?php while( $new_query->have_posts() ): $new_query->the_post(); ?>
    <?php get_template_part("content_home_featured"); ?>
<?php endwhile; wp_reset_postdata(); ?>
</div><!-- /.eight-col -->

<?php endif; // if have_posts ends
/* ============== end pull in featured ============== */
?>

<?php
/* ============== pull in latest news articles ============== */
  wp_reset_query();
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; // Needed for pagination
	$current_cat = basename(get_permalink());
	$query = new WP_Query( array(
    	'posts_per_page'    => 6,
    	'category_name'     => 'news',
        'post_type'         => 'any',
        'post__not_in'      => $do_not_duplicate,
    	'paged'             => $paged
	));
?>

<?php if ($query->have_posts()) : ?>
<div class="box box-highlight eight-col clear">
    <h2>Latest news</h2>
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
/* ============== end pull in latest news ============== */ 
?>

<?php
/* ============== pull in follow us ============== */ ?>
<div class="box box-highlight eight-col clear">
    <?php echo do_shortcode("[embed_post title='Follow us' show_title='yes']"); ?>
</div><!-- /.eight-col -->

<?php 
wp_reset_query();  // Restore global post data 
// if have_posts ends
/* ============== end pull in follow us ============== */
?>

<?php /* ============== links to all Downloads ============== */ ?>
<div class="box box-highlight eight-col clear">
<h2>Downloads</h2>
<?php $custom_terms = get_terms('download-type');
$attachment_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_parent = '$post->ID' AND post_status = 'inherit' AND post_type='attachment' ORDER BY post_date DESC LIMIT 1");

foreach($custom_terms as $custom_term) :
$args = array(
	'post_type'	    => 'any',
	'order'			=> 'ASC',
	'orderby'		=> 'slug',
	'tax_query'     => array(
		array(
			'field'     => 'slug',
			'taxonomy'	=> 'download-type',
			'terms'     => $custom_term->slug
		),
	),
);

query_posts($args);
if(have_posts()) : ?>
<div class="eight-col clear">
			<h3><?php echo $custom_term->name; ?></h3>
			<ul class="no-bullets no-margin-bottom">
     <?php $c = 0; while(have_posts()) : the_post(); $c++; 
     	if( $c == 2) {
				 $style = ' last-col';
				 $c = 0;
			}
			else $style='';
     ?>
		 <li class="no-margin-bottom four-col<?php echo $style; ?>">
				<?php 
					$attachments = get_posts(array( 
    				    'post_type'     => 'attachment',
    				    'numberposts'   => -1,
    				    'post_status'   => 'any',
    				    'post_parent'   => $post->ID
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
</div><!-- /.box -->
<?php endforeach; wp_reset_query(); ?>
</div><!-- /.box -->

<?php
/* ============== pull in about articles ============== */
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; // Needed for pagination
	$current_tax = basename(get_permalink());
	$parent_pages = get_posts( array(
		'post_type'      => 'page',
		'title'          => 'About',
		'posts_per_page' => 1,
		'post_status'    => 'publish',
	) );
	$parent_page = ! empty( $parent_pages ) ? $parent_pages[0] : null;
	$parent_page_id = $parent_page ? $parent_page->ID : 0;
	$query = new WP_Query( array(
    	'posts_per_page'    => 1,
    	'post_parent'       => $parent_page_id,
        'post_type'         => 'page',
        'post__not_in'      => $do_not_duplicate,
    	'orderby'           => 'menu_order',
    	'paged'             =>$paged
	));
?>
 
<?php if ($query->have_posts()) : ?>
<div class="box box-highlight eight-col clear">
    <h2>About</h2>
	<ul class="no-bullets">
	<?php 
		while( $query->have_posts() ): 
		$query->the_post(); 
		$do_not_duplicate[] = $post->ID ?>

		<li<?php if(in_category( $press_cats )) echo ' class="has-time"'; ?>>
			<!-- <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3> -->
			<p><?php echo the_excerpt(); ?></p>
			<p><a href="/about">Find out more</a></p>
		</li>

	<?php endwhile; ?>
	</ul>
</div><!-- /.eight-col -->
<?php endif; 
wp_reset_query();  // Restore global post data 
// if have_posts ends
/* ============== end pull in about articles ============== */
?>

</div><!-- /.eight-col -->

<aside id="sidebar" class="four-col last-col">
<?php get_template_part("includes/_digest"); ?>
    <div class="box box-highlight four-col">
    <h2>News by topic</h2>
		<ul class="no-bullets">
		<?php
			wp_reset_query();
			$current_tax = 'news';
			$category = $current_tax;
			$the_id = get_cat_ID('news');
            $term_args = array(
                'taxonomy'    => 'topic',
                'orderby'     => 'slug',
                'order'       => 'ASC'
              );
			$cats = get_categories($term_args);
			// loop through the categries
				foreach ($cats as $cat) :
					// setup the cateogory ID
                    $query_args = array(
						'post_type'         => 'any',
						'posts_per_page'    => '1',
						'cat'               => $the_id,
						'topic'             => $cat->name
					);

          query_posts($query_args); //create our own custom query based on above arguments
					// start the wordpress loop!
			      if (have_posts()) : while (have_posts()) : the_post();
							echo "<li><a href='/category/" . $current_tax . "?topic=".$cat->slug."'>".$cat->name." (" .$wp_query->found_posts . ")</a></li>";
			      ?>
						<?php endwhile; endif; // done our wordpress loop. Will start again for each category ?>
				<?php endforeach; // done the foreach statement ?>

		</ul>
    </div><!-- /.box -->
    <div class="box box-highlight four-col">
      <h2 class="clear">News by year</h2>
      <ul class="no-bullets">
<?php
     	$y = date( 'Y' ); // The current year.
        $the_id = get_cat_ID('news');

		while ( $y > 2004 ) { // Pick a reasonable year you want this loop to end at, to save your server some time.
    		
				$args = array(
					'posts_per_page'    => -1,
					'cat'               => $the_id,
					'year'              => $y
				);
				$cat_q = new WP_Query( $args );
				if ( $cat_q->have_posts() ) {
					$p = 0;
					while ( $cat_q->have_posts() ) {
						$cat_q->the_post();
						$p++;
					}
					?>
					<li>
						<a href="<?php bloginfo( 'url' ); ?>/category/news/year/<?php echo $y; ?>"><?php echo ' '.$y.' ('.$p.')'; ?></a>
					</li>
					<?php
				wp_reset_query();
			}
			$y--;
		}
		wp_reset_query(); ?>
	   </ul>
    
    </div><!-- /.box -->
</aside>

</div><!-- /.inner-wrapper -->
</div><!-- /.row -->
<?php get_footer(); ?>
