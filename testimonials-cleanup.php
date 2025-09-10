<?php
/**
 * Testimonials Cleanup Tool
 * 
 * This tool helps clean up redundant testimonial files and fix testimonial post type issues
 */

// Bootstrap WordPress
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
    <title>Testimonials Cleanup Tool</title>
    <style>
        body { font-family: sans-serif; max-width: 800px; margin: 20px auto; line-height: 1.6; }
        h1, h2, h3 { color: #23282d; }
        .card { background: #fff; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04); padding: 15px; margin-bottom: 20px; }
        .success { color: green; }
        .error { color: red; }
        .warning { color: orange; }
        pre { background: #f5f5f5; padding: 10px; border: 1px solid #ddd; overflow: auto; }
        .button { display: inline-block; text-decoration: none; font-size: 13px; line-height: 2.15384615; min-height: 30px; margin: 0; padding: 0 10px; cursor: pointer; border-width: 1px; border-style: solid; -webkit-appearance: none; border-radius: 3px; white-space: nowrap; box-sizing: border-box; background: #2271b1; border-color: #2271b1; color: #fff; }
        .button:hover { background: #135e96; border-color: #135e96; color: #fff; }
        table { border-collapse: collapse; width: 100%; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        tr:nth-child(even) { background-color: #f9f9f9; }
    </style>
</head>
<body>
    <h1>Testimonials Cleanup Tool</h1>
    
    <?php
    // Define theme directory
    $theme_dir = get_template_directory();
    
    // Check post type status
    $post_type_exists = post_type_exists('portfolio_testimonial');
    
    // Display current status
    echo '<div class="card">';
    echo '<h2>Current Status</h2>';
    echo '<p class="' . ($post_type_exists ? 'success' : 'error') . '">' . 
        ($post_type_exists ? '✅ The testimonial post type IS registered.' : '❌ The testimonial post type is NOT registered.') . '</p>';
    
    // Check which files exist
    $files_to_check = array(
        'inc/testimonials-core.php' => 'Core registration file - KEEP',
        'inc/testimonials-admin.php' => 'Admin menu file - KEEP',
        'inc/testimonials-dashboard.php' => 'Dashboard functionality - KEEP',
        'inc/widgets/testimonials-widget.php' => 'Widget file - KEEP',
        'inc/testimonials.php' => 'Old testimonials class - REMOVE',
        'inc/new-testimonials.php' => 'Duplicate registration - REMOVE',
        'inc/core-testimonials.php' => 'Another duplicate - REMOVE',
        'portfolio-testimonials-core.php' => 'Root duplicate - REMOVE',
        'portfolio-testimonials-fix.php' => 'Fix file - REMOVE',
        'debug-post-types.php' => 'Debug file - REMOVE',
        'fix-testimonials.php' => 'Fix script - KEEP for now',
        'testimonials-diagnostic.php' => 'Diagnostic - REMOVE',
        'create-testimonials.php' => 'Creator - REMOVE',
        'fix-testimonials-post-type.php' => 'Fix script - REMOVE',
        'add-sample-testimonials.php' => 'Sample data - KEEP for now',
    );
    
    echo '<h3>File Status</h3>';
    echo '<table>';
    echo '<tr><th>File</th><th>Status</th><th>Recommendation</th></tr>';
    
    foreach ($files_to_check as $file => $description) {
        $file_path = $theme_dir . '/' . $file;
        $exists = file_exists($file_path);
        
        $status_class = $exists ? 'success' : 'warning';
        $status_text = $exists ? 'Found' : 'Not found';
        
        $action = (strpos($description, 'KEEP') !== false) ? 
            '<span class="success">Keep</span>' : 
            '<span class="error">Remove</span>';
        
        echo '<tr>';
        echo '<td>' . esc_html($file) . '</td>';
        echo '<td class="' . $status_class . '">' . $status_text . '</td>';
        echo '<td>' . $action . ' - ' . esc_html(str_replace(' - KEEP', '', str_replace(' - REMOVE', '', $description))) . '</td>';
        echo '</tr>';
    }
    
    echo '</table>';
    echo '</div>';
    
    // Process cleanup if requested
    if (isset($_GET['action']) && $_GET['action'] === 'cleanup') {
        echo '<div class="card">';
        echo '<h2>Cleanup Results</h2>';
        
        // Files to remove
        $files_to_remove = array(
            $theme_dir . '/inc/testimonials.php',
            $theme_dir . '/inc/new-testimonials.php',
            $theme_dir . '/inc/core-testimonials.php',
            $theme_dir . '/portfolio-testimonials-core.php',
            $theme_dir . '/portfolio-testimonials-fix.php',
            $theme_dir . '/debug-post-types.php',
            $theme_dir . '/testimonials-diagnostic.php',
            $theme_dir . '/create-testimonials.php',
            $theme_dir . '/fix-testimonials-post-type.php',
        );
        
        // Create backups directory
        $backup_dir = $theme_dir . '/backups/' . date('Ymd');
        if (!is_dir($backup_dir)) {
            mkdir($backup_dir, 0755, true);
        }
        
        // First create backups of files we're going to remove
        foreach ($files_to_remove as $file) {
            if (file_exists($file)) {
                $backup_file = $backup_dir . '/' . basename($file) . '.bak';
                if (copy($file, $backup_file)) {
                    echo '<p class="success">✅ Backed up: ' . esc_html(basename($file)) . '</p>';
                } else {
                    echo '<p class="error">❌ Failed to backup: ' . esc_html(basename($file)) . '</p>';
                }
            }
        }
        
        // Now remove the files
        foreach ($files_to_remove as $file) {
            if (file_exists($file)) {
                if (@unlink($file)) {
                    echo '<p class="success">✅ Removed: ' . esc_html(basename($file)) . '</p>';
                } else {
                    echo '<p class="error">❌ Failed to remove: ' . esc_html(basename($file)) . '</p>';
                }
            }
        }
        
        // Flush rewrite rules
        flush_rewrite_rules(true);
        echo '<p class="success">✅ Flushed rewrite rules.</p>';
        
        echo '<p>Backup created in: <code>' . esc_html($backup_dir) . '</code></p>';
        echo '</div>';
    }
    
    // Function to check for custom meta keys in the database
    function check_testimonial_meta_keys() {
        global $wpdb;
        
        $testimonial_meta_keys = $wpdb->get_col(
            $wpdb->prepare(
                "SELECT DISTINCT meta_key FROM {$wpdb->postmeta} pm
                 JOIN {$wpdb->posts} p ON pm.post_id = p.ID
                 WHERE p.post_type = %s
                 AND meta_key LIKE %s
                 ORDER BY meta_key",
                'portfolio_testimonial',
                '\_%'
            )
        );
        
        return $testimonial_meta_keys;
    }
    
    // Display meta fields analysis
    $meta_keys = check_testimonial_meta_keys();
    
    echo '<div class="card">';
    echo '<h2>Testimonial Meta Fields Analysis</h2>';
    
    if (empty($meta_keys)) {
        echo '<p>No testimonial meta keys found in the database.</p>';
    } else {
        echo '<p>The following meta keys are being used for testimonials:</p>';
        echo '<ul>';
        foreach ($meta_keys as $key) {
            echo '<li><code>' . esc_html($key) . '</code></li>';
        }
        echo '</ul>';
        
        // Check for inconsistencies
        $client_name_keys = array_filter($meta_keys, function($key) {
            return strpos($key, '_client_name') !== false;
        });
        
        if (count($client_name_keys) > 1) {
            echo '<p class="warning">⚠️ Warning: Multiple client name meta keys detected. This may cause data inconsistency.</p>';
        }
    }
    echo '</div>';
    
    // Display action buttons
    echo '<div class="card">';
    echo '<h2>Available Actions</h2>';
    echo '<p><a href="?action=cleanup" class="button" onclick="return confirm(\'This will permanently remove redundant testimonial files. Backups will be created, but proceed with caution. Continue?\');">Clean Up Redundant Files</a></p>';
    echo '<p><a href="' . admin_url('options-permalink.php') . '" class="button">Update Permalinks</a></p>';
    echo '<p><a href="' . admin_url('edit.php?post_type=portfolio_testimonial') . '" class="button">Go to Testimonials</a></p>';
    echo '</div>';
    
    // Display functions.php status
    echo '<div class="card">';
    echo '<h2>functions.php Analysis</h2>';
    
    $functions_php = file_get_contents($theme_dir . '/functions.php');
    
    // Check for correct include of testimonials-core.php
    $has_core_include = strpos($functions_php, "require_once get_template_directory() . '/inc/testimonials-core.php'") !== false || 
                      strpos($functions_php, "require get_template_directory() . '/inc/testimonials-core.php'") !== false ||
                      strpos($functions_php, "include get_template_directory() . '/inc/testimonials-core.php'") !== false ||
                      strpos($functions_php, "include_once get_template_directory() . '/inc/testimonials-core.php'") !== false;
    
    // Check for multiple registrations
    $redundant_includes = array(
        '/inc/testimonials.php',
        '/inc/new-testimonials.php',
        '/inc/core-testimonials.php',
        '/portfolio-testimonials-core.php'
    );
    
    $found_redundant = false;
    foreach ($redundant_includes as $file) {
        if (strpos($functions_php, $file) !== false) {
            $found_redundant = true;
            break;
        }
    }
    
    if ($has_core_include) {
        echo '<p class="success">✅ functions.php correctly includes testimonials-core.php</p>';
    } else {
        echo '<p class="error">❌ functions.php does not seem to include testimonials-core.php correctly</p>';
    }
    
    if ($found_redundant) {
        echo '<p class="warning">⚠️ Warning: functions.php contains references to redundant testimonial files.</p>';
    } else {
        echo '<p class="success">✅ No redundant testimonial includes found in functions.php</p>';
    }
    
    echo '</div>';
    
    // Summary and next steps
    echo '<div class="card">';
    echo '<h2>Summary and Next Steps</h2>';
    echo '<ol>';
    echo '<li>Run the "Clean Up Redundant Files" action above</li>';
    echo '<li>Visit Settings > Permalinks and click "Save Changes" to refresh rewrite rules</li>';
    echo '<li>Visit Testimonials in the admin menu to verify everything is working</li>';
    echo '<li>If there are still issues, check the functions.php file for duplicate includes</li>';
    echo '</ol>';
    echo '</div>';
    ?>
    
</body>
</html>
<?php
// End of script
