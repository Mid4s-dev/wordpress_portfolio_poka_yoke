<?php
/**
 * Simple Mailer - A more reliable email solution for the Portfolio theme
 * 
 * @package Portfolio
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Simple Mailer Class
 */
class Portfolio_Simple_Mailer {
    
    /**
     * Constructor
     */
    public function __construct() {
        // Register settings
        add_action('admin_init', array($this, 'register_settings'));
        
        // Add settings page
        add_action('admin_menu', array($this, 'add_settings_page'));
        
        // Filter the wp_mail() function to use custom SMTP if configured
        add_action('phpmailer_init', array($this, 'configure_smtp'));
    }
    
    /**
     * Register settings
     */
    public function register_settings() {
        register_setting('portfolio_mailer_settings', 'portfolio_mailer_options');
        
        add_settings_section(
            'mail_settings_section',
            __('Email Settings', 'portfolio'),
            array($this, 'mail_settings_section_callback'),
            'portfolio-mailer'
        );
        
        add_settings_field(
            'mail_method',
            __('Email Method', 'portfolio'),
            array($this, 'mail_method_callback'),
            'portfolio-mailer',
            'mail_settings_section'
        );
        
        // SMTP Settings Fields
        add_settings_field(
            'smtp_host',
            __('SMTP Host', 'portfolio'),
            array($this, 'smtp_host_callback'),
            'portfolio-mailer',
            'mail_settings_section'
        );
        
        add_settings_field(
            'smtp_port',
            __('SMTP Port', 'portfolio'),
            array($this, 'smtp_port_callback'),
            'portfolio-mailer',
            'mail_settings_section'
        );
        
        add_settings_field(
            'smtp_encryption',
            __('Encryption', 'portfolio'),
            array($this, 'smtp_encryption_callback'),
            'portfolio-mailer',
            'mail_settings_section'
        );
        
        add_settings_field(
            'smtp_auth',
            __('Authentication', 'portfolio'),
            array($this, 'smtp_auth_callback'),
            'portfolio-mailer',
            'mail_settings_section'
        );
        
        add_settings_field(
            'smtp_username',
            __('Username', 'portfolio'),
            array($this, 'smtp_username_callback'),
            'portfolio-mailer',
            'mail_settings_section'
        );
        
        add_settings_field(
            'smtp_password',
            __('Password', 'portfolio'),
            array($this, 'smtp_password_callback'),
            'portfolio-mailer',
            'mail_settings_section'
        );
        
        add_settings_field(
            'from_email',
            __('From Email', 'portfolio'),
            array($this, 'from_email_callback'),
            'portfolio-mailer',
            'mail_settings_section'
        );
        
        add_settings_field(
            'from_name',
            __('From Name', 'portfolio'),
            array($this, 'from_name_callback'),
            'portfolio-mailer',
            'mail_settings_section'
        );
    }
    
    /**
     * Settings section callback
     */
    public function mail_settings_section_callback() {
        echo '<p>' . __('Configure email settings for your website. Choose between default WordPress mail or SMTP.', 'portfolio') . '</p>';
    }
    
    /**
     * Email method field callback
     */
    public function mail_method_callback() {
        $options = get_option('portfolio_mailer_options', array());
        $mail_method = isset($options['mail_method']) ? $options['mail_method'] : 'wp_mail';
        
        ?>
        <select name="portfolio_mailer_options[mail_method]" id="mail_method">
            <option value="wp_mail" <?php selected($mail_method, 'wp_mail'); ?>><?php _e('WordPress Default', 'portfolio'); ?></option>
            <option value="smtp" <?php selected($mail_method, 'smtp'); ?>><?php _e('SMTP', 'portfolio'); ?></option>
        </select>
        <p class="description"><?php _e('Select which method to use for sending emails.', 'portfolio'); ?></p>
        <script>
            jQuery(document).ready(function($) {
                function toggleSMTPFields() {
                    var method = $('#mail_method').val();
                    if (method === 'smtp') {
                        $('.smtp-field').closest('tr').show();
                    } else {
                        $('.smtp-field').closest('tr').hide();
                    }
                }
                
                $('#mail_method').on('change', toggleSMTPFields);
                toggleSMTPFields();
            });
        </script>
        <?php
    }
    
