<?php
/**
 * Portfolio functions and definitions
 *
 * @package WordPress
 * @subpackage Portfolio
 * @since 1.0
 */

if ( ! function_exists( 'portfolio_setup' ) ) {
    /**
     * Sets up theme defaults and regis    // Enqueue theme JavaScript.
    wp_enqueue_script(
        'portfolio-main-js',
        get_theme_file_uri( 'assets/js/main.js' ),
        array('jquery'),
        filemtime(get_template_directory() . '/assets/js/main.js'),
        true
    );
    
    // Enqueue mobile menu fix script
    wp_enqueue_script(
        'mobile-menu-fix',
        get_theme_file_uri( 'assets/js/mobile-menu-fix.js' ),
        array('jquery', 'portfolio-main-js'),
        filemtime(get_template_directory() . '/assets/js/mobile-menu-fix.js'),
        true
    );
    
    // Disable header.js since functionality is now in main.js
    // wp_enqueue_script(
    //     'portfolio-header-js',
    //     get_theme_file_uri( 'assets/js/header.js' ),
    //     array('jquery'),
    //     filemtime(get_template_directory() . '/assets/js/header.js'),
    //     true
    // );various WordPress features.
     */
    function portfolio_setup() {
        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );

        // Let WordPress manage the document title.
        add_theme_support( 'title-tag' );

        // Enable support for Post Thumbnails on posts and pages.
        add_theme_support( 'post-thumbnails' );

        // Add support for Block Styles.
        add_theme_support( 'wp-block-styles' );

        // Add support for full and wide align images.
        add_theme_support( 'align-wide' );

        // Add support for editor styles.
        add_theme_support( 'editor-styles' );

        // Add custom editor font sizes.
        add_theme_support(
            'editor-font-sizes',
            array(
                array(
                    'name'      => __( 'Small', 'portfolio' ),
                    'shortName' => __( 'S', 'portfolio' ),
                    'size'      => 14,
                    'slug'      => 'small',
                ),
                array(
                    'name'      => __( 'Normal', 'portfolio' ),
                    'shortName' => __( 'M', 'portfolio' ),
                    'size'      => 16,
                    'slug'      => 'normal',
                ),
                array(
                    'name'      => __( 'Large', 'portfolio' ),
                    'shortName' => __( 'L', 'portfolio' ),
                    'size'      => 24,
                    'slug'      => 'large',
                ),
                array(
                    'name'      => __( 'Extra Large', 'portfolio' ),
                    'shortName' => __( 'XL', 'portfolio' ),
                    'size'      => 36,
                    'slug'      => 'extra-large',
                ),
            )
        );
        
    }
}
add_action( 'after_setup_theme', 'portfolio_setup' );

/**
 * Enqueue styles and scripts.
 */
function portfolio_enqueue_styles() {
    // Enqueue Tailwind CSS.
    wp_enqueue_style(
        'portfolio-tailwind',
        get_theme_file_uri( 'assets/css/tailwind-output.css' ),
        array(),
        filemtime(get_template_directory() . '/assets/css/tailwind-output.css')
    );
    
    // Add Google Fonts.
    wp_enqueue_style(
        'portfolio-google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap',
        array(),
        null
    );
    
    // Enqueue theme stylesheet.
    wp_enqueue_style(
        'portfolio-style',
        get_stylesheet_uri(),
        array('portfolio-tailwind', 'portfolio-google-fonts'),
        filemtime(get_template_directory() . '/style.css')
    );
    
    // Enqueue consolidated theme core styles
    if (file_exists(get_template_directory() . '/assets/css/theme-core.css')) {
        wp_enqueue_style(
            'portfolio-theme-core',
            get_theme_file_uri( 'assets/css/theme-core.css' ),
            array('portfolio-style'),
            filemtime(get_template_directory() . '/assets/css/theme-core.css')
        );
    }
    
    // Enqueue consolidated component styles (carousels, cards, etc.)
    if (file_exists(get_template_directory() . '/assets/css/components.css')) {
        wp_enqueue_style(
            'portfolio-components',
            get_theme_file_uri( 'assets/css/components.css' ),
            array('portfolio-theme-core'),
            filemtime(get_template_directory() . '/assets/css/components.css')
        );
    }
    
    // Enqueue dashicons on the frontend for social icons
    wp_enqueue_style('dashicons');
    
    // Enqueue Swiper.js CSS for carousels
    wp_enqueue_style(
        'swiper-css',
        'https://unpkg.com/swiper@8/swiper-bundle.min.css',
        array(),
        '8.0.0'
    );
    
    // Enqueue Maasai patterns styles (keeping separate as it's decorative)
    if (file_exists(get_template_directory() . '/assets/css/maasai-patterns.css')) {
        wp_enqueue_style(
            'maasai-patterns',
            get_theme_file_uri( 'assets/css/maasai-patterns.css' ),
            array('portfolio-theme-core'),
            filemtime(get_template_directory() . '/assets/css/maasai-patterns.css')
        );
    }

    // Enqueue dashicons on the frontend for social icons
    wp_enqueue_style('dashicons');
}
add_action( 'wp_enqueue_scripts', 'portfolio_enqueue_styles' );

