<div id="tags">
<?php
$categoryID = $cat; // category ID
$blogURL = get_option('home'); // varible used for tag page link
$category_posts = new WP_query(array(
		'post_type' => array('post','company','product','any other custom post type'), //  <<--- CUSTOM POST TYPES
		'cat' => $categoryID,
		'posts_per_page' => -1
		));
if ($category_posts->have_posts()) : while ($category_posts->have_posts()) : $category_posts->the_post();
	$posttags = get_the_tags();
	if ($posttags) {
		foreach($posttags as $tag) {
			$all_tags_arr[] = array($tag->name , $tag->count, $tag->slug); // get tag name, slug and count (needed for sorting)
		}
	}

endwhile; endif;

if ($all_tags_arr) :

	function sortBySubArray($a,$b){
		return $b[1]-$a[1];
	}
	uasort($all_tags_arr, 'sortBySubArray'); //sorting descending with function usort, sort by tag count - most used tags first

	foreach ($all_tags_arr as $tag) {
			$tags[] = '<li><a href="'.$blogURL.'/tag/'.$tag[2].'">'.$tag[0].' ('.$tag[1].' ) </a></li>';
		}

	$tags_final = array_unique($tags); // remove duplicate posts
	echo '<h2>Related tags</h2><ul id="tag-list">';
	foreach ( $tags_final as $tags ) {
		echo $tags;
	}
	echo '</ul>';

endif;
?>
</div>

