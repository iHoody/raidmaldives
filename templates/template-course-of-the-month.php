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
$centreBenefitsList = $centreBenefits['benefits'];

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
      <div class="middle-content__details">
        <?= wp_kses_post($middleContentData) ?>
      </div>
    </section>

  </div>

<?php
get_footer();
