<div class="box box-highlight press-release-videos four-col clearfix">
<h2>Videos</h2>
<?php $postVideos = explode(',',get_post_meta($post->ID, 'postVideo', TRUE));

	if($postVideos) : ?>
	<ul class="no-bullets">
<?php foreach ( $postVideos as $postVideo ) : 
	$url = "https://www.youtube.com/watch?v=$postVideo";
	$youtube = "https://www.youtube.com/oembed?url=".urlencode($url)."&format=json";
	$json = json_decode(file_get_contents($youtube));
?>
		<li>
			<h3><?php echo $json->title; ?></h3>
			<div class="video-wrapper">
			<?php echo $json->html; ?>
			</div>
			<p>Embed code</p>
			<code>
			&lt;iframe width="560" height="315" src="http://www.youtube.com/embed/<?php echo $postVideo; ?>" frameborder="0" allowfullscreen&gt;&lt;/iframe&gt;
			</code>
		</li>
<?php endforeach; ?>
	</ul>
<?php endif; ?>
</div><!-- /.press-release-videos -->