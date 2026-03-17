<?php
/**
 * Enqueue scripts and styles.
 *
 * @package DiveRaid
 */

defined( 'ABSPATH' ) || exit;

const CURRENT_VERSION = '1.0.26.05';
define("CURRENT_DATE", date('ymdHis'));

/**
 * Enqueue scripts and styles for the theme.
 */
function dive_raid_enqueue_assets(): void {
    wp_enqueue_style(
        'dive-raid-main-style',
        get_template_directory_uri() . '/dist/css/main.css',
        [],
        CURRENT_VERSION.'.'.CURRENT_DATE
    );
    
    // Enqueue compiled SCSS.
    wp_enqueue_style(
        'swiper-css',
        get_template_directory_uri() . '/dist/css/components/swiper-bundle.min.css',
        [],
        CURRENT_VERSION.'.'.CURRENT_DATE
    );
    wp_enqueue_script(
        'swiper-js',
        get_template_directory_uri() . '/dist/js/components/swiper-bundle.min.js',
        [],
        CURRENT_VERSION.'.'.CURRENT_DATE,
        true
    );
    wp_enqueue_script(
        'dive-raid-home',
        get_template_directory_uri() . '/dist/js/home.js',
        ['swiper-js'],
        CURRENT_VERSION.'.'.CURRENT_DATE,
        true
    );
    wp_enqueue_script(
        'common-js',
        get_template_directory_uri() . '/dist/js/common.js',
        [],
        CURRENT_VERSION.'.'.CURRENT_DATE,
        true
    );
    
    if (is_singular('event')) {
        enqueueEventFiles();
    }
    
    if (is_page('dive-centres') || is_singular('event')) {
        enqueueDiveCentresFiles();
    }
    
    if (is_page('checkout')) {
        enqueueCheckoutFiles();
    }
    
    if (is_page('course-of-the-month')) {
        enqueueCourseOfTheMonthFiles();
    }
    
    if (is_page('login')) {
        enqueueLoginFiles();
    }
    
    if (is_page('training-ground') || is_singular('training')) {
        enqueueTrainingFiles();
    }
    
    if (is_singular('training')) {
        enqueueSingleTrainingFiles();
    }
    
    if (is_page('dive-locations-and-trips')) {
        enqueueLocationTrips();
    }
    
    if (is_page('products-and-services') || is_page('gas-fills') || is_page('servicing') || is_page('toolbox')) {
        enqueueProductsAndServicesTrips();
    }
    
    if (is_page('gallery')) {
        enqueueGalleryTrips();
    }
    
    if (is_page('account') || is_page('events')) {
        enqueueAccount();
    }
}
add_action( 'wp_enqueue_scripts', 'dive_raid_enqueue_assets' );

function enqueueAccount(): void
{
    wp_enqueue_style(
        'account-css',
        get_template_directory_uri() . '/dist/css/account.css',
        [],
        CURRENT_VERSION.'.'.CURRENT_DATE
    );
}

function enqueueGalleryTrips(): void
{
    wp_enqueue_style(
        'gallery-css',
        get_template_directory_uri() . '/dist/css/gallery.css',
        [],
        CURRENT_VERSION.'.'.CURRENT_DATE
    );
    wp_enqueue_script(
        'gallery-js',
        get_template_directory_uri() . '/dist/js/gallery.js',
        ['swiper-js'],
        CURRENT_VERSION.'.'.CURRENT_DATE,
        true
    );
}

function enqueueProductsAndServicesTrips(): void
{
    wp_enqueue_style(
        'products-services-css',
        get_template_directory_uri() . '/dist/css/products-services.css',
        [],
        CURRENT_VERSION.'.'.CURRENT_DATE
    );
}

function enqueueLocationTrips(): void
{
    wp_enqueue_style(
        'location-trip-css',
        get_template_directory_uri() . '/dist/css/location-trip.css',
        [],
        CURRENT_VERSION.'.'.CURRENT_DATE
    );
}

function enqueueSingleTrainingFiles(): void
{
    wp_enqueue_script(
        'training-js',
        get_template_directory_uri() . '/dist/js/training.js',
        [],
        CURRENT_VERSION.'.'.CURRENT_DATE,
        true
    );
}

