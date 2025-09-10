<?php
/**
 * Testimonial Admin Menu
 * 
 * Adds admin menu items for testimonials management
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
 * Add submenu item for adding new testimonial
 */
function portfolio_testimonials_admin_menu() {
    // Add a direct link to "Add New Testimonial" in the admin menu
    add_submenu_page(
        'edit.php?post_type=portfolio_testimonial',
        __('Add New Testimonial', 'portfolio'),
        __('Add New', 'portfolio'),
        'edit_posts',
        'post-new.php?post_type=portfolio_testimonial'
    );
    
    // Add a link to manage testimonials in the admin menu
    add_menu_page(
        __('Testimonials', 'portfolio'),
        __('Testimonials', 'portfolio'),
        'edit_posts',
        'edit.php?post_type=portfolio_testimonial',
        '',
        'dashicons-format-quote',
        22
    );
}
add_action('admin_menu', 'portfolio_testimonials_admin_menu');
