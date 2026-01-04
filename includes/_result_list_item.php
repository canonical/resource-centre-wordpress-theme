									<li class="article">
									<div class="eight-col<?php if(in_category( $press_cats )) echo ' has-time'; ?>">
									<?php if ('event' == get_post_type()) : ?>
										<?php get_template_part("includes/_event_meta"); ?>
									<?php else : ?>
										<?php get_template_part("content_home_featured"); ?>
									<?php endif ; ?>
										</div>
										</li>
