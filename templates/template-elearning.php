<?php
/**
 * Template Name: Dive Centre Free E-Learning
 *
 * @package DiveRaid
 */

$headerContent = get_field('header_content');
$headerContentDescription = $headerContent['content'];
$headerContentBackgroundImage = $headerContent['image'];

$middleLogo = get_field('middle_logo');
$middleLogoImage = $middleLogo['image'];

$middleContent = get_field('middle_content');
$middleContentList = $middleContent['contents'];

$bottomContent = get_field('bottom_content');
$bottomContentDescription = $bottomContent['description'];
$bottomContentBackgroundImage = $bottomContent['background_image'];
$bottomContentImage = $bottomContent['image_icon'];
$bottomContentButtonTitle = $bottomContent['button_title'];
$bottomContentButtonLink = $bottomContent['button_url'];
get_header();
?>

    <section class="header-content bg-dark-blue">
        <div class="container">
            <div class="row">
                <div class="column column--5 content-details">
                    <div class="header-content__details content-details__wrap">
                        <div class="header-content__details-description content-details__wrap-description">
                            <?= wp_kses_post($headerContentDescription) ?>
                        </div>
                    </div>
                </div>
                <div class="column column--7">
                    <div class="header-content__details">
                        <div class="header-content__details-image">
                            <img src="<?= esc_url($headerContentBackgroundImage) ?>" alt="" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="middle-content-image bg-dark-blue4">
        <div class="container">
            <div class="row">
                <div class="column column--12 align-center">
                    <div class="middle-content-image__details">
                        <div class="middle-content-image__details-image">
                            <img src="<?= esc_url($middleLogoImage) ?>" alt="" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="middle-content-list bg-dark-blue">
        <div class="container">
            <?php if ($middleContentList) : ?>
                <?php foreach ($middleContentList as $key => $content) : ?>
                    <div class="row middle-content-row <?= esc_attr($key % 2 === 0 ? '' : 'reverse-column') ?>">
                        <div class="column column--6">
                            <div class="middle-content-list__details image-wrap">
                                <div class="middle-content-list__details-image">
                                    <img src="<?= esc_url($content['image']) ?>" alt="" />
                                </div>
                            </div>
                        </div>
                        <div class="column column--6 content-details">
                            <div class="middle-content-list__details content-details__wrap description-wrap">
                                <div class="middle-content-list__details-description content-details__wrap-description">
                                    <?= wp_kses_post($content['content']) ?>
                                </div>
                                <?php if ($content['buttons']) : ?>
                                    <div class="middle-content-list__details-button">
                                        <?php foreach ($content['buttons'] as $button) : ?>
                                            <a href="<?= esc_url($button['button_url']) ?>">
                                                <?= esc_attr($button['button_title']) ?> <i class="icon icon-arrow-right"></i>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

    <section class="bottom-content">
        <div class="background-filter black"></div>
        <style>
          .bottom-content:before {
            background-image: url('<?= esc_url($bottomContentBackgroundImage) ?>');
          }
        </style>
        <div class="container">
            <div class="row">
                <div class="column column--6 content-details justify-center align-center">
                    <div class="content-details__wrap image-wrap">
                        <img src="<?= esc_attr($bottomContentImage) ?>" alt="">
                    </div>
                </div>
                <div class="column column--6 content-details justify-center">
                    <div class="content-details__wrap content-wrap">
                        <div class="content-details__wrap-description"><?= wp_kses_post($bottomContentDescription) ?></div>
                        <div class="content-details__wrap-button">
                            <a href="<?= esc_url($bottomContentButtonLink) ?>">
                                <?= esc_attr($bottomContentButtonTitle) ?> <i class="icon icon-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


<?php
get_footer();
