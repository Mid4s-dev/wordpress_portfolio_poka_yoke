/**
 * Testimonials Admin JavaScript
 *
 * @package WordPress
 * @subpackage Portfolio
 * @since 1.0
 */

(function($) {
    'use strict';
    
    // Document ready
    $(document).ready(function() {
        
        // Create testimonials rating chart if element exists
        if ($('#testimonialsRatingChart').length) {
            createRatingDistributionChart();
        }
        
        // Initialize any interactive elements on the dashboard
        initTestimonialsDashboard();
    });
    
    /**
     * Create a rating distribution chart
     */
    function createRatingDistributionChart() {
        // Sample data - in a real implementation, this would be passed from PHP
        var ctx = document.getElementById('testimonialsRatingChart').getContext('2d');
        
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['5 Stars', '4 Stars', '3 Stars', '2 Stars', '1 Star'],
                datasets: [{
                    label: 'Number of Testimonials',
                    data: [12, 5, 2, 0, 0],
                    backgroundColor: [
                        'rgba(52, 152, 219, 0.7)',
                        'rgba(52, 152, 219, 0.6)',
                        'rgba(52, 152, 219, 0.5)',
                        'rgba(52, 152, 219, 0.4)',
                        'rgba(52, 152, 219, 0.3)'
                    ],
                    borderColor: [
                        'rgba(52, 152, 219, 1)',
                        'rgba(52, 152, 219, 1)',
                        'rgba(52, 152, 219, 1)',
                        'rgba(52, 152, 219, 1)',
                        'rgba(52, 152, 219, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }
    
    /**
     * Initialize testimonials dashboard functionality
     */
    function initTestimonialsDashboard() {
        // Copy shortcode to clipboard when clicked
        $('.testimonial-shortcode code').on('click', function() {
            var $this = $(this);
            var $temp = $('<input>');
            
            $('body').append($temp);
            $temp.val($this.text()).select();
            document.execCommand('copy');
            $temp.remove();
            
            // Show "copied" tooltip
            var $tooltip = $('<div class="copied-tooltip">Copied!</div>');
            $this.append($tooltip);
            
            setTimeout(function() {
                $tooltip.fadeOut(300, function() {
                    $(this).remove();
                });
            }, 1500);
        }).css('cursor', 'pointer');
    }
    
})(jQuery);
