<?php
global $allowedposttags;

$banner = get_field('banner');
$bannerBackground = $banner['background_image'];
$bannerTitle = $banner['title'];
$bannerShortDescription = $banner['short_description'];
$buttonTitle = $banner['button_title'];
$buttonLink = $banner['button_link'];

$midContent = get_field('middle_content');
$leftTitle = $midContent['left_title'];
$rightTitle = $midContent['right_description'];
$midOptions = $midContent['options'];

$bookACall = get_field('book_a_call');
$bookATitle = $bookACall['title'];
$bookAContent = $bookACall['description'];
$bookAButtonTitle = $bookACall['button_text'];
$bookAButtonLink = $bookACall['button_url'];

$blog = get_field('blog');
$blogTitle = $blog['title'];
$blogSubTitle = $blog['sub_title'];
$blogButtonTitle = $blog['button_title'];

$postsPage = get_page_by_path('posts');
$blogButtonLink = $postsPage ? get_permalink($postsPage->ID) : '#';
get_header();
?>

<div class="site-content">

  <div class="site-header-background" style="background-image: url('<?= esc_attr($bannerBackground) ?>');"></div>
  <section class="site-header-banner">
    <div class="container site-header-container">
      <div class="site-information">
        <h3 class="site-information__title"><?= wp_kses($bannerTitle, $allowedposttags) ?></h3>
        <div class="site-information__description"><?= wp_kses($bannerShortDescription, $allowedposttags) ?></div>
        <div class="site-information__link">
          <a href="<?= esc_url($buttonLink) ?>">
              <?= esc_attr($buttonTitle) ?>
            <i class="icon icon-arrow-right"></i>
          </a>
        </div>
      </div>
    </div>
  </section>
  
  <section class="site-middle-content">

    <div class="container">
      <div class="site-middle-content__wrap">
        <h2 class="site-middle-content__title"><?= wp_kses($leftTitle, $allowedposttags) ?></h2>
        <div class="site-middle-content__description"><?= wp_kses($rightTitle, $allowedposttags) ?></div>
      </div>
      <div id="swiper-middle-content" class="site-middle-content__options swiper">
        <div class="swiper-wrapper">
          <?php if ($midOptions) : ?>
            <?php foreach ($midOptions as $option) : ?>
              <div class="site-middle-content__option swiper-slide">
                <img src="<?= esc_url($option['image']) ?>" alt="<?= esc_attr($option['title']) ?>">
                <h3><?= esc_attr($option['title']) ?></h3>
                <div class="site-middle-content__option-description"><?= esc_attr($option['description']) ?></div>
                <div class="site-middle-content__option-link">
                  <a href="<?= esc_url($option['button_link']) ?>">
                    <?= esc_attr($option['button_title']) ?>
                    <i class="icon icon-arrow-right"></i>
                  </a>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
        <div class="swiper-pagination"></div>
      </div>
    </div>
    
  </section>
  
  <section class="site-booking">
    <style>
      .site-booking:before {
        background-image: url('<?= esc_url($bookACall['background_image']) ?>');
      }
    </style>
    <div class="container">
      <div class="site-booking__booking-wrap">
        <h2 class="site-booking__title"><?= wp_kses($bookATitle, $allowedposttags) ?></h2>
        <div class="site-booking__description"><?= wp_kses($bookAContent, $allowedposttags) ?></div>
        <a href="<?= esc_url($bookAButtonLink) ?>" class="site-booking__button"><?= esc_attr($bookAButtonTitle) ?> <i class="icon icon-book-call"></i></a>
      </div>
    </div>
    
  </section>
  
  <div class="container">
    <section class="site-blog section-content">

      <h1 class="site-blog__title section-title"><?= esc_attr($blogTitle) ?></h1>
      <h5 class="site-blog__sub-title sub-title"><?= esc_attr($blogSubTitle) ?></h5>

      <div class="site-blog__posts">
        <?php
          $args = [
            'post_type' => 'post',
            'posts_per_page' => 3
          ];
          
          $posts = get_posts($args);
          
          if ($posts):
            foreach ($posts as $post) : setup_postdata($post); ?>

              <article class="site-blog__post">
                <div class="site-blog__post-image">
                  <img src="<?= esc_url(get_the_post_thumbnail_url()) ?>" alt="<?= esc_attr(get_the_title()) ?>">
                </div>
                <h3 class="site-blog__post-title"><?= esc_attr(get_the_title()) ?></h3>
                <div class="site-blog__post-description">
                    <?= wp_kses(get_the_excerpt(), $allowedposttags) ?>
                </div>
                <div class="site-blog__post-button">
                  <a href="<?= esc_url(get_permalink()) ?>">
                    Read more
                    <i class="icon icon-arrow-right-orange"></i>
                  </a>
                </div>
              </article>
            <?php
            endforeach;
          endif;
          wp_reset_postdata();
        ?>
      </div>

      <div class="site-blog__button-wrap">
        <a href="<?= esc_url($blogButtonLink) ?>" class="site-blog__button"><?= esc_attr($blogButtonTitle) ?></a>
      </div>
      
    </section>
  </div>
  
</div>

<?php
get_footer();
?>