<?php
/**
 * Template Name: Products and Services - Gas Fills Template
 *
 * @package DiveRaid
 */

global $allowedposttags;

$banner = get_field('banner');
$bannerBackground = $banner['background_image'];
$bannerTitle = $banner['title'];
$bannerSubTitle = $banner['sub_title'];

$middleContent = get_field('middle_content');
$servicesTitle = $middleContent['title'];
$servicesSubTitle = $middleContent['sub_title'];
get_header();
?>
    
    <div class="site-content">
    
        <section class="products-services-banner site-banner" style="background-image: url('<?= esc_attr($bannerBackground) ?>');">
            <div class="container site-banner__container products-services-container">
                <div class="site-information">
                    <h1 class="banner-title"><?= esc_attr($bannerTitle) ?></h1>
                    <p class="banner-description"><?= esc_attr($bannerSubTitle) ?></p>
                </div>
            </div>
        </section>
        
        <section class="gas-fills products-services-section">
            <div class="container">
                
                <div class="row">
                    <div class="column column--12">
                    
                        <div class="gas-fills__content products-services__content">
                            <h2><?= esc_attr($servicesTitle) ?></h2>
                            <div class="gas-fills__content-description products-services__content-description">
                                <?= wp_kses($servicesSubTitle, $allowedposttags) ?>
                            </div>
                            <div class="gas-fills__content-details">
                                <?= wp_kses(get_the_content(), $allowedposttags) ?>
                            </div>
                        </div>
                    
                    </div>
                </div>
                
            </div>
        </section>
    
    </div>

<?php
get_footer();
