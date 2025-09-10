<?php
/**
 * Template Name: Flush Permalinks
 * 
 * This template flushes permalinks to fix post type URLs
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Flush Permalinks Tool</h1>
    
    <div class="bg-white p-6 rounded shadow-md">
        <?php
        // Only allow admin users
        if (current_user_can('manage_options')) {
            // Check if the post type exists
            $post_type_exists = post_type_exists('portfolio_testimonial');
            
            echo '<h2 class="text-2xl mb-4">Current Status</h2>';
            echo '<p>' . ($post_type_exists ? '✅ Testimonial post type is registered' : '❌ Testimonial post type is NOT registered') . '</p>';
            
            // If requested, flush the permalinks
            if (isset($_POST['flush_permalinks'])) {
                flush_rewrite_rules();
                echo '<div class="bg-green-100 p-4 my-4 border border-green-300 rounded">';
                echo '<p class="font-bold">✅ Rewrite rules have been flushed!</p>';
                echo '</div>';
            }
            
            // Form for flushing permalinks
            echo '<form method="post" class="mt-6">';
            echo '<input type="hidden" name="flush_permalinks" value="1">';
            echo '<button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">Flush Permalinks</button>';
            echo '</form>';
            
            // Links to testimonial pages
            if ($post_type_exists) {
                echo '<div class="mt-8">';
                echo '<h2 class="text-2xl mb-4">Testimonial Links</h2>';
                echo '<ul class="list-disc pl-6 space-y-2">';
                echo '<li><a href="' . admin_url('edit.php?post_type=portfolio_testimonial') . '" class="text-blue-500 hover:underline">View All Testimonials</a></li>';
                echo '<li><a href="' . admin_url('post-new.php?post_type=portfolio_testimonial') . '" class="text-blue-500 hover:underline">Add New Testimonial</a></li>';
                echo '<li><a href="' . home_url('/testimonials/') . '" class="text-blue-500 hover:underline">View Testimonials Archive</a></li>';
                echo '</ul>';
                echo '</div>';
            }
        } else {
            echo '<p>You do not have permission to use this tool.</p>';
        }
        ?>
    </div>
</div>

<?php get_footer(); ?>
