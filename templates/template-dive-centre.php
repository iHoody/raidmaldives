<?php
/**
 * Template Name: Dive Centre Template
 *
 * @package DiveRaid
 */

global $allowedposttags;

$banner = get_field('banner');
$bannerBackground = $banner['background_image'];
$bannerShortDescription = get_the_content();
$buttonTitle = $banner['button_title'];
$buttonLink = $banner['button_url'];
$statistics = $banner['statistics'];

$services = get_field('why_choose_section');
$servicesTitle = $services['title'];
$servicesLists = $services['services'];
get_header();
?>
    
    <div class="site-content">
        
        <section class="dive-centre-banner site-banner" style="background-image: url('<?= esc_attr($bannerBackground) ?>');">
            <div class="container site-banner__container dive-centre-container">
                <div class="site-information">
                    <div class="site-information__description">
                        <?= wp_kses($bannerShortDescription, $allowedposttags) ?>
                    </div>
                  <div class="site-information__statistics">
                    <?php foreach ($statistics as $statistic) : ?>
                        <div class="site-information__statistic">
                            <div class="site-information__statistic-number"><?= esc_attr($statistic['numbers']) ?></div>
                            <div class="site-information__statistic-text"><?= esc_attr($statistic['title']) ?></div>
                        </div>
                    <?php endforeach; ?>
                  </div>
                    <div class="site-information__link">
                        <a href="<?= esc_url($buttonLink) ?>">
                            <?= esc_attr($buttonTitle) ?>
                            <i class="icon icon-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>
      
        <section class="dive-services">
          <div class="container">
            
            <div class="dive-services__wrap section-content">
              <h2 class="section-title"><?= esc_attr($servicesTitle) ?></h2>
            
              <div class="dive-services__wrap-services section-services">
                <?php foreach ($servicesLists as $service) : ?>
                  <div class="service-wrap">
                    <div class="service-icon">
                      <img src="<?= esc_attr($service['icon']) ?>" alt="<?= esc_attr($service['title']) ?>">
                    </div>
                    <div class="service-title"><?= esc_attr($service['title']) ?></div>
                    <div class="service-sub-title"><?= esc_attr($service['sub_title']) ?></div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
            
          </div>
        </section>
      
        <section class="dive-events-section">
          <div class="container">
          
            <div class="dive-events__list">
              <?php
                $args = [
                  'post_type' => 'event',
                  'orderby' => 'date',
                  'order' => 'DESC'
                ];
                $events = new WP_Query($args);
                
                if ($events->have_posts()):
                  while ($events->have_posts()) : $events->the_post(); ?>
                    <div class="dive-events__item">
                      <div class="dive-events__item-image">
                        <?php if (has_post_thumbnail()) : ?>
                          <?= get_the_post_thumbnail(null, 'thumbnail') ?>
                        <?php endif; ?>
                      </div>
                      <div class="dive-events__item-details">
                        <?php
                        $eventDateTime = '';

                        $eventDate = get_field('event_date', get_the_ID());
                        $eventStartTime = get_field('event_start_time', get_the_ID());
                        $eventEndTime = get_field('event_end_time', get_the_ID());

                        if (isset($eventDate)) {
                          $eventDateTime = $eventDate;
                        }

                        if ($eventStartTime !== '') {
                          $eventDateTime = $eventDate . ' ' . $eventStartTime;
                        }

                        if ($eventStartTime !== '' && $eventEndTime !== '') {
                          $eventDateTime = $eventDate . ' ' . $eventStartTime . ' - ' . $eventEndTime;
                        }
                        ?>
                        <div class="dive-events__item-date">
                          <span><?= esc_attr($eventDateTime) ?></span>
                        </div>
                        <h3 class="dive-events__item-title"><?= esc_attr(get_the_title()) ?></h3>
                        <div class="dive-events__item-location">
                          <i class="icon icon-location"></i>
                          <?= esc_attr(get_field('location', get_the_ID())) ?>
                        </div>
                        <div class="dive-events__item-description">
                          <?= wp_kses(get_the_excerpt(), $allowedposttags) ?>
                        </div>
                        <div class="dive-events__item-categories">
                          <h5>Specialties:</h5>
                          <div class="specialties">
                            <?php
                              $specialties = get_the_terms(get_the_ID(), 'specialties');
                              if ($specialties && !is_wp_error($specialties)) :
                                foreach ($specialties as $specialty) : ?>
                                  <div class="specialty"><?= esc_attr($specialty->name) ?></div>
                                <?php endforeach;
                              endif;
                            ?>
                          </div>
                        </div>
                        <div class="dive-events__item-buttons">
                          <a href="<?= esc_url(get_permalink()) ?>" class="dive-events__item-button view-details">View Details <i class="icon icon-arrow-right-blue"></i></a>
                          <a href="#" class="dive-events__item-button book-now"
                             data-post-id="<?= esc_attr(get_the_ID()) ?>"
                             data-event-date="<?= esc_attr($eventDate) ?>"
                             data-event-start-time="<?= esc_attr($eventStartTime) ?>"
                             data-event-end-time="<?= esc_attr($eventEndTime) ?>"
                             data-event-name="<?= esc_attr(get_the_title()) ?>">
                              <?php esc_html_e('Book Now', 'dive-raid'); ?>
                          </a>
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

<?php require_once(get_template_directory() . '/template-parts/modal/event-booking-form.php'); ?>
<?php
get_footer();
