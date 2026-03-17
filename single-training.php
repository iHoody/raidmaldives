<?php
/**
 * Single page template for Training the post-type
 *
 * @package DiveRaid
 */
 
global $allowedposttags;

$trainingPage = get_page_by_path('training-ground');

get_header(); ?>
    
    <?php if ($trainingPage): ?>
    <?php require_once(get_template_directory().'/template-parts/modal/training-gallery-modal.php'); ?>
        <?php
        $banner = get_field('banner', $trainingPage->ID);
        $bannerBackground = get_template_directory_uri().'/dist/images/single-training-header.jpg' ?? $banner['background_image'];
        ?>
    
        <div class="site-content">
        
            <section class="training-banner site-banner is-single" style="background-image: url('<?= esc_attr($bannerBackground) ?>');">
                <div class="container site-banner__container training-container">
                    <div class="site-information">
                        <h1 class="banner-title"><?= esc_attr(get_the_title()) ?></h1>
                        <p class="banner-description">
                            <i class="icon icon-price"></i>
                            <?= esc_attr('£'.get_field('course_detail')['price'].' per session') ?>
                        </p>
                    </div>
                </div>
            </section>
            
            <section class="training--section">
                <div class="container">
                    
                    <?php
                        $gallery = get_field('gallery');
                        $sidebarGallery = $gallery['sidebar_gallery'];
                        $sidebarGalleryPosition = $sidebarGallery['position'];
                        $sidebarGalleryList = $sidebarGallery['images'];
                        
                        $bottomGallery = $gallery['bottom_gallery'];
                        $bottomGalleryList = $bottomGallery['images'];
                        
                        // Default position
                        $position = 'left';
                        $classPosition = '';
                        if ($sidebarGalleryPosition === 'right') {
                            $classPosition = 'reverse-column';
                        }
                    ?>
                    <div class="row <?= esc_attr($classPosition) ?>">
                        <?php if (count($sidebarGalleryList) > 0): ?>
                            <div class="column column--4">
                                <div class="training--gallery">
                                    <?php foreach ($sidebarGalleryList as $image): ?>
                                        <div class="training--gallery__item">
                                            <img src="<?= esc_attr($image) ?>" alt="<?= esc_attr(get_the_title()) ?>">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="column column--<?= esc_attr(count($sidebarGalleryList) > 0 ? '8' : '12') ?>">
                            <?php
                                $class = '';
                                if (count($sidebarGalleryList) > 0) {
                                    if ($classPosition === 'right') {
                                        $class = 'big-padding-right';
                                    } else {
                                        $class = 'big-padding-left';
                                    }
                                }
                            ?>
                            <div class="training--content <?= esc_attr($class) ?>">
                                <?= wp_kses_post(get_the_content()) ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="training--bottom-gallery">
                        <div class="row">
                            <?php if (count($bottomGalleryList) > 0): ?>
                                <?php foreach ($bottomGalleryList as $image): ?>
                                    <div class="column column--4">
                                        <div class="training--bottom-gallery__item">
                                            <img src="<?= esc_attr($image) ?>" alt="<?= esc_attr(get_the_title()) ?>">
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                </div>
            </section>

            <div class="dive-event-events">
              <div class="container">

                <div class="dive-event-events__wrap section-content">
                  <h2 class="section-title">Available Courses</h2>
                </div>

                <?= getPostContentTypes(get_the_ID()); ?>

              </div>
            </div>
        
        </div>
    
    <?php else: ?>
    
        <div class="site-content">
        
          <div class="container">
            <div class="dive-services__wrap section-content">
              <h2 class="section-title">Sorry! The page could not be found.</h2>
            </div>
          </div>
        
        </div>
    
    <?php endif; ?>

<?php require_once(get_template_directory() . '/template-parts/modal/training-booking-form.php'); ?>
<?php
get_footer();
