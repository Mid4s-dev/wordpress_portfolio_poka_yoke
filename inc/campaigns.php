<?php
/**
 * Campaigns & Projects - Custom post type for showcasing recent campaigns and projects
 * 
 * @package Portfolio
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Campaigns & Projects Handler Class
 */
class Portfolio_Campaigns {

    /**
     * Constructor
     */
    public function __construct() {
        // Register custom post type
        add_action('init', array($this, 'register_campaigns_post_type'));
        
        // Add meta boxes
        add_action('add_meta_boxes', array($this, 'add_campaign_meta_boxes'));
        
        // Save meta box data
        add_action('save_post', array($this, 'save_campaign_meta'));
        
        // Add shortcode
        add_shortcode('portfolio_campaigns', array($this, 'campaigns_shortcode'));
        
        // Add campaigns to admin bar
        add_action('admin_bar_menu', array($this, 'add_campaigns_to_admin_bar'), 100);
    }
    
    /**
     * Register campaigns post type
     */
    public function register_campaigns_post_type() {
        $labels = array(
            'name'               => __('Campaigns & Projects', 'portfolio'),
            'singular_name'      => __('Campaign/Project', 'portfolio'),
            'menu_name'          => __('Campaigns', 'portfolio'),
            'add_new'            => __('Add New', 'portfolio'),
            'add_new_item'       => __('Add New Campaign/Project', 'portfolio'),
            'edit_item'          => __('Edit Campaign/Project', 'portfolio'),
            'new_item'           => __('New Campaign/Project', 'portfolio'),
            'view_item'          => __('View Campaign/Project', 'portfolio'),
            'search_items'       => __('Search Campaigns & Projects', 'portfolio'),
            'not_found'          => __('No campaigns found', 'portfolio'),
            'not_found_in_trash' => __('No campaigns found in trash', 'portfolio'),
        );
        
        $args = array(
            'labels'              => $labels,
            'public'              => true,
            'has_archive'         => true,
            'publicly_queryable'  => true,
            'query_var'           => true,
            'rewrite'             => array('slug' => 'campaigns'),
            'capability_type'     => 'post',
            'hierarchical'        => false,
            'menu_position'       => 5,
            'menu_icon'           => 'dashicons-portfolio',
            'supports'            => array('title', 'editor', 'thumbnail', 'excerpt'),
            'show_in_rest'        => true, // Enable Gutenberg editor
        );
        
        register_post_type('portfolio_campaign', $args);
        
        // Register campaign type taxonomy
        register_taxonomy('campaign_type', 'portfolio_campaign', array(
            'label'              => __('Campaign Type', 'portfolio'),
            'hierarchical'       => true,
            'show_ui'            => true,
            'show_admin_column'  => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'campaign-type'),
            'show_in_rest'       => true,
        ));
        
        // Add default terms if they don't exist
        $default_terms = array(
            'LinkedIn Post',
            'Instagram Post',
            'Twitter Post',
            'Project',
            'Campaign',
            'Other'
        );
        
