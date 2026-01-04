<?php
$current_tax = basename(get_permalink());    
?>
    <ul class="main-nav topic-nav no-bullets">
    <li class="nav-cloud-and-server<?php if ( $current_tax == "cloud-and-server" ) : echo ' active'; endif; ?>"><a href="<?php echo get_site_url(); ?>/cloud-and-server/">Cloud and server</a></li>
    <li class="nav-iot<?php if ( $current_tax == "internet-of-things" ) : echo ' active'; endif; ?>"><a href="<?php echo get_site_url(); ?>/internet-of-things/">IoT</a></li>
    <li class="nav-desktop<?php if ( $current_tax == "desktop" ) : echo ' active'; endif; ?>"><a href="<?php echo get_site_url(); ?>/desktop/">Desktop</a></li>
    <li class="nav-press-center<?php if ( $current_tax == "press-center" ) : echo ' active'; endif; ?>"><a href="<?php echo get_site_url(); ?>/press-centre/">Press centre</a></li>
</ul>

<form class="header-search" method="get" action="<?php bloginfo('url'); ?>/">
	<label class="off-left" for="s"><?php _e('Search:'); ?></label>
	<input class="form-text" type="search" autocomplete="off" placeholder="Search" name="s" id="s" />
  <button type="submit"><img src="//assets.ubuntu.com/sites/ubuntu/1218/u/img/search-white.svg" alt="Search" height="28" /></button>
</form>