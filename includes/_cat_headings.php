<div class="row single-post-cats">
	<h2 class="accessibility-aid">Posted in:</h2>
		<?php if(is_single() ) : ?>
			<ul class="no-bullets clearfix inline smaller">
            <?php
				$category = get_the_category(); 
				echo '<li><a href="/'.$category[0]->slug.'">'.$category[0]->cat_name.'</a></li>';
			?>
            <?php
				// Get terms for post
				$terms = get_the_terms( $post->ID , array('group') );
				if ($terms) :
					foreach( $terms as $term ) :
						echo '<li><a href="/' .$term->slug. '"> ' .$term->name. '</a></li>';
					unset($term);
				endforeach;
				endif;
            ?>
				
            <?php
				// Get terms for post
				$terms = get_the_terms( $post->ID , 'download-type' );
				if ($terms) :
					foreach( $terms as $term ) :
						echo '<li><a href="/category/downloads/?download-type=' .$term->slug. '"> '.$term->name.'</a></li>';
					unset($term);
				endforeach;
				endif;
            ?>
            <?php
                $tags = get_the_tags($post_id);
                if ($tags) :
                	foreach( $tags as $tag ) :
                		echo '<li><a href="/tag/' .$tag->slug. '">' .$tag->name. '</a></li>';
                	unset($tag);
                endforeach;
                endif;
            ?>
			</ul>
		<?php elseif ( is_home() || is_page( 'Webinars' ) || is_author() || is_search() ) : ?>
		<?php else : ?>
			<?php $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); ?> <span><?php single_cat_title(); ?></span>
		<?php endif; ?>
</div>