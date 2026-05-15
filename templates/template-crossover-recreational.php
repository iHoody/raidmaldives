<?php
/**
 * Template Name: Crossover Recreational Template
 *
 * @package DiveRaid
 */

global $allowedposttags;

$banner = get_field('banner');
$bannerBackground = $banner['background_image'];
$bannerTitle = $banner['title'];
$bannerSubTitle = $banner['sub_title'];
$buttonTitle = $banner['button_title'];
$buttonLink = $banner['button_url'];

$topContent = get_field('top_content');
$topContentPosts = $topContent['content_post'];

$howCrossoverWorks = get_field('how_crossover_works');
$howCrossoverWorksTitle = $howCrossoverWorks['title'];
$howCrossoverContentPost = $howCrossoverWorks['content_post'];

$learnCrossover = get_field('learn_crossover');
$learnCrossoverTitle = $learnCrossover['title'];
$learnCrossoverSubTitle = $learnCrossover['sub_title'];
$learnCrossoverContentPost = $learnCrossover['content_post'];

$instructorCrossover = get_field('instructor_crossover');
$instructorCrossoverTitle = $instructorCrossover['title'];
$instructorCrossoverDescription = $instructorCrossover['description'];
$instructorCrossoverIcon = $instructorCrossover['icon'];
$instructorCrossoverBackgroundImage = $instructorCrossover['background_image'];

