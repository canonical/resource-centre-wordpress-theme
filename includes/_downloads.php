<?php $attachments = get_children( array('post_parent' => get_the_ID(), 'post_type' => 'attachment') ); if ( $attachments ) : ?>
<div class="box box-highlight press-release-downloads four-col clearfix">
<h2>Downloads</h2>
<?php
	$args = array( 'post_type' => 'attachment', 'orderby' => 'menu_order', 'order' => 'ASC','post_status' => null, 'numberposts' => null, 'post_parent' => $post->ID );

	$attachments = get_posts($args);
	if ($attachments) : ?>
	<ul class="no-bullets">
	<?php	foreach ( $attachments as $attachment ) :
			$alt = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);
			$image_title = $attachment->post_title;
			$caption = $attachment->post_excerpt;
			$bytes = filesize(get_attached_file($attachment->ID));
			$mimetype = $attachment->post_mime_type;
			$type = friendly_mime( $mimetype );
			$description = $attachment->post_content; ?>
		<li><a href="<?php echo wp_get_attachment_url( $attachment->ID); ?>"><?php echo $description; echo '&nbsp;[', $type, '&nbsp;', size_format($bytes), ']'; ?>&nbsp;&rsaquo;</a></li>
<?php endforeach; ?>
</ul>
<?php endif; // end $attachments ?>
</div><!-- /.press-release-downloads -->
<?php endif; // $attachments ?>
