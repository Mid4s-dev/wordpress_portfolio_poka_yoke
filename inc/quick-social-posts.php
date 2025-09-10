<?php
/**
 * Quick Social Posts - Simple admin interface for quickly adding social media posts
 * 
 * @package Portfolio
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Portfolio Quick Social Posts Class
 */
class Portfolio_Quick_Social_Posts {

    /**
     * Constructor
     */
    public function __construct() {
        // Add admin menu page
        add_action('admin_menu', array($this, 'add_quick_posts_menu'));
        
        // Register admin styles
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
        
        // Handle form submission
        add_action('admin_init', array($this, 'handle_form_submission'));
        
        // Add AJAX handler for post preview
        add_action('wp_ajax_get_social_post_preview', array($this, 'ajax_get_social_post_preview'));
        
        // Add floating quick add button
        add_action('admin_footer', array($this, 'add_floating_quick_button'));
    }
    
    /**
     * Add admin menu page
     */
    public function add_quick_posts_menu() {
        add_submenu_page(
            'portfolio-campaigns',
            __('Quick Social Post', 'portfolio'),
            __('Quick Add Post', 'portfolio'),
            'edit_posts',
            'portfolio-quick-post',
            array($this, 'render_quick_post_page')
        );
    }
    
    /**
     * Enqueue admin assets
     */
    public function enqueue_admin_assets($hook) {
        // Only enqueue on our page
        if ($hook !== 'campaigns_page_portfolio-quick-post') {
            return;
        }
        
        // Add custom CSS
        wp_enqueue_style(
            'portfolio-quick-posts-css',
            get_template_directory_uri() . '/assets/css/quick-posts.css',
            array(),
            filemtime(get_template_directory() . '/assets/css/quick-posts.css')
        );
        
        // Add custom JS
        wp_enqueue_script(
            'portfolio-quick-posts-js',
            get_template_directory_uri() . '/assets/js/quick-posts.js',
            array('jquery'),
            filemtime(get_template_directory() . '/assets/js/quick-posts.js'),
            true
        );
        
        // Add media uploader
        wp_enqueue_media();
        
        // Pass data to JS
        wp_localize_script(
            'portfolio-quick-posts-js',
            'portfolioQuickPosts',
            array(
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('portfolio-quick-post-nonce'),
                'strings' => array(
                    'previewLoading' => __('Loading post preview...', 'portfolio'),
                    'previewError' => __('Could not load preview. Please check the URL and try again.', 'portfolio'),
                    'selectImage' => __('Select Image', 'portfolio'),
                    'changeImage' => __('Change Image', 'portfolio'),
                )
            )
        );
    }
    
