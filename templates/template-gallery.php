<?php
/**
 * Template Name: Gallery Template
 *
 * @package DiveRaid
 */

global $allowedposttags;

$banner = get_field('banner');
$bannerBackground = $banner['background_image'];
$bannerTitle = $banner['title'];
$bannerSubTitle = $banner['sub_title'];

$gallery = get_field('gallery');
$galleryTitle = $gallery['title'];
$galleryImages = $gallery['images'];
get_header();
?>
    
    <div class="site-content">
    
        <section class="gallery-banner site-banner" style="background-image: url('<?= esc_attr($bannerBackground) ?>');">
            <div class="container site-banner__container gallery-container">
                <div class="site-information">
                    <h1 class="banner-title"><?= esc_attr($bannerTitle) ?></h1>
                    <p class="banner-description"><?= esc_attr($bannerSubTitle) ?></p>
                </div>
            </div>
        </section>
        
        <section class="gallery">
            <div class="container">

                <div class="row">
                    <div class="column column--12">
                      <div class="gallery__header">
                          <h2><?= esc_attr($galleryTitle) ?></h2>
                      </div>
                    </div>
                </div>
                
                <div class="row">
                
                    <?php if ($galleryImages): ?>
                        <?php foreach($galleryImages as $image): ?>
                            
                            <div class="column column--4">
                                <div class="gallery__wrap gallery-item">
                                    <div class="gallery__wrap-image">
                                        <img src="<?= esc_attr($image['featured_image']) ?>" alt="<?= esc_attr($image['title']) ?>">
                                    </div>
                                    <div class="gallery__wrap-detail">
                                        <h3><?= esc_attr($image['title']) ?></h3>
                                        <?php $totalImages = count($image['gallery']); ?>
                                        <p><?= esc_attr($totalImages) ?> <?= esc_attr($totalImages > 1 ? 'photos' : 'photo') ?></p>
                                    </div>
                                    <?php
                                    $imageArr = [];
                                    if ($image['gallery']) {
                                        foreach ($image['gallery'] as $galleryImage) {
                                            $imageArr[] = $galleryImage['image'];
                                        }
                                    }
                                    ?>
                                    <div class="gallery-images" data-images="<?= esc_attr(implode(',', $imageArr)) ?>"></div>
                                </div>
                            </div>
        
                        <?php endforeach; ?>
                    <?php endif; ?>
                    
                </div>
                
            </div>
        </section>
        
    </div>
<?php
get_footer();
