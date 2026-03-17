<?php
/**
 * Template Name: Training Template
 *
 * @package DiveRaid
 */

global $allowedposttags;

$banner = get_field('banner');
$bannerBackground = $banner['background_image'];
$bannerTitle = $banner['title'];
$bannerSubTitle = $banner['sub_title'];

$midContent = get_field('middle_content');
$midContentImage = $midContent['image'];
$midContentTitle = $midContent['title'];
$midContentList = $midContent['training_list'];

$howItWorks = get_field('how_it_work');
$howItWorksTitle = $howItWorks['title'];
$howItWorksImage = $howItWorks['image'];
$howItWorksList = $howItWorks['lists'];
get_header();
?>
    
    <div class="site-content">
        
        <section class="training-banner site-banner" style="background-image: url('<?= esc_attr($bannerBackground) ?>');">
            <div class="container site-banner__container training-container">
                <div class="site-information">
                    <h1 class="banner-title"><?= esc_attr($bannerTitle) ?></h1>
                    <p class="banner-description"><?= esc_attr($bannerSubTitle) ?></p>
                </div>
            </div>
        </section>
        
        <section class="training-mid-content">
            <div class="container">
                <div class="row">
                    <div class="column column--6 align-right">
                        <div class="training-mid-content__details">
                            <div class="training-mid-content__details-image">
                                <img src="<?= esc_attr($midContentImage) ?>" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="column column--6">
                        <div class="training-mid-content__details">
                            <div class="training-mid-content__details-content">
                                <h4><?= esc_attr($midContentTitle) ?></h4>
                                <ul>
                                    <?php foreach ($midContentList as $list) : ?>
                                        <li><?= wp_kses_post($list['title']) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <section class="how-it-works section-content">
            <div class="how-it-works__wrap">
                <h2 class="how-it-works__wrap-title section-title"><?= esc_attr($howItWorksTitle) ?></h2>
            </div>
            <div class="container">
                <div class="row">
                    <div class="column column--6">
                        <?php if ($howItWorksList) : ?>
                            <div class="how-it-works__list">
                                <ul>
                                  <?php foreach ($howItWorksList as $list) : ?>
                                    <li><?= esc_attr($list['title']) ?></li>
                                  <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="column column--6">
                        <div class="how-it-works__image">
                          <img src="<?= esc_attr($howItWorksImage) ?>" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="courses start-diving section-content">
            <div class="courses__wrap">
                <h2 class="courses__wrap-title section-title">Start Diving</h2>
            </div>
            <div class="courses__posts">
                <?php
                    $taxonomyArgs = [
                        'taxonomy' => 'training-category',
                        'field' => 'slug',
                        'terms' => 'diving'
                    ];
                    contentPostList('training', $taxonomyArgs); ?>
            </div>
        </div>

        <div class="courses section-content">
            <div class="courses__wrap">
                <h2 class="courses__wrap-title section-title">Keep Diving</h2>
            </div>
            <div class="courses__posts">
                <?php
                    $taxonomyArgs = [
                        'taxonomy' => 'training-category',
                        'field' => 'slug',
                        'terms' => 'keep-diving'
                    ];
                    contentPostList('training', $taxonomyArgs); ?>
            </div>
        </div>
        
    </div>

<?php require_once(get_template_directory() . '/template-parts/modal/training-booking-form.php'); ?>
<?php
get_footer();
