class ResponsiveSwiper {
    constructor(selector, swiperOptions = {}, breakpoint = 768) {
        this.selector = selector;
        this.swiperOptions = swiperOptions;
        this.breakpoint = breakpoint;
        this.swiper = null;
        this.container = document.querySelector(selector);

        if (!this.container) return;

        this.init();
    }

    init() {
        this.toggle();

        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => this.toggle(), 100);
        });
    }

    toggle() {
        if (window.innerWidth <= this.breakpoint) {
            this.initSwiper();
        } else {
            this.destroySwiper();
        }
    }

    initSwiper() {
        if (!this.swiper) {
            this.swiper = new Swiper(this.selector, this.swiperOptions);
        }
    }

    destroySwiper() {
        if (this.swiper) {
            this.swiper.destroy(true, true);
            this.swiper = null;
        }
    }
}

document.addEventListener('DOMContentLoaded', function () {

    // Crossover section
    new ResponsiveSwiper('#swiper-crossover-posts', {
        slidesPerView: 1,
        spaceBetween: 20,
        pagination: {
            el: '#swiper-crossover-posts .swiper-pagination',
            clickable: true,
        },
    }, 768);

    // Blog section — reuse the same class, no duplicate logic
    new ResponsiveSwiper('#swiper-blog-posts', {
        slidesPerView: 1,
        spaceBetween: 20,
        pagination: {
            el: '#swiper-blog-posts .swiper-pagination',
            clickable: true,
        },
    }, 768);

});
