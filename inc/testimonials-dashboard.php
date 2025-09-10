<?php
/**
 * Testimonials Dashboard Page
 * 
 * @package Portfolio
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Portfolio Testimonials Dashboard Class
 */
class Portfolio_Testimonials_Dashboard {
    
    /**
     * Constructor
     */
    public function __construct() {
        // Add admin menu page
        add_action('admin_menu', array($this, 'add_testimonials_menu'));
        
        // Register admin styles and scripts
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
        
        // Add post count to admin menu
        add_action('admin_menu', array($this, 'add_testimonial_count_bubble'));
        
        // Add dashboard widgets
        add_action('wp_dashboard_setup', array($this, 'add_dashboard_widgets'));
        
        // Add quick links to the admin bar
        add_action('admin_bar_menu', array($this, 'add_admin_bar_links'), 80);
    }
    
    /**
     * Add admin menu page
     */
    public function add_testimonials_menu() {
        add_menu_page(
            __('Testimonials', 'portfolio'),
            __('Testimonials', 'portfolio'),
            'edit_posts',
            'portfolio-testimonials',
            array($this, 'render_dashboard_page'),
            'dashicons-format-quote',
            6
        );
        
        // Add submenu pages
        add_submenu_page(
            'portfolio-testimonials',
            __('Dashboard', 'portfolio'),
            __('Dashboard', 'portfolio'),
            'edit_posts',
            'portfolio-testimonials',
            array($this, 'render_dashboard_page')
        );
        
        // Add a custom callback that redirects to the correct URL
        add_submenu_page(
            'portfolio-testimonials',
            __('Add New Testimonial', 'portfolio'),
            __('Add New', 'portfolio'),
            'edit_posts',
            'add-new-testimonial',
            array($this, 'redirect_to_new_testimonial')
        );
        
        add_submenu_page(
            'portfolio-testimonials',
            __('All Testimonials', 'portfolio'),
            __('All Testimonials', 'portfolio'),
            'edit_posts',
            'edit.php?post_type=portfolio_testimonial'
        );
    }
    
    /**
     * Enqueue admin assets
     */
    public function enqueue_admin_assets($hook) {
        // Only enqueue on our custom page
        if ($hook !== 'toplevel_page_portfolio-testimonials') {
            return;
        }
        
        // Add custom CSS
        wp_enqueue_style(
            'portfolio-testimonials-admin-css',
            get_template_directory_uri() . '/assets/css/quick-testimonials.css',
            array(),
            filemtime(get_template_directory() . '/assets/css/quick-testimonials.css')
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
            'portfolio-testimonials-admin-js',
            get_template_directory_uri() . '/assets/js/testimonials.js',
            array('jquery', 'chart-js'),
            filemtime(get_template_directory() . '/assets/js/testimonials.js'),
            true
        );
    }
    
