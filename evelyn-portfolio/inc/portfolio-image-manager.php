<?php
/**
 * Portfolio Image Manager
 * 
 * Provides tools and settings for managing portfolio images
 */

// Add Portfolio Image Manager Page
add_action('admin_menu', function() {
    add_menu_page(
        'Portfolio Images', 
        'Portfolio Images',
        'manage_options',
        'portfolio-image-manager',
        'portfolio_image_manager_page',
        'dashicons-format-gallery',
        33
    );
});

// Register Portfolio Image Settings
add_action('admin_init', function() {
    // Image Settings
    register_setting('portfolio_image_settings_group', 'portfolio_thumbnail_quality');
    register_setting('portfolio_image_settings_group', 'portfolio_enable_lazy_loading');
    register_setting('portfolio_image_settings_group', 'portfolio_watermark_image');
    register_setting('portfolio_image_settings_group', 'portfolio_enable_watermark');
    register_setting('portfolio_image_settings_group', 'portfolio_watermark_position');
    register_setting('portfolio_image_settings_group', 'portfolio_watermark_opacity');
    
    // Layout Settings
    register_setting('portfolio_image_settings_group', 'portfolio_grid_columns');
    register_setting('portfolio_image_settings_group', 'portfolio_items_per_page');
    register_setting('portfolio_image_settings_group', 'portfolio_image_hover_effect');
    register_setting('portfolio_image_settings_group', 'portfolio_show_titles');
    register_setting('portfolio_image_settings_group', 'portfolio_show_categories');
});

