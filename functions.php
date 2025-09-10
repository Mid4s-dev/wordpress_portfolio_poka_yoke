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
     * Sets up theme defaults and registers support for various WordPress features.
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
    
    // Enqueue custom logo styles
    if (file_exists(get_template_directory() . '/assets/css/custom-logo.css')) {
        wp_enqueue_style(
            'portfolio-custom-logo',
            get_theme_file_uri( 'assets/css/custom-logo.css' ),
            array(),
            filemtime(get_template_directory() . '/assets/css/custom-logo.css')
        );
    }
    
    // Enqueue campaigns styles
    if (file_exists(get_template_directory() . '/assets/css/campaigns.css')) {
        wp_enqueue_style(
            'portfolio-campaigns',
            get_theme_file_uri( 'assets/css/campaigns.css' ),
            array(),
            filemtime(get_template_directory() . '/assets/css/campaigns.css')
        );
    }
    

    
    // Enqueue services styles
    if (file_exists(get_template_directory() . '/assets/css/services.css')) {
        wp_enqueue_style(
            'portfolio-services',
            get_theme_file_uri( 'assets/css/services.css' ),
            array(),
            filemtime(get_template_directory() . '/assets/css/services.css')
        );
    }
    
    // Enqueue dashicons on the frontend for social icons
    wp_enqueue_style('dashicons');
    
    // Enqueue theme stylesheet.
    wp_enqueue_style(
        'portfolio-style',
        get_stylesheet_uri(),
        array('portfolio-tailwind', 'portfolio-google-fonts'),
        filemtime(get_template_directory() . '/style.css')
    );
    
    // Enqueue Joshua's portfolio custom styles if the file exists
    if (file_exists(get_template_directory() . '/assets/css/joshua-portfolio.css')) {
        wp_enqueue_style(
            'joshua-portfolio',
            get_theme_file_uri( 'assets/css/joshua-portfolio.css' ),
            array('portfolio-style'),
            filemtime(get_template_directory() . '/assets/css/joshua-portfolio.css')
        );
    }
    
    // Enqueue Maasai Shuka theme CSS
    if (file_exists(get_template_directory() . '/assets/css/maasai-theme.css')) {
        wp_enqueue_style(
            'maasai-theme',
            get_theme_file_uri( 'assets/css/maasai-theme.css' ),
            array('portfolio-style', 'joshua-portfolio'),
            filemtime(get_template_directory() . '/assets/css/maasai-theme.css')
        );
    }
    
    // Enqueue jQuery
    wp_enqueue_script('jquery');
    
    // Enqueue theme JavaScript.
    wp_enqueue_script(
        'portfolio-main-js',
        get_theme_file_uri( 'assets/js/main.js' ),
        array('jquery'),
        filemtime(get_template_directory() . '/assets/js/main.js'),
        true
    );
    
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
add_action( 'wp_enqueue_scripts', 'portfolio_enqueue_styles' );

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


// Include Gmail API integration
require_once get_template_directory() . '/inc/gmail-api.php';

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
    
    // Flush rewrite rules
    flush_rewrite_rules();
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
 * Get the portfolio about image URL (theme mod) with fallback to default image
 */
function portfolio_get_about_image() {
    $image_url = get_theme_mod( 'portfolio_about_image' );
    if ( empty( $image_url ) ) {
        // Return the default image path if no custom image is set
        return get_template_directory_uri() . '/assets/images/about-me.jpg';
    }
    return $image_url;
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
