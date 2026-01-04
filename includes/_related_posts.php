<div class="box eight-col box-highlight related-posts clearfix">
<h2>You may also be interested in:</h2>
<ul class="list clearfix no-bullets no-margin-bottom">
<?php
wp_reset_query();
$max_articles = 4;  // How many articles to display
$tags = wp_get_post_tags($post->ID);
$cnt = 0;

if ($tags) :
	$tag_ids = array();
	$cat_id = get_cat_ID('downloads');

foreach($tags as $individual_tag) $tag_ids[0] = $individual_tag->term_id;

$args=array(
	'category__not_in' => array($cat_id),
	'tag__in' => $tag_ids,
	'post__not_in' => array($post->ID),
	'showposts'=> $max_articles, // Number of related posts that will be shown.
	'caller_get_posts'=> 1
	// unhide these to order by most viewed
	//'meta_key' => 'post_views_count',
  //'orderby' => 'meta_value_num'
);
$my_query = new wp_query($args);
if( $my_query->have_posts() ) :
	while ($my_query->have_posts()) :
		$my_query->the_post();
	$cnt++;
?>
 <li class="eight-col has-time">
  <h3><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3> 
  <div class="article-meta eight-col">
    <p>By <a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>" title="View <?php if(get_the_author_meta('first_name',$uid)): ?><?php the_author_meta('first_name',$uid); ?><?php else : ?><?php the_author_meta('display_name',$uid); ?><?php endif; ?>'s bio and posts"><span><?php the_author_meta('first_name',$uid); ?> <?php the_author_meta('last_name',$uid); ?></span></a> on 
  	 <time datetime="<?php the_time('Y-m-d') ?>" ><?php the_time('j') ?><?php the_time(' F Y') ?></time></p>
  </div>
	 <p><?php echo get_excerpt(); ?></p>
	 <?php get_template_part("includes/_post_cats"); ?>
	 </li>
 <?php
endwhile;	// have_posts
endif;	 	// have_posts
endif; 		// tags

if ($cnt < $max_articles) :
	$categories = get_the_category($post->ID);
if ( $categories ) :
	$categories = array();
	$cat_id = get_cat_ID('downloads');
foreach($categories as $individual_category) $category_ids[0] = $individual_category->term_id;

$args=array(
	'category__in' => $category_ids,
	'category__not_in' => array($cat_id),
	'post__not_in' => array($post->ID),
	'showposts'=> $max_articles, // Number of related posts that will be shown.
	'caller_get_posts'=> 1
	// unhide these to order by most viewed
	//'meta_key' => 'post_views_count',
  //'orderby' => 'meta_value_num'
);
$my_query = new wp_query($args);
if( $my_query->have_posts() ) :
	while ($my_query->have_posts()) :
		$my_query->the_post();
	$cnt++;
if ($cnt > $max_articles) break;
?>
 <li class="eight-col has-time">
	 <h3><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
  <p class="article-meta eight-col">
  	 By <a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>" title="View <?php if(get_the_author_meta('first_name',$uid)): ?><?php the_author_meta('first_name',$uid); ?><?php else : ?><?php the_author_meta('display_name',$uid); ?><?php endif; ?>'s bio and posts"><span><?php the_author_meta('first_name',$uid); ?> <?php the_author_meta('last_name',$uid); ?></span></a> on 
  	 <time datetime="<?php the_time('Y-m-d') ?>" ><?php the_time('j') ?><?php the_time(' F Y') ?></time>
  </p>
	 <p><?php echo get_excerpt(); ?></p>
	 <?php get_template_part("includes/_post_cats"); ?>
 </li>
 <?php
endwhile; // have_posts
endif; 		// have_posts
endif; 		// $categories
endif; 		// $cnt
wp_reset_query();
?>
</ul>
</div>
