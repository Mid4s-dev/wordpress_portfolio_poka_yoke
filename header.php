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

    <header id="masthead" class="site-header sticky top-0 z-50 bg-gradient-to-r from-primary-700 to-primary-600 text-white shadow-lg backdrop-blur-sm">
        <div class="container mx-auto flex items-center justify-between px-4 py-4 sm:px-6">
            <div class="site-branding flex-shrink-0">
                <?php if ( has_custom_logo() ) : ?>
                    <div class="custom-logo-container bg-white p-1 rounded-full">
                        <?php the_custom_logo(); ?>
                    </div>
                <?php else : ?>
                    <h1 class="site-title text-xl sm:text-2xl font-bold truncate">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="text-white hover:text-primary-100 transition-colors">
                            <?php bloginfo( 'name' ); ?>
                        </a>
                    </h1>
                <?php endif; ?>
            </div>

            <button class="mobile-menu-toggle md:hidden p-2 rounded-md bg-primary-800 hover:bg-primary-500 text-white transition-colors shadow-md" aria-controls="primary-menu" aria-expanded="false">
                <span class="screen-reader-text"><?php esc_html_e( 'Menu', 'portfolio' ); ?></span>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white hamburger-icon">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white close-icon hidden">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>

            <nav id="site-navigation" class="main-navigation">
                <!-- Desktop Menu -->
                <div class="hidden md:flex md:items-center md:gap-6">
                    <a href="#about" class="nav-link text-white hover:text-primary-100 font-medium py-2 px-3 rounded-md transition-all hover:bg-primary-500"><?php esc_html_e( 'About', 'portfolio' ); ?></a>
                    <a href="#services" class="nav-link text-white hover:text-primary-100 font-medium py-2 px-3 rounded-md transition-all hover:bg-primary-500"><?php esc_html_e( 'Services', 'portfolio' ); ?></a>
                    <a href="#portfolio" class="nav-link text-white hover:text-primary-100 font-medium py-2 px-3 rounded-md transition-all hover:bg-primary-500"><?php esc_html_e( 'Portfolio', 'portfolio' ); ?></a>
                    <a href="#blog" class="nav-link text-white hover:text-primary-100 font-medium py-2 px-3 rounded-md transition-all hover:bg-primary-500"><?php esc_html_e( 'Blog', 'portfolio' ); ?></a>
                    <a href="#contact" class="nav-link bg-white text-primary-600 hover:text-primary-700 font-medium py-2 px-4 rounded-full transition-all hover:bg-primary-50"><?php esc_html_e( 'Contact', 'portfolio' ); ?></a>
                    
                    <?php
                    // Fallback to WordPress menu if exists
                    wp_nav_menu(
                        array(
                            'theme_location' => 'primary',
                            'menu_id'        => 'primary-menu-additional',
                            'container'      => false,
                            'menu_class'     => 'flex gap-6',
                            'fallback_cb'    => false,
                            'depth'          => 1,
                            'link_before'    => '<span class="text-white hover:text-primary-100 font-medium py-2 px-3 rounded-md transition-all hover:bg-primary-500">',
                            'link_after'     => '</span>',
                        )
                    );
                    ?>
                </div>

                <!-- Mobile Menu -->
                <div id="mobile-menu" class="mobile-menu-overlay fixed inset-0 bg-black bg-opacity-70 z-40 hidden md:hidden">
                    <div class="mobile-menu-content fixed top-0 right-0 h-full w-full max-w-sm bg-gradient-to-b from-primary-700 to-primary-600 text-white shadow-xl transform translate-x-full transition-transform duration-300 ease-in-out">
                        <div class="flex flex-col h-full">
                            <!-- Header section with branding -->
                            <div class="flex items-center justify-between p-6 border-b border-primary-500 bg-primary-800">
                                <h2 class="text-xl font-bold text-white"><?php echo portfolio_get_owner_name(); ?></h2>
                                <button class="mobile-menu-close p-2 rounded-full hover:bg-primary-700 text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                </button>
                            </div>
                            
                            <!-- Navigation links -->
                            <div class="flex-1 flex flex-col justify-center px-6">
                                <div class="space-y-2">
                                    <a href="#about" class="mobile-nav-link font-medium text-white hover:bg-primary-500 transition-colors py-4 border-b border-primary-500 hover:border-white -mx-6 px-6 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-3"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path></svg>
                                        <?php esc_html_e( 'About', 'portfolio' ); ?>
                                    </a>
                                    <a href="#services" class="mobile-nav-link font-medium text-white hover:bg-primary-500 transition-colors py-4 border-b border-primary-500 hover:border-white -mx-6 px-6 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-3"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg>
                                        <?php esc_html_e( 'Services', 'portfolio' ); ?>
                                    </a>
                                    <a href="#portfolio" class="mobile-nav-link font-medium text-white hover:bg-primary-500 transition-colors py-4 border-b border-primary-500 hover:border-white -mx-6 px-6 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-3"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                                        <?php esc_html_e( 'Portfolio', 'portfolio' ); ?>
                                    </a>
                                    <a href="#blog" class="mobile-nav-link font-medium text-white hover:bg-primary-500 transition-colors py-4 border-b border-primary-500 hover:border-white -mx-6 px-6 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-3"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                                        <?php esc_html_e( 'Blog', 'portfolio' ); ?>
                                    </a>
                                    <a href="#contact" class="mobile-nav-link font-medium text-white hover:bg-primary-500 transition-colors py-4 border-b border-primary-500 hover:border-white -mx-6 px-6 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-3"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                        <?php esc_html_e( 'Contact', 'portfolio' ); ?>
                                    </a>
                                    
                                    <!-- Social Media Links -->
                                    <div class="mt-8 pt-6 border-t border-primary-500">
                                        <h3 class="font-medium text-white mb-4"><?php esc_html_e( 'Connect With Me', 'portfolio' ); ?></h3>
                                        <div class="flex space-x-4">
                                            <a href="#" class="p-2 bg-primary-800 rounded-full hover:bg-primary-500 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                                            </a>
                                            <a href="#" class="p-2 bg-primary-800 rounded-full hover:bg-primary-500 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                                            </a>
                                            <a href="#" class="p-2 bg-primary-800 rounded-full hover:bg-primary-500 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle></svg>
                                            </a>
                                            <a href="#" class="p-2 bg-primary-800 rounded-full hover:bg-primary-500 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <div id="content" class="site-content">
