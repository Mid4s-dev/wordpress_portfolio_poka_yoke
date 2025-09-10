<?php
/**
 * Simple Testimonials Feature
 * 
 * A clean, minimalist implementation of testimonials for the portfolio theme.
 */

// Register Testimonial Post Type
function simple_testimonials_register_post_type() {
    $labels = array(
        'name'               => 'Testimonials',
        'singular_name'      => 'Testimonial',
        'menu_name'          => 'Testimonials',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Testimonial',
        'edit_item'          => 'Edit Testimonial',
        'new_item'           => 'New Testimonial',
        'view_item'          => 'View Testimonial',
        'search_items'       => 'Search Testimonials',
        'not_found'          => 'No testimonials found',
        'not_found_in_trash' => 'No testimonials found in Trash',
        'featured_image'     => 'Client Image',
        'set_featured_image' => 'Set client image',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'simple-testimonials'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 20,
        'menu_icon'          => 'dashicons-format-quote',
        'supports'           => array('title', 'editor', 'thumbnail'),
        'show_in_rest'       => true,
    );

    register_post_type('simple_testimonial', $args);
}
add_action('init', 'simple_testimonials_register_post_type');

// Add meta box for testimonial details
function simple_testimonials_add_meta_boxes() {
    add_meta_box(
        'simple_testimonial_details',
        'Client Details',
        'simple_testimonials_render_meta_box',
        'simple_testimonial',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'simple_testimonials_add_meta_boxes');

// Render the meta box
function simple_testimonials_render_meta_box($post) {
    // Add nonce for security
    wp_nonce_field('simple_testimonial_save_meta', 'simple_testimonial_nonce');

    // Get current values
    $client_name = get_post_meta($post->ID, '_simple_testimonial_client_name', true);
    $client_position = get_post_meta($post->ID, '_simple_testimonial_client_position', true);
    $client_company = get_post_meta($post->ID, '_simple_testimonial_client_company', true);
    $rating = get_post_meta($post->ID, '_simple_testimonial_rating', true);
    ?>
    <style>
        .testimonial-meta-field {
            margin-bottom: 15px;
        }
        .testimonial-meta-field label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .testimonial-meta-field input[type="text"] {
            width: 100%;
        }
        .rating-selector {
            display: flex;
            align-items: center;
        }
        .rating-selector label {
            margin-right: 10px;
        }
    </style>

    <div class="testimonial-meta-field">
        <label for="simple_testimonial_client_name">Client Name:</label>
        <input type="text" id="simple_testimonial_client_name" name="simple_testimonial_client_name" 
               value="<?php echo esc_attr($client_name); ?>" placeholder="Enter client name">
    </div>

    <div class="testimonial-meta-field">
        <label for="simple_testimonial_client_position">Position/Title:</label>
        <input type="text" id="simple_testimonial_client_position" name="simple_testimonial_client_position" 
               value="<?php echo esc_attr($client_position); ?>" placeholder="Enter client position/title">
    </div>

    <div class="testimonial-meta-field">
        <label for="simple_testimonial_client_company">Company:</label>
        <input type="text" id="simple_testimonial_client_company" name="simple_testimonial_client_company" 
               value="<?php echo esc_attr($client_company); ?>" placeholder="Enter client company">
    </div>

    <div class="testimonial-meta-field">
        <div class="rating-selector">
            <label for="simple_testimonial_rating">Rating (1-5):</label>
            <select id="simple_testimonial_rating" name="simple_testimonial_rating">
                <option value="">Select a rating</option>
                <?php for ($i = 1; $i <= 5; $i++) : ?>
                    <option value="<?php echo $i; ?>" <?php selected($rating, $i); ?>><?php echo $i; ?> Star<?php echo $i > 1 ? 's' : ''; ?></option>
                <?php endfor; ?>
            </select>
        </div>
    </div>

    <p class="description">
        <strong>Note:</strong> The testimonial content should be added in the main editor above. 
        The featured image will be used as the client's photo.
    </p>
    <?php
}

// Save the meta box data
function simple_testimonials_save_meta($post_id) {
    // Check if nonce is set
    if (!isset($_POST['simple_testimonial_nonce'])) {
        return;
    }

    // Verify the nonce
    if (!wp_verify_nonce($_POST['simple_testimonial_nonce'], 'simple_testimonial_save_meta')) {
        return;
    }

    // Check if this is an autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check user permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save client name
    if (isset($_POST['simple_testimonial_client_name'])) {
        update_post_meta(
            $post_id,
            '_simple_testimonial_client_name',
            sanitize_text_field($_POST['simple_testimonial_client_name'])
        );
    }

    // Save client position
    if (isset($_POST['simple_testimonial_client_position'])) {
        update_post_meta(
            $post_id,
            '_simple_testimonial_client_position',
            sanitize_text_field($_POST['simple_testimonial_client_position'])
        );
    }

    // Save client company
    if (isset($_POST['simple_testimonial_client_company'])) {
        update_post_meta(
            $post_id,
            '_simple_testimonial_client_company',
            sanitize_text_field($_POST['simple_testimonial_client_company'])
        );
    }

    // Save rating
    if (isset($_POST['simple_testimonial_rating'])) {
        update_post_meta(
            $post_id,
            '_simple_testimonial_rating',
            sanitize_text_field($_POST['simple_testimonial_rating'])
        );
    }
}
add_action('save_post_simple_testimonial', 'simple_testimonials_save_meta');

// Add custom columns to the testimonials list
function simple_testimonials_columns($columns) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = $columns['title'];
    $new_columns['client_image'] = 'Client Image';
    $new_columns['client_details'] = 'Client Details';
    $new_columns['rating'] = 'Rating';
    $new_columns['date'] = $columns['date'];
    return $new_columns;
}
add_filter('manage_simple_testimonial_posts_columns', 'simple_testimonials_columns');

