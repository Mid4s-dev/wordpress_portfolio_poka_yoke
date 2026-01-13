<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Minimal admin page to inspect visitor events.
 */
class Portfolio_Visitor_Analytics_Page {
    public function __construct() {
        add_action('admin_menu', array($this, 'register_menu')); // Add menu entry.
    }

    public function register_menu() {
        add_submenu_page(
            'tools.php',
            __('Visitor Analytics', 'portfolio'),
            __('Visitor Analytics', 'portfolio'),
            'manage_options',
            'portfolio-visitor-analytics',
            array($this, 'render_page')
        );
    }

    public function render_page() {
        $events = new WP_Query(array(
            'post_type'      => 'portfolio_visitor_event',
            'posts_per_page' => 50,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ));
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('Visitor Analytics', 'portfolio'); ?></h1>
            <p><?php esc_html_e('Recent visitor events (last 50).', 'portfolio'); ?></p>

            <table class="widefat fixed striped">
                <thead>
                    <tr>
                        <th><?php esc_html_e('Date', 'portfolio'); ?></th>
                        <th><?php esc_html_e('Event', 'portfolio'); ?></th>
                        <th><?php esc_html_e('Page URL', 'portfolio'); ?></th>
                        <th><?php esc_html_e('Referrer', 'portfolio'); ?></th>
                        <th><?php esc_html_e('Session', 'portfolio'); ?></th>
                        <th><?php esc_html_e('IP', 'portfolio'); ?></th>
                        <th><?php esc_html_e('Scroll %', 'portfolio'); ?></th>
                        <th><?php esc_html_e('Time on Page (ms)', 'portfolio'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($events->have_posts()) : ?>
                        <?php while ($events->have_posts()) : $events->the_post(); ?>
                            <?php
                                $post_id = get_the_ID();
                                $event_type = get_post_meta($post_id, '_event_type', true);
                                $page_url = get_post_meta($post_id, '_page_url', true);
                                $referrer = get_post_meta($post_id, '_referrer', true);
                                $session = get_post_meta($post_id, '_session_id', true);
                                $ip = get_post_meta($post_id, '_ip_address', true);
                                $scroll = get_post_meta($post_id, '_scroll_depth', true);
                                $time_on_page = get_post_meta($post_id, '_time_on_page_ms', true);
                            ?>
                            <tr>
                                <td><?php echo esc_html(get_the_date('Y-m-d H:i')); ?></td>
                                <td><?php echo esc_html($event_type); ?></td>
                                <td style="max-width:240px; word-break:break-all;">
                                    <a href="<?php echo esc_url($page_url); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html($page_url); ?></a>
                                </td>
                                <td style="max-width:200px; word-break:break-all;">
                                    <?php echo $referrer ? '<a href="' . esc_url($referrer) . '" target="_blank" rel="noopener noreferrer">' . esc_html($referrer) . '</a>' : '&mdash;'; ?>
                                </td>
                                <td><?php echo esc_html($session); ?></td>
                                <td><?php echo esc_html($ip); ?></td>
                                <td><?php echo esc_html($scroll); ?></td>
                                <td><?php echo esc_html($time_on_page); ?></td>
                            </tr>
                        <?php endwhile; wp_reset_postdata(); ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="8"><?php esc_html_e('No events recorded yet.', 'portfolio'); ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php
    }
}

// Initialize admin page.
if (is_admin()) {
    new Portfolio_Visitor_Analytics_Page();
}
