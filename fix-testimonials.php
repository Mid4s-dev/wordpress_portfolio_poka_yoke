<?php
/**
 * Fix Testimonials Post Type Registration
 * 
 * This script explicitly flushes rewrite rules to ensure the testimonial post type
 * is properly registered and accessible.
 */

// Find WordPress
$wp_load_paths = array(
    '../../../../wp-load.php',
    '../../../wp-load.php',
    '../../wp-load.php',
    '../wp-load.php',
    './wp-load.php',
    dirname(dirname(dirname(dirname(__FILE__)))) . '/wp-load.php'
);

$wp_loaded = false;
foreach ($wp_load_paths as $path) {
    if (file_exists($path)) {
        require_once($path);
        $wp_loaded = true;
        break;
    }
}

if (!$wp_loaded) {
    die('Could not find WordPress installation. Please run this script from the WordPress admin or adjust the path to wp-load.php.');
}

// Ensure we're logged in with admin rights
if (!current_user_can('manage_options')) {
    die('You need to be an administrator to run this script.');
}

// Check if post type exists
echo "<h2>Testimonials Post Type Check</h2>";
if (post_type_exists('portfolio_testimonial')) {
    echo "<p style='color:green;'>✅ Post type 'portfolio_testimonial' is registered.</p>";
} else {
    echo "<p style='color:red;'>❌ Post type 'portfolio_testimonial' is NOT registered!</p>";
    
    // Try to register it manually
    echo "<p>Attempting to register post type manually...</p>";
    
    // Try new testimonials file first
    if (file_exists(get_template_directory() . '/inc/new-testimonials.php')) {
        echo "<p>Using new-testimonials.php...</p>";
        include_once(get_template_directory() . '/inc/new-testimonials.php');
    } else {
        // Fall back to original file
        echo "<p>Using testimonials.php...</p>";
        include_once(get_template_directory() . '/inc/testimonials.php');
    }
    
    // If still not registered, try direct registration
    if (!post_type_exists('portfolio_testimonial')) {
        echo "<p>Direct registration attempt...</p>";
        
        $args = array(
            'labels' => array(
                'name'               => 'Testimonials',
                'singular_name'      => 'Testimonial',
                'menu_name'          => 'Testimonials',
                'add_new'            => 'Add New',
                'add_new_item'       => 'Add New Testimonial',
                'edit_item'          => 'Edit Testimonial'
            ),
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
    }
    
    // Check again
    if (post_type_exists('portfolio_testimonial')) {
        echo "<p style='color:green;'>✅ Post type successfully registered!</p>";
    } else {
        echo "<p style='color:red;'>❌ Failed to register post type!</p>";
    }
}

// Flush rewrite rules
echo "<h2>Flushing Rewrite Rules</h2>";
echo "<p>Current rewrite rules count: " . count($GLOBALS['wp_rewrite']->rewrite_rules()) . "</p>";

echo "<p>Flushing rewrite rules...</p>";
flush_rewrite_rules(true);

echo "<p>Rewrite rules flushed.</p>";
echo "<p>New rewrite rules count: " . count($GLOBALS['wp_rewrite']->rewrite_rules()) . "</p>";

// Check if Quick Testimonials page is available
echo "<h2>Quick Testimonials Page Check</h2>";

// Get the list of admin pages
global $menu;
$quick_testimonials_found = false;

// We can't directly access $menu here, so let's check another way
$admin_page_url = admin_url('admin.php?page=portfolio-quick-testimonial');
echo "<p>Quick Testimonials page URL: <a href='$admin_page_url' target='_blank'>$admin_page_url</a></p>";

// Check testimonials count
echo "<h2>Testimonials Count</h2>";
$testimonials = get_posts(array(
    'post_type' => 'portfolio_testimonial',
    'posts_per_page' => -1,
    'post_status' => array('publish', 'draft', 'pending'),
));

echo "<p>Total testimonials found: " . count($testimonials) . "</p>";

if (count($testimonials) == 0) {
    echo "<p>No testimonials found. You can create testimonials using the <a href='$admin_page_url' target='_blank'>Quick Testimonials page</a>.</p>";
} else {
    echo "<h3>Existing Testimonials:</h3>";
    echo "<ul>";
    foreach ($testimonials as $testimonial) {
        $edit_url = get_edit_post_link($testimonial->ID);
        echo "<li><a href='$edit_url' target='_blank'>" . esc_html($testimonial->post_title) . "</a> (Status: " . $testimonial->post_status . ")</li>";
    }
    echo "</ul>";
}

echo "<h2>Next Steps</h2>";
echo "<ol>";
echo "<li>Go to <a href='" . admin_url('options-permalink.php') . "' target='_blank'>Permalinks Settings</a> and click 'Save Changes' to update rewrite rules.</li>";
echo "<li>Go to the <a href='$admin_page_url' target='_blank'>Quick Testimonials page</a> to add testimonials.</li>";
echo "<li>Visit your <a href='" . home_url() . "' target='_blank'>homepage</a> to see if testimonials are now displayed.</li>";
echo "</ol>";

echo "<p style='margin-top:30px;'><b>Script completed successfully!</b></p>";
