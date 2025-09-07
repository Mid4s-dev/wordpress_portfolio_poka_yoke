<?php
/**
 * Blog Customization Settings
 * 
 * Provides options to manage blog appearance and functionality
 */

// Add Blog Settings Page to Admin Menu
add_action('admin_menu', function() {
    add_menu_page(
        'Blog Settings', 
        'Blog Manager',
        'manage_options',
        'blog-manager-settings',
        'blog_manager_settings_page',
        'dashicons-welcome-write-blog',
        32
    );
});

// Register Blog Settings
add_action('admin_init', function() {
    // Blog Layout Settings
    register_setting('blog_manager_settings_group', 'blog_layout_style');
    register_setting('blog_manager_settings_group', 'blog_posts_per_page');
    register_setting('blog_manager_settings_group', 'blog_show_featured_image');
    register_setting('blog_manager_settings_group', 'blog_show_author');
    register_setting('blog_manager_settings_group', 'blog_show_date');
    register_setting('blog_manager_settings_group', 'blog_show_categories');
    register_setting('blog_manager_settings_group', 'blog_excerpt_length');
    
    // Featured Blog Section
    register_setting('blog_manager_settings_group', 'blog_enable_featured_section');
    register_setting('blog_manager_settings_group', 'blog_featured_category');
    register_setting('blog_manager_settings_group', 'blog_featured_count');
    
    // Blog Sidebar Settings
    register_setting('blog_manager_settings_group', 'blog_enable_sidebar');
    register_setting('blog_manager_settings_group', 'blog_sidebar_position');
    
    // Featured Images Settings
    register_setting('blog_manager_settings_group', 'blog_image_size');
    register_setting('blog_manager_settings_group', 'blog_enable_lightbox');
});

// Settings page callback
function blog_manager_settings_page() {
    ?>
    <div class="wrap">
        <h1>Blog Manager Settings</h1>
        <p>Customize your blog's appearance and functionality.</p>
        
        <form method="post" action="options.php">
            <?php settings_fields('blog_manager_settings_group'); ?>
            <?php do_settings_sections('blog_manager_settings_group'); ?>
            
            <div class="nav-tab-wrapper">
                <a href="#layout" class="nav-tab nav-tab-active">Layout</a>
                <a href="#featured" class="nav-tab">Featured Content</a>
                <a href="#images" class="nav-tab">Images</a>
                <a href="#sidebar" class="nav-tab">Sidebar</a>
            </div>
            
            <div id="layout" class="tab-content">
                <h2>Blog Layout Settings</h2>
                <table class="form-table">
                    <tr>
                        <th scope="row">Blog Layout Style</th>
                        <td>
                            <select name="blog_layout_style">
                                <option value="grid" <?php selected('grid', get_option('blog_layout_style', 'grid')); ?>>Grid Layout</option>
                                <option value="list" <?php selected('list', get_option('blog_layout_style', 'grid')); ?>>List Layout</option>
                                <option value="masonry" <?php selected('masonry', get_option('blog_layout_style', 'grid')); ?>>Masonry Grid</option>
                                <option value="classic" <?php selected('classic', get_option('blog_layout_style', 'grid')); ?>>Classic Layout</option>
                            </select>
                            <p class="description">Choose the layout style for your blog listings</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Posts Per Page</th>
                        <td>
                            <input type="number" name="blog_posts_per_page" value="<?php echo esc_attr(get_option('blog_posts_per_page', '9')); ?>" min="1" max="50" />
                            <p class="description">Number of posts to display per page</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Content Display Options</th>
                        <td>
                            <label>
                                <input type="checkbox" name="blog_show_featured_image" value="1" <?php checked('1', get_option('blog_show_featured_image', '1')); ?> />
                                Show featured images
                            </label><br>
                            
                            <label>
                                <input type="checkbox" name="blog_show_author" value="1" <?php checked('1', get_option('blog_show_author', '1')); ?> />
                                Show author information
                            </label><br>
                            
                            <label>
                                <input type="checkbox" name="blog_show_date" value="1" <?php checked('1', get_option('blog_show_date', '1')); ?> />
                                Show post date
                            </label><br>
                            
                            <label>
                                <input type="checkbox" name="blog_show_categories" value="1" <?php checked('1', get_option('blog_show_categories', '1')); ?> />
                                Show categories
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Excerpt Length</th>
                        <td>
                            <input type="number" name="blog_excerpt_length" value="<?php echo esc_attr(get_option('blog_excerpt_length', '20')); ?>" min="10" max="100" />
                            <p class="description">Number of words in excerpt</p>
                        </td>
                    </tr>
                </table>
            </div>
            
            <div id="featured" class="tab-content" style="display:none;">
                <h2>Featured Blog Content</h2>
                <table class="form-table">
                    <tr>
                        <th scope="row">Enable Featured Section</th>
                        <td>
                            <label>
                                <input type="checkbox" name="blog_enable_featured_section" value="1" <?php checked('1', get_option('blog_enable_featured_section', '1')); ?> />
                                Show featured posts section
                            </label>
                            <p class="description">Display a featured posts section at the top of the blog page</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Featured Category</th>
                        <td>
                            <select name="blog_featured_category">
                                <option value="">— Select Category —</option>
                                <?php 
                                $categories = get_categories();
                                $selected_cat = get_option('blog_featured_category');
                                
                                foreach ($categories as $category) {
                                    printf(
                                        '<option value="%s" %s>%s</option>',
                                        esc_attr($category->term_id),
                                        selected($category->term_id, $selected_cat, false),
                                        esc_html($category->name)
                                    );
                                }
                                ?>
                            </select>
                            <p class="description">Posts from this category will be featured (leave empty to feature latest posts)</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Number of Featured Posts</th>
                        <td>
                            <input type="number" name="blog_featured_count" value="<?php echo esc_attr(get_option('blog_featured_count', '3')); ?>" min="1" max="10" />
                            <p class="description">Number of posts to display in the featured section</p>
                        </td>
                    </tr>
                </table>
            </div>
            
            <div id="images" class="tab-content" style="display:none;">
                <h2>Featured Images Settings</h2>
                <table class="form-table">
                    <tr>
                        <th scope="row">Image Size</th>
                        <td>
                            <select name="blog_image_size">
                                <option value="thumbnail" <?php selected('thumbnail', get_option('blog_image_size', 'blog-featured')); ?>>Thumbnail</option>
                                <option value="medium" <?php selected('medium', get_option('blog_image_size', 'blog-featured')); ?>>Medium</option>
                                <option value="large" <?php selected('large', get_option('blog_image_size', 'blog-featured')); ?>>Large</option>
                                <option value="blog-featured" <?php selected('blog-featured', get_option('blog_image_size', 'blog-featured')); ?>>Blog Featured (Custom)</option>
                                <option value="full" <?php selected('full', get_option('blog_image_size', 'blog-featured')); ?>>Full Size</option>
                            </select>
                            <p class="description">Size of featured images in blog listings</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Lightbox for Images</th>
                        <td>
                            <label>
                                <input type="checkbox" name="blog_enable_lightbox" value="1" <?php checked('1', get_option('blog_enable_lightbox', '1')); ?> />
                                Enable lightbox for images in blog posts
                            </label>
                            <p class="description">When enabled, clicking on images in blog posts will open them in a lightbox</p>
                        </td>
                    </tr>
                </table>
            </div>
            
            <div id="sidebar" class="tab-content" style="display:none;">
                <h2>Blog Sidebar Settings</h2>
                <table class="form-table">
                    <tr>
                        <th scope="row">Enable Sidebar</th>
                        <td>
                            <label>
                                <input type="checkbox" name="blog_enable_sidebar" value="1" <?php checked('1', get_option('blog_enable_sidebar', '1')); ?> />
                                Show sidebar on blog pages
                            </label>
                            <p class="description">Display a sidebar on blog index and single posts</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Sidebar Position</th>
                        <td>
                            <select name="blog_sidebar_position">
                                <option value="right" <?php selected('right', get_option('blog_sidebar_position', 'right')); ?>>Right</option>
                                <option value="left" <?php selected('left', get_option('blog_sidebar_position', 'right')); ?>>Left</option>
                            </select>
                            <p class="description">Position of the sidebar on blog pages</p>
                        </td>
                    </tr>
                </table>
            </div>
            
            <?php submit_button('Save Blog Settings'); ?>
        </form>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        // Tab navigation
        $('.nav-tab').on('click', function(e) {
            e.preventDefault();
            
            // Hide all tab contents
            $('.tab-content').hide();
            
            // Remove active class from all tabs
            $('.nav-tab').removeClass('nav-tab-active');
            
            // Show the selected tab content
            $($(this).attr('href')).show();
            
            // Add active class to clicked tab
            $(this).addClass('nav-tab-active');
        });
    });
    </script>
    <?php
}

