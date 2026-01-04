<?php
    $attachment_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_parent = '$post->ID' AND post_status = 'inherit' AND post_type='attachment' ORDER BY post_date DESC LIMIT 1");
    //$current_cat = get_query_var('category_name');
	$current_cat = basename(get_permalink());

?>
	<div class="has-time">
		<article>
<?php if ($current_cat == 'downloads') : ?>
		<h3><a href="<?php echo wp_get_attachment_url( $attachment_id ); ?>"><?php echo $bytes; ?><?php the_title(); ?></a></h3>
<?php else : ?>
		<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
<?php endif ; ?>
	  <div class="article-meta">
	    <p>By <a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>" title="View <?php if(get_the_author_meta('first_name',$uid)): ?><?php the_author_meta('first_name',$uid); ?><?php else : ?><?php the_author_meta('display_name',$uid); ?><?php endif; ?>'s bio and posts"><span><?php the_author_meta('first_name',$uid); ?> <?php the_author_meta('last_name',$uid); ?></span></a> on 
      <time datetime="<?php the_time('Y-m-d') ?>"><?php the_time('j F Y') ?></time></p>
    </div>
		<?php if($post->post_content == "") : ?>
		<?php else : ?>
		<p><?php echo get_excerpt(); ?></p>
		<?php endif ; ?>
		<?php get_template_part("/includes/_article_meta"); ?>
		<!--<p><?php //echo getPostViews(get_the_ID()); ?></p>-->
		</article>
	</div>