<?php
// Include helper functions and settings pages
require_once get_template_directory() . '/inc/dynamic-text.php';
require_once get_template_directory() . '/inc/seo-settings.php';
require_once get_template_directory() . '/inc/portfolio-post-type.php';
// Temporarily disable portfolio image manager to prevent memory issues
// require_once get_template_directory() . '/inc/portfolio-image-manager.php';

// Minimal theme setup
add_action('after_setup_theme', function(){
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    register_nav_menus(['primary' => 'Primary Menu']);
    
    // Add custom image sizes for portfolio
    add_image_size('portfolio-thumbnail', 600, 400, true);
    add_image_size('portfolio-large', 1200, 800, true);
    add_image_size('blog-featured', 900, 500, true);
    
    // Add theme support for custom logo
    add_theme_support('custom-logo', [
        'height'      => 100,
        'width'       => 350,
        'flex-height' => true,
        'flex-width'  => true,
    ]);
});

// Enqueue Tailwind CDN and custom scripts
add_action('wp_enqueue_scripts', function(){
    // Google Fonts
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400;500;600&display=swap', [], null);
    
    // Tailwind CSS - Fixed CDN URL
    wp_enqueue_style('evelyn-tailwind', 'https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css', [], '2.2.19');
    
    // Additional plugins for enhanced UI
    wp_enqueue_style('tailwind-typography', 'https://unpkg.com/@tailwindcss/typography@0.4.1/dist/typography.min.css', ['evelyn-tailwind'], '0.4.1');
    
    // Fallback Tailwind styles (in case the CDN fails)
    wp_enqueue_style('evelyn-tailwind-fallback', get_template_directory_uri() . '/tailwind-output.css', ['evelyn-tailwind'], time());
    
    // Portfolio styles
    wp_enqueue_style('evelyn-portfolio-style', get_template_directory_uri() . '/assets/css/portfolio.css', [], time());
    
    // Add portfolio lightbox CSS inline to avoid file loading issues
    wp_register_style('evelyn-portfolio-lightbox', false);
    wp_enqueue_style('evelyn-portfolio-lightbox');
    wp_add_inline_style('evelyn-portfolio-lightbox', '
    /* Portfolio Lightbox Styles */
    .portfolio-lightbox {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.95);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .portfolio-lightbox-content {
        position: relative;
        max-width: 90%;
        max-height: 90%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .portfolio-lightbox-image {
        max-width: 100%;
        max-height: 90vh;
        object-fit: contain;
    }

    .portfolio-lightbox-close {
        position: fixed;
        top: 15px;
        right: 15px;
        background: rgba(0, 0, 0, 0.4);
        color: white;
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        font-size: 24px;
        line-height: 40px;
        text-align: center;
        cursor: pointer;
        z-index: 10000;
        padding: 0;
    }

    .portfolio-lightbox-nav {
        position: fixed;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0, 0, 0, 0.4);
        color: white;
        border: none;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        font-size: 32px;
        line-height: 50px;
        text-align: center;
        cursor: pointer;
        z-index: 10000;
        padding: 0;
    }

    .portfolio-lightbox-prev {
        left: 15px;
    }

    .portfolio-lightbox-next {
        right: 15px;
    }

    .portfolio-lightbox-counter {
        position: fixed;
        bottom: 15px;
        left: 0;
        right: 0;
        text-align: center;
        color: white;
        font-size: 14px;
        z-index: 10000;
    }

    /* Style for when lightbox is open */
    body.lightbox-open {
        overflow: hidden;
    }

    /* Button hover effects */
    .portfolio-lightbox-close:hover,
    .portfolio-lightbox-nav:hover {
        background: rgba(255, 255, 255, 0.2);
    }
    ');
    
    // Custom styles - Make sure this comes AFTER Tailwind to override styles
    wp_enqueue_style('evelyn-style', get_stylesheet_uri(), ['evelyn-tailwind', 'tailwind-typography', 'evelyn-tailwind-fallback', 'evelyn-portfolio-style'], time()); // Using time() for development to prevent caching
    
    // Add inline styles to fix Tailwind's opacity classes and add missing utility classes
    $custom_css = "
        /* Background opacity fixes */
        .bg-white\/95, .bg-white\\/95 {
            background-color: rgba(255, 255, 255, 0.95);
        }
        .bg-black\/80, .bg-black\\/80 {
            background-color: rgba(0, 0, 0, 0.8);
        }
        .backdrop-blur-md {
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        
        /* Additional utility classes */
        .bg-blue-600 { background-color: #2563eb; }
        .hover\:bg-blue-700:hover { background-color: #1d4ed8; }
        .hover\:text-blue-600:hover { color: #2563eb; }
        .hover\:text-blue-300:hover { color: #93c5fd; }
        .hover\:scale-105:hover { transform: scale(1.05); }
        
        /* Transitions and Animations */
        .transition-all { transition-property: all; }
        .duration-300 { transition-duration: 300ms; }
        .ease-in-out { transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); }
        
        /* Transform */
        .translate-y-0 { transform: translateY(0); }
        .translate-y-10 { transform: translateY(2.5rem); }
        .group-hover\:w-full:hover { width: 100%; }
        
        /* Border */
        .border-t { border-top-width: 1px; }
        .border-blue-600 { border-color: #2563eb; }
    ";
    wp_add_inline_style('evelyn-style', $custom_css);
    
    // Register empty script handles with bare minimum 
    wp_register_script('evelyn-portfolio-js', '', [], '1.0.0', true);
    wp_register_script('evelyn-portfolio-lightbox', '', [], '1.0.0', true);
    
    // Minimal inline scripts only - main.js is temporarily disabled to reduce memory usage
    wp_add_inline_script('evelyn-portfolio-js', '
    // Minimal JS needed for basic functionality
    jQuery(document).ready(function($) {
        // Basic portfolio filtering without animations
        $(".filter-button").on("click", function() {
            var category = $(this).data("category");
            $(".filter-button").removeClass("active");
            $(this).addClass("active");
            
            if (category === "all") {
                $(".portfolio-item").show();
            } else {
                $(".portfolio-item").hide();
                $(".portfolio-item.category-" + category).show();
            }
        });
    });
    ');
    
    // Add ultra-minimal portfolio lightbox code
    wp_add_inline_script('evelyn-portfolio-lightbox', '
    document.addEventListener("DOMContentLoaded", function() {
        // Simple link click handler that opens images in new tab instead of lightbox
        const galleryLinks = document.querySelectorAll(".portfolio-gallery-item, [data-fancybox]");
        
        if (galleryLinks.length > 0) {
            galleryLinks.forEach(function(link) {
                link.addEventListener("click", function(e) {
                    // Get image URL
                    const imageUrl = link.getAttribute("href") || link.getAttribute("src");
                    if (imageUrl) {
                        e.preventDefault();
                        window.open(imageUrl, "_blank");
                    }
                });
            });
        }
    });
    ');
});

// Add theme customizer settings for better admin control
add_action('customize_register', function($wp_customize) {
    // Add section for portfolio settings
    $wp_customize->add_section('evelyn_portfolio_settings', array(
        'title' => 'Portfolio Settings',
        'description' => 'Customize your portfolio appearance and features',
        'priority' => 30,
    ));
    
    // Add setting for About Image
    $wp_customize->add_setting('evelyn_about_image', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'evelyn_about_image', array(
        'label' => 'About Section Image',
        'description' => 'Upload an image to be displayed in the About section',
        'section' => 'evelyn_portfolio_settings',
        'settings' => 'evelyn_about_image',
    )));
    
    // Add setting for Contact Image
    $wp_customize->add_setting('evelyn_contact_image', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'evelyn_contact_image', array(
        'label' => 'Contact Section Image',
        'description' => 'Upload an image to be displayed in the Contact section',
        'section' => 'evelyn_portfolio_settings',
        'settings' => 'evelyn_contact_image',
    )));
    
    // Add color settings for theme customization
    $wp_customize->add_setting('evelyn_primary_color', array(
        'default' => '#3B82F6', // blue-600
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'evelyn_primary_color', array(
        'label' => 'Primary Color',
        'description' => 'Choose the primary color for buttons and accents',
        'section' => 'evelyn_portfolio_settings',
        'settings' => 'evelyn_primary_color',
    )));
    
    // Add setting for enabling/disabling portfolio features
    $wp_customize->add_setting('evelyn_enable_hidden_section', array(
        'default' => true,
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('evelyn_enable_hidden_section', array(
        'label' => 'Enable Hidden Photography Section',
        'description' => 'Show the section for private/password-protected portfolio items',
        'section' => 'evelyn_portfolio_settings',
        'settings' => 'evelyn_enable_hidden_section',
        'type' => 'checkbox',
    ));
});

// Add drag and drop image placeholders to the editor
add_action('admin_head', function() {
    if (get_post_type() === 'portfolio' || get_post_type() === 'post') {
        ?>
        <style>
        /* Better placeholders for images in the editor */
        .block-editor-block-list__layout .wp-block-image.is-selected {
            position: relative;
        }
        
        .block-editor-block-list__layout .wp-block-image.is-selected:before {
            content: "Click or drag image here";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(59, 130, 246, 0.1);
            border: 2px dashed #3B82F6;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #3B82F6;
            font-weight: bold;
            z-index: 1;
            pointer-events: none;
        }
        
        .portfolio-hero:not(:has(img)),
        .portfolio-slot:not(:has(img)) {
            position: relative;
            min-height: 200px;
            background: rgba(59, 130, 246, 0.05);
            border: 2px dashed #3B82F6;
            border-radius: 8px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .portfolio-hero:not(:has(img)):before {
            content: "Drop hero image here or click to upload";
            color: #3B82F6;
            font-weight: bold;
        }
        
        .portfolio-slot:not(:has(img)):before {
            content: "Drop image here or click to upload";
            color: #3B82F6;
            font-weight: bold;
        }
        </style>
        <?php
    }
});

// Allow editor styles to match front-end
add_action('after_setup_theme', function(){
    add_theme_support('editor-styles');
    add_editor_style('https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css');
    add_editor_style('https://unpkg.com/@tailwindcss/typography@0.4.1/dist/typography.min.css');
    
    // Add custom editor styles
    add_editor_style('style.css');
});

// Render owner profile with job title and company
function evelyn_owner_profile_html() {
    $owner = get_owner_profile();
    if (empty($owner['name'])) return '';
    
    $html = '<div class="bg-white p-8 rounded-lg shadow-md">';
    $html .= '<h2 class="text-3xl font-bold mb-2">' . esc_html($owner['name']) . '</h2>';
    
    // Add job title and company if available
    if (!empty($owner['job_title']) || !empty($owner['company'])) {
        $html .= '<div class="text-blue-600 text-lg mb-4">';
        if (!empty($owner['job_title'])) {
            $html .= esc_html($owner['job_title']);
            if (!empty($owner['company'])) {
                $html .= ' at ' . esc_html($owner['company']);
            }
        } elseif (!empty($owner['company'])) {
            $html .= esc_html($owner['company']);
        }
        $html .= '</div>';
    }
    
    if (!empty($owner['bio'])) {
        $html .= '<p class="text-lg text-gray-700 leading-relaxed mb-6">' . esc_html($owner['bio']) . '</p>';
    }
    
    if (!empty($owner['social']) && is_array($owner['social'])) {
        $html .= '<div class="flex gap-4">';
        foreach ($owner['social'] as $k => $v) {
            if ($v) {
                $html .= '<a class="text-gray-600 hover:text-blue-600 transition flex items-center" href="' . esc_url($v) . '" target="_blank" rel="noopener">';
                
                // Add icons for social links
                switch($k) {
                    case 'twitter':
                        $html .= '<svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>';
                        break;
                    case 'instagram':
                        $html .= '<svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>';
                        break;
                    case 'linkedin':
                        $html .= '<svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z"/></svg>';
                        break;
                    default:
                        $html .= '<svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 6.627 5.374 12 12 12 6.627 0 12-5.373 12-12 0-6.627-5.373-12-12-12zm0 22c-5.514 0-10-4.486-10-10s4.486-10 10-10 10 4.486 10 10-4.486 10-10 10zm-2-11.5l7 4.5-7 4.5v-9z"/></svg>';
                }
                
                $html .= esc_html(ucfirst($k)) . '</a>';
            }
        }
        
        // Add email if available
        if (!empty($owner['email'])) {
            $html .= '<a class="text-gray-600 hover:text-blue-600 transition flex items-center" href="mailto:' . esc_attr($owner['email']) . '">';
            $html .= '<svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>';
            $html .= 'Email</a>';
        }
        
        $html .= '</div>';
    }
    $html .= '</div>';
    return $html;
}

// Helper to render social links for portfolio items (fallback if not in mu-plugin)
if (!function_exists('portfolio_render_social_links')) {
    function portfolio_render_social_links($post_id = null) {
        if (!$post_id) $post_id = get_the_ID();
        $links = get_post_meta($post_id, '_portfolio_social', true);
        if (empty($links) || !is_array($links)) return '';
        $out = '<div class="flex gap-3 mt-4">';
        foreach (['twitter' => 'Twitter', 'linkedin' => 'LinkedIn', 'instagram' => 'Instagram'] as $key => $label) {
            if (!empty($links[$key])) {
                $url = esc_url($links[$key]);
                $out .= '<a class="text-sm text-white hover:text-blue-300 transition flex items-center" href="' . $url . '" target="_blank" rel="noopener">';
                
                // Add icons for social links
                switch($key) {
                    case 'twitter':
                        $out .= '<svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>';
                        break;
                    case 'instagram':
                        $out .= '<svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>';
                        break;
                    case 'linkedin':
                        $out .= '<svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24"><path d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z"/></svg>';
                        break;
                }
                
                $out .= esc_html($label) . '</a>';
            }
        }
        $out .= '</div>';
        return $out;
    }
}

// Create Portfolio Owner Settings Page
add_action('admin_menu', function() {
    add_menu_page(
        'Portfolio Owner', // Page title
        'Portfolio Owner', // Menu title
        'manage_options', // Capability required
        'portfolio-owner-settings', // Menu slug
        'portfolio_owner_settings_page', // Callback function
        'dashicons-businessperson', // Icon
        30 // Position
    );
});

// Register settings
add_action('admin_init', function() {
    register_setting('portfolio_owner_settings_group', 'portfolio_owner_name');
    register_setting('portfolio_owner_settings_group', 'portfolio_owner_job_title');
    register_setting('portfolio_owner_settings_group', 'portfolio_owner_company');
    register_setting('portfolio_owner_settings_group', 'portfolio_owner_bio');
    register_setting('portfolio_owner_settings_group', 'portfolio_owner_twitter');
    register_setting('portfolio_owner_settings_group', 'portfolio_owner_linkedin');
    register_setting('portfolio_owner_settings_group', 'portfolio_owner_instagram');
    register_setting('portfolio_owner_settings_group', 'portfolio_owner_email');
});

// Settings page callback
function portfolio_owner_settings_page() {
    ?>
    <div class="wrap">
        <h1>Portfolio Owner Settings</h1>
        <p>Configure the portfolio owner's information that will be displayed throughout the site.</p>
        
        <form method="post" action="options.php">
            <?php settings_fields('portfolio_owner_settings_group'); ?>
            <?php do_settings_sections('portfolio_owner_settings_group'); ?>
            
            <table class="form-table">
                <tr>
                    <th scope="row">Name</th>
                    <td>
                        <input type="text" name="portfolio_owner_name" value="<?php echo esc_attr(get_option('portfolio_owner_name', 'Evelyn')); ?>" class="regular-text" />
                        <p class="description">The portfolio owner's name (e.g., Evelyn, Lynn)</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Job Title</th>
                    <td>
                        <input type="text" name="portfolio_owner_job_title" value="<?php echo esc_attr(get_option('portfolio_owner_job_title', 'PR & Comms Lead')); ?>" class="regular-text" />
                        <p class="description">The portfolio owner's job title</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Company</th>
                    <td>
                        <input type="text" name="portfolio_owner_company" value="<?php echo esc_attr(get_option('portfolio_owner_company', 'Immobilis')); ?>" class="regular-text" />
                        <p class="description">The company where the portfolio owner works</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Bio</th>
                    <td>
                        <textarea name="portfolio_owner_bio" rows="5" cols="50" class="large-text"><?php echo esc_textarea(get_option('portfolio_owner_bio', 'A passionate photographer and storyteller, capturing moments that matter.')); ?></textarea>
                        <p class="description">A brief biography of the portfolio owner</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Social Media & Contact</th>
                    <td>
                        <p>
                            <label>
                                <strong>Twitter:</strong><br>
                                <input type="url" name="portfolio_owner_twitter" value="<?php echo esc_url(get_option('portfolio_owner_twitter', '')); ?>" class="regular-text" placeholder="https://twitter.com/username" />
                            </label>
                        </p>
                        <p>
                            <label>
                                <strong>LinkedIn:</strong><br>
                                <input type="url" name="portfolio_owner_linkedin" value="<?php echo esc_url(get_option('portfolio_owner_linkedin', '')); ?>" class="regular-text" placeholder="https://linkedin.com/in/username" />
                            </label>
                        </p>
                        <p>
                            <label>
                                <strong>Instagram:</strong><br>
                                <input type="url" name="portfolio_owner_instagram" value="<?php echo esc_url(get_option('portfolio_owner_instagram', '')); ?>" class="regular-text" placeholder="https://instagram.com/username" />
                            </label>
                        </p>
                        <p>
                            <label>
                                <strong>Email:</strong><br>
                                <input type="email" name="portfolio_owner_email" value="<?php echo esc_attr(get_option('portfolio_owner_email', '')); ?>" class="regular-text" placeholder="contact@example.com" />
                            </label>
                        </p>
                    </td>
                </tr>
            </table>
            
            <?php submit_button('Save Settings'); ?>
        </form>
    </div>
    <?php
}

// Helper to get owner profile
if (!function_exists('get_owner_profile')) {
    function get_owner_profile() {
        return [
            'name' => get_option('portfolio_owner_name', 'Evelyn'),
            'job_title' => get_option('portfolio_owner_job_title', 'PR & Comms Lead'),
            'company' => get_option('portfolio_owner_company', 'Immobilis'),
            'bio' => get_option('portfolio_owner_bio', 'A passionate photographer and storyteller, capturing moments that matter.'),
            'social' => [
                'twitter' => get_option('portfolio_owner_twitter', ''),
                'linkedin' => get_option('portfolio_owner_linkedin', ''),
                'instagram' => get_option('portfolio_owner_instagram', ''),
            ],
            'email' => get_option('portfolio_owner_email', ''),
        ];
    }
}
?>