/**
 * Enqueue scripts for the theme.
 * 
 * This function handles all JavaScript files needed on the frontend,
 * including libraries like jQuery and Swiper.js for carousels.
 */
function portfolio_enqueue_scripts() {
    // Enqueue jQuery first as a dependency
    wp_enqueue_script('jquery');
    
    // Enqueue consolidated main JavaScript
    wp_enqueue_script(
        'portfolio-main-js',
        get_theme_file_uri( 'assets/js/main.js' ),
        array('jquery'),
        filemtime(get_template_directory() . '/assets/js/main.js'),
        true
    );
    
    // Debug tools have been consolidated into main.js
    
    // Enqueue Swiper.js script for carousels
    wp_enqueue_script(
        'swiper-js',
        'https://unpkg.com/swiper@8/swiper-bundle.min.js',
        array('jquery'),
        '8.0.0',
        true
    );
    
    // Enqueue our custom carousel JavaScript
    if (file_exists(get_template_directory() . '/assets/js/carousels.js')) {
        wp_enqueue_script(
            'portfolio-carousels-js',
            get_theme_file_uri( 'assets/js/carousels.js' ),
            array('jquery', 'swiper-js'),
            filemtime(get_template_directory() . '/assets/js/carousels.js'),
            true
        );
    }
    
    // Enqueue normalize carousels script
    if (file_exists(get_template_directory() . '/assets/js/normalize-carousels.js')) {
        wp_enqueue_script(
            'normalize-carousels-js',
            get_theme_file_uri( 'assets/js/normalize-carousels.js' ),
            array('jquery', 'swiper-js', 'portfolio-carousels-js'),
            filemtime(get_template_directory() . '/assets/js/normalize-carousels.js'),
            true
        );
    }
    
    // Enqueue campaigns JavaScript
    if (file_exists(get_template_directory() . '/assets/js/campaigns.js')) {
        wp_enqueue_script(
            'portfolio-campaigns-js',
            get_theme_file_uri( 'assets/js/campaigns.js' ),
            array('jquery'),
            filemtime(get_template_directory() . '/assets/js/campaigns.js'),
            true
        );
    }
    
    // Enqueue campaigns template JavaScript on campaigns template
    if (file_exists(get_template_directory() . '/assets/js/campaigns-template.js')) {
        // Only load on the campaigns template
        if (is_page_template('templates/template-campaigns.php')) {
            wp_enqueue_script(
                'portfolio-campaigns-template',
                get_theme_file_uri( 'assets/js/campaigns-template.js' ),
                array('jquery'),
                filemtime(get_template_directory() . '/assets/js/campaigns-template.js'),
                true
            );
        }
    }
    
    // Enqueue services JavaScript
    if (file_exists(get_template_directory() . '/assets/js/services.js')) {
        wp_enqueue_script(
            'portfolio-services-js',
            get_theme_file_uri( 'assets/js/services.js' ),
            array('jquery'),
            filemtime(get_template_directory() . '/assets/js/services.js'),
            true
        );
    }
    

    
    // The forms.js file is enqueued in the Portfolio_Form_Handler class
}
add_action( 'wp_enqueue_scripts', 'portfolio_enqueue_scripts' );

/**
 * Enqueue admin scripts and styles.
 */
