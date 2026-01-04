<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Archive Template
 *
 *
 * @file           archive.php
 * @package        Canonical
 * @author         Canonical Web Team
 * @copyright      2012 Canonical Ltd
 * @license        license.txt
 * @version        Release: 2.0
 * @filesource     wp-content/themes/canonical/archive.php
 * @link           http://codex.wordpress.org/Theme_Development#Archive_.28archive.php.29
 * @since          available since Release 2.0
 */

get_header();
?>

<div class="row no-border">
<div class="inner-wrapper">
	<?php if (have_posts()) : ?>
    <div class="eight-col">
      <h1>Posts from <?php the_date(' F Y') ?></h1>
      <ul class="article-list infinitescroll no-bullets">
	<?php while (have_posts()) : the_post(); ?>
			<?php get_template_part("/includes/_result_list_item"); ?>
	<?php endwhile; ?>
</ul>
<?php get_template_part("includes/_pagination"); ?>
</div><!-- /.eight-col -->
<?php endif; // end have_posts ?>

<div class="four-col last-co">
  <?php get_template_part("/includes/_nav_archive"); ?>
</div><!-- /.two-col -->
</div><!-- /.inner-wrapper -->
</div><!-- /.row -->
<?php get_footer(); ?>
