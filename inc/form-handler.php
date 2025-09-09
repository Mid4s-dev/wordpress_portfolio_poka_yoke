<?php
/**
 * Form Handler - Manages contact forms and newsletter subscriptions
 *
 * @package Portfolio
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Form Handler Class
 */
class Portfolio_Form_Handler {

    /**
     * Constructor
     */
    public function __construct() {
        // Register custom post types
        add_action('init', array($this, 'register_custom_post_types'));
        
        // Add admin menu items
        add_action('admin_menu', array($this, 'add_admin_menu_items'));
        
        // Register AJAX actions for form submissions
        add_action('wp_ajax_portfolio_contact_form', array($this, 'handle_contact_form'));
        add_action('wp_ajax_nopriv_portfolio_contact_form', array($this, 'handle_contact_form'));
        
        add_action('wp_ajax_portfolio_newsletter_form', array($this, 'handle_newsletter_form'));
        add_action('wp_ajax_nopriv_portfolio_newsletter_form', array($this, 'handle_newsletter_form'));
        
        // Add script for form handling
        add_action('wp_enqueue_scripts', array($this, 'enqueue_form_scripts'));
        
        // Add custom columns for contact messages
        add_filter('manage_portfolio_contact_posts_columns', array($this, 'set_contact_columns'));
        add_action('manage_portfolio_contact_posts_custom_column', array($this, 'contact_custom_column'), 10, 2);
        
        // Add custom columns for newsletter subscribers
        add_filter('manage_portfolio_subscriber_posts_columns', array($this, 'set_subscriber_columns'));
        add_action('manage_portfolio_subscriber_posts_custom_column', array($this, 'subscriber_custom_column'), 10, 2);
        
        // Register settings for newsletter
        add_action('admin_init', array($this, 'register_newsletter_settings'));
    }

    /**
     * Register custom post types for contact messages and subscribers
     */
    public function register_custom_post_types() {
        // Contact Messages Post Type
        register_post_type('portfolio_contact', array(
            'labels' => array(
                'name'               => __('Contact Messages', 'portfolio'),
                'singular_name'      => __('Contact Message', 'portfolio'),
                'menu_name'          => __('Contact Messages', 'portfolio'),
                'all_items'          => __('All Messages', 'portfolio'),
                'view_item'          => __('View Message', 'portfolio'),
                'search_items'       => __('Search Messages', 'portfolio'),
                'not_found'          => __('No messages found', 'portfolio'),
                'not_found_in_trash' => __('No messages found in trash', 'portfolio')
            ),
            'public'              => false,
            'show_ui'             => true,
            'capability_type'     => 'post',
            'capabilities'        => array(
                'create_posts' => false,
            ),
            'map_meta_cap'        => true,
            'publicly_queryable'  => false,
            'exclude_from_search' => true,
            'show_in_nav_menus'   => false,
            'menu_icon'           => 'dashicons-email-alt',
            'supports'            => array('title'),
        ));
        
        // Newsletter Subscribers Post Type
        register_post_type('portfolio_subscriber', array(
            'labels' => array(
                'name'               => __('Newsletter Subscribers', 'portfolio'),
                'singular_name'      => __('Subscriber', 'portfolio'),
                'menu_name'          => __('Newsletter', 'portfolio'),
                'all_items'          => __('All Subscribers', 'portfolio'),
                'view_item'          => __('View Subscriber', 'portfolio'),
                'search_items'       => __('Search Subscribers', 'portfolio'),
                'not_found'          => __('No subscribers found', 'portfolio'),
                'not_found_in_trash' => __('No subscribers found in trash', 'portfolio')
            ),
            'public'              => false,
            'show_ui'             => true,
            'capability_type'     => 'post',
            'capabilities'        => array(
                'create_posts' => false,
            ),
            'map_meta_cap'        => true,
            'publicly_queryable'  => false,
            'exclude_from_search' => true,
            'show_in_nav_menus'   => false,
            'menu_icon'           => 'dashicons-groups',
            'supports'            => array('title'),
        ));
    }

