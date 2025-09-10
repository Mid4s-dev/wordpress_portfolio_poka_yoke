<?php
/**
 * Testimonials Conflict Resolution
 * 
 * This file attempts to identify and remove any hooks that might be interfering
 * with the testimonial post type registration.
 */

// Include WordPress
define("WP_USE_THEMES", false);
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
    <title>Testimonials Conflict Resolution</title>
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
    <h1>Testimonials Conflict Resolution</h1>
    
    <?php
    global $wp_filter;
    
    // Trying to find conflicts in the init hook
    $init_functions = array();
    $suspicious_functions = array();
    
    if (isset($wp_filter['init']) && !empty($wp_filter['init']->callbacks)) {
        foreach ($wp_filter['init']->callbacks as $priority => $callbacks) {
            foreach ($callbacks as $cb => $callback) {
                $function_name = "";
                
                if (is_string($callback['function'])) {
                    $function_name = $callback['function'];
                } elseif (is_array($callback['function'])) {
                    if (is_object($callback['function'][0])) {
                        $function_name = get_class($callback['function'][0]) . "->" . $callback['function'][1];
                    } else {
                        $function_name = $callback['function'][0] . "::" . $callback['function'][1];
                    }
                } else {
                    $function_name = "Closure or other callable";
                }
                
                $init_functions[] = array(
                    "priority" => $priority,
                    "name" => $function_name,
                    "callback" => $callback,
                    "cb_key" => $cb
                );
                
                // Check if this might be related to testimonials
                if (strpos($function_name, "testimonial") !== false || 
                    strpos($cb, "testimonial") !== false) {
                    $suspicious_functions[] = array(
                        "priority" => $priority,
                        "name" => $function_name,
                        "cb_key" => $cb
                    );
                }
            }
        }
    }
    ?>
    
    <div class="card">
        <h2>Suspicious Functions</h2>
        <?php if (!empty($suspicious_functions)): ?>
            <p>The following functions might be related to testimonials registration:</p>
            <table border="1" cellpadding="5" style="border-collapse: collapse; width: 100%;">
                <tr>
                    <th>Priority</th>
                    <th>Function Name</th>
                    <th>Action</th>
                </tr>
                <?php foreach($suspicious_functions as $func): ?>
                <tr>
                    <td><?php echo $func["priority"]; ?></td>
                    <td><?php echo $func["name"]; ?></td>
                    <td>
                        <?php if (isset($_GET['remove']) && $_GET['remove'] == $func["cb_key"]): ?>
                            <?php 
                            // Attempt to remove the function
                            remove_action('init', $func["name"], $func["priority"]);
                            echo "<span class=\"success\">Attempted to remove function</span>";
                            ?>
                        <?php else: ?>
                            <a href="?remove=<?php echo urlencode($func["cb_key"]); ?>" class="button">Remove Function</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No suspicious functions found that might be related to testimonials.</p>
        <?php endif; ?>
    </div>
    
    <div class="card">
        <h2>Force New Registration</h2>
        
        <?php if (isset($_GET['force_register']) && $_GET['force_register'] === 'yes'): ?>
            <?php
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

            <h3>Next Steps</h3>
            <p>1. <a href="<?php echo admin_url('options-permalink.php'); ?>" class="button">Update Permalinks</a></p>
            <p>2. <a href="<?php echo admin_url('edit.php?post_type=portfolio_testimonial'); ?>" class="button">Try Accessing Testimonials Admin</a></p>
        <?php else: ?>
            <p><a href="?force_register=yes" class="button">Force Register Testimonial Post Type</a></p>
        <?php endif; ?>
    </div>
    
    <div class="card">
        <h2>All Init Hooks</h2>
        <?php if (!empty($init_functions)): ?>
            <p>Here are all functions registered on the 'init' hook:</p>
            <table border="1" cellpadding="5" style="border-collapse: collapse; width: 100%;">
                <tr>
                    <th>Priority</th>
                    <th>Function Name</th>
                </tr>
                <?php foreach($init_functions as $func): ?>
                <tr>
                    <td><?php echo $func["priority"]; ?></td>
                    <td><?php echo $func["name"]; ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No functions found on the 'init' hook.</p>
        <?php endif; ?>
    </div>
</body>
</html>