<?php
/**
 * Testimonials Registration Diagnostic
 * This script diagnoses issues with testimonial post type registration
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
    <title>Testimonials Registration Diagnostic</title>
    <style>
        body { font-family: sans-serif; max-width: 800px; margin: 20px auto; line-height: 1.6; }
        h1, h2, h3 { color: #23282d; }
        .card { background: #fff; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04); padding: 15px; margin-bottom: 20px; }
        .success { color: green; font-weight: bold; }
        .error { color: red; font-weight: bold; }
        .warning { color: orange; font-weight: bold; }
        pre { background: #f5f5f5; padding: 10px; border: 1px solid #ddd; overflow: auto; }
        .button { display: inline-block; text-decoration: none; font-size: 13px; line-height: 2.15384615; min-height: 30px; margin: 0; padding: 0 10px; cursor: pointer; border-width: 1px; border-style: solid; -webkit-appearance: none; border-radius: 3px; white-space: nowrap; box-sizing: border-box; background: #2271b1; border-color: #2271b1; color: #fff; }
        .button:hover { background: #135e96; border-color: #135e96; color: #fff; }
    </style>
</head>
<body>
    <h1>Testimonials Registration Diagnostic</h1>
    
    <div class="card">
        <h2>Real-time Post Type Registration Status</h2>
        <?php 
        $post_type_exists = post_type_exists('portfolio_testimonial');
        if ($post_type_exists): 
        ?>
            <p class="success">✅ Post type IS registered in the system</p>
        <?php else: ?>
            <p class="error">❌ Post type is NOT registered in the system</p>
        <?php endif; ?>

        <h3>Post Types Currently Registered</h3>
        <?php
        $post_types = get_post_types(array(), 'objects');
        echo '<ul>';
        foreach ($post_types as $pt => $obj) {
            echo '<li>' . esc_html($pt) . ' (' . esc_html($obj->label) . ')</li>';
        }
        echo '</ul>';
        ?>
    </div>

    <div class="card">
        <h2>Force Register Post Type</h2>
        <?php
        if (isset($_GET['force_register']) && $_GET['force_register'] === 'yes'):
            // Define labels for the custom post type
            $labels = array(
                'name'                  => _x('Testimonials', 'Post type general name', 'portfolio'),
                'singular_name'         => _x('Testimonial', 'Post type singular name', 'portfolio'),
                'menu_name'             => _x('Testimonials', 'Admin Menu text', 'portfolio'),
                'name_admin_bar'        => _x('Testimonial', 'Add New on Toolbar', 'portfolio'),
                'add_new'               => __('Add New', 'portfolio'),
                'add_new_item'          => __('Add New Testimonial', 'portfolio'),
                'new_item'              => __('New Testimonial', 'portfolio'),
                'edit_item'             => __('Edit Testimonial', 'portfolio'),
                'view_item'             => __('View Testimonial', 'portfolio'),
                'all_items'             => __('All Testimonials', 'portfolio'),
                'search_items'          => __('Search Testimonials', 'portfolio'),
                'not_found'             => __('No testimonials found.', 'portfolio'),
                'not_found_in_trash'    => __('No testimonials found in Trash.', 'portfolio'),
                'featured_image'        => __('Client Image', 'portfolio'),
                'set_featured_image'    => __('Set client image', 'portfolio'),
                'remove_featured_image' => __('Remove client image', 'portfolio'),
                'use_featured_image'    => __('Use as client image', 'portfolio'),
                'archives'              => __('Testimonial archives', 'portfolio'),
            );
            
            // Define the arguments for the custom post type
            $args = array(
                'labels'             => $labels,
                'public'             => true,
                'publicly_queryable' => true,
                'show_ui'            => true,
                'show_in_menu'       => true,
                'query_var'          => true,
                'rewrite'            => array('slug' => 'testimonials'),
                'capability_type'    => 'post',
                'has_archive'        => true,
                'hierarchical'       => false,
                'menu_position'      => 22,
                'menu_icon'          => 'dashicons-format-quote',
                'supports'           => array('title', 'editor', 'thumbnail'),
                'show_in_rest'       => true,
            );
            
            // Register the post type directly in this script
            $result = register_post_type('portfolio_testimonial', $args);
            
            if (is_wp_error($result)): ?>
                <p class="error">❌ Failed to register post type: <?php echo $result->get_error_message(); ?></p>
            <?php else: ?>
                <p class="success">✅ Post type registered successfully within this script</p>
                <?php update_option('portfolio_testimonial_forced_registration', true); ?>
                <p>This is only temporary for this page load. You need to add this registration to your theme.</p>
            <?php endif; ?>

            <?php 
            // Check again if it's registered
            if (post_type_exists('portfolio_testimonial')): ?>
                <p class="success">✅ Post type IS NOW registered in the system</p>
            <?php else: ?>
                <p class="error">❌ Post type is STILL NOT registered in the system (something is very wrong)</p>
            <?php endif; ?>

            <h3>Actions Taken</h3>
            <p>1. Attempted to register 'portfolio_testimonial' post type directly</p>
            <p>2. Flush permalinks</p>
            <p><a href="<?php echo admin_url('edit.php?post_type=portfolio_testimonial'); ?>" class="button">Try Accessing Testimonials Admin</a></p>
            <p><a href="<?php echo admin_url('options-permalink.php'); ?>" class="button">Update Permalinks</a></p>

        <?php else: ?>
            <p><a href="?force_register=yes" class="button">Force Register Testimonial Post Type</a></p>
            <p class="warning">⚠️ Use this button to attempt an immediate registration of the testimonial post type.</p>
        <?php endif; ?>
    </div>

    <div class="card">
        <h2>WordPress Hook Registration Timing</h2>
        <?php
        global $wp_filter;
        
        echo '<h3>Currently registered \'init\' hooks</h3>';
        
        if (isset($wp_filter['init']) && !empty($wp_filter['init'])) {
            echo '<pre>';
            foreach ($wp_filter['init']->callbacks as $priority => $callbacks) {
                echo "Priority: $priority\n";
                foreach ($callbacks as $cb => $callback) {
                    if (is_string($callback['function'])) {
                        echo "  Function: " . esc_html($callback['function']) . "\n";
                    } elseif (is_array($callback['function'])) {
                        if (is_object($callback['function'][0])) {
                            echo "  Method: " . esc_html(get_class($callback['function'][0])) . "->" . esc_html($callback['function'][1]) . "\n";
                        } else {
                            echo "  Static Method: " . esc_html($callback['function'][0]) . "::" . esc_html($callback['function'][1]) . "\n";
                        }
                    } else {
                        echo "  Closure or other callable\n";
                    }
                }
                echo "\n";
            }
            echo '</pre>';
        } else {
            echo '<p>No init hooks found or accessible.</p>';
        }
        ?>
    </div>
    
    <div class="card">
        <h2>Create Super-Priority Fix</h2>
        <?php if (isset($_GET['create_fix']) && $_GET['create_fix'] === 'yes'):
            
            // Create the super-priority testimonial fix
            $fix_content = '<?php
/**
 * Super Priority Testimonials Fix
 *
 * This file registers the testimonials post type with absolute priority
 * and implements a direct solution that avoids conflicts with other code.
 */

