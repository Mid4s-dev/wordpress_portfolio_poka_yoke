/**
 * Portfolio Image Manager Scripts
 */
jQuery(document).ready(function($) {
    // Tab navigation for portfolio image manager
    $('.nav-tab-wrapper .nav-tab').on('click', function(e) {
        e.preventDefault();
        
        // Hide all tab contents
        $('.tab-content').hide();
        
        // Remove active class from all tabs
        $('.nav-tab').removeClass('nav-tab-active');
        
        // Show the selected tab content
        $($(this).attr('href')).show();
        
        // Add active class to clicked tab
        $(this).addClass('nav-tab-active');
    });
    
    // Show the first tab by default
    $('.tab-content:first').show();
    $('.nav-tab:first').addClass('nav-tab-active');
    
    // Update opacity value display
    $('input[name="portfolio_watermark_opacity"]').on('input', function() {
        $('.opacity-value').text($(this).val() + '%');
    });
    
    // Portfolio filtering (archive page)
    $('.filter-button').on('click', function() {
        var category = $(this).data('category');
        
        // Update active button
        $('.filter-button').removeClass('active bg-blue-500 text-white').addClass('bg-gray-200 text-gray-700');
        $(this).addClass('active bg-blue-500 text-white').removeClass('bg-gray-200 text-gray-700');
        
        // If "All" is selected, show all items
        if (category === 'all') {
            $('.portfolio-item').fadeIn();
        } else {
            // Hide all items first
            $('.portfolio-item').hide();
            
            // Show only items with selected category
            $('.portfolio-item.category-' + category).fadeIn();
        }
    });
    
    // Lightbox functionality is now handled by portfolio-lightbox.js
    
    // Portfolio gallery image sortable
    if ($.fn.sortable) {
        $('.portfolio-gallery-images').sortable({
            update: function() {
                updateGalleryImageIDs();
            }
        });
    }
    
    // Update hidden field with image IDs
    function updateGalleryImageIDs() {
        var ids = [];
        $('.gallery-image').each(function() {
            ids.push($(this).data('id'));
        });
        $('#portfolio-gallery-images').val(ids.join(','));
    }
    
    // Remove gallery image
    $(document).on('click', '.remove-image', function(e) {
        e.preventDefault();
        $(this).parent().remove();
        updateGalleryImageIDs();
    });
    
    // Add gallery images
    $('#add-gallery-images').on('click', function(e) {
        e.preventDefault();
        
        var mediaUploader = wp.media({
            title: 'Select Gallery Images',
            button: {
                text: 'Add to Gallery'
            },
            multiple: true
        });
        
        mediaUploader.on('select', function() {
            var attachments = mediaUploader.state().get('selection').toJSON();
            
            attachments.forEach(function(attachment) {
                // Check if image already exists in gallery
                if ($('.gallery-image[data-id="' + attachment.id + '"]').length === 0) {
                    $('.portfolio-gallery-images').append(
                        '<div class="gallery-image" data-id="' + attachment.id + '" style="position: relative; margin: 5px; border: 1px solid #ddd; padding: 5px; cursor: move;">' +
                        '<img src="' + (attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url) + '" width="100" height="100" style="display: block;">' +
                        '<a href="#" class="remove-image" style="position: absolute; top: 0; right: 0; background: rgba(255,255,255,0.7); padding: 2px; color: red;" title="Remove Image">×</a>' +
                        '</div>'
                    );
                }
            });
            
            updateGalleryImageIDs();
        });
        
        mediaUploader.open();
    });
});
