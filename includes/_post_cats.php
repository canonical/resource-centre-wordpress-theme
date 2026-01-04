<ul class="no-bullets clearfix inline smaller">
<?php $category = get_the_category();
echo '<li><a href="/'.$category[0]->slug.'">'.$category[0]->cat_name.'</a></li>';
?>

<?php $terms = get_the_terms( $post->ID , 'group' );
if ($terms) :
	foreach( $terms as $term ) :
		echo '<li><a href="/'.$term->slug. '">'.$term->name.'</a></li>';
	unset($term);
endforeach;
endif;
?>
</ul>
