<?php
/**
 * Template Name: Events Template
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

$middleLogo = get_field('middle_content');
$middleLogoImage = $middleLogo['image_logo'];

$bottomContent = get_field('bottom_content');
$bottomContentDescription = $bottomContent['description'];
$bottomContentBackgroundImage = $bottomContent['background_image'];
$bottomContentImage = $bottomContent['image_icon'];
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

      <section class="event-section bg-dark-blue">
        <div class="container">

          <div class="event-section__events">
            <?php
              $args = [
                  'post_type' => 'event',
                  'posts_per_page' => 6,
                  'post_status' => 'publish',
                  'order' => 'DESC',
              ];
              $events = get_posts($args);

              if ($events):
                foreach ($events as $event) : setup_postdata($event); ?>

                  <div class="row event-row">
                    <div class="column column--6">
                      <div class="event-item">
                        <div class="event-item__image">
                          <?php if (has_post_thumbnail($event->ID)) : ?>
                            <img src="<?= esc_url(get_the_post_thumbnail_url($event->ID)) ?>" alt="">
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>
                    <div class="column column--6">
                      <div class="event-item">
                        <div class="event-item__content">
                          <h2><?= wp_kses_post(preg_replace('/^([^:]+)(:)/', '<span>$1</span>$2', $event->post_title)) ?></h2>
                          <div class="event-item__sub-content">
                            <div class="date">
                              <?php
                                $startDate = get_field('start_date', $event->ID);
                                $endDate = get_field('end_date', $event->ID);

                                $date = formatEventDate($startDate);
                                if (isset($endDate) && $endDate !== '') {
                                  $date = formatEventDate($startDate, $endDate);
                                }
                              ?>
                              <i class="icon icon-event"></i> <?= esc_html($date) ?>
                            </div>
                          </div>
                          <div class="event-item__excerpt">
                            <?= wp_kses_post(wp_trim_words(get_the_content(), 50)) ?>
                          </div>
                          <div class="event-item__button">
                            <a href="<?= esc_url(get_permalink($event->ID)) ?>" class="btn btn--primary">
                              <?= esc_attr(get_field('button_title', $event->ID)) ?> <i class="icon icon-arrow-right"></i>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                <?php
                endforeach;
              endif;
              wp_reset_postdata();
            ?>
          </div>
        </div>
      </section>

      <section class="bottom-content-image bg-dark-blue4">
        <div class="container">
          <div class="row">
            <div class="column column--12 align-center">
              <div class="bottom-content-image__details">
                <div class="bottom-content-image__details-image">
                  <img src="<?= esc_url($middleLogoImage) ?>" alt="" />
                </div>
              </div>
            </div>
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
    </div>

<?php
get_footer();
