<?php
/**
 * Campaigns Dashboard Page
 * 
 * @package Portfolio
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Portfolio Campaigns Dashboard Class
 */
class Portfolio_Campaigns_Dashboard {
    
    /**
     * Constructor
     */
    public function __construct() {
        // Add admin menu page
        add_action('admin_menu', array($this, 'add_campaigns_menu'));
        
        // Register admin styles and scripts
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
        
        // Add post count to admin menu
        add_action('admin_menu', array($this, 'add_campaign_count_bubble'));
        
        // Add dashboard widgets
        add_action('wp_dashboard_setup', array($this, 'add_dashboard_widgets'));
        
        // Add quick links to the admin bar
        add_action('admin_bar_menu', array($this, 'add_admin_bar_links'), 80);
    }
    
    /**
     * Add admin menu page
     */
    public function add_campaigns_menu() {
        add_menu_page(
            __('Campaigns & Projects', 'portfolio'),
            __('Campaigns', 'portfolio'),
            'edit_posts',
            'portfolio-campaigns',
            array($this, 'render_dashboard_page'),
            'dashicons-portfolio',
            5
        );
        
        // Add submenu pages
        add_submenu_page(
            'portfolio-campaigns',
            __('Dashboard', 'portfolio'),
            __('Dashboard', 'portfolio'),
            'edit_posts',
            'portfolio-campaigns',
            array($this, 'render_dashboard_page')
        );
        
        add_submenu_page(
            'portfolio-campaigns',
            __('Add Social Post', 'portfolio'),
            __('Add Social Post', 'portfolio'),
            'edit_posts',
            'portfolio-quick-post',
            null
        );
        
        add_submenu_page(
            'portfolio-campaigns',
            __('Campaign Types', 'portfolio'),
            __('Campaign Types', 'portfolio'),
            'manage_categories',
            'edit-tags.php?taxonomy=campaign_type&post_type=portfolio_campaign'
        );
    }
    
    /**
     * Enqueue admin assets
     */
    public function enqueue_admin_assets($hook) {
        // Only enqueue on our custom page
        if ($hook !== 'toplevel_page_portfolio-campaigns') {
            return;
        }
        
        // Add custom CSS
        wp_enqueue_style(
            'portfolio-campaigns-admin-css',
            get_template_directory_uri() . '/assets/css/campaigns-admin.css',
            array(),
            filemtime(get_template_directory() . '/assets/css/campaigns-admin.css')
        );
        
        // Add Chart.js
        wp_enqueue_script(
            'chart-js',
            'https://cdn.jsdelivr.net/npm/chart.js',
            array(),
            '3.9.1',
            true
        );
        
        // Add custom JS
        wp_enqueue_script(
            'portfolio-campaigns-admin-js',
            get_template_directory_uri() . '/assets/js/campaigns-admin.js',
            array('jquery', 'chart-js'),
            filemtime(get_template_directory() . '/assets/js/campaigns-admin.js'),
            true
        );
        
        // Pass data to JS
        wp_localize_script(
            'portfolio-campaigns-admin-js',
            'portfolioCampaigns',
            $this->get_chart_data()
        );
    }
    
    /**
     * Add campaign count bubble to admin menu
     */
    public function add_campaign_count_bubble() {
        global $menu;
        
        $post_type = 'portfolio_campaign';
        
        if (!post_type_exists($post_type)) {
            return;
        }
        
        // Get number of posts
        $num_posts = wp_count_posts($post_type);
        $count = $num_posts->publish;
        
        if ($count > 0) {
            foreach ($menu as $key => $value) {
                if ($menu[$key][2] === 'portfolio-campaigns') {
                    $menu[$key][0] .= ' <span class="awaiting-mod update-plugins count-' . $count . '"><span class="plugin-count">' . $count . '</span></span>';
                    break;
                }
            }
        }
    }
    