    /**
     * SMTP host field callback
     */
    public function smtp_host_callback() {
        $options = get_option('portfolio_mailer_options', array());
        $smtp_host = isset($options['smtp_host']) ? $options['smtp_host'] : '';
        
        echo '<input type="text" id="smtp_host" name="portfolio_mailer_options[smtp_host]" value="' . esc_attr($smtp_host) . '" class="regular-text smtp-field">';
        echo '<p class="description">' . __('The SMTP server hostname (e.g., smtp.gmail.com).', 'portfolio') . '</p>';
    }
    
    /**
     * SMTP port field callback
     */
    public function smtp_port_callback() {
        $options = get_option('portfolio_mailer_options', array());
        $smtp_port = isset($options['smtp_port']) ? $options['smtp_port'] : '587';
        
        echo '<input type="number" id="smtp_port" name="portfolio_mailer_options[smtp_port]" value="' . esc_attr($smtp_port) . '" class="small-text smtp-field">';
        echo '<p class="description">' . __('The SMTP server port (usually 587 for TLS or 465 for SSL).', 'portfolio') . '</p>';
    }
    
    /**
     * SMTP encryption field callback
     */
    public function smtp_encryption_callback() {
        $options = get_option('portfolio_mailer_options', array());
        $smtp_encryption = isset($options['smtp_encryption']) ? $options['smtp_encryption'] : 'tls';
        
        ?>
        <select name="portfolio_mailer_options[smtp_encryption]" id="smtp_encryption" class="smtp-field">
            <option value="none" <?php selected($smtp_encryption, 'none'); ?>><?php _e('None', 'portfolio'); ?></option>
            <option value="tls" <?php selected($smtp_encryption, 'tls'); ?>><?php _e('TLS', 'portfolio'); ?></option>
            <option value="ssl" <?php selected($smtp_encryption, 'ssl'); ?>><?php _e('SSL', 'portfolio'); ?></option>
        </select>
        <p class="description"><?php _e('The encryption method to use when connecting to your SMTP server.', 'portfolio'); ?></p>
        <?php
    }
    
    /**
     * SMTP authentication field callback
     */
    public function smtp_auth_callback() {
        $options = get_option('portfolio_mailer_options', array());
        $smtp_auth = isset($options['smtp_auth']) ? $options['smtp_auth'] : 'yes';
        
        ?>
        <select name="portfolio_mailer_options[smtp_auth]" id="smtp_auth" class="smtp-field">
            <option value="yes" <?php selected($smtp_auth, 'yes'); ?>><?php _e('Yes', 'portfolio'); ?></option>
            <option value="no" <?php selected($smtp_auth, 'no'); ?>><?php _e('No', 'portfolio'); ?></option>
        </select>
        <p class="description"><?php _e('Whether to use authentication when connecting to your SMTP server.', 'portfolio'); ?></p>
        <script>
            jQuery(document).ready(function($) {
                function toggleAuthFields() {
                    var auth = $('#smtp_auth').val();
                    if (auth === 'yes') {
                        $('#smtp_username, #smtp_password').closest('tr').show();
                    } else {
                        $('#smtp_username, #smtp_password').closest('tr').hide();
                    }
                }
                
                $('#smtp_auth').on('change', toggleAuthFields);
                toggleAuthFields();
            });
        </script>
        <?php
    }
    
    /**
     * SMTP username field callback
     */
    public function smtp_username_callback() {
        $options = get_option('portfolio_mailer_options', array());
        $smtp_username = isset($options['smtp_username']) ? $options['smtp_username'] : '';
        
        echo '<input type="text" id="smtp_username" name="portfolio_mailer_options[smtp_username]" value="' . esc_attr($smtp_username) . '" class="regular-text smtp-field">';
        echo '<p class="description">' . __('Your SMTP username (usually your email address).', 'portfolio') . '</p>';
    }
    
    /**
     * SMTP password field callback
     */
    public function smtp_password_callback() {
        $options = get_option('portfolio_mailer_options', array());
        $smtp_password = isset($options['smtp_password']) ? $options['smtp_password'] : '';
        
        echo '<input type="password" id="smtp_password" name="portfolio_mailer_options[smtp_password]" value="' . esc_attr($smtp_password) . '" class="regular-text smtp-field">';
        echo '<p class="description">' . __('Your SMTP password.', 'portfolio') . '</p>';
        echo '<p class="description">' . __('Note: For Gmail, you need to use an App Password, not your regular account password.', 'portfolio') . ' <a href="https://support.google.com/accounts/answer/185833" target="_blank">' . __('Learn more', 'portfolio') . '</a></p>';
    }
    
