<?php
/**
 * Template Name: Products and Services Template
 *
 * @package DiveRaid
 */

global $allowedposttags;

$banner = get_field('banner');
$bannerBackground = $banner['background_image'];
$bannerTitle = $banner['title'];
$bannerSubTitle = $banner['sub_title'];

$productServices = get_field('middle_content');
$servicesTitle = $productServices['title'];
$servicesDescription = $productServices['description'];
$servicesImages = $productServices['images'];

$services = get_field('services');
get_header();
?>
    
    <div class="site-content">
        
        <section class="products-services-banner site-banner" style="background-image: url('<?= esc_attr($bannerBackground) ?>');">
            <div class="container site-banner__container products-services-container">
                <div class="site-information">
                    <h1 class="banner-title"><?= esc_attr($bannerTitle) ?></h1>
                    <p class="banner-description"><?= esc_attr($bannerSubTitle) ?></p>
                </div>
            </div>
        </section>

        <section class="products-services-section">

          <div class="container">

            <div class="row">
              <div class="column column--12">

                <div class="products-services__content">
                  <h2><?= esc_attr($servicesTitle) ?></h2>
                  <div class="products-services__content-description">
                    <?= wp_kses($servicesDescription, $allowedposttags) ?>
                  </div>
                  <?php if ($servicesImages): ?>
                    <div class="products-services__content-images">
                      <?php foreach($servicesImages as $image): ?>
                        <div class="products-services__content-images__image">
                          <img src="<?= esc_attr($image['image']) ?>" alt="<?= esc_attr($servicesTitle) ?>">
                        </div>
                      <?php endforeach; ?>
                    </div>
                  <?php endif; ?>
                </div>

              </div>
            </div>

          </div>

        </section>

        <section class="services-section">

          <div class="container">
            <div class="services__list row">

              <?php if ($services): ?>
                <?php foreach($services as $service): ?>

                  <div class="column column--12 services__list-item">
                    <div class="services__list-item__details">
                      <div class="services__list-item__details-image">
                        <img src="<?= esc_attr($service['image']) ?>" alt="<?= esc_attr($service['title']) ?>">
                      </div>
                      <div class="services__list-item__details-content">
                        <h3><?= esc_attr($service['title']) ?></h3>
                        <div class="details"><?= wp_kses_post($service['description']) ?></div>
                      </div>
                    </div>
                  </div>

                <?php endforeach; ?>
              <?php endif; ?>

            </div>
          </div>

        </section>
    
    </div>

<?php
get_footer();