    /**
     * Add admin menu items for newsletter sending
     */
    public function add_admin_menu_items() {
        add_submenu_page(
            'edit.php?post_type=portfolio_subscriber',
            __('Send Newsletter', 'portfolio'),
            __('Send Newsletter', 'portfolio'),
            'manage_options',
            'portfolio-send-newsletter',
            array($this, 'newsletter_admin_page')
        );
    }
    
    /**
     * Set custom columns for contact messages
     */
    public function set_contact_columns($columns) {
        $columns = array(
            'cb'        => $columns['cb'],
            'title'     => __('Name', 'portfolio'),
            'email'     => __('Email', 'portfolio'),
            'subject'   => __('Subject', 'portfolio'),
            'message'   => __('Message', 'portfolio'),
            'date'      => __('Date', 'portfolio'),
        );
        
        return $columns;
    }
    
    /**
     * Display contact message custom columns
     */
    public function contact_custom_column($column, $post_id) {
        switch ($column) {
            case 'email':
                echo esc_html(get_post_meta($post_id, '_contact_email', true));
                break;
            case 'subject':
                echo esc_html(get_post_meta($post_id, '_contact_subject', true));
                break;
            case 'message':
                $message = get_post_meta($post_id, '_contact_message', true);
                echo '<div style="max-height:100px;overflow:auto;">' . esc_html($message) . '</div>';
                break;
        }
    }
    
    /**
     * Set custom columns for subscribers
     */
    public function set_subscriber_columns($columns) {
        $columns = array(
            'cb'        => $columns['cb'],
            'title'     => __('Name', 'portfolio'),
            'email'     => __('Email', 'portfolio'),
            'status'    => __('Status', 'portfolio'),
            'date'      => __('Subscribed Date', 'portfolio'),
        );
        
        return $columns;
    }
    
    /**
     * Display subscriber custom columns
     */
    public function subscriber_custom_column($column, $post_id) {
        switch ($column) {
            case 'email':
                echo esc_html(get_post_meta($post_id, '_subscriber_email', true));
                break;
            case 'status':
                $status = get_post_meta($post_id, '_subscriber_status', true);
                echo esc_html(ucfirst($status ? $status : 'active'));
                break;
        }
    }
    
    /**
     * Register newsletter settings
     */
    public function register_newsletter_settings() {
        register_setting('portfolio_newsletter_options', 'portfolio_newsletter_settings');
        
        add_settings_section(
            'portfolio_newsletter_section',
            __('Newsletter Settings', 'portfolio'),
            array($this, 'newsletter_section_callback'),
            'portfolio-newsletter'
        );
        
        add_settings_field(
            'welcome_email_subject',
            __('Welcome Email Subject', 'portfolio'),
            array($this, 'welcome_email_subject_callback'),
            'portfolio-newsletter',
            'portfolio_newsletter_section'
        );
        
        add_settings_field(
            'welcome_email_content',
            __('Welcome Email Content', 'portfolio'),
            array($this, 'welcome_email_content_callback'),
            'portfolio-newsletter',
            'portfolio_newsletter_section'
        );
    }
    
    /**
     * Newsletter section description
     */
    public function newsletter_section_callback() {
        echo '<p>' . __('Configure your newsletter settings here.', 'portfolio') . '</p>';
    }
    
    /**
     * Welcome email subject field
     */
    public function welcome_email_subject_callback() {
        $options = get_option('portfolio_newsletter_settings');
        $value = isset($options['welcome_email_subject']) ? $options['welcome_email_subject'] : __('Welcome to our Newsletter!', 'portfolio');
        
        echo '<input type="text" id="welcome_email_subject" name="portfolio_newsletter_settings[welcome_email_subject]" value="' . esc_attr($value) . '" class="regular-text" />';
    }
    
    /**
     * Welcome email content field
     */
    public function welcome_email_content_callback() {
        $options = get_option('portfolio_newsletter_settings');
        $value = isset($options['welcome_email_content']) ? $options['welcome_email_content'] : __("Hello {name},\n\nThank you for subscribing to our newsletter! We're excited to have you join our community.\n\nWe'll keep you updated with our latest news, projects, and insights.\n\nBest regards,\n{site_name}", 'portfolio');
        
        echo '<textarea id="welcome_email_content" name="portfolio_newsletter_settings[welcome_email_content]" rows="10" class="large-text">' . esc_textarea($value) . '</textarea>';
        echo '<p class="description">' . __('Available placeholders: {name}, {email}, {site_name}, {site_url}', 'portfolio') . '</p>';
    }
    
