<?php
/* ============== pull in topic specific cta ============== */
  wp_reset_query();
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; // Needed for pagination
	$query = new WP_Query( array(
	  'posts_per_page'  => 2,
    'topic'           => $current_tax,
    'post_type'       => 'topiccta',
    'post__not_in'    => $do_not_duplicate,
    'paged'           => $paged
	));
?>
<?php if ($query->have_posts()) : ?>
		<?php 
			while( $query->have_posts() ): 
			$query->the_post(); 
			$do_not_duplicate[] = $post->ID;
			$slug = basename(get_permalink()); ?>					
	<div class="box box-highlight box-<?php echo strtolower(wp_title( '', false, 'right' )); ?> box-<?php echo $slug; ?> contextual-footer four-col">
        <h2><?php the_title(); ?></h2>
        <?php the_content(); ?>
	</div><!-- /.box -->
		<?php endwhile; ?>
<?php endif; // if have_posts ends 
wp_reset_query(); 
/* ============== end pull in topic specific cta ============== */ ?>
