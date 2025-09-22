<?php
/**
 * Modern Header file with Maasai Color Theme
 *
 * @package WordPress
 * @subpackage Portfolio
 * @since Portfolio 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class('has-modern-header'); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'portfolio' ); ?></a>

    <header id="masthead" class="site-header">
        <div class="header-inner">
            <!-- Site Branding -->
            <div class="site-branding">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo-link" rel="home">
                    <?php if ( function_exists('portfolio_has_profile_image') && portfolio_has_profile_image() ) : ?>
                        <div class="header-profile-container">
                            <img src="<?php echo esc_url( portfolio_get_profile_image() ); ?>" alt="<?php echo esc_attr( function_exists('portfolio_get_owner_name') ? portfolio_get_owner_name() : get_bloginfo('name') ); ?>" class="header-profile-image">
                        </div>
                    <?php elseif ( has_custom_logo() ) : ?>
                        <div class="custom-logo-container">
                            <?php 
                            $custom_logo_id = get_theme_mod('custom_logo');
                            $logo = wp_get_attachment_image($custom_logo_id, 'full', false, array('class' => 'custom-logo')); 
                            echo $logo;
                            ?>
                        </div>
                    <?php else : ?>
                        <h1 class="site-title">
                            <?php bloginfo( 'name' ); ?>
                        </h1>
                    <?php endif; ?>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <nav class="main-navigation desktop-nav" aria-label="<?php esc_attr_e( 'Main Navigation', 'portfolio' ); ?>">
                <ul class="nav-list">
                    <?php 
                    // Check if we're on the front page
                    $is_front_page = is_front_page();
                    $home_url = esc_url(home_url('/'));
                    
                    // Define sections and their labels
                    $sections = array(
                        'about' => __('About', 'portfolio'),
                        'skills' => __('Skills', 'portfolio'),
                        'portfolio' => __('Portfolio', 'portfolio'),
                        'testimonials' => __('Testimonials', 'portfolio'),
                        'blog' => __('Blog', 'portfolio'),
                    );
                    
                    // Output nav items
                    foreach ($sections as $section => $label) {
                        $section_url = $is_front_page ? "#$section" : "$home_url#$section";
                        echo '<li class="nav-item">';
                        echo '<a href="' . esc_url($section_url) . '" class="nav-link">' . esc_html($label) . '</a>';
                        echo '</li>';
                    }
                    ?>
                    <li class="nav-item">
                        <a href="<?php echo $is_front_page ? "#contact" : "$home_url#contact"; ?>" class="contact-button"><?php esc_html_e('Contact', 'portfolio'); ?></a>
                    </li>
                </ul>
            </nav>

            <!-- Mobile Menu Button -->
            <button id="mobile-menu-toggle" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle menu', 'portfolio'); ?>">
                <div class="hamburger-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>
        </div>

        <!-- Mobile Menu Drawer -->
        <div id="mobile-drawer" class="mobile-drawer">
            <div class="mobile-drawer-header">
                <h2><?php echo function_exists('portfolio_get_owner_name') ? portfolio_get_owner_name() : get_bloginfo('name'); ?></h2>
            </div>
            
            <nav class="mobile-navigation" aria-label="<?php esc_attr_e( 'Mobile Navigation', 'portfolio' ); ?>">
                <ul class="mobile-nav-list">
                    <?php
                    // Define the mobile navigation items with icons
                    $mobile_nav_items = array(
                        'about' => array(
                            'label' => __('About', 'portfolio'),
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>'
                        ),
                        'skills' => array(
                            'label' => __('Skills', 'portfolio'),
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg>'
                        ),
                        'portfolio' => array(
                            'label' => __('Portfolio', 'portfolio'),
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><rect x="7" y="7" width="3" height="9"></rect><rect x="14" y="7" width="3" height="5"></rect></svg>'
                        ),
                        'testimonials' => array(
                            'label' => __('Testimonials', 'portfolio'),
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>'
                        ),
                        'blog' => array(
                            'label' => __('Blog', 'portfolio'),
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>'
                        ),
                        'contact' => array(
                            'label' => __('Contact', 'portfolio'),
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>'
                        )
                    );
                    
                    // Output each navigation item
                    foreach ($mobile_nav_items as $section => $item) {
                        $section_url = $is_front_page ? "#$section" : "$home_url#$section";
                        ?>
                        <li class="mobile-nav-item">
                            <a href="<?php echo esc_url($section_url); ?>" class="mobile-nav-link">
                                <span class="mobile-nav-icon <?php echo esc_attr($section); ?>"><?php echo $item['icon']; ?></span>
                                <span class="mobile-nav-label"><?php echo esc_html($item['label']); ?></span>
                            </a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </nav>

            <!-- Social Media Links -->
            <div class="mobile-drawer-footer">
                <h3><?php esc_html_e('Connect With Me', 'portfolio'); ?></h3>
                <div class="social-links">
                    <a href="https://github.com/mid4s" target="_blank" rel="noopener noreferrer" class="social-link github-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path></svg>
                        <span>GitHub</span>
                    </a>
                    <a href="https://linkedin.com/in/joshua-lugaya-mid4s-dev" target="_blank" rel="noopener noreferrer" class="social-link linkedin-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle></svg>
                        <span>LinkedIn</span>
                    </a>
                    <a href="https://twitter.com/mid4s_dev" target="_blank" rel="noopener noreferrer" class="social-link twitter-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>
                        <span>Twitter</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Overlay for mobile menu -->
    <div id="mobile-overlay" class="overlay"></div>

    <div id="content" class="site-content">