        foreach ($default_terms as $term) {
            if (!term_exists($term, 'campaign_type')) {
                wp_insert_term($term, 'campaign_type');
            }
        }
    }
    
    /**
     * Add meta boxes to the campaign post type
     */
    public function add_campaign_meta_boxes() {
        add_meta_box(
            'portfolio_campaign_details',
            __('Campaign/Project Details', 'portfolio'),
            array($this, 'render_campaign_details_meta_box'),
            'portfolio_campaign',
            'normal',
            'high'
        );
        
        // Add featured campaign meta box
        add_meta_box(
            'portfolio_campaign_featured',
            __('Featured Status', 'portfolio'),
            array($this, 'render_featured_meta_box'),
            'portfolio_campaign',
            'side',
            'default'
        );
    }
    
    /**
     * Render featured meta box
     */
    public function render_featured_meta_box($post) {
        // Add nonce for security
        wp_nonce_field('portfolio_featured_meta_box', 'portfolio_featured_meta_nonce');
        
        // Get current value
        $featured = get_post_meta($post->ID, '_campaign_featured', true);
        
        ?>
        <div class="featured-meta-box">
            <p>
                <label>
                    <input type="checkbox" name="campaign_featured" value="1" <?php checked($featured, '1'); ?>>
                    <strong><?php _e('Set as featured campaign/project', 'portfolio'); ?></strong>
                </label>
            </p>
            <p class="description">
                <?php _e('Featured campaigns appear at the top of the campaigns showcase page in a highlighted section.', 'portfolio'); ?>
            </p>
        </div>
        <?php
    }
    
    /**
     * Render campaign details meta box
     */
    public function render_campaign_details_meta_box($post) {
        // Add a nonce field
        wp_nonce_field('portfolio_campaign_meta_box', 'portfolio_campaign_meta_nonce');
        
        // Get current values
        $url = get_post_meta($post->ID, '_campaign_url', true);
        $date = get_post_meta($post->ID, '_campaign_date', true);
        $platform = get_post_meta($post->ID, '_campaign_platform', true);
        $embed_code = get_post_meta($post->ID, '_campaign_embed_code', true);
        
        ?>
        <div class="campaign-meta-box">
            <p>
                <label for="campaign_url"><strong><?php _e('URL:', 'portfolio'); ?></strong></label><br>
                <input type="url" id="campaign_url" name="campaign_url" value="<?php echo esc_url($url); ?>" class="widefat">
                <span class="description"><?php _e('Enter the URL of the campaign/project or social media post', 'portfolio'); ?></span>
            </p>
            
            <p>
                <label for="campaign_date"><strong><?php _e('Date:', 'portfolio'); ?></strong></label><br>
                <input type="date" id="campaign_date" name="campaign_date" value="<?php echo esc_attr($date); ?>" class="widefat">
                <span class="description"><?php _e('When was this campaign/project launched or post created?', 'portfolio'); ?></span>
            </p>
            
            <p>
                <label for="campaign_platform"><strong><?php _e('Platform:', 'portfolio'); ?></strong></label><br>
                <select id="campaign_platform" name="campaign_platform" class="widefat">
                    <option value=""><?php _e('Select a platform', 'portfolio'); ?></option>
                    <option value="linkedin" <?php selected($platform, 'linkedin'); ?>><?php _e('LinkedIn', 'portfolio'); ?></option>
                    <option value="instagram" <?php selected($platform, 'instagram'); ?>><?php _e('Instagram', 'portfolio'); ?></option>
                    <option value="twitter" <?php selected($platform, 'twitter'); ?>><?php _e('Twitter', 'portfolio'); ?></option>
                    <option value="project" <?php selected($platform, 'project'); ?>><?php _e('Project', 'portfolio'); ?></option>
                    <option value="campaign" <?php selected($platform, 'campaign'); ?>><?php _e('Campaign', 'portfolio'); ?></option>
                    <option value="other" <?php selected($platform, 'other'); ?>><?php _e('Other', 'portfolio'); ?></option>
                </select>
                <span class="description"><?php _e('What platform or type is this content from?', 'portfolio'); ?></span>
            </p>
            
            <p>
                <label for="campaign_embed_code"><strong><?php _e('Embed Code (optional):', 'portfolio'); ?></strong></label><br>
                <textarea id="campaign_embed_code" name="campaign_embed_code" class="widefat" rows="5"><?php echo esc_textarea($embed_code); ?></textarea>
                <span class="description"><?php _e('If you have an embed code from the platform (like a LinkedIn post embed), paste it here. Otherwise, leave blank and we\'ll generate a preview.', 'portfolio'); ?></span>
            </p>
        </div>
        <?php
    }
    
    /**
     * Save campaign meta data
     */
    public function save_campaign_meta($post_id) {
        // Check if nonce is set
        if (!isset($_POST['portfolio_campaign_meta_nonce'])) {
            return;
        }
        
        // Verify that the nonce is valid
        if (!wp_verify_nonce($_POST['portfolio_campaign_meta_nonce'], 'portfolio_campaign_meta_box')) {
            return;
        }
        
        // If this is an autosave, don't do anything
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        
        // Check the user's permissions
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        
        // Save the URL
        if (isset($_POST['campaign_url'])) {
            update_post_meta(
                $post_id,
                '_campaign_url',
                esc_url_raw($_POST['campaign_url'])
            );
        }
        
        // Save the date
        if (isset($_POST['campaign_date'])) {
            update_post_meta(
                $post_id,
                '_campaign_date',
                sanitize_text_field($_POST['campaign_date'])
            );
        }
        
        // Save the platform
        if (isset($_POST['campaign_platform'])) {
            update_post_meta(
                $post_id,
                '_campaign_platform',
                sanitize_text_field($_POST['campaign_platform'])
            );
        }
        
        // Save the embed code
        if (isset($_POST['campaign_embed_code'])) {
            update_post_meta(
                $post_id,
                '_campaign_embed_code',
                wp_kses_post($_POST['campaign_embed_code'])
            );
        }
        
        // Save featured status
        if (isset($_POST['portfolio_featured_meta_nonce']) && 
            wp_verify_nonce($_POST['portfolio_featured_meta_nonce'], 'portfolio_featured_meta_box')) {
            
            if (isset($_POST['campaign_featured'])) {
                update_post_meta($post_id, '_campaign_featured', '1');
            } else {
                update_post_meta($post_id, '_campaign_featured', '0');
            }
        }
    }
    
    /**
     * Add campaigns to admin bar for quick access
     */
    public function add_campaigns_to_admin_bar($wp_admin_bar) {
        if (!is_admin_bar_showing() || !current_user_can('edit_posts')) {
            return;
        }
        
        $wp_admin_bar->add_node(array(
            'id'    => 'portfolio-campaigns',
            'title' => __('Campaigns & Projects', 'portfolio'),
            'href'  => admin_url('edit.php?post_type=portfolio_campaign'),
        ));
        
        $wp_admin_bar->add_node(array(
            'id'     => 'portfolio-add-campaign',
            'parent' => 'portfolio-campaigns',
            'title'  => __('Add New', 'portfolio'),
            'href'   => admin_url('post-new.php?post_type=portfolio_campaign'),
        ));
    }
    
    /**
     * Shortcode for displaying campaigns
     */
    public function campaigns_shortcode($atts) {
        $atts = shortcode_atts(array(
            'count'    => 6,
            'type'     => '',
            'platform' => '',
            'orderby'  => 'date',
            'order'    => 'DESC',
        ), $atts);
        
        $args = array(
            'post_type'      => 'portfolio_campaign',
            'posts_per_page' => intval($atts['count']),
            'orderby'        => $atts['orderby'],
            'order'          => $atts['order'],
        );
        
        // Add taxonomy query if type is specified
        if (!empty($atts['type'])) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'campaign_type',
                    'field'    => 'slug',
                    'terms'    => explode(',', $atts['type']),
                ),
            );
        }
        
        // Add meta query if platform is specified
        if (!empty($atts['platform'])) {
            $args['meta_query'] = array(
                array(
                    'key'     => '_campaign_platform',
                    'value'   => explode(',', $atts['platform']),
                    'compare' => 'IN',
                ),
            );
        }
        
        $campaigns = new WP_Query($args);
        
        if (!$campaigns->have_posts()) {
            return '<div class="portfolio-campaigns-empty">' . __('No campaigns or projects found.', 'portfolio') . '</div>';
        }
        
        ob_start();
        ?>
        <div class="portfolio-campaigns-container">
            <div class="portfolio-campaigns-grid">
                <?php while ($campaigns->have_posts()) : $campaigns->the_post(); ?>
                    <?php
                    $url = get_post_meta(get_the_ID(), '_campaign_url', true);
                    $date = get_post_meta(get_the_ID(), '_campaign_date', true);
                    $platform = get_post_meta(get_the_ID(), '_campaign_platform', true);
                    $embed_code = get_post_meta(get_the_ID(), '_campaign_embed_code', true);
                    
                    $formatted_date = !empty($date) ? date_i18n(get_option('date_format'), strtotime($date)) : '';
                    $platform_icon = $this->get_platform_icon($platform);
                    ?>
                    
                    <div class="portfolio-campaign-item">
                        <div class="portfolio-campaign-content">
                            <?php if (!empty($embed_code)) : ?>
                                <div class="portfolio-campaign-embed">
                                    <?php echo wp_kses_post($embed_code); ?>
                                </div>
                            <?php else : ?>
                                <div class="portfolio-campaign-preview">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="portfolio-campaign-thumbnail">
                                            <?php if (!empty($url)) : ?>
                                                <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener">
                                                    <?php the_post_thumbnail('medium'); ?>
                                                </a>
                                            <?php else : ?>
                                                <?php the_post_thumbnail('medium'); ?>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="portfolio-campaign-excerpt">
                                        <h3 class="portfolio-campaign-title">
                                            <?php if (!empty($url)) : ?>
                                                <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener">
                                                    <?php the_title(); ?>
                                                </a>
                                            <?php else : ?>
                                                <?php the_title(); ?>
                                            <?php endif; ?>
                                        </h3>
                                        
                                        <?php the_excerpt(); ?>
                                        
                                        <?php if (!empty($url)) : ?>
                                            <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener" class="portfolio-campaign-link">
                                                <?php _e('View Original', 'portfolio'); ?> <span class="screen-reader-text"><?php _e('(opens in a new tab)', 'portfolio'); ?></span>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="portfolio-campaign-meta">
                            <?php if (!empty($platform_icon)) : ?>
                                <span class="portfolio-campaign-platform">
                                    <span class="dashicons <?php echo esc_attr($platform_icon); ?>"></span>
                                    <?php echo esc_html(ucfirst($platform)); ?>
                                </span>
                            <?php endif; ?>
                            
                            <?php if (!empty($formatted_date)) : ?>
                                <span class="portfolio-campaign-date">
                                    <span class="dashicons dashicons-calendar-alt"></span>
                                    <?php echo esc_html($formatted_date); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                <?php endwhile; ?>
            </div>
        </div>
        <?php
        wp_reset_postdata();
        
        return ob_get_clean();
    }
    
    /**
     * Get platform icon
     */
    private function get_platform_icon($platform) {
        switch ($platform) {
            case 'linkedin':
                return 'dashicons-linkedin';
            case 'instagram':
                return 'dashicons-instagram';
            case 'twitter':
                return 'dashicons-twitter';
            case 'project':
                return 'dashicons-portfolio';
            case 'campaign':
                return 'dashicons-megaphone';
            default:
                return 'dashicons-admin-links';
        }
    }
}

