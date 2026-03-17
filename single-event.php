<?php
/**
 * Single page template for Event the post-type
 *
 * @package DiveRaid
 */
 
global $allowedposttags;

$trainingPage = get_page_by_path('training-ground');
get_header(); ?>
    
    <?php if ($trainingPage): ?>
    
        <div class="site-content">
        
            <section class="training-banner site-banner is-single" style="background-image: url('<?= esc_attr($bannerBackground) ?>');">
                <div class="container site-banner__container training-container">
                    <div class="site-information">
                        <h1 class="banner-title"><?= esc_attr(get_the_title()) ?></h1>

                    </div>
                </div>
            </section>
            

        
        </div>
    
    <?php else: ?>
    
        <div class="site-content">
        
        
        
        </div>
    
    <?php endif; ?>

<?php
get_footer();
