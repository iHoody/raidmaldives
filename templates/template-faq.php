<?php
/**
 * Template Name: FAQ Template
 *
 * @package DiveRaid
 */

global $allowedposttags;

$banner = get_field('banner');
$bannerBackground = $banner['background_image'];
$bannerTitle = $banner['title'];
$bannerSubTitle = $banner['sub_title'];

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
                <p class="banner-description"><?= esc_attr($bannerSubTitle) ?></p>
            </div>
        </div>
    </section>
    
    <section class="bottom-content-image">
        <div class="container">
            <div class="row">
                <div class="column column--12 align-center">
                    
                    <div class="site-faq__content">
                        <div class="site-faq__content-image">
                            <img src="<?= esc_url($faqImage) ?>" alt="faq-image">
                        </div>
                        <?php if ($faqLists) : ?>
                            <div class="site-faq_content-wrap">
                                <div class="site-faq__content-button">
                                    <button>Expand/Collapse All</button>
                                </div>
                                <div class="site-faq__search">
                                    <input type="text" class="site-faq__search-input" placeholder="Search Questions." />
                                </div>
                                <div class="site-faq__content-list">
                                    <?php foreach ($faqLists as $faqList) : ?>
                                        <div class="site-faq__content-list-item">
                                            <h6 class="site-faq__content-list-title"><?= esc_attr($faqList['question']) ?></h6>
                                            <p class="site-faq__content-list-description"><?= esc_attr($faqList['answer']) ?></p>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                
                </div>
            </div>
        </div>
    </section>
    
</div>

<?php
get_footer();
