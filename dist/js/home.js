document.addEventListener('DOMContentLoaded', function() {
    const home = {
        optionsSwiper: null,
        mobileBreakpoint: 768,

        init: function() {
            this.middleSection();
            this.reviewClient();
            this.accordion();
        },

        accordion: function() {
            this.items = document.querySelectorAll('.site-faq__content-list-item');
            this.toggleAllBtn = document.querySelector('.site-faq__content-button button');
            this.allExpanded = false;

            if (this.items.length === 0) return;

            this.bindEvents();
        },

        bindEvents: function() {
            const self = this;

            this.items.forEach(item => {
                const title = item.querySelector('.site-faq__content-list-title');
                if (title) {
                    title.addEventListener('click', () => self.toggleItem(item));
                }
            });

            if (this.toggleAllBtn) {
                this.toggleAllBtn.addEventListener('click', () => self.toggleAll());
            }
        },

        toggleItem: function(item) {
            item.classList.toggle('is-active');
            this.updateToggleAllState();
        },

        toggleAll: function() {
            this.allExpanded = !this.allExpanded;

            this.items.forEach(item => {
                if (this.allExpanded) {
                    item.classList.add('is-active');
                } else {
                    item.classList.remove('is-active');
                }
            });

            this.updateButtonText();
        },

        updateToggleAllState: function() {
            const activeItems = document.querySelectorAll('.site-faq__content-list-item.is-active');
            this.allExpanded = activeItems.length === this.items.length;
            this.updateButtonText();
        },

        updateButtonText: function() {
            if (this.toggleAllBtn) {
                this.toggleAllBtn.textContent = this.allExpanded ? 'Collapse All' : 'Expand All';
            }
        },

        middleSection: function() {
            const self = this;
            const container = document.querySelector('#swiper-middle-content');

            if (!container) return;

            // Initialize Swiper with breakpoint-based enabled option
            this.optionsSwiper = new Swiper('#swiper-middle-content', {
                slidesPerView: 1,
                spaceBetween: 20,
                enabled: window.innerWidth <= this.mobileBreakpoint,
                pagination: {
                    el: '#swiper-middle-content .swiper-pagination',
                    clickable: true,
                },
                breakpoints: {
                    480: {
                        slidesPerView: 1,
                        spaceBetween: 15,
                    },
                },
                on: {
                    // Runs after resize
                    resize: function() {
                        self.handleResize();
                    }
                }
            });

            // Handle initial state
            this.updateSwiperState();

            // Also listen to window resize as backup
            let resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(() => self.handleResize(), 100);
            });
        },

        handleResize: function() {
            this.updateSwiperState();
        },

        updateSwiperState: function() {
            if (!this.optionsSwiper) return;

            const container = document.querySelector('#swiper-middle-content');

            if (window.innerWidth <= this.mobileBreakpoint) {
                // Enable swiper on mobile
                this.optionsSwiper.enable();
                container.classList.add('swiper-enabled');
                container.classList.remove('swiper-disabled');
            } else {
                // Disable swiper on desktop
                this.optionsSwiper.disable();
                container.classList.remove('swiper-enabled');
                container.classList.add('swiper-disabled');
            }
        },

        reviewClient: function() {
            const container = document.querySelector('#swiper-reviews');

            if (!container) return;

            new Swiper('#swiper-reviews', {
                slidesPerView: 4,
                spaceBetween: 30,
                pagination: {
                    el: '#swiper-reviews .swiper-pagination',
                    clickable: true,
                },
                breakpoints: {
                    320: {
                        slidesPerView: 1,
                        spaceBetween: 10,
                    },
                    768: {
                        slidesPerView: 1,
                        spaceBetween: 20,
                    },
                    992: {
                        slidesPerView: 2,
                        spaceBetween: 25,
                    },
                    1200: {
                        slidesPerView: 4,
                        spaceBetween: 30,
                    },
                },
            });
        }
    };

    home.init();
});