function portfolio_admin_scripts() {
    // Enqueue consolidated admin styles
    if (file_exists(get_template_directory() . '/assets/css/admin.css')) {
        wp_enqueue_style(
            'portfolio-admin',
            get_theme_file_uri('assets/css/admin.css'),
            array(),
            filemtime(get_template_directory() . '/assets/css/admin.css')
        );
    }
    
    // Enqueue profile customizer scripts when in the customizer
    if (is_customize_preview() && file_exists(get_template_directory() . '/assets/js/profile-customizer.js')) {
        wp_enqueue_script(
            'portfolio-profile-customizer',
            get_theme_file_uri('assets/js/profile-customizer.js'),
            array('jquery', 'customize-preview'),
            filemtime(get_template_directory() . '/assets/js/profile-customizer.js'),
            true
        );
    }
}
add_action('admin_enqueue_scripts', 'portfolio_admin_scripts');

/**
 * Register pattern categories.
 */
function portfolio_register_pattern_categories() {
    register_block_pattern_category(
        'portfolio',
        array( 'label' => __( 'Portfolio', 'portfolio' ) )
    );
    
    register_block_pattern_category(
        'portfolio-sections',
        array( 'label' => __( 'Portfolio Sections', 'portfolio' ) )
    );
}
add_action( 'init', 'portfolio_register_pattern_categories' );

/**
 * Custom comment callback function
 */
if ( ! function_exists( 'portfolio_comment_callback' ) ) {
    function portfolio_comment_callback( $comment, $args, $depth ) {
        $tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
?>
        <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $args['has_children'] ? 'parent' : '', $comment ); ?>>
            <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
                <footer class="comment-meta">
                    <div class="comment-author vcard">
                        <?php
                        if ( 0 != $args['avatar_size'] ) {
                            echo get_avatar( $comment, $args['avatar_size'], '', '', array( 'class' => 'comment-avatar' ) );
                        }
                        ?>
                        <?php
                        printf(
                            /* translators: %s: comment author link */
                            __( '%s <span class="says">says:</span>', 'portfolio' ),
                            sprintf( '<b class="fn">%s</b>', get_comment_author_link( $comment ) )
                        );
                        ?>
                    </div><!-- .comment-author -->

                    <div class="comment-metadata">
                        <a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
                            <time datetime="<?php comment_time( 'c' ); ?>">
                                <?php
                                printf(
                                    /* translators: 1: comment date, 2: comment time */
                                    __( '%1$s at %2$s', 'portfolio' ),
                                    get_comment_date( '', $comment ),
                                    get_comment_time()
                                );
                                ?>
                            </time>
                        </a>
                        <?php
                        edit_comment_link( __( 'Edit', 'portfolio' ), '<span class="edit-link">', '</span>' );
                        ?>
                    </div><!-- .comment-metadata -->

                    <?php if ( '0' == $comment->comment_approved ) : ?>
                    <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'portfolio' ); ?></p>
                    <?php endif; ?>
                </footer><!-- .comment-meta -->

                <div class="comment-content">
                    <?php comment_text(); ?>
                </div><!-- .comment-content -->

                <?php
                if ( '1' == $comment->comment_approved || $comment->comment_type === 'pingback' || $comment->comment_type === 'trackback' ) {
                    comment_reply_link( array_merge( $args, array(
                        'add_below' => 'div-comment',
                        'depth'     => $depth,
                        'max_depth' => $args['max_depth'],
                        'before'    => '<div class="reply">',
                        'after'     => '</div>'
                    ) ) );
                }
                ?>
            </article><!-- .comment-body -->
<?php
    }
}

