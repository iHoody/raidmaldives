document.addEventListener('DOMContentLoaded', function() {
    const home = {
        optionsSwiper: null,
        blogSwiper: null,
        mobileBreakpoint: 768,

        init: function() {
            this.blogSection();
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

        blogSection: function() {
            const container = document.querySelector('#swiper-blog-posts');
            if (!container) return;

            this.blogSwiper = new Swiper('#swiper-blog-posts', {
                slidesPerView: 1,
                spaceBetween: 20,
                pagination: {
                    el: '#swiper-blog-posts .swiper-pagination',
                    clickable: true,
                },
                breakpoints: {
                    768: {
                        enabled: false,
                    }
                }
            });
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
