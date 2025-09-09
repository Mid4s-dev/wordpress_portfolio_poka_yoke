<?php
/**
 * Recent Campaigns & Projects Widget
 * 
 * @package Portfolio
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Portfolio_Recent_Campaigns_Widget extends WP_Widget {
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct(
            'portfolio_recent_campaigns',
            __('Portfolio: Recent Campaigns', 'portfolio'),
            array(
                'description' => __('Display your recent campaigns and projects', 'portfolio'),
                'classname'   => 'widget_recent_campaigns',
            )
        );
    }
    
    /**
     * Widget output
     */
    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Recent Campaigns & Projects', 'portfolio');
        $count = !empty($instance['count']) ? absint($instance['count']) : 4;
        $platform = !empty($instance['platform']) ? $instance['platform'] : '';
        
        echo $args['before_widget'];
        
        if (!empty($title)) {
            echo $args['before_title'] . apply_filters('widget_title', $title) . $args['after_title'];
        }
        
        // Build shortcode attributes
        $shortcode_atts = array(
            'count' => $count
        );
        
        if (!empty($platform)) {
            $shortcode_atts['platform'] = $platform;
        }
        
        $shortcode = '[portfolio_campaigns';
        foreach ($shortcode_atts as $key => $value) {
            $shortcode .= ' ' . $key . '="' . esc_attr($value) . '"';
        }
        $shortcode .= ']';
        
        echo do_shortcode($shortcode);
        
        if (!is_post_type_archive('portfolio_campaign') && !is_singular('portfolio_campaign')) {
            echo '<p class="mt-4 text-center"><a href="' . esc_url(get_post_type_archive_link('portfolio_campaign')) . '" class="view-all-link">' . __('View All Campaigns & Projects', 'portfolio') . '</a></p>';
        }
        
        echo $args['after_widget'];
    }
    
    /**
     * Widget form
     */
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Recent Campaigns & Projects', 'portfolio');
        $count = !empty($instance['count']) ? absint($instance['count']) : 4;
        $platform = !empty($instance['platform']) ? $instance['platform'] : '';
        
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'portfolio'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('count')); ?>"><?php esc_html_e('Number of campaigns to show:', 'portfolio'); ?></label>
            <input class="tiny-text" id="<?php echo esc_attr($this->get_field_id('count')); ?>" name="<?php echo esc_attr($this->get_field_name('count')); ?>" type="number" step="1" min="1" value="<?php echo esc_attr($count); ?>" size="3">
        </p>
        
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('platform')); ?>"><?php esc_html_e('Filter by platform:', 'portfolio'); ?></label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('platform')); ?>" name="<?php echo esc_attr($this->get_field_name('platform')); ?>">
                <option value="" <?php selected($platform, ''); ?>><?php esc_html_e('All Platforms', 'portfolio'); ?></option>
                <option value="linkedin" <?php selected($platform, 'linkedin'); ?>><?php esc_html_e('LinkedIn', 'portfolio'); ?></option>
                <option value="instagram" <?php selected($platform, 'instagram'); ?>><?php esc_html_e('Instagram', 'portfolio'); ?></option>
                <option value="twitter" <?php selected($platform, 'twitter'); ?>><?php esc_html_e('Twitter', 'portfolio'); ?></option>
                <option value="project" <?php selected($platform, 'project'); ?>><?php esc_html_e('Projects', 'portfolio'); ?></option>
                <option value="campaign" <?php selected($platform, 'campaign'); ?>><?php esc_html_e('Campaigns', 'portfolio'); ?></option>
            </select>
        </p>
        <?php
    }
    
    /**
     * Widget update
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['count'] = (!empty($new_instance['count'])) ? absint($new_instance['count']) : 4;
        $instance['platform'] = (!empty($new_instance['platform'])) ? sanitize_text_field($new_instance['platform']) : '';
        
        return $instance;
    }
}

// Register the widget
function register_portfolio_campaigns_widget() {
    register_widget('Portfolio_Recent_Campaigns_Widget');
}
add_action('widgets_init', 'register_portfolio_campaigns_widget');