/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
if ( ! function_exists( 'portfolio_posted_on' ) ) {
    function portfolio_posted_on() {
        // Post date/time
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf(
            $time_string,
            esc_attr( get_the_date( 'c' ) ),
            esc_html( get_the_date() ),
            esc_attr( get_the_modified_date( 'c' ) ),
            esc_html( get_the_modified_date() )
        );

        $posted_on = sprintf(
            /* translators: %s: post date. */
            esc_html_x( 'Posted on %s', 'post date', 'portfolio' ),
            '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
        );

        // Author
        $byline = sprintf(
            /* translators: %s: post author. */
            esc_html_x( 'by %s', 'post author', 'portfolio' ),
            '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
        );

        echo '<span class="posted-on">' . $posted_on . '</span> <span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
}

/**
 * Outputs content for the default featured image fallback.
 */
function portfolio_default_featured_image() {
    if ( is_singular() && ! has_post_thumbnail() && ! is_attachment() ) {
        return get_template_directory_uri() . '/assets/images/about-me.jpg';
    }
}
add_filter( 'post_thumbnail_html', 'portfolio_default_featured_image' );

// Include simple mailer class
require_once get_template_directory() . '/inc/simple-mailer.php';

// Include form handler class
require_once get_template_directory() . '/inc/form-handler.php';

// Include campaigns functionality
require_once get_template_directory() . '/inc/campaigns.php';

// Include widgets
require_once get_template_directory() . '/inc/widgets/recent-campaigns-widget.php';

// Include campaigns dashboard page
require_once get_template_directory() . '/inc/campaigns-dashboard.php';

// Include quick social posts functionality
require_once get_template_directory() . '/inc/quick-social-posts.php';

// Include services functionality 
require_once get_template_directory() . '/inc/services.php';

// Include services widget
require_once get_template_directory() . '/inc/widgets/services-widget.php';

// Include simple testimonials functionality
require_once get_template_directory() . '/inc/simple-testimonials.php';

// Include Gmail API integration
require_once get_template_directory() . '/inc/gmail-api.php';

// Include profile image functionality
require_once get_template_directory() . '/inc/profile-image.php';

// Manually flush rewrite rules on theme init to fix potential permalink issues
function portfolio_manual_flush_rewrite_rules() {
    if (get_option('portfolio_flush_rewrite_rules_flag')) {
        flush_rewrite_rules();
        delete_option('portfolio_flush_rewrite_rules_flag');
    }
}
add_action('init', 'portfolio_manual_flush_rewrite_rules', 99); // Run after post type registration

// Set the flag to flush rewrite rules
update_option('portfolio_flush_rewrite_rules_flag', true);

/**
 * Setup theme with default content
 * This function runs during theme activation to set up default content for the portfolio
 */
function portfolio_setup_theme_defaults() {
    // Create sample services
    portfolio_create_sample_services();
    
    // Create sample testimonials
    portfolio_create_sample_testimonials();
    
    // Flush rewrite rules
    flush_rewrite_rules();
}

/**
 * Generate sample testimonials if none exist
 */
function portfolio_create_sample_testimonials() {
    $existing_testimonials = get_posts(array(
        'post_type' => 'simple_testimonial',
        'posts_per_page' => 1,
    ));
    
    // Only generate sample testimonials if none exist
    if (empty($existing_testimonials)) {
        $sample_testimonials = array(
            array(
                'title' => 'Excellent PR Strategy',
                'content' => 'Working with this PR professional has been an absolute pleasure. They delivered our campaign ahead of schedule and exceeded all our expectations. Their attention to detail and creative solutions made our project stand out.',
                'client_name' => 'Sarah Johnson',
                'client_position' => 'Marketing Director',
                'client_company' => 'TechVision Inc.',
                'rating' => 5
            ),
            array(
                'title' => 'Outstanding Media Relations',
                'content' => 'The media coverage we received thanks to their PR strategy was phenomenal. Their network of contacts and ability to craft compelling stories resulted in features in publications we had been targeting for years.',
                'client_name' => 'Michael Chen',
                'client_position' => 'CEO',
                'client_company' => 'InnovateTech',
                'rating' => 5
            ),
            array(
                'title' => 'Reliable Crisis Management',
                'content' => 'When our company faced a potential PR crisis, their quick thinking and strategic communication plan helped us navigate through it with minimal impact. Their guidance was invaluable during a challenging time for our organization.',
                'client_name' => 'Lisa Omondi',
                'client_position' => 'Product Manager',
                'client_company' => 'Savannah Solutions',
                'rating' => 5
            ),
        );
        
        foreach ($sample_testimonials as $testimonial) {
            $post_id = wp_insert_post(array(
                'post_title' => $testimonial['title'],
                'post_content' => $testimonial['content'],
                'post_type' => 'simple_testimonial',
                'post_status' => 'publish',
            ));
            
            if ($post_id) {
                // Add testimonial meta
                update_post_meta($post_id, '_simple_testimonial_client_name', $testimonial['client_name']);
                update_post_meta($post_id, '_simple_testimonial_client_position', $testimonial['client_position']);
                update_post_meta($post_id, '_simple_testimonial_client_company', $testimonial['client_company']);
                update_post_meta($post_id, '_simple_testimonial_rating', $testimonial['rating']);
            }
        }
    }
}



/**
 * Generate sample services if none exist
 */
function portfolio_create_sample_services() {
    $existing_services = get_posts(array(
        'post_type' => 'portfolio_service',
        'posts_per_page' => 1,
    ));
    
    // Only generate sample services if none exist
    if (empty($existing_services)) {
        $sample_services = array(
            array(
                'title' => 'Web Development',
                'content' => 'Custom web development using the latest technologies. We build responsive, user-friendly websites that help your business grow online.',
                'excerpt' => 'Professional web development services tailored to your business needs.',
                'icon' => 'dashicons-admin-site-alt3',
                'price' => 'Starting at $1,500',
                'duration' => '3-6 weeks',
                'featured' => 'yes'
            ),
            array(
                'title' => 'Mobile App Development',
                'content' => 'Native and cross-platform mobile applications for iOS and Android. Our apps combine beautiful design with powerful functionality.',
                'excerpt' => 'Transform your idea into a polished mobile application.',
                'icon' => 'dashicons-smartphone',
                'price' => 'Starting at $3,000',
                'duration' => '2-4 months',
                'featured' => 'no'
            ),
            array(
                'title' => 'UI/UX Design',
                'content' => 'User-centered design approach that focuses on creating intuitive and engaging digital experiences that keep your users coming back.',
                'excerpt' => 'Create beautiful, intuitive interfaces that users love.',
                'icon' => 'dashicons-art',
                'price' => 'Starting at $800',
                'duration' => '2-3 weeks',
                'featured' => 'no'
            ),
            array(
                'title' => 'E-commerce Solutions',
                'content' => 'Complete e-commerce website development with payment integration, product management, and everything you need to sell online.',
                'excerpt' => 'Turn your products into online sales with a custom e-commerce solution.',
                'icon' => 'dashicons-cart',
                'price' => 'Starting at $2,500',
                'duration' => '4-8 weeks',
                'featured' => 'yes'
            ),
        );
        
        foreach ($sample_services as $service) {
            $post_id = wp_insert_post(array(
                'post_title' => $service['title'],
                'post_content' => $service['content'],
                'post_excerpt' => $service['excerpt'],
                'post_type' => 'portfolio_service',
                'post_status' => 'publish',
            ));
            
            if ($post_id) {
                // Add service meta
                update_post_meta($post_id, '_portfolio_service_icon', $service['icon']);
                update_post_meta($post_id, '_portfolio_service_price', $service['price']);
                update_post_meta($post_id, '_portfolio_service_duration', $service['duration']);
                update_post_meta($post_id, '_portfolio_service_featured', $service['featured']);
            }
        }
    }
}
add_action('after_switch_theme', 'portfolio_setup_theme_defaults');

/**
 * Get the campaigns page URL (preferring custom template page over archive)
 */
function portfolio_get_campaigns_page_url() {
    // First check if a page using the campaigns template exists
    $pages = get_pages(array(
        'meta_key' => '_wp_page_template',
        'meta_value' => 'templates/template-campaigns.php',
        'number' => 1,
    ));

    if (!empty($pages)) {
        return get_permalink($pages[0]->ID);
    }

    // Fall back to archive if no template page exists
    return get_post_type_archive_link('portfolio_campaign');
}

/**
 * Get the portfolio owner name (theme mod) with fallback
 */
function portfolio_get_owner_name() {
    $name = get_theme_mod( 'portfolio_owner_name', 'Joshua Lugaya' );
    return esc_html( $name );
}

/**
 * Get the portfolio about image URL prioritizing theme mod with fallback to default image
 */
function portfolio_get_about_image() {
    // Use theme mod first (from Customizer)
    $image_url = get_theme_mod('portfolio_about_image');
    if (!empty($image_url)) {
        return $image_url;
    }
    
    // Fall back to featured image if available
    $front_page_id = get_option('page_on_front');
    if ($front_page_id && has_post_thumbnail($front_page_id)) {
        // Get the featured image URL
        $thumbnail_id = get_post_thumbnail_id($front_page_id);
        $featured_image_url = wp_get_attachment_image_url($thumbnail_id, 'large');
        if ($featured_image_url) {
            return $featured_image_url;
        }
    }
    
    // Return the default image path if no custom image is set
    return get_template_directory_uri() . '/assets/images/about-me.jpg';
}

/**
 * Get the portfolio skills section image URL from theme mod with fallback
 */
function portfolio_get_skills_image() {
    $image_url = get_theme_mod('portfolio_skills_image');
    if (!empty($image_url)) {
        return $image_url;
    }
    
    // Return the default image path if no custom image is set
    return get_template_directory_uri() . '/assets/images/skills.jpg';
}

/**
 * Get the portfolio services background image URL from theme mod with fallback
 */
function portfolio_get_services_bg() {
    $image_url = get_theme_mod('portfolio_services_bg');
    if (!empty($image_url)) {
        return $image_url;
    }
    
    // Return the default image path if no custom image is set
    return get_template_directory_uri() . '/assets/images/services-bg.jpg';
}

/**
 * Get the portfolio contact section image URL from theme mod with fallback
 */
function portfolio_get_contact_image() {
    $image_url = get_theme_mod('portfolio_contact_image');
    if (!empty($image_url)) {
        return $image_url;
    }
    
    // Return the default image path if no custom image is set
    return get_template_directory_uri() . '/assets/images/contact.jpg';
}

// Register custom homepage template
function portfolio_add_homepage_template($templates) {
    $templates['templates/template-home.php'] = 'Portfolio Home';
    $templates['templates/template-campaigns.php'] = 'Campaigns & Projects Showcase';
    $templates['templates/template-joshua-portfolio.php'] = 'Joshua Lugaya Portfolio';
    $templates['templates/template-services.php'] = 'Services';
    return $templates;
}
add_filter('theme_page_templates', 'portfolio_add_homepage_template');

/**
 * Display an admin notice on the front page edit screen to set featured image
 */
function portfolio_admin_featured_image_notice() {
    $screen = get_current_screen();
    if ($screen->id !== 'page') return;
    
    if (isset($_GET['post']) && $_GET['post'] == get_option('page_on_front')) {
        $message = '<p><strong>Featured Image:</strong> Setting a featured image for this page will display it in the About section on your homepage. You can also manage this and other site images in the WordPress Customizer under "Front Page Images".</p>';
        echo '<div class="notice notice-info">' . $message . '</div>';
    }
}
add_action('admin_notices', 'portfolio_admin_featured_image_notice');

/**
 * Add a link in the admin bar for quick access to theme images customization
 */
function portfolio_admin_bar_link($admin_bar) {
    if (!current_user_can('edit_theme_options')) {
        return;
    }
    
    $admin_bar->add_node(array(
        'id'    => 'portfolio-theme-images',
        'title' => 'Theme Images',
        'href'  => admin_url('customize.php?autofocus[section]=portfolio_frontpage_images'),
        'meta'  => array(
            'title' => __('Edit Theme Images', 'portfolio'),
        ),
    ));
}
add_action('admin_bar_menu', 'portfolio_admin_bar_link', 100);

/**
 * Add Customizer options for front page images
 */
function portfolio_customize_register($wp_customize) {
    // Add Front Page Images section
    $wp_customize->add_section('portfolio_frontpage_images', array(
        'title'       => __('Front Page Images', 'portfolio'),
        'description' => __('Upload and manage images for your front page sections.', 'portfolio'),
        'priority'    => 30,
    ));
    
    // About Section Image
    $wp_customize->add_setting('portfolio_about_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'portfolio_about_image_control', array(
        'label'       => __('About Section Image', 'portfolio'),
        'description' => __('Upload an image for the About section. Recommended size: 600x800px.', 'portfolio'),
        'section'     => 'portfolio_frontpage_images',
        'settings'    => 'portfolio_about_image',
        'priority'    => 10,
    )));
    
    // Skills Section Image
    $wp_customize->add_setting('portfolio_skills_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'portfolio_skills_image_control', array(
        'label'       => __('Skills Section Image', 'portfolio'),
        'description' => __('Upload an image for the Skills section.', 'portfolio'),
        'section'     => 'portfolio_frontpage_images',
        'settings'    => 'portfolio_skills_image',
        'priority'    => 20,
    )));
    
    // Services Section Background
    $wp_customize->add_setting('portfolio_services_bg', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'portfolio_services_bg_control', array(
        'label'       => __('Services Background Image', 'portfolio'),
        'description' => __('Upload a background image for the Services section.', 'portfolio'),
        'section'     => 'portfolio_frontpage_images',
        'settings'    => 'portfolio_services_bg',
        'priority'    => 30,
    )));
    
    // Contact Section Image
    $wp_customize->add_setting('portfolio_contact_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'portfolio_contact_image_control', array(
        'label'       => __('Contact Section Image', 'portfolio'),
        'description' => __('Upload an image for the Contact section.', 'portfolio'),
        'section'     => 'portfolio_frontpage_images',
        'settings'    => 'portfolio_contact_image',
        'priority'    => 40,
    )));
}
add_action('customize_register', 'portfolio_customize_register');
