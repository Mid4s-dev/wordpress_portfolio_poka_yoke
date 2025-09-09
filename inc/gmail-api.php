<?php
/**
 * Gmail API Integration for Portfolio Theme
 *
 * @package Portfolio
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Gmail API Handler for sending newsletter emails
 */
class Portfolio_Gmail_API {

    /**
     * Google API client ID
     */
    private $client_id = '';
    
    /**
     * Google API client secret
     */
    private $client_secret = '';
    
    /**
     * Google API refresh token
     */
    private $refresh_token = '';
    
    /**
     * Google API access token
     */
    private $access_token = '';
    
    /**
     * Google API access token expiry
     */
    private $token_expiry = 0;
    
    /**
     * Sender email address
     */
    private $sender_email = '';
    
    /**
     * Sender name
     */
    private $sender_name = '';

    /**
     * Constructor
     */
    public function __construct() {
        // Load settings
        $options = get_option('portfolio_gmail_api_settings', array());
        
        $this->client_id = isset($options['client_id']) ? $options['client_id'] : '';
        $this->client_secret = isset($options['client_secret']) ? $options['client_secret'] : '';
        $this->refresh_token = isset($options['refresh_token']) ? $options['refresh_token'] : '';
        $this->sender_email = isset($options['sender_email']) ? $options['sender_email'] : get_option('admin_email');
        $this->sender_name = isset($options['sender_name']) ? $options['sender_name'] : get_bloginfo('name');
        
        // Register settings page
        add_action('admin_menu', array($this, 'add_settings_page'));
        add_action('admin_init', array($this, 'register_settings'));
        
        // Enqueue admin styles
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_styles'));
        
        // Add help text to send newsletter page
        add_action('portfolio_before_newsletter_form', array($this, 'add_gmail_api_info'));
    }
    
    /**
     * Enqueue admin styles
     */
    public function enqueue_admin_styles($hook) {
        $gmail_api_pages = array(
            'portfolio_subscriber_page_portfolio-gmail-api',
            'portfolio_subscriber_page_portfolio-send-newsletter'
        );
        
        if (in_array($hook, $gmail_api_pages)) {
            wp_enqueue_style(
                'portfolio-gmail-api-admin',
                get_template_directory_uri() . '/assets/css/gmail-api-admin.css',
                array(),
                filemtime(get_template_directory() . '/assets/css/gmail-api-admin.css')
            );
        }
    }
    
    /**
     * Add settings page
     */
    public function add_settings_page() {
        add_submenu_page(
            'edit.php?post_type=portfolio_subscriber',
            __('Gmail API Settings', 'portfolio'),
            __('Gmail API Settings', 'portfolio'),
            'manage_options',
            'portfolio-gmail-api',
            array($this, 'settings_page')
        );
    }
    
    /**
     * Register settings
     */
    public function register_settings() {
        register_setting('portfolio_gmail_api_group', 'portfolio_gmail_api_settings');
        
        add_settings_section(
            'portfolio_gmail_api_section',
            __('Gmail API Configuration', 'portfolio'),
            array($this, 'settings_section_callback'),
            'portfolio-gmail-api'
        );
        
        add_settings_field(
            'client_id',
            __('Client ID', 'portfolio'),
            array($this, 'client_id_callback'),
            'portfolio-gmail-api',
            'portfolio_gmail_api_section'
        );
        
        add_settings_field(
            'client_secret',
            __('Client Secret', 'portfolio'),
            array($this, 'client_secret_callback'),
            'portfolio-gmail-api',
            'portfolio_gmail_api_section'
        );
        
        add_settings_field(
            'refresh_token',
            __('Refresh Token', 'portfolio'),
            array($this, 'refresh_token_callback'),
            'portfolio-gmail-api',
            'portfolio_gmail_api_section'
        );
        
        add_settings_field(
            'sender_email',
            __('Sender Email', 'portfolio'),
            array($this, 'sender_email_callback'),
            'portfolio-gmail-api',
            'portfolio_gmail_api_section'
        );
        
        add_settings_field(
            'sender_name',
            __('Sender Name', 'portfolio'),
            array($this, 'sender_name_callback'),
            'portfolio-gmail-api',
            'portfolio_gmail_api_section'
        );
    }
    
    /**
     * Settings section callback
     */
    public function settings_section_callback() {
        echo '<p>' . __('Configure your Gmail API settings to send emails using your Gmail account. You need to create a project in Google Cloud Console and get API credentials.', 'portfolio') . '</p>';
        echo '<p><strong>' . __('Required Gmail API Scopes:', 'portfolio') . '</strong> https://mail.google.com/</p>';
        echo '<p><a href="https://developers.google.com/gmail/api/quickstart/php" target="_blank" class="button">' . __('Google Gmail API Documentation', 'portfolio') . '</a></p>';
    }
    
