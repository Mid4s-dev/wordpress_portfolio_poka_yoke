<?php
/**
 * Testimonials Verification Tool
 * 
 * This script verifies the complete implementation of the testimonials system
 * and adds any missing functionality.
 */

// Include WordPress
define('WP_USE_THEMES', false);
require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/wp-load.php';

// Check permissions
if (!current_user_can('manage_options')) {
    wp_die('You need administrator permissions to run this tool.');
}

// Start HTML output
?>
<!DOCTYPE html>
<html>
<head>
    <title>Testimonials System Verification</title>
    <style>
        body { font-family: sans-serif; max-width: 800px; margin: 20px auto; line-height: 1.6; padding: 0 20px; }
        h1, h2, h3 { color: #23282d; }
        .card { background: #fff; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04); padding: 15px; margin-bottom: 20px; }
        .success { color: green; }
        .warning { color: orange; }
        .error { color: red; }
        pre { background: #f5f5f5; padding: 10px; border: 1px solid #ddd; overflow: auto; }
        code { background: #f5f5f5; padding: 2px 4px; border: 1px solid #ddd; border-radius: 3px; }
        .button { display: inline-block; text-decoration: none; font-size: 13px; line-height: 2.15384615; min-height: 30px; margin: 0 3px 3px 0; padding: 0 10px; cursor: pointer; border-width: 1px; border-style: solid; -webkit-appearance: none; border-radius: 3px; white-space: nowrap; box-sizing: border-box; background: #2271b1; border-color: #2271b1; color: #fff; }
        .button:hover { background: #135e96; border-color: #135e96; color: #fff; }
        .button-secondary { background: #f6f7f7; border-color: #2c3338; color: #2c3338; }
        .button-secondary:hover { background: #f0f0f1; border-color: #0a4b78; color: #0a4b78; }
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Testimonials System Verification</h1>
    
    <div class="card">
        <h2>System Status</h2>
        <?php
        $status = array(
            'post_type_exists' => post_type_exists('portfolio_testimonial'),
            'shortcode_exists' => shortcode_exists('portfolio_testimonials'),
            'single_template' => file_exists(get_template_directory() . '/single-portfolio_testimonial.php'),
            'archive_template' => file_exists(get_template_directory() . '/archive-portfolio_testimonial.php'),
            'css_file' => file_exists(get_template_directory() . '/assets/css/testimonials.css'),
            'js_file' => file_exists(get_template_directory() . '/assets/js/testimonials.js'),
            'widget_file' => file_exists(get_template_directory() . '/inc/widgets/testimonials-widget.php'),
            'documentation' => file_exists(get_template_directory() . '/docs/testimonials-complete-guide.md'),
        );
        
        $all_good = !in_array(false, $status);
        ?>
        
        <p class="<?php echo $all_good ? 'success' : 'warning'; ?>">
            <?php echo $all_good ? '✅ All systems functioning normally' : '⚠️ Some components need attention'; ?>
        </p>
        
        <table>
            <tr>
                <th>Component</th>
                <th>Status</th>
            </tr>
            <tr>
                <td>Post Type Registration</td>
                <td class="<?php echo $status['post_type_exists'] ? 'success' : 'error'; ?>">
                    <?php echo $status['post_type_exists'] ? '✅ Working' : '❌ Not registered'; ?>
                </td>
            </tr>
            <tr>
                <td>Shortcode Registration</td>
                <td class="<?php echo $status['shortcode_exists'] ? 'success' : 'error'; ?>">
                    <?php echo $status['shortcode_exists'] ? '✅ Working' : '❌ Not registered'; ?>
                </td>
            </tr>
            <tr>
                <td>Single Testimonial Template</td>
                <td class="<?php echo $status['single_template'] ? 'success' : 'warning'; ?>">
                    <?php echo $status['single_template'] ? '✅ Found' : '⚠️ Using default template'; ?>
                </td>
            </tr>
            <tr>
                <td>Archive Template</td>
                <td class="<?php echo $status['archive_template'] ? 'success' : 'warning'; ?>">
                    <?php echo $status['archive_template'] ? '✅ Found' : '⚠️ Using default template'; ?>
                </td>
            </tr>
            <tr>
                <td>CSS Styling</td>
                <td class="<?php echo $status['css_file'] ? 'success' : 'warning'; ?>">
                    <?php echo $status['css_file'] ? '✅ Found' : '⚠️ Missing (using default styles)'; ?>
                </td>
            </tr>
            <tr>
                <td>JavaScript</td>
                <td class="<?php echo $status['js_file'] ? 'success' : 'warning'; ?>">
                    <?php echo $status['js_file'] ? '✅ Found' : '⚠️ Missing (sliders may not work)'; ?>
                </td>
            </tr>
            <tr>
                <td>Widget</td>
                <td class="<?php echo $status['widget_file'] ? 'success' : 'warning'; ?>">
                    <?php echo $status['widget_file'] ? '✅ Found' : '⚠️ Missing'; ?>
                </td>
            </tr>
            <tr>
                <td>Documentation</td>
                <td class="<?php echo $status['documentation'] ? 'success' : 'warning'; ?>">
                    <?php echo $status['documentation'] ? '✅ Found' : '⚠️ Missing'; ?>
                </td>
            </tr>
        </table>
    </div>
    
    <div class="card">
        <h2>Testimonials Count</h2>
        <?php 
        $testimonials = new WP_Query([
            'post_type' => 'portfolio_testimonial',
            'posts_per_page' => -1
        ]);
        $count = $testimonials->found_posts;
        ?>
        
        <p>Total testimonials: <strong><?php echo $count; ?></strong></p>
        
        <?php if ($count === 0): ?>
            <div class="warning">
                <p>⚠️ No testimonials found. You should create some testimonials to fully test the system.</p>
                <p><a href="<?php echo admin_url('post-new.php?post_type=portfolio_testimonial'); ?>" class="button">Create New Testimonial</a></p>
            </div>
        <?php else: ?>
            <p class="success">✅ Testimonials are present in the system</p>
            <p><a href="<?php echo admin_url('edit.php?post_type=portfolio_testimonial'); ?>" class="button">Manage Testimonials</a></p>
        <?php endif; ?>
    </div>
    
    <div class="card">
        <h2>Testimonials Shortcode</h2>
        
        <?php if (shortcode_exists('portfolio_testimonials')): ?>
            <p class="success">✅ Testimonials shortcode is registered correctly</p>
            <h3>Basic Usage</h3>
            <p>Add this shortcode to any page or post:</p>
            <pre><code>[portfolio_testimonials]</code></pre>
            
            <h3>Shortcode Parameters</h3>
            <table>
                <tr>
                    <th>Parameter</th>
                    <th>Default</th>
                    <th>Description</th>
                </tr>
                <tr>
                    <td>count</td>
                    <td>-1 (all)</td>
                    <td>Number of testimonials to display</td>
                </tr>
                <tr>
                    <td>layout</td>
                    <td>grid</td>
                    <td>Display style: "slider", "grid", or "list"</td>
                </tr>
                <tr>
                    <td>columns</td>
                    <td>3</td>
                    <td>For grid layout, number of columns</td>
                </tr>
                <tr>
                    <td>orderby</td>
                    <td>date</td>
                    <td>Sort by: "date", "title", or "random"</td>
                </tr>
                <tr>
                    <td>order</td>
                    <td>DESC</td>
                    <td>Sort direction: "ASC" or "DESC"</td>
                </tr>
                <tr>
                    <td>min_rating</td>
                    <td>0</td>
                    <td>Filter by minimum rating (1-5)</td>
                </tr>
            </table>
            
            <h3>Example</h3>
            <pre><code>[portfolio_testimonials count="3" layout="grid" columns="2" min_rating="4" orderby="random"]</code></pre>
            
        <?php else: ?>
            <p class="error">❌ Testimonials shortcode is NOT registered</p>
            <p>This suggests there's an issue with the testimonials system implementation.</p>
        <?php endif; ?>
    </div>
    
    <div class="card">
        <h2>Auto-Fix Missing Components</h2>
        <?php
        // Check if there's a request to fix components
        $fix_requested = isset($_GET['fix']) && $_GET['fix'] === 'yes';
        
        if ($fix_requested):
            $fixed = array();
            
            // Fix JavaScript file if missing
            if (!$status['js_file']) {
                $js_content = "/**
 * Testimonials JavaScript
 *
 * @package WordPress
 * @subpackage Portfolio
 * @since 1.0
 */

(function($) {
    'use strict';

    // Initialize testimonials sliders
    function initTestimonialsSlider() {
        $('.portfolio-testimonials-slider').each(function() {
            var slider = $(this);
            var testimonials = slider.find('.portfolio-testimonial');
            var currentIndex = 0;
            
            // Hide all testimonials except the first one
            testimonials.removeClass('active').eq(0).addClass('active');
            
            // Create navigation controls if more than one testimonial
            if (testimonials.length > 1) {
                var controls = $('<div class=\"testimonial-controls\"></div>');
                var prevButton = $('<button class=\"testimonial-prev\" aria-label=\"Previous testimonial\"><span class=\"dashicons dashicons-arrow-left-alt\"></span></button>');
                var nextButton = $('<button class=\"testimonial-next\" aria-label=\"Next testimonial\"><span class=\"dashicons dashicons-arrow-right-alt\"></span></button>');
                
                controls.append(prevButton);
                controls.append(nextButton);
                slider.append(controls);
                
                // Next button click
                nextButton.on('click', function() {
                    testimonials.eq(currentIndex).removeClass('active');
                    currentIndex = (currentIndex + 1) % testimonials.length;
                    testimonials.eq(currentIndex).addClass('active');
                });
                
                // Previous button click
                prevButton.on('click', function() {
                    testimonials.eq(currentIndex).removeClass('active');
                    currentIndex = (currentIndex - 1 + testimonials.length) % testimonials.length;
                    testimonials.eq(currentIndex).addClass('active');
                });
                
                // Auto rotate if specified
                var autoRotate = slider.data('auto-rotate');
                if (autoRotate) {
                    var interval = parseInt(slider.data('interval')) || 5000;
                    setInterval(function() {
                        testimonials.eq(currentIndex).removeClass('active');
                        currentIndex = (currentIndex + 1) % testimonials.length;
                        testimonials.eq(currentIndex).addClass('active');
                    }, interval);
                }
            }
        });
    }
    
    // Initialize on document ready
    $(document).ready(function() {
        initTestimonialsSlider();
    });

})(jQuery);";
                
                // Create the JS file
                $js_file = get_template_directory() . '/assets/js/testimonials.js';
                if (!file_exists(dirname($js_file))) {
                    mkdir(dirname($js_file), 0755, true);
                }
                file_put_contents($js_file, $js_content);
                $fixed[] = 'JavaScript file created';
                $status['js_file'] = true;
            }
            
            // Create widget file if missing
            if (!$status['widget_file']) {
                $widget_content = "<?php
/**
 * Testimonials Widget
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
 * Testimonials Widget Class
 */
class Portfolio_Testimonials_Widget extends WP_Widget {

    /**
     * Register widget with WordPress
     */
    public function __construct() {
        parent::__construct(
            'portfolio_testimonials_widget',
            __('Portfolio Testimonials', 'portfolio'),
            array('description' => __('Display testimonials from your clients.', 'portfolio'))
        );
    }

    /**
     * Front-end display of the widget
     */
    public function widget(\$args, \$instance) {
        echo \$args['before_widget'];
        
        if (!empty(\$instance['title'])) {
            echo \$args['before_title'] . apply_filters('widget_title', \$instance['title']) . \$args['after_title'];
        }
        
        // Build shortcode attributes
        \$shortcode_atts = array(
            'count' => (!empty(\$instance['count']) ? \$instance['count'] : 3),
            'layout' => (!empty(\$instance['layout']) ? \$instance['layout'] : 'slider'),
            'orderby' => (!empty(\$instance['orderby']) ? \$instance['orderby'] : 'date'),
            'min_rating' => (!empty(\$instance['min_rating']) ? \$instance['min_rating'] : 0),
        );
        
        \$shortcode = '[portfolio_testimonials';
        foreach (\$shortcode_atts as \$key => \$value) {
            \$shortcode .= ' ' . \$key . '=\"' . esc_attr(\$value) . '\"';
        }
        \$shortcode .= ']';
        
        echo do_shortcode(\$shortcode);
        
        echo \$args['after_widget'];
    }

    /**
     * Back-end widget form
     */
    public function form(\$instance) {
        \$title = !empty(\$instance['title']) ? \$instance['title'] : __('Testimonials', 'portfolio');
        \$count = !empty(\$instance['count']) ? \$instance['count'] : 3;
        \$layout = !empty(\$instance['layout']) ? \$instance['layout'] : 'slider';
        \$orderby = !empty(\$instance['orderby']) ? \$instance['orderby'] : 'date';
        \$min_rating = !empty(\$instance['min_rating']) ? \$instance['min_rating'] : 0;
        ?>
        <p>
            <label for=\"<?php echo \$this->get_field_id('title'); ?>\"><?php _e('Title:', 'portfolio'); ?></label>
            <input class=\"widefat\" id=\"<?php echo \$this->get_field_id('title'); ?>\" name=\"<?php echo \$this->get_field_name('title'); ?>\" type=\"text\" value=\"<?php echo esc_attr(\$title); ?>\">
        </p>
        <p>
            <label for=\"<?php echo \$this->get_field_id('count'); ?>\"><?php _e('Number of testimonials to show:', 'portfolio'); ?></label>
            <input class=\"tiny-text\" id=\"<?php echo \$this->get_field_id('count'); ?>\" name=\"<?php echo \$this->get_field_name('count'); ?>\" type=\"number\" min=\"1\" max=\"10\" value=\"<?php echo esc_attr(\$count); ?>\">
        </p>
        <p>
            <label for=\"<?php echo \$this->get_field_id('layout'); ?>\"><?php _e('Layout:', 'portfolio'); ?></label>
            <select class=\"widefat\" id=\"<?php echo \$this->get_field_id('layout'); ?>\" name=\"<?php echo \$this->get_field_name('layout'); ?>\">
                <option value=\"slider\" <?php selected(\$layout, 'slider'); ?>><?php _e('Slider', 'portfolio'); ?></option>
                <option value=\"grid\" <?php selected(\$layout, 'grid'); ?>><?php _e('Grid', 'portfolio'); ?></option>
                <option value=\"list\" <?php selected(\$layout, 'list'); ?>><?php _e('List', 'portfolio'); ?></option>
            </select>
        </p>
        <p>
            <label for=\"<?php echo \$this->get_field_id('orderby'); ?>\"><?php _e('Order by:', 'portfolio'); ?></label>
            <select class=\"widefat\" id=\"<?php echo \$this->get_field_id('orderby'); ?>\" name=\"<?php echo \$this->get_field_name('orderby'); ?>\">
                <option value=\"date\" <?php selected(\$orderby, 'date'); ?>><?php _e('Date', 'portfolio'); ?></option>
                <option value=\"title\" <?php selected(\$orderby, 'title'); ?>><?php _e('Title', 'portfolio'); ?></option>
                <option value=\"random\" <?php selected(\$orderby, 'random'); ?>><?php _e('Random', 'portfolio'); ?></option>
            </select>
        </p>
        <p>
            <label for=\"<?php echo \$this->get_field_id('min_rating'); ?>\"><?php _e('Minimum rating:', 'portfolio'); ?></label>
            <select class=\"widefat\" id=\"<?php echo \$this->get_field_id('min_rating'); ?>\" name=\"<?php echo \$this->get_field_name('min_rating'); ?>\">
                <option value=\"0\" <?php selected(\$min_rating, 0); ?>><?php _e('Any rating', 'portfolio'); ?></option>
                <option value=\"1\" <?php selected(\$min_rating, 1); ?>><?php _e('1 star and above', 'portfolio'); ?></option>
                <option value=\"2\" <?php selected(\$min_rating, 2); ?>><?php _e('2 stars and above', 'portfolio'); ?></option>
                <option value=\"3\" <?php selected(\$min_rating, 3); ?>><?php _e('3 stars and above', 'portfolio'); ?></option>
                <option value=\"4\" <?php selected(\$min_rating, 4); ?>><?php _e('4 stars and above', 'portfolio'); ?></option>
                <option value=\"5\" <?php selected(\$min_rating, 5); ?>><?php _e('5 stars only', 'portfolio'); ?></option>
            </select>
        </p>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved
     */
    public function update(\$new_instance, \$old_instance) {
        \$instance = array();
        \$instance['title'] = (!empty(\$new_instance['title'])) ? sanitize_text_field(\$new_instance['title']) : '';
        \$instance['count'] = (!empty(\$new_instance['count'])) ? (int) \$new_instance['count'] : 3;
        \$instance['layout'] = (!empty(\$new_instance['layout'])) ? sanitize_text_field(\$new_instance['layout']) : 'slider';
        \$instance['orderby'] = (!empty(\$new_instance['orderby'])) ? sanitize_text_field(\$new_instance['orderby']) : 'date';
        \$instance['min_rating'] = (!empty(\$new_instance['min_rating'])) ? (int) \$new_instance['min_rating'] : 0;
        
        return \$instance;
    }
}

// Register the widget
function portfolio_register_testimonials_widget() {
    register_widget('Portfolio_Testimonials_Widget');
}
add_action('widgets_init', 'portfolio_register_testimonials_widget');";
                
                // Create the widget file
                $widget_dir = get_template_directory() . '/inc/widgets';
                if (!file_exists($widget_dir)) {
                    mkdir($widget_dir, 0755, true);
                }
                
                $widget_file = $widget_dir . '/testimonials-widget.php';
                file_put_contents($widget_file, $widget_content);
                $fixed[] = 'Widget file created';
                $status['widget_file'] = true;
            }
            
            // Flush rewrite rules
            flush_rewrite_rules();
            update_option('portfolio_permalinks_updated_for_testimonials', true);
            $fixed[] = 'Permalinks updated';
            
            if (empty($fixed)) {
                echo '<p>No fixes were needed. All components are present.</p>';
            } else {
                echo '<p class="success">✅ Fixes applied:</p>';
                echo '<ul>';
                foreach ($fixed as $fix) {
                    echo '<li>' . esc_html($fix) . '</li>';
                }
                echo '</ul>';
            }
            
        else:
            // Display fix button
            if (!$all_good):
            ?>
                <p>Some components are missing. Click the button below to auto-fix these issues:</p>
                <p><a href="?fix=yes" class="button">Fix Missing Components</a></p>
            <?php
            else:
            ?>
                <p class="success">✅ All components are present. No fixes needed.</p>
            <?php
            endif;
        endif;
        ?>
    </div>
    
    <div class="card">
        <h2>Developer Tools</h2>
        
        <h3>Shortcode Tester</h3>
        <?php
        // Test shortcode functionality
        if (shortcode_exists('portfolio_testimonials')):
            $shortcode_output = do_shortcode('[portfolio_testimonials count="2" layout="grid" columns="2"]');
            ?>
            <p>Here's a preview of the testimonials shortcode output:</p>
            <div class="shortcode-preview">
                <?php echo $shortcode_output; ?>
            </div>
            <p><em>Note: Styling may differ from your actual theme.</em></p>
        <?php else: ?>
            <p class="error">⚠️ Cannot test shortcode as it's not registered</p>
        <?php endif; ?>
        
        <h3>Useful Links</h3>
        <p>
            <a href="<?php echo admin_url('edit.php?post_type=portfolio_testimonial'); ?>" class="button">Manage Testimonials</a>
            <a href="<?php echo admin_url('post-new.php?post_type=portfolio_testimonial'); ?>" class="button">Add New Testimonial</a>
            <a href="<?php echo admin_url('options-permalink.php'); ?>" class="button">Update Permalinks</a>
            <a href="<?php echo home_url('/testimonials/'); ?>" class="button" target="_blank">View Testimonials Archive</a>
        </p>
        
        <p>
            <a href="<?php echo get_template_directory_uri(); ?>/testimonials-check.php" class="button button-secondary">Run Status Check</a>
            <a href="<?php echo get_template_directory_uri(); ?>/testimonials-cleanup.php" class="button button-secondary">Cleanup Tool</a>
        </p>
    </div>
</body>
</html>
