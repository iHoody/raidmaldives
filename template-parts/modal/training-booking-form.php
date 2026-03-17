<?php
/**
 * Event Booking Modal Template
 *
 * @package DiveRaid
 */
?>

<div id="booking-modal" class="booking-modal" aria-hidden="true">
    <div class="booking-modal__overlay" data-close-modal></div>
    <div class="booking-modal__container">
        <button class="booking-modal__close" data-close-modal aria-label="<?php esc_attr_e('Close modal', 'dive-raid'); ?>">
            <span aria-hidden="true">&times;</span>
        </button>
        
        <div class="booking-modal__content">
            <div class="booking-modal__header">
                <h2 class="booking-modal__title"><?php esc_html_e('Enroll your Training Course', 'dive-raid'); ?></h2>
                <p class="booking-modal__event-name"></p>
            </div>
            
            <div class="booking-modal__body">
                <!-- Loading State -->
                <div class="booking-modal__loading">
                    <div class="spinner"></div>
                    <p><?php esc_html_e('Loading available options...', 'dive-raid'); ?></p>
                </div>
                
                <!-- Error State -->
                <div class="booking-modal__error" style="display: none;">
                    <p><?php esc_html_e('Unable to load booking options. Please try again.', 'dive-raid'); ?></p>
                    <button class="btn btn-secondary" data-retry-load><?php esc_html_e('Retry', 'dive-raid'); ?></button>
                </div>
                
                <!-- Booking Form -->
                <div class="booking-modal__form" style="display: none;">
                    <div class="booking-form__field">
                        <label for="event-type-select"><?php esc_html_e('Select Training Course', 'dive-raid'); ?></label>
                        <select id="event-type-select" class="booking-form__select">
                            <option value=""><?php esc_html_e('-- Choose an option --', 'dive-raid'); ?></option>
                        </select>
                    </div>
                    
                    <!-- Event Type Details (shown after selection) -->
                    <div class="booking-form__details" style="display: none;">
                        <div class="booking-form__details-card">
                            <div class="details-card__header">
                                <h3 class="details-card__name"></h3>
                                <span class="details-card__price"></span>
                            </div>
                            
                            <div class="details-card__info">
                                <div class="details-card__row">
                                    <span class="details-card__label"><?php esc_html_e('Date:', 'dive-raid'); ?></span>
                                    <span class="details-card__value details-card__date"></span>
                                </div>
                                <div class="details-card__row">
                                    <span class="details-card__label"><?php esc_html_e('Time:', 'dive-raid'); ?></span>
                                    <span class="details-card__value details-card__time"></span>
                                </div>
                                <div class="details-card__row">
                                    <span class="details-card__label"><?php esc_html_e('Availability:', 'dive-raid'); ?></span>
                                    <span class="details-card__value details-card__availability"></span>
                                </div>
                            </div>
                            
                            <div class="details-card__actions">
                                <button type="button" class="btn btn-primary booking-form__checkout-btn" disabled>
                                    <?php esc_html_e('Proceed to Checkout', 'dive-raid'); ?>
                                </button>
                                <p class="details-card__sold-out" style="display: none;">
                                    <?php esc_html_e('Sorry, this option is fully booked.', 'dive-raid'); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>