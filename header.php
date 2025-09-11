<?php
/**
 * Header file
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

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'portfolio' ); ?></a>

    <header id="masthead" class="site-header bg-shuka-black text-white shadow-md z-50 fixed w-full top-0 left-0">
        <!-- Decorative top border -->
        <div class="h-1 bg-gradient-to-r from-maroon via-shuka-yellow to-maroon"></div>
        
        <!-- Header Container -->
        <div class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <!-- Site Branding -->
                <div class="site-branding flex items-center">
                    <?php if ( portfolio_has_profile_image() ) : ?>
                        <div class="header-profile-container">
                            <img src="<?php echo esc_url( portfolio_get_profile_image() ); ?>" alt="<?php echo esc_attr( portfolio_get_owner_name() ); ?>" class="header-profile-image w-10 h-10 rounded-full object-cover">
                        </div>
                    <?php elseif ( has_custom_logo() ) : ?>
                        <div class="custom-logo-container bg-white p-1 rounded-full border-2 border-maroon hover:border-shuka-yellow transition-all">
                            <?php the_custom_logo(); ?>
                        </div>
                    <?php else : ?>
                        <h1 class="site-title text-xl font-bold">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="text-shuka-yellow hover:text-white transition-colors">
                                <?php bloginfo( 'name' ); ?>
                            </a>
                        </h1>
                    <?php endif; ?>
                </div>

                <!-- Desktop Navigation -->
                <nav class="hidden md:block">
                    <ul class="flex items-center space-x-2">
                        <li><a href="#about" class="nav-link px-3 py-2 rounded-md text-white hover:text-shuka-yellow hover:bg-maroon/20 transition-all"><?php esc_html_e('About', 'portfolio'); ?></a></li>
                        <li><a href="#skills" class="nav-link px-3 py-2 rounded-md text-white hover:text-shuka-yellow hover:bg-maroon/20 transition-all"><?php esc_html_e('Skills', 'portfolio'); ?></a></li>
                        <li><a href="#portfolio" class="nav-link px-3 py-2 rounded-md text-white hover:text-shuka-yellow hover:bg-maroon/20 transition-all"><?php esc_html_e('Portfolio', 'portfolio'); ?></a></li>
                        <li><a href="#testimonials" class="nav-link px-3 py-2 rounded-md text-white hover:text-shuka-yellow hover:bg-maroon/20 transition-all"><?php esc_html_e('Testimonials', 'portfolio'); ?></a></li>
                        <li><a href="#blog" class="nav-link px-3 py-2 rounded-md text-white hover:text-shuka-yellow hover:bg-maroon/20 transition-all"><?php esc_html_e('Blog', 'portfolio'); ?></a></li>
                        <li><a href="#contact" class="px-4 py-2 bg-maroon text-white hover:bg-shuka-yellow hover:text-maroon rounded-md transition-all font-medium"><?php esc_html_e('Contact', 'portfolio'); ?></a></li>
                    </ul>
                </nav>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-button" class="flex items-center p-2 rounded-md text-white hover:bg-maroon/20 focus:outline-none md:hidden" aria-label="<?php esc_attr_e('Toggle menu', 'portfolio'); ?>" aria-expanded="false">
                    <svg class="w-6 h-6" fill="none" stroke="white" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="color: white; stroke: white;">
                        <path id="hamburger-icon" class="block" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16" style="stroke: white; stroke-width: 2.5;"></path>
                        <path id="close-icon" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" style="stroke: white; stroke-width: 2.5;"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu Drawer -->
        <div id="mobile-menu-drawer" class="fixed inset-0 bg-black/70 z-40 transform translate-x-full transition-transform duration-300 ease-in-out md:hidden" style="display: none; visibility: hidden;">
            <div class="bg-shuka-black h-screen w-4/5 ml-auto flex flex-col shadow-lg overflow-y-auto">
                <!-- Mobile Menu Header -->
                <div class="flex items-center justify-between px-6 py-4 border-b border-maroon/30 sticky top-0 bg-shuka-black z-10">
                    <h2 class="text-xl font-bold text-shuka-yellow"><?php echo portfolio_get_owner_name(); ?></h2>
                </div>
                
                <!-- Mobile Navigation Links -->
                <nav class="flex-1 overflow-y-auto p-4 space-y-1">
                    <a href="#about" class="mobile-nav-item">
                        <span class="icon-container bg-maroon"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" /></svg></span>
                        <span class="text"><?php esc_html_e('About', 'portfolio'); ?></span>
                    </a>
                    <a href="#skills" class="mobile-nav-item">
                        <span class="icon-container bg-shuka-blue"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" /></svg></span>
                        <span class="text"><?php esc_html_e('Skills', 'portfolio'); ?></span>
                    </a>
                    <a href="#portfolio" class="mobile-nav-item">
                        <span class="icon-container bg-shuka-yellow"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z" /></svg></span>
                        <span class="text"><?php esc_html_e('Portfolio', 'portfolio'); ?></span>
                    </a>
                    <a href="#testimonials" class="mobile-nav-item">
                        <span class="icon-container bg-shuka-earth"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 13V5a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2h3l3 3 3-3h3a2 2 0 002-2zM5 7a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1zm1 3a1 1 0 100 2h3a1 1 0 100-2H6z" clip-rule="evenodd" /></svg></span>
                        <span class="text"><?php esc_html_e('Testimonials', 'portfolio'); ?></span>
                    </a>
                    <a href="#blog" class="mobile-nav-item">
                        <span class="icon-container bg-shuka-blue"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M2 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 002 2H4a2 2 0 01-2-2V5zm3 1h6v4H5V6zm6 6H5v2h6v-2z" clip-rule="evenodd" /><path d="M15 7h1a2 2 0 012 2v5.5a1.5 1.5 0 01-3 0V7z" /></svg></span>
                        <span class="text"><?php esc_html_e('Blog', 'portfolio'); ?></span>
                    </a>
                    <a href="#contact" class="mobile-nav-item">
                        <span class="icon-container bg-maroon"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" /><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" /></svg></span>
                        <span class="text"><?php esc_html_e('Contact', 'portfolio'); ?></span>
                    </a>

                    <!-- Social Media Links -->
                    <div class="pt-8 mt-6 border-t border-shuka-yellow/30">
                        <h3 class="font-bold text-shuka-yellow mb-4 px-1"><?php esc_html_e('Connect With Me', 'portfolio'); ?></h3>
                        <div class="flex flex-wrap gap-3">
                            <a href="https://github.com/Mid4s-dev" target="_blank" rel="noopener noreferrer" class="social-link bg-maroon/20">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path></svg>
                                <span>GitHub</span>
                            </a>
                            <a href="https://linkedin.com/in/joshua-lugaya-mid4s-dev" target="_blank" rel="noopener noreferrer" class="social-link bg-shuka-blue/20">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle></svg>
                                <span>LinkedIn</span>
                            </a>
                            <a href="https://twitter.com/mid4s_dev" target="_blank" rel="noopener noreferrer" class="social-link bg-shuka-yellow/20">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>
                                <span>Twitter</span>
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <!-- Spacer to compensate for fixed header -->
    <div class="header-spacer h-16"></div>

    <div id="content" class="site-content">