// Settings page callback
function portfolio_image_manager_page() {
    ?>
    <div class="wrap">
        <h1>Portfolio Image Manager</h1>
        <p>Manage your portfolio images and gallery settings.</p>
        
        <form method="post" action="options.php">
            <?php settings_fields('portfolio_image_settings_group'); ?>
            <?php do_settings_sections('portfolio_image_settings_group'); ?>
            
            <div class="nav-tab-wrapper">
                <a href="#display" class="nav-tab nav-tab-active">Display</a>
                <a href="#watermark" class="nav-tab">Watermark</a>
                <a href="#bulk" class="nav-tab">Bulk Actions</a>
            </div>
            
            <div id="display" class="tab-content">
                <h2>Portfolio Display Settings</h2>
                <table class="form-table">
                    <tr>
                        <th scope="row">Grid Columns</th>
                        <td>
                            <select name="portfolio_grid_columns">
                                <option value="2" <?php selected('2', get_option('portfolio_grid_columns', '3')); ?>>2 Columns</option>
                                <option value="3" <?php selected('3', get_option('portfolio_grid_columns', '3')); ?>>3 Columns</option>
                                <option value="4" <?php selected('4', get_option('portfolio_grid_columns', '3')); ?>>4 Columns</option>
                            </select>
                            <p class="description">Number of columns in the portfolio grid</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Items Per Page</th>
                        <td>
                            <input type="number" name="portfolio_items_per_page" value="<?php echo esc_attr(get_option('portfolio_items_per_page', '9')); ?>" min="1" max="50" />
                            <p class="description">Number of portfolio items to display per page</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Image Hover Effect</th>
                        <td>
                            <select name="portfolio_image_hover_effect">
                                <option value="zoom" <?php selected('zoom', get_option('portfolio_image_hover_effect', 'zoom')); ?>>Zoom</option>
                                <option value="overlay" <?php selected('overlay', get_option('portfolio_image_hover_effect', 'zoom')); ?>>Overlay</option>
                                <option value="slide" <?php selected('slide', get_option('portfolio_image_hover_effect', 'zoom')); ?>>Slide Up</option>
                                <option value="fade" <?php selected('fade', get_option('portfolio_image_hover_effect', 'zoom')); ?>>Fade</option>
                                <option value="none" <?php selected('none', get_option('portfolio_image_hover_effect', 'zoom')); ?>>None</option>
                            </select>
                            <p class="description">Effect when hovering over portfolio images</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Image Quality</th>
                        <td>
                            <select name="portfolio_thumbnail_quality">
                                <option value="90" <?php selected('90', get_option('portfolio_thumbnail_quality', '90')); ?>>High (90%)</option>
                                <option value="80" <?php selected('80', get_option('portfolio_thumbnail_quality', '90')); ?>>Medium (80%)</option>
                                <option value="70" <?php selected('70', get_option('portfolio_thumbnail_quality', '90')); ?>>Low (70%)</option>
                            </select>
                            <p class="description">Quality of generated portfolio thumbnails</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Display Options</th>
                        <td>
                            <label>
                                <input type="checkbox" name="portfolio_enable_lazy_loading" value="1" <?php checked('1', get_option('portfolio_enable_lazy_loading', '1')); ?> />
                                Enable lazy loading for images
                            </label><br>
                            
                            <label>
                                <input type="checkbox" name="portfolio_show_titles" value="1" <?php checked('1', get_option('portfolio_show_titles', '1')); ?> />
                                Show titles on portfolio grid
                            </label><br>
                            
                            <label>
                                <input type="checkbox" name="portfolio_show_categories" value="1" <?php checked('1', get_option('portfolio_show_categories', '1')); ?> />
                                Show categories on portfolio grid
                            </label>
                        </td>
                    </tr>
                </table>
            </div>
            
            <div id="watermark" class="tab-content" style="display:none;">
                <h2>Portfolio Watermark Settings</h2>
                <table class="form-table">
                    <tr>
                        <th scope="row">Enable Watermark</th>
                        <td>
                            <label>
                                <input type="checkbox" name="portfolio_enable_watermark" value="1" <?php checked('1', get_option('portfolio_enable_watermark', '0')); ?> />
                                Apply watermark to portfolio images
                            </label>
                            <p class="description">When enabled, your watermark will be applied to all portfolio images</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Watermark Image</th>
                        <td>
                            <div class="upload-wrapper">
                                <?php
                                $image_id = get_option('portfolio_watermark_image');
                                $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'medium') : '';
                                ?>
                                <div <?php echo $image_url ? 'style="display:block;"' : 'style="display:none;"'; ?> class="image-preview">
                                    <img src="<?php echo esc_url($image_url); ?>" alt="" style="max-width: 300px; height: auto; margin-bottom: 10px;">
                                </div>
                                
                                <input type="hidden" name="portfolio_watermark_image" id="watermark_image_id" value="<?php echo esc_attr($image_id); ?>">
                                <button type="button" class="button upload-watermark-button">Select Watermark Image</button>
                                <button type="button" class="button remove-watermark-button" <?php echo !$image_url ? 'style="display:none;"' : ''; ?>>Remove Watermark</button>
                                
                                <p class="description">Upload a transparent PNG to use as your watermark</p>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Watermark Position</th>
                        <td>
                            <select name="portfolio_watermark_position">
                                <option value="center" <?php selected('center', get_option('portfolio_watermark_position', 'bottom-right')); ?>>Center</option>
                                <option value="top-left" <?php selected('top-left', get_option('portfolio_watermark_position', 'bottom-right')); ?>>Top Left</option>
                                <option value="top-right" <?php selected('top-right', get_option('portfolio_watermark_position', 'bottom-right')); ?>>Top Right</option>
                                <option value="bottom-left" <?php selected('bottom-left', get_option('portfolio_watermark_position', 'bottom-right')); ?>>Bottom Left</option>
                                <option value="bottom-right" <?php selected('bottom-right', get_option('portfolio_watermark_position', 'bottom-right')); ?>>Bottom Right</option>
                            </select>
                            <p class="description">Position of the watermark on images</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Watermark Opacity</th>
                        <td>
                            <input type="range" name="portfolio_watermark_opacity" min="10" max="100" value="<?php echo esc_attr(get_option('portfolio_watermark_opacity', '70')); ?>" step="10" />
                            <span class="opacity-value"><?php echo esc_html(get_option('portfolio_watermark_opacity', '70')); ?>%</span>
                            <p class="description">Transparency level of the watermark</p>
                        </td>
                    </tr>
                </table>
            </div>
            
            <div id="bulk" class="tab-content" style="display:none;">
                <h2>Bulk Image Actions</h2>
                
                <div class="notice notice-info">
                    <p><strong>Note:</strong> These tools allow you to perform bulk actions on your portfolio images. Use with caution.</p>
                </div>
                
                <div class="card" style="max-width: 800px; margin-top: 20px; padding: 20px; background: #fff; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04);">
                    <h3>Regenerate Thumbnails</h3>
                    <p>Regenerate all portfolio thumbnails to apply new sizes and quality settings.</p>
                    <button type="button" id="regenerate-thumbnails" class="button button-primary">Regenerate Thumbnails</button>
                    <div id="regenerate-progress" style="margin-top: 10px; display: none;">
                        <div class="progress-bar" style="height: 20px; background-color: #f1f1f1; border-radius: 3px; overflow: hidden;">
                            <div class="progress-bar-fill" style="height: 100%; width: 0%; background-color: #2271b1; transition: width 0.3s ease;"></div>
                        </div>
                        <p class="progress-status">Processing: <span id="progress-count">0</span>/<span id="progress-total">0</span></p>
                    </div>
                </div>
                
                <div class="card" style="max-width: 800px; margin-top: 20px; padding: 20px; background: #fff; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04);">
                    <h3>Apply/Remove Watermarks</h3>
                    <p>Apply or remove watermarks from all portfolio images at once.</p>
                    <button type="button" id="apply-watermarks" class="button button-primary">Apply Watermarks</button>
                    <button type="button" id="remove-watermarks" class="button">Remove Watermarks</button>
                </div>
                
                <div class="card" style="max-width: 800px; margin-top: 20px; padding: 20px; background: #fff; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04);">
                    <h3>Optimize Images</h3>
                    <p>Optimize all portfolio images to improve page load speed.</p>
                    <button type="button" id="optimize-images" class="button button-primary">Optimize Images</button>
                </div>
            </div>
            
            <?php submit_button('Save Portfolio Settings'); ?>
        </form>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        // Tab navigation
        $('.nav-tab').on('click', function(e) {
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
        
        // Watermark image upload
        var mediaUploader;
        
        $('.upload-watermark-button').on('click', function(e) {
            e.preventDefault();
            
            if (mediaUploader) {
                mediaUploader.open();
                return;
            }
            
            mediaUploader = wp.media({
                title: 'Select Watermark Image',
                button: {
                    text: 'Use this image'
                },
                multiple: false
            });
            
            mediaUploader.on('select', function() {
                var attachment = mediaUploader.state().get('selection').first().toJSON();
                $('#watermark_image_id').val(attachment.id);
                $('.image-preview').show().find('img').attr('src', attachment.url);
                $('.remove-watermark-button').show();
            });
            
            mediaUploader.open();
        });
        
        $('.remove-watermark-button').on('click', function() {
            $('#watermark_image_id').val('');
            $('.image-preview').hide();
            $(this).hide();
        });
        
        // Update opacity value display
        $('input[name="portfolio_watermark_opacity"]').on('input', function() {
            $('.opacity-value').text($(this).val() + '%');
        });
        
        // Regenerate thumbnails
        $('#regenerate-thumbnails').on('click', function() {
            var $button = $(this);
            var $progress = $('#regenerate-progress');
            var $progressBar = $('.progress-bar-fill');
            var $progressCount = $('#progress-count');
            var $progressTotal = $('#progress-total');
            
            $button.prop('disabled', true).text('Processing...');
            $progress.show();
            
            // This would be replaced with actual AJAX functionality
            // Simulating progress for demonstration
            var totalImages = 25; // Example total
            $progressTotal.text(totalImages);
            
            var currentImage = 0;
            var interval = setInterval(function() {
                currentImage++;
                var percent = (currentImage / totalImages) * 100;
                
                $progressCount.text(currentImage);
                $progressBar.css('width', percent + '%');
                
                if (currentImage >= totalImages) {
                    clearInterval(interval);
                    $button.prop('disabled', false).text('Complete!');
                    setTimeout(function() {
                        $button.text('Regenerate Thumbnails');
                    }, 2000);
                }
            }, 100);
        });
        
        // Apply watermarks (demo functionality)
        $('#apply-watermarks, #remove-watermarks, #optimize-images').on('click', function() {
            var action = $(this).text();
            $(this).prop('disabled', true).text('Processing...');
            
            // Simulate processing
            setTimeout(function() {
                alert(action + ' completed successfully!');
                $(this).prop('disabled', false).text(action);
            }.bind(this), 1000);
        });
    });
    </script>
    <?php
}