    /**
     * Client ID field callback
     */
    public function client_id_callback() {
        $options = get_option('portfolio_gmail_api_settings');
        $value = isset($options['client_id']) ? $options['client_id'] : '';
        echo '<input type="text" id="client_id" name="portfolio_gmail_api_settings[client_id]" value="' . esc_attr($value) . '" class="regular-text">';
    }
    
    /**
     * Client Secret field callback
     */
    public function client_secret_callback() {
        $options = get_option('portfolio_gmail_api_settings');
        $value = isset($options['client_secret']) ? $options['client_secret'] : '';
        echo '<input type="password" id="client_secret" name="portfolio_gmail_api_settings[client_secret]" value="' . esc_attr($value) . '" class="regular-text">';
    }
    
    /**
     * Refresh Token field callback
     */
    public function refresh_token_callback() {
        $options = get_option('portfolio_gmail_api_settings');
        $value = isset($options['refresh_token']) ? $options['refresh_token'] : '';
        echo '<input type="password" id="refresh_token" name="portfolio_gmail_api_settings[refresh_token]" value="' . esc_attr($value) . '" class="regular-text">';
        echo '<p class="description">' . __('You\'ll need to generate a refresh token using Google OAuth 2.0 Playground or a similar tool.', 'portfolio') . '</p>';
        echo '<p><a href="https://developers.google.com/oauthplayground/" target="_blank" class="button">' . __('Google OAuth Playground', 'portfolio') . '</a></p>';
    }
    
    /**
     * Sender Email field callback
     */
    public function sender_email_callback() {
        $options = get_option('portfolio_gmail_api_settings');
        $value = isset($options['sender_email']) ? $options['sender_email'] : get_option('admin_email');
        echo '<input type="email" id="sender_email" name="portfolio_gmail_api_settings[sender_email]" value="' . esc_attr($value) . '" class="regular-text">';
        echo '<p class="description">' . __('This must be the same email address you used to set up your Google API project.', 'portfolio') . '</p>';
    }
    
    /**
     * Sender Name field callback
     */
    public function sender_name_callback() {
        $options = get_option('portfolio_gmail_api_settings');
        $value = isset($options['sender_name']) ? $options['sender_name'] : get_bloginfo('name');
        echo '<input type="text" id="sender_name" name="portfolio_gmail_api_settings[sender_name]" value="' . esc_attr($value) . '" class="regular-text">';
    }
    
    /**
     * Settings page
     */
    public function settings_page() {
        ?>
        <div class="wrap">
            <h1><?php _e('Gmail API Settings', 'portfolio'); ?></h1>
            
            <form method="post" action="options.php">
                <?php
                settings_fields('portfolio_gmail_api_group');
                do_settings_sections('portfolio-gmail-api');
                submit_button();
                ?>
            </form>
            
            <div class="gmail-api-card">
                <h2><?php _e('How to set up Gmail API', 'portfolio'); ?></h2>
                
                <ol class="gmail-api-steps">
                    <li><?php _e('Go to <a href="https://console.cloud.google.com/" target="_blank">Google Cloud Console</a> and create a new project.', 'portfolio'); ?></li>
                    <li><?php _e('Enable the Gmail API for your project.', 'portfolio'); ?></li>
                    <li><?php _e('Create OAuth 2.0 credentials (OAuth client ID).', 'portfolio'); ?>
                        <ul>
                            <li><?php _e('Application type: Web application', 'portfolio'); ?></li>
                            <li><?php _e('Add an authorized redirect URI: https://developers.google.com/oauthplayground', 'portfolio'); ?></li>
                        </ul>
                    </li>
                    <li><?php _e('Copy your Client ID and Client Secret.', 'portfolio'); ?></li>
                    <li><?php _e('Go to <a href="https://developers.google.com/oauthplayground/" target="_blank">Google OAuth Playground</a>.', 'portfolio'); ?></li>
                    <li><?php _e('Click the gear icon in the upper right and check "Use your own OAuth credentials".', 'portfolio'); ?></li>
                    <li><?php _e('Enter your Client ID and Client Secret.', 'portfolio'); ?></li>
                    <li><?php _e('In the list of APIs, find "Gmail API v1" and select "https://mail.google.com/".', 'portfolio'); ?></li>
                    <li><?php _e('Click "Authorize APIs" and follow the authorization flow.', 'portfolio'); ?></li>
                    <li><?php _e('After authorization, click "Exchange authorization code for tokens".', 'portfolio'); ?></li>
                    <li><?php _e('Copy the Refresh Token and paste it here.', 'portfolio'); ?></li>
                </ol>
            </div>
            
            <div class="gmail-api-card">
                <h2><?php _e('Test Email', 'portfolio'); ?></h2>
                <p><?php _e('Send a test email to verify your Gmail API configuration.', 'portfolio'); ?></p>
                
                <div class="test-email-form">
                    <div class="form-field">
                        <label for="test-email"><?php _e('Email Address:', 'portfolio'); ?></label>
                        <input type="email" id="test-email" class="regular-text" placeholder="<?php esc_attr_e('your@email.com', 'portfolio'); ?>">
                    </div>
                    
                    <button type="button" id="send-test-email" class="button button-primary"><?php _e('Send Test Email', 'portfolio'); ?></button>
                    
                    <div id="test-email-result" class="test-email-result"></div>
                </div>
                
                <script>
                jQuery(document).ready(function($) {
                    $('#send-test-email').on('click', function() {
                        const email = $('#test-email').val();
                        if (!email) {
                            $('#test-email-result').html('<div class="notice notice-error"><p><?php _e('Please enter an email address.', 'portfolio'); ?></p></div>');
                            return;
                        }
                        
                        $(this).prop('disabled', true).text('<?php _e('Sending...', 'portfolio'); ?>');
                        
                        $.ajax({
                            url: ajaxurl,
                            type: 'POST',
                            data: {
                                action: 'portfolio_test_gmail_api',
                                email: email,
                                nonce: '<?php echo wp_create_nonce('test_gmail_api_nonce'); ?>'
                            },
                            success: function(response) {
                                if (response.success) {
                                    $('#test-email-result').html('<div class="notice notice-success"><p>' + response.data + '</p></div>');
                                } else {
                                    $('#test-email-result').html('<div class="notice notice-error"><p>' + response.data + '</p></div>');
                                }
                            },
                            error: function() {
                                $('#test-email-result').html('<div class="notice notice-error"><p><?php _e('An error occurred while sending the test email.', 'portfolio'); ?></p></div>');
                            },
                            complete: function() {
                                $('#send-test-email').prop('disabled', false).text('<?php _e('Send Test Email', 'portfolio'); ?>');
                            }
                        });
                    });
                });
                </script>
            </div>
        </div>
        <?php
    }
    