    /**
     * Handle form submission
     */
    public function handle_form_submission() {
        if (!isset($_POST['portfolio_quick_post_submit'])) {
            return;
        }
        
        // Check nonce
        if (!isset($_POST['portfolio_quick_post_nonce']) || 
            !wp_verify_nonce($_POST['portfolio_quick_post_nonce'], 'portfolio_quick_post_action')) {
            wp_die(__('Security check failed. Please try again.', 'portfolio'));
        }
        
        // Check permissions
        if (!current_user_can('edit_posts')) {
            wp_die(__('You do not have permission to add posts.', 'portfolio'));
        }
        
        // Get form data
        $title = isset($_POST['post_title']) ? sanitize_text_field($_POST['post_title']) : '';
        $url = isset($_POST['post_url']) ? esc_url_raw($_POST['post_url']) : '';
        $platform = isset($_POST['post_platform']) ? sanitize_text_field($_POST['post_platform']) : '';
        $description = isset($_POST['post_description']) ? wp_kses_post($_POST['post_description']) : '';
        $image_id = isset($_POST['post_image_id']) ? absint($_POST['post_image_id']) : 0;
        $embed_code = isset($_POST['post_embed_code']) ? wp_kses_post($_POST['post_embed_code']) : '';
        $post_id = isset($_POST['post_id']) ? absint($_POST['post_id']) : 0;
        
        // Check if we're editing an existing post
        $is_edit = ($post_id > 0);
        
        // Validate required fields
        if (empty($title) || empty($url) || empty($platform)) {
            // Store form data for repopulation
            $form_data = array(
                'title' => $title,
                'url' => $url,
                'platform' => $platform,
                'description' => $description,
                'image_id' => $image_id,
                'embed_code' => $embed_code,
                'error' => __('Please fill in all required fields.', 'portfolio')
            );
            
            if ($is_edit) {
                $form_data['edit_id'] = $post_id;
            }
            
            set_transient('portfolio_quick_post_data', $form_data, 60);
            
            // Redirect back to form
            if ($is_edit) {
                wp_redirect(admin_url('admin.php?page=portfolio-quick-post&edit=' . $post_id . '&error=1'));
            } else {
                wp_redirect(admin_url('admin.php?page=portfolio-quick-post&error=1'));
            }
            exit;
        }
        
        // Create new or update existing campaign post
        $post_data = array(
            'post_title' => $title,
            'post_content' => $description,
            'post_status' => 'publish',
            'post_type' => 'portfolio_campaign',
        );
        
        if ($is_edit) {
            $post_data['ID'] = $post_id;
        }
        
        $post_id = wp_insert_post($post_data);
        
        if (is_wp_error($post_id)) {
            // Store form data for repopulation
            set_transient('portfolio_quick_post_data', array(
                'title' => $title,
                'url' => $url,
                'platform' => $platform,
                'description' => $description,
                'image_id' => $image_id,
                'embed_code' => $embed_code,
                'error' => $post_id->get_error_message()
            ), 60);
            
            // Redirect back to form
            wp_redirect(admin_url('admin.php?page=portfolio-quick-post&error=1'));
            exit;
        }
        
        // Save meta data
        update_post_meta($post_id, '_campaign_url', $url);
        update_post_meta($post_id, '_campaign_platform', $platform);
        update_post_meta($post_id, '_campaign_date', current_time('Y-m-d'));
        
        if (!empty($embed_code)) {
            update_post_meta($post_id, '_campaign_embed_code', $embed_code);
        }
        
        // Set featured image
        if ($image_id > 0) {
            set_post_thumbnail($post_id, $image_id);
        }
        
        // Set campaign type based on platform
        $term = '';
        switch ($platform) {
            case 'linkedin':
                $term = 'LinkedIn Post';
                break;
            case 'instagram':
                $term = 'Instagram Post';
                break;
            case 'twitter':
                $term = 'Twitter Post';
                break;
        }
        
        if (!empty($term)) {
            wp_set_object_terms($post_id, $term, 'campaign_type');
        }
        
        // Redirect to success page
        if ($is_edit) {
            wp_redirect(admin_url('admin.php?page=portfolio-quick-post&edit=' . $post_id . '&success=1'));
        } else {
            wp_redirect(admin_url('admin.php?page=portfolio-quick-post&success=1'));
        }
        exit;
    }
    
