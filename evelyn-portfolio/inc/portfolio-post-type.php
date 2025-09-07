<?php
/**
 * Portfolio Custom Post Type
 * 
 * Creates and configures the Portfolio custom post type
 */

// Register Portfolio Custom Post Type
add_action('init', function() {
    $labels = array(
        'name'               => _x('Portfolio Items', 'post type general name', 'evelyn-portfolio'),
        'singular_name'      => _x('Portfolio Item', 'post type singular name', 'evelyn-portfolio'),
        'menu_name'          => _x('Portfolio', 'admin menu', 'evelyn-portfolio'),
        'name_admin_bar'     => _x('Portfolio Item', 'add new on admin bar', 'evelyn-portfolio'),
        'add_new'            => _x('Add New', 'portfolio item', 'evelyn-portfolio'),
        'add_new_item'       => __('Add New Portfolio Item', 'evelyn-portfolio'),
        'new_item'           => __('New Portfolio Item', 'evelyn-portfolio'),
        'edit_item'          => __('Edit Portfolio Item', 'evelyn-portfolio'),
        'view_item'          => __('View Portfolio Item', 'evelyn-portfolio'),
        'all_items'          => __('All Portfolio Items', 'evelyn-portfolio'),
        'search_items'       => __('Search Portfolio Items', 'evelyn-portfolio'),
        'parent_item_colon'  => __('Parent Portfolio Items:', 'evelyn-portfolio'),
        'not_found'          => __('No portfolio items found.', 'evelyn-portfolio'),
        'not_found_in_trash' => __('No portfolio items found in Trash.', 'evelyn-portfolio')
    );

    $args = array(
        'labels'             => $labels,
        'description'        => __('Portfolio items for showcasing work', 'evelyn-portfolio'),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'portfolio'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-format-gallery',
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'show_in_rest'       => true, // Enable Gutenberg editor
    );

    register_post_type('portfolio', $args);
});

// Register Portfolio Categories Taxonomy
add_action('init', function() {
    $labels = array(
        'name'              => _x('Portfolio Categories', 'taxonomy general name', 'evelyn-portfolio'),
        'singular_name'     => _x('Portfolio Category', 'taxonomy singular name', 'evelyn-portfolio'),
        'search_items'      => __('Search Portfolio Categories', 'evelyn-portfolio'),
        'all_items'         => __('All Portfolio Categories', 'evelyn-portfolio'),
        'parent_item'       => __('Parent Portfolio Category', 'evelyn-portfolio'),
        'parent_item_colon' => __('Parent Portfolio Category:', 'evelyn-portfolio'),
        'edit_item'         => __('Edit Portfolio Category', 'evelyn-portfolio'),
        'update_item'       => __('Update Portfolio Category', 'evelyn-portfolio'),
        'add_new_item'      => __('Add New Portfolio Category', 'evelyn-portfolio'),
        'new_item_name'     => __('New Portfolio Category Name', 'evelyn-portfolio'),
        'menu_name'         => __('Categories', 'evelyn-portfolio'),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'portfolio-category'),
        'show_in_rest'      => true, // Enable in Gutenberg
    );

    register_taxonomy('portfolio_category', array('portfolio'), $args);
});

// Register Portfolio Tags Taxonomy
add_action('init', function() {
    $labels = array(
        'name'              => _x('Portfolio Tags', 'taxonomy general name', 'evelyn-portfolio'),
        'singular_name'     => _x('Portfolio Tag', 'taxonomy singular name', 'evelyn-portfolio'),
        'search_items'      => __('Search Portfolio Tags', 'evelyn-portfolio'),
        'all_items'         => __('All Portfolio Tags', 'evelyn-portfolio'),
        'parent_item'       => __('Parent Portfolio Tag', 'evelyn-portfolio'),
        'parent_item_colon' => __('Parent Portfolio Tag:', 'evelyn-portfolio'),
        'edit_item'         => __('Edit Portfolio Tag', 'evelyn-portfolio'),
        'update_item'       => __('Update Portfolio Tag', 'evelyn-portfolio'),
        'add_new_item'      => __('Add New Portfolio Tag', 'evelyn-portfolio'),
        'new_item_name'     => __('New Portfolio Tag Name', 'evelyn-portfolio'),
        'menu_name'         => __('Tags', 'evelyn-portfolio'),
    );

    $args = array(
        'hierarchical'      => false,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'portfolio-tag'),
        'show_in_rest'      => true, // Enable in Gutenberg
    );

    register_taxonomy('portfolio_tag', array('portfolio'), $args);
});

// Add portfolio item metadata
add_action('add_meta_boxes', function() {
    add_meta_box(
        'portfolio_details',
        __('Portfolio Details', 'evelyn-portfolio'),
        'portfolio_details_callback',
        'portfolio',
        'normal',
        'high'
    );
});

