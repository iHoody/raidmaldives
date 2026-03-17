(function($) {
    'use strict';

    let common = {
        smoothScrolling: function() {
            // Smooth scrolling for navigation links
            $('a[href^="#"]').on('click', function(e) {
                e.preventDefault();
                const target = $(this.getAttribute('href'));
                if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top
                    }, 800);
                }

                // Close mobile menu if open
                //common.closeMobileMenu();
            });
        },

        headerScroll: function() {
            const $header = $('.site-header');
            const scrollThreshold = 50;

            $(window).on('scroll', function() {
                if ($(this).scrollTop() > scrollThreshold) {
                    $header.addClass('is-scrolled');
                } else {
                    $header.removeClass('is-scrolled');
                }
            });

            // Check initial scroll position on page load
            if ($(window).scrollTop() > scrollThreshold) {
                $header.addClass('is-scrolled');
            }
        },

        mobileMenu: function() {
            const $burger = $('#nav-icon1');
            const $panel = $('.site-nav__mobile-panel');
            const $overlay = $('.site-nav__overlay');
            const $body = $('body');

            // Toggle menu on burger click
            $burger.on('click', function() {
                $(this).toggleClass('is-open');
                $panel.toggleClass('is-open');
                $overlay.toggleClass('is-open');
                $body.toggleClass('menu-open');
            });

            // Close menu on overlay click
            $overlay.on('click', function() {
                common.closeMobileMenu();
            });

            // Close menu on window resize (if going to desktop)
            $(window).on('resize', function() {
                if ($(window).width() > 768) {
                    common.closeMobileMenu();
                }
            });

        },

        closeMobileMenu: function() {
            $('#nav-icon1').removeClass('is-open');
            $('.site-nav__mobile-panel').removeClass('is-open');
            $('.site-nav__overlay').removeClass('is-open');
            $('body').removeClass('menu-open');
        },

        headerMenu: function() {
            document.querySelectorAll('.menu-item-has-children > a')
                .forEach(link => {
                    link.addEventListener('click', function (e) {
                        this.parentElement.classList.toggle('open');
                    });
                });
        },

        init: function() {
            this.smoothScrolling();
            this.headerScroll();
            this.mobileMenu();
            this.headerMenu();
        }
    };

    document.addEventListener('DOMContentLoaded', function () {
        common.init();
    });

})(jQuery);