$bottomContent = get_field('bottom_content');
$bottomContentPosts = $bottomContent['content_post'];
get_header();
?>
    
    <div class="site-content">
        
        <section class="crossover-banner site-banner" style="background-image: url('<?= esc_attr($bannerBackground) ?>');">
            <div class="container site-banner__container crossover-banner__container">
                <div class="site-information">
                    <h1 class="banner-title"><?= esc_attr($bannerTitle) ?></h1>
                    <p class="banner-description"><?= esc_attr($bannerSubTitle) ?></p>
                    <div class="button-section">
                        <a href="<?= esc_url($buttonLink) ?>" class="text-uppercase">
                            <?= esc_attr($buttonTitle) ?> <i class="icon icon-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        
        <?php if ($topContentPosts): ?>
            <section class="crossover-content">
                <div class="container">
                    
                    <?php foreach ($topContentPosts as $key => $post): ?>
                        <div class="row <?= ($key % 2 === 0) ? '' : 'reverse-column' ?>">
                            
                            <div class="column column--6">
                                <div class="content-details__wrap">
                                    <div class="content-details__wrap-description <?= ($key % 2 === 0) ? '' : 'reverse' ?>">
                                        <h3><?= wp_kses_post($post['title']) ?></h3>
                                        <div class="content-details__wrap-image content">
                                            <img src="<?= esc_attr($post['image']) ?>" alt="<?= esc_attr(strip_tags($post['title'])) ?>">
                                        </div>
                                        <?= wp_kses_post($post['description']) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="column column--6">
                                <div class="content-details__wrap">
                                    <div class="content-details__wrap-image not-content <?= ($key % 2 === 0) ? '' : 'reverse' ?>">
                                        <img src="<?= esc_attr($post['image']) ?>" alt="<?= esc_attr(strip_tags($post['title'])) ?>">
                                    </div>
                                </div>
                            </div>
                        
                        </div>
                    <?php endforeach; ?>
                
                </div>
            </section>
        <?php endif; ?>
        
        <section class="crossover-path recreational-instructor-crossover">
            <div class="crossover-path__wrap">
                <h2 class="crossover-path__wrap-title"><?= wp_kses_post($howCrossoverWorksTitle) ?></h2>
            </div>
            
            <div class="container">
                
                <?php if ($howCrossoverContentPost): ?>
                    
                    <div class="crossover-desktop">
                        <div class="row">
                            
                            <?php getMiddleContentPosts($howCrossoverContentPost) ?>
                        
                        </div>
                    </div>
                    <div class="crossover-mobile">
                        <div class="crossover-content__swiper-wrapper swiper" id="swiper-crossover-posts">
                            <div class="swiper-wrapper">
                                
                                <?php getMiddleContentPosts($howCrossoverContentPost, true) ?>
                            
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                
                <?php endif; ?>
            
            </div>
        </section>
        
        <section class="crossover-path learn-crossover bg-white">
            <div class="crossover-path__wrap">
                <h2 class="crossover-path__wrap-title"><?= wp_kses_post($learnCrossoverTitle) ?></h2>
                <h5 class="crossover-path__wrap-sub-title"><?= wp_kses_post($learnCrossoverSubTitle) ?></h5>
            </div>
            
            <div class="container">
                
                <?php if ($learnCrossoverContentPost): ?>
                    
                    <div class="crossover-desktop">
                        <div class="row">
                            
                            <?php getMiddleContentPosts($learnCrossoverContentPost) ?>
                        
                        </div>
                    </div>
                    <div class="crossover-mobile">
                        <div class="crossover-content__swiper-wrapper swiper" id="swiper-crossover-posts">
                            <div class="swiper-wrapper">
                                
                                <?php getMiddleContentPosts($learnCrossoverContentPost, true) ?>
                            
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                
                <?php endif; ?>
            
            </div>
        </section>
        
        <section class="crossover-common">
            <div class="background-filter black"></div>
            <style>
              .crossover-common:before {
                background-image: url('<?= esc_url($instructorCrossoverBackgroundImage) ?>');
              }
            </style>
            <div class="container">
                <div class="row justify-center-grid">
                    <div class="column column--6 content-details justify-center align-center">
                        <div class="content-details__wrap">
                            <img src="<?= esc_attr($instructorCrossoverIcon) ?>" alt="<?= wp_kses_post($instructorCrossoverTitle) ?>">
                        </div>
                    </div>
                    <div class="column column--5 content-details justify-center">
                        <div class="content-details__wrap">
                            <h3><?= wp_kses_post($instructorCrossoverTitle) ?></h3>
                            <div class="content-details__wrap-description"><?= wp_kses_post($instructorCrossoverDescription) ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <?php if ($bottomContentPosts): ?>
            <section class="bottom-content crossover-recreational">
                <div class="container">
                    
                    <?php foreach ($bottomContentPosts as $key => $post): ?>
                        <div class="row <?= ($key % 2 === 0) ? '' : 'reverse-column' ?>">
                            
                            <div class="column column--6">
                                <div class="content-details__wrap">
                                    <div class="content-details__wrap-description <?= ($key % 2 === 0) ? '' : 'reverse' ?>">
                                        <h3><?= wp_kses_post($post['title']) ?></h3>
                                        <div class="content-details__wrap-image content">
                                            <img src="<?= esc_attr($post['image']) ?>" alt="<?= esc_attr(strip_tags($post['title'])) ?>">
                                        </div>
                                        <?= wp_kses_post($post['description']) ?>
                                        <?php if ($post['buttons']['button_title'] !== '' && $post['buttons']['button_url'] !== ''): ?>
                                            <div class="content-details__wrap-button">
                                                <a href="<?= esc_url($post['buttons']['button_url']) ?>">
                                                    <?= esc_attr($post['buttons']['button_title']) ?> <i class="icon icon-arrow-right"></i>
                                                    <?php if ($post['buttons']['button_sub_title'] !== ''): ?>
                                                        <label><?= esc_attr($post['buttons']['button_sub_title']) ?></label>
                                                    <?php endif; ?>
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="column column--6">
                                <div class="content-details__wrap">
                                    <div class="content-details__wrap-image not-content <?= ($key % 2 === 0) ? '' : 'reverse' ?>">
                                        <img src="<?= esc_attr($post['image']) ?>" alt="<?= esc_attr(strip_tags($post['title'])) ?>">
                                    </div>
                                </div>
                            </div>
                        
                        </div>
                    <?php endforeach; ?>
                
                </div>
            </section>
        <?php endif; ?>
    
    </div>
<?php
get_footer();
