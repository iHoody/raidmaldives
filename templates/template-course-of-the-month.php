<?php
/**
 * Template Name: Course of the Month Template
 *
 * @package DiveRaid
 */

global $allowedposttags;

$banner = get_field('banner');
$bannerBackground = $banner['background_image'];
$bannerTitle = $banner['title'];
$bannerDescription = $banner['description'];
$bannerButtonTitle = $banner['buttons']['title'];
$bannerButtonSubTitle = $banner['buttons']['sub_title'];
$bannerButtonLink = $banner['button']['url'];

$middleContent = get_field('middle_content');
$middleContentData = $middleContent['content_title'];

$centreBenefits = get_field('centre_benefits');
$centreBenefitsTitle = $centreBenefits['title'];
$centreBenefitsDescription = $centreBenefits['description'];

$contentPosts = get_field('content_posts');
$contentPostsList = $contentPosts['posts'];

$bottomContent = get_field('bottom_content');
$bottomContentTitle = $bottomContent['title'];
$bottomContentDescription = $bottomContent['description'];
$bottomContentBackgroundImage = $bottomContent['background_image'];
$bottomContentButtonTitle = $bottomContent['button_title'];
$bottomContentButtonLink = $bottomContent['button_link'];
get_header();
?>

  <div class="site-content">

    <section class="course-month-banner site-banner" style="background-image: url('<?= esc_attr($bannerBackground) ?>');">
      <div class="container site-banner__container course-month__container">
        <div class="site-information">
          <h1 class="banner-title"><?= esc_attr(get_the_title()) ?></h1>
          <p class="banner-description"><?= esc_attr($bannerDescription) ?></p>
          <div class="button-section">
            <a href="<?= esc_url($bannerButtonLink) ?>">
              <?= esc_attr($bannerButtonTitle) ?> <i class="icon icon-arrow-right"></i>
              <label><?= esc_attr($bannerButtonSubTitle) ?></label>
            </a>
          </div>
        </div>
      </div>
    </section>

    <section class="middle-content">
      <div class="container">
        <div class="row justify-center-grid">
          <div class="column column--1"></div>
          <div class="column column--10">
            <div class="middle-content__details">
              <?= wp_kses_post($middleContentData) ?>
            </div>
          </div>
          <div class="column column--1"></div>
        </div>
      </div>
    </section>

    <section class="benefits">
      <div class="container">

        <div class="row">
          <div class="column column--6 justify-center align-center">
            <div class="benefits__wrap">
              <h2 class="benefits__wrap-title"><?= esc_attr($centreBenefitsTitle) ?></h2>
            </div>
          </div>
          <div class="column column--6">
            <div class="benefits__wrap">
              <div class="benefits__wrap-description"><?= wp_kses_post($centreBenefitsDescription) ?></div>
            </div>
          </div>
          <div class="column column--12">
            <div class="benefits__wrap">
              <?php if ($contentPostsList) : ?>
                <div class="benefits__wrap-list">
                  <?php foreach ($contentPostsList as $post) : ?>
                    <div class="benefits__wrap-list__item">
                      <div class="benefit-item">
                        <div class="benefit-item__image">
                          <img src="<?= esc_attr($post['image']) ?>" alt="<?= esc_attr(strip_tags($post['month_display'])) ?>">
                        </div>
                        <div class="benefit-item__content">
                          <h5 class="benefit-item__content-title"><?= wp_kses_post($post['month_display']) ?></h5>
                          <p class="benefit-item__content-description"><?= wp_kses_post($post['decompression']) ?></p>
                        </div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>

      </div>
    </section>

    <section class="training-posts">

      <div class="container">
        <div class="post-content-desktop">
          <div class="posts__content">
            <?= wp_kses_post(getTrainingPostList($contentPostsList)) ?>
          </div>
        </div>
        <div class="post-content-mobile">
          <div class="posts__content">
            <div class="post-training-content swiper" id="swiper-training-posts">
              <div class="swiper-wrapper">
                <?= wp_kses_post(getTrainingPostList($contentPostsList, true)) ?>
              </div>
              <div class="swiper-pagination"></div>
            </div>
          </div>
        </div>
      </div>

    </section>

  </div>

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

<?php
get_footer();