    /**
     * Add dashboard widgets
     */
    public function add_dashboard_widgets() {
        wp_add_dashboard_widget(
            'portfolio_campaigns_summary',
            __('Recent Campaigns & Projects', 'portfolio'),
            array($this, 'render_dashboard_widget')
        );
    }
    
    /**
     * Add links to admin bar
     */
    public function add_admin_bar_links($admin_bar) {
        if (!is_admin_bar_showing() || !current_user_can('edit_posts')) {
            return;
        }
        
        $admin_bar->add_node(array(
            'id'    => 'portfolio-add-campaign',
            'title' => __('Add Social Post', 'portfolio'),
            'href'  => admin_url('admin.php?page=portfolio-quick-post'),
            'parent' => 'new-content',
        ));
    }
    
    /**
     * Get chart data for dashboard
     */
    private function get_chart_data() {
        // Get campaigns by platform
        $platforms = array('linkedin', 'instagram', 'twitter', 'project', 'campaign', 'other');
        $platform_counts = array();
        $platform_labels = array();
        
        foreach ($platforms as $platform) {
            $args = array(
                'post_type'      => 'portfolio_campaign',
                'posts_per_page' => -1,
                'meta_query'     => array(
                    array(
                        'key'   => '_campaign_platform',
                        'value' => $platform,
                    ),
                ),
            );
            
            $query = new WP_Query($args);
            $count = $query->found_posts;
            
            $platform_counts[] = $count;
            $platform_labels[] = ucfirst($platform);
        }
        
        // Get campaigns by month (last 6 months)
        $date_counts = array();
        $date_labels = array();
        
        for ($i = 5; $i >= 0; $i--) {
            $month = date('m', strtotime("-$i months"));
            $year = date('Y', strtotime("-$i months"));
            
            $args = array(
                'post_type'      => 'portfolio_campaign',
                'posts_per_page' => -1,
                'date_query'     => array(
                    array(
                        'year'  => $year,
                        'month' => $month,
                    ),
                ),
            );
            
            $query = new WP_Query($args);
            $count = $query->found_posts;
            
            $date_counts[] = $count;
            $date_labels[] = date_i18n('M Y', strtotime("$year-$month-01"));
        }
        
        return array(
            'platforms' => array(
                'labels' => $platform_labels,
                'counts' => $platform_counts,
            ),
            'dates' => array(
                'labels' => $date_labels,
                'counts' => $date_counts,
            ),
        );
    }
    