    /**
     * Render quick post page
     */
    public function render_quick_post_page() {
        // Check for messages
        $success = isset($_GET['success']) ? true : false;
        $error = isset($_GET['error']) ? true : false;
        $edit_id = isset($_GET['edit']) ? intval($_GET['edit']) : 0;
        $form_data = get_transient('portfolio_quick_post_data');
        
        // Check if we're editing an existing post
        if ($edit_id > 0 && empty($form_data)) {
            $post = get_post($edit_id);
            
            if ($post && $post->post_type === 'portfolio_campaign') {
                // Get post data for editing
                $form_data = array(
                    'title' => $post->post_title,
                    'description' => $post->post_content,
                    'url' => get_post_meta($edit_id, '_campaign_url', true),
                    'platform' => get_post_meta($edit_id, '_campaign_platform', true),
                    'image_id' => get_post_thumbnail_id($edit_id),
                    'embed_code' => get_post_meta($edit_id, '_campaign_embed_code', true),
                    'edit_id' => $edit_id
                );
            }
        }
        
        // Clear transient
        if ($form_data && !isset($form_data['edit_id'])) {
            delete_transient('portfolio_quick_post_data');
        }
        ?>
        <div class="wrap quick-social-post-wrap">
            <h1><?php echo isset($form_data['edit_id']) ? __('Edit Social Post', 'portfolio') : __('Quick Add Social Post', 'portfolio'); ?></h1>
            
            <?php if ($success) : ?>
                <div class="notice notice-success is-dismissible">
                    <p><?php _e('Social post saved successfully!', 'portfolio'); ?></p>
                </div>
            <?php endif; ?>
            
            <?php if ($error && $form_data && isset($form_data['error'])) : ?>
                <div class="notice notice-error is-dismissible">
                    <p><?php echo esc_html($form_data['error']); ?></p>
                </div>
            <?php endif; ?>
            
            <div class="quick-post-container">
                <div class="quick-post-form-wrap">
                    <div class="quick-post-header">
                        <h2><?php echo isset($form_data['edit_id']) ? __('Edit social media post', 'portfolio') : __('Add a social media post to your portfolio', 'portfolio'); ?></h2>
                        <p class="description"><?php _e('Quickly add or edit a LinkedIn, Instagram, or Twitter post to display on your portfolio homepage.', 'portfolio'); ?></p>
                    </div>
                    
                    <form method="post" action="" class="quick-post-form">
                        <?php wp_nonce_field('portfolio_quick_post_action', 'portfolio_quick_post_nonce'); ?>
                        
                        <div class="form-field">
                            <label for="post_title"><?php _e('Title', 'portfolio'); ?> <span class="required">*</span></label>
                            <input type="text" id="post_title" name="post_title" value="<?php echo isset($form_data['title']) ? esc_attr($form_data['title']) : ''; ?>" required />
                            <p class="description"><?php _e('Give your post a title that will appear on your portfolio.', 'portfolio'); ?></p>
                        </div>
                        
                        <div class="form-field">
                            <label for="post_url"><?php _e('Post URL', 'portfolio'); ?> <span class="required">*</span></label>
                            <input type="url" id="post_url" name="post_url" value="<?php echo isset($form_data['url']) ? esc_url($form_data['url']) : ''; ?>" required />
                            <p class="description"><?php _e('The URL to your LinkedIn, Instagram, or Twitter post.', 'portfolio'); ?></p>
                        </div>
                        
                        <div class="form-field">
                            <label for="post_platform"><?php _e('Platform', 'portfolio'); ?> <span class="required">*</span></label>
                            <select id="post_platform" name="post_platform" required>
                                <option value=""><?php _e('Select Platform', 'portfolio'); ?></option>
                                <option value="linkedin" <?php selected(isset($form_data['platform']) && $form_data['platform'] === 'linkedin'); ?>><?php _e('LinkedIn', 'portfolio'); ?></option>
                                <option value="instagram" <?php selected(isset($form_data['platform']) && $form_data['platform'] === 'instagram'); ?>><?php _e('Instagram', 'portfolio'); ?></option>
                                <option value="twitter" <?php selected(isset($form_data['platform']) && $form_data['platform'] === 'twitter'); ?>><?php _e('Twitter', 'portfolio'); ?></option>
                            </select>
                        </div>
                        
                        <div class="form-field">
                            <label for="post_description"><?php _e('Description', 'portfolio'); ?></label>
                            <textarea id="post_description" name="post_description" rows="3"><?php echo isset($form_data['description']) ? esc_textarea($form_data['description']) : ''; ?></textarea>
                            <p class="description"><?php _e('A brief description of your post (optional).', 'portfolio'); ?></p>
                        </div>
                        
                        <div class="form-field">
                            <label><?php _e('Featured Image', 'portfolio'); ?></label>
                            <div id="post-image-container" class="post-image-container">
                                <?php if (isset($form_data['image_id']) && $form_data['image_id'] > 0) : ?>
                                    <?php echo wp_get_attachment_image($form_data['image_id'], 'thumbnail'); ?>
                                <?php else : ?>
                                    <div class="no-image-placeholder">
                                        <span class="dashicons dashicons-format-image"></span>
                                        <span><?php _e('No image selected', 'portfolio'); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <input type="hidden" id="post_image_id" name="post_image_id" value="<?php echo isset($form_data['image_id']) ? absint($form_data['image_id']) : ''; ?>" />
                            <button type="button" id="select-image-button" class="button"><?php _e('Select Image', 'portfolio'); ?></button>
                            <button type="button" id="remove-image-button" class="button" <?php echo (!isset($form_data['image_id']) || $form_data['image_id'] <= 0) ? 'style="display:none"' : ''; ?>><?php _e('Remove Image', 'portfolio'); ?></button>
                            <p class="description"><?php _e('Upload or select an image to represent this post (optional).', 'portfolio'); ?></p>
                        </div>
                        
                        <div class="form-field">
                            <label for="post_embed_code"><?php _e('Embed Code', 'portfolio'); ?></label>
                            <textarea id="post_embed_code" name="post_embed_code" rows="4"><?php echo isset($form_data['embed_code']) ? esc_textarea($form_data['embed_code']) : ''; ?></textarea>
                            <p class="description"><?php _e('If you have an embed code from the platform, paste it here (optional). This will create an interactive embed.', 'portfolio'); ?></p>
                        </div>
                        
                        <?php if (isset($form_data['edit_id'])) : ?>
                            <input type="hidden" name="post_id" value="<?php echo esc_attr($form_data['edit_id']); ?>" />
                        <?php endif; ?>
                        
                        <div class="form-actions">
                            <button type="button" id="preview-button" class="button button-secondary"><?php _e('Preview Post', 'portfolio'); ?></button>
                            <input type="submit" name="portfolio_quick_post_submit" class="button button-primary" value="<?php echo isset($form_data['edit_id']) ? esc_attr__('Update Post', 'portfolio') : esc_attr__('Add to Portfolio', 'portfolio'); ?>" />
                            <?php if (isset($form_data['edit_id'])) : ?>
                                <a href="<?php echo esc_url(admin_url('edit.php?post_type=portfolio_campaign')); ?>" class="button"><?php esc_html_e('Cancel', 'portfolio'); ?></a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
                
                <div class="quick-post-preview-wrap">
                    <div class="quick-post-preview-header">
                        <h2><?php _e('Post Preview', 'portfolio'); ?></h2>
                    </div>
                    <div id="post-preview-container" class="post-preview-container">
                        <div class="post-preview-placeholder">
                            <span class="dashicons dashicons-welcome-view-site"></span>
                            <p><?php _e('Enter a post URL and click "Preview Post" to see how it will appear on your site.', 'portfolio'); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    
    /**
     * AJAX handler for post preview
     */
    public function ajax_get_social_post_preview() {
        // Check nonce
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'portfolio-quick-post-nonce')) {
            wp_send_json_error(array('message' => __('Security check failed.', 'portfolio')));
        }
        
