<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Visitor tracking (page views, interactions).
 */
class Portfolio_Visitor_Tracking {

    /**
     * Bootstrap hooks.
     */
    public function __construct() {
        add_action('init', array($this, 'register_post_type'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_tracking_script'));

        add_action('wp_ajax_portfolio_track_event', array($this, 'handle_event'));
        add_action('wp_ajax_nopriv_portfolio_track_event', array($this, 'handle_event'));
    }

    /**
     * Register CPT to store events.
     */
    public function register_post_type() {
        register_post_type('portfolio_visitor_event', array(
            'labels' => array(
                'name'          => __('Visitor Events', 'portfolio'),
                'singular_name' => __('Visitor Event', 'portfolio'),
                'menu_name'     => __('Visitor Events', 'portfolio'),
            ),
            'public'              => false,
            'show_ui'             => true,
            'show_in_menu'        => false,
            'capability_type'     => 'post',
            'capabilities'        => array('create_posts' => false),
            'map_meta_cap'        => true,
            'publicly_queryable'  => false,
            'exclude_from_search' => true,
            'supports'            => array('title'),
        ));
    }

    /**
     * Enqueue tracking script and seed data.
     */
    public function enqueue_tracking_script() {
        $script_path = get_template_directory() . '/assets/js/visitor-tracking.js';
        if (!file_exists($script_path)) {
            return;
        }

        wp_enqueue_script(
            'portfolio-visitor-tracking',
            get_theme_file_uri('assets/js/visitor-tracking.js'),
            array(),
            filemtime($script_path),
            true
        );

        wp_localize_script('portfolio-visitor-tracking', 'portfolioVisitorTrackingData', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('portfolio_visitor_tracking'),
            'siteUrl' => home_url('/'),
        ));
    }

    /**
     * Handle incoming tracking events via AJAX.
     */
    public function handle_event() {
        check_ajax_referer('portfolio_visitor_tracking', 'nonce');

        $payload = isset($_POST['event']) ? json_decode(stripslashes($_POST['event']), true) : null;
        if (!is_array($payload)) {
            wp_send_json_error(array('message' => 'Invalid payload'), 400);
        }

        $allowed_keys = array(
            'event_type', 'page_url', 'referrer', 'page_title', 'session_id', 'ts',
            'user_agent', 'screen_width', 'screen_height', 'viewport_width', 'viewport_height',
            'language', 'timezone_offset', 'scroll_depth', 'time_on_page_ms'
        );

        $event = array();
        foreach ($allowed_keys as $key) {
            if (isset($payload[$key])) {
                $event[$key] = sanitize_text_field($payload[$key]);
            }
        }

        if (empty($event['event_type']) || empty($event['page_url'])) {
            wp_send_json_error(array('message' => 'Missing required fields'), 422);
        }

        $ip_address = isset($_SERVER['REMOTE_ADDR']) ? sanitize_text_field(wp_unslash($_SERVER['REMOTE_ADDR'])) : '';
        if ($ip_address) {
            $event['ip_address'] = $ip_address;
        }

        $title = sprintf('%s - %s', $event['event_type'], $event['page_url']);

        $post_id = wp_insert_post(array(
            'post_type'   => 'portfolio_visitor_event',
            'post_status' => 'publish',
            'post_title'  => wp_trim_words($title, 12, '...'),
        ), true);

        if (is_wp_error($post_id)) {
            wp_send_json_error(array('message' => 'Insert failed'), 500);
        }

        foreach ($event as $meta_key => $meta_value) {
            update_post_meta($post_id, '_' . $meta_key, $meta_value);
        }

        wp_send_json_success(array('stored' => true));
    }
}

// Initialize tracking.
new Portfolio_Visitor_Tracking();
