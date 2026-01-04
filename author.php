<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Author Template
 *
 *
 * @file           author.php
 * @package        Ubuntu blog theme
 * @author         Canonical Web Team 
 * @copyright      2012 Canonical Ltd
 * @license
 * @version        Release: 1.0
 * @filesource     wp-content/themes/insights-theme/author.php
 * @link           http://codex.wordpress.org/Author_Templates
 * @since          available since Release 1.0
 */
?>

<?php get_header(); ?>
<?php if ( is_author('') ) { ?>
<?php $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', sanitize_text_field($_GET['author_name'])) : get_userdata(intval(get_query_var('author'))); ?>

<div class="row no-border">
	<div id="hcard-<?php echo $curauth->first_name; ?>-<?php echo $curauth->last_name; ?>" class="vcard inner-wrapper">
		<div id="author-info" class="<?php if(get_the_author_meta('user_photo', $curauth->ID)) echo 'has-avatar '; ?>seven-col">
			<header>
				<?php if(get_the_author_meta('user_photo', $curauth->ID)) : ?>
				<span class="image-wrap avatar" style="width: auto; height: auto;"><img src="<?php bloginfo('url'); ?>/<?php echo $curauth->user_photo; ?>" alt="<?php echo $curauth->first_name; ?>'s photo" class="avatar-140 photo" width="156" height="156" /></span>
				<?php else : ?>
				<?php endif; ?>
				<h1><?php the_author_meta('first_name',$uid); ?> <?php the_author_meta('last_name',$uid); ?></h1>
		    <?php if(get_the_author_meta('user_job_title',$curauth->ID)) : ?>
					<p class="role"><?php echo $curauth->user_job_title; ?></p>
				<?php endif; ?>
	    	<?php if(get_the_author_meta('location',$curauth->ID)) : ?>
					<p class="location"><?php echo $curauth->location; ?></p>
				<?php endif; ?>
	    	</header>
				<ul id="social-links" class="no-bullets">
				<?php if(get_the_author_meta('user_twitter', $curauth->ID)): ?>
					<li><a class="social-twitter url" href="http://twitter.com/<?php the_author_meta('user_twitter', $curauth->ID); ?>" title="Follow <?php the_author_meta('first_name', $curauth->ID); ?> on Twitter">Follow <?php the_author_meta('first_name',$curauth->ID); ?> on Twitter</a></li>
				<?php endif; ?>
				<?php if(get_the_author_meta('user_facebook', $curauth->ID)): ?>
					<li><a class="social-facebook url" href="http://facebook.com/<?php the_author_meta('user_facebook', $curauth->ID); ?>" title="Follow <?php the_author_meta('first_name',$curauth->ID); ?> on Facebook">Follow <?php the_author_meta('first_name',$curauth->ID); ?> on Facebook</a></li>
				<?php endif; ?>
				<?php if(get_the_author_meta('user_google', $curauth->ID)): ?>
					<li><a title="Follow <?php the_author_meta('first_name',$curauth->ID); ?> on Google Plus" class="social-google url" href="https://plus.google.com/<?php the_author_meta('user_google',$curauth->ID); ?>">Follow <?php the_author_meta('first_name',$curauth->ID); ?> on Google Plus</a></li>
				<?php endif; ?>
				<?php if(get_the_author_meta('user_launchpad', $curauth->ID)): ?>
					<li><a class="social-launchpad url" href="https://launchpad.net/~<?php echo $curauth->user_launchpad; ?>" title="View <?php echo $curauth->first_name; ?> on Launchpad">Launchpad</a></li>
				<?php endif; ?>
				</ul>
				<?php if(get_the_author_meta('user_description', $curauth->ID)) : ?>
				<div id="author-description" class="">
					<p><?php echo $curauth->user_description; ?></p>
				</div><!-- /#author-description -->
				<?php endif; // user_description ?>
	</div><!-- /.five-col -->

<div class="five-col last-col">
	<?php $postCount = 0; ?>	
		<div id="author-articles" class="box">
		<h3>Recently posted by <?php if(get_the_author_meta('first_name', $curauth->ID)): ?><?php echo $curauth->first_name; ?><?php else : ?><?php echo $curauth->display_name; ?><?php endif; ?></h3>
		<p class="social-rss"><a class="url" href="/author/<?php the_author_meta('user_nicename',$curauth->ID); ?>/feed/">Subscribe to <?php the_author_meta('first_name',$curauth->ID); ?>'s posts</a></p>
			<?php $loop = new WP_Query( array( 'post_type' => $post_types, 'author' => $curauth->ID, 'posts_per_page' => 5 ) ); ?>
			<?php if ( $loop->have_posts() ) : ?>
				<ul class="no-bullets">
		<?php while ( $loop->have_posts() ) : ?>
		<?php $loop->the_post(); ?>
			        <li class="block-click<?php the_category_unlinked(' post-'); ?>">
			        	<article>
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							<p><span class="off-left">Posted on </span><time datetime="<?php the_time('Y-m-d') ?>" ><?php the_time('j') ?><?php the_time(' F Y') ?></time></p>
							<p class="post-category">Posted in: <?php the_category_unlinked(); ?></p>
			        	</article>
			        </li>
		<?php endwhile; ?>
					    </ul>
		<?php else: ?>
			        <p><?php _e('No posts by this author.'); ?></p>
		<?php endif; // have_posts() ?>
		</div><!-- /#articles -->
	<?php } ?>
	</aside>
</div><!-- /.five-col --> 
</div><!-- /.hcard -->
</div><!-- /.twelve-col -->

<?#php get_sidebar(); ?>
<?php get_footer(); ?>