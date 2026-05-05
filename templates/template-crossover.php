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

        <section class="crossover-path">
            <div class="crossover-path__wrap">
                <h2 class="crossover-path__wrap-title"><?= wp_kses_post($middleContentTitle) ?></h2>
            </div>

            <div class="container">

                <?php if ($middleContentPosts): ?>

                    <div class="crossover-desktop">
                        <div class="row">

                          <?php getMiddleContentPosts($middleContentPosts) ?>

                        </div>
                    </div>
                    <div class="crossover-mobile">
                      <div class="crossover-content__swiper-wrapper swiper" id="swiper-crossover-posts">
                        <div class="row swiper-wrapper">

                          <?php getMiddleContentPosts($middleContentPosts) ?>

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
              background-image: url('<?= esc_url($crossoverCommonBGImage) ?>');
            }
          </style>
          <div class="container">
            <div class="row justify-center-grid">
              <div class="column column--6 content-details justify-center align-center">
                <div class="content-details__wrap">
                  <img src="<?= esc_attr($crossoverCommonImage) ?>" alt="<?= wp_kses_post($crossoverCommonTitle) ?>">
                </div>
              </div>
              <div class="column column--5 content-details justify-center">
                <div class="content-details__wrap">
                  <h3><?= wp_kses_post($crossoverCommonTitle) ?></h3>
                  <div class="content-details__wrap-description"><?= wp_kses_post($crossoverCommonDescription) ?></div>
                </div>
              </div>
            </div>
          </div>
        </section>

        <section class="bottom-content">
          <div class="container">
            <div class="row">
              <div class="column column--6 content-details">
                <div class="content-details__wrap image-wrap content">
                  <img src="<?= esc_attr($bottomContentImage) ?>" alt="<?= wp_kses_post($bottomContentTitle) ?>">
                </div>
              </div>
              <div class="column column--6 content-details justify-center">
                <div class="content-details__wrap content-wrap">
                  <h3><?= wp_kses_post($bottomContentTitle) ?></h3>
                  <div class="content-details__wrap image-wrap not-content">
                    <img src="<?= esc_attr($bottomContentImage) ?>" alt="<?= wp_kses_post($bottomContentTitle) ?>">
                  </div>
                  <div class="content-details__wrap-description"><?= wp_kses_post($bottomContentDescription) ?></div>
                </div>
              </div>
            </div>
          </div>
        </section>

    </div>
<?php
get_footer();
