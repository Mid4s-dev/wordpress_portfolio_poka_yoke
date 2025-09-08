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
