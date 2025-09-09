/**
 * Campaigns & Projects JavaScript
 * 
 * Handles interactive elements for the campaigns feature
 */

(function($) {
    'use strict';
    
    // Initialize when document is ready
    $(document).ready(function() {
        initCampaigns();
    });
    
    /**
     * Initialize campaigns functionality
     */
    function initCampaigns() {
        // Handle embedded content resizing
        resizeEmbeds();
        
        // Setup filter functionality on archive page
        setupFilters();
        
        // Add loading animation for embeds
        handleEmbedLoading();
    }
    
    /**
     * Make embeds responsive
     */
    function resizeEmbeds() {
        $('.portfolio-campaign-embed iframe').each(function() {
            const $iframe = $(this);
            
            // Skip iframes that already have responsive wrappers
            if ($iframe.parent().hasClass('embed-responsive')) {
                return;
            }
            
            // Get aspect ratio from width and height attributes
            let width = $iframe.attr('width') || 640;
            let height = $iframe.attr('height') || 360;
            
            // Default to 16:9 if no dimensions are specified
            if (width === '100%') width = 640;
            if (height === '100%') height = 360;
            
            // Calculate aspect ratio
            const ratio = (parseInt(height) / parseInt(width)) * 100;
            
            // Wrap iframe in a responsive container with padding-bottom based on aspect ratio
            $iframe.wrap('<div class="embed-responsive" style="position: relative; padding-bottom: ' + ratio + '%; height: 0; overflow: hidden;"></div>');
            
            // Make iframe fill the container
            $iframe.css({
                'position': 'absolute',
                'top': '0',
                'left': '0',
                'width': '100%',
                'height': '100%'
            });
        });
    }
    
    /**
     * Setup filter functionality on archive page
     */
    function setupFilters() {
        const $filterForm = $('.filters-container form');
        
        if ($filterForm.length) {
            // Add change event to auto-submit on select change
            $filterForm.find('select').on('change', function() {
                $filterForm.submit();
            });
            
            // Add animation to filtered results
            if (window.location.search.includes('platform=') || window.location.search.includes('campaign_type=')) {
                $('.portfolio-campaigns-grid').addClass('filter-animation');
                
                // Add filter badges
                const urlParams = new URLSearchParams(window.location.search);
                const platform = urlParams.get('platform');
                const type = urlParams.get('campaign_type');
                
                let filterHTML = '';
                
                if (platform) {
                    let platformLabel = $('#platform-filter option[value="' + platform + '"]').text();
                    filterHTML += '<span class="filter-badge platform-badge">' + platformLabel + ' <button type="button" class="remove-filter" data-param="platform">&times;</button></span>';
                }
                
                if (type) {
                    let typeLabel = $('#type-filter option[value="' + type + '"]').text();
                    filterHTML += '<span class="filter-badge type-badge">' + typeLabel + ' <button type="button" class="remove-filter" data-param="campaign_type">&times;</button></span>';
                }
                
                if (filterHTML) {
                    $('<div class="active-filters">' + filterHTML + '</div>').insertAfter('.filters-container');
                }
                
                // Handle remove filter buttons
                $(document).on('click', '.remove-filter', function() {
                    const param = $(this).data('param');
                    urlParams.delete(param);
                    
                    const newUrl = window.location.pathname + (urlParams.toString() ? '?' + urlParams.toString() : '');
                    window.location.href = newUrl;
                });
            }
        }
    }
    
    /**
     * Add loading animation for embeds
     */
    function handleEmbedLoading() {
        $('.portfolio-campaign-embed iframe').each(function() {
            const $iframe = $(this);
            const $container = $iframe.closest('.portfolio-campaign-embed');
            
            // Add loading indicator
            $container.append('<div class="embed-loading"><div class="spinner"></div></div>');
            
            // Remove loading indicator when iframe is loaded
            $iframe.on('load', function() {
                $container.find('.embed-loading').fadeOut(300, function() {
                    $(this).remove();
                });
            });
        });
    }
    
})(jQuery);
