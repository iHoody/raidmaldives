<?php
/**
 * Template Name: Blog Posts Template
 *
 * @package DiveRaid
 */

global $allowedposttags;

$banner = get_field('banner', 'option');
$bannerBackground = $banner['background_image'];
get_header();
?>
    
    <div class="site-content">
        
        <section class="posts-banner site-banner" style="background-image: url('<?= esc_attr($bannerBackground) ?>');">
            <div class="container site-banner__container posts-container">
                <div class="site-information">
                    <h1 class="banner-title">
                        Recent Blogs and Updates
                    </h1>
                </div>
            </div>
        </section>
      
        <section class="posts-section">
          <div class="container">
          
            <div class="row">
              <?php
                $args = [
                    'post_type' => 'post',
                    'orderby' => 'date',
                    'order' => 'DESC'
                ];
                $events = new WP_Query($args);

                if ($events->have_posts()):
                  while ($events->have_posts()) : $events->the_post(); ?>
                    <div class="column column--6">
                      <div class="posts__item">
                        <div class="posts__item-image">
                          <?php if (has_post_thumbnail()) : ?>
                            <?= get_the_post_thumbnail(null, 'thumbnail') ?>
                          <?php else : ?>
                            <img src="https://picsum.photos/200/300" alt="Placeholder">
                          <?php endif; ?>
                        </div>
                        <div class="posts__item-details">
                          <h3 class="posts__item-title"><?= esc_attr(get_the_title()) ?></h3>
                          <div class="posts__item-date">
                            <span><?= esc_attr(get_the_date()) ?></span>
                          </div>
                          <div class="posts__item-description">
                            <?= wp_kses(get_the_excerpt(), $allowedposttags) ?>
                          </div>
                          <div class="posts__item-button">
                            <a href="<?= esc_url(get_permalink()) ?>" class="posts__item-button view-details">Read More <i class="icon icon-arrow-right"></i></a>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php endwhile;
                  wp_reset_postdata();
                endif;
              ?>
            </div>
          
          </div>
        </section>
        
    </div>

<?php
get_footer();
