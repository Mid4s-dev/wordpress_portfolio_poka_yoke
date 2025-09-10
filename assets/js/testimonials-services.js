/**
 * Testimonials and Services JavaScript
 * 
 * Provides enhanced functionality for testimonials and services display.
 */

(function($) {
    'use strict';
    
    // Initialize when the DOM is ready
    $(document).ready(function() {
        // Initialize testimonials features
        initTestimonials();
        
        // Initialize services features
        initServices();
    });
    
    /**
     * Initialize testimonials functionality
     */
    function initTestimonials() {
        // Simple animation for testimonials on scroll
        $('.portfolio-testimonial').each(function() {
            $(this).addClass('testimonial-fade-in');
        });
        
        // Initialize testimonial sliders/carousels
        if ($('.portfolio-testimonials-slider, .portfolio-testimonials-carousel').length) {
            $('.portfolio-testimonials-slider, .portfolio-testimonials-carousel').each(function() {
                var $slider = $(this);
                var $testimonials = $slider.find('.portfolio-testimonial');
                var $prevBtn = $slider.siblings('.testimonial-controls').find('.testimonial-prev');
                var $nextBtn = $slider.siblings('.testimonial-controls').find('.testimonial-next');
                
                // Initialize the slider
                if ($testimonials.length > 0) {
                    // Show the first testimonial
                    $testimonials.first().addClass('active');
                    
                    // Set up navigation
                    $prevBtn.on('click', function() {
                        var $active = $slider.find('.portfolio-testimonial.active');
                        var $prev = $active.prev('.portfolio-testimonial');
                        if ($prev.length === 0) {
                            $prev = $testimonials.last();
                        }
                        
                        $active.removeClass('active');
                        $prev.addClass('active');
                    });
                    
                    $nextBtn.on('click', function() {
                        var $active = $slider.find('.portfolio-testimonial.active');
                        var $next = $active.next('.portfolio-testimonial');
                        if ($next.length === 0) {
                            $next = $testimonials.first();
                        }
                        
                        $active.removeClass('active');
                        $next.addClass('active');
                    });
                }
            });
        }
    }
    
    /**
     * Initialize services functionality
     */
    function initServices() {
        // Add hover effects for services
        $('.portfolio-service').hover(
            function() {
                $(this).addClass('service-hovered');
            },
            function() {
                $(this).removeClass('service-hovered');
            }
        );
        
        // Add click event for service learn more buttons
        $('.service-link .button').on('click', function(e) {
            // If you want to add any special behavior when clicking on a service
            // You could add it here
        });
    }
    
})(jQuery);