function portfolio_details_callback($post) {
    wp_nonce_field(basename(__FILE__), 'portfolio_details_nonce');
    
    // Get saved values
    $client = get_post_meta($post->ID, '_portfolio_client', true);
    $project_date = get_post_meta($post->ID, '_portfolio_date', true);
    $project_url = get_post_meta($post->ID, '_portfolio_url', true);
    $featured = get_post_meta($post->ID, '_portfolio_featured', true);
    
    ?>
    <div class="portfolio-details-wrapper">
        <p>
            <label for="portfolio_client"><?php _e('Client:', 'evelyn-portfolio'); ?></label>
            <input type="text" id="portfolio_client" name="portfolio_client" value="<?php echo esc_attr($client); ?>" class="widefat">
        </p>
        
        <p>
            <label for="portfolio_date"><?php _e('Project Date:', 'evelyn-portfolio'); ?></label>
            <input type="date" id="portfolio_date" name="portfolio_date" value="<?php echo esc_attr($project_date); ?>" class="widefat">
        </p>
        
        <p>
            <label for="portfolio_url"><?php _e('Project URL:', 'evelyn-portfolio'); ?></label>
            <input type="url" id="portfolio_url" name="portfolio_url" value="<?php echo esc_url($project_url); ?>" class="widefat" placeholder="https://">
        </p>
        
        <p>
            <input type="checkbox" id="portfolio_featured" name="portfolio_featured" value="1" <?php checked($featured, '1'); ?>>
            <label for="portfolio_featured"><?php _e('Feature this project on the homepage', 'evelyn-portfolio'); ?></label>
        </p>
    </div>
    <?php
}

// Save portfolio details
add_action('save_post', function($post_id) {
    // Check if our nonce is set and verify it
    if (!isset($_POST['portfolio_details_nonce']) || !wp_verify_nonce($_POST['portfolio_details_nonce'], basename(__FILE__))) {
        return $post_id;
    }
    
    // Check user permissions
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    
    if ('portfolio' !== $_POST['post_type'] || !current_user_can('edit_post', $post_id)) {
        return $post_id;
    }
    
    // Save portfolio details
    if (isset($_POST['portfolio_client'])) {
        update_post_meta($post_id, '_portfolio_client', sanitize_text_field($_POST['portfolio_client']));
    }
    
    if (isset($_POST['portfolio_date'])) {
        update_post_meta($post_id, '_portfolio_date', sanitize_text_field($_POST['portfolio_date']));
    }
    
    if (isset($_POST['portfolio_url'])) {
        update_post_meta($post_id, '_portfolio_url', esc_url_raw($_POST['portfolio_url']));
    }
    
    // Checkbox handling
    if (isset($_POST['portfolio_featured'])) {
        update_post_meta($post_id, '_portfolio_featured', '1');
    } else {
        update_post_meta($post_id, '_portfolio_featured', '0');
    }
});

// Add Portfolio Items to REST API
add_action('rest_api_init', function() {
    register_rest_field('portfolio', 'portfolio_details', array(
        'get_callback' => function($post) {
            return array(
                'client' => get_post_meta($post['id'], '_portfolio_client', true),
                'date' => get_post_meta($post['id'], '_portfolio_date', true),
                'url' => get_post_meta($post['id'], '_portfolio_url', true),
                'featured' => (bool) get_post_meta($post['id'], '_portfolio_featured', true),
                'gallery' => array_map('intval', explode(',', get_post_meta($post['id'], '_portfolio_gallery_images', true))),
                'featured_image' => get_the_post_thumbnail_url($post['id'], 'full'),
                'categories' => wp_get_post_terms($post['id'], 'portfolio_category', array('fields' => 'names')),
                'tags' => wp_get_post_terms($post['id'], 'portfolio_tag', array('fields' => 'names')),
            );
        },
    ));
});

// Add portfolio archive template
add_filter('template_include', function($template) {
    if (is_post_type_archive('portfolio')) {
        $new_template = locate_template(array('archive-portfolio.php'));
        if ('' != $new_template) {
            return $new_template;
        }
    }
    
    if (is_singular('portfolio')) {
        $new_template = locate_template(array('single-portfolio.php'));
        if ('' != $new_template) {
            return $new_template;
        }
    }
    
    return $template;
});

// Helper function to get portfolio items
function get_portfolio_items($args = array()) {
    $defaults = array(
        'post_type' => 'portfolio',
        'posts_per_page' => 9,
        'orderby' => 'date',
        'order' => 'DESC',
    );
    
    $args = wp_parse_args($args, $defaults);
    
    return get_posts($args);
}

// Helper function to get featured portfolio items
function get_featured_portfolio_items($limit = 6) {
    return get_portfolio_items(array(
        'posts_per_page' => $limit,
        'meta_key' => '_portfolio_featured',
        'meta_value' => '1',
    ));
}

