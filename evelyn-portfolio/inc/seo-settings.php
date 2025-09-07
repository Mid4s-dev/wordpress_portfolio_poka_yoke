<?php
/**
 * Theme Settings Page for SEO and Metadata
 */

// Add SEO Settings Page to Admin Menu
add_action('admin_menu', function() {
    add_menu_page(
        'Theme SEO Settings',
        'Theme SEO',
        'manage_options',
        'theme-seo-settings',
        'theme_seo_settings_page',
        'dashicons-admin-site',
        31
    );
});

// Register SEO Settings
add_action('admin_init', function() {
    register_setting('theme_seo_settings_group', 'theme_seo_title_format');
    register_setting('theme_seo_settings_group', 'theme_seo_description');
    register_setting('theme_seo_settings_group', 'theme_seo_keywords');
    register_setting('theme_seo_settings_group', 'theme_seo_enable_schema');
    register_setting('theme_seo_settings_group', 'theme_seo_social_image');
});

// Settings page callback
function theme_seo_settings_page() {
    ?>
    <div class="wrap">
        <h1>Theme SEO Settings</h1>
        <p>Configure SEO settings and metadata for your site.</p>
        
        <form method="post" action="options.php">
            <?php settings_fields('theme_seo_settings_group'); ?>
            <?php do_settings_sections('theme_seo_settings_group'); ?>
            
            <table class="form-table">
                <tr>
                    <th scope="row">Title Format</th>
                    <td>
                        <input type="text" name="theme_seo_title_format" value="<?php echo esc_attr(get_option('theme_seo_title_format', "{title} | {name}'s Portfolio")); ?>" class="large-text" />
                        <p class="description">Format for page titles. Use {title} for page title, {name} for owner name, {site} for site name</p>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">Meta Description</th>
                    <td>
                        <textarea name="theme_seo_description" rows="3" class="large-text"><?php echo esc_textarea(get_option('theme_seo_description', "Explore {name}'s portfolio of photography and stories from a {job_title} at {company}")); ?></textarea>
                        <p class="description">Default meta description. Use {name}, {job_title} and {company} as variables.</p>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">Meta Keywords</th>
                    <td>
                        <input type="text" name="theme_seo_keywords" value="<?php echo esc_attr(get_option('theme_seo_keywords', 'portfolio, photography, blog')); ?>" class="large-text" />
                        <p class="description">Comma-separated keywords for your site</p>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">Enable Schema Markup</th>
                    <td>
                        <label>
                            <input type="checkbox" name="theme_seo_enable_schema" value="1" <?php checked('1', get_option('theme_seo_enable_schema', '1')); ?> />
                            Add Schema.org structured data for better search results
                        </label>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">Default Social Image</th>
                    <td>
                        <div class="upload-wrapper">
                            <?php
                            $image_id = get_option('theme_seo_social_image');
                            $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'medium') : '';
                            ?>
                            <div <?php echo $image_url ? 'style="display:block;"' : 'style="display:none;"'; ?> class="image-preview">
                                <img src="<?php echo esc_url($image_url); ?>" alt="" style="max-width: 300px; height: auto; margin-bottom: 10px;">
                            </div>
                            
                            <input type="hidden" name="theme_seo_social_image" id="social_image_id" value="<?php echo esc_attr($image_id); ?>">
                            <button type="button" class="button upload-image-button">Select Image</button>
                            <button type="button" class="button remove-image-button" <?php echo !$image_url ? 'style="display:none;"' : ''; ?>>Remove Image</button>
                            
                            <p class="description">Image to use when sharing on social media (recommended size: 1200x630)</p>
                        </div>
                        
                        <script>
                        jQuery(document).ready(function($) {
                            var mediaUploader;
                            
                            $('.upload-image-button').on('click', function(e) {
                                e.preventDefault();
                                
                                if (mediaUploader) {
                                    mediaUploader.open();
                                    return;
                                }
                                
                                mediaUploader = wp.media({
                                    title: 'Select Social Media Image',
                                    button: {
                                        text: 'Use this image'
                                    },
                                    multiple: false
                                });
                                
                                mediaUploader.on('select', function() {
                                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                                    $('#social_image_id').val(attachment.id);
                                    $('.image-preview').show().find('img').attr('src', attachment.url);
                                    $('.remove-image-button').show();
                                });
                                
                                mediaUploader.open();
                            });
                            
                            $('.remove-image-button').on('click', function() {
                                $('#social_image_id').val('');
                                $('.image-preview').hide();
                                $(this).hide();
                            });
                        });
                        </script>
                    </td>
                </tr>
            </table>
            
            <?php submit_button('Save SEO Settings'); ?>
        </form>
    </div>
    <?php
}

// Add SEO meta tags to head
add_action('wp_head', function() {
    // Get owner details
    $owner_name = portfolio_owner_name();
    $job_title = portfolio_owner_job_title();
    $company = portfolio_owner_company();
    
    // Get SEO settings
    $title_format = get_option('theme_seo_title_format', "{title} | {name}'s Portfolio");
    $description = get_option('theme_seo_description', "Explore {name}'s portfolio of photography and stories from a {job_title} at {company}");
    $keywords = get_option('theme_seo_keywords', 'portfolio, photography, blog');
    
    // Replace variables
    $description = str_replace('{name}', $owner_name, $description);
    $description = str_replace('{job_title}', $job_title, $description);
    $description = str_replace('{company}', $company, $description);
    
    // Meta description
    echo '<meta name="description" content="' . esc_attr($description) . '">' . "\n";
    
    // Meta keywords
    if (!empty($keywords)) {
        echo '<meta name="keywords" content="' . esc_attr($keywords) . '">' . "\n";
    }
    
    // Open Graph tags
    echo '<meta property="og:site_name" content="' . esc_attr(get_bloginfo('name')) . '">' . "\n";
    echo '<meta property="og:title" content="' . esc_attr(wp_get_document_title()) . '">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr($description) . '">' . "\n";
    
    // Twitter Card tags
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    echo '<meta name="twitter:title" content="' . esc_attr(wp_get_document_title()) . '">' . "\n";
    echo '<meta name="twitter:description" content="' . esc_attr($description) . '">' . "\n";
    
    // Social image
    $social_image_id = get_option('theme_seo_social_image');
    if ($social_image_id) {
        $social_image_url = wp_get_attachment_image_url($social_image_id, 'large');
        if ($social_image_url) {
            echo '<meta property="og:image" content="' . esc_url($social_image_url) . '">' . "\n";
            echo '<meta name="twitter:image" content="' . esc_url($social_image_url) . '">' . "\n";
        }
    }
    
    // Schema.org structured data
    if (get_option('theme_seo_enable_schema', '1')) {
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'Person',
            'name' => $owner_name,
            'jobTitle' => $job_title,
            'worksFor' => array(
                '@type' => 'Organization',
                'name' => $company
            ),
            'url' => home_url(),
        );
        
        echo '<script type="application/ld+json">' . json_encode($schema) . '</script>' . "\n";
    }
});

// Filter document title
add_filter('pre_get_document_title', function($title) {
    // Only apply on front-end
    if (is_admin()) {
        return $title;
    }
    
    $title_format = get_option('theme_seo_title_format', "{title} | {name}'s Portfolio");
    $owner_name = portfolio_owner_name();
    $site_name = get_bloginfo('name');
    
    // Replace variables in title format
    $current_title = wp_get_document_title();
    $new_title = str_replace('{title}', $current_title, $title_format);
    $new_title = str_replace('{name}', $owner_name, $new_title);
    $new_title = str_replace('{site}', $site_name, $new_title);
    
    return $new_title;
}, 15);
