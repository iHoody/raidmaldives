<?php
/**
 * Theme setup functions.
 *
 * @package DiveRaid
 */

defined( 'ABSPATH' ) || exit;

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function dive_raid_setup(): void {
    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );
    
    // Let WordPress manage the document title.
    add_theme_support( 'title-tag' );
    
    // Enable support for Post Thumbnails on posts and pages.
    add_theme_support( 'post-thumbnails' );
    
    // Switch default core markup for search form, comment form, and comments to output valid HTML5.
    add_theme_support( 'html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ] );
}
add_action( 'after_setup_theme', 'dive_raid_setup' );


/**
 * Register navigation menus.
 */
function dive_raid_register_menus(): void {
    register_nav_menus( [
        'primary'                   => __( 'Primary Menu', 'dive-raid' ),
        'header_social'             => __( 'Header Social Media', 'dive-raid' ),
        'footer_services'           => __( 'Footer Services', 'dive-raid' ),
        'footer_policies'           => __( 'Footer Policies', 'dive-raid' ),
        'footer_connect'            => __( 'Footer Connect', 'dive-raid' ),
    ] );
}
add_action( 'init', 'dive_raid_register_menus' );