    /**
     * Add testimonial count bubble to admin menu
     */
    public function add_testimonial_count_bubble() {
        global $menu;
        
        $post_type = 'portfolio_testimonial';
        
        if (!post_type_exists($post_type)) {
            return;
        }
        
        // Get number of posts
        $num_posts = wp_count_posts($post_type);
        $count = isset($num_posts->publish) ? $num_posts->publish : 0;
        
        if ($count > 0) {
            foreach ($menu as $key => $value) {
                if ($menu[$key][2] === 'portfolio-testimonials') {
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
            'portfolio_testimonials_summary',
            __('Recent Testimonials', 'portfolio'),
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
            'id'    => 'portfolio-add-testimonial',
            'title' => __('Add Testimonial', 'portfolio'),
            'href'  => admin_url('admin.php?page=add-new-testimonial'),
            'parent' => 'new-content',
        ));
    }
    
    /**
     * Render dashboard page
     */
    public function render_dashboard_page() {
        // Get counts
        $counts = wp_count_posts('portfolio_testimonial');
        $total_testimonials = isset($counts->publish) ? $counts->publish : 0;
        $draft_testimonials = isset($counts->draft) ? $counts->draft : 0;
        $pending_testimonials = isset($counts->pending) ? $counts->pending : 0;
        
        // Get recent testimonials
        $recent_testimonials = get_posts(array(
            'post_type'      => 'portfolio_testimonial',
            'posts_per_page' => 5,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ));
        
        // Get average rating
        $args = array(
            'post_type'      => 'portfolio_testimonial',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
        );
        
        $testimonials = get_posts($args);
        $total_rating = 0;
        $rating_count = 0;
        
        foreach ($testimonials as $testimonial) {
            $rating = get_post_meta($testimonial->ID, '_portfolio_testimonial_rating', true);
            if (!empty($rating)) {
                $total_rating += intval($rating);
                $rating_count++;
            }
        }
        
        $average_rating = $rating_count > 0 ? round($total_rating / $rating_count, 1) : 0;
        ?>
        <div class="wrap testimonials-dashboard">
            <h1 class="wp-heading-inline"><?php _e('Testimonials Dashboard', 'portfolio'); ?></h1>
            <a href="<?php echo esc_url(admin_url('admin.php?page=add-new-testimonial')); ?>" class="page-title-action"><?php _e('Add New Testimonial', 'portfolio'); ?></a>
            <hr class="wp-header-end">
            
            <div class="dashboard-header">
                <div class="dashboard-welcome">
                    <h2><?php _e('Welcome to Your Testimonials Dashboard', 'portfolio'); ?></h2>
                    <p><?php _e('Manage client testimonials and showcase their feedback on your portfolio.', 'portfolio'); ?></p>
                </div>
                
                <div class="dashboard-actions">
                    <a href="<?php echo esc_url(get_post_type_archive_link('portfolio_testimonial')); ?>" class="button button-secondary" target="_blank"><?php _e('View Archive Page', 'portfolio'); ?></a>
                    <a href="<?php echo esc_url(admin_url('edit.php?post_type=portfolio_testimonial')); ?>" class="button button-secondary"><?php _e('Manage All Testimonials', 'portfolio'); ?></a>
                </div>
            </div>
            
            <div class="dashboard-widgets">
                <div class="dashboard-column">
                    <div class="dashboard-widget stats-overview">
                        <h3><?php _e('Quick Stats', 'portfolio'); ?></h3>
                        
                        <div class="stats-grid">
                            <div class="stat-box">
                                <span class="dashicons dashicons-format-quote"></span>
                                <span class="stat-number"><?php echo absint($total_testimonials); ?></span>
                                <span class="stat-label"><?php _e('Total Testimonials', 'portfolio'); ?></span>
                            </div>
                            
                            <div class="stat-box">
                                <span class="dashicons dashicons-edit-page"></span>
                                <span class="stat-number"><?php echo absint($draft_testimonials); ?></span>
                                <span class="stat-label"><?php _e('Draft Testimonials', 'portfolio'); ?></span>
                            </div>
                            
                            <div class="stat-box">
                                <span class="dashicons dashicons-star-filled"></span>
                                <span class="stat-number"><?php echo number_format($average_rating, 1); ?></span>
                                <span class="stat-label"><?php _e('Average Rating', 'portfolio'); ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="dashboard-widget recent-testimonials">
                        <h3><?php _e('Recently Added', 'portfolio'); ?></h3>
                        
                        <?php if (!empty($recent_testimonials)) : ?>
                            <ul class="recent-list">
                                <?php foreach ($recent_testimonials as $testimonial) : 
                                    $client_name = get_post_meta($testimonial->ID, '_portfolio_testimonial_client_name', true);
                                    $client_company = get_post_meta($testimonial->ID, '_portfolio_testimonial_client_company', true);
                                    $rating = get_post_meta($testimonial->ID, '_portfolio_testimonial_rating', true);
                                    
                                    // Use post title if client name is empty
                                    if (empty($client_name)) {
                                        $client_name = $testimonial->post_title;
                                    }
                                ?>
                                    <li>
                                        <a href="<?php echo esc_url(get_edit_post_link($testimonial->ID)); ?>">
                                            <?php echo esc_html($client_name); ?>
                                            <?php if (!empty($client_company)) : ?>
                                                <span class="client-company">(<?php echo esc_html($client_company); ?>)</span>
                                            <?php endif; ?>
                                        </a>
                                        <?php if (!empty($rating)) : ?>
                                            <div class="testimonial-rating">
                                                <?php
                                                for ($i = 1; $i <= 5; $i++) {
                                                    if ($i <= $rating) {
                                                        echo '<span class="dashicons dashicons-star-filled" style="color:#ffb900;"></span>';
                                                    } else {
                                                        echo '<span class="dashicons dashicons-star-empty" style="color:#ccc;"></span>';
                                                    }
                                                }
                                                ?>
                                            </div>
                                        <?php endif; ?>
                                        <span class="meta">
                                            <?php 
                                            printf(
                                                __('Added %s ago', 'portfolio'),
                                                human_time_diff(get_post_time('U', false, $testimonial), current_time('timestamp'))
                                            ); 
                                            ?>
                                        </span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            
                            <a href="<?php echo esc_url(admin_url('edit.php?post_type=portfolio_testimonial')); ?>" class="button button-secondary button-small view-all"><?php _e('View All Testimonials', 'portfolio'); ?></a>
                        <?php else : ?>
                            <p class="no-items"><?php _e('No testimonials have been created yet.', 'portfolio'); ?></p>
                            <a href="<?php echo esc_url(admin_url('admin.php?page=add-new-testimonial')); ?>" class="button button-primary button-small"><?php _e('Add Your First Testimonial', 'portfolio'); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="dashboard-column">
                    <div class="dashboard-widget testimonial-tips">
                        <h3><?php _e('Tips for Great Testimonials', 'portfolio'); ?></h3>
                        <ul class="tips-list">
                            <li>
                                <span class="dashicons dashicons-yes-alt"></span>
                                <?php _e('Add real client photos to build trust with potential clients.', 'portfolio'); ?>
                            </li>
                            <li>
                                <span class="dashicons dashicons-yes-alt"></span>
                                <?php _e('Include specific results or achievements in testimonial content.', 'portfolio'); ?>
                            </li>
                            <li>
                                <span class="dashicons dashicons-yes-alt"></span>
                                <?php _e('Feature testimonials from a variety of client industries.', 'portfolio'); ?>
                            </li>
                            <li>
                                <span class="dashicons dashicons-yes-alt"></span>
                                <?php _e('Regularly update your testimonials with fresh feedback.', 'portfolio'); ?>
                            </li>
                            <li>
                                <span class="dashicons dashicons-yes-alt"></span>
                                <?php _e('Ask clients for specific feedback about your process and results.', 'portfolio'); ?>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="dashboard-widget testimonial-shortcode">
                        <h3><?php _e('Displaying Testimonials', 'portfolio'); ?></h3>
                        <p><?php _e('Use this shortcode to display testimonials anywhere on your site:', 'portfolio'); ?></p>
                        <code>[portfolio_testimonials count="4" layout="grid" columns="2"]</code>
                        
                        <div class="shortcode-options">
                            <h4><?php _e('Available Options:', 'portfolio'); ?></h4>
                            <ul>
                                <li><code>count</code>: <?php _e('Number of testimonials to show (e.g. 4)', 'portfolio'); ?></li>
                                <li><code>layout</code>: <?php _e('Layout style (grid, list, slider)', 'portfolio'); ?></li>
                                <li><code>columns</code>: <?php _e('Number of columns for grid layout (1-4)', 'portfolio'); ?></li>
                                <li><code>orderby</code>: <?php _e('Order by (date, title, rand)', 'portfolio'); ?></li>
                                <li><code>order</code>: <?php _e('Order (ASC or DESC)', 'portfolio'); ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="dashboard-help">
                <h3><?php _e('Quick Help', 'portfolio'); ?></h3>
                
                <div class="help-grid">
                    <div class="help-box">
                        <h4><span class="dashicons dashicons-admin-users"></span> <?php _e('Client Information', 'portfolio'); ?></h4>
                        <p><?php _e('Add client names, positions, and company names to give context to their testimonials.', 'portfolio'); ?></p>
                    </div>
                    
                    <div class="help-box">
                        <h4><span class="dashicons dashicons-format-image"></span> <?php _e('Client Photos', 'portfolio'); ?></h4>
                        <p><?php _e('Upload client photos as featured images to make testimonials more personal and authentic.', 'portfolio'); ?></p>
                    </div>
                    
                    <div class="help-box">
                        <h4><span class="dashicons dashicons-star-filled"></span> <?php _e('Star Ratings', 'portfolio'); ?></h4>
                        <p><?php _e('Add star ratings to provide a quick visual indicator of client satisfaction.', 'portfolio'); ?></p>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    
    /**
     * Redirect to the new testimonial page
     */
    public function redirect_to_new_testimonial() {
        // Use JavaScript redirect instead of wp_redirect to avoid headers already sent error
        ?>
        <script type="text/javascript">
            window.location.href = "<?php echo esc_url(admin_url('post-new.php?post_type=portfolio_testimonial')); ?>";
        </script>
        <?php
        echo '<p>' . __('Redirecting to add new testimonial page...', 'portfolio') . '</p>';
    }
    
    /**
     * Render dashboard widget
     */
    public function render_dashboard_widget() {
        // Get counts
        $counts = wp_count_posts('portfolio_testimonial');
        $total_testimonials = isset($counts->publish) ? $counts->publish : 0;
        
        // Get recent testimonials
        $recent_testimonials = get_posts(array(
            'post_type'      => 'portfolio_testimonial',
            'posts_per_page' => 3,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ));
        
        ?>
        <div class="testimonials-widget">
            <p class="testimonials-count">
                <?php printf(
                    _n(
                        'You have <strong>%s</strong> published testimonial.',
                        'You have <strong>%s</strong> published testimonials.',
                        $total_testimonials,
                        'portfolio'
                    ),
                    number_format_i18n($total_testimonials)
                ); ?>
            </p>
            
            <?php if (!empty($recent_testimonials)) : ?>
                <ul class="testimonials-list">
                    <?php foreach ($recent_testimonials as $testimonial) : 
                        $client_name = get_post_meta($testimonial->ID, '_portfolio_testimonial_client_name', true);
                        $client_company = get_post_meta($testimonial->ID, '_portfolio_testimonial_client_company', true);
                        
                        if (empty($client_name)) {
                            $client_name = $testimonial->post_title;
                        }
                    ?>
                        <li>
                            <span class="dashicons dashicons-format-quote"></span>
                            <a href="<?php echo esc_url(get_edit_post_link($testimonial->ID)); ?>">
                                <?php echo esc_html($client_name); ?>
                                <?php if (!empty($client_company)) : ?>
                                    <span class="client-company">(<?php echo esc_html($client_company); ?>)</span>
                                <?php endif; ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <p class="no-testimonials"><?php _e('No testimonials have been published yet.', 'portfolio'); ?></p>
            <?php endif; ?>
            
            <p class="testimonials-actions">
                <a href="<?php echo esc_url(admin_url('admin.php?page=add-new-testimonial')); ?>" class="button button-secondary button-small"><?php _e('Add Testimonial', 'portfolio'); ?></a>
                <a href="<?php echo esc_url(admin_url('edit.php?post_type=portfolio_testimonial')); ?>" class="button button-link button-small"><?php _e('Manage All', 'portfolio'); ?></a>
            </p>
        </div>
        <?php
    }
}

// Initialize the dashboard
new Portfolio_Testimonials_Dashboard();
