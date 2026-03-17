(function($) {
    'use strict';

    let common = {
        gallery: function() {

            const modal = document.querySelector('.gallery-modal');
            const mainWrapper = modal.querySelector('.gallery-main .swiper-wrapper');
            const thumbsWrapper = modal.querySelector('.gallery-thumbs .swiper-wrapper');

            let mainSwiper, thumbsSwiper;

            const images = document.querySelectorAll('.training--bottom-gallery__item img');

            if (images.length > 0) {
                images.forEach((img, index) => {

                    img.addEventListener('click', () => {

                        // clear elements
                        mainWrapper.innerHTML = '';
                        thumbsWrapper.innerHTML = '';

                        images.forEach((image, i) => {
                            const src = image.src;

                            mainWrapper.innerHTML += `
                                <div class="swiper-slide">
                                    <img src="${src}" alt="image">
                                </div>
                            `;

                            thumbsWrapper.innerHTML += `
                                <div class="swiper-slide">
                                    <img src="${src}" alt="image">
                                </div>
                            `;
                        });

                        // Add classes here
                        modal.classList.add('active');

                        // Initiate Swiper
                        thumbsSwiper = new Swiper('.gallery-thumbs', {
                            spaceBetween: 10,
                            slidesPerView: 6,
                            freeMode: true,
                            watchSlidesProgress: true,
                        });

                        mainSwiper = new Swiper('.gallery-main', {
                            spaceBetween: 10,
                            navigation: {
                                nextEl: '.gallery-main .swiper-button-next',
                                prevEl: '.gallery-main .swiper-button-prev',
                            },
                            thumbs: {
                                swiper: thumbsSwiper
                            },
                            initialSlide: index
                        });

                    });

                });

                document.querySelector('.gallery-modal__close').addEventListener('click', () => {
                    modal.classList.remove('active');

                    if (mainSwiper) mainSwiper.destroy();
                    if (thumbsSwiper) thumbsSwiper.destroy();
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