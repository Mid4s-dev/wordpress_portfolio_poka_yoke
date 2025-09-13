/**
 * Carousel functionality using Swiper.js
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize Blog Posts Carousel
    if (document.querySelector('.blog-carousel .swiper-container')) {
        new Swiper('.blog-carousel .swiper-container', {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.blog-carousel .swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.blog-carousel .swiper-button-next',
                prevEl: '.blog-carousel .swiper-button-prev',
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                }
            }
        });
    }

    // Initialize Testimonials Carousel
    if (document.querySelector('.testimonials-carousel .swiper-container')) {
        new Swiper('.testimonials-carousel .swiper-container', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 6000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.testimonials-carousel .swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.testimonials-carousel .swiper-button-next',
                prevEl: '.testimonials-carousel .swiper-button-prev',
            },
            breakpoints: {
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                }
            }
        });
    }

    // Initialize Campaigns Carousel
    if (document.querySelector('.campaigns-carousel .swiper-container')) {
        new Swiper('.campaigns-carousel .swiper-container', {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            autoplay: {
                delay: 5500,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.campaigns-carousel .swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.campaigns-carousel .swiper-button-next',
                prevEl: '.campaigns-carousel .swiper-button-prev',
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                }
            }
        });
    }
});