// Add custom image size for portfolio
add_action('after_setup_theme', function() {
    add_image_size('portfolio-large', 1200, 800, true);
    add_image_size('portfolio-medium', 800, 600, true);
    add_image_size('portfolio-thumbnail', 600, 400, true);
    add_image_size('portfolio-square', 600, 600, true);
});

// Helper function to get portfolio settings
function get_portfolio_setting($key, $default = '') {
    return get_option('portfolio_' . $key, $default);
}

// Apply portfolio settings to posts per page
add_action('pre_get_posts', function($query) {
    if (!is_admin() && $query->is_main_query()) {
        if ($query->is_post_type_archive('portfolio') || $query->is_tax('portfolio_category')) {
            $items_per_page = get_portfolio_setting('items_per_page', 9);
            $query->set('posts_per_page', $items_per_page);
        }
    }
});

// Add lazy loading to portfolio images
add_filter('wp_get_attachment_image_attributes', function($attr, $attachment, $size) {
    // Check if we're on a portfolio page and lazy loading is enabled
    if ((is_post_type_archive('portfolio') || is_singular('portfolio') || is_tax('portfolio_category')) && 
        get_portfolio_setting('enable_lazy_loading', '1')) {
        $attr['loading'] = 'lazy';
    }
    
    return $attr;
}, 10, 3);