    /**
     * Add Gmail API info to newsletter form
     */
    public function add_gmail_api_info() {
        // Check if Gmail API is configured
        $options = get_option('portfolio_gmail_api_settings', array());
        $is_configured = !empty($options['client_id']) && !empty($options['client_secret']) && !empty($options['refresh_token']);
        
        if (!$is_configured) {
            echo '<div class="gmail-api-status warning">';
            echo '<p><strong>' . __('Gmail API Status:', 'portfolio') . '</strong> ' . __('Not configured', 'portfolio') . '</p>';
            echo '<p>' . __('Emails will be sent using WordPress mail function.', 'portfolio') . ' ';
            echo '<a href="' . admin_url('edit.php?post_type=portfolio_subscriber&page=portfolio-gmail-api') . '" class="button button-small">' . __('Configure Gmail API', 'portfolio') . '</a></p>';
            echo '</div>';
        } else {
            echo '<div class="gmail-api-status success">';
            echo '<p><strong>' . __('Gmail API Status:', 'portfolio') . '</strong> ' . __('Configured and ready to use', 'portfolio') . '</p>';
            echo '<p>' . __('Emails will be sent using Gmail API.', 'portfolio') . ' ';
            echo '<a href="' . admin_url('edit.php?post_type=portfolio_subscriber&page=portfolio-gmail-api') . '" class="button button-small">' . __('Gmail API Settings', 'portfolio') . '</a></p>';
            echo '</div>';
        }
    }

    /**
     * Get access token using refresh token
     */
    private function get_access_token() {
        // Check if we have a valid access token
        $now = time();
        if (!empty($this->access_token) && $this->token_expiry > $now) {
            return $this->access_token;
        }
        
        // Get new access token using refresh token
        $url = 'https://oauth2.googleapis.com/token';
        
        $response = wp_remote_post($url, array(
            'headers' => array(
                'Content-Type' => 'application/x-www-form-urlencoded',
            ),
            'body' => array(
                'client_id' => $this->client_id,
                'client_secret' => $this->client_secret,
                'refresh_token' => $this->refresh_token,
                'grant_type' => 'refresh_token',
            ),
        ));
        
        if (is_wp_error($response)) {
            error_log('Gmail API Error: ' . $response->get_error_message());
            return false;
        }
        
        $body = json_decode(wp_remote_retrieve_body($response), true);
        
        if (isset($body['access_token'])) {
            $this->access_token = $body['access_token'];
            $this->token_expiry = $now + $body['expires_in'];
            return $this->access_token;
        }
        
        return false;
    }
    
