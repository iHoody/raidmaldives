<?php
/**
 * Content wrappers
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/wrapper-start.php.
 *
 * @package DiveRaid
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$banner = get_field('banner', 'option');
$bannerBackground = $banner['background_image'] ?? get_template_directory_uri() . '/dist/images/default-banner.jpg';

// Set page title
$page_title = '';
if ( is_account_page() ) {
    $page_title = 'My Account';
} elseif ( is_shop() ) {
    $page_title = 'Shop';
} elseif ( is_product() ) {
    $page_title = get_the_title();
} elseif ( is_cart() ) {
    $page_title = 'Cart';
} elseif ( is_checkout() ) {
    $page_title = 'Checkout';
} else {
    $page_title = get_the_title();
}
?>

<section class="dive-event-banner site-banner" style="background-image: url('<?php echo esc_url($bannerBackground); ?>');">
    <div class="container site-banner__container dive-event-container">
        <div class="site-information">
            <h1 class="banner-title">
                <?php echo esc_html($page_title); ?>
            </h1>
        </div>
    </div>
</section>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">