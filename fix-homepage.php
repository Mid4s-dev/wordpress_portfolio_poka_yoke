<?php
/**
 * Fix Portfolio Homepage
 *
 * This file helps restore the default homepage settings.
 * Upload to your theme directory and access via your-site.com/wp-content/themes/portfolio/fix-homepage.php
 * DELETE THIS FILE AFTER USING IT!
 */

// Load WordPress with minimal setup
define('WP_USE_THEMES', false);
require_once('../../../../wp-load.php');

// Security check - only site administrators can access
if (!current_user_can('manage_options')) {
    wp_die('You need administrator privileges to access this page.');
}

// Check if we need to reset homepage settings
$reset = isset($_GET['reset']) && $_GET['reset'] === '1';

// Get current reading settings
$show_on_front = get_option('show_on_front');
$page_on_front = get_option('page_on_front');
$page_for_posts = get_option('page_for_posts');

// Find homepage candidates
$homepage_candidates = get_pages(array(
    'meta_key' => '_wp_page_template',
    'meta_value' => 'templates/template-home.php'
));

// Check if a home page exists with template-home.php
$home_page = null;
if (!empty($homepage_candidates)) {
    $home_page = $homepage_candidates[0];
}

// Find existing "Home" page regardless of template
if (!$home_page) {
    $home_pages = get_pages(array(
        'title' => 'Home'
    ));
    
    if (!empty($home_pages)) {
        $home_page = $home_pages[0];
    }
}

// If reset is triggered, update settings
$message = '';
if ($reset) {
    if ($home_page) {
        // Update reading settings to use this page as homepage
        update_option('show_on_front', 'page');
        update_option('page_on_front', $home_page->ID);
        
        // Set template to template-home.php if not already
        $current_template = get_post_meta($home_page->ID, '_wp_page_template', true);
        if ($current_template !== 'templates/template-home.php') {
            update_post_meta($home_page->ID, '_wp_page_template', 'templates/template-home.php');
        }
        
        $message = 'Homepage settings have been updated! Your homepage is now set to: "' . $home_page->post_title . '"';
    } else {
        // Create a new page
        $home_page_id = wp_insert_post(array(
            'post_title' => 'Home',
            'post_content' => 'Welcome to my portfolio site.',
            'post_status' => 'publish',
            'post_type' => 'page',
        ));
        
        if ($home_page_id) {
            // Set the template
            update_post_meta($home_page_id, '_wp_page_template', 'templates/template-home.php');
            
            // Update reading settings
            update_option('show_on_front', 'page');
            update_option('page_on_front', $home_page_id);
            
            $message = 'A new Home page has been created and set as your homepage!';
        } else {
            $message = 'Error: Failed to create a new homepage.';
        }
    }
}

// Get updated settings if we made changes
if ($reset) {
    $show_on_front = get_option('show_on_front');
    $page_on_front = get_option('page_on_front');
    $page_for_posts = get_option('page_for_posts');
    
    if ($page_on_front) {
        $front_page = get_post($page_on_front);
    }
}

// Page HTML output
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fix Portfolio Homepage</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .info-box {
            background: #f8f9fa;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #f2f2f2;
        }
        .button {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 10px;
        }
        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Fix Portfolio Homepage</h1>
    
    <?php if ($message): ?>
        <div class="info-box success">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
    
    <div class="info-box">
        <h2>Current Reading Settings</h2>
        <p><strong>Homepage displays:</strong> <?php echo $show_on_front === 'page' ? 'A static page' : 'Latest posts'; ?></p>
        <?php if ($show_on_front === 'page' && $page_on_front): ?>
            <p><strong>Homepage:</strong> "<?php echo get_the_title($page_on_front); ?>" (ID: <?php echo $page_on_front; ?>)</p>
            <p><strong>Template:</strong> <?php echo get_post_meta($page_on_front, '_wp_page_template', true) ?: 'default'; ?></p>
        <?php endif; ?>
        <?php if ($show_on_front === 'page' && $page_for_posts): ?>
            <p><strong>Posts page:</strong> "<?php echo get_the_title($page_for_posts); ?>" (ID: <?php echo $page_for_posts; ?>)</p>
        <?php endif; ?>
    </div>
    
    <h2>Available Pages</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Template</th>
        </tr>
        <?php 
        $pages = get_pages();
        foreach ($pages as $page): 
            $template = get_post_meta($page->ID, '_wp_page_template', true) ?: 'default';
            $is_front = ($page->ID == $page_on_front);
        ?>
            <tr <?php echo $is_front ? 'style="background-color: #ffffcc;"' : ''; ?>>
                <td><?php echo $page->ID; ?></td>
                <td><?php echo $page->post_title; ?> <?php echo $is_front ? '(Current Homepage)' : ''; ?></td>
                <td><?php echo $template; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    
    <div class="info-box">
        <h2>About Your Portfolio Theme</h2>
        <p>Your portfolio theme has several ways to display the homepage:</p>
        <ol>
            <li><strong>front-page.php:</strong> This file is automatically used as your homepage regardless of WordPress settings.</li>
            <li><strong>template-home.php:</strong> A custom template that can be assigned to any page and includes your portfolio sections.</li>
        </ol>
        <p>To ensure your portfolio displays correctly, click the button below to:</p>
        <ul>
            <li>Set your homepage to display a static page (not latest posts)</li>
            <li>Set an existing "Home" page as your homepage OR create one if it doesn't exist</li>
            <li>Ensure the home page uses the Portfolio Home template</li>
        </ul>
        
        <?php if (!$reset): ?>
            <a href="?reset=1" class="button">Fix Homepage Settings</a>
        <?php else: ?>
            <p><strong>Settings have been updated!</strong> You can now <a href="<?php echo home_url(); ?>">visit your homepage</a> to verify it's displaying correctly.</p>
        <?php endif; ?>
    </div>
    
    <p><strong>Important:</strong> Delete this file after using it for security reasons!</p>
</body>
</html>
