<?php
/**
 * Custom post types
 *
 * @package DiveRaid
 */
function post_type_events_cpt(): void
{
    $labels = array(
        'name'                  => _x( 'Events', 'Post Type General Name', 'dive-raid' ),
        'singular_name'         => _x( 'Event', 'Post Type Singular Name', 'dive-raid' ),
        'menu_name'             => __( 'Events', 'dive-raid' ),
        'name_admin_bar'        => __( 'Event', 'dive-raid' ),
        'archives'              => __( 'Event Archives', 'dive-raid' ),
        'attributes'            => __( 'Event Attributes', 'dive-raid' ),
        'parent_item_colon'     => __( 'Parent Event:', 'dive-raid' ),
        'all_items'             => __( 'All Events', 'dive-raid' ),
        'add_new_item'          => __( 'Add New Event', 'dive-raid' ),
        'add_new'               => __( 'Add New', 'dive-raid' ),
        'new_item'              => __( 'New Event', 'dive-raid' ),
        'edit_item'             => __( 'Edit Event', 'dive-raid' ),
        'update_item'           => __( 'Update Event', 'dive-raid' ),
        'view_item'             => __( 'View Event', 'dive-raid' ),
        'view_items'            => __( 'View Events', 'dive-raid' ),
        'search_items'          => __( 'Search Event', 'dive-raid' ),
        'not_found'             => __( 'Not found', 'dive-raid' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'dive-raid' ),
        'featured_image'        => __( 'Featured Image', 'dive-raid' ),
        'set_featured_image'    => __( 'Set featured image', 'dive-raid' ),
        'remove_featured_image' => __( 'Remove featured image', 'dive-raid' ),
        'use_featured_image'    => __( 'Use as featured image', 'dive-raid' ),
        'insert_into_item'      => __( 'Insert into Event', 'dive-raid' ),
        'uploaded_to_this_item' => __( 'Uploaded to this Event', 'dive-raid' ),
        'items_list'            => __( 'Events list', 'dive-raid' ),
        'items_list_navigation' => __( 'Events list navigation', 'dive-raid' ),
        'filter_items_list'     => __( 'Filter Events list', 'dive-raid' ),
    );
    
    $args   = array(
        'label'               => __( 'Event', 'dive-raid' ),
        'description'         => __( 'Post Type for company Events.', 'dive-raid' ),
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
