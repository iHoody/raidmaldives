<?php
/**
 * Custom WooCOmmerce functionality
 *
 * @package DiveRaid
 */
    
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Hook early in the content, before WooCommerce processes shortcodes
add_action( 'the_content', 'diveraid_add_woocommerce_banner_to_content' );

function diveraid_add_woocommerce_banner_to_content( $content ) {
    if ( ! is_page() ) {
        return $content;
    }
    
    global $post;
    
    // Check if the page content has WooCommerce shortcodes
    if ( ! has_shortcode( $post->post_content, 'woocommerce_my_account' ) &&
         ! has_shortcode( $post->post_content, 'woocommerce_checkout' ) &&
         ! has_shortcode( $post->post_content, 'woocommerce_cart' ) ) {
        return $content;
    }
    
    $banner = get_field('banner', 'option');
    $bannerBackground = $banner['background_image'] ?? get_template_directory_uri() . '/dist/images/default-banner.jpg';
    
    // Determine page title
    $page_title = get_the_title();
    if ( has_shortcode( $post->post_content, 'woocommerce_my_account' ) ) {
        $page_title = 'My Account';
    } elseif ( has_shortcode( $post->post_content, 'woocommerce_cart' ) ) {
        $page_title = 'Cart';
    } elseif ( has_shortcode( $post->post_content, 'woocommerce_checkout' ) ) {
        $page_title = 'Checkout';
    }
    
    $banner_html = '
    <section class="dive-event-banner site-banner" style="background-image: url(\'' . esc_url($bannerBackground) . '\');">
        <div class="container site-banner__container dive-event-container">
            <div class="site-information">
                <h1 class="banner-title">' . esc_html($page_title) . '</h1>
            </div>
        </div>
    </section>';
    
    return $banner_html . $content;
}