/**
 * Profile Image Customizer JavaScript
 */

(function($) {
    'use strict';
    
    // When the document is ready
    $(document).ready(function() {
        // Handle profile image live preview
        wp.customize('portfolio_profile_image', function(value) {
            value.bind(function(newVal) {
                // Update all profile images on the page
                if (newVal) {
                    $('.profile-image').attr('src', newVal);
                    $('.header-profile-image').attr('src', newVal);
                }
                
                // Update preview in customizer
                var $preview = $('.profile-image-preview');
                if ($preview.length === 0) {
                    $preview = $('<img class="profile-image-preview" />').appendTo('.customize-control-image .actions');
                }
                $preview.attr('src', newVal);
            });
        });
        
        // Handle profile name live preview
        wp.customize('portfolio_profile_name', function(value) {
            value.bind(function(newVal) {
                // Update the profile name on the page
                $('.profile-owner-name').text(newVal);
                
                // Update the site title if it's being used as the profile name
                $('.site-title a').text(newVal);
            });
        });
        
        // Add a preview section in the customizer
        if ($('.profile-image-preview-wrapper').length === 0) {
            var $previewWrapper = $('<div class="profile-image-preview-wrapper"></div>');
            var $previewTitle = $('<h4>Live Preview</h4>');
            var $previewContainer = $('<div class="profile-image-container-preview"></div>');
            var $previewBorder = $('<div class="profile-image-maasai-border-preview"></div>');
            var $previewImage = $('<img class="profile-image-preview" />');
            
            $previewContainer.append($previewBorder);
            $previewContainer.append($previewImage);
            $previewWrapper.append($previewTitle);
            $previewWrapper.append($previewContainer);
            
            // Add notice
            var $notice = $('<div class="profile-customizer-notice"></div>');
            $notice.html('<p>This profile image will appear in the header and in the hero section with a Maasai-inspired border.</p>');
            $previewWrapper.append($notice);
            
            // Add to customizer
            $('.customize-control-image').append($previewWrapper);
            
            // Set the initial image
            var currentImage = wp.customize('portfolio_profile_image').get();
            if (currentImage) {
                $previewImage.attr('src', currentImage);
            }
        }
    });
    
})(jQuery);