// Display the custom column content
function simple_testimonials_column_content($column, $post_id) {
    switch ($column) {
        case 'client_image':
            if (has_post_thumbnail($post_id)) {
                echo get_the_post_thumbnail($post_id, array(50, 50));
            } else {
                echo '—';
            }
            break;
        case 'client_details':
            $client_name = get_post_meta($post_id, '_simple_testimonial_client_name', true);
            $client_position = get_post_meta($post_id, '_simple_testimonial_client_position', true);
            $client_company = get_post_meta($post_id, '_simple_testimonial_client_company', true);
            
            if (!empty($client_name)) {
                echo '<strong>' . esc_html($client_name) . '</strong><br>';
            }
            if (!empty($client_position) || !empty($client_company)) {
                echo '<small>';
                echo !empty($client_position) ? esc_html($client_position) : '';
                echo !empty($client_position) && !empty($client_company) ? ', ' : '';
                echo !empty($client_company) ? esc_html($client_company) : '';
                echo '</small>';
            }
            break;
        case 'rating':
            $rating = get_post_meta($post_id, '_simple_testimonial_rating', true);
            if (!empty($rating)) {
                echo str_repeat('★', $rating) . str_repeat('☆', 5 - $rating);
            } else {
                echo '—';
            }
            break;
    }
}
add_action('manage_simple_testimonial_posts_custom_column', 'simple_testimonials_column_content', 10, 2);

// Add a shortcode to display testimonials
function simple_testimonials_shortcode($atts) {
    $atts = shortcode_atts(
        array(
            'count'      => 3,
            'orderby'    => 'date',
            'order'      => 'DESC',
            'layout'     => 'grid', // grid or slider
            'columns'    => 3,      // for grid layout
            'title'      => 'What Our Clients Say',
            'subtitle'   => 'See what clients are saying about our work and the results we\'ve achieved together.',
            'show_title' => 'yes',  // yes or no
        ),
        $atts,
        'simple_testimonials'
    );

    // Query testimonials
    $args = array(
        'post_type'      => 'simple_testimonial',
        'posts_per_page' => intval($atts['count']),
        'orderby'        => $atts['orderby'],
        'order'          => $atts['order'],
        'post_status'    => 'publish',
    );

    $testimonials = new WP_Query($args);

    // Start output buffer
    ob_start();

    echo '<section class="simple-testimonials-section py-16">';
    echo '<div class="container mx-auto px-4">';

    // Show section title if enabled
    if ($atts['show_title'] === 'yes') {
        echo '<div class="simple-testimonials-heading">';
        echo '<h2>' . esc_html($atts['title']) . '</h2>';
        if (!empty($atts['subtitle'])) {
            echo '<p>' . esc_html($atts['subtitle']) . '</p>';
        }
        echo '</div>';
    }

    if ($testimonials->have_posts()) {
        // Wrapper class based on layout
        $wrapper_class = $atts['layout'] === 'slider' ? 'testimonials-slider' : 'testimonials-grid';

        echo '<div class="simple-testimonials ' . esc_attr($wrapper_class) . '">';

        while ($testimonials->have_posts()) {
            $testimonials->the_post();
            
            // Get testimonial meta
            $client_name = get_post_meta(get_the_ID(), '_simple_testimonial_client_name', true);
            $client_position = get_post_meta(get_the_ID(), '_simple_testimonial_client_position', true);
            $client_company = get_post_meta(get_the_ID(), '_simple_testimonial_client_company', true);
            $rating = get_post_meta(get_the_ID(), '_simple_testimonial_rating', true);

            // Fallbacks
            $client_name = !empty($client_name) ? $client_name : get_the_title();
            ?>
            <div class="testimonial-item">
                <div class="testimonial-content">
                    <blockquote>
                        <?php the_content(); ?>
                    </blockquote>
                </div>
                
                <div class="testimonial-meta">
                    <div class="client-info">
                        <div class="client-image">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('thumbnail'); ?>
                            <?php else : ?>
                                <span><?php echo substr($client_name, 0, 1); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="client-details">
                            <h4><?php echo esc_html($client_name); ?></h4>
                            <?php if (!empty($client_position)) : ?>
                                <span class="client-position"><?php echo esc_html($client_position); ?></span>
                            <?php endif; ?>
                            <?php if (!empty($client_company)) : ?>
                                <span class="client-company"><?php echo esc_html($client_company); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <?php if (!empty($rating)) : ?>
                        <div class="testimonial-rating">
                            <?php for ($i = 1; $i <= 5; $i++) : ?>
                                <?php if ($i <= $rating) : ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                                    </svg>
                                <?php else : ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php
        }
        
        echo '</div>'; // Close testimonials wrapper
        
        wp_reset_postdata();
    } else {
        echo '<p class="text-center py-8">No testimonials found. Add some testimonials to showcase client feedback.</p>';
    }
    
    echo '</div>'; // Close container
    echo '</section>'; // Close section

    // Get the buffer content and return
    return ob_get_clean();
}
add_shortcode('simple_testimonials', 'simple_testimonials_shortcode');

// Enqueue styles
function simple_testimonials_enqueue_styles() {
    wp_enqueue_style(
        'simple-testimonials-style',
        get_template_directory_uri() . '/assets/css/simple-testimonials.css',
        array(),
        filemtime(get_template_directory() . '/assets/css/simple-testimonials.css')
    );
}
add_action('wp_enqueue_scripts', 'simple_testimonials_enqueue_styles');
