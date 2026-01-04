<?php
// show custom post_types on category pages
function category_query_post_type($query) {
    if ( is_category() && false == $query->query_vars['suppress_filters'] )
      $query->set( 'post_type', array( 'whitepaper', 'post', 'video', 'attachment', 'downloads', 'casestudy', 'infographic', 'webinar', 'ebook', 'event', 'presskits' ) );
    return $query;
}
add_filter('pre_get_posts', 'category_query_post_type');

// change 'Posts' to 'Articles'
function edit_admin_menus() {  
    global $menu;  
    global $submenu;  
    $menu[5][0] = 'Articles'; // Change Posts to Articles  
    $submenu['edit.php'][5][0] = 'All articles';  
    $submenu['edit.php'][10][0] = 'Add an article';  
}  
function change_post_object_label() {
    global $wp_post_types;
    $labels = &$wp_post_types['post']->labels;
    $labels->name = 'Articles';
    $labels->singular_name = 'Article';
    $labels->add_new = 'Add an article';
    $labels->add_new_item = 'Add article';
    $labels->edit_item = 'Edit articles';
    $labels->new_item = 'Article';
    $labels->view_item = 'View articles';
    $labels->search_items = 'Search articles';
    $labels->not_found = 'No articles found';
    $labels->not_found_in_trash = 'No articles found in trash';
}
add_action( 'init', 'change_post_object_label' );
add_action( 'admin_menu', 'edit_admin_menus' );
// end change 'Posts' to 'Articles'

/*// add downloads post type
add_action('init', 'downloads');
function downloads() 
{
  $labels = array(
    'name' => _x('Downloads', 'post type general name'),
    'singular_name' => _x('Download', 'post type singular name'),
    'plural_name' => _x('Downloads', 'post type plural name'),
    'add_new' => _x('Add new', 'download'),
    'add_new_item' => __('Add new Download'),
    'view_item' => __('View download post'),
    'search_items' => __('Search downloads'),
    'css_friendly' => __('download'),
    'title_friendly' => __('download'),
    'edit_item' => __('Edit download')
  );
 
 $args = array(
		'exclude_from_search' => false,
		'rewrite' => array("slug" => "download"), // Permalinks format
		'can_export' => true,
		'capability_type' => 'post',
		'has_archive' => true,
		'hierarchical' => true,
		'labels' => $labels,
		'menu_icon' => get_stylesheet_directory_uri() . '/static/img/admin/document-text.png',
		'menu_position' => 6,
		'public' => true,
		'publicly_queryable' => true,
		'query_var' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
		'show_ui' => true, 
		'supports' => array( 'revisions', 'attachments', 'title', 'excerpt', 'editor', 'thumbnail', 'author','comments' ),    
		'taxonomies' => array('topic', 'post_tag'));
  register_post_type('downloads',$args);
}
// end add downloads post type
*/
/*
// add case study post type
add_action('init', 'post_type_casestudy');
function post_type_casestudy() 
{
  $labels = array(
    'name' => _x('Case study', 'post type general name'),
    'singular_name' => _x('Case study', 'post type singular name'),
    'plural_name' => _x('Case studies', 'post type plural name'),
    'add_new' => _x('Add New', 'casestudy'),
    'add_new_item' => __('Add New Case study'),
    'view_item' => __('View Case study post'),
    'search_items' => __('Search Case studies'),
    'css_friendly' => __('case-study'),
    'title_friendly' => __('case study'),
    'edit_item' => __('Edit Case study post')
  );
 
 $args = array(
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
 		'exclude_from_search' => false,
    'can_export' => true,
    'capability_type' => 'post',
    'has_archive' => true,
    'hierarchical' => true,
    'labels' => $labels,
    'menu_icon' => get_stylesheet_directory_uri() . '/static/img/admin/document-text.png',
    'menu_position' => 6,
    'public' => true,
    'publicly_queryable' => true,
		'rewrite' => array("slug" => "case-study"), // Permalinks format
    'query_var' => true,
    'show_ui' => true, 
    'supports' => array( 'title', 'excerpt', 'editor', 'thumbnail', 'author','comments' ),
    'taxonomies' => array('category', 'post_tag'));
  register_post_type('casestudy',$args);
}
// end add case study post type

// add ebook post type
add_action('init', 'post_type_ebook');
function post_type_ebook() 
{
  $labels = array(
    'name' => _x('E-Books', 'post type general name'),
    'singular_name' => _x('E-Book', 'post type singular name'),
    'plural_name' => _x('E-Books', 'post type plural name'),
    'add_new' => _x('Add New', 'E-book'),
    'add_new_item' => __('Add new E-book'),
    'view_item' => __('View E-book'),
    'search_items' => __('Search E-books'),
    'css_friendly' => __('e-book'),
    'title_friendly' => __('e-book'),
    'edit_item' => __('Edit E-book')
  );
 
 $args = array(
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
 		'exclude_from_search' => false,
    'can_export' => true,
    'capability_type' => 'post',
    'has_archive' => true,
    'hierarchical' => true,
    'labels' => $labels,
    'menu_icon' => get_stylesheet_directory_uri() . '/static/img/admin/document-text.png',
    'menu_position' => 6,
    'public' => true,
    'publicly_queryable' => true,
    'query_var' => true,
    'show_ui' => true, 
    'supports' => array( 'revisions', 'attachments', 'title', 'excerpt', 'editor', 'thumbnail', 'author','comments' ),
    'taxonomies' => array('category', 'post_tag'));
  register_post_type('ebook',$args);
}
// end add ebook post type
*/