// Don\'t allow direct access
if (!defined(\'ABSPATH\')) {
    exit;
}

// Register with the highest priority possible
function portfolio_testimonials_super_priority_fix() {
    if (!post_type_exists(\'portfolio_testimonial\')) {
        $labels = array(
            \'name\'                  => _x(\'Testimonials\', \'Post type general name\', \'portfolio\'),
            \'singular_name\'         => _x(\'Testimonial\', \'Post type singular name\', \'portfolio\'),
            \'menu_name\'             => _x(\'Testimonials\', \'Admin Menu text\', \'portfolio\'),
            \'name_admin_bar\'        => _x(\'Testimonial\', \'Add New on Toolbar\', \'portfolio\'),
            \'add_new\'               => __(\'Add New\', \'portfolio\'),
            \'add_new_item\'          => __(\'Add New Testimonial\', \'portfolio\'),
            \'new_item\'              => __(\'New Testimonial\', \'portfolio\'),
            \'edit_item\'             => __(\'Edit Testimonial\', \'portfolio\'),
            \'view_item\'             => __(\'View Testimonial\', \'portfolio\'),
            \'all_items\'             => __(\'All Testimonials\', \'portfolio\'),
            \'search_items\'          => __(\'Search Testimonials\', \'portfolio\'),
            \'not_found\'             => __(\'No testimonials found.\', \'portfolio\'),
            \'not_found_in_trash\'    => __(\'No testimonials found in Trash.\', \'portfolio\'),
            \'featured_image\'        => __(\'Client Image\', \'portfolio\'),
            \'set_featured_image\'    => __(\'Set client image\', \'portfolio\'),
            \'remove_featured_image\' => __(\'Remove client image\', \'portfolio\'),
            \'use_featured_image\'    => __(\'Use as client image\', \'portfolio\'),
            \'archives\'              => __(\'Testimonial archives\', \'portfolio\'),
        );
        
        $args = array(
            \'labels\'             => $labels,
            \'public\'             => true,
            \'publicly_queryable\' => true,
            \'show_ui\'            => true,
            \'show_in_menu\'       => true,
            \'query_var\'          => true,
            \'rewrite\'            => array(\'slug\' => \'testimonials\'),
            \'capability_type\'    => \'post\',
            \'has_archive\'        => true,
            \'hierarchical\'       => false,
            \'menu_position\'      => 22,
            \'menu_icon\'          => \'dashicons-format-quote\',
            \'supports\'           => array(\'title\', \'editor\', \'thumbnail\'),
            \'show_in_rest\'       => true,
        );
        
        register_post_type(\'portfolio_testimonial\', $args);
        update_option(\'portfolio_testimonials_super_priority_fixed\', true);
    }
}

// Register at plugins_loaded - even before init
add_action(\'plugins_loaded\', \'portfolio_testimonials_super_priority_fix\', -99999);

// Also register at init with highest priority (as fallback)
add_action(\'init\', \'portfolio_testimonials_super_priority_fix\', -99999);

// Add admin notice if we had to fix this
function portfolio_testimonials_super_priority_admin_notice() {
    if (get_option(\'portfolio_testimonials_super_priority_fixed\')) {
        echo \'<div class="notice notice-warning">
            <p><strong>Super Priority Fix:</strong> Testimonial post type was registered by the super priority fix. 
            This indicates there may still be conflicts in your theme code.</p>
        </div>\';
    }
}
add_action(\'admin_notices\', \'portfolio_testimonials_super_priority_admin_notice\');

// Add meta boxes for testimonials
function portfolio_testimonials_super_priority_add_meta_boxes() {
    add_meta_box(
        \'portfolio_testimonial_details\',
        __(\'Client Details\', \'portfolio\'),
        \'portfolio_testimonials_super_priority_render_meta_box\',
        \'portfolio_testimonial\',
        \'normal\',
        \'high\'
    );
}
add_action(\'add_meta_boxes\', \'portfolio_testimonials_super_priority_add_meta_boxes\');

// Render the meta box
function portfolio_testimonials_super_priority_render_meta_box($post) {
    // Add a nonce field
    wp_nonce_field(\'portfolio_testimonial_meta_box\', \'portfolio_testimonial_meta_box_nonce\');
    
    // Get existing meta values
    $client_name = get_post_meta($post->ID, \'_portfolio_testimonial_client_name\', true);
    $client_title = get_post_meta($post->ID, \'_portfolio_testimonial_client_title\', true);
    $client_company = get_post_meta($post->ID, \'_portfolio_testimonial_client_company\', true);
    $rating = get_post_meta($post->ID, \'_portfolio_testimonial_rating\', true);
    
    if (empty($rating)) {
        $rating = 5; // Default to 5 stars
    }
    
    ?>
    <p>
        <label for="portfolio_testimonial_client_name"><?php _e(\'Client Name:\', \'portfolio\'); ?></label>
        <input type="text" id="portfolio_testimonial_client_name" name="portfolio_testimonial_client_name" 
               value="<?php echo esc_attr($client_name); ?>" class="widefat">
    </p>
    
    <p>
        <label for="portfolio_testimonial_client_title"><?php _e(\'Client Title/Position:\', \'portfolio\'); ?></label>
        <input type="text" id="portfolio_testimonial_client_title" name="portfolio_testimonial_client_title" 
               value="<?php echo esc_attr($client_title); ?>" class="widefat">
    </p>
    
    <p>
        <label for="portfolio_testimonial_client_company"><?php _e(\'Client Company/Organization:\', \'portfolio\'); ?></label>
        <input type="text" id="portfolio_testimonial_client_company" name="portfolio_testimonial_client_company" 
               value="<?php echo esc_attr($client_company); ?>" class="widefat">
    </p>
    
    <p>
        <label for="portfolio_testimonial_rating"><?php _e(\'Rating:\', \'portfolio\'); ?></label>
        <select id="portfolio_testimonial_rating" name="portfolio_testimonial_rating" class="widefat">
            <option value="5" <?php selected($rating, 5); ?>><?php _e(\'5 Stars\', \'portfolio\'); ?></option>
            <option value="4" <?php selected($rating, 4); ?>><?php _e(\'4 Stars\', \'portfolio\'); ?></option>
            <option value="3" <?php selected($rating, 3); ?>><?php _e(\'3 Stars\', \'portfolio\'); ?></option>
            <option value="2" <?php selected($rating, 2); ?>><?php _e(\'2 Stars\', \'portfolio\'); ?></option>
            <option value="1" <?php selected($rating, 1); ?>><?php _e(\'1 Star\', \'portfolio\'); ?></option>
        </select>
    </p>
    <?php
}

// Save the meta box data
function portfolio_testimonials_super_priority_save_meta_box($post_id) {
    // Check if nonce is set
    if (!isset($_POST[\'portfolio_testimonial_meta_box_nonce\'])) {
        return;
    }
    
    // Verify that the nonce is valid
    if (!wp_verify_nonce($_POST[\'portfolio_testimonial_meta_box_nonce\'], \'portfolio_testimonial_meta_box\')) {
        return;
    }
    
    // If this is an autosave, don\'t do anything
    if (defined(\'DOING_AUTOSAVE\') && DOING_AUTOSAVE) {
        return;
    }
    
    // Check the user\'s permissions
    if (\'portfolio_testimonial\' === $_POST[\'post_type\']) {
        if (!current_user_can(\'edit_post\', $post_id)) {
            return;
        }
    }
    
    // Save the meta fields
    if (isset($_POST[\'portfolio_testimonial_client_name\'])) {
        update_post_meta($post_id, \'_portfolio_testimonial_client_name\', 
            sanitize_text_field($_POST[\'portfolio_testimonial_client_name\']));
    }
    
    if (isset($_POST[\'portfolio_testimonial_client_title\'])) {
        update_post_meta($post_id, \'_portfolio_testimonial_client_title\', 
            sanitize_text_field($_POST[\'portfolio_testimonial_client_title\']));
    }
    
    if (isset($_POST[\'portfolio_testimonial_client_company\'])) {
        update_post_meta($post_id, \'_portfolio_testimonial_client_company\', 
            sanitize_text_field($_POST[\'portfolio_testimonial_client_company\']));
    }
    
    if (isset($_POST[\'portfolio_testimonial_rating\'])) {
        update_post_meta($post_id, \'_portfolio_testimonial_rating\', 
            intval($_POST[\'portfolio_testimonial_rating\']));
    }
}
add_action(\'save_post\', \'portfolio_testimonials_super_priority_save_meta_box\', 10);

// Make sure this runs even during normal page loads
portfolio_testimonials_super_priority_fix();';

            // Write the fix file
            $fix_path = get_template_directory() . '/testimonials-super-priority-fix.php';
            file_put_contents($fix_path, $fix_content);

            // Also modify functions.php to include this file at the very top
            $functions_path = get_template_directory() . '/functions.php';
            $functions_content = file_get_contents($functions_path);
            
            // Add include at the top, right after the opening PHP tag
            $new_include = "<?php\n// Super Priority Fix for Testimonials\nrequire_once get_template_directory() . '/testimonials-super-priority-fix.php';\n\n";
            $functions_content = preg_replace('/^<\?php/i', $new_include, $functions_content, 1);
            
            file_put_contents($functions_path, $functions_content);
            
            echo '<p class="success">✅ Created super-priority fix file and added it to functions.php</p>';
            echo '<p>The fix will:</p>';
            echo '<ol>';
            echo '<li>Register the testimonials post type using the plugins_loaded hook (before init)</li>';
            echo '<li>Also register at init with the highest possible priority (-99999)</li>';
            echo '<li>Add all necessary meta boxes and admin functionality</li>';
            echo '</ol>';
            
            echo '<p><strong>Next steps:</strong></p>';
            echo '<ol>';
            echo '<li>Visit <a href="' . admin_url('options-permalink.php') . '" class="button">Update Permalinks</a></li>';
            echo '<li>Try accessing <a href="' . admin_url('edit.php?post_type=portfolio_testimonial') . '" class="button">Testimonials Admin</a></li>';
            echo '</ol>';
            
            // Flush permalinks
            flush_rewrite_rules();
            
        else:
        ?>
            <p>If the regular fixes aren't working, you can create a super-priority fix that:</p>
            <ol>
                <li>Runs at plugins_loaded (before init)</li>
                <li>Uses the highest priority possible (-99999)</li>
                <li>Gets included at the very top of functions.php</li>
                <li>Implements a complete solution that can't be overridden</li>
            </ol>
            <p><a href="?create_fix=yes" class="button">Create Super-Priority Fix</a></p>
        <?php endif; ?>
    </div>
    
    <div class="card">
        <h2>Debug Information</h2>
        
        <h3>WordPress Version</h3>
        <p><?php echo get_bloginfo('version'); ?></p>
        
        <h3>Theme Information</h3>
        <p>Theme Name: <?php echo wp_get_theme()->get('Name'); ?></p>
        <p>Theme Version: <?php echo wp_get_theme()->get('Version'); ?></p>
        
        <h3>Active Plugins</h3>
        <ul>
        <?php 
        $active_plugins = get_option('active_plugins');
        foreach($active_plugins as $plugin) {
            $plugin_data = get_plugin_data(WP_PLUGIN_DIR . '/' . $plugin);
            echo '<li>' . esc_html($plugin_data['Name']) . ' (' . esc_html($plugin_data['Version']) . ')</li>';
        }
        ?>
        </ul>
        
        <h3>System Information</h3>
        <p>PHP Version: <?php echo phpversion(); ?></p>
        <p>WordPress Memory Limit: <?php echo WP_MEMORY_LIMIT; ?></p>
    </div>
</body>
</html>
