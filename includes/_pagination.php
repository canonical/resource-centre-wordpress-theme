<?php 
	$prev_link = get_previous_posts_link(__('&laquo; Older Entries'));
	$next_link = get_next_posts_link(__('Newer Entries &raquo;'));
	
	if ($prev_link || $next_link) {?>
<div class="navigation clearfix">
	<ul class="no-bullets no-margin-bottom">
		<li class="nav-previous"><?php next_posts_link('Older Entries') ?></li>
		<li class="nav-next"><?php previous_posts_link('Newer Entries') ?></li>
	</ul>
</div><!-- /.navigation -->
<?php } ?>

