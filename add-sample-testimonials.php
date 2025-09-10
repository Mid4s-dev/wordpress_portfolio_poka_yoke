<?php
/**
 * Add Sample Testimonials
 * 
 * This script creates sample testimonials if none exist in the database.
 * Access this file directly in the browser to create sample testimonials.
 */

// Load WordPress without theme support
define('WP_USE_THEMES', false);
require_once('../../../wp-load.php');

// Security check
if (!current_user_can('manage_options')) {
    wp_die('You do not have permission to access this page.');
}

echo '<h1>Sample Testimonials Creator</h1>';

// Check if testimonials exist
$existing_testimonials = get_posts(array(
    'post_type' => 'portfolio_testimonial',
    'posts_per_page' => 1,
));

if (!empty($existing_testimonials)) {
    echo '<p style="color: blue; font-weight: bold;">Testimonials already exist in your database. No need to create sample testimonials.</p>';
    
    echo '<p>You have the following testimonials:</p>';
    
    $all_testimonials = get_posts(array(
        'post_type' => 'portfolio_testimonial',
        'posts_per_page' => -1,
    ));
    
    echo '<ul>';
    foreach ($all_testimonials as $testimonial) {
        echo '<li>' . esc_html($testimonial->post_title) . ' (ID: ' . $testimonial->ID . ')</li>';
    }
    echo '</ul>';
    
    echo '<p><a href="' . home_url() . '">Return to homepage</a> | <a href="' . home_url('/wp-admin/edit.php?post_type=portfolio_testimonial') . '">Manage testimonials</a></p>';
    exit;
}

// Sample testimonial data
$sample_testimonials = array(
    array(
        'title' => 'Sarah Johnson',
        'content' => '"Working with this PR professional was transformative for our brand. The strategic campaign they developed increased our media coverage by 300% and significantly boosted our industry credibility. Their deep understanding of our market and creative approach to storytelling made all the difference."',
        'meta' => array(
            'client_name' => 'Sarah Johnson',
            'client_title' => 'Marketing Director',
            'client_company' => 'TechNova Solutions',
            'rating' => 5
        )
    ),
    array(
        'title' => 'Michael Chen',
        'content' => '"During our company crisis, having such a skilled PR specialist on our team was invaluable. They navigated the complex media landscape with confidence and precision, turning a potentially damaging situation into an opportunity to showcase our commitment to transparency. Highly recommended!"',
        'meta' => array(
            'client_name' => 'Michael Chen',
            'client_title' => 'CEO',
            'client_company' => 'Horizon Innovations',
            'rating' => 5
        )
    ),
    array(
        'title' => 'Olivia Martinez',
        'content' => '"The social media strategy developed for our launch campaign exceeded all our expectations. Not only did we achieve our target engagement metrics, but the campaign also generated leads beyond our projections. Their understanding of digital narratives and audience behavior is truly exceptional."',
        'meta' => array(
            'client_name' => 'Olivia Martinez',
            'client_title' => 'Brand Manager',
            'client_company' => 'Elevate Lifestyle',
            'rating' => 4
        )
    ),
    array(
        'title' => 'David Ochieng',
        'content' => '"I appreciate the strategic approach to our corporate communications overhaul. The messaging framework developed has unified our voice across all channels, and our team now has clear guidelines that have improved both internal and external communications. The workshops provided were engaging and insightful."',
        'meta' => array(
            'client_name' => 'David Ochieng',
            'client_title' => 'Communications Lead',
            'client_company' => 'Savanna Enterprises',
            'rating' => 5
        )
    ),
);

$count = 0;

foreach ($sample_testimonials as $testimonial_data) {
    // Create testimonial post
    $post_data = array(
        'post_title'    => $testimonial_data['title'],
        'post_content'  => $testimonial_data['content'],
        'post_status'   => 'publish',
        'post_type'     => 'portfolio_testimonial',
        'post_author'   => get_current_user_id(),
    );
    
    // Insert the post
    $post_id = wp_insert_post($post_data);
    
    if (!is_wp_error($post_id)) {
        // Add meta data
        foreach ($testimonial_data['meta'] as $key => $value) {
            update_post_meta($post_id, '_portfolio_testimonial_' . $key, $value);
        }
        
        echo '<p style="color: green;">✓ Created testimonial: ' . esc_html($testimonial_data['title']) . ' (ID: ' . $post_id . ')</p>';
        $count++;
    } else {
        echo '<p style="color: red;">✗ Error creating testimonial: ' . esc_html($testimonial_data['title']) . ' - ' . $post_id->get_error_message() . '</p>';
    }
}

echo '<h2>Successfully created ' . $count . ' sample testimonials!</h2>';

echo '<p><a href="' . home_url() . '">Return to homepage</a> | <a href="' . home_url('/wp-admin/edit.php?post_type=portfolio_testimonial') . '">Manage testimonials</a></p>';

// Refresh permalinks for good measure
flush_rewrite_rules();
