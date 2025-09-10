<?php
/**
 * Testimonials Registration Fixer
 * 
 * This file ensures testimonials are registered properly.
 * Include this file at the top of your functions.php to fix testimonial post type issues.
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Only proceed if the post type doesn't already exist
if (!post_type_exists('portfolio_testimonial')) {
    // Register the post type directly with highest priority
    add_action('init', 'portfolio_testimonials_emergency_register', -9999);
}

/**
 * Emergency registration function with highest priority
 */
function portfolio_testimonials_emergency_register() {
    if (!post_type_exists('portfolio_testimonial')) {
        $labels = array(
            'name'                  => 'Testimonials',
            'singular_name'         => 'Testimonial',
            'menu_name'             => 'Testimonials',
            'name_admin_bar'        => 'Testimonial',
            'add_new'               => 'Add New',
            'add_new_item'          => 'Add New Testimonial',
            'new_item'              => 'New Testimonial',
            'edit_item'             => 'Edit Testimonial',
            'view_item'             => 'View Testimonial',
            'all_items'             => 'All Testimonials',
            'search_items'          => 'Search Testimonials',
            'not_found'             => 'No testimonials found.',
            'not_found_in_trash'    => 'No testimonials found in Trash.',
            'featured_image'        => 'Client Image',
            'set_featured_image'    => 'Set client image',
            'remove_featured_image' => 'Remove client image',
            'use_featured_image'    => 'Use as client image',
            'archives'              => 'Testimonial archives',
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
        
        // Try to flush rewrite rules
        global $wp_rewrite;
        if ($wp_rewrite) {
            $wp_rewrite->flush_rules();
        }
        
        // Also register the meta boxes since we registered the post type
        add_action('add_meta_boxes', 'portfolio_testimonials_emergency_add_meta_boxes');
        add_action('save_post', 'portfolio_testimonials_emergency_save_meta_box', 10, 2);
        
        // Add admin columns
        add_filter('manage_portfolio_testimonial_posts_columns', 'portfolio_testimonials_emergency_set_columns');
        add_action('manage_portfolio_testimonial_posts_custom_column', 'portfolio_testimonials_emergency_column_content', 10, 2);
        
        // Add a notice that the emergency fix is active
        add_action('admin_notices', function() {
            if (!current_user_can('manage_options')) return;
            ?>
            <div class="notice notice-warning is-dismissible">
                <p><strong>Emergency Fix:</strong> Testimonial post type was registered by the emergency fix.</p>
                <p>Visit <a href="<?php echo admin_url('options-permalink.php'); ?>">Settings > Permalinks</a> and click Save Changes to update permalink structure.</p>
            </div>
            <?php
        });
    }
}

/**
 * Add meta boxes for testimonials
 */
function portfolio_testimonials_emergency_add_meta_boxes() {
    add_meta_box(
        'portfolio_testimonial_details',
        'Client Details',
        'portfolio_testimonials_emergency_render_meta_box',
        'portfolio_testimonial',
        'normal',
        'high'
    );
}

/**
 * Render the testimonials meta box
 */
function portfolio_testimonials_emergency_render_meta_box($post) {
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
        <label for="portfolio_testimonial_client_name">Client Name:</label>
        <input type="text" id="portfolio_testimonial_client_name" name="portfolio_testimonial_client_name" 
               value="<?php echo esc_attr($client_name); ?>" class="widefat">
    </p>
    
    <p>
        <label for="portfolio_testimonial_client_title">Client Title/Position:</label>
        <input type="text" id="portfolio_testimonial_client_title" name="portfolio_testimonial_client_title" 
               value="<?php echo esc_attr($client_title); ?>" class="widefat">
    </p>
    
    <p>
        <label for="portfolio_testimonial_client_company">Client Company/Organization:</label>
        <input type="text" id="portfolio_testimonial_client_company" name="portfolio_testimonial_client_company" 
               value="<?php echo esc_attr($client_company); ?>" class="widefat">
    </p>
    
    <p>
        <label for="portfolio_testimonial_rating">Rating:</label>
        <select id="portfolio_testimonial_rating" name="portfolio_testimonial_rating" class="widefat">
            <option value="5" <?php selected($rating, 5); ?>>5 Stars</option>
            <option value="4" <?php selected($rating, 4); ?>>4 Stars</option>
            <option value="3" <?php selected($rating, 3); ?>>3 Stars</option>
            <option value="2" <?php selected($rating, 2); ?>>2 Stars</option>
            <option value="1" <?php selected($rating, 1); ?>>1 Star</option>
        </select>
    </p>
    <?php
}

/**
 * Save meta box data
 */
function portfolio_testimonials_emergency_save_meta_box($post_id, $post) {
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
    if ('portfolio_testimonial' === $_POST['post_type'] && !current_user_can('edit_post', $post_id)) {
        return;
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

/**
 * Set admin columns
 */
function portfolio_testimonials_emergency_set_columns($columns) {
    $new_columns = array(
        'cb' => $columns['cb'],
        'title' => $columns['title'],
        'client_info' => 'Client Info',
        'rating' => 'Rating',
        'date' => $columns['date']
    );
    return $new_columns;
}

/**
 * Add column content
 */
function portfolio_testimonials_emergency_column_content($column, $post_id) {
    switch ($column) {
        case 'client_info':
            $client_name = get_post_meta($post_id, '_portfolio_testimonial_client_name', true);
            $client_title = get_post_meta($post_id, '_portfolio_testimonial_client_title', true);
            $client_company = get_post_meta($post_id, '_portfolio_testimonial_client_company', true);
            
            if (!empty($client_name)) {
                echo '<strong>' . esc_html($client_name) . '</strong><br>';
            }
            
            if (!empty($client_title)) {
                echo esc_html($client_title);
                if (!empty($client_company)) {
                    echo ', ';
                }
            }
            
            if (!empty($client_company)) {
                echo esc_html($client_company);
            }
            break;
            
        case 'rating':
            $rating = get_post_meta($post_id, '_portfolio_testimonial_rating', true);
            if (!empty($rating)) {
                // Display stars for rating
                $stars = '';
                for ($i = 1; $i <= 5; $i++) {
                    if ($i <= $rating) {
                        $stars .= '<span class="dashicons dashicons-star-filled" style="color:#ffb900;"></span>';
                    } else {
                        $stars .= '<span class="dashicons dashicons-star-empty" style="color:#ccc;"></span>';
                    }
                }
                echo $stars;
            } else {
                echo '—';
            }
            break;
    }
}