function enqueueTrainingFiles(): void
{
    wp_enqueue_style(
        'training-css',
        get_template_directory_uri() . '/dist/css/training.css',
        [],
        CURRENT_VERSION.'.'.CURRENT_DATE
    );
    wp_enqueue_script(
        'booking-training-js',
        get_template_directory_uri() . '/dist/js/booking-training.js',
        [],
        CURRENT_VERSION.'.'.CURRENT_DATE,
        true
    );
    wp_localize_script('booking-training-js', 'diveraidBookingTraining', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('diveraid_booking_nonce'),
        'checkoutUrl' => function_exists('wc_get_checkout_url') ? wc_get_checkout_url() : '/checkout/',
        'strings' => [
            'chooseOption' => __('-- Choose an option --', 'dive-raid'),
            'spotsLeft' => __('spots left', 'dive-raid'),
            'soldOut' => __('Sold Out', 'dive-raid'),
            'tba' => __('TBA', 'dive-raid'),
            'processing' => __('Processing...', 'dive-raid'),
            'checkout' => __('Proceed to Checkout', 'dive-raid'),
            'error' => __('Something went wrong. Please try again.', 'dive-raid'),
        ]
    ]);
}

function enqueueLoginFiles(): void
{
    wp_enqueue_style(
        'login-css',
        get_template_directory_uri() . '/dist/css/login.css',
        [],
        CURRENT_VERSION.'.'.CURRENT_DATE
    );
    wp_enqueue_script(
        'auth-js',
        get_template_directory_uri() . '/dist/js/auth.js',
        [],
        CURRENT_VERSION.'.'.CURRENT_DATE,
        true
    );
    wp_localize_script('auth-js', 'diveraidAuth', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'signupNonce' => wp_create_nonce('diveraid_signup_nonce'),
        'loginNonce' => wp_create_nonce('diveraid_login_nonce'),
    ]);
}

/**
 * @return void
 */
function enqueueEventFiles(): void
{
    wp_enqueue_style(
        'dive_event-css',
        get_template_directory_uri() . '/dist/css/dive_event.css',
        [],
        CURRENT_VERSION.'.'.CURRENT_DATE
    );
}

/**
 * @return void
 */
function enqueueDiveCentresFiles(): void
{
    wp_enqueue_style(
        'dive_centre-css',
        get_template_directory_uri() . '/dist/css/dive-centre.css',
        [],
        CURRENT_VERSION.'.'.CURRENT_DATE
    );
    wp_enqueue_script(
        'booking-event-js',
        get_template_directory_uri() . '/dist/js/booking-event.js',
        [],
        CURRENT_VERSION.'.'.CURRENT_DATE,
        true
    );
    wp_localize_script('booking-event-js', 'diveraidBooking', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('diveraid_booking_nonce'),
        'checkoutUrl' => function_exists('wc_get_checkout_url') ? wc_get_checkout_url() : '/checkout/',
        'strings' => [
            'chooseOption' => __('-- Choose an option --', 'dive-raid'),
            'spotsLeft' => __('spots left', 'dive-raid'),
            'soldOut' => __('Sold Out', 'dive-raid'),
            'tba' => __('TBA', 'dive-raid'),
            'processing' => __('Processing...', 'dive-raid'),
            'checkout' => __('Proceed to Checkout', 'dive-raid'),
            'error' => __('Something went wrong. Please try again.', 'dive-raid'),
        ]
    ]);
}

/**
 * @return void
 */
function enqueueCheckoutFiles(): void
{
    wp_enqueue_style(
        'woocommerce-css',
        get_template_directory_uri() . '/dist/css/woocommerce.css',
        [],
        CURRENT_VERSION.'.'.CURRENT_DATE
    );
}

/**
 * @return void
 */
function enqueueCourseOfTheMonthFiles(): void
{
    wp_enqueue_style(
        'course-month-css',
        get_template_directory_uri() . '/dist/css/course-month.css',
        [],
        CURRENT_VERSION.'.'.CURRENT_DATE
    );
}