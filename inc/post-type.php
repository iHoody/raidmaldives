<?php
/**
 * Custom post types
 *
 * @package DiveRaid
 */
function post_type_client_reviews_cpt(): void
{
    $labels = array(
        'name'                  => _x( 'Client Reviews', 'Post Type General Name', 'dive-raid' ),
        'singular_name'         => _x( 'Client Review', 'Post Type Singular Name', 'dive-raid' ),
        'menu_name'             => __( 'Client Reviews', 'dive-raid' ),
        'name_admin_bar'        => __( 'Client Review', 'dive-raid' ),
        'archives'              => __( 'Client Review Archives', 'dive-raid' ),
        'attributes'            => __( 'Client Review Attributes', 'dive-raid' ),
        'parent_item_colon'     => __( 'Parent Client Review:', 'dive-raid' ),
        'all_items'             => __( 'All Client Reviews', 'dive-raid' ),
        'add_new_item'          => __( 'Add New Client Review', 'dive-raid' ),
        'add_new'               => __( 'Add New', 'dive-raid' ),
        'new_item'              => __( 'New Client Review', 'dive-raid' ),
        'edit_item'             => __( 'Edit Client Review', 'dive-raid' ),
        'update_item'           => __( 'Update Client Review', 'dive-raid' ),
        'view_item'             => __( 'View Client Review', 'dive-raid' ),
        'view_items'            => __( 'View Client Reviews', 'dive-raid' ),
        'search_items'          => __( 'Search Client Review', 'dive-raid' ),
        'not_found'             => __( 'Not found', 'dive-raid' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'dive-raid' ),
        'featured_image'        => __( 'Featured Image', 'dive-raid' ),
        'set_featured_image'    => __( 'Set featured image', 'dive-raid' ),
        'remove_featured_image' => __( 'Remove featured image', 'dive-raid' ),
        'use_featured_image'    => __( 'Use as featured image', 'dive-raid' ),
        'insert_into_item'      => __( 'Insert into client review', 'dive-raid' ),
        'uploaded_to_this_item' => __( 'Uploaded to this client review', 'dive-raid' ),
        'items_list'            => __( 'Client Reviews list', 'dive-raid' ),
        'items_list_navigation' => __( 'Client Reviews list navigation', 'dive-raid' ),
        'filter_items_list'     => __( 'Filter Client Reviews list', 'dive-raid' ),
    );
    
    $args   = array(
        'label'               => __( 'Client Review', 'dive-raid' ),
        'description'         => __( 'Post Type for company Client Reviews.', 'dive-raid' ),
        'labels'              => $labels,
        'supports'            => ['title', 'editor', 'thumbnail', 'revisions'],
        'taxonomies'          => [],
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 20,
        'menu_icon'           => 'dashicons-businessperson',
        'show_in_admin_bar'   => true,
        'show_in_nav_menus'   => true,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => true,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest'        => true,
        'rewrite'             => array( 'slug' => 'client-review', 'with_front' => false ),
    );
    register_post_type( 'client-review', $args );
    
}
add_action( 'init', 'post_type_client_reviews_cpt', 0 );