        // Check permissions
        if (!current_user_can('edit_posts')) {
            wp_send_json_error(array('message' => __('You do not have permission to do this.', 'portfolio')));
        }
        
        // Get URL and platform
        $url = isset($_POST['url']) ? esc_url_raw($_POST['url']) : '';
        $platform = isset($_POST['platform']) ? sanitize_text_field($_POST['platform']) : '';
        $image_id = isset($_POST['image_id']) ? absint($_POST['image_id']) : 0;
        $title = isset($_POST['title']) ? sanitize_text_field($_POST['title']) : '';
        $description = isset($_POST['description']) ? wp_kses_post($_POST['description']) : '';
        
        if (empty($url)) {
            wp_send_json_error(array('message' => __('Please enter a valid URL.', 'portfolio')));
        }
        
        ob_start();
        ?>
        <div class="portfolio-campaign-item preview-item">
            <div class="portfolio-campaign-content">
                <?php if ($image_id > 0) : ?>
                    <div class="portfolio-campaign-thumbnail">
                        <?php echo wp_get_attachment_image($image_id, 'medium', false, array('class' => 'preview-image')); ?>
                    </div>
                <?php else : ?>
                    <div class="portfolio-campaign-thumbnail preview-thumbnail">
                        <div class="platform-icon <?php echo esc_attr($platform); ?>-icon">
                            <span class="dashicons <?php echo esc_attr($this->get_platform_icon($platform)); ?>"></span>
                        </div>
                    </div>
                <?php endif; ?>
                
                <div class="portfolio-campaign-excerpt">
                    <h3 class="portfolio-campaign-title">
                        <?php echo esc_html($title); ?>
                    </h3>
                    
