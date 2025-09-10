<?php
/**
 * Flush Rewrite Rules Script
 * 
 * This script will flush WordPress rewrite rules to ensure permalinks work correctly.
 */

// Bootstrap WordPress
define('WP_USE_THEMES', false);
require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/wp-load.php';

// Check permissions
if (!current_user_can('manage_options')) {
    wp_die('You need administrator permissions to run this tool.');
}

echo '<!DOCTYPE html>
<html>
<head>
    <title>Flush Rewrite Rules</title>
    <style>
        body { font-family: sans-serif; max-width: 800px; margin: 20px auto; line-height: 1.6; }
        h1, h2 { color: #23282d; }
        .card { background: #fff; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04); padding: 15px; margin-bottom: 20px; }
        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>
    <h1>Flush Rewrite Rules</h1>';

echo '<div class="card">';
echo '<h2>Registered Post Types</h2>';
echo '<ul>';

$post_types = get_post_types(array(), 'objects');
foreach ($post_types as $post_type) {
    echo '<li>' . esc_html($post_type->name) . ' - ' . esc_html($post_type->label) . '</li>';
}

echo '</ul>';
echo '</div>';

echo '<div class="card">';
echo '<h2>Flushing Rewrite Rules</h2>';

// Flush rewrite rules
flush_rewrite_rules(true);
echo '<p class="success">✅ Rewrite rules flushed successfully.</p>';

// Check if testimonial post type is registered
$testimonial_exists = post_type_exists('portfolio_testimonial');
echo '<p>' . ($testimonial_exists ? '✅ portfolio_testimonial post type is registered.' : '❌ portfolio_testimonial post type is NOT registered!') . '</p>';

echo '<p>Return to <a href="' . admin_url() . '">WordPress Dashboard</a></p>';
echo '</div>';

echo '</body>
</html>';

// Delete this file after execution
@unlink(__FILE__);
