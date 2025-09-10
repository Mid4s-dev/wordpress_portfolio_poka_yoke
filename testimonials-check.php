<?php
/**
 * Quick Testimonials Status Check
 * 
 * Run this script from your browser to check testimonials functionality
 */

// Include WordPress
define('WP_USE_THEMES', false);
require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/wp-load.php';

// Check permissions
if (!current_user_can('manage_options')) {
    wp_die('You need administrator permissions to run this tool.');
}

// Start HTML output
?>
<!DOCTYPE html>
<html>
<head>
    <title>Testimonials Status Check</title>
    <style>
        body { font-family: sans-serif; max-width: 800px; margin: 20px auto; line-height: 1.6; }
        h1, h2, h3 { color: #23282d; }
        .card { background: #fff; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04); padding: 15px; margin-bottom: 20px; }
        .success { color: green; }
        .error { color: red; }
        pre { background: #f5f5f5; padding: 10px; border: 1px solid #ddd; overflow: auto; }
        .button { display: inline-block; text-decoration: none; font-size: 13px; line-height: 2.15384615; min-height: 30px; margin: 0; padding: 0 10px; cursor: pointer; border-width: 1px; border-style: solid; -webkit-appearance: none; border-radius: 3px; white-space: nowrap; box-sizing: border-box; background: #2271b1; border-color: #2271b1; color: #fff; }
        .button:hover { background: #135e96; border-color: #135e96; color: #fff; }
    </style>
</head>
<body>
    <h1>Testimonials System Status</h1>
    
    <div class="card">
        <h2>Post Type Status</h2>
        <?php if (post_type_exists('portfolio_testimonial')): ?>
            <p class="success">✅ Post type is registered correctly</p>
        <?php else: ?>
            <p class="error">❌ Post type is NOT registered</p>
        <?php endif; ?>
        
        <h3>Registration Details</h3>
        <ul>
            <li>Direct Registration: <?php echo get_option('portfolio_testimonials_directly_registered', false) ? '<span class="success">Yes</span>' : '<span class="error">No</span>'; ?></li>
            <li>Core Registration: <?php echo get_option('portfolio_testimonials_core_registered', false) ? '<span class="success">Yes</span>' : '<span class="error">No</span>'; ?></li>
            <li>Permalinks Updated: <?php echo get_option('portfolio_permalinks_updated_for_testimonials', false) ? '<span class="success">Yes</span>' : '<span class="error">No</span>'; ?></li>
        </ul>
    </div>
    
    <div class="card">
        <h2>Testimonials Count</h2>
        <?php 
        $testimonials = new WP_Query([
            'post_type' => 'portfolio_testimonial',
            'posts_per_page' => -1
        ]);
        $count = $testimonials->found_posts;
        ?>
        
        <p>Total testimonials: <?php echo $count; ?></p>
        
        <?php if ($count === 0): ?>
            <p><a href="<?php echo admin_url('post-new.php?post_type=portfolio_testimonial'); ?>" class="button">Create New Testimonial</a></p>
        <?php else: ?>
            <p><a href="<?php echo admin_url('edit.php?post_type=portfolio_testimonial'); ?>" class="button">View All Testimonials</a></p>
        <?php endif; ?>
    </div>
    
    <div class="card">
        <h2>Template Files</h2>
        <?php
        $theme_dir = get_template_directory();
        $template_files = [
            'single-portfolio_testimonial.php' => $theme_dir . '/single-portfolio_testimonial.php',
            'archive-portfolio_testimonial.php' => $theme_dir . '/archive-portfolio_testimonial.php'
        ];
        ?>
        
        <ul>
        <?php foreach ($template_files as $name => $path): ?>
            <li>
                <?php echo esc_html($name); ?>: 
                <?php if (file_exists($path)): ?>
                    <span class="success">Found</span>
                <?php else: ?>
                    <span>Not found (will use default templates)</span>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
        </ul>
    </div>
    
    <div class="card">
        <h2>Shortcode Test</h2>
        
        <?php if (function_exists('portfolio_testimonials_shortcode') || shortcode_exists('portfolio_testimonials')): ?>
            <p class="success">✅ Testimonials shortcode is registered</p>
            <p>You can use the shortcode <code>[portfolio_testimonials]</code> to display testimonials in your pages.</p>
            <p>Examples:</p>
            <ul>
                <li><code>[portfolio_testimonials count="3"]</code> - Display 3 testimonials</li>
                <li><code>[portfolio_testimonials layout="grid" columns="2"]</code> - Display in a 2-column grid</li>
                <li><code>[portfolio_testimonials min_rating="4"]</code> - Only show testimonials with 4 or 5 stars</li>
            </ul>
        <?php else: ?>
            <p class="error">❌ Testimonials shortcode is NOT registered</p>
        <?php endif; ?>
    </div>
    
    <div class="card">
        <h2>Actions</h2>
        <p><a href="<?php echo admin_url('options-permalink.php'); ?>" class="button">Update Permalinks</a></p>
        <p><a href="<?php echo admin_url('edit.php?post_type=portfolio_testimonial'); ?>" class="button">Testimonials Admin</a></p>
        <p><a href="<?php echo admin_url('post-new.php?post_type=portfolio_testimonial'); ?>" class="button">Add New Testimonial</a></p>
        <p><a href="<?php echo home_url(); ?>" class="button">View Site</a></p>
    </div>
</body>
</html>
