<?php
/**
 * Template Name: Testimonials Debug
 * 
 * A diagnostic template to help troubleshoot testimonial post type issues
 */

// Ensure we're in WordPress
if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Testimonials Post Type Diagnostic</h1>
    
    <div class="bg-white p-6 rounded shadow-md mb-8">
        <h2 class="text-2xl font-semibold mb-4">Post Type Registration Status</h2>
        
        <?php
        // Check if the post type is registered
        $post_types = get_post_types(array(), 'objects');
        $is_registered = isset($post_types['portfolio_testimonial']);
        ?>
        
        <div class="mb-4 p-4 <?php echo $is_registered ? 'bg-green-100' : 'bg-red-100'; ?> rounded">
            <p class="font-bold">
                <?php echo $is_registered ? '✅ Post Type IS Registered' : '❌ Post Type NOT Registered'; ?>
            </p>
        </div>
        
        <h3 class="text-xl font-semibold mb-2">All Registered Post Types:</h3>
        <div class="bg-gray-100 p-4 rounded overflow-x-auto">
            <pre><?php print_r(array_keys($post_types)); ?></pre>
        </div>
        
        <h3 class="text-xl font-semibold mt-6 mb-2">Post Type Details (if registered):</h3>
        <?php if ($is_registered): ?>
            <div class="bg-gray-100 p-4 rounded overflow-x-auto">
                <pre><?php print_r($post_types['portfolio_testimonial']); ?></pre>
            </div>
        <?php else: ?>
            <p class="text-red-500">Post type not found.</p>
        <?php endif; ?>
    </div>
    
    <div class="bg-white p-6 rounded shadow-md mb-8">
        <h2 class="text-2xl font-semibold mb-4">Fix Attempt</h2>
        
        <?php
        // Try to register the post type now
        if (!$is_registered) {
            echo '<p class="mb-4">Attempting to register post type now...</p>';
            
            function portfolio_debug_register_testimonial() {
                $args = array(
                    'labels' => array(
                        'name' => 'Debug Testimonials',
                        'singular_name' => 'Debug Testimonial'
                    ),
                    'public' => true,
                    'has_archive' => true,
                    'supports' => array('title', 'editor'),
                    'menu_icon' => 'dashicons-format-quote'
                );
                
                register_post_type('portfolio_testimonial', $args);
                
                return true;
            }
            
            $result = portfolio_debug_register_testimonial();
            
            echo '<p class="' . ($result ? 'text-green-500' : 'text-red-500') . '">';
            echo $result ? '✅ Registration attempted. Please check post types again.' : '❌ Registration failed.';
            echo '</p>';
            
            // Check if it worked
            $post_types = get_post_types(array(), 'objects');
            $now_registered = isset($post_types['portfolio_testimonial']);
            
            echo '<p class="mt-4 ' . ($now_registered ? 'text-green-500' : 'text-red-500') . '">';
            echo $now_registered ? '✅ Post type is NOW registered.' : '❌ Post type is STILL NOT registered.';
            echo '</p>';
        } else {
            echo '<p class="text-green-500">Post type is already registered. No fix needed.</p>';
        }
        ?>
    </div>
    
    <div class="bg-white p-6 rounded shadow-md mb-8">
        <h2 class="text-2xl font-semibold mb-4">Next Steps</h2>
        
        <ul class="list-disc pl-6 space-y-2">
            <li>Flush rewrite rules by going to Settings > Permalinks and clicking "Save Changes"</li>
            <li>Check that the testimonials.php and core-testimonials.php files are both being included</li>
            <li>Deactivate and reactivate the theme</li>
            <li>Check for plugin conflicts that might be affecting custom post type registration</li>
        </ul>
        
        <div class="mt-6">
            <a href="<?php echo admin_url('edit.php?post_type=portfolio_testimonial'); ?>" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                Go to Testimonials Admin Page
            </a>
        </div>
    </div>
</div>

<?php
get_footer();
?>
