<<?php if (is_home() ) { echo 'li'; } else { echo 'div'; } ?> id="popular-posts" class="four-col box">
<h2>Popular content</h2>
<ol class="no-bullets">
<?php $pc = new WP_Query('orderby=comment_count&posts_per_page=5'); ?>
<?php while ($pc->have_posts()) : $pc->the_post(); ?>
<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
<?php endwhile; ?>
</ol>
</<?php if (is_home()) { echo 'li'; } else { echo 'div'; } ?>><!-- /#popular-posts -->
