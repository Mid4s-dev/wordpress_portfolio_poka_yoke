<?php
/**
 * Database Table Check Script
 *
 * This script identifies tables storing testimonials and campaigns data.
 *
 * @package Portfolio
 */

// Load WordPress without theme support
define('WP_USE_THEMES', false);
require_once('../../../wp-load.php');

// Security check
if (!current_user_can('manage_options')) {
    wp_die('You do not have permission to access this page.', 'Access Denied', array('response' => 403));
}

// Start HTML output
echo '<!DOCTYPE html>
<html>
<head>
    <title>Database Tables Information</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
            line-height: 1.6;
            margin: 20px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        h1, h2, h3 {
            color: #0073aa;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }
        th, td {
            text-align: left;
            padding: 8px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f8f9fa;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .highlight {
            background-color: #e6f7ff !important;
            font-weight: bold;
        }
        .info-box {
            background-color: #f0f8ff;
            border: 1px solid #d1e4f7;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .post-data {
            margin-top: 30px;
        }
    </style>
</head>
<body>';

echo '<h1>WordPress Database Tables Analysis</h1>';

global $wpdb;

echo '<div class="info-box">';
echo '<p><strong>Database Prefix:</strong> ' . esc_html($wpdb->prefix) . '</p>';
echo '<p>In WordPress, custom post types like testimonials and campaigns are stored in the default WordPress posts table, with post meta information stored in the postmeta table.</p>';
echo '</div>';

// Get all database tables
$tables = $wpdb->get_results("SHOW TABLES");
$table_column = 'Tables_in_' . $wpdb->dbname;

echo '<h2>All Database Tables</h2>';
echo '<table>';
echo '<tr><th>Table Name</th><th>Description</th></tr>';

foreach ($tables as $table) {
    $table_name = $table->$table_column;
    $highlight = '';
    $description = '';
    
    // Identify WordPress core tables
    if ($table_name === $wpdb->prefix . 'posts') {
        $highlight = ' class="highlight"';
        $description = 'Stores all posts, pages, and custom post types including testimonials and campaigns';
    } else if ($table_name === $wpdb->prefix . 'postmeta') {
        $highlight = ' class="highlight"';
        $description = 'Stores all post metadata, including testimonial and campaign custom fields';
    } else if ($table_name === $wpdb->prefix . 'terms') {
        $description = 'Stores taxonomy terms that may be used for categorizing testimonials or campaigns';
    } else if ($table_name === $wpdb->prefix . 'term_relationships') {
        $description = 'Maps posts (including testimonials and campaigns) to taxonomy terms';
    } else {
        $description = 'WordPress core table or plugin table';
    }
    
    echo "<tr$highlight><td>{$table_name}</td><td>{$description}</td></tr>";
}

echo '</table>';

// Check for testimonial data in posts table
echo '<h2>Testimonial Data Structure</h2>';

// Check if post type exists
$testimonial_post_type = 'portfolio_testimonial';
if (post_type_exists($testimonial_post_type)) {
    echo "<p>The testimonial post type <code>$testimonial_post_type</code> is registered in your WordPress site.</p>";
    
    // Count testimonials
    $testimonial_count = wp_count_posts($testimonial_post_type);
    echo '<p>Testimonial counts:</p>';
    echo '<ul>';
    echo '<li><strong>Published:</strong> ' . intval($testimonial_count->publish) . '</li>';
    echo '<li><strong>Draft:</strong> ' . intval($testimonial_count->draft) . '</li>';
    echo '</ul>';
    
    // Display table structure
    echo '<h3>Database Storage Information:</h3>';
    echo '<div class="info-box">';
    echo "<p>Testimonials are stored as posts with post_type='$testimonial_post_type' in the <strong>{$wpdb->prefix}posts</strong> table.</p>";
    echo "<p>Testimonial metadata (client name, rating, etc.) is stored in the <strong>{$wpdb->prefix}postmeta</strong> table.</p>";
    echo '</div>';
    
    // Show example testimonial meta keys
    $meta_keys = $wpdb->get_col($wpdb->prepare(
        "SELECT DISTINCT meta_key FROM {$wpdb->postmeta} pm
        JOIN {$wpdb->posts} p ON pm.post_id = p.ID
        WHERE p.post_type = %s AND meta_key LIKE '_%'
        LIMIT 10",
        $testimonial_post_type
    ));
    
    if (!empty($meta_keys)) {
        echo '<h4>Testimonial Meta Keys:</h4>';
        echo '<ul>';
        foreach ($meta_keys as $key) {
            echo '<li><code>' . esc_html($key) . '</code></li>';
        }
        echo '</ul>';
    }
    
    // Example testimonial structure
    $testimonial = get_posts(array(
        'post_type' => $testimonial_post_type,
        'posts_per_page' => 1,
    ));
    
    if (!empty($testimonial)) {
        $testimonial = $testimonial[0];
        $testimonial_meta = get_post_meta($testimonial->ID);
        
        echo '<h4>Example Testimonial Data Structure:</h4>';
        echo '<div class="post-data">';
        echo '<table>';
        echo '<tr><th>Field</th><th>Database Table</th><th>Value</th></tr>';
        echo '<tr><td>ID</td><td>' . $wpdb->prefix . 'posts.ID</td><td>' . esc_html($testimonial->ID) . '</td></tr>';
        echo '<tr><td>Title</td><td>' . $wpdb->prefix . 'posts.post_title</td><td>' . esc_html($testimonial->post_title) . '</td></tr>';
        echo '<tr><td>Content</td><td>' . $wpdb->prefix . 'posts.post_content</td><td>' . esc_html(wp_trim_words($testimonial->post_content, 10)) . '...</td></tr>';
        echo '<tr><td>Status</td><td>' . $wpdb->prefix . 'posts.post_status</td><td>' . esc_html($testimonial->post_status) . '</td></tr>';
        
        foreach ($testimonial_meta as $key => $values) {
            if (strpos($key, '_') === 0) { // Only show meta keys that start with underscore
                echo '<tr>';
                echo '<td>' . esc_html($key) . '</td>';
                echo '<td>' . $wpdb->prefix . 'postmeta</td>';
                echo '<td>' . esc_html(maybe_serialize($values[0])) . '</td>';
                echo '</tr>';
            }
        }
        
        echo '</table>';
        echo '</div>';
    }
} else {
    echo "<p>No testimonial post type <code>$testimonial_post_type</code> is registered in your WordPress site.</p>";
}

// Check for campaigns data
echo '<h2>Campaign Data Structure</h2>';

// Check if post type exists
$campaign_post_type = 'portfolio_campaign';
if (post_type_exists($campaign_post_type)) {
    echo "<p>The campaign post type <code>$campaign_post_type</code> is registered in your WordPress site.</p>";
    
    // Count campaigns
    $campaign_count = wp_count_posts($campaign_post_type);
    echo '<p>Campaign counts:</p>';
    echo '<ul>';
    echo '<li><strong>Published:</strong> ' . intval($campaign_count->publish) . '</li>';
    echo '<li><strong>Draft:</strong> ' . intval($campaign_count->draft) . '</li>';
    echo '</ul>';
    
    // Display table structure
    echo '<h3>Database Storage Information:</h3>';
    echo '<div class="info-box">';
    echo "<p>Campaigns are stored as posts with post_type='$campaign_post_type' in the <strong>{$wpdb->prefix}posts</strong> table.</p>";
    echo "<p>Campaign metadata is stored in the <strong>{$wpdb->prefix}postmeta</strong> table.</p>";
    echo '</div>';
    
    // Show example campaign meta keys
    $meta_keys = $wpdb->get_col($wpdb->prepare(
        "SELECT DISTINCT meta_key FROM {$wpdb->postmeta} pm
        JOIN {$wpdb->posts} p ON pm.post_id = p.ID
        WHERE p.post_type = %s AND meta_key LIKE '_%'
        LIMIT 10",
        $campaign_post_type
    ));
    
    if (!empty($meta_keys)) {
        echo '<h4>Campaign Meta Keys:</h4>';
        echo '<ul>';
        foreach ($meta_keys as $key) {
            echo '<li><code>' . esc_html($key) . '</code></li>';
        }
        echo '</ul>';
    }
    
    // Example campaign structure
    $campaign = get_posts(array(
        'post_type' => $campaign_post_type,
        'posts_per_page' => 1,
    ));
    
    if (!empty($campaign)) {
        $campaign = $campaign[0];
        $campaign_meta = get_post_meta($campaign->ID);
        
        echo '<h4>Example Campaign Data Structure:</h4>';
        echo '<div class="post-data">';
        echo '<table>';
        echo '<tr><th>Field</th><th>Database Table</th><th>Value</th></tr>';
        echo '<tr><td>ID</td><td>' . $wpdb->prefix . 'posts.ID</td><td>' . esc_html($campaign->ID) . '</td></tr>';
        echo '<tr><td>Title</td><td>' . $wpdb->prefix . 'posts.post_title</td><td>' . esc_html($campaign->post_title) . '</td></tr>';
        echo '<tr><td>Content</td><td>' . $wpdb->prefix . 'posts.post_content</td><td>' . esc_html(wp_trim_words($campaign->post_content, 10)) . '...</td></tr>';
        echo '<tr><td>Status</td><td>' . $wpdb->prefix . 'posts.post_status</td><td>' . esc_html($campaign->post_status) . '</td></tr>';
        
        foreach ($campaign_meta as $key => $values) {
            if (strpos($key, '_') === 0) { // Only show meta keys that start with underscore
                echo '<tr>';
                echo '<td>' . esc_html($key) . '</td>';
                echo '<td>' . $wpdb->prefix . 'postmeta</td>';
                echo '<td>' . esc_html(maybe_serialize($values[0])) . '</td>';
                echo '</tr>';
            }
        }
        
        echo '</table>';
        echo '</div>';
    }
} else {
    // Check if we can find any other campaign-like post type
    $possible_campaign_types = array('campaign', 'campaigns', 'portfolio_campaigns');
    $found = false;
    
    foreach ($possible_campaign_types as $type) {
        if (post_type_exists($type)) {
            echo "<p>Found a possible campaign post type: <code>$type</code></p>";
            $found = true;
            break;
        }
    }
    
    if (!$found) {
        echo "<p>No campaign post type <code>$campaign_post_type</code> is registered in your WordPress site.</p>";
        
        // Try to check for any custom post types that might be campaigns
        $args = array(
            'public' => true,
            '_builtin' => false
        );
        $post_types = get_post_types($args, 'objects');
        
        if (!empty($post_types)) {
            echo "<p>Custom post types found that might be used for campaigns:</p>";
            echo "<ul>";
            foreach ($post_types as $post_type) {
                echo "<li><code>" . esc_html($post_type->name) . "</code> - " . esc_html($post_type->label) . "</li>";
            }
            echo "</ul>";
        }
    }
}

// Direct SQL query for testimonial data
echo '<h2>Sample SQL Queries for Testimonial Data</h2>';

echo '<div class="info-box">';
echo '<p>These queries show you how to retrieve testimonial data directly from the database:</p>';

echo '<pre style="background-color: #f4f4f4; padding: 10px; overflow-x: auto;">';
echo "-- Query to get all testimonials\n";
echo "SELECT ID, post_title, post_date, post_status \n";
echo "FROM {$wpdb->prefix}posts \n";
echo "WHERE post_type = 'portfolio_testimonial' \n";
echo "ORDER BY post_date DESC;\n\n";

echo "-- Query to get testimonial metadata\n";
echo "SELECT p.ID, p.post_title, pm.meta_key, pm.meta_value \n";
echo "FROM {$wpdb->prefix}posts p \n";
echo "JOIN {$wpdb->prefix}postmeta pm ON p.ID = pm.post_id \n";
echo "WHERE p.post_type = 'portfolio_testimonial' \n";
echo "AND pm.meta_key LIKE '\_%' \n";
echo "ORDER BY p.ID, pm.meta_key;\n\n";

echo "-- Query to count testimonials by status\n";
echo "SELECT post_status, COUNT(*) as count \n";
echo "FROM {$wpdb->prefix}posts \n";
echo "WHERE post_type = 'portfolio_testimonial' \n";
echo "GROUP BY post_status;";
echo '</pre>';
echo '</div>';

// Direct SQL query for campaign data
echo '<h2>Sample SQL Queries for Campaign Data</h2>';

echo '<div class="info-box">';
echo '<p>These queries show you how to retrieve campaign data directly from the database:</p>';

echo '<pre style="background-color: #f4f4f4; padding: 10px; overflow-x: auto;">';
echo "-- Query to get all campaigns\n";
echo "SELECT ID, post_title, post_date, post_status \n";
echo "FROM {$wpdb->prefix}posts \n";
echo "WHERE post_type = 'portfolio_campaign' \n";
echo "ORDER BY post_date DESC;\n\n";

echo "-- Query to get campaign metadata\n";
echo "SELECT p.ID, p.post_title, pm.meta_key, pm.meta_value \n";
echo "FROM {$wpdb->prefix}posts p \n";
echo "JOIN {$wpdb->prefix}postmeta pm ON p.ID = pm.post_id \n";
echo "WHERE p.post_type = 'portfolio_campaign' \n";
echo "AND pm.meta_key LIKE '\_%' \n";
echo "ORDER BY p.ID, pm.meta_key;\n\n";

echo "-- Query to count campaigns by status\n";
echo "SELECT post_status, COUNT(*) as count \n";
echo "FROM {$wpdb->prefix}posts \n";
echo "WHERE post_type = 'portfolio_campaign' \n";
echo "GROUP BY post_status;";
echo '</pre>';
echo '</div>';

// Footer
echo '<p><a href="' . esc_url(admin_url()) . '">Return to WordPress Admin</a></p>';
echo '</body></html>';
?>
