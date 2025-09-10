<?php
/**
 * Services Widget Class
 * 
 * A widget to display services in the sidebar
 *
 * @package WordPress
 * @subpackage Portfolio
 * @since 1.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Services Widget
 */
class Portfolio_Services_Widget extends WP_Widget {
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct(
            'portfolio_services_widget',
            __('Portfolio Services', 'portfolio'),
            array(
                'description' => __('Display your services in a widget.', 'portfolio'),
            )
        );
    }
    
    /**
     * Widget output
     */
    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? apply_filters('widget_title', $instance['title']) : '';
        $count = !empty($instance['count']) ? intval($instance['count']) : 3;
        $featured_only = !empty($instance['featured_only']) ? 'yes' : 'no';
        $layout = !empty($instance['layout']) ? $instance['layout'] : 'list';
        
        echo $args['before_widget'];
        
        if ($title) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        
        // Use the shortcode to display services
        echo do_shortcode('[portfolio_services count="' . $count . '" featured_only="' . $featured_only . '" layout="' . $layout . '" columns="1"]');
        
        echo $args['after_widget'];
    }
    
    /**
     * Widget form
     */
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Our Services', 'portfolio');
        $count = !empty($instance['count']) ? intval($instance['count']) : 3;
        $featured_only = !empty($instance['featured_only']) ? (bool) $instance['featured_only'] : false;
        $layout = !empty($instance['layout']) ? $instance['layout'] : 'list';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'portfolio'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Number of services to show:', 'portfolio'); ?></label>
            <input class="tiny-text" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="number" step="1" min="1" value="<?php echo esc_attr($count); ?>" size="3">
        </p>
        <p>
            <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('featured_only'); ?>" name="<?php echo $this->get_field_name('featured_only'); ?>"<?php checked($featured_only); ?>>
            <label for="<?php echo $this->get_field_id('featured_only'); ?>"><?php _e('Show only featured services', 'portfolio'); ?></label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('layout'); ?>"><?php _e('Layout:', 'portfolio'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('layout'); ?>" name="<?php echo $this->get_field_name('layout'); ?>">
                <option value="list" <?php selected($layout, 'list'); ?>><?php _e('List', 'portfolio'); ?></option>
                <option value="grid" <?php selected($layout, 'grid'); ?>><?php _e('Grid', 'portfolio'); ?></option>
            </select>
        </p>
        <?php
    }
    
    /**
     * Update widget settings
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = !empty($new_instance['title']) ? sanitize_text_field($new_instance['title']) : '';
        $instance['count'] = !empty($new_instance['count']) ? intval($new_instance['count']) : 3;
        $instance['featured_only'] = !empty($new_instance['featured_only']) ? 1 : 0;
        $instance['layout'] = !empty($new_instance['layout']) ? sanitize_text_field($new_instance['layout']) : 'list';
        
        return $instance;
    }
}
