<?php
/**
 * Template Name: Blog Template
 *
 * @package DiveRaid
 */

global $allowedposttags;


$blog = get_field('blog');
$blogTitle = $blog['title'];
$blogSubTitle = $blog['sub_title'];

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

      <section class="blog-section section-content">
        <div class="container">
          <div class="section-content">
            <h2 class="section-title"><?= esc_attr($blogTitle) ?></h2>
            <h3 class="sub-title"><?= esc_attr($blogSubTitle) ?></h3>
          </div>

          <div class="blog-section__posts">
            <div class="row">
              <?php
                $args = [
                    'post_type' => 'post',
                    'posts_per_page' => 6,
                    'post_status' => 'publish',
                    'order' => 'DESC',
                ];
                $posts = get_posts($args);

                if ($posts):
                  foreach ($posts as $post) : setup_postdata($post); ?>

                    <div class="column column--4 stretch-column">
                      <div class="post-item">
                        <div class="post-item__image">
                          <?php if (has_post_thumbnail($post->ID)) : ?>
                            <img src="<?= esc_url(get_the_post_thumbnail_url($post->ID)) ?>" alt="">
                          <?php endif; ?>
                        </div>
                        <div class="post-item__content">
                          <h2><?= esc_attr($post->post_title) ?></h2>
                          <div class="post-item__sub-content">
                            <div class="author">
                              <i class="icon icon-author"></i> <?= esc_attr(get_the_author()) ?>
                            </div>
                            <div class="date">
                              <i class="icon icon-calendar-blue"></i> Published on: <?= esc_attr(get_the_date('d/M/Y')) ?>
                            </div>
                          </div>
                          <div class="post-item__excerpt">
                            <?= esc_attr(wp_trim_words(get_the_content(), 50)) ?>
                          </div>
                          <div class="post-item__button">
                            <a href="<?= esc_url(get_permalink($post->ID)) ?>" class="btn btn--primary">
                              Read More <i class="icon icon-arrow-right-orange"></i>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>

                  <?php
                  endforeach;
                endif;
                wp_reset_postdata();
              ?>
              <?php if ((int)wp_count_posts()->publish > 6): ?>
                <div class="column column--12 justify-center align-center">
                  <div class="pagination-click">
                    <a href="#" class="btn btn--primary">
                      View More
                    </a>
                  </div>
                </div>
              <?php endif; ?>
            </div>
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
