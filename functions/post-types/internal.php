<?php
/**
 * Internal Custom Post Types (not public-facing)
 *
 * @package ResourceCentre
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Product Business Card post type
 */
function rc_register_productbusinesscard_post_type() {
	$labels = array(
		'name'               => _x( 'Product business cards', 'post type general name', 'resource-centre' ),
		'singular_name'      => _x( 'Product business card', 'post type singular name', 'resource-centre' ),
		'add_new'            => _x( 'Add new', 'product business card', 'resource-centre' ),
		'add_new_item'       => __( 'Add new product business card', 'resource-centre' ),
		'edit_item'          => __( 'Edit product business card', 'resource-centre' ),
		'new_item'           => __( 'Add new product business card', 'resource-centre' ),
		'view_item'          => __( 'View product business card', 'resource-centre' ),
		'search_items'       => __( 'Search product business cards', 'resource-centre' ),
		'not_found'          => __( 'No product business cards found', 'resource-centre' ),
		'not_found_in_trash' => __( 'No product business cards found in trash', 'resource-centre' ),
	);

	$args = array(
		'labels'              => $labels,
		'public'              => false,
		'publicly_queryable'  => true,
		'exclude_from_search' => true,
		'show_ui'             => true,
		'show_in_nav_menus'   => true,
		'show_in_rest'        => false,
		'query_var'           => true,
		'rewrite'             => array( 'slug' => 'product-business-card' ),
		'capability_type'     => 'post',
		'hierarchical'        => true,
		'has_archive'         => true,
		'menu_position'       => 10,
		'menu_icon'           => get_stylesheet_directory_uri() . '/static/img/admin/document-text.png',
		'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'author', 'comments', 'revisions' ),
		'taxonomies'          => array( 'category', 'post_tag' ),
	);

	register_post_type( 'productbusinesscard', $args );
}
add_action( 'init', 'rc_register_productbusinesscard_post_type' );

/**
 * Register Topic CTA post type
 */
function rc_register_topiccta_post_type() {
	$labels = array(
		'name'               => _x( 'Topic CTA', 'post type general name', 'resource-centre' ),
		'singular_name'      => _x( 'Topic CTA', 'post type singular name', 'resource-centre' ),
		'add_new'            => _x( 'Add new', 'topic cta', 'resource-centre' ),
		'add_new_item'       => __( 'Add new topic CTA', 'resource-centre' ),
		'edit_item'          => __( 'Edit topic CTA', 'resource-centre' ),
		'new_item'           => __( 'Add new topic CTA', 'resource-centre' ),
		'view_item'          => __( 'View topic CTA', 'resource-centre' ),
		'search_items'       => __( 'Search topic CTAs', 'resource-centre' ),
		'not_found'          => __( 'No topic CTAs found', 'resource-centre' ),
		'not_found_in_trash' => __( 'No topic CTAs found in trash', 'resource-centre' ),
	);

	$args = array(
		'labels'              => $labels,
		'public'              => false,
		'publicly_queryable'  => true,
		'exclude_from_search' => true,
		'show_ui'             => true,
		'show_in_nav_menus'   => true,
		'show_in_rest'        => false,
		'query_var'           => true,
		'rewrite'             => array( 'slug' => 'topic-cta' ),
		'capability_type'     => 'post',
		'hierarchical'        => true,
		'has_archive'         => true,
		'menu_position'       => 10,
		'menu_icon'           => get_stylesheet_directory_uri() . '/static/img/admin/document-text.png',
		'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'author', 'comments', 'revisions' ),
		'taxonomies'          => array( 'category', 'post_tag' ),
	);

	register_post_type( 'topiccta', $args );
}
add_action( 'init', 'rc_register_topiccta_post_type' );