    /**
     * From email field callback
     */
    public function from_email_callback() {
        $options = get_option('portfolio_mailer_options', array());
        $from_email = isset($options['from_email']) ? $options['from_email'] : get_option('admin_email');
        
        echo '<input type="email" id="from_email" name="portfolio_mailer_options[from_email]" value="' . esc_attr($from_email) . '" class="regular-text">';
        echo '<p class="description">' . __('The email address that emails should be sent from.', 'portfolio') . '</p>';
    }
    
    /**
     * From name field callback
     */
    public function from_name_callback() {
        $options = get_option('portfolio_mailer_options', array());
        $from_name = isset($options['from_name']) ? $options['from_name'] : get_bloginfo('name');
        
        echo '<input type="text" id="from_name" name="portfolio_mailer_options[from_name]" value="' . esc_attr($from_name) . '" class="regular-text">';
        echo '<p class="description">' . __('The name that emails should be sent from.', 'portfolio') . '</p>';
    }
    
    /**
     * Add settings page
     */
    public function add_settings_page() {
        add_submenu_page(
            'edit.php?post_type=portfolio_subscriber',
            __('Email Settings', 'portfolio'),
            __('Email Settings', 'portfolio'),
            'manage_options',
            'portfolio-email-settings',
            array($this, 'render_settings_page')
        );
    }
    
    /**
     * Render settings page
     */
    public function render_settings_page() {
        // Handle test email
        if (isset($_POST['send_test_email']) && check_admin_referer('portfolio_test_email')) {
            $this->send_test_email();
        }
        
        ?>
        <div class="wrap">
            <h1><?php _e('Email Settings', 'portfolio'); ?></h1>
            
            <?php settings_errors(); ?>
            
            <form method="post" action="options.php">
                <?php
                settings_fields('portfolio_mailer_settings');
                do_settings_sections('portfolio-mailer');
                submit_button();
                ?>
            </form>
            
            <hr>
            
            <h2><?php _e('Test Email Configuration', 'portfolio'); ?></h2>
            <p><?php _e('Send a test email to verify your email configuration.', 'portfolio'); ?></p>
            
            <form method="post" action="">
                <?php wp_nonce_field('portfolio_test_email'); ?>
                
                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="test_email_to"><?php _e('Send test to:', 'portfolio'); ?></label></th>
                        <td>
                            <input type="email" id="test_email_to" name="test_email_to" class="regular-text" value="<?php echo esc_attr(get_option('admin_email')); ?>" required>
                            <p class="description"><?php _e('Email address to send the test to.', 'portfolio'); ?></p>
                        </td>
                    </tr>
                </table>
                
                <?php submit_button(__('Send Test Email', 'portfolio'), 'secondary', 'send_test_email'); ?>
            </form>
            
            <hr>
            
            <h2><?php _e('Troubleshooting Tips', 'portfolio'); ?></h2>
            <ul>
                <li><?php _e('If using Gmail SMTP, make sure to create an "App Password" in your Google account security settings.', 'portfolio'); ?></li>
                <li><?php _e('Common SMTP ports: 25, 465 (SSL), 587 (TLS), 2525 (alternate).', 'portfolio'); ?></li>
                <li><?php _e('Make sure your hosting provider allows outgoing SMTP connections.', 'portfolio'); ?></li>
                <li><?php _e('For Gmail, use smtp.gmail.com, port 587, and TLS encryption.', 'portfolio'); ?></li>
                <li><?php _e('For Outlook/Office 365, use smtp.office365.com, port 587, and TLS encryption.', 'portfolio'); ?></li>
                <li><?php _e('If emails still fail to send, consider using a dedicated email service provider plugin like WP Mail SMTP or Post SMTP.', 'portfolio'); ?></li>
            </ul>
        </div>
        <?php
    }
    