    /**
     * Render dashboard page
     */
    public function render_dashboard_page() {
        // Get counts
        $counts = wp_count_posts('portfolio_campaign');
        $total_campaigns = $counts->publish;
        $draft_campaigns = $counts->draft;
        $pending_campaigns = $counts->pending;
        
        // Get recent campaigns
        $recent_campaigns = get_posts(array(
            'post_type'      => 'portfolio_campaign',
            'posts_per_page' => 5,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ));
        ?>
        <div class="wrap campaigns-dashboard">
            <h1 class="wp-heading-inline"><?php _e('Campaigns & Projects Dashboard', 'portfolio'); ?></h1>
            <a href="<?php echo esc_url(admin_url('admin.php?page=portfolio-quick-post')); ?>" class="page-title-action"><?php _e('Add Social Post', 'portfolio'); ?></a>
            <hr class="wp-header-end">
            
            <div class="dashboard-header">
                <div class="dashboard-welcome">
                    <h2><?php _e('Welcome to Your Campaigns Dashboard', 'portfolio'); ?></h2>
                    <p><?php _e('Manage your campaigns, projects, and social media posts in one place.', 'portfolio'); ?></p>
                </div>
                
                <div class="dashboard-actions">
                    <a href="<?php echo esc_url(get_post_type_archive_link('portfolio_campaign')); ?>" class="button button-secondary" target="_blank"><?php _e('View Archive Page', 'portfolio'); ?></a>
                    <a href="<?php echo esc_url(admin_url('edit-tags.php?taxonomy=campaign_type&post_type=portfolio_campaign')); ?>" class="button button-secondary"><?php _e('Manage Categories', 'portfolio'); ?></a>
                </div>
            </div>
            
            <div class="dashboard-widgets">
                <div class="dashboard-column">
                    <div class="dashboard-widget stats-overview">
                        <h3><?php _e('Quick Stats', 'portfolio'); ?></h3>
                        
                        <div class="stats-grid">
                            <div class="stat-box">
                                <span class="dashicons dashicons-portfolio"></span>
                                <span class="stat-number"><?php echo absint($total_campaigns); ?></span>
                                <span class="stat-label"><?php _e('Total Campaigns', 'portfolio'); ?></span>
                            </div>
                            
                            <div class="stat-box">
                                <span class="dashicons dashicons-edit-page"></span>
                                <span class="stat-number"><?php echo absint($draft_campaigns); ?></span>
                                <span class="stat-label"><?php _e('Draft Campaigns', 'portfolio'); ?></span>
                            </div>
                            
                            <div class="stat-box">
                                <span class="dashicons dashicons-clock"></span>
                                <span class="stat-number"><?php echo absint($pending_campaigns); ?></span>
                                <span class="stat-label"><?php _e('Pending Campaigns', 'portfolio'); ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="dashboard-widget recent-campaigns">
                        <h3><?php _e('Recently Added', 'portfolio'); ?></h3>
                        
                        <?php if (!empty($recent_campaigns)) : ?>
                            <ul class="recent-list">
                                <?php foreach ($recent_campaigns as $campaign) : 
                                    $platform = get_post_meta($campaign->ID, '_campaign_platform', true);
                                    $platform_icon = '';
                                    
                                    switch ($platform) {
                                        case 'linkedin':
                                            $platform_icon = 'dashicons-linkedin';
                                            break;
                                        case 'instagram':
                                            $platform_icon = 'dashicons-instagram';
                                            break;
                                        case 'twitter':
                                            $platform_icon = 'dashicons-twitter';
                                            break;
                                        case 'project':
                                            $platform_icon = 'dashicons-portfolio';
                                            break;
                                        case 'campaign':
                                            $platform_icon = 'dashicons-megaphone';
                                            break;
                                        default:
                                            $platform_icon = 'dashicons-admin-links';
                                    }
                                ?>
                                    <li>
                                        <span class="dashicons <?php echo esc_attr($platform_icon); ?>"></span>
                                        <a href="<?php echo esc_url(get_edit_post_link($campaign->ID)); ?>">
                                            <?php echo esc_html($campaign->post_title); ?>
                                        </a>
                                        <div class="row-actions">
                                            <span class="edit">
                                                <a href="<?php echo esc_url(admin_url('admin.php?page=portfolio-quick-post&edit=' . $campaign->ID)); ?>" aria-label="<?php esc_attr_e('Edit with Quick Post', 'portfolio'); ?>">
                                                    <?php _e('Quick Edit', 'portfolio'); ?>
                                                </a>
                                            </span>
                                        </div>
                                        <span class="meta">
                                            <?php 
                                            printf(
                                                __('Added %s ago', 'portfolio'),
                                                human_time_diff(get_post_time('U', false, $campaign), current_time('timestamp'))
                                            ); 
                                            ?>
                                        </span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            
                            <a href="<?php echo esc_url(admin_url('edit.php?post_type=portfolio_campaign')); ?>" class="button button-secondary button-small view-all"><?php _e('View All Campaigns', 'portfolio'); ?></a>
                        <?php else : ?>
                            <p class="no-items"><?php _e('No campaigns have been created yet.', 'portfolio'); ?></p>
                            <a href="<?php echo esc_url(admin_url('admin.php?page=portfolio-quick-post')); ?>" class="button button-primary button-small"><?php _e('Add Your First Social Post', 'portfolio'); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="dashboard-column">
                    <div class="dashboard-widget platform-chart">
                        <h3><?php _e('Campaigns by Platform', 'portfolio'); ?></h3>
                        <div class="chart-container">
                            <canvas id="platformChart"></canvas>
                        </div>
                    </div>
                    
                    <div class="dashboard-widget time-chart">
                        <h3><?php _e('Campaigns by Month', 'portfolio'); ?></h3>
                        <div class="chart-container">
                            <canvas id="timeChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="dashboard-help">
                <h3><?php _e('Quick Help', 'portfolio'); ?></h3>
                
                <div class="help-grid">
                    <div class="help-box">
                        <h4><span class="dashicons dashicons-admin-customizer"></span> <?php _e('Customize Your Campaigns', 'portfolio'); ?></h4>
                        <p><?php _e('Add featured images, embed codes from social platforms, and detailed descriptions for your campaigns.', 'portfolio'); ?></p>
                    </div>
                    
                    <div class="help-box">
                        <h4><span class="dashicons dashicons-category"></span> <?php _e('Organize with Categories', 'portfolio'); ?></h4>
                        <p><?php _e('Use campaign types to organize your content into meaningful collections that visitors can browse.', 'portfolio'); ?></p>
                    </div>
                    
                    <div class="help-box">
                        <h4><span class="dashicons dashicons-share"></span> <?php _e('Embed Social Content', 'portfolio'); ?></h4>
                        <p><?php _e('Copy and paste embed codes from LinkedIn, Instagram, or Twitter into the embed code field to display original posts.', 'portfolio'); ?></p>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    
    /**
     * Render dashboard widget
     */
    public function render_dashboard_widget() {
        // Get counts
        $counts = wp_count_posts('portfolio_campaign');
        $total_campaigns = $counts->publish;
        
        // Get recent campaigns
        $recent_campaigns = get_posts(array(
            'post_type'      => 'portfolio_campaign',
            'posts_per_page' => 3,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ));
        
        ?>
        <div class="campaigns-widget">
            <p class="campaigns-count">
                <?php printf(
                    _n(
                        'You have <strong>%s</strong> published campaign/project.',
                        'You have <strong>%s</strong> published campaigns/projects.',
                        $total_campaigns,
                        'portfolio'
                    ),
                    number_format_i18n($total_campaigns)
                ); ?>
            </p>
            
            <?php if (!empty($recent_campaigns)) : ?>
                <ul class="campaigns-list">
                    <?php foreach ($recent_campaigns as $campaign) : 
                        $platform = get_post_meta($campaign->ID, '_campaign_platform', true);
                        $platform_icon = '';
                        
                        switch ($platform) {
                            case 'linkedin':
                                $platform_icon = 'dashicons-linkedin';
                                break;
                            case 'instagram':
                                $platform_icon = 'dashicons-instagram';
                                break;
                            case 'twitter':
                                $platform_icon = 'dashicons-twitter';
                                break;
                            default:
                                $platform_icon = 'dashicons-portfolio';
                        }
                    ?>
                        <li>
                            <span class="dashicons <?php echo esc_attr($platform_icon); ?>"></span>
                            <a href="<?php echo esc_url(get_edit_post_link($campaign->ID)); ?>">
                                <?php echo esc_html(wp_trim_words($campaign->post_title, 8)); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <p class="no-campaigns"><?php _e('No campaigns have been published yet.', 'portfolio'); ?></p>
            <?php endif; ?>
            
            <p class="campaigns-actions">
                <a href="<?php echo esc_url(admin_url('admin.php?page=portfolio-quick-post')); ?>" class="button button-secondary button-small"><?php _e('Add Social Post', 'portfolio'); ?></a>
                <a href="<?php echo esc_url(admin_url('edit.php?post_type=portfolio_campaign')); ?>" class="button button-link button-small"><?php _e('Manage All', 'portfolio'); ?></a>
            </p>
        </div>
        <?php
    }
}

// Initialize the dashboard
new Portfolio_Campaigns_Dashboard();