// Initialize Campaigns
new Portfolio_Campaigns();

/**
 * Add CSS for campaigns display
 */
function portfolio_campaigns_styles() {
    $css = '
    /* Campaigns & Projects Grid */
    .portfolio-campaigns-container {
        margin: 2rem 0;
    }
    
    .portfolio-campaigns-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        grid-gap: 2rem;
    }
    
    .portfolio-campaign-item {
        border: 1px solid #ddd;
        border-radius: 4px;
        overflow: hidden;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        background: #fff;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .portfolio-campaign-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .portfolio-campaign-content {
        padding: 1.5rem;
    }
    
    .portfolio-campaign-embed {
        margin: -1.5rem -1.5rem 0;
        overflow: hidden;
        position: relative;
        padding-bottom: 1.5rem;
    }
    
    .portfolio-campaign-embed iframe {
        max-width: 100%;
    }
    
    .portfolio-campaign-thumbnail img {
        width: 100%;
        height: auto;
        display: block;
    }
    
    .portfolio-campaign-excerpt {
        padding: 1rem 0 0;
    }
    
    .portfolio-campaign-title {
        margin-top: 0;
        margin-bottom: 1rem;
        font-size: 1.2rem;
    }
    
    .portfolio-campaign-title a {
        color: inherit;
        text-decoration: none;
    }
    
    .portfolio-campaign-title a:hover {
        color: #0073aa;
    }
    
    .portfolio-campaign-link {
        display: inline-block;
        margin-top: 1rem;
        padding: 0.5rem 1rem;
        background: #f0f0f0;
        border-radius: 3px;
        text-decoration: none;
        color: #333;
        font-size: 0.9rem;
        transition: background 0.2s ease;
    }
    
    .portfolio-campaign-link:hover {
        background: #e0e0e0;
    }
    
    .portfolio-campaign-meta {
        border-top: 1px solid #eee;
        padding: 1rem 1.5rem;
        background: #f9f9f9;
        font-size: 0.9rem;
        color: #666;
        display: flex;
        justify-content: space-between;
    }
    
    .portfolio-campaign-platform,
    .portfolio-campaign-date {
        display: flex;
        align-items: center;
    }
    
    .portfolio-campaign-platform .dashicons,
    .portfolio-campaign-date .dashicons {
        margin-right: 0.3rem;
    }
    
    /* Responsive Fixes */
    @media screen and (max-width: 600px) {
        .portfolio-campaigns-grid {
            grid-template-columns: 1fr;
        }
    }
    ';
    
    wp_add_inline_style('portfolio-style', $css);
}
add_action('wp_enqueue_scripts', 'portfolio_campaigns_styles');
