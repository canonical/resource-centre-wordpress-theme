<?php if(!is_paged()) : ?>
<?php 
	query_posts( array('post_type' => $post_types, 'cat' => $cat, 'posts_per_page' => 1, 'orderby' => 'date'));
		
	while (have_posts()) : the_post();
	$thePostID = $post->ID;
	$post_type = get_post_type_object( get_post_type($post));
	$pagecat = $this_category->category_nicename;
	$articlecat = $category = get_the_category()->category_nicename;
	$key = 'postVideo';
	$mything = 'dbt_checkbox_featured';
	$featured_content = get_post_meta($post->ID, $mything, TRUE);
	$video_content = get_post_meta($post->ID, $key, TRUE);
	$terms = get_the_term_list( $post->ID, 'topic' );
	$terms = strip_tags( $terms );
	$attachment_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_parent = '$post->ID' AND post_status = 'inherit' AND post_type='attachment' ORDER BY post_date DESC LIMIT 1");
?>
<?php if ( ( $term->name ) && ( $term->name == $terms ) ) : ?>

	<div class="featured-article box twelve-col<?php the_category_unlinked(' post-'); ?>">
<?php if ($featured_content) : echo 'yes'; endif; ?>
		<div class="article-content six-col">
			<?php get_template_part("includes/_article_meta"); ?>
			<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<?php the_excerpt(); ?>
			<?php if('casestudy' == get_post_type() || 'ebook' == get_post_type() || 'whitepaper' == get_post_type()) : ?> 
			<p><a class="link-cta-ubuntu" href="<?php the_permalink(); ?>">Get <?php echo $post_type->labels->title_friendly; ?> download</a></p>
			<?php endif; // end if('ebook' == get_post_type() || 'whitepaper' == get_post_type()) ?>
		</div><!-- /.article-content -->
		<div class="article-image six-col right last-col">
				<a href="<?php the_permalink(); ?>">
				<?php if('video' == get_post_type()): ?>
					<img src="http://img.youtube.com/vi/<?php echo $video_content; ?>/0.jpg" width="260" height="146" alt="" />
				<?php else : ?>	
				<?php the_post_thumbnail('medium'); ?> 	
				<?php endif; ?>
				</a>
		</div><!-- /.article-image -->
	</div>
<?php endif; /*end if($articlecat == $pagecat)*/ endwhile; /* (have_posts()) */ endif; // end if(is_paged()) ?>
