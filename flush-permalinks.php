<?php
/**
 * Flush Permalinks Script
 */

// Include WordPress
define('WP_USE_THEMES', false);
require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/wp-load.php';

// Check permissions
if (!current_user_can('manage_options')) {
    echo "Error: Must be an administrator\n";
    exit(1);
}

// Flush permalinks
flush_rewrite_rules();
echo "Success: Permalinks have been flushed.\n";
echo "Portfolio Testimonial Post Type: " . (post_type_exists('portfolio_testimonial') ? "EXISTS" : "DOES NOT EXIST") . "\n";
update_option('portfolio_permalinks_updated_for_testimonials', time());
