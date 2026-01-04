<?php
$post_type = get_post_type_object( get_post_type($post));
$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
$cat_desc = get_category(get_query_var('cat'))->category_description;
$category = basename(get_permalink());
$current_tax = basename(get_permalink());
$the_category = get_category_by_slug($current_tax);
$get_page_name = basename(get_permalink());
$key = wp_specialchars($s, 1); 
$search_title = ('Search results for "' . $key . '"');
$cat_plural = get_tax_meta($the_category,'ba_plural');
global $wpdb;
global $posted;
?>
	<h2 class="off-left">Share<?php if(is_single() ) : ?> or save<?php endif; ?></h2>
	<ul class="list-social no-bullets">
		<li>
			<a id="item-facebook" href="http://www.facebook.com/sharer.php?s=100&amp;p[url]=<?php if(is_single() ) : ?><?php echo urlencode( the_permalink( $post->ID ) ); ?>
			&amp;p[title]=<?php echo urlencode(the_title()); ?>&amp;p[summary]=<?php echo urlencode(get_excerpt()); ?>&amp;p[images][0]=<?php $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 300,300 ), false, '' ); echo $src[0]; ?><?php elseif(is_home() ): ?><?php echo "http://" . $_SERVER['HTTP_HOST']  . $_SERVER['REQUEST_URI']; ?>&amp;t=Hello<?php elseif( is_page() ) : ?><?php echo "http://" . $_SERVER['HTTP_HOST']  . $_SERVER['REQUEST_URI']; ?>&amp;p[summary]=Visit%20the%20%27<?php echo basename(get_permalink()); ?>%27%20section%20on%20the%20Ubuntu%20Insights%20website<?php elseif (is_search()) : ?><?php echo "http://" . $_SERVER['HTTP_HOST']  . $_SERVER['REQUEST_URI']; ?>&amp;p[summary]=Ubuntu%20Insights%20website&amp;p[summary]=I've%20just%20searched%20for%20%27<?php /* Search Count */ $key = wp_specialchars($s, 1); echo $key; _e(''); ?>%27%20on%20the%20Ubuntu%20Insights%20website%20and%20thought%20I%20would%20share%20the%20results<?php else : ?><?php echo "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>&amp;p[title]=Ubuntu%20Insights%20website<?php endif ; ?>">Facebook</a>	
		</li>
		<li>
			<a id="item-twitter" class="" href="http://twitter.com/share?text=<?php if(is_single() ) : ?><?php echo urlencode(the_title()); ?><?php elseif(is_home() ): ?>Ubuntu%20Insights<?php elseif( is_page() ) : ?>See%20all%20<?php if($cat_plural == '') : ?><?php echo $get_page_name; ?>%20resources<?php else : ?><?php echo $cat_plural; ?><?php endif ; ?>%20on%20Ubuntu%20Insights<?php elseif (is_search()) : ?>I've%20just%20searched%20for%20%27<?php /* Search Count */  $key = wp_specialchars($s, 1); echo $key; _e(''); ?>%27%20on%20the%20Ubuntu%20Insights%20website%20and%20thought%20I'd%20share%20the%20results.%20Check%20them%20out:<?php else : ?>Ubuntu%20Insights%20website<?php endif ; ?>&amp;url=<?php if(is_single() ) : ?><?php echo urlencode( wp_get_shortlink( $post->ID ) ); ?><?php else : ?><?php echo "http://" . $_SERVER['HTTP_HOST']  . $_SERVER['REQUEST_URI']; ?><?php endif; ?>&amp;hashtags=ubuntu" title="Share on Twitter" rel="nofollow">Twitter</a>
		</li>
		<li><?php // no need for any if else nonse for G+ as it uses the data on the page  ?>
			<a id="item-google" class="" href="https://plus.google.com/share?url=<?php if(is_single() ) : ?><?php urlencode(the_permalink()); ?><?php else : ?><?php echo "http://" . $_SERVER['HTTP_HOST']  . $_SERVER['REQUEST_URI']; ?><?php endif; ?>">Google+</a>	
		</li>
		<li>
			<a id="item-email" class="" title="Share '<?php the_title(); ?>' via Email" href="mailto:?subject=Saw%20this%20and%20thought%20of%20you&amp;body=
			<?php if(is_single() ) : ?>I've%20just%20read%20%27<?php echo str_replace( "&#038;", "%26", get_the_title() ); ?>%27%20on%20the%20Ubuntu%20Insights%20website%20and%20thought%20you%20would%20like%20it.%20Check%20it%20out:%20<?php the_permalink(); ?><?php elseif( is_page() ) : ?>Thought%20you%20would%20like%20to%20see%20<?php if($cat_plural == '') : ?><?php echo $get_page_name; ?>%20resources<?php else : ?><?php echo $cat_plural; ?><?php endif ; ?>%20on%20the%20Ubuntu%20Insights%20website.%20Check%20it%20out:%20<?php echo "http://" . $_SERVER['HTTP_HOST']  . $_SERVER['REQUEST_URI']; ?><?php elseif(is_home() ): ?>I've%20just%20visited%20the%20Ubuntu%20Insights%20website%20and%20thought%20you%20would%20like%20it.%20Check%20it%20out:%20<?php bloginfo('url'); ?><?php elseif (is_search()) : ?>I've%20just%20searched%20for%20%27<?php /* Search Count */ $ $key = wp_specialchars($s, 1);  echo $key; _e(''); ?>%27%20on%20the%20Ubuntu%20Insights%20website%20and%20thought%20I'd%20share%20the%20results%20with%20you.%20Check%20them%20out:%20<?php echo "http://" . $_SERVER['HTTP_HOST']  . $_SERVER['REQUEST_URI']; ?><?php else : ?> I've%20just%20visited%20the%20%27<?php single_tag_title(); ?>%27%20section%20on%20the%20Ubuntu%20Insights%20website%20and%20thought%20you%20would%20like%20it.%20Check%20it%20out:%20<?php echo "http://" . $_SERVER['HTTP_HOST']  . $_SERVER['REQUEST_URI']; ?><?php endif; ?>">Email</a>
		</li>
		<li class="last-item">
		    <a title="Share '<?php echo urlencode(the_title()); ?>' on LinkedIn" id="item-linkedin" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo "http://" . $_SERVER['HTTP_HOST']  . $_SERVER['REQUEST_URI']; ?>&amp;title=<?php echo str_replace( "&#038;", "%26", get_the_title() ); ?>">LinkedIn</a>
		</li>
<?php if ( is_single() ) : ?>
		<li><a id="item-instapaper" href="http://www.instapaper.com/hello2?url=<?php echo urlencode( the_permalink( $post->ID ) ); ?>&amp;title=<?php echo urlencode( get_the_title() ); ?>" title="Add '<?php echo the_title(); ?>' to Instapaper">Add to Instapaper</a></li>
		<li><a id="item-pocket" href="http://getpocket.com/save?url=<?php echo urlencode( the_permalink( $post->ID ) ); ?>&amp;title=<?php echo urlencode( get_the_title() ); ?>" title="Add '<?php echo urlencode(the_title()); ?>' to Pocket">Add to Pocket</a></li>
<?php endif ; ?>
	</ul>
