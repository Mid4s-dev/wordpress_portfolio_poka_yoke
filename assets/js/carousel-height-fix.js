/**
 * Carousel Height Normalization Script
 * Ensures all carousel cards have consistent heights to prevent jumping
 */

document.addEventListener('DOMContentLoaded', function() {
    console.log('Carousel height fix script initialized');
    
    // Initial normalization
    normalizeCarouselHeights();
    
    // Re-normalize on window resize
    window.addEventListener('resize', debounce(normalizeCarouselHeights, 250));
    
    // Re-normalize when tabs or accordions might affect card visibility
    document.querySelectorAll('.tab-button, .accordion-trigger').forEach(element => {
        element.addEventListener('click', function() {
            setTimeout(normalizeCarouselHeights, 100);
        });
    });
    
    // Add listeners for Swiper events
    document.addEventListener('swiperSlideChangeTransitionEnd', function(e) {
        console.log('Swiper transition ended, normalizing heights');
        normalizeCarouselHeights();
    });
    
    // When images load, they may change the height
    const carouselImages = document.querySelectorAll('.swiper-slide img');
    carouselImages.forEach(function(img) {
        if (img.complete) {
            // Image already loaded
            setTimeout(normalizeCarouselHeights, 50);
        } else {
            // Wait for image to load
            img.addEventListener('load', function() {
                setTimeout(normalizeCarouselHeights, 50);
            });
        }
    });
    
    /**
     * Normalize heights of all carousel slides
     */
    function normalizeCarouselHeights() {
        console.log('Normalizing carousel heights');
        
        const carouselTypes = [
            '.services-carousel',
            '.campaigns-carousel', 
            '.blog-carousel',
            '.testimonials-carousel'
        ];
        
        carouselTypes.forEach(carouselType => {
            const carousels = document.querySelectorAll(carouselType);
            
            carousels.forEach(carousel => {
                const slides = carousel.querySelectorAll('.swiper-slide');
                if (!slides.length) return;
                
                const wrapper = carousel.querySelector('.swiper-wrapper');
                if (!wrapper) return;
                
                // Reset heights first - including internal cards
                slides.forEach(slide => {
                    slide.style.height = 'auto';
                    
                    // Reset heights of cards inside slides
                    const cards = slide.querySelectorAll('.card, .portfolio-campaign-item, .blog-post-item, .testimonial-item, .portfolio-service');
                    cards.forEach(card => {
                        card.style.height = 'auto';
                    });
                });
                
                // Find maximum height
                let maxHeight = 0;
                slides.forEach(slide => {
                    const slideHeight = slide.offsetHeight;
                    if (slideHeight > maxHeight) {
                        maxHeight = slideHeight;
                    }
                });
                
                // Apply equal height to all slides
                if (maxHeight > 0) {
                    console.log(`Setting ${carouselType} slides to height: ${maxHeight}px`);
                    
                    // Set wrapper height
                    wrapper.style.height = maxHeight + 'px';
                    
                    // Set all slides to same height
                    slides.forEach(slide => {
                        slide.style.height = maxHeight + 'px';
                        
                        // Set all cards inside slides to same height
                        const cards = slide.querySelectorAll('.card, .portfolio-campaign-item, .blog-post-item, .testimonial-item, .portfolio-service');
                        cards.forEach(card => {
                            card.style.height = '100%';
                        });
                    });
                    
                    // Also set container height
                    const swiperContainer = carousel.querySelector('.swiper-container');
                    if (swiperContainer) {
                        swiperContainer.style.height = (maxHeight + 40) + 'px'; // Add padding
                    }
                }
            });
        });
    }
    
    /**
     * Debounce function to prevent excessive firing
     */
    function debounce(func, wait, immediate) {
        let timeout;
        return function() {
            const context = this, args = arguments;
            const later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            const callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    }
});
