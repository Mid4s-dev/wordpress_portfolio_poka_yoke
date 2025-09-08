<?php
/**
 * Portfolio functions and definitions
 *
 * @package WordPress
 * @subpackage Portfolio
 * @since Portfolio 1.0
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

        // Add support for editor styles.
        add_theme_support( 'editor-styles' );

        // Add support for responsive embedded content.
        add_theme_support( 'responsive-embeds' );

        // Add support for custom units.
        add_theme_support( 'custom-units' );
        
        // Register navigation menus
        register_nav_menus(
            array(
                'primary' => esc_html__( 'Primary Menu', 'portfolio' ),
                'footer'  => esc_html__( 'Footer Menu', 'portfolio' ),
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
    
    // Enqueue theme JavaScript.
    wp_enqueue_script(
        'portfolio-main-js',
        get_theme_file_uri( 'assets/js/main.js' ),
        array(),
        filemtime(get_template_directory() . '/assets/js/main.js'),
        true
    );
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
        <<?php echo esc_attr( $tag ); ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( 'comment-body bg-gray-50 rounded-lg p-6', empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
            <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
                <footer class="comment-meta mb-4">
                    <div class="flex items-center">
                        <div class="comment-author vcard mr-4">
                            <?php
                            if ( 0 !== $args['avatar_size'] ) {
                                echo '<div class="w-12 h-12 rounded-full overflow-hidden">';
                                echo get_avatar( $comment, $args['avatar_size'] );
                                echo '</div>';
                            }
                            ?>
                        </div>

                        <div>
                            <div class="comment-author-name font-medium">
                                <?php
                                printf(
                                    '<span>%s</span>',
                                    get_comment_author_link( $comment )
                                );
                                ?>
                            </div>
                            <div class="comment-metadata text-sm text-gray-500 mt-1">
                                <?php
                                printf(
                                    '<time datetime="%1$s">%2$s</time>',
                                    esc_attr( get_comment_time( 'c' ) ),
                                    esc_html( sprintf( _x( '%1$s at %2$s', '1: date, 2: time', 'portfolio' ), get_comment_date(), get_comment_time() ) )
                                );
                                ?>
                                <?php edit_comment_link( __( 'Edit', 'portfolio' ), '<span class="edit-link ml-2">', '</span>' ); ?>
                            </div>
                        </div>
                    </div>
                    
                    <?php if ( '0' === $comment->comment_approved ) : ?>
                        <p class="comment-awaiting-moderation text-yellow-600 mt-2"><?php esc_html_e( 'Your comment is awaiting moderation.', 'portfolio' ); ?></p>
                    <?php endif; ?>
                </footer>

                <div class="comment-content prose prose-sm">
                    <?php comment_text(); ?>
                </div>

                <div class="reply mt-4">
                    <?php
                    comment_reply_link(
                        array_merge(
                            $args,
                            array(
                                'add_below' => 'div-comment',
                                'depth'     => $depth,
                                'max_depth' => $args['max_depth'],
                                'before'    => '<div class="reply-link text-sm text-primary-600 hover:underline">',
                                'after'     => '</div>',
                            )
                        )
                    );
                    ?>
                </div>
            </article>
        <?php
    }
}
