<?php
global $allowedposttags;

$banner = get_field('banner');
$bannerBackground = $banner['background_image'];
$bannerImgTitle = $banner['image_title'];
$bannerShortDescription = $banner['short_description'];
$bannerBottomDescription = $banner['bottom_description'];
$buttonTitle = $banner['button_title'];
$buttonLink = $banner['button_link'];

//$midContent = get_field('middle_content');
//$midOptions = $midContent['options'];

$bookACall = get_field('book_a_call');
$bookATitle = $bookACall['title'];
$bookAContent = $bookACall['description'];
$bookAButtonTitle = $bookACall['button_text'];
$bookAButtonTitle2 = $bookACall['button_text_2'];
$bookAButtonLink = $bookACall['button_url'];

$blog = get_field('blog');
$blogTitle = $blog['title'];
$blogSubTitle = $blog['sub_title'];
$blogButtonTitle = $blog['button_title'];

$postsPage = get_page_by_path('blog');
$blogButtonLink = $postsPage ? get_permalink($postsPage->ID) : '#';
get_header();
?>

<div class="site-content">

  <section class="site-header-banner" style="background-image: url('<?= esc_attr($bannerBackground) ?>');">
    <div class="container site-header-container">
      <div class="site-wrap">
        <div class="site-information">
          <?php if ($bannerImgTitle): ?>
            <img src="<?= esc_url($bannerImgTitle) ?>" alt="" >
          <?php endif; ?>
          <div class="site-information__description"><?= wp_kses($bannerShortDescription, $allowedposttags) ?></div>
          <div class="site-information__link">
            <a href="<?= esc_url($buttonLink) ?>">
              <?= esc_attr($buttonTitle) ?>
              <i class="icon icon-arrow-right"></i>
            </a>
          </div>
        </div>
        <div class="site-information transparent">
          <div class="site-information__description smaller"><?= wp_kses($bannerBottomDescription, $allowedposttags) ?></div>
        </div>
      </div>
    </div>
  </section>

  <section class="site-booking book-call">
    <div class="background-filter black light"></div>
    <style>
      .site-booking.book-call:before {
        background-image: url('<?= esc_url($bookACall['background_image']) ?>');
      }
    </style>
    <div class="container">
      <div class="site-booking__booking-wrap">
        <h2 class="site-booking__title"><?= wp_kses($bookATitle, $allowedposttags) ?></h2>
        <div class="site-booking__description"><?= wp_kses($bookAContent, $allowedposttags) ?></div>
        <a href="<?= esc_url($bookAButtonLink) ?>" class="site-booking__button">
          <?= esc_attr($bookAButtonTitle) ?> <i class="icon icon-arrow-right"></i>
          <label><?= esc_attr($bookAButtonTitle2) ?></label>
        </a>
      </div>
    </div>

  </section>

  <div class="container">
    <section class="site-blog section-content">

      <h1 class="site-blog__title section-title"><?= esc_attr($blogTitle) ?></h1>
      <h5 class="site-blog__sub-title sub-title"><?= esc_attr($blogSubTitle) ?></h5>

      <div class="content-desktop">
        <div class="site-blog__posts">
          <?php
            $args = [
                'post_type' => 'post',
                'posts_per_page' => 3
            ];

            $posts = get_posts($args);

            if ($posts):
              echo getFrontPageContentPosts($posts);
            endif;
            wp_reset_postdata();
          ?>
        </div>

        <div class="site-blog__button-wrap">
          <a href="<?= esc_url($blogButtonLink) ?>" class="site-blog__button"><?= esc_attr($blogButtonTitle) ?></a>
        </div>
      </div>

      <div class="content-mobile">
        <div class="site-blog__posts swiper" id="swiper-blog-posts">
          <div class="swiper-wrapper">
            <?php
              if ($posts):
                echo getFrontPageContentPosts($posts, true);
              endif;
              wp_reset_postdata();
            ?>
          </div>
          <div class="swiper-pagination"></div>
        </div>
      </div>

    </section>
  </div>

</div>

<?php
get_footer();
?>