                    <?php if (!empty($description)) : ?>
                        <div class="portfolio-campaign-description">
                            <?php echo wpautop($description); ?>
                        </div>
                    <?php endif; ?>
                    
                    <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener" class="portfolio-campaign-link">
                        <?php _e('View Original', 'portfolio'); ?> <span class="screen-reader-text"><?php _e('(opens in a new tab)', 'portfolio'); ?></span>
                    </a>
                </div>
            </div>
            
            <div class="portfolio-campaign-meta">
                <span class="portfolio-campaign-platform">
                    <span class="dashicons <?php echo esc_attr($this->get_platform_icon($platform)); ?>"></span>
                    <?php echo esc_html(ucfirst($platform)); ?>
                </span>
                
                <span class="portfolio-campaign-date">
                    <span class="dashicons dashicons-calendar-alt"></span>
                    <?php echo esc_html(date_i18n(get_option('date_format'))); ?>
                </span>
            </div>
        </div>
        <?php
        $preview = ob_get_clean();
        
        wp_send_json_success(array(
            'preview' => $preview
        ));
    }
    
    /**
     * Get platform icon
     */
    private function get_platform_icon($platform) {
        switch ($platform) {
            case 'linkedin':
                return 'dashicons-linkedin';
            case 'instagram':
                return 'dashicons-instagram';
            case 'twitter':
                return 'dashicons-twitter';
            default:
                return 'dashicons-admin-links';
        }
    }
    
    /**
     * Add floating quick add button to admin
     */
    public function add_floating_quick_button() {
        // Only show on admin pages
        if (!is_admin()) {
            return;
        }
        
        // Get current screen
        $screen = get_current_screen();
        
        // Don't show on our quick add page
        if ($screen->id === 'campaigns_page_portfolio-quick-post') {
            return;
        }
        
        // Show on campaign related pages, dashboard, and site management
        $show_on_screens = array(
            'edit-portfolio_campaign',
            'portfolio_campaign',
            'toplevel_page_portfolio-campaigns',
            'dashboard',
            'toplevel_page_portfolio-site-management'
        );
        
        // Only show on selected screens
        if (!in_array($screen->id, $show_on_screens) && $screen->post_type !== 'portfolio_campaign') {
            return;
        }
        
        ?>
        <div id="portfolio-quick-add-button" class="portfolio-quick-add-button">
            <a href="<?php echo esc_url(admin_url('admin.php?page=portfolio-quick-post')); ?>" title="<?php esc_attr_e('Quick Add Social Post', 'portfolio'); ?>">
                <span class="dashicons dashicons-plus"></span>
                <span class="screen-reader-text"><?php _e('Quick Add Social Post', 'portfolio'); ?></span>
            </a>
        </div>
        
        <style>
            .portfolio-quick-add-button {
                position: fixed;
                bottom: 30px;
                right: 30px;
                z-index: 9999;
            }
            
            .portfolio-quick-add-button a {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 56px;
                height: 56px;
                background: #2271b1;
                color: #fff;
                border-radius: 50%;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
                text-decoration: none;
                transition: all 0.2s ease;
            }
            
            .portfolio-quick-add-button a:hover {
                background: #135e96;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
                transform: translateY(-2px);
            }
            
            .portfolio-quick-add-button .dashicons {
                font-size: 24px;
                width: 24px;
                height: 24px;
            }
            
            /* Animation */
            @keyframes pulse {
                0% {
                    box-shadow: 0 0 0 0 rgba(33, 117, 155, 0.7);
                }
                70% {
                    box-shadow: 0 0 0 10px rgba(33, 117, 155, 0);
                }
                100% {
                    box-shadow: 0 0 0 0 rgba(33, 117, 155, 0);
                }
            }
            
            .portfolio-quick-add-button a {
                animation: pulse 2s infinite;
            }
            
            /* Hide on mobile edit screens to avoid overlapping with publish button */
            @media screen and (max-width: 782px) {
                body.post-new-php .portfolio-quick-add-button,
                body.post-php .portfolio-quick-add-button {
                    display: none;
                }
            }
        </style>
        <?php
    }
}

// Initialize
new Portfolio_Quick_Social_Posts();
