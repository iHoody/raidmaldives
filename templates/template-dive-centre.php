<?php
/**
 * Template Name: Dive Centre Template
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
$statistics = $banner['statistics'];

$middleContent = get_field('middle_content');
$middleContentDescription = $middleContent['content'];
$middleContentImage = $middleContent['image'];

$diverLists = get_field('diver_list');
$divers = $diverLists['divers'];

$bottomContent = get_field('bottom_content');
$bottomContentTitle = $bottomContent['title'];
$bottomContentDescription = $bottomContent['sub_title'];
$bottomContentBackgroundImage = $bottomContent['image'];
$bottomContentButtonTitle = $bottomContent['button_title'];
$bottomContentButtonLink = $bottomContent['button_url'];
get_header();
?>

    <div class="site-content">

      <section class="course-month-banner site-banner" style="background-image: url('<?= esc_attr($bannerBackground) ?>');">
        <div class="container site-banner__container course-month__container">
          <div class="site-information">
            <h1 class="banner-title"><?= esc_attr($bannerTitle) ?></h1>
            <p class="banner-description"><?= esc_attr($bannerSubTitle) ?></p>
            <div class="button-section">
              <a href="<?= esc_url($buttonLink) ?>">
                <?= esc_attr($buttonTitle) ?> <i class="icon icon-arrow-right"></i>
              </a>
            </div>
          </div>
        </div>
      </section>

      <section class="middle-content bg-dark-blue">
        <div class="container">
          <div class="row">
            <div class="column column--6 content-details justify-center">
              <div class="middle-content__details content-details__wrap">
                <div class="middle-content__details-description content-details__wrap-description">
                  <?= wp_kses_post($middleContentDescription) ?>
                </div>
              </div>
            </div>
            <div class="column column--6">
              <div class="middle-content__details">
                <div class="middle-content__details-image">
                  <img src="<?= esc_url($middleContentImage) ?>" alt="">
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="divers-list">
        <div class="container">
          <div class="divers__content">
            <?php if ($divers) : ?>
              <?php foreach ($divers as $diver) : ?>
                <article class="divers__wrap row">
                  <div class="divers__wrap-image column column--4">
                    <img src="<?= esc_url($diver['image']) ?>" alt="<?= esc_attr($diver['title']) ?>">
                  </div>
                  <div class="divers__wrap-details column column--8">
                    <h3 class="divers__wrap-details-title"><?= esc_attr($diver['title']) ?></h3>
                    <div class="divers__wrap-details-description">
                      <?= wp_kses_post($diver['description']) ?>
                    </div>
                    <div class="divers__wrap-details-contacts">
                      <?php if (isset($diver['contact']['website_url']) && $diver['contact']['website_url'] !== ''): ?>
                        <a href="<?= esc_url($diver['contact']['website_url']) ?>">
                          <i class="icon icon-website"></i>
                        </a>
                      <?php endif; ?>
                      <?php if (isset($diver['contact']['email']) && $diver['contact']['email'] !== ''): ?>
                        <a href="<?= wp_kses_post('mailto:'.$diver['contact']['email']) ?>">
                          <i class="icon icon-email-gray"></i>
                        </a>
                      <?php endif; ?>
                      <?php if (isset($diver['contact']['facebook_url']) && $diver['contact']['facebook_url'] !== ''): ?>
                        <a href="<?= esc_url($diver['contact']['facebook_url']) ?>">
                          <i class="icon icon-facebook-gray"></i>
                        </a>
                      <?php endif; ?>
                      <?php if (isset($diver['contact']['instagram_url']) && $diver['contact']['instagram_url'] !== ''): ?>
                        <a href="<?= esc_url($diver['contact']['instagram_url']) ?>">
                          <i class="icon icon-instagram-gray"></i>
                        </a>
                      <?php endif; ?>
                    </div>
                  </div>
                </article>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
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
          <div class="bottom-content__wrap">
            <h2 class="bottom-content__title"><?= esc_attr($bottomContentTitle) ?></h2>
            <div class="bottom-content__description"><?= wp_kses_post($bottomContentDescription) ?></div>
            <a href="<?= esc_url($bottomContentButtonLink) ?>" class="bottom-content__button">
              <?= esc_attr($bottomContentButtonTitle) ?> <i class="icon icon-arrow-right"></i>
            </a>
          </div>
        </div>

      </section>

    </div>

<?php
get_footer();
