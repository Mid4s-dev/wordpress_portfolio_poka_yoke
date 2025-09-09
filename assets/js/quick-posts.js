/**
 * Quick Social Posts JavaScript
 * 
 * Handles interactive elements for the quick post form
 */

(function($) {
    'use strict';
    
    // Initialize when document is ready
    $(document).ready(function() {
        initQuickPostForm();
    });
    
    /**
     * Initialize quick post form functionality
     */
    function initQuickPostForm() {
        // Initialize media uploader
        initMediaUploader();
        
        // Initialize post preview
        initPostPreview();
    }
    
    /**
     * Initialize WordPress media uploader
     */
    function initMediaUploader() {
        let mediaUploader;
        const $imageContainer = $('#post-image-container');
        const $imageIdInput = $('#post_image_id');
        const $selectButton = $('#select-image-button');
        const $removeButton = $('#remove-image-button');
        
        // Handle select image button click
        $selectButton.on('click', function(e) {
            e.preventDefault();
            
            // If uploader already exists, open it
            if (mediaUploader) {
                mediaUploader.open();
                return;
            }
            
            // Create new media uploader
            mediaUploader = wp.media({
                title: portfolioQuickPosts.strings.selectImage,
                button: {
                    text: portfolioQuickPosts.strings.selectImage
                },
                multiple: false
            });
            
            // When image is selected
            mediaUploader.on('select', function() {
                const attachment = mediaUploader.state().get('selection').first().toJSON();
                
                // Update hidden input with image ID
                $imageIdInput.val(attachment.id);
                
                // Update image preview
                $imageContainer.html(`<img src="${attachment.url}" alt="" />`);
                
                // Show remove button
                $removeButton.show();
                
                // Update select button text
                $selectButton.text(portfolioQuickPosts.strings.changeImage);
            });
            
            // Open media uploader
            mediaUploader.open();
        });
        
        // Handle remove image button click
        $removeButton.on('click', function(e) {
            e.preventDefault();
            
            // Clear image ID
            $imageIdInput.val('');
            
            // Clear image preview
            $imageContainer.html(`
                <div class="no-image-placeholder">
                    <span class="dashicons dashicons-format-image"></span>
                    <span>No image selected</span>
                </div>
            `);
            
            // Hide remove button
            $removeButton.hide();
            
            // Reset select button text
            $selectButton.text(portfolioQuickPosts.strings.selectImage);
        });
    }
    
    /**
     * Initialize post preview functionality
     */
    function initPostPreview() {
        const $previewButton = $('#preview-button');
        const $previewContainer = $('#post-preview-container');
        const $urlInput = $('#post_url');
        const $platformSelect = $('#post_platform');
        const $imageIdInput = $('#post_image_id');
        const $titleInput = $('#post_title');
        const $descriptionInput = $('#post_description');
        
        // Handle preview button click
        $previewButton.on('click', function(e) {
            e.preventDefault();
            
            // Get form values
            const url = $urlInput.val();
            const platform = $platformSelect.val();
            const imageId = $imageIdInput.val();
            const title = $titleInput.val();
            const description = $descriptionInput.val();
            
            // Validate URL
            if (!url) {
                alert('Please enter a post URL to preview.');
                $urlInput.focus();
                return;
            }
            
            // Show loading state
            $previewContainer.html(`
                <div class="preview-loading">
                    <span class="spinner is-active"></span>
                    <p>${portfolioQuickPosts.strings.previewLoading}</p>
                </div>
            `);
            
            // Send AJAX request to get preview
            $.ajax({
                url: portfolioQuickPosts.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'get_social_post_preview',
                    nonce: portfolioQuickPosts.nonce,
                    url: url,
                    platform: platform,
                    image_id: imageId,
                    title: title,
                    description: description
                },
                success: function(response) {
                    if (response.success) {
                        // Update preview container with response
                        $previewContainer.html(response.data.preview);
                    } else {
                        // Show error message
                        $previewContainer.html(`
                            <div class="post-preview-placeholder">
                                <span class="dashicons dashicons-warning"></span>
                                <p>${response.data.message || portfolioQuickPosts.strings.previewError}</p>
                            </div>
                        `);
                    }
                },
                error: function() {
                    // Show error message
                    $previewContainer.html(`
                        <div class="post-preview-placeholder">
                            <span class="dashicons dashicons-warning"></span>
                            <p>${portfolioQuickPosts.strings.previewError}</p>
                        </div>
                    `);
                }
            });
        });
        
        // Auto-preview when both URL and platform are entered
        let typingTimer;
        
        function delayedPreview() {
            clearTimeout(typingTimer);
            
            // Only trigger preview if both URL and platform are set
            if ($urlInput.val() && $platformSelect.val()) {
                typingTimer = setTimeout(function() {
                    $previewButton.trigger('click');
                }, 1000);
            }
        }
        
        $urlInput.on('input', delayedPreview);
        $platformSelect.on('change', delayedPreview);
    }
    
})(jQuery);