    /**
     * Configure PHPMailer to use SMTP
     */
    public function configure_smtp($phpmailer) {
        $options = get_option('portfolio_mailer_options', array());
        
        // If SMTP is not enabled, just set from name/email and return
        if (!isset($options['mail_method']) || $options['mail_method'] !== 'smtp') {
            $from_email = isset($options['from_email']) ? $options['from_email'] : get_option('admin_email');
            $from_name = isset($options['from_name']) ? $options['from_name'] : get_bloginfo('name');
            
            $phpmailer->setFrom($from_email, $from_name);
            return;
        }
        
        // Configure SMTP
        $phpmailer->isSMTP();
        $phpmailer->Host = isset($options['smtp_host']) ? $options['smtp_host'] : 'smtp.gmail.com';
        $phpmailer->Port = isset($options['smtp_port']) ? (int) $options['smtp_port'] : 587;
        
        // Set encryption
        $encryption = isset($options['smtp_encryption']) ? $options['smtp_encryption'] : 'tls';
        if ($encryption === 'tls') {
            $phpmailer->SMTPSecure = 'tls';
        } elseif ($encryption === 'ssl') {
            $phpmailer->SMTPSecure = 'ssl';
        } else {
            $phpmailer->SMTPSecure = '';
        }
        
        // Set authentication
        if (isset($options['smtp_auth']) && $options['smtp_auth'] === 'yes') {
            $phpmailer->SMTPAuth = true;
            $phpmailer->Username = isset($options['smtp_username']) ? $options['smtp_username'] : '';
            $phpmailer->Password = isset($options['smtp_password']) ? $options['smtp_password'] : '';
        } else {
            $phpmailer->SMTPAuth = false;
        }
        
        // Set from email and name
        $from_email = isset($options['from_email']) ? $options['from_email'] : get_option('admin_email');
        $from_name = isset($options['from_name']) ? $options['from_name'] : get_bloginfo('name');
        
        $phpmailer->setFrom($from_email, $from_name);
        
        // Debug mode (uncomment for troubleshooting)
        // $phpmailer->SMTPDebug = 2;
    }
    
    /**
     * Send a test email
     */
    private function send_test_email() {
        if (!isset($_POST['test_email_to'])) {
            return;
        }
        
        $to = sanitize_email($_POST['test_email_to']);
        
        if (!is_email($to)) {
            add_settings_error(
                'portfolio_mailer_test',
                'invalid_email',
                __('Please enter a valid email address.', 'portfolio'),
                'error'
            );
            return;
        }
        
        $subject = __('[Test] Portfolio Email Configuration Test', 'portfolio');
        
        $message = __('This is a test email from your Portfolio theme.', 'portfolio');
        $message .= "\n\n";
        $message .= __('If you received this email, your email configuration is working correctly!', 'portfolio');
        $message .= "\n\n";
        $message .= __('Date/time of test: ', 'portfolio') . current_time('mysql');
        
        $headers = array('Content-Type: text/html; charset=UTF-8');
        
        // Convert line breaks to HTML
        $message = wpautop($message);
        
        $result = wp_mail($to, $subject, $message, $headers);
        
        if ($result) {
            add_settings_error(
                'portfolio_mailer_test',
                'email_sent',
                __('Test email sent successfully! Please check your inbox (and spam folder).', 'portfolio'),
                'success'
            );
        } else {
            add_settings_error(
                'portfolio_mailer_test',
                'email_failed',
                __('Failed to send test email. Please check your email settings and try again.', 'portfolio'),
                'error'
            );
        }
    }
    
    /**
     * Send an email using the configured method
     */
    public function send_email($to, $subject, $message, $headers = array(), $attachments = array()) {
        // We don't need to do anything special here, as we've already filtered wp_mail()
        return wp_mail($to, $subject, $message, $headers, $attachments);
    }
    
    /**
     * Send bulk emails
     */
    public function send_bulk_emails($emails, $subject, $message_template) {
        $success_count = 0;
        $site_name = get_bloginfo('name');
        $site_url = get_site_url();
        
        foreach ($emails as $email) {
            $to = $email['email'];
            $name = $email['name'];
            
            // Replace personalization variables
            $message = str_replace('{name}', $name, $message_template);
            $message = str_replace('{email}', $to, $message);
            $message = str_replace('{site_name}', $site_name, $message);
            $message = str_replace('{site_url}', $site_url, $message);
            
            // Convert line breaks to HTML
            $message = wpautop($message);
            
            $headers = array('Content-Type: text/html; charset=UTF-8');
            
            // Send email
            $result = wp_mail($to, $subject, $message, $headers);
            
            if ($result) {
                $success_count++;
                
                // Sleep briefly to avoid rate limits
                usleep(100000); // 100ms
            }
        }
        
        return $success_count;
    }
}

// Initialize the simple mailer
global $portfolio_simple_mailer;
$portfolio_simple_mailer = new Portfolio_Simple_Mailer();
