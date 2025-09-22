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
            autoHeight: false, // Disable auto height to prevent resize during transitions
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
            },
            on: {
                init: function() {
                    // Dispatch an event that our height fixer can listen to
                    setTimeout(function() {
                        document.dispatchEvent(new CustomEvent('swiperSlideChangeTransitionEnd'));
                    }, 100);
                },
                slideChangeTransitionEnd: function() {
                    // Dispatch an event when slide transition ends
                    document.dispatchEvent(new CustomEvent('swiperSlideChangeTransitionEnd'));
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
            },
            on: {
                init: function() {
                    // Dispatch an event that our height fixer can listen to
                    setTimeout(function() {
                        document.dispatchEvent(new CustomEvent('swiperSlideChangeTransitionEnd'));
                    }, 100);
                },
                slideChangeTransitionEnd: function() {
                    // Dispatch an event when slide transition ends
                    document.dispatchEvent(new CustomEvent('swiperSlideChangeTransitionEnd'));
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
            autoHeight: false, // Disable auto height to prevent resize during transitions
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
            },
            on: {
                init: function() {
                    // Dispatch an event that our height fixer can listen to
                    setTimeout(function() {
                        document.dispatchEvent(new CustomEvent('swiperSlideChangeTransitionEnd'));
                    }, 100);
                },
                slideChangeTransitionEnd: function() {
                    // Dispatch an event when slide transition ends
                    document.dispatchEvent(new CustomEvent('swiperSlideChangeTransitionEnd'));
                }
            }
        });
    }
    
    // Initialize Services Carousel
    if (document.querySelector('.services-carousel .swiper-container')) {
        new Swiper('.services-carousel .swiper-container', {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            autoHeight: false, // Disable auto height to prevent resize during transitions
            autoplay: {
                delay: 4500,  // Different delay from other carousels
                disableOnInteraction: false,
            },
            pagination: {
                el: '.services-carousel .swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.services-carousel .swiper-button-next',
                prevEl: '.services-carousel .swiper-button-prev',
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
            },
            on: {
                init: function() {
                    // Dispatch an event that our height fixer can listen to
                    setTimeout(function() {
                        document.dispatchEvent(new CustomEvent('swiperSlideChangeTransitionEnd'));
                    }, 100);
                },
                slideChangeTransitionEnd: function() {
                    // Dispatch an event when slide transition ends
                    document.dispatchEvent(new CustomEvent('swiperSlideChangeTransitionEnd'));
                }
            }
        });
    }
});
