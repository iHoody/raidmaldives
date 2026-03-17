(function($) {
    'use strict';

    let common = {
        gallery: function() {
            const galleryItem = document.querySelectorAll('.gallery-item');

            const swiperContainer = document.createElement('div');
            swiperContainer.classList.add('swiper-container-fullscreen');

            // Inner swiper structure
            swiperContainer.innerHTML = `
                <div class="swiper">
                    <div class="swiper-wrapper"></div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-pagination"></div>
                </div>
                <button class="swiper-close"></button>
            `;
            document.body.appendChild(swiperContainer);

            const swiperWrapper = swiperContainer.querySelector('.swiper-wrapper');
            const closeButton = swiperContainer.querySelector('.swiper-close');
            let swiperInstance;

            // Close button event
            // When closing the gallery, destroy the swiper instance
            closeButton.addEventListener('click', function() {
                swiperContainer.style.display = 'none';
                if (swiperInstance) {
                    swiperInstance.destroy(true, true);
                }
            });

            // Click event on the `.gallery-item` element
            if (galleryItem) {
                galleryItem.forEach(item => {

                    item.addEventListener('click', function() {

                        const imagesEl = item.querySelector('.gallery-images');
                        if (!imagesEl) return;

                        const images = imagesEl.dataset.images.split(',').map(image => image.trim());

                        // Clear the previous slides
                        swiperWrapper.innerHTML = '';

                        // Create new slides
                        images.forEach(image => {
                            const slide = document.createElement('div');
                            slide.classList.add('swiper-slide');
                            // TODO: move to CSS
                            slide.innerHTML = `<img src="${image}" alt="" >`;
                            swiperWrapper.appendChild(slide);
                        });

                        // Display contianer
                        swiperContainer.style.display = 'flex';

                        // Initialize swiper
                        swiperInstance = new Swiper(document.querySelector('.swiper-container-fullscreen .swiper'), {
                            loop: true,
                            pagination: {
                                el: '.swiper-pagination',
                                type: 'bullets',
                                clickable: true,
                            },
                            navigation: {
                                nextEl: '.swiper-button-next',
                                prevEl: '.swiper-button-prev',
                            },
                            keyboard: {
                                enabled: true,
                                onlyInViewport: true,
                            }
                        });
                    })

                });
            }
        },

        init: function() {
            this.gallery();
        }
    };

    document.addEventListener('DOMContentLoaded', function () {
        common.init();
    });

})(jQuery);