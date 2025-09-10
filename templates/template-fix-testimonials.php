<?php
/**
 * Template Name: Fix Testimonials
 * Description: A template page that helps fix testimonials post type issues
 *
 * @package Portfolio
 */

// Only allow administrators to access this page
if (!is_user_logged_in() || !current_user_can('manage_options')) {
    wp_die('You do not have permission to access this page.');
}

get_header();
?>

<div class="container mx-auto px-4 py-12">
    <h1 class="heading-xl mb-8 text-center">Testimonials Troubleshooting</h1>
    
    <div class="bg-white p-8 rounded-lg shadow-md mb-8">
        <h2 class="heading-lg mb-4">Post Type Registration Check</h2>
        
        <?php 
        // Check if post type exists
        if (post_type_exists('portfolio_testimonial')) {
            echo '<div class="bg-green-100 text-green-800 p-4 rounded mb-4">';
            echo '<p>✅ <strong>Post type "portfolio_testimonial" is registered correctly.</strong></p>';
            echo '</div>';
        } else {
            echo '<div class="bg-red-100 text-red-800 p-4 rounded mb-4">';
            echo '<p>❌ <strong>Post type "portfolio_testimonial" is NOT registered!</strong></p>';
            echo '</div>';
            
            // Force register post type
            require_once get_template_directory() . '/inc/testimonials.php';
            
            // Check again
            if (post_type_exists('portfolio_testimonial')) {
                echo '<div class="bg-green-100 text-green-800 p-4 rounded mb-4">';
                echo '<p>✅ <strong>Post type successfully registered!</strong></p>';
                echo '</div>';
            }
        }
        ?>
        
        <h3 class="heading-md mb-3 mt-6">Flush Rewrite Rules</h3>
        <p class="mb-4">Click the button below to flush WordPress rewrite rules, which may fix URL-related issues with the testimonials:</p>
        
        <form method="post">
            <?php wp_nonce_field('fix_testimonials_action', 'fix_testimonials_nonce'); ?>
            <input type="hidden" name="flush_rules" value="1">
            <button type="submit" class="py-2 px-4 bg-blue-600 text-white rounded hover:bg-blue-700">Flush Rewrite Rules</button>
        </form>
        
        <?php
        // Handle form submission
        if (isset($_POST['flush_rules']) && isset($_POST['fix_testimonials_nonce'])) {
            if (wp_verify_nonce($_POST['fix_testimonials_nonce'], 'fix_testimonials_action')) {
                flush_rewrite_rules(true);
                echo '<div class="bg-green-100 text-green-800 p-4 rounded my-4">';
                echo '<p>✅ <strong>Rewrite rules have been flushed successfully!</strong></p>';
                echo '</div>';
            }
        }
        ?>
    </div>
    
    <div class="bg-white p-8 rounded-lg shadow-md mb-8">
        <h2 class="heading-lg mb-4">Testimonials Content Check</h2>
        
        <?php
        // Check testimonials count
        $testimonials = get_posts(array(
            'post_type' => 'portfolio_testimonial',
            'posts_per_page' => -1,
            'post_status' => array('publish', 'draft', 'pending'),
        ));
        
        echo '<p class="mb-4"><strong>Total testimonials found: ' . count($testimonials) . '</strong></p>';
        
        if (count($testimonials) == 0) {
            echo '<div class="bg-yellow-100 text-yellow-800 p-4 rounded mb-4">';
            echo '<p>⚠️ <strong>No testimonials found.</strong> You can create testimonials using the Quick Testimonials page.</p>';
            echo '</div>';
        } else {
            echo '<h3 class="heading-md mb-3">Existing Testimonials:</h3>';
            echo '<ul class="list-disc pl-5 mb-4">';
            foreach ($testimonials as $testimonial) {
                $edit_url = get_edit_post_link($testimonial->ID);
                echo '<li><a href="' . $edit_url . '" class="text-blue-600 hover:underline">' . esc_html($testimonial->post_title) . '</a> (Status: ' . $testimonial->post_status . ')</li>';
            }
            echo '</ul>';
        }
        ?>
    </div>
    
    <div class="bg-white p-8 rounded-lg shadow-md">
        <h2 class="heading-lg mb-4">Next Steps</h2>
        
        <ol class="list-decimal pl-5 mb-6 space-y-2">
            <li>Go to <a href="<?php echo admin_url('options-permalink.php'); ?>" class="text-blue-600 hover:underline">Permalinks Settings</a> and click 'Save Changes' to update rewrite rules.</li>
            <li>Go to the <a href="<?php echo admin_url('admin.php?page=portfolio-quick-testimonial'); ?>" class="text-blue-600 hover:underline">Quick Testimonials page</a> to add testimonials.</li>
            <li>Visit your <a href="<?php echo home_url(); ?>" class="text-blue-600 hover:underline">homepage</a> to see if testimonials are now displayed.</li>
        </ol>
        
        <div class="flex space-x-4">
            <a href="<?php echo admin_url('options-permalink.php'); ?>" class="py-2 px-4 bg-gray-600 text-white rounded hover:bg-gray-700">Permalinks Settings</a>
            <a href="<?php echo admin_url('admin.php?page=portfolio-quick-testimonial'); ?>" class="py-2 px-4 bg-blue-600 text-white rounded hover:bg-blue-700">Quick Add Testimonial</a>
            <a href="<?php echo home_url(); ?>" class="py-2 px-4 bg-green-600 text-white rounded hover:bg-green-700">View Homepage</a>
        </div>
    </div>
</div>

<?php get_footer(); ?>
