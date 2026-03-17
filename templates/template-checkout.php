<?php
/**
 * Template Name: Checkout Template
 *
 * @package DiveRaid
 */

global $allowedposttags, $wp;

$banner = get_field('banner', 'option');
$bannerBackground = $banner['background_image'];


$title = get_the_title();

if ( isset( $wp->query_vars['order-received'] ) ) {
    $title = 'Booking Confirmed';
}
get_header();
?>
    
    <div class="site-content">

        <section class="training-banner site-banner" style="background-image: url('<?= esc_attr($bannerBackground) ?>');">
          <div class="container site-banner__container training-container">
            <div class="site-information">
              <h1 class="banner-title">
                <?= esc_attr($title) ?>
              </h1>
            </div>
          </div>
        </section>
    
        <div class="container">
            
            <div class="diveraid-checkout">
                <?= do_shortcode(get_the_content()) ?>
            </div>
            
        </div>
    
    </div>

<?php
get_footer();