// add events post type
add_action('init', 'post_type_event');
function post_type_event() 
{
  $labels = array(
    'name' => _x('Events', 'post type general name'),
    'singular_name' => _x('Event', 'post type singular name'),
    'plural_name' => _x('Events', 'post type plural name'),
    'add_new' => _x('Add new', 'event'),
    'add_new_item' => __('Add new event'),
    'view_item' => __('View event post'),
    'search_items' => __('Search events'),
    'css_friendly' => __('event'),
    'title_friendly' => __('event'),
    'edit_item' => __('Edit event post')
  );
 
 $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
		'show_in_nav_menus' => true,
    'query_var' => true,
    'can_export' => true,
    'taxonomies' => array('category', 'post_tag'),
    'capability_type' => 'post',
    'hierarchical' => true,
    'menu_position' => 5,
    'comments' => true,
    'has_archive' => true,
    'menu_icon' => get_stylesheet_directory_uri() . '/static/img/admin/calendar-day.png',
    'supports' => array( 'revisions', 'attachments', 'title', 'excerpt', 'editor', 'thumbnail', 'author','comments' ));
  register_post_type('event',$args);
}
// end add event post type

// add Product business cards post type
add_action('init', 'post_type_productbusinesscard');
function post_type_productbusinesscard() 
{
  $labels = array(
    'name' => _x('Product business cards', 'post type general name'),
    'singular_name' => _x('Product business card', 'post type singular name'),
    'add_new' => _x('Add new', 'product business card'),
    'add_new_item' => __('Add new product business card'),
    'view_item' => __('View product business card'),
    'search_items' => __('Search product business cards'),
    'css_friendly' => __('product-business-card'),
    'title_friendly' => __('product business card'),
    'edit_item' => __('Edit product business card')
  );
 
 $args = array(
    'labels' => $labels,
    'public' => false,
    'publicly_queryable' => true,
 		'exclude_from_search' => true,
    'show_ui' => true, 
		'show_in_nav_menus' => true,
    'query_var' => true,
    'can_export' => true,
    'taxonomies' => array('category', 'post_tag'),
    'capability_type' => 'post',
    'hierarchical' => true,
    'menu_position' => 10,
    'has_archive' => true,
    'menu_icon' => get_stylesheet_directory_uri() . '/static/img/admin/document-text.png',
    'supports' => array( 'revisions', 'attachments', 'title', 'excerpt', 'editor', 'thumbnail', 'author','comments' ));
  register_post_type('productbusinesscard',$args);
}
// end add productbusinesscard post type

// add topic cta post type
add_action('init', 'post_type_topiccta');
function post_type_topiccta() 
{
  $labels = array(
    'name' => _x('Topic cta', 'post type general name'),
    'singular_name' => _x('Topic cta', 'post type singular name'),
    'add_new' => _x('Add new', 'topic cta'),
    'add_new_item' => __('Add new topic cta'),
    'view_item' => __('View topic cta'),
    'search_items' => __('Search topic ctas'),
    'css_friendly' => __('topic-cta'),
    'title_friendly' => __('topic cta'),
    'edit_item' => __('Edit topic cta')
  );
 
 $args = array(
    'labels' => $labels,
    'public' => false,
    'publicly_queryable' => true,
    'show_ui' => true, 
		'show_in_nav_menus' => true,
    'query_var' => true,
    'can_export' => true,
    'taxonomies' => array('category', 'post_tag'),
    'capability_type' => 'post',
    'hierarchical' => true,
    'menu_position' => 10,
    'has_archive' => true,
    'menu_icon' => get_stylesheet_directory_uri() . '/static/img/admin/document-text.png',
    'supports' => array( 'revisions', 'attachments', 'title', 'excerpt', 'editor', 'thumbnail', 'author','comments' ));
  register_post_type('topiccta',$args);
}
// end add topiccta post type

