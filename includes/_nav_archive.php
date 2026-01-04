<ul id="list-archives" class="no-bullets">
<?php
/**/
$years = $wpdb->get_col("SELECT DISTINCT YEAR(post_date) FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post' ORDER BY post_date DESC");
foreach($years as $year) :
?>
	<li class="year"><h3><a href="<?php echo get_year_link($year); ?> "><?php echo $year; ?></a></h3>

		<ul id="" class="no-bullets">
		<?	$months = $wpdb->get_col("SELECT DISTINCT MONTH(post_date) FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post' AND YEAR(post_date) = '".$year."' ORDER BY post_date DESC");
			foreach($months as $month) :
			?>
			<li><a href="<?php echo get_month_link($year, $month); ?>"><?php echo date( 'F', mktime(0, 0, 0, $month) );?>
			<?php $monthly_posts = query_posts("year=".$year."&monthnum=".$month."&order=DESC");
				  $post_count = count($monthly_posts);
			?>
(<?php if($post_count >= 1) { echo $post_count.''; } wp_reset_query(); ?>)</a></li>
			<?php endforeach;?>
		</ul>
	</li>
<?php endforeach; ?>
</ul>