// Register portfolio shortcode
add_shortcode('portfolio_grid', function($atts) {
    $atts = shortcode_atts(array(
        'limit' => 6,
        'category' => '',
        'columns' => 3,
        'featured_only' => false,
    ), $atts);
    
    $args = array(
        'posts_per_page' => intval($atts['limit']),
    );
    
    // Filter by category if specified
    if (!empty($atts['category'])) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'portfolio_category',
                'field' => 'slug',
                'terms' => $atts['category'],
            ),
        );
    }
    
    // Filter by featured if specified
    if (filter_var($atts['featured_only'], FILTER_VALIDATE_BOOLEAN)) {
        $args['meta_key'] = '_portfolio_featured';
        $args['meta_value'] = '1';
    }
    
    $portfolio_items = get_portfolio_items($args);
    
    if (empty($portfolio_items)) {
        return '<p class="no-portfolio-items">' . __('No portfolio items found.', 'evelyn-portfolio') . '</p>';
    }
    
    // Get columns setting
    $columns = intval($atts['columns']);
    if ($columns < 1 || $columns > 4) {
        $columns = 3;
    }
    
    // Get hover effect
    $hover_effect = get_portfolio_setting('image_hover_effect', 'zoom');
    
    $output = '<div class="portfolio-grid columns-' . $columns . '">';
    
    foreach ($portfolio_items as $item) {
        $thumbnail = get_the_post_thumbnail_url($item->ID, 'portfolio-medium');
        if (!$thumbnail) {
            $thumbnail = get_template_directory_uri() . '/assets/images/placeholder.jpg';
        }
        
        $categories = get_the_terms($item->ID, 'portfolio_category');
        $category_names = array();
        
        if (!empty($categories) && !is_wp_error($categories)) {
            foreach ($categories as $category) {
                $category_names[] = $category->name;
            }
        }
        
        $output .= '<div class="portfolio-item hover-effect-' . esc_attr($hover_effect) . '">';
        $output .= '<a href="' . get_permalink($item->ID) . '" class="portfolio-item-link">';
        $output .= '<div class="portfolio-item-image">';
        $output .= '<img src="' . esc_url($thumbnail) . '" alt="' . esc_attr($item->post_title) . '">';
        $output .= '</div>';
        $output .= '<div class="portfolio-item-overlay">';
        $output .= '<h3 class="portfolio-item-title">' . esc_html($item->post_title) . '</h3>';
        
        if (!empty($category_names) && get_portfolio_setting('show_categories', '1')) {
            $output .= '<div class="portfolio-item-categories">' . esc_html(implode(', ', $category_names)) . '</div>';
        }
        
        $output .= '</div>';
        $output .= '</a>';
        $output .= '</div>';
    }
    
    $output .= '</div>';
    
    return $output;
});

// AJAX filter for portfolio items
add_action('wp_ajax_filter_portfolio', 'filter_portfolio_items');
add_action('wp_ajax_nopriv_filter_portfolio', 'filter_portfolio_items');

function filter_portfolio_items() {
    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'portfolio_filter_nonce')) {
        wp_send_json_error('Invalid nonce');
    }
    
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
    
    $args = array(
        'post_type' => 'portfolio',
        'posts_per_page' => get_portfolio_setting('items_per_page', 9),
        'paged' => $paged,
    );
    
    // Add category filter
    if (!empty($category) && $category !== 'all') {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'portfolio_category',
                'field' => 'slug',
                'terms' => $category,
            ),
        );
    }
    
    $query = new WP_Query($args);
    
    $response = array(
        'success' => true,
        'found' => $query->found_posts,
        'max_pages' => $query->max_num_pages,
        'html' => '',
    );
    
    if ($query->have_posts()) {
        ob_start();
        while ($query->have_posts()) {
            $query->the_post();
            
            $thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'portfolio-medium');
            if (!$thumbnail) {
                $thumbnail = get_template_directory_uri() . '/assets/images/placeholder.jpg';
            }
            
            $categories = get_the_terms(get_the_ID(), 'portfolio_category');
            $category_names = array();
            
            if (!empty($categories) && !is_wp_error($categories)) {
                foreach ($categories as $category) {
                    $category_names[] = $category->name;
                }
            }
            
            // Get hover effect
            $hover_effect = get_portfolio_setting('image_hover_effect', 'zoom');
            
            ?>
            <div class="portfolio-item hover-effect-<?php echo esc_attr($hover_effect); ?>">
                <a href="<?php the_permalink(); ?>" class="portfolio-item-link">
                    <div class="portfolio-item-image">
                        <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php the_title_attribute(); ?>">
                    </div>
                    <div class="portfolio-item-overlay">
                        <h3 class="portfolio-item-title"><?php the_title(); ?></h3>
                        
                        <?php if (!empty($category_names) && get_portfolio_setting('show_categories', '1')) : ?>
                            <div class="portfolio-item-categories"><?php echo esc_html(implode(', ', $category_names)); ?></div>
                        <?php endif; ?>
                    </div>
                </a>
            </div>
            <?php
        }
        $response['html'] = ob_get_clean();
    }
    
    wp_reset_postdata();
    wp_send_json($response);
}