// Add custom image size for blog featured images
add_action('after_setup_theme', function() {
    add_image_size('blog-featured', 900, 500, true);
    add_image_size('blog-grid', 600, 400, true);
    add_image_size('blog-thumbnail', 300, 200, true);
});

// Helper function to get blog settings
function get_blog_setting($key, $default = '') {
    return get_option('blog_' . $key, $default);
}

// Apply blog settings to posts per page
add_action('pre_get_posts', function($query) {
    if (!is_admin() && $query->is_main_query()) {
        if ($query->is_home() || $query->is_category() || $query->is_tag()) {
            $posts_per_page = get_blog_setting('posts_per_page', 9);
            $query->set('posts_per_page', $posts_per_page);
        }
    }
});

// Add custom class to body based on blog layout
add_filter('body_class', function($classes) {
    if (is_home() || is_archive() || is_search()) {
        $layout = get_blog_setting('layout_style', 'grid');
        $classes[] = 'blog-layout-' . $layout;
        
        if (get_blog_setting('enable_sidebar', '1')) {
            $classes[] = 'has-sidebar';
            $classes[] = 'sidebar-' . get_blog_setting('sidebar_position', 'right');
        } else {
            $classes[] = 'no-sidebar';
        }
    }
    
    return $classes;
});

// Custom excerpt length
add_filter('excerpt_length', function($length) {
    if (is_admin()) {
        return $length;
    }
    
    return get_blog_setting('excerpt_length', 20);
});

// Add lightbox to images
add_action('wp_footer', function() {
    if (!is_admin() && is_singular('post') && get_blog_setting('enable_lightbox', '1')) {
        ?>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const contentImages = document.querySelectorAll('.entry-content img');
            
            contentImages.forEach(function(img) {
                const link = document.createElement('a');
                link.href = img.src;
                link.setAttribute('data-fancybox', 'blog-gallery');
                link.setAttribute('data-caption', img.alt || '');
                
                img.parentNode.insertBefore(link, img);
                link.appendChild(img);
            });
            
            // Initialize lightbox if available
            if (typeof Fancybox !== 'undefined') {
                Fancybox.bind('[data-fancybox="blog-gallery"]');
            }
        });
        </script>
        <?php
    }
});
