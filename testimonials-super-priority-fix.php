<?php
/**
 * Super Priority Testimonials Fix
 *
 * This file registers the testimonials post type with absolute priority
 * and implements a direct solution that avoids conflicts with other code.
 */

// Don't allow direct access
if (!defined('ABSPATH')) {
    exit;
}

// Register with the highest priority possible
function portfolio_testimonials_super_priority_fix() {
    if (!post_type_exists('portfolio_testimonial')) {
        $labels = array(
            'name'                  => _x('Testimonials', 'Post type general name', 'portfolio'),
            'singular_name'         => _x('Testimonial', 'Post type singular name', 'portfolio'),
            'menu_name'             => _x('Testimonials', 'Admin Menu text', 'portfolio'),
            'name_admin_bar'        => _x('Testimonial', 'Add New on Toolbar', 'portfolio'),
            'add_new'               => __('Add New', 'portfolio'),
            'add_new_item'          => __('Add New Testimonial', 'portfolio'),
            'new_item'              => __('New Testimonial', 'portfolio'),
            'edit_item'             => __('Edit Testimonial', 'portfolio'),
            'view_item'             => __('View Testimonial', 'portfolio'),
            'all_items'             => __('All Testimonials', 'portfolio'),
            'search_items'          => __('Search Testimonials', 'portfolio'),
            'not_found'             => __('No testimonials found.', 'portfolio'),
            'not_found_in_trash'    => __('No testimonials found in Trash.', 'portfolio'),
            'featured_image'        => __('Client Image', 'portfolio'),
            'set_featured_image'    => __('Set client image', 'portfolio'),
            'remove_featured_image' => __('Remove client image', 'portfolio'),
            'use_featured_image'    => __('Use as client image', 'portfolio'),
            'archives'              => __('Testimonial archives', 'portfolio'),
        );
        
        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'testimonials'),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => 22,
            'menu_icon'          => 'dashicons-format-quote',
            'supports'           => array('title', 'editor', 'thumbnail'),
            'show_in_rest'       => true,
        );
        
        register_post_type('portfolio_testimonial', $args);
        update_option('portfolio_testimonials_super_priority_fixed', time());
    }
}

// Register at muplugins_loaded (absolute earliest)
add_action('muplugins_loaded', 'portfolio_testimonials_super_priority_fix', -99999);

// Also register at plugins_loaded
add_action('plugins_loaded', 'portfolio_testimonials_super_priority_fix', -99999);

// Also register at init with highest priority (as fallback)
add_action('init', 'portfolio_testimonials_super_priority_fix', -99999);

// Add admin notice if we had to fix this
function portfolio_testimonials_super_priority_admin_notice() {
    if (get_option('portfolio_testimonials_super_priority_fixed')) {
        echo '<div class="notice notice-warning">
            <p><strong>Super Priority Fix:</strong> Testimonial post type was registered by the super priority fix. 
            This indicates there may still be conflicts in your theme code.</p>
        </div>';
    }
}
add_action('admin_notices', 'portfolio_testimonials_super_priority_admin_notice');

// Add meta boxes for testimonials
function portfolio_testimonials_super_priority_add_meta_boxes() {
    add_meta_box(
        'portfolio_testimonial_details',
        __('Client Details', 'portfolio'),
        'portfolio_testimonials_super_priority_render_meta_box',
        'portfolio_testimonial',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'portfolio_testimonials_super_priority_add_meta_boxes');

// Render the meta box
function portfolio_testimonials_super_priority_render_meta_box($post) {
    // Add a nonce field
    wp_nonce_field('portfolio_testimonial_meta_box', 'portfolio_testimonial_meta_box_nonce');
    
    // Get existing meta values
    $client_name = get_post_meta($post->ID, '_portfolio_testimonial_client_name', true);
    $client_title = get_post_meta($post->ID, '_portfolio_testimonial_client_title', true);
    $client_company = get_post_meta($post->ID, '_portfolio_testimonial_client_company', true);
    $rating = get_post_meta($post->ID, '_portfolio_testimonial_rating', true);
    
    if (empty($rating)) {
        $rating = 5; // Default to 5 stars
    }
    
    ?>
    <p>
        <label for="portfolio_testimonial_client_name"><?php _e('Client Name:', 'portfolio'); ?></label>
        <input type="text" id="portfolio_testimonial_client_name" name="portfolio_testimonial_client_name" 
               value="<?php echo esc_attr($client_name); ?>" class="widefat">
    </p>
    
    <p>
        <label for="portfolio_testimonial_client_title"><?php _e('Client Title/Position:', 'portfolio'); ?></label>
        <input type="text" id="portfolio_testimonial_client_title" name="portfolio_testimonial_client_title" 
               value="<?php echo esc_attr($client_title); ?>" class="widefat">
    </p>
    
    <p>
        <label for="portfolio_testimonial_client_company"><?php _e('Client Company/Organization:', 'portfolio'); ?></label>
        <input type="text" id="portfolio_testimonial_client_company" name="portfolio_testimonial_client_company" 
               value="<?php echo esc_attr($client_company); ?>" class="widefat">
    </p>
    
    <p>
        <label for="portfolio_testimonial_rating"><?php _e('Rating:', 'portfolio'); ?></label>
        <select id="portfolio_testimonial_rating" name="portfolio_testimonial_rating" class="widefat">
            <option value="5" <?php selected($rating, 5); ?>><?php _e('5 Stars', 'portfolio'); ?></option>
            <option value="4" <?php selected($rating, 4); ?>><?php _e('4 Stars', 'portfolio'); ?></option>
            <option value="3" <?php selected($rating, 3); ?>><?php _e('3 Stars', 'portfolio'); ?></option>
            <option value="2" <?php selected($rating, 2); ?>><?php _e('2 Stars', 'portfolio'); ?></option>
            <option value="1" <?php selected($rating, 1); ?>><?php _e('1 Star', 'portfolio'); ?></option>
        </select>
    </p>
    <?php
}

// Save the meta box data
function portfolio_testimonials_super_priority_save_meta_box($post_id) {
    // Check if nonce is set
    if (!isset($_POST['portfolio_testimonial_meta_box_nonce'])) {
        return;
    }
    
    // Verify that the nonce is valid
    if (!wp_verify_nonce($_POST['portfolio_testimonial_meta_box_nonce'], 'portfolio_testimonial_meta_box')) {
        return;
    }
    
    // If this is an autosave, don't do anything
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // Check the user's permissions
    if ('portfolio_testimonial' === $_POST['post_type']) {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    }
    
    // Save the meta fields
    if (isset($_POST['portfolio_testimonial_client_name'])) {
        update_post_meta($post_id, '_portfolio_testimonial_client_name', 
            sanitize_text_field($_POST['portfolio_testimonial_client_name']));
    }
    
    if (isset($_POST['portfolio_testimonial_client_title'])) {
        update_post_meta($post_id, '_portfolio_testimonial_client_title', 
            sanitize_text_field($_POST['portfolio_testimonial_client_title']));
    }
    
    if (isset($_POST['portfolio_testimonial_client_company'])) {
        update_post_meta($post_id, '_portfolio_testimonial_client_company', 
            sanitize_text_field($_POST['portfolio_testimonial_client_company']));
    }
    
    if (isset($_POST['portfolio_testimonial_rating'])) {
        update_post_meta($post_id, '_portfolio_testimonial_rating', 
            intval($_POST['portfolio_testimonial_rating']));
    }
}
add_action('save_post', 'portfolio_testimonials_super_priority_save_meta_box', 10);

// Make sure this runs even during normal page loads
portfolio_testimonials_super_priority_fix();
