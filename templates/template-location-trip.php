<?php
/**
 * Template Name: Location and Trip Template
 *
 * @package DiveRaid
 */

global $allowedposttags;

$banner = get_field('banner');
$bannerBackground = $banner['background_image'];
$bannerTitle = $banner['title'];
$bannerDescription = $banner['description'];

$whyChoose = get_field('why_choose');
$whyChooseTitle = $whyChoose['title'];
$whyChooseLists = $whyChoose['list'];

$diveLocations = get_field('dive_locations');
$diveLocationsTitle = $diveLocations['title'];
$diveLocationsPosts = $diveLocations['posts'];

$diveTrips = get_field('trips');
$diveTripsTitle = $diveTrips['title'];
$diveTripsPosts = $diveTrips['posts'];
get_header();
?>
    
    <div class="site-content">
        
        <section class="loc-trip-banner site-banner" style="background-image: url('<?= esc_attr($bannerBackground) ?>');">
            <div class="container site-banner__container loc-trip-container">
                <div class="site-information">
                    <h1 class="banner-title"><?= esc_attr($bannerTitle) ?></h1>
                    <p class="banner-description"><?= esc_attr($bannerDescription) ?></p>
                </div>
            </div>
        </section>
        
        <section class="why-choose">
            <div class="container">
                
                <div class="why-choose__wrap section-content">
                    <h2 class="section-title"><?= esc_attr($whyChooseTitle) ?></h2>
                    
                    <div class="why-choose__wrap-services section-services">
                        <?php foreach ($whyChooseLists as $service) : ?>
                            <div class="service-wrap">
                                <div class="service-icon">
                                    <img src="<?= esc_attr($service['icon']) ?>" alt="<?= esc_attr($service['title']) ?>">
                                </div>
                                <div class="service-title"><?= esc_attr($service['title']) ?></div>
                                <div class="service-sub-title"><?= esc_attr($service['description']) ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            
            </div>
        </section>
        
        <section class="dive-location-section dive-post-section">
            
            <div class="container">
                
                <div class="why-choose__wrap section-content">
                    <h2 class="section-title"><?= esc_attr($diveLocationsTitle) ?></h2>
                </div>
                
                <div class="row">
                    <?php if ($diveLocationsPosts) : ?>
                        <?php foreach ($diveLocationsPosts as $post) : ?>
                            <div class="column column--4">
                                <div class="dive-location-item dive-post-item">
                                    <div class="dive-location-item__image dive-post-item__image">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <?= get_the_post_thumbnail($post->ID, 'thumbnail') ?>
                                        <?php endif; ?>
                                    </div>
                                    <div class="dive-post-item__details">
                                        <h3 class="dive-location-item__title dive-post-item__title"><?= esc_attr($post->post_title) ?></h3>
                                        <div class="dive-location-item__sub-title dive-post-item__sub-title"><?= esc_attr(get_field('sub_title', $post->ID)) ?></div>
                                        <div class="dive-location-item__description dive-post-item__description">
                                            <p><?= wp_kses_post(get_field('summary', $post->ID)) ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            
            </div>
        
        </section>
        
        <section class="dive-trip-section dive-post-section">
            
            <div class="container">
                
                <div class="why-choose__wrap section-content">
                    <h2 class="section-title"><?= esc_attr($diveTripsTitle) ?></h2>
                </div>
                
                <div class="row">
                    <?php if ($diveTripsPosts) : ?>
                        <?php foreach ($diveTripsPosts as $post) : ?>
                            <div class="column column--4">
                                <div class="dive-trip-item dive-post-item">
                                    <div class="dive-trip-item__image dive-post-item__image">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <?= get_the_post_thumbnail($post->ID, 'thumbnail') ?>
                                        <?php else : ?>
                                            <div class="dive-post-item__video-placeholder"></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="dive-post-item__details">
                                        <h3 class="dive-trip-item__title dive-post-item__title"><?= esc_attr($post->post_title) ?></h3>
                                        <?php
                                            $dateText = 'TBD';
                                            $date = get_field('date', $post->ID);
                                            
                                            if (! empty($date)) {
                                                $eventTimestamp = strtotime($date);
                                                $today = current_time('Y-m-d');
                                                
                                                if (date('Y-m-d', $eventTimestamp) !== $today) {
                                                    $dateText = date('d M Y g:i a', $eventTimestamp);
                                                }
                                            }
                                        ?>
                                        <div class="dive-trip-item__sub-title dive-post-item__sub-title"><?= esc_attr($dateText) ?></div>
                                        <div class="dive-trip-item__description dive-post-item__description">
                                            <h4 class="header-description">Trip Details</h4>
                                            <p><?= wp_kses_post($post->post_content) ?></p>
                                        </div>
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
