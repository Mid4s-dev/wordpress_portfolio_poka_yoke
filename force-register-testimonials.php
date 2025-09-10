<?php
/**
 * Fix for Testimonials Post Type Registration
 * 
 * This script directly registers the post type on every page load
 * to ensure it's available in the system.
 */

// Bootstrap WordPress
define('WP_USE_THEMES', false);
require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/wp-load.php';

// Make sure we're registered
function fix_portfolio_testimonials_registration() {
    if (!post_type_exists('portfolio_testimonial')) {
        // Register post type directly
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
        );
        
        register_post_type('portfolio_testimonial', $args);
        
        // Flush rewrite rules
        flush_rewrite_rules(true);
        
        echo "<div style='background:#fff; padding:20px; margin:20px; border:1px solid #ddd;'>";
        echo "<h1>Testimonial Post Type Fixed</h1>";
        echo "<p>The portfolio_testimonial post type has been registered.</p>";
        echo "<p><a href='" . admin_url('edit.php?post_type=portfolio_testimonial') . "'>Go to Testimonials</a></p>";
        echo "</div>";
    } else {
        echo "<div style='background:#fff; padding:20px; margin:20px; border:1px solid #ddd;'>";
        echo "<h1>Post Type Already Registered</h1>";
        echo "<p>The portfolio_testimonial post type is already registered.</p>";
        echo "<p><a href='" . admin_url('edit.php?post_type=portfolio_testimonial') . "'>Go to Testimonials</a></p>";
        echo "</div>";
    }
}

// Run the fix
fix_portfolio_testimonials_registration();
