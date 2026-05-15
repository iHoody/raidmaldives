<?php
/**
 * Template Name: Contact Template
 *
 * @package DiveRaid
 */

global $allowedposttags;

$banner = get_field('banner');
$bannerBackground = $banner['background_image'];
$bannerTitle = $banner['title'];

$faqHeader = get_field('header');
$faqHeaderTitle = $faqHeader['title'];
$faqHeaderSubTitle = $faqHeader['sub_title'];
$faqImage = $faqHeader['image'];
$faqLists = get_field('faq_list');
get_header();
?>
<div class="site-content">
    <section class="events-banner site-banner" style="background-image: url('<?= esc_attr($bannerBackground) ?>');">
        <div class="container site-banner__container events__container">
            <div class="site-information">
                <h1 class="banner-title"><?= esc_attr($bannerTitle) ?></h1>
            </div>
        </div>
    </section>

    <section class="contact-section">
        <div class="container">
            <div class="row">
                <div class="column column--6 align-center">

                    <div class="contact--wrap">
                      <?= do_shortcode(get_field('contact_form_shortcode')) ?>
                    </div>

                </div>
            </div>
        </div>
    </section>

</div>

<?php
get_footer();