/*
// add press kit post type
add_action('init', 'post_type_presskits');
function post_type_presskits() 
{
  $labels = array(
    'name' => _x('Press kits', 'post type general name'),
    'singular_name' => _x('Press kit', 'post type singular name'),
    'plural_name' => _x('Press kits', 'post type plural name'),
    'add_new' => _x('Add New', 'Press kits'),
    'add_new_item' => __('Add new press kit'),
    'view_item' => __('View press kits'),
    'search_items' => __('Search press kits'),
    'css_friendly' => __('press-kits'),
    'title_friendly' => __('press-kit'),
    'edit_item' => __('Edit press kits')
  );
 
 $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
		'show_in_nav_menus' => true,
    'query_var' => true,
    'can_export' => true,
    'taxonomies' => array('category', 'post_tag'),
    'capability_type' => 'post',
    'hierarchical' => true,
    'menu_position' => 7,
    'has_archive' => true,
    'menu_icon' => get_stylesheet_directory_uri() . '/static/img/admin/document-text.png',
    'supports' => array( 'revisions', 'attachments', 'title', 'excerpt', 'editor', 'thumbnail', 'author','comments' ));
  register_post_type('presskits',$args);
}
// end add press kit post type

// add video post type
add_action('init', 'post_type_video');
function post_type_video() 
{
  $labels = array(
    'name' => _x('Videos', 'post type general name'),
    'singular_name' => _x('Video', 'post type singular name'),
    'plural_name' => _x('Videos', 'post type plural name'),
    'add_new' => _x('Add New', 'video'),
    'add_new_item' => __('Add New Video post'),
    'view_item' => __('View Video'),
    'search_items' => __('Search Videos'),
    'css_friendly' => __('video'),
    'title_friendly' => __('video'),
    'edit_item' => __('Edit Video post')
  );
 
 $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
		'show_in_nav_menus' => true,
    'show_ui' => true, 
    'query_var' => true,
    'can_export' => true,
    'taxonomies' => array('category', 'post_tag'),
    'capability_type' => 'post',
    'hierarchical' => true,
    'menu_position' => 9,
    'has_archive' => true,
    'menu_icon' => get_stylesheet_directory_uri() . '/static/img/admin/film.png',
    'supports' => array( 'revisions', 'attachments', 'title', 'excerpt', 'editor', 'thumbnail', 'author','comments' ));
  register_post_type('video',$args);
 
}
// end add video post type
*/

// add webinar post type
add_action('init', 'post_type_webinar');
function post_type_webinar() 
{
  $labels = array(
    'name' => _x('Webinar', 'post type general name'),
    'singular_name' => _x('Webinar', 'post type singular name'),
    'plural_name' => _x('Webinars', 'post type plural name'),
    'add_new' => _x('Add New', 'webinar'),
    'add_new_item' => __('Add New Webinar'),
    'view_item' => __('View Webinar'),
    'search_items' => __('Search Webinars'),
    'css_friendly' => __('webinar'),
    'title_friendly' => __('webinar'),
    'edit_item' => __('Edit Webinar')
  );
 
 $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_nav_menus' => true,
    'query_var' => true,
    'can_export' => true,
    'taxonomies' => array('category', 'post_tag'),
    'capability_type' => 'post',
    'hierarchical' => true,
    'menu_position' => 6,
    'has_archive' => true,
    'menu_icon' => get_stylesheet_directory_uri() . '/static/img/admin/film.png',
    'supports' => array( 'revisions', 'attachments', 'title', 'excerpt', 'editor', 'thumbnail', 'author','comments' ));
  register_post_type('webinar',$args);
 
}
// end add webinar post type

/*
// add white paper post type
add_action('init', 'post_type_whitepaper');
function post_type_whitepaper() 
{
  $labels = array(
    'name' => _x('White paper', 'post type general name'),
    'singular_name' => _x('White paper', 'post type singular name'),
    'plural_name' => _x('White papers', 'post type plural name'),
    'add_new' => _x('Add New', 'white paper'),
    'add_new_item' => __('Add New White paper'),
    'view_item' => __('View White paper'),
    'search_items' => __('Search White papers'),
    'css_friendly' => __('white-paper'),
    'title_friendly' => __('white paper'),
    'edit_item' => __('Edit White paper')
  );
 
 $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true,
		'show_in_nav_menus' => true,
    'query_var' => true,
    'can_export' => true,
    'taxonomies' => array('category', 'post_tag'),
		'capability_type' => 'post',
    'hierarchical' => true,
    'menu_position' => 6,
    'has_archive' => true,
    'menu_icon' => get_stylesheet_directory_uri() . '/static/img/admin/document-pdf-text.png',
    'supports' => array( 'revisions', 'attachments', 'title', 'excerpt', 'editor', 'thumbnail', 'author','comments' ));
  register_post_type('whitepaper',$args);
}
// end add whitepaper post type
*/

?>