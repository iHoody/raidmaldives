<?php
/**
 * Custom post types
 *
 * @package DiveRaid
 */
function post_type_events_cpt(): void
{
    $labels = array(
        'name'                  => _x( 'Events', 'Post Type General Name', 'raid-maldives' ),
        'singular_name'         => _x( 'Event', 'Post Type Singular Name', 'raid-maldives' ),
        'menu_name'             => __( 'Events', 'raid-maldives' ),
        'name_admin_bar'        => __( 'Event', 'raid-maldives' ),
        'archives'              => __( 'Event Archives', 'raid-maldives' ),
        'attributes'            => __( 'Event Attributes', 'raid-maldives' ),
        'parent_item_colon'     => __( 'Parent Event:', 'raid-maldives' ),
        'all_items'             => __( 'All Events', 'raid-maldives' ),
        'add_new_item'          => __( 'Add New Event', 'raid-maldives' ),
        'add_new'               => __( 'Add New', 'raid-maldives' ),
        'new_item'              => __( 'New Event', 'raid-maldives' ),
        'edit_item'             => __( 'Edit Event', 'raid-maldives' ),
        'update_item'           => __( 'Update Event', 'raid-maldives' ),
        'view_item'             => __( 'View Event', 'raid-maldives' ),
        'view_items'            => __( 'View Events', 'raid-maldives' ),
        'search_items'          => __( 'Search Event', 'raid-maldives' ),
        'not_found'             => __( 'Not found', 'raid-maldives' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'raid-maldives' ),
        'featured_image'        => __( 'Featured Image', 'raid-maldives' ),
        'set_featured_image'    => __( 'Set featured image', 'raid-maldives' ),
        'remove_featured_image' => __( 'Remove featured image', 'raid-maldives' ),
        'use_featured_image'    => __( 'Use as featured image', 'raid-maldives' ),
        'insert_into_item'      => __( 'Insert into Event', 'raid-maldives' ),
        'uploaded_to_this_item' => __( 'Uploaded to this Event', 'raid-maldives' ),
        'items_list'            => __( 'Events list', 'raid-maldives' ),
        'items_list_navigation' => __( 'Events list navigation', 'raid-maldives' ),
        'filter_items_list'     => __( 'Filter Events list', 'raid-maldives' ),
    );
    
    $args   = array(
        'label'               => __( 'Event', 'raid-maldives' ),
        'description'         => __( 'Post Type for company Events.', 'raid-maldives' ),
        'labels'              => $labels,
        'supports'            => ['title', 'editor', 'thumbnail', 'revisions'],
        'taxonomies'          => [],
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 20,
        'menu_icon'           => 'dashicons-awards',
        'show_in_admin_bar'   => true,
        'show_in_nav_menus'   => true,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => true,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest'        => true,
        'rewrite'             => array( 'slug' => 'event', 'with_front' => false ),
    );
    register_post_type( 'event', $args );
    
}
add_action( 'init', 'post_type_events_cpt', 0 );

function post_type_dive_centres_cpt(): void
{
    $labels = array(
        'name'                  => _x( 'Dive Centre', 'Post Type General Name', 'raid-maldives' ),
        'singular_name'         => _x( 'Dive Centre', 'Post Type Singular Name', 'raid-maldives' ),
        'menu_name'             => __( 'Dive Centres', 'raid-maldives' ),
        'name_admin_bar'        => __( 'Dive Centre', 'raid-maldives' ),
        'archives'              => __( 'Dive Centre Archives', 'raid-maldives' ),
        'attributes'            => __( 'Dive Centre Attributes', 'raid-maldives' ),
        'parent_item_colon'     => __( 'Parent Dive Centre:', 'raid-maldives' ),
        'all_items'             => __( 'All Dive Centres', 'raid-maldives' ),
        'add_new_item'          => __( 'Add New Dive Centre', 'raid-maldives' ),
        'add_new'               => __( 'Add New', 'raid-maldives' ),
        'new_item'              => __( 'New Dive Centre', 'raid-maldives' ),
        'edit_item'             => __( 'Edit Dive Centre', 'raid-maldives' ),
        'update_item'           => __( 'Update Dive Centre', 'raid-maldives' ),
        'view_item'             => __( 'View Dive Centre', 'raid-maldives' ),
        'view_items'            => __( 'View Dive Centres', 'raid-maldives' ),
        'search_items'          => __( 'Search Dive Centre', 'raid-maldives' ),
        'not_found'             => __( 'Not found', 'raid-maldives' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'raid-maldives' ),
        'featured_image'        => __( 'Featured Image', 'raid-maldives' ),
        'set_featured_image'    => __( 'Set featured image', 'raid-maldives' ),
        'remove_featured_image' => __( 'Remove featured image', 'raid-maldives' ),
        'use_featured_image'    => __( 'Use as featured image', 'raid-maldives' ),
        'insert_into_item'      => __( 'Insert into Dive Centre', 'raid-maldives' ),
        'uploaded_to_this_item' => __( 'Uploaded to this Dive Centre', 'raid-maldives' ),
        'items_list'            => __( 'Dive Centres list', 'raid-maldives' ),
        'items_list_navigation' => __( 'Dive Centres list navigation', 'raid-maldives' ),
        'filter_items_list'     => __( 'Filter Dive Centres list', 'raid-maldives' ),
    );
    
    $args   = array(
        'label'               => __( 'Dive Centre', 'raid-maldives' ),
        'description'         => __( 'Post Type for company Dive Centres.', 'raid-maldives' ),
        'labels'              => $labels,
        'supports'            => ['title', 'editor', 'thumbnail', 'revisions'],
        'taxonomies'          => [],
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 20,
        'menu_icon'           => 'dashicons-text-page',
        'show_in_admin_bar'   => true,
        'show_in_nav_menus'   => true,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => true,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest'        => true,
        'rewrite'             => array( 'slug' => 'dive-centre', 'with_front' => false ),
    );
    register_post_type( 'dive-centre', $args );
    
}
add_action( 'init', 'post_type_dive_centres_cpt', 0 );
