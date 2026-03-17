<?php
/**
 * Template Name: Course of the Month Template
 *
 * @package DiveRaid
 */

global $allowedposttags;

$banner = get_field('banner');
$bannerBackground = $banner['background_image'];
$bannerTagTitle = $banner['tags'];
$bannerDescription = $banner['description'];

$course = get_field('course');
$courseTitle = $course['title'];
$courseFeaturedCourse = $course['featured_course'];

$howItWorks = get_field('how_it_works_section');
$howItWorksTitle = $howItWorks['title'];
$howItWorksSubTitle = $howItWorks['sub_title'];
$howItWorksInstructions = $howItWorks['instructions'];

$benefits = get_field('benefits');
$benefitsTitle = $benefits['title'];
$benefitsDescription = $benefits['sub_title'];
$benefitsList = $benefits['benefits'];
get_header();
?>
    
  <div class="site-content">

    <section class="course-month-banner site-banner" style="background-image: url('<?= esc_attr($bannerBackground) ?>');">
      <div class="container site-banner__container course-month__container">
        <div class="site-information">
          <div class="course-month__tagline">
            <h4><i class="icon icon-calendar"></i><?= esc_attr($bannerTagTitle) ?></h4>
          </div>
          <h1 class="banner-title"><?= esc_attr(get_the_title()) ?></h1>
          <p class="banner-description"><?= esc_attr($bannerDescription) ?></p>
        </div>
      </div>
    </section>
    
    <section class="featured-course">
      <div class="container">
      
        <div class="featured-course__wrap">
          <div class="featured-course__wrap-tagline">
            <h5><?= esc_attr($courseTitle) ?></h5>
          </div>
          <h2 class="featured-course__wrap-title"><?= esc_attr(date('M').' '.date('Y')) ?></h2>
        
          <?php if($courseFeaturedCourse): ?>
            <?php
            $coursePriceArr = get_field('course_price', $courseFeaturedCourse->ID);
            $coursePrice = $coursePriceArr['price'];
            
            $courseHighlights = get_field('course_highlights', $courseFeaturedCourse->ID);
            
            $coursePrerequisites = get_field('prerequisites', $courseFeaturedCourse->ID);
            $coursePrerequisitesTitle = $coursePrerequisites['title'];
            $coursePrerequisitesDescription = $coursePrerequisites['description'];
            
            $courseAbout = get_field('about_this_course', $courseFeaturedCourse->ID);
            $courseAboutTitle = $courseAbout['title'];
            $courseAboutDescription = $courseAbout['description'];
            
            $downloadableMaterials = get_field('course_materials', $courseFeaturedCourse->ID);
            $files = $downloadableMaterials['downloadable_course_material'];
            ?>
            <div class="featured-course__wrap-course">
              
              <div class="featured-course__wrap-image">
                <?php if (has_post_thumbnail($courseFeaturedCourse->ID)) : ?>
                  <div class="price-content">
                    <div class="price-label">EARN</div>
                    <div class="price"><?= esc_attr($coursePrice) ?></div>
                    <div class="price-label bottom">per certification</div>
                  </div>
                  <?= get_the_post_thumbnail($courseFeaturedCourse->ID, 'large') ?>
                <?php endif; ?>
              </div>
              
              <div class="featured-course__wrap-details">
                
                <h3><?= esc_attr(get_the_title($courseFeaturedCourse->ID)) ?></h3>
                <div class="taglines">
                  <?php
                    $specialties = get_the_terms($courseFeaturedCourse->ID, 'course-category');
                    if ($specialties && !is_wp_error($specialties)) :
                      foreach ($specialties as $specialty) : ?>
                        <div class="tagline specialty"><?= esc_attr($specialty->name) ?></div>
                      <?php endforeach;
                    endif;
                  ?>
                  <?php
                    $durations = get_the_terms($courseFeaturedCourse->ID, 'course-duration');
                    if ($durations && !is_wp_error($durations)) :
                      foreach ($durations as $duration) : ?>
                        <div class="tagline duration"><?= esc_attr($duration->name) ?></div>
                      <?php endforeach;
                    endif;
                  ?>
                </div>
                
                <div class="description">
                  <?= wp_kses($courseFeaturedCourse->post_content, $allowedposttags) ?>
                </div>
                
                <?php if ($courseHighlights): ?>
                  <div class="course-highlights">
                    <h4>Course Highlights:</h4>
                    <?php foreach($courseHighlights as $highlight): ?>
                      <div class="highlight"><i class="icon icon-check"></i><?= esc_attr($highlight['highlights']) ?></div>
                    <?php endforeach; ?>
                  </div>
                <?php endif; ?>
                
                <?php if ($coursePrerequisites): ?>
                  <div class="prerequisites">
                    <?php foreach($coursePrerequisites as $prerequisite): ?>
                      <div class="prerequisite">
                        <h4><?= esc_attr($prerequisite['title']) ?></h4>
                        <div class="description">
                          <?= wp_kses($prerequisite['description'], $allowedposttags) ?>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  </div>
                <?php endif; ?>
                
                <div class="about-this-course">
                  <h5><?= esc_attr($courseAboutTitle) ?></h5>
                  <div class="description">
                    <?= wp_kses($courseAboutDescription, $allowedposttags) ?>
                  </div>
                </div>

                <div class="downloadable-material">
                  <a href="<?= esc_url($files) ?>">Download Course Materials <i class="icon icon-arrow-right"></i></a>
                </div>
                
              </div>
            </div>
          <?php endif; ?>
        
        </div>
      
      </div>
    </section>

    <section class="how-it-works section-content">
      <div class="how-it-works__wrap">
        <h2 class="how-it-works__wrap-title section-title"><?= esc_attr($howItWorksTitle) ?></h2>
        <div class="how-it-works__wrap-description sub-title"><?= esc_attr($howItWorksSubTitle) ?></div>
      </div>
      <div class="how-it-works__process">
        <?php if ($howItWorksInstructions) : ?>
          <?php foreach ($howItWorksInstructions as $key => $instruction) : ?>
            <div class="how-it-works__process-item">
              <div class="how-it-works__process-item-number"><span><?= esc_attr($key+1) ?></span></div>
              <div class="how-it-works__process-item-title"><?= esc_attr($instruction['title']) ?></div>
              <div class="how-it-works__process-item-description"><?= esc_attr($instruction['description']) ?></div>
              <div class="how-it-works__process-item-line"></div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </section>

    <section class="benefit section-content">
      <div class="benefit__wrap">
        <h2 class="benefit__wrap-title section-title"><?= esc_attr($benefitsTitle) ?></h2>
        <div class="benefit__wrap-description sub-title"><?= esc_attr($benefitsDescription) ?></div>
      </div>
      <div class="benefit__list">
        <?php if ($benefitsList) : ?>
          <?php foreach ($benefitsList as $benefit) : ?>
            <div class="benefit__list-item">
              <div class="benefit__list-item-icon">
                <img src="<?= esc_attr($benefit['icon']) ?>" alt="<?= esc_attr($benefit['title']) ?>">
              </div>
              <div class="benefit__list-item-title"><?= esc_attr($benefit['title']) ?></div>
              <div class="benefit__list-item-description"><?= esc_attr($benefit['sub_title']) ?></div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </section>
  
  </div>

<?php
get_footer();
