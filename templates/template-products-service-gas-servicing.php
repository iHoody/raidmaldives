<?php
/**
 * Template Name: Products and Services - Servicing Template
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
$servicesList = $middleContent['services'];
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
        
        <section class="servicing products-services-section">
            <div class="container">
                
                <div class="row">
                    <div class="column column--12">
                        
                        <div class="servicing__content products-services__content">
                            <h2><?= esc_attr($servicesTitle) ?></h2>
                            <div class="servicing__content-description products-services__content-description">
                                <?= wp_kses($servicesSubTitle, $allowedposttags) ?>
                            </div>
                            <div class="servicing__content-list">
                                <?php if ($servicesList): ?>
                                    <?php foreach($servicesList as $list): ?>
                                        
                                        <div class="servicing__content-list-item">
                                            <div class="content-list__image">
                                                <img src="<?= esc_attr($list['image']) ?>" alt="<?= esc_attr($list['title']) ?>">
                                            </div>
                                            <div class="content-list__details">
                                                <h3><?= esc_attr($list['title']) ?></h3>
                                                <div class="description"><?= wp_kses($list['description'], $allowedposttags) ?></div>
                                            </div>
                                        </div>
                                        
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    
                    </div>
                </div>
            
            </div>
        </section>
    
    </div>

<?php
get_footer();
