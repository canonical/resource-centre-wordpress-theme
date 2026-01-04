<?php
/*
Template Name: Authors Page
*/

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

// Get all users order by amount of posts
$allUsers = get_users('orderby=post_count&order=DESC');

$users = array();

// Remove subscribers from the list as they won't write any articles
foreach($allUsers as $currentUser)
{
	if(!in_array( 'author',  $currentUser->roles ))
	{
		$users[] = $currentUser;
	}
}

?>

<?php get_header(); ?>

<div class="row no-border">
	<div class="inner-wrapper">
		<div class="eight-col">
		<ul>
		<h1><?php
			printf(the_title());
			foreach($users as $user)
			{
				?></h1>
				<li class="author">
					<div class="authorAvatar">
				<?php if(get_the_author_meta('user_photo', $user->ID)) : ?>
				<span class="image-wrap avatar" style="width: auto; height: auto;"><img src="<?php bloginfo('url'); ?><?php echo $user->user_photo; ?>" alt="<?php echo $user->first_name; ?>'s photo" class="avatar photo" width="156" height="156" /></span>
				<?php else : ?>
				<?php endif; ?>
					</div>
					<div class="author-info">
						<h2 class="author-name"><a href="<?php echo get_author_posts_url( $user->ID ); ?>"><?php echo $user->first_name; ?> <?php echo $user->last_name; ?></a></h2>
						<p class="author-descrption"><?php echo get_user_meta($user->ID, 'description', true); ?></p>
	
						<p class="social-icons">
							<ul>
								<?php
									$website = $user->user_url;
									if($user->user_url != '')
									{
										printf('<li><a href="%s">%s</a></li>', $user->user_url, 'Website');
									}
	
									$twitter = get_user_meta($user->ID, 'twitter_profile', true);
									if($twitter != '')
									{
										printf('<li><a href="%s">%s</a></li>', $twitter, 'Twitter');
									}
	
									$facebook = get_user_meta($user->ID, 'facebook_profile', true);
									if($facebook != '')
									{
										printf('<li><a href="%s">%s</a></li>', $facebook, 'Facebook');
									}
	
									$google = get_user_meta($user->ID, 'google_profile', true);
									if($google != '')
									{
										printf('<li><a href="%s">%s</a></li>', $google, 'Google');
									}
	
									$linkedin = get_user_meta($user->ID, 'linkedin_profile', true);
									if($linkedin != '')
									{
										printf('<li><a href="%s">%s</a></li>', $linkedin, 'LinkedIn');
									}
								?>
							</ul>
						</p>
					</div>
				</li>
				<?php
			}
		?>
		</ul>
		</div><!-- /.eight-col -->
	</div><!-- /.inner-wrapper -->
</div><!-- /.row -->
<?php get_footer(); ?>