    /**
     * Newsletter admin page
     */
    public function newsletter_admin_page() {
        // Check if form is submitted
        if (isset($_POST['send_newsletter']) && check_admin_referer('send_newsletter_nonce', 'newsletter_nonce')) {
            $this->process_newsletter_send();
        }
        
        ?>
        <div class="wrap">
            <h1><?php _e('Send Newsletter', 'portfolio'); ?></h1>
            
            <?php 
            // Display Gmail API status
            global $portfolio_gmail_api;
            if (isset($portfolio_gmail_api) && method_exists($portfolio_gmail_api, 'add_gmail_api_info')) {
                $portfolio_gmail_api->add_gmail_api_info();
            }
            ?>
            
            <form method="post" action="">
                <?php wp_nonce_field('send_newsletter_nonce', 'newsletter_nonce'); ?>
                
                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="newsletter_subject"><?php _e('Email Subject', 'portfolio'); ?></label></th>
                        <td>
                            <input type="text" id="newsletter_subject" name="newsletter_subject" class="regular-text" required>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="newsletter_content"><?php _e('Email Content', 'portfolio'); ?></label></th>
                        <td>
                            <?php 
                            wp_editor('', 'newsletter_content', array(
                                'media_buttons' => true,
                                'textarea_name' => 'newsletter_content',
                                'textarea_rows' => 15,
                            )); 
                            ?>
                            <p class="description"><?php _e('Available placeholders: {name}, {email}, {site_name}, {site_url}', 'portfolio'); ?></p>
                        </td>
                    </tr>
                </table>
                
                <p class="submit">
                    <input type="submit" name="send_newsletter" class="button button-primary" value="<?php _e('Send Newsletter', 'portfolio'); ?>">
                </p>
            </form>
            
            <hr>
            
            <h2><?php _e('Newsletter Settings', 'portfolio'); ?></h2>
            <form method="post" action="options.php">
                <?php 
                settings_fields('portfolio_newsletter_options');
                do_settings_sections('portfolio-newsletter');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }
    
    /**
     * Process newsletter sending
     */
    private function process_newsletter_send() {
        $subject = sanitize_text_field($_POST['newsletter_subject']);
        $content = wp_kses_post($_POST['newsletter_content']);
        
        if (empty($subject) || empty($content)) {
            add_settings_error('portfolio_newsletter', 'empty_fields', __('Subject and content are required.', 'portfolio'), 'error');
            return;
        }
        
        // Query subscribers
        $subscribers = new WP_Query(array(
            'post_type'      => 'portfolio_subscriber',
            'posts_per_page' => -1,
            'meta_query'     => array(
                array(
                    'key'     => '_subscriber_status',
                    'value'   => 'active',
                    'compare' => '=',
                ),
            ),
        ));
        
        $sent_count = 0;
        $headers = array('Content-Type: text/html; charset=UTF-8');
        
        // Use Simple Mailer for sending emails
        global $portfolio_simple_mailer;
        $use_simple_mailer = isset($portfolio_simple_mailer) && method_exists($portfolio_simple_mailer, 'send_bulk_emails');
        
        // Send to each subscriber
        if ($subscribers->have_posts()) {
            if ($use_simple_mailer) {
                // Prepare emails for bulk sending
                $emails = array();
                while ($subscribers->have_posts()) {
                    $subscribers->the_post();
                    $emails[] = array(
                        'name' => get_the_title(),
                        'email' => get_post_meta(get_the_ID(), '_subscriber_email', true)
                    );
                }
                wp_reset_postdata();
                
                // Send emails using Simple Mailer
                $sent_count = $portfolio_simple_mailer->send_bulk_emails($emails, $subject, $content);
            } else {
                // Standard WordPress mail sending
                $site_name = get_bloginfo('name');
                $site_url = get_site_url();
                
                while ($subscribers->have_posts()) {
                    $subscribers->the_post();
                    $subscriber_id = get_the_ID();
                    $name = get_the_title();
                    $email = get_post_meta($subscriber_id, '_subscriber_email', true);
                    
                    // Replace placeholders
                    $email_content = $content;
                    $email_content = str_replace('{name}', $name, $email_content);
                    $email_content = str_replace('{email}', $email, $email_content);
                    $email_content = str_replace('{site_name}', $site_name, $email_content);
                    $email_content = str_replace('{site_url}', $site_url, $email_content);
                    
                    // Convert line breaks to HTML
                    $email_content = wpautop($email_content);
                    
                    // Send email
                    $result = wp_mail($email, $subject, $email_content, $headers);
                    
                    if ($result) {
                        $sent_count++;
                    }
                }
                wp_reset_postdata();
            }
            
            add_settings_error('portfolio_newsletter', 'newsletter_sent', sprintf(__('Newsletter sent to %d subscribers.', 'portfolio'), $sent_count), 'success');
        } else {
            add_settings_error('portfolio_newsletter', 'no_subscribers', __('No active subscribers found.', 'portfolio'), 'warning');
        }
    }
    
    /**
     * Enqueue scripts for form handling
     */
    public function enqueue_form_scripts() {
        wp_enqueue_script(
            'portfolio-forms',
            get_template_directory_uri() . '/assets/js/forms.js',
            array('jquery'),
            filemtime(get_template_directory() . '/assets/js/forms.js'),
            true
        );
        
        wp_localize_script(
            'portfolio-forms',
            'portfolioForms',
            array(
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'nonce'   => wp_create_nonce('portfolio_form_nonce'),
                'contactSuccess' => __('Thank you! Your message has been sent successfully.', 'portfolio'),
                'newsletterSuccess' => __('Thank you for subscribing to our newsletter!', 'portfolio'),
                'error' => __('Something went wrong. Please try again.', 'portfolio')
            )
        );
    }

    /**
     * Handle contact form submission
     */
    public function handle_contact_form() {
        // Verify nonce
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'portfolio_form_nonce')) {
            wp_send_json_error(__('Security check failed', 'portfolio'));
        }
        
        // Get form data
        $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
        $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
        $subject = isset($_POST['subject']) ? sanitize_text_field($_POST['subject']) : '';
        $message = isset($_POST['message']) ? sanitize_textarea_field($_POST['message']) : '';
        
        // Validate required fields
        if (empty($name) || empty($email) || empty($message)) {
            wp_send_json_error(__('Please fill in all required fields', 'portfolio'));
        }
        
        // Validate email
        if (!is_email($email)) {
            wp_send_json_error(__('Please enter a valid email address', 'portfolio'));
        }
        
        // Create post for contact message
        $post_id = wp_insert_post(array(
            'post_title'   => $name,
            'post_status'  => 'publish',
            'post_type'    => 'portfolio_contact',
        ));
        
        if (!is_wp_error($post_id)) {
            // Save message data as post meta
            update_post_meta($post_id, '_contact_email', $email);
            update_post_meta($post_id, '_contact_subject', $subject);
            update_post_meta($post_id, '_contact_message', $message);
            
            // Send email notification to admin
            $admin_email = get_option('admin_email');
            $site_name = get_bloginfo('name');
            
            $email_subject = sprintf(__('New Contact Message from %s', 'portfolio'), $site_name);
            
            $email_message = sprintf(
                __("You have received a new contact message from your website.\n\nName: %s\nEmail: %s\nSubject: %s\n\nMessage:\n%s\n\nYou can view all messages in your WordPress dashboard.", 'portfolio'),
                $name,
                $email,
                $subject,
                $message
            );
            
            $headers = array('Reply-To: ' . $name . ' <' . $email . '>');
            
            // Try using Simple Mailer if available
            global $portfolio_simple_mailer;
            if (isset($portfolio_simple_mailer) && method_exists($portfolio_simple_mailer, 'send_email')) {
                $html_message = wpautop($email_message);
                $result = $portfolio_simple_mailer->send_email($admin_email, $email_subject, $html_message, $headers);
            } else {
                wp_mail($admin_email, $email_subject, $email_message, $headers);
            }
            
            wp_send_json_success(__('Thank you for your message! We will get back to you soon.', 'portfolio'));
        } else {
            wp_send_json_error(__('Failed to save your message. Please try again later.', 'portfolio'));
        }
        
        wp_die();
    }
    
    /**
     * Handle newsletter form submission
     */
    public function handle_newsletter_form() {
        // Verify nonce
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'portfolio_form_nonce')) {
            wp_send_json_error(__('Security check failed', 'portfolio'));
        }
        
        // Get form data
        $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
        $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
        
        // Validate required fields
        if (empty($name) || empty($email)) {
            wp_send_json_error(__('Please fill in all required fields', 'portfolio'));
        }
        
        // Validate email
        if (!is_email($email)) {
            wp_send_json_error(__('Please enter a valid email address', 'portfolio'));
        }
        
        // Check if email already exists
        $existing_subscriber = new WP_Query(array(
            'post_type' => 'portfolio_subscriber',
            'posts_per_page' => 1,
            'meta_query' => array(
                array(
                    'key' => '_subscriber_email',
                    'value' => $email,
                    'compare' => '=',
                ),
            ),
        ));
        
        if ($existing_subscriber->have_posts()) {
            wp_send_json_error(__('This email is already subscribed to our newsletter.', 'portfolio'));
        }
        
        // Create post for subscriber
        $post_id = wp_insert_post(array(
            'post_title'   => $name,
            'post_status'  => 'publish',
            'post_type'    => 'portfolio_subscriber',
        ));
        
        if (!is_wp_error($post_id)) {
            // Save subscriber data as post meta
            update_post_meta($post_id, '_subscriber_email', $email);
            update_post_meta($post_id, '_subscriber_status', 'active');
            
            // Send welcome email
            $this->send_welcome_email($name, $email);
            
            // Notify admin
            $admin_email = get_option('admin_email');
            $site_name = get_bloginfo('name');
            
            $admin_subject = sprintf(__('New Newsletter Subscriber on %s', 'portfolio'), $site_name);
            $admin_message = sprintf(
                __("You have a new newsletter subscriber!\n\nName: %s\nEmail: %s\n\nYou can view all subscribers in your WordPress dashboard.", 'portfolio'),
                $name,
                $email
            );
            
            // Try using Simple Mailer if available
            global $portfolio_simple_mailer;
            if (isset($portfolio_simple_mailer) && method_exists($portfolio_simple_mailer, 'send_email')) {
                $html_message = wpautop($admin_message);
                $result = $portfolio_simple_mailer->send_email($admin_email, $admin_subject, $html_message);
            } else {
                wp_mail($admin_email, $admin_subject, $admin_message);
            }
            
            wp_send_json_success(__('Thank you for subscribing to our newsletter!', 'portfolio'));
        } else {
            wp_send_json_error(__('Failed to subscribe. Please try again later.', 'portfolio'));
        }
        
        wp_die();
    }
    
    /**
     * Send welcome email to new subscribers
     */
    private function send_welcome_email($name, $email) {
        $options = get_option('portfolio_newsletter_settings');
        
        $subject = isset($options['welcome_email_subject']) ? $options['welcome_email_subject'] : __('Welcome to our Newsletter!', 'portfolio');
        
        $content = isset($options['welcome_email_content']) 
            ? $options['welcome_email_content'] 
            : __("Hello {name},\n\nThank you for subscribing to our newsletter! We're excited to have you join our community.\n\nWe'll keep you updated with our latest news, projects, and insights.\n\nBest regards,\n{site_name}", 'portfolio');
        
        $site_name = get_bloginfo('name');
        $site_url = get_site_url();
        
        // Replace placeholders
        $content = str_replace('{name}', $name, $content);
        $content = str_replace('{email}', $email, $content);
        $content = str_replace('{site_name}', $site_name, $content);
        $content = str_replace('{site_url}', $site_url, $content);
        
        // Convert line breaks to HTML
        $content = wpautop($content);
        
        // Try using Simple Mailer if available
        global $portfolio_simple_mailer;
        $headers = array('Content-Type: text/html; charset=UTF-8');
        
        if (isset($portfolio_simple_mailer) && method_exists($portfolio_simple_mailer, 'send_email')) {
            $result = $portfolio_simple_mailer->send_email($email, $subject, $content, $headers);
        } else {
            wp_mail($email, $subject, $content, $headers);
        }
    }
}

// Initialize the form handler
new Portfolio_Form_Handler();
