(function($) {
    'use strict';

    const BookingModal = {
        modal: null,
        currentPostId: null,
        eventTypes: [],
        checkoutUrl: '',

        init: function() {
            this.modal = $('#booking-modal');
            this.checkoutUrl = diveraidBooking?.checkoutUrl || '/checkout/';
            this.bindEvents();
        },

        bindEvents: function() {
            const self = this;

            // Open modal on book now click
            $(document).on('click', '.book-now', function(e) {
                e.preventDefault();
                const postId = $(this).data('post-id');
                const eventName = $(this).data('event-name') || '';
                self.openModal(postId, eventName);
            });

            // Close modal
            $(document).on('click', '[data-close-modal]', function() {
                self.closeModal();
            });

            // Close on escape key
            $(document).on('keydown', function(e) {
                if (e.key === 'Escape' && self.modal.attr('aria-hidden') === 'false') {
                    self.closeModal();
                }
            });

            // Event type selection change
            $(document).on('change', '#event-type-select', function() {
                const selectedId = $(this).val();
                self.showEventTypeDetails(selectedId);
            });

            // Retry loading
            $(document).on('click', '[data-retry-load]', function() {
                self.loadEventTypes(self.currentPostId);
            });

            // Checkout button click
            $(document).on('click', '.booking-form__checkout-btn', function() {
                if (!$(this).prop('disabled')) {
                    self.proceedToCheckout();
                }
            });
        },

        openModal: function(postId, eventName) {
            this.currentPostId = postId;
            this.modal.find('.booking-modal__event-name').text(eventName);
            this.modal.attr('aria-hidden', 'false');
            $('body').addClass('modal-open');

            // Reset state
            this.resetModal();

            // Load event types
            this.loadEventTypes(postId);
        },

        closeModal: function() {
            this.modal.attr('aria-hidden', 'true');
            $('body').removeClass('modal-open');
            this.currentPostId = null;
            this.eventTypes = [];
        },

        resetModal: function() {
            this.modal.find('.booking-modal__loading').show();
            this.modal.find('.booking-modal__error').hide();
            this.modal.find('.booking-modal__form').hide();
            this.modal.find('.booking-form__details').hide();
            this.modal.find('#event-type-select').val('').html('<option value="">-- Choose an option --</option>');
        },

        loadEventTypes: function(postId) {
            const self = this;

            this.modal.find('.booking-modal__loading').show();
            this.modal.find('.booking-modal__error').hide();
            this.modal.find('.booking-modal__form').hide();

            $.ajax({
                url: diveraidBooking.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'diveraid_get_frontend_event_types',
                    nonce: diveraidBooking.nonce,
                    post_id: postId
                },
                success: function(response) {
                    self.modal.find('.booking-modal__loading').hide();

                    if (response.success && response.data.eventTypes.length > 0) {
                        self.eventTypes = response.data.eventTypes;
                        self.populateSelect(response.data.eventTypes);
                        self.modal.find('.booking-modal__form').show();
                    } else {
                        self.modal.find('.booking-modal__error').show();
                    }
                },
                error: function() {
                    self.modal.find('.booking-modal__loading').hide();
                    self.modal.find('.booking-modal__error').show();
                }
            });
        },

        populateSelect: function(eventTypes) {
            const select = this.modal.find('#event-type-select');
            select.html('<option value="">' + diveraidBooking.strings.chooseOption + '</option>');

            eventTypes.forEach(function(type) {
                const remaining = parseInt(type.capacity) - parseInt(type.booked);
                const availabilityText = remaining > 0
                    ? ' (' + remaining + ' ' + diveraidBooking.strings.spotsLeft + ')'
                    : ' (' + diveraidBooking.strings.soldOut + ')';

                const option = $('<option></option>')
                    .val(type.id)
                    .text(type.name + ' - $' + parseFloat(type.price).toFixed(2) + availabilityText)
                    .data('event-type', type);

                if (remaining <= 0) {
                    option.prop('disabled', true);
                }

                select.append(option);
            });
        },

        showEventTypeDetails: function(eventTypeId) {
            const detailsContainer = this.modal.find('.booking-form__details');
            const checkoutBtn = this.modal.find('.booking-form__checkout-btn');
            const soldOutMsg = this.modal.find('.details-card__sold-out');

            if (!eventTypeId) {
                detailsContainer.hide();
                return;
            }

            const eventType = this.eventTypes.find(t => t.id == eventTypeId);
            if (!eventType) {
                detailsContainer.hide();
                return;
            }

            const remaining = parseInt(eventType.capacity) - parseInt(eventType.booked);

            // Update details card
            this.modal.find('.details-card__name').text(eventType.name);
            this.modal.find('.details-card__price').text('$' + parseFloat(eventType.price).toFixed(2));

            // Format date
            const dateText = eventType.event_date
                ? this.formatDate(eventType.event_date)
                : diveraidBooking.strings.tba;
            this.modal.find('.details-card__date').text(dateText);

            // Format time
            const timeText = eventType.event_time || diveraidBooking.strings.tba;
            this.modal.find('.details-card__time').text(timeText);

            // Availability
            const availabilityText = remaining > 0
                ? remaining + ' of ' + eventType.capacity + ' spots available'
                : 'Fully booked';
            this.modal.find('.details-card__availability')
                .text(availabilityText)
                .toggleClass('sold-out', remaining <= 0);

            // Toggle checkout button / sold out message
            if (remaining > 0) {
                checkoutBtn.show().prop('disabled', false).data('product-id', eventType.product_id);
                soldOutMsg.hide();
            } else {
                checkoutBtn.hide();
                soldOutMsg.show();
            }

            detailsContainer.slideDown(200);
        },

        formatDate: function(dateString) {
            if (!dateString) return '';
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        },

        proceedToCheckout: function() {
            const checkoutBtn = this.modal.find('.booking-form__checkout-btn');
            const productId = checkoutBtn.data('product-id');

            if (!productId) {
                alert(diveraidBooking.strings.error);
                return;
            }

            // Add to cart and redirect to checkout
            checkoutBtn.prop('disabled', true).text(diveraidBooking.strings.processing);

            $.ajax({
                url: diveraidBooking.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'diveraid_add_to_cart',
                    nonce: diveraidBooking.nonce,
                    product_id: productId
                },
                success: function(response) {
                    if (response.success) {
                        window.location.href = response.data.checkout_url;
                    } else {
                        alert(response.data.message || diveraidBooking.strings.error);
                        checkoutBtn.prop('disabled', false).text(diveraidBooking.strings.checkout);
                    }
                },
                error: function() {
                    alert(diveraidBooking.strings.error);
                    checkoutBtn.prop('disabled', false).text(diveraidBooking.strings.checkout);
                }
            });
        }
    };

    // Initialize on DOM ready
    $(document).ready(function() {
        if ($('#booking-modal').length) {
            BookingModal.init();
        }
    });

})(jQuery);