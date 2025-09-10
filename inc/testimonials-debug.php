<?php
/**
 * Testimonials Debug Functions
 * 
 * This file contains debug functions to help troubleshoot testimonial post type issues.
 * It will show admin notices about the post type registration status.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Add an admin notice showing if the testimonial post type is properly registered
 */
function portfolio_testimonials_debug_notice() {
    // Only show to administrators
    if (!current_user_can('manage_options')) {
        return;
    }
    
    // Check if the post type exists
    $post_type_exists = post_type_exists('portfolio_testimonial');
    
    // Get list of all registered post types
    $post_types = get_post_types(array(), 'names');
    
    // Start building the notice
    $notice_class = $post_type_exists ? 'notice-success' : 'notice-error';
    
    ?>
    <div class="notice <?php echo $notice_class; ?> is-dismissible">
        <h3>Testimonials Debug Information</h3>
        <p>
            <strong>Testimonial Post Type Status:</strong> 
            <?php echo $post_type_exists ? '✅ REGISTERED' : '❌ NOT REGISTERED'; ?>
        </p>
        
        <?php if (!$post_type_exists): ?>
            <p>The "portfolio_testimonial" post type is not currently registered. This may cause "Invalid Post Type" errors.</p>
            <p>Please check:</p>
            <ol>
                <li>That testimonials-core.php is being included in functions.php</li>
                <li>That the registration function is properly hooked to init</li>
                <li>That there are no PHP errors preventing registration</li>
            </ol>
        <?php endif; ?>
        
        <p><strong>All Registered Post Types:</strong></p>
        <ul style="background: #f8f8f8; padding: 10px; border: 1px solid #ddd; max-height: 200px; overflow-y: auto;">
            <?php foreach ($post_types as $post_type): ?>
                <li><?php echo esc_html($post_type); ?><?php echo ($post_type === 'portfolio_testimonial') ? ' ✓' : ''; ?></li>
            <?php endforeach; ?>
        </ul>
        
        <p>
            <a href="<?php echo admin_url('admin.php?page=testimonials-debug'); ?>" class="button">View Detailed Debug Info</a>
            <a href="<?php echo home_url('/fix-testimonials.php'); ?>" class="button">Run Fix Tool</a>
        </p>
    </div>
    <?php
}
add_action('admin_notices', 'portfolio_testimonials_debug_notice');

/**
 * Register a debug admin page
 */
function portfolio_testimonials_debug_page() {
    add_management_page(
        'Testimonials Debug', 
        'Testimonials Debug', 
        'manage_options', 
        'testimonials-debug', 
        'portfolio_testimonials_debug_page_content'
    );
}
add_action('admin_menu', 'portfolio_testimonials_debug_page');

/**
 * Display the debug admin page content
 */
function portfolio_testimonials_debug_page_content() {
    // Check if the user has the required capability
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }
    
    // Get post type object if it exists
    $post_type_obj = get_post_type_object('portfolio_testimonial');
    
    echo '<div class="wrap">';
    echo '<h1>Testimonials Debug Information</h1>';
    
    // Post Type Status
    echo '<h2>Post Type Status</h2>';
    echo '<div class="card" style="padding: 10px; background: #fff; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04); margin-bottom: 20px;">';
    if ($post_type_obj) {
        echo '<p style="color: green;">✅ The portfolio_testimonial post type IS registered.</p>';
        echo '<pre>' . print_r($post_type_obj, true) . '</pre>';
    } else {
        echo '<p style="color: red;">❌ The portfolio_testimonial post type is NOT registered.</p>';
    }
    echo '</div>';
    
    // Included Files
    echo '<h2>Relevant Included Files</h2>';
    echo '<div class="card" style="padding: 10px; background: #fff; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04); margin-bottom: 20px;">';
    echo '<ul>';
    $theme_dir = get_template_directory();
    $relevant_files = array(
        '/inc/testimonials-core.php',
        '/inc/testimonials.php',
        '/inc/new-testimonials.php',
        '/inc/testimonials-admin.php'
    );
    
    foreach ($relevant_files as $file) {
        $file_path = $theme_dir . $file;
        $file_exists = file_exists($file_path);
        $included = in_array($file_path, get_included_files());
        
        echo '<li>';
        echo $file . ' - ';
        echo $file_exists ? '✅ Exists' : '❌ Not found';
        echo ' / ';
        echo $included ? '✅ Included' : '❓ Not included';
        echo '</li>';
    }
    echo '</ul>';
    echo '</div>';
    
    // Fix Button
    echo '<h2>Actions</h2>';
    echo '<div class="card" style="padding: 10px; background: #fff; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04); margin-bottom: 20px;">';
    echo '<p><a href="' . home_url('/fix-testimonials.php') . '" class="button button-primary">Run Fix Testimonials Tool</a></p>';
    echo '<p><a href="' . admin_url('options-permalink.php') . '" class="button">Update Permalinks</a></p>';
    echo '<p><a href="' . admin_url('edit.php?post_type=portfolio_testimonial') . '" class="button">Go to Testimonials</a></p>';
    echo '</div>';
    
    echo '</div>';
}