// Apply hover effect class to portfolio images
add_filter('post_class', function($classes) {
    if (is_post_type_archive('portfolio') || is_tax('portfolio_category')) {
        $hover_effect = get_portfolio_setting('image_hover_effect', 'zoom');
        if ($hover_effect !== 'none') {
            $classes[] = 'hover-effect-' . $hover_effect;
        }
    }
    
    return $classes;
});

// Add custom metabox for managing portfolio images
add_action('add_meta_boxes', function() {
    add_meta_box(
        'portfolio_images_metabox',
        'Portfolio Images',
        'portfolio_images_metabox_callback',
        'portfolio',
        'normal',
        'high'
    );
});

function portfolio_images_metabox_callback($post) {
    wp_nonce_field(basename(__FILE__), 'portfolio_images_nonce');
    
    // Get saved gallery images
    $gallery_images = get_post_meta($post->ID, '_portfolio_gallery_images', true);
    $gallery_images = $gallery_images ? explode(',', $gallery_images) : array();
    
    ?>
    <div class="portfolio-gallery-wrapper">
        <p>Add images to your portfolio gallery. These will be displayed in the portfolio item page.</p>
        
        <div class="portfolio-gallery-images" style="display: flex; flex-wrap: wrap; margin-bottom: 15px;">
            <?php 
            if (!empty($gallery_images)) {
                foreach ($gallery_images as $image_id) {
                    $image = wp_get_attachment_image_src($image_id, 'thumbnail');
                    if ($image) {
                        ?>
                        <div class="gallery-image" data-id="<?php echo esc_attr($image_id); ?>" style="position: relative; margin: 5px; border: 1px solid #ddd; padding: 5px; cursor: move;">
                            <img src="<?php echo esc_url($image[0]); ?>" width="100" height="100" style="display: block;">
                            <a href="#" class="remove-image" style="position: absolute; top: 0; right: 0; background: rgba(255,255,255,0.7); padding: 2px; color: red;" title="Remove Image">×</a>
                        </div>
                        <?php
                    }
                }
            }
            ?>
        </div>
        
        <input type="hidden" name="portfolio_gallery_images" id="portfolio-gallery-images" value="<?php echo esc_attr(implode(',', $gallery_images)); ?>">
        
        <button type="button" class="button button-primary" id="add-gallery-images">Add Images</button>
        
        <script>
        jQuery(document).ready(function($) {
            // Make gallery images sortable
            $('.portfolio-gallery-images').sortable({
                update: function() {
                    updateGalleryImageIDs();
                }
            });
            
            // Update hidden field with image IDs
            function updateGalleryImageIDs() {
                var ids = [];
                $('.gallery-image').each(function() {
                    ids.push($(this).data('id'));
                });
                $('#portfolio-gallery-images').val(ids.join(','));
            }
            
            // Add images to gallery
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
            
            // Remove images from gallery
            $(document).on('click', '.remove-image', function(e) {
                e.preventDefault();
                $(this).parent().remove();
                updateGalleryImageIDs();
            });
        });
        </script>
    </div>
    <?php
}

// Save portfolio gallery images
add_action('save_post', function($post_id) {
    // Check if our nonce is set and verify it
    if (!isset($_POST['portfolio_images_nonce']) || !wp_verify_nonce($_POST['portfolio_images_nonce'], basename(__FILE__))) {
        return $post_id;
    }
    
    // Check user permissions
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    
    if ('portfolio' !== $_POST['post_type'] || !current_user_can('edit_post', $post_id)) {
        return $post_id;
    }
    
    // Save gallery images
    if (isset($_POST['portfolio_gallery_images'])) {
        update_post_meta($post_id, '_portfolio_gallery_images', sanitize_text_field($_POST['portfolio_gallery_images']));
    } else {
        delete_post_meta($post_id, '_portfolio_gallery_images');
    }
});
