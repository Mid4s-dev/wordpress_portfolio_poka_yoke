<?php
/**
 * Template Name: Reset Homepage
 *
 * This template allows resetting the homepage settings
 */

// Security check
if (!current_user_can('manage_options')) {
    wp_die('You do not have sufficient permissions to access this page.');
}

// Process form submission
$message = '';
if (isset($_POST['action']) && $_POST['action'] === 'reset_homepage') {
    // Update homepage settings
    update_option('show_on_front', 'page');
    
    // If home page ID is provided
    if (!empty($_POST['home_page_id'])) {
        update_option('page_on_front', absint($_POST['home_page_id']));
    }
    
    // If blog page ID is provided
    if (!empty($_POST['blog_page_id'])) {
        update_option('page_for_posts', absint($_POST['blog_page_id']));
    }
    
    $message = 'Homepage settings updated successfully!';
}

get_header();
?>

<main id="primary" class="site-main">
    <div class="container mx-auto px-4 py-12">
        <h1 class="text-3xl font-bold mb-8">Reset Homepage Settings</h1>
        
        <?php if ($message): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <?php echo esc_html($message); ?>
            </div>
        <?php endif; ?>
        
        <div class="bg-white p-6 rounded shadow-md">
            <h2 class="text-xl font-semibold mb-4">Current Settings</h2>
            <div class="mb-6 bg-gray-50 p-4 rounded">
                <p><strong>Show on front:</strong> <?php echo esc_html(get_option('show_on_front')); ?></p>
                <p><strong>Page on front ID:</strong> <?php echo esc_html(get_option('page_on_front')); ?></p>
                <p><strong>Page for posts ID:</strong> <?php echo esc_html(get_option('page_for_posts')); ?></p>
            </div>
            
            <h2 class="text-xl font-semibold mb-4">Reset Settings</h2>
            <form method="post">
                <div class="mb-4">
                    <label for="home_page_id" class="block mb-2 font-medium">Home Page</label>
                    <select name="home_page_id" id="home_page_id" class="w-full border border-gray-300 rounded px-3 py-2">
                        <option value="">Select a page</option>
                        <?php
                        $pages = get_pages();
                        foreach ($pages as $page) {
                            $template = get_post_meta($page->ID, '_wp_page_template', true);
                            echo '<option value="' . esc_attr($page->ID) . '">' . 
                                esc_html($page->post_title) . 
                                ($template ? ' (' . esc_html($template) . ')' : '') . 
                                '</option>';
                        }
                        ?>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label for="blog_page_id" class="block mb-2 font-medium">Blog Page</label>
                    <select name="blog_page_id" id="blog_page_id" class="w-full border border-gray-300 rounded px-3 py-2">
                        <option value="">Select a page</option>
                        <?php
                        foreach ($pages as $page) {
                            echo '<option value="' . esc_attr($page->ID) . '">' . esc_html($page->post_title) . '</option>';
                        }
                        ?>
                    </select>
                </div>
                
                <input type="hidden" name="action" value="reset_homepage">
                <button type="submit" class="bg-primary-500 hover:bg-primary-600 text-white font-bold py-2 px-4 rounded">
                    Update Homepage Settings
                </button>
            </form>
            
            <h2 class="text-xl font-semibold mt-8 mb-4">Available Pages</h2>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border p-2 text-left">ID</th>
                            <th class="border p-2 text-left">Title</th>
                            <th class="border p-2 text-left">Template</th>
                            <th class="border p-2 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pages as $page): ?>
                            <tr>
                                <td class="border p-2"><?php echo esc_html($page->ID); ?></td>
                                <td class="border p-2"><?php echo esc_html($page->post_title); ?></td>
                                <td class="border p-2"><?php echo esc_html(get_post_meta($page->ID, '_wp_page_template', true) ?: 'default'); ?></td>
                                <td class="border p-2"><?php echo esc_html($page->post_status); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
