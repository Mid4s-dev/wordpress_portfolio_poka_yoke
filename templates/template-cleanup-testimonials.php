<?php
/**
 * Template Name: Clean Testimonials
 * 
 * This template cleans up old testimonial files and helps fix registration issues
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Testimonials Cleanup</h1>
    
    <div class="bg-white p-6 rounded shadow-md mb-6">
        <h2 class="text-2xl font-bold mb-4">Current Status</h2>
        
        <?php
        // Check if the post type is registered
        $post_type_exists = post_type_exists('portfolio_testimonial');
        ?>
        
        <p class="<?php echo $post_type_exists ? 'text-green-500' : 'text-red-500'; ?>">
            <?php echo $post_type_exists ? '✅ Testimonial post type IS registered' : '❌ Testimonial post type is NOT registered'; ?>
        </p>
        
        <?php
        // Check which files exist
        $theme_dir = get_template_directory();
        $files = array(
            'testimonials.php' => $theme_dir . '/inc/testimonials.php',
            'new-testimonials.php' => $theme_dir . '/inc/new-testimonials.php',
            'core-testimonials.php' => $theme_dir . '/inc/core-testimonials.php',
            'testimonials-dashboard.php' => $theme_dir . '/inc/testimonials-dashboard.php',
            'testimonials-fix.php' => $theme_dir . '/portfolio-testimonials-fix.php',
        );
        
        echo '<h3 class="text-xl font-bold mt-4 mb-2">Files Check</h3>';
        echo '<ul class="list-disc pl-5">';
        foreach ($files as $name => $path) {
            $exists = file_exists($path);
            echo '<li class="' . ($exists ? 'text-green-500' : 'text-red-500') . '">';
            echo $name . ': ' . ($exists ? 'Exists' : 'Not Found');
            echo '</li>';
        }
        echo '</ul>';
        ?>
    </div>
    
    <?php if (current_user_can('manage_options') && isset($_POST['action']) && $_POST['action'] === 'cleanup'): ?>
        <div class="bg-white p-6 rounded shadow-md mb-6">
            <h2 class="text-2xl font-bold mb-4">Cleanup Results</h2>
            
            <?php
            // Validate nonce
            if (wp_verify_nonce($_POST['testimonials_cleanup_nonce'], 'testimonials_cleanup')) {
                // Backup functions.php first
                $functions_file = $theme_dir . '/functions.php';
                $functions_backup = $theme_dir . '/functions.php.cleanup-backup';
                if (file_exists($functions_file) && !file_exists($functions_backup)) {
                    copy($functions_file, $functions_backup);
                    echo '<p class="text-green-500">✅ Created backup of functions.php</p>';
                }
                
                // Update functions.php to use only new-testimonials.php
                if (file_exists($functions_file)) {
                    $functions_content = file_get_contents($functions_file);
                    
                    // Remove core-testimonials.php include
                    $functions_content = preg_replace('/require_once get_template_directory\(\) \. \'\/inc\/core-testimonials\.php\';/', '// Removed core-testimonials.php include', $functions_content);
                    
                    // Replace testimonials.php with new-testimonials.php
                    $functions_content = str_replace(
                        "require_once get_template_directory() . '/inc/testimonials.php';",
                        "require_once get_template_directory() . '/inc/new-testimonials.php';",
                        $functions_content
                    );
                    
                    // Write updated content
                    file_put_contents($functions_file, $functions_content);
                    echo '<p class="text-green-500">✅ Updated functions.php to use new-testimonials.php</p>';
                }
                
                // Flush rewrite rules
                flush_rewrite_rules(true);
                echo '<p class="text-green-500">✅ Flushed rewrite rules</p>';
                
                echo '<p class="font-bold mt-4">Cleanup completed successfully!</p>';
            } else {
                echo '<p class="text-red-500">❌ Invalid nonce verification. Please try again.</p>';
            }
            ?>
        </div>
    <?php endif; ?>
    
    <?php if (current_user_can('manage_options')): ?>
        <div class="bg-white p-6 rounded shadow-md">
            <h2 class="text-2xl font-bold mb-4">Cleanup Options</h2>
            
            <form method="post" action="">
                <?php wp_nonce_field('testimonials_cleanup', 'testimonials_cleanup_nonce'); ?>
                <input type="hidden" name="action" value="cleanup">
                
                <p class="mb-4">This will perform the following actions:</p>
                <ul class="list-disc pl-5 mb-6">
                    <li>Update functions.php to use only the new testimonials file</li>
                    <li>Flush rewrite rules</li>
                </ul>
                
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    Run Cleanup
                </button>
            </form>
            
            <div class="mt-8">
                <h3 class="text-xl font-bold mb-2">Other Actions</h3>
                <a href="<?php echo admin_url('options-permalink.php'); ?>" class="inline-block bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded mr-2">
                    Flush Permalinks
                </a>
                <a href="<?php echo admin_url('post-new.php?post_type=portfolio_testimonial'); ?>" class="inline-block bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                    Add New Testimonial
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="bg-red-100 p-6 rounded shadow-md">
            <p>You need to be an administrator to use this tool.</p>
        </div>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
