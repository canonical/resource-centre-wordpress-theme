<?php // Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if (!empty($post->post_password)) { // if there's a password
		if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
			?>

			<p class="nocomments">This post is password protected. Enter the password to view comments.</p>

			<?php
			return;
		}
	}
	/* This variable is for alternating comment background */
	$oddcomment = ' comment-alt';
?>

<?php // start editing here. ?>
<div id="comments" class="">
<?php if ($comments) : ?>
	<h3 id="comment-count"><?php comments_number('No comments', 'One comment', '% comments' );?> </h3>

	<ol class="comment-list no-bullets">
	<?php foreach ($comments as $comment) : ?>
	<?php $comment_type = get_comment_type(); ?>
	<?php if($comment_type == 'comment') { ?>
    	<li class="clearfix twelve-col <?php echo $oddcomment; ?><?php if ($comment->comment_author_email == get_the_author_email()) { echo ' author-comment'; } ?>" id="comment-<?php comment_ID() ?>"> 		
			<?php if ($comment->comment_approved == '0') : ?>
			<div class="alert">Thank you. Your comment is awaiting moderation.</div>
			<?php endif; ?>
			<div class="comment-meta three-col">
				<div>
					<?php echo get_avatar( $comment, 32 ); ?>
					<cite><?php comment_author_link() ?></cite>
					<time datetime="<?php the_time('Y-m-d') ?>"><a href="#comment-<?php comment_ID() ?>" title=""><?php the_time('j') ?><?php the_time(' F Y') ?></a></time>
				</div>
			</div><!-- /.comment-meta -->
			<div class="comment-content five-col last-col">
				<div>
					<?php comment_text() ?>
				</div>
			</div><!-- /.comment-content -->
		</li>
	<?php
		/* Changes every other comment to a different class */
		$oddcomment = ( empty( $oddcomment ) ) ? ' comment-alt' : '';
	?>
	<?php } else { $trackback = true; } /* End of is_comment statement */ ?>
	<?php endforeach; /* end for each comment */ ?>
	</ol>
<?php if ($trackback == true) { ?>
	<div id="post-trackbacks" class="container<?php if (get_comments_number()==0) { echo ' no-comments'; } ?>">
		<h3>Trackbacks</h3>
			<ol class="no-bullets">
			<?php foreach ($comments as $comment) : ?>
				<?php $comment_type = get_comment_type(); ?>
				<?php if($comment_type != 'comment') { ?>
				<li><?php comment_author_link() ?></li>
				<?php } ?>
			<?php endforeach; ?>
			</ol>
	</div>
<?php } ?>	
 <?php else : // this is displayed if there are no comments so far ?>
	<?php if ('open' == $post->comment_status) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. 		<p class="no-comments">Comments are closed.</p>
		-->

	<?php endif; ?>
<?php endif; ?>

<?php if ('open' == $post->comment_status) : ?>

<h3 id="respond">Add your comment</h3>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p>
<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="comment-form">
<fieldset>
<ul class="no-bullets">
<?php if ( $user_ID ) : ?>
	<li><p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">Log out &raquo;</a></p></li>

<?php else : ?>

	<li>
		<label for="author">Your name <?php if ($req) echo "(required)"; ?></label>
		<input class="text" type="text" name="author" autocorrect="on" autocapitalize="on" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="6" <?php if ($req) echo "aria-required='true'"; ?> />
	</li>
	<li>
		<label for="email">Your email <?php if ($req) echo "(required)"; ?></label>
		<input class="text" type="email" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="7" <?php if ($req) echo "aria-required='true'"; ?> />
	</li>
	<li>
		<label for="url">Your website</label>
		<input class="text" type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="8" />
	</li>
<?php endif; ?>
	<li>
		<label for="comment">Your comment <?php if ($req) echo "(required)"; ?></label>
		<textarea name="comment" id="comment" cols="20" rows="10" tabindex="9"></textarea>
	</li>
	<!-- <li><p><strong>XHTML:</strong> You can use these tags: <code><?#php echo allowed_tags(); ?></code></p></li> -->
	<li>
		<button name="submit" type="submit" id="submit" tabindex="10">Submit your comment</button>
		<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
	</li>
</ul>
<div><?php do_action('comment_form', $post->ID); ?></div>
</fieldset>
</form>

<?php endif; // If registration required and not logged in ?>
<?php endif; // end if ($comments) - if you delete this the sky will fall on your head ?>
</div><!-- /#comments -->
