<?php
/**
 * Template Name: Crossover Template
 *
 * @package DiveRaid
 */

global $allowedposttags;

$banner = get_field('banner');
$bannerBackground = $banner['background_image'];
$bannerTitle = $banner['title'];
$bannerSubTitle = $banner['sub_title'];

$topContent = get_field('top_content');
$topContentPosts = $topContent['content_post'];

$middleContent = get_field('middle_content');
$middleContentTitle = $middleContent['title'];
$middleContentPosts = $middleContent['content_post'];

$crossoverCommon = get_field('crossover_common');
$crossoverCommonTitle = $crossoverCommon['title'];
$crossoverCommonDescription = $crossoverCommon['description'];
$crossoverCommonImage = $crossoverCommon['image_content'];
$crossoverCommonBGImage = $crossoverCommon['background_image'];

$bottomContent = get_field('bottom_content');
$bottomContentTitle = $bottomContent['title'];
$bottomContentDescription = $bottomContent['description'];
$bottomContentImage = $bottomContent['image_content'];
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

        <?php if ($topContentPosts): ?>
        <section class="crossover-content">
            <div class="container">

                <?php foreach ($topContentPosts as $key => $post): ?>
                    <div class="row <?= ($key % 2 === 0) ? '' : 'reverse-column' ?>">

                        <div class="column column--6">
                            <div class="content-details__wrap">
                                <div class="content-details__wrap-description <?= ($key % 2 === 0) ? '' : 'reverse' ?>">
                                    <h3><?= wp_kses_post($post['title']) ?></h3>
                                    <?= wp_kses_post($post['description']) ?>
                                </div>
                            </div>
                        </div>
                        <div class="column column--6">
                            <div class="content-details__wrap">
                                <div class="content-details__wrap-image <?= ($key % 2 === 0) ? '' : 'reverse' ?>">
                                    <img src="<?= esc_attr($post['image']) ?>" alt="<?= esc_attr(strip_tags($post['title'])) ?>">
                                </div>
                            </div>
                        </div>

                    </div>
                <?php endforeach; ?>

            </div>
        </section>
        <?php endif; ?>

        <section class="crossover-path section-content">
            <div class="crossover-path__wrap">
                <h2 class="crossover-path__wrap-title section-title"><?= wp_kses_post($middleContentTitle) ?></h2>
            </div>

            <div class="container">

                <?php if ($middleContentPosts): ?>

                    <div class="row">

                        <?php foreach ($middleContentPosts as $key => $post): ?>

                            <?php
                            $gridType = $post['grid_type'];
                            $column = match ($gridType) {
                                'col_2' => 'column--6',
                                'col_3' => 'column--4',
                                default => 'column--12',
                            };
                            ?>
                            <div class="column <?= esc_attr($column) ?>">
                                <div class="crossover-content__wrap">
                                    <div class="crossover-content__wrap-image" style="background-image: url(<?= esc_attr($post['image']) ?>)"></div>
                                    <div class="crossover-content__wrap-detail">
                                        <h4><?= esc_attr($post['title']) ?></h4>
                                        <div class="crossover-content__wrap-detail__description">
                                            <?= wp_kses_post($post['description']) ?>
                                        </div>
                                        <div class="crossover-content__wrap-detail__button">
                                            <a href="<?= esc_url($post['button_url']) ?>">
                                                <?= esc_attr($post['button_title']) ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php endforeach; ?>

                    </div>

                <?php endif; ?>

            </div>
        </section>

    </div>
<?php
get_footer();
