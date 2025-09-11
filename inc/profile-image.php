<?php
/**
 * Profile Image Customizer Settings
 *
 * Adds options to the WordPress Customizer for uploading a profile image
 *
 * @package WordPress
 * @subpackage Portfolio
 * @since Portfolio 1.0
 */

/**
 * Add profile image option to the Theme Customizer
 */
function portfolio_customizer_profile_image($wp_customize) {
    // Add a section for Profile Image settings
    $wp_customize->add_section('portfolio_profile_image', array(
        'title'    => __('Profile Image', 'portfolio'),
        'priority' => 30,
    ));

    // Add setting for profile image
    $wp_customize->add_setting('portfolio_profile_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    // Add control for uploading profile image
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'portfolio_profile_image', array(
        'label'       => __('Upload Profile Image', 'portfolio'),
        'description' => __('Upload an image to be displayed in the Maasai-styled profile frame on the homepage.', 'portfolio'),
        'section'     => 'portfolio_profile_image',
        'settings'    => 'portfolio_profile_image',
    )));
}
add_action('customize_register', 'portfolio_customizer_profile_image');

/**
 * Check if a profile image has been set
 */
function portfolio_has_profile_image() {
    $profile_image = get_theme_mod('portfolio_profile_image');
    return !empty($profile_image);
}

/**
 * Get the profile image URL
 */
function portfolio_get_profile_image() {
    $profile_image = get_theme_mod('portfolio_profile_image');
    
    if (!empty($profile_image)) {
        return $profile_image;
    }
    
    // Try to use the about image as fallback
    $about_image = portfolio_get_about_image();
    if (!empty($about_image)) {
        return $about_image;
    }
    
    // Final fallback to logo or avatar
    if (has_custom_logo()) {
        $custom_logo_id = get_theme_mod('custom_logo');
        $logo_image = wp_get_attachment_image_src($custom_logo_id, 'full');
        if ($logo_image) {
            return $logo_image[0];
        }
    }
    
    // Default image if nothing else is available
    return 'https://secure.gravatar.com/avatar/' . md5(get_bloginfo('admin_email')) . '?s=500&d=mm';
}