    /**
     * Send email using Gmail API
     */
    public function send_email($to, $subject, $message, $headers = array()) {
        // Get access token
        $access_token = $this->get_access_token();
        if (!$access_token) {
            // Fallback to wp_mail if no access token
            return wp_mail($to, $subject, $message, $headers);
        }
        
        // Build email
        $email = $this->build_email($to, $subject, $message, $headers);
        
        // Send email
        $url = 'https://www.googleapis.com/gmail/v1/users/me/messages/send';
        
        $response = wp_remote_post($url, array(
            'headers' => array(
                'Authorization' => 'Bearer ' . $access_token,
                'Content-Type' => 'application/json',
            ),
            'body' => json_encode(array(
                'raw' => $email,
            )),
        ));
        
        if (is_wp_error($response)) {
            error_log('Gmail API Error: ' . $response->get_error_message());
            // Fallback to wp_mail
            return wp_mail($to, $subject, $message, $headers);
        }
        
        $body = json_decode(wp_remote_retrieve_body($response), true);
        
        return isset($body['id']);
    }
    
    /**
     * Send bulk emails using Gmail API
     */
    public function send_bulk_emails($emails, $subject, $message_template) {
        $success_count = 0;
        
        foreach ($emails as $email) {
            $to = $email['email'];
            $name = $email['name'];
            
            // Replace personalization variables
            $message = str_replace('{name}', $name, $message_template);
            $message = str_replace('{email}', $to, $message);
            $message = str_replace('{site_name}', get_bloginfo('name'), $message);
            $message = str_replace('{site_url}', get_site_url(), $message);
            
            // Convert line breaks to HTML
            $message = wpautop($message);
            
            $headers = array('Content-Type: text/html; charset=UTF-8');
            
            // Send email
            $result = $this->send_email($to, $subject, $message, $headers);
            
            if ($result) {
                $success_count++;
                
                // Sleep briefly to avoid rate limits
                usleep(100000); // 100ms
            }
        }
        
        return $success_count;
    }
    
    /**
     * Build email in base64 format for Gmail API
     */
    private function build_email($to, $subject, $message, $headers = array()) {
        // Parse headers
        $cc = '';
        $bcc = '';
        $content_type = 'text/html; charset=UTF-8';
        
        foreach ($headers as $header) {
            if (strpos($header, 'Cc:') === 0) {
                $cc = trim(substr($header, 3));
            } elseif (strpos($header, 'Bcc:') === 0) {
                $bcc = trim(substr($header, 4));
            } elseif (strpos($header, 'Content-Type:') === 0) {
                $content_type = trim(substr($header, 13));
            }
        }
        
        // Build email headers
        $email_headers = array();
        $email_headers[] = 'From: ' . $this->sender_name . ' <' . $this->sender_email . '>';
        $email_headers[] = 'To: ' . $to;
        $email_headers[] = 'Subject: ' . $subject;
        
        if (!empty($cc)) {
            $email_headers[] = 'Cc: ' . $cc;
        }
        
        if (!empty($bcc)) {
            $email_headers[] = 'Bcc: ' . $bcc;
        }
        
        $email_headers[] = 'MIME-Version: 1.0';
        $email_headers[] = 'Content-Type: ' . $content_type;
        $email_headers[] = '';
        
        // Combine headers and message
        $email_content = implode("\r\n", $email_headers) . "\r\n" . $message;
        
        // Base64 encode
        return base64_encode($email_content);
    }
    
    /**
     * Test Gmail API connection
     */
    public function test_connection($test_email) {
        $subject = __('Gmail API Test Email', 'portfolio');
        $message = __('This is a test email to verify your Gmail API configuration.', 'portfolio');
        $message .= "\n\n";
        $message .= __('If you received this email, your Gmail API setup is working correctly!', 'portfolio');
        
        $headers = array('Content-Type: text/html; charset=UTF-8');
        
        // Convert line breaks to HTML
        $message = wpautop($message);
        
        return $this->send_email($test_email, $subject, $message, $headers);
    }
}

// Initialize Gmail API Handler
$portfolio_gmail_api = new Portfolio_Gmail_API();

// Test Gmail API connection
function portfolio_test_gmail_api_callback() {
    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'test_gmail_api_nonce')) {
        wp_send_json_error(__('Security check failed.', 'portfolio'));
    }
    
    // Check if email is provided
    if (!isset($_POST['email']) || empty($_POST['email'])) {
        wp_send_json_error(__('Please provide an email address.', 'portfolio'));
    }
    
    $email = sanitize_email($_POST['email']);
    
    // Test connection
    global $portfolio_gmail_api;
    $result = $portfolio_gmail_api->test_connection($email);
    
    if ($result) {
        wp_send_json_success(__('Test email sent successfully. Please check your inbox.', 'portfolio'));
    } else {
        wp_send_json_error(__('Failed to send test email. Please check your Gmail API settings.', 'portfolio'));
    }
}
add_action('wp_ajax_portfolio_test_gmail_api', 'portfolio_test_gmail_api_callback');
