<?php
/**
 * Services Functionality
 * 
 * This file contains all the functionality related to the services feature
 * including post type registration, meta boxes, and display functions.
 *
 * @package WordPress
 * @subpackage Portfolio
 * @since 1.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class Portfolio_Services
 * 
 * Handles all service-related functionality
 */
class Portfolio_Services {
    
    /**
     * Constructor
     */
    public function __construct() {
        // Register post type
        add_action('init', array($this, 'register_post_type'));
        
        // Add meta boxes
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        
        // Save meta box data
        add_action('save_post', array($this, 'save_meta_box'), 10, 2);
        
        // Add columns to admin list
        add_filter('manage_portfolio_service_posts_columns', array($this, 'set_custom_columns'));
        add_action('manage_portfolio_service_posts_custom_column', array($this, 'custom_column_content'), 10, 2);
        
        // Register shortcode
        add_shortcode('portfolio_services', array($this, 'services_shortcode'));
    }
    
    /**
     * Register the services post type
     */
    public function register_post_type() {
        $labels = array(
            'name'                  => _x('Services', 'Post type general name', 'portfolio'),
            'singular_name'         => _x('Service', 'Post type singular name', 'portfolio'),
            'menu_name'             => _x('Services', 'Admin Menu text', 'portfolio'),
            'name_admin_bar'        => _x('Service', 'Add New on Toolbar', 'portfolio'),
            'add_new'               => __('Add New', 'portfolio'),
            'add_new_item'          => __('Add New Service', 'portfolio'),
            'new_item'              => __('New Service', 'portfolio'),
            'edit_item'             => __('Edit Service', 'portfolio'),
            'view_item'             => __('View Service', 'portfolio'),
            'all_items'             => __('All Services', 'portfolio'),
            'search_items'          => __('Search Services', 'portfolio'),
            'not_found'             => __('No services found.', 'portfolio'),
            'not_found_in_trash'    => __('No services found in Trash.', 'portfolio'),
            'featured_image'        => __('Service Icon', 'portfolio'),
            'set_featured_image'    => __('Set service icon', 'portfolio'),
            'remove_featured_image' => __('Remove service icon', 'portfolio'),
            'use_featured_image'    => __('Use as service icon', 'portfolio'),
            'archives'              => __('Service archives', 'portfolio'),
        );     
        
        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'services'),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => 21,
            'menu_icon'          => 'dashicons-hammer',
            'supports'           => array('title', 'editor', 'thumbnail', 'excerpt'),
        );
        
        register_post_type('portfolio_service', $args);
    }
    
    /**
     * Add meta boxes to the service post type
     */
    public function add_meta_boxes() {
        add_meta_box(
            'portfolio_service_details',
            __('Service Details', 'portfolio'),
            array($this, 'render_meta_box'),
            'portfolio_service',
            'normal',
            'high'
        );
    }
    
    /**
     * Render the meta box
     */
    public function render_meta_box($post) {
        // Add a nonce field
        wp_nonce_field('portfolio_service_meta_box', 'portfolio_service_meta_box_nonce');
        
        // Get existing meta values
        $service_icon = get_post_meta($post->ID, '_portfolio_service_icon', true);
        $service_price = get_post_meta($post->ID, '_portfolio_service_price', true);
        $service_duration = get_post_meta($post->ID, '_portfolio_service_duration', true);
        $service_featured = get_post_meta($post->ID, '_portfolio_service_featured', true);
        
        ?>
        <p>
            <label for="portfolio_service_icon"><?php _e('Icon Class:', 'portfolio'); ?></label>
            <input type="text" id="portfolio_service_icon" name="portfolio_service_icon" 
                   value="<?php echo esc_attr($service_icon); ?>" class="widefat">
            <span class="description">
                <?php _e('Enter a Dashicons class (e.g., dashicons-admin-customizer) or Font Awesome class (e.g., fas fa-paint-brush).', 'portfolio'); ?>
                <a href="https://developer.wordpress.org/resource/dashicons/" target="_blank"><?php _e('View Dashicons', 'portfolio'); ?></a>
            </span>
        </p>
        
        <p>
            <label for="portfolio_service_price"><?php _e('Price:', 'portfolio'); ?></label>
            <input type="text" id="portfolio_service_price" name="portfolio_service_price" 
                   value="<?php echo esc_attr($service_price); ?>" class="widefat">
            <span class="description"><?php _e('Enter the price for this service (e.g., $100, Starting at $500, Contact for Quote).', 'portfolio'); ?></span>
        </p>
        
        <p>
            <label for="portfolio_service_duration"><?php _e('Duration:', 'portfolio'); ?></label>
            <input type="text" id="portfolio_service_duration" name="portfolio_service_duration" 
                   value="<?php echo esc_attr($service_duration); ?>" class="widefat">
            <span class="description"><?php _e('Enter the typical duration for this service (e.g., 2 weeks, 1-3 months).', 'portfolio'); ?></span>
        </p>
        
        <p>
            <label for="portfolio_service_featured">
                <input type="checkbox" id="portfolio_service_featured" name="portfolio_service_featured" 
                       <?php checked($service_featured, 'yes'); ?> value="yes">
                <?php _e('Featured Service', 'portfolio'); ?>
            </label>
            <span class="description"><?php _e('Check this box to mark this service as featured.', 'portfolio'); ?></span>
        </p>
        <?php
    }
    
    /**
     * Save the meta box data
     */
    public function save_meta_box($post_id, $post) {
        // Check if nonce is set
        if (!isset($_POST['portfolio_service_meta_box_nonce'])) {
            return;
        }
        
        // Verify that the nonce is valid
        if (!wp_verify_nonce($_POST['portfolio_service_meta_box_nonce'], 'portfolio_service_meta_box')) {
            return;
        }
        
        // If this is an autosave, don't do anything
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        
        // Check the user's permissions
        if ('portfolio_service' === $_POST['post_type']) {
            if (!current_user_can('edit_post', $post_id)) {
                return;
            }
        }
        
        // Save the meta fields
        if (isset($_POST['portfolio_service_icon'])) {
            update_post_meta($post_id, '_portfolio_service_icon', sanitize_text_field($_POST['portfolio_service_icon']));
        }
        
        if (isset($_POST['portfolio_service_price'])) {
            update_post_meta($post_id, '_portfolio_service_price', sanitize_text_field($_POST['portfolio_service_price']));
        }
        
        if (isset($_POST['portfolio_service_duration'])) {
            update_post_meta($post_id, '_portfolio_service_duration', sanitize_text_field($_POST['portfolio_service_duration']));
        }
        
        // Featured service checkbox
        $service_featured = isset($_POST['portfolio_service_featured']) ? 'yes' : 'no';
        update_post_meta($post_id, '_portfolio_service_featured', $service_featured);
    }
    
    /**
     * Set custom columns for the service admin list
     */
    public function set_custom_columns($columns) {
        $new_columns = array(
            'cb' => $columns['cb'],
            'title' => $columns['title'],
            'service_icon' => __('Icon', 'portfolio'),
            'service_details' => __('Details', 'portfolio'),
            'featured' => __('Featured', 'portfolio'),
            'date' => $columns['date']
        );
        return $new_columns;
    }
    
    /**
     * Display custom column content
     */
    public function custom_column_content($column, $post_id) {
        switch ($column) {
            case 'service_icon':
                if (has_post_thumbnail($post_id)) {
                    echo get_the_post_thumbnail($post_id, array(50, 50));
                } else {
                    $icon = get_post_meta($post_id, '_portfolio_service_icon', true);
                    if (!empty($icon)) {
                        if (strpos($icon, 'dashicons') !== false) {
                            echo '<span class="dashicons ' . esc_attr($icon) . '" style="font-size:30px;width:30px;height:30px;"></span>';
                        } else {
                            echo '<i class="' . esc_attr($icon) . '" style="font-size:24px;"></i>';
                        }
                    } else {
                        echo '—';
                    }
                }
                break;
                
            case 'service_details':
                $price = get_post_meta($post_id, '_portfolio_service_price', true);
                $duration = get_post_meta($post_id, '_portfolio_service_duration', true);
                
                if (!empty($price)) {
                    echo '<strong>' . __('Price:', 'portfolio') . '</strong> ' . esc_html($price) . '<br>';
                }
                
                if (!empty($duration)) {
                    echo '<strong>' . __('Duration:', 'portfolio') . '</strong> ' . esc_html($duration);
                }
                break;
                
            case 'featured':
                $featured = get_post_meta($post_id, '_portfolio_service_featured', true);
                if ($featured === 'yes') {
                    echo '<span class="dashicons dashicons-star-filled" style="color:#ffb900;"></span>';
                } else {
                    echo '—';
                }
                break;
        }
    }
    
    /**
     * Display services using a shortcode
     */
    public function services_shortcode($atts) {
        $atts = shortcode_atts(array(
            'count' => -1,
            'featured_only' => 'no',
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'layout' => 'grid', // grid, list
            'columns' => 3,
        ), $atts);
        
        $args = array(
            'post_type' => 'portfolio_service',
            'posts_per_page' => intval($atts['count']),
            'orderby' => $atts['orderby'],
            'order' => $atts['order'],
            'post_status' => 'publish',
        );
        
        // Filter by featured if requested
        if ($atts['featured_only'] === 'yes') {
            $args['meta_query'] = array(
                array(
                    'key' => '_portfolio_service_featured',
                    'value' => 'yes',
                    'compare' => '=',
                ),
            );
        }
        
        $services = new WP_Query($args);
        
        ob_start();
        
        if ($services->have_posts()) {
            $columns_class = 'portfolio-services-columns-' . intval($atts['columns']);
            echo '<div class="portfolio-services portfolio-services-' . esc_attr($atts['layout']) . ' ' . esc_attr($columns_class) . '">';
            
            while ($services->have_posts()) {
                $services->the_post();
                
                $icon = get_post_meta(get_the_ID(), '_portfolio_service_icon', true);
                $price = get_post_meta(get_the_ID(), '_portfolio_service_price', true);
                $duration = get_post_meta(get_the_ID(), '_portfolio_service_duration', true);
                $featured = get_post_meta(get_the_ID(), '_portfolio_service_featured', true);
                
                // Display the service
                $featured_class = ($featured === 'yes') ? ' service-featured' : '';
                ?>
                <div class="portfolio-service<?php echo esc_attr($featured_class); ?>">
                    <?php if ($featured === 'yes') : ?>
                        <div class="service-featured-badge"><?php _e('Featured', 'portfolio'); ?></div>
                    <?php endif; ?>
                    
                    <div class="service-header">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="service-icon">
                                <?php the_post_thumbnail('thumbnail'); ?>
                            </div>
                        <?php elseif (!empty($icon)) : ?>
                            <div class="service-icon">
                                <?php if (strpos($icon, 'dashicons') !== false) : ?>
                                    <span class="dashicons <?php echo esc_attr($icon); ?>"></span>
                                <?php else : ?>
                                    <i class="<?php echo esc_attr($icon); ?>"></i>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        
                        <h3 class="service-title"><?php the_title(); ?></h3>
                    </div>
                    
                    <div class="service-content">
                        <?php the_excerpt(); ?>
                        
                        <?php if (!empty($price) || !empty($duration)) : ?>
                            <div class="service-meta">
                                <?php if (!empty($price)) : ?>
                                    <div class="service-price">
                                        <strong><?php _e('Price:', 'portfolio'); ?></strong> <?php echo esc_html($price); ?>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($duration)) : ?>
                                    <div class="service-duration">
                                        <strong><?php _e('Duration:', 'portfolio'); ?></strong> <?php echo esc_html($duration); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="service-link">
                            <a href="<?php the_permalink(); ?>" class="button"><?php _e('Learn More', 'portfolio'); ?></a>
                        </div>
                    </div>
                </div>
                <?php
            }
            
            echo '</div>';
        } else {
            echo '<p>' . __('No services found.', 'portfolio') . '</p>';
        }
        
        wp_reset_postdata();
        
        return ob_get_clean();
    }
}

// Initialize the services class
new Portfolio_Services();
