<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */
$key = wp_specialchars($s, 1); 
$search_title = ('Search results for "' . $key . '"');
$category = get_the_category(); 
$press_cats = array('press-releases', 'news');
if (isset($_GET['termlist']) && is_array($_GET['termlist']) OR isset($_GET['topiclist']) && is_array($_GET['topiclist'])) : $hasFilter = '1'; endif;
include("header.php");
?>
<div class="row row-hero no-border<?php if ($hasFilter) : ?> has-filter-wrap<?php else : ?> no-filter-wrap<?php endif; ?>">
<div class="inner-wrapper">
	<h1>We've found <?php echo $wp_query->found_posts; ?> <?php echo _n( 'result', 'results', $count, 'ubuntu-resources' ); ?> for "<?php /* Search Count */ 
		global $post;
		if( is_category() ){
			$category = end(get_the_category());
			$current =$category->cat_ID;
			$current_name = $category->cat_name;
		}
		if( is_tax() ){
			$term = end(get_the_terms($post->ID, 'topic'));
			$current_term =$term->cat_ID;
			$current_term_name = $term->name;
		}
		$key = wp_specialchars($s, 1); 
		$count = $wp_query->found_posts; _e('');
		 _e(''); 
		 echo $key; _e('');
		 if ( $current_name ) {
			 //echo '&nbsp;';
			 //echo strtolower($current_name); 
		 }
	?>&nbsp;"<?php if ( $count == "0") : echo ', try a different search?'; endif; ?>
	</h1>
		
<form id="search-form" method="get" action="<?php bloginfo('url'); ?>">
<input type="search" name="s" value="<?php echo wp_specialchars($s, 1); ?>" placeholder="search&hellip;" maxlength="50" required="required" />

<div class="search-filter<?php if ( $count == "0") : echo ' no-results'; endif; ?>">
<h2>Filter your search results</h2>
<div class="search-inner <?php if ($hasFilter) : ?> has-filter<?php endif; ?>">
	<fieldset class="four-col">
	<h3>By topic</h3>
	<ul class="no-bullets search-filters">
	<?php
	// generate list of topics
	$exclude = get_cat_id('TV');
	$post_ancestors = ($post->ancestors) ? $post->ancestors : array();
	$gb = ($_GET['topiclist']);
	$terms = wp_get_post_terms( $post->ID, 'topic');
	$topics = get_terms('topic',array( 'taxonomy' => 'topic', 'exclude' => $exclude, 'hide_empty' => 1 ));
	foreach ($topics as $topic) :
	  echo
			'<li><label>',
			'<input type="checkbox" name="topiclist[]" value="',  $topic->slug, '"   '?>
			<?php if (isset($_GET['topiclist']) && is_array($_GET['topiclist'])) : ?>
			<?php	if (in_array($topic->slug, $gb)) { echo ' checked'; } ?>
			<?php endif ; ?>
			<?php echo '/>' ?>
			<?php echo $topic->name; '</label></li>' ?>
	<?php endforeach;
	?>
	</ul>
	</fieldset>
	
	<fieldset class="four-col last-col">
	<h3>By type</h3>
	<ul class="no-bullets search-filters">
	<?php
	// generate list of types
	$exclude = get_cat_id('Product business card');
	$o = '';
	$o = ($_GET['termlist']);
	$cats = get_categories(array('exclude' => $exclude, 'taxonomy' => 'category', 'hide_empty' => 1, 'hierarchical' => 0, 'parent' => 0));
	//echo '<li><label><input type="checkbox" value="0" id="SelectAll">Select all</label></li>';
	foreach ($cats as $cat) :
	  echo
			'<li><label>',
			'<input type="checkbox" name="termlist[]" value="',  $cat->slug, '"   '?>
			<?php if (isset($_GET['termlist']) && is_array($_GET['termlist'])) : ?>
			<?php	if (in_array($cat->slug, $o)) { echo ' checked'; } ?>
			<?php endif ; ?>
			<?php echo '/>' ?>
			<?php echo $cat->name; '</label></li>' ?>
		 
	<?php endforeach;
	?>
	</ul>
	</fieldset>
</div>

<fieldset class="twelve-col">
<button class="search-submit" type="submit">Update results</button>
<?php if ($hasFilter) : ?><a href="<?php bloginfo('url'); ?>?s=<?php echo wp_specialchars($s, 1); ?>">Remove filters</a><?php endif; ?>
<!-- <button type="submit">Reset</button> -->
</fieldset>
</div>
</form>

</div><!-- /.inner-wrapper --> 
</div><!-- /.row -->

<div class="no-margin-bottom">
	<?php if (have_posts()) : ?>
	<ul class="article-list infinitescroll no-bullets">
		<?php while (have_posts()) : the_post(); ?>
<?php if ( is_search() ) : ?>
<?php $title = get_the_title(); $keys= explode(" ",$s); $title = preg_replace('/('.implode('|', $keys) .')/iu', '<strong class="search-term">\0</strong>', $title); ?>
<?php $excerpt = get_the_excerpt(); $keys= explode(" ",$s); $excerpt = preg_replace('/('.implode('|', $keys) .')/iu', '<strong class="search-term">\0</strong>', $excerpt); ?>
<?php endif; ?>				
					<li class="row article"> 
					<div class="inner-wrapper">
					<div class="eight-col no-margin-bottom<?php if(in_category( $press_cats )) echo ' has-time'; ?>">
					<?php if ('event' == get_post_type()) : ?>
						<?php get_template_part("includes/_event_meta"); ?>
					<?php else : ?>
						<?php get_template_part("content_home_featured"); ?>	
					<?php endif ; ?>
					</div>
						</div>
						</li>		
					<?php endwhile; ?>
		</ul>
	<?php get_template_part("includes/_pagination"); ?>
</div>
	<?php endif; // end have_posts ?>
	
<?php get_footer(); ?>