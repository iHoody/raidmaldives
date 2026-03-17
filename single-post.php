<?php
/**
 * Single page template for Training the post-type
 *
 * @package DiveRaid
 */
 
global $allowedposttags;

$banner = get_field('banner', 'option');
$bannerBackground = $banner['background_image'];

$trainingPage = get_page_by_path('training-ground');

get_header(); ?>

  <div class="site-content">

    <section class="dive-event-banner site-banner" style="background-image: url('<?= esc_attr($bannerBackground) ?>');">
      <div class="container site-banner__container dive-event-container">
        <div class="site-information">
          <h1 class="banner-title">
            <?= esc_attr(get_the_title()) ?>
          </h1>
        </div>
      </div>
    </section>

    <section class="dive-event-content">

      <div class="container">

        <div class="row">


          <?php if (has_post_thumbnail()) : ?>
            <div class="column column--4">
              <div class="dive-event-content__images">
                <img src="<?= esc_attr(get_the_post_thumbnail_url()) ?>" alt="<?= esc_attr(get_the_title()) ?>">
              </div>
            </div>
          <?php endif; ?>
          <div class="column column--<?= esc_attr(has_post_thumbnail() ? '8' : '12') ?>">
            <div class="dive-event-content__details">
              <?= wp_kses_post(get_the_content()) ?>
            </div>
          </div>

        </div>

      </div>

    </section>

  </div>

<?php
get_footer();
