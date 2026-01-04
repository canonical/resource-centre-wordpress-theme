<?php 
	$theTerms= wp_get_object_terms($post->ID, 'topic');
	$term = $theTerms[0]->slug;
	switch($term) {
		case "cloud":
		$form_id = '';
		break; 
		case "consulting":
		$form_id = '';
		break; 
		case "desktop":
		$form_id = 'd2b965d07a'; 
		break;
		case "phone":
		$form_id = '';
		break; 
		case "server":
		$form_id = '';
		break; 
		case "support":
		$form_id = '';
		break; 
		case "tablet":
		$form_id = '';
		break; 
	}
?>
<div class="subscribe row-grey clearfix">
	<h2>Subscribe to related content</h2>
	<p>Get notified when more '<?php echo $theTerms[0]->slug; ?>' content like this is available.</p>
	<form action="http://canonical.us3.list-manage.com/subscribe/post?u=56dac47c206ba0f58ec25f314&amp;id=<?php echo $form_id; ?>" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate clearfix" novalidate>
			<ul class="no-bullets">
				<li>
					<label class="off-left" for="mce-email">Your email</label>
					<span><input type="email" value="" name="email" class="email" id="mce-email" placeholder="Your email" required></span>
				</li>
				<li>
					<button name="submit" type="submit" id="submit">Subscribe</button>
				</li>
			</ul>
	</form>
</div><!-- /.subscribe --> 
