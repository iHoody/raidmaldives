<?php
/**
 * Theme functions and definitions
 *
 * @package DiveRaid
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


// DiveRaid includes a directory.
$dive_raid_inc_dir = 'inc';

// Array of files to include.
$dive_raid_includes = [
    '/setup.php',           // Theme setup and custom theme supports.
    '/enqueue.php',         // Enqueue scripts and styles.
    '/post-type.php',       // Custom post types.
    '/ajax.php',            // Ajax request.
    '/helper.php',          // Helper functions.
    // '/widgets.php',      // Register widget area.
    // '/hooks.php',        // Custom hooks.
    // '/helper.php',       // Custom functions that act independently of the theme templates.
];

// Load WooCommerce functions if WooCommerce is activated.
if ( class_exists( 'WooCommerce' ) ) {
    $dive_raid_includes[] = '/woocommerce.php';
}

// Load the Jetpack compatibility file if Jetpack is activated.
if ( class_exists( 'Jetpack' ) ) {
    $dive_raid_includes[] = '/jetpack.php';
}

// Include files.
foreach ( $dive_raid_includes as $file ) {
    require_once get_theme_file_path( $dive_raid_inc_dir . $file );
}