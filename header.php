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

    <header id="masthead" class="site-header sticky top-0 z-50 bg-shuka-black text-white shadow-lg backdrop-blur-sm">
        <div class="absolute top-0 left-0 right-0 h-2 from-shuka-red to-shuka-yellow bg-shuka-pattern"></div>
        <div class="container mx-auto flex items-center justify-between px-4 py-4 sm:px-6">
            <div class="site-branding flex-shrink-0">
                <?php if ( has_custom_logo() ) : ?>
                    <div class="custom-logo-container bg-white p-1 rounded-full border-2 border-shuka-yellow">
                        <?php the_custom_logo(); ?>
                    </div>
                <?php else : ?>
                    <h1 class="site-title text-xl sm:text-2xl font-bold truncate">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="text-shuka-yellow hover:text-shuka-red transition-colors">
                            <?php bloginfo( 'name' ); ?>
                        </a>
                    </h1>
                <?php endif; ?>
            </div>

            <button class="mobile-menu-toggle md:hidden p-2 rounded-md bg-shuka-red/80 hover:bg-shuka-red text-white transition-colors shadow-md border border-shuka-yellow/20" aria-controls="primary-menu" aria-expanded="false">
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
                <div class="hidden md:flex md:items-center md:gap-4">
                    <a href="#about" class="nav-link text-white hover:text-shuka-yellow font-medium py-2 px-3 rounded-md transition-all hover:bg-shuka-red/60"><?php esc_html_e( 'About', 'portfolio' ); ?></a>
                    <a href="#skills" class="nav-link text-white hover:text-shuka-yellow font-medium py-2 px-3 rounded-md transition-all hover:bg-shuka-red/60"><?php esc_html_e( 'Skills', 'portfolio' ); ?></a>
                    <a href="#experience" class="nav-link text-white hover:text-shuka-yellow font-medium py-2 px-3 rounded-md transition-all hover:bg-shuka-red/60"><?php esc_html_e( 'Experience', 'portfolio' ); ?></a>
                    <a href="#projects" class="nav-link text-white hover:text-shuka-yellow font-medium py-2 px-3 rounded-md transition-all hover:bg-shuka-red/60"><?php esc_html_e( 'Projects', 'portfolio' ); ?></a>

                    <a href="#contact" class="shuka-button bg-shuka-red hover:bg-shuka-red-600"><?php esc_html_e( 'Contact', 'portfolio' ); ?></a>
                    
                    <?php
                    // Fallback to WordPress menu if exists
                    wp_nav_menu(
                        array(
                            'theme_location' => 'primary',
                            'menu_id'        => 'primary-menu-additional',
                            'container'      => false,
                            'menu_class'     => 'flex gap-4',
                            'fallback_cb'    => false,
                            'depth'          => 1,
                            'link_before'    => '<span class="text-white hover:text-shuka-yellow font-medium py-2 px-3 rounded-md transition-all hover:bg-shuka-red/60">',
                            'link_after'     => '</span>',
                        )
                    );
                    ?>
                </div>

                <!-- Mobile Menu -->
                <div id="mobile-menu" class="mobile-menu-overlay fixed inset-0 bg-black bg-opacity-80 z-40 hidden md:hidden">
                    <div class="mobile-menu-content fixed top-0 right-0 h-full w-full max-w-sm bg-shuka-black text-white shadow-xl transform translate-x-full transition-transform duration-300 ease-in-out">
                        <div class="flex flex-col h-full">
                            <!-- Header section with branding -->
                            <div class="flex items-center justify-between p-6 border-b border-shuka-red/30 bg-shuka-pattern-small from-shuka-black to-shuka-earth/80">
                                <h2 class="text-xl font-bold text-shuka-yellow"><?php echo portfolio_get_owner_name(); ?></h2>
                                <button class="mobile-menu-close p-2 rounded-full hover:bg-shuka-red/50 text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                </button>
                            </div>
                            
                            <!-- Navigation links -->
                            <div class="flex-1 flex flex-col justify-center px-6 overflow-y-auto bg-shuka-pattern-large from-shuka-black to-shuka-earth/30 bg-opacity-5">
                                <div class="space-y-1">
                                    <a href="#about" class="mobile-nav-link font-medium text-white hover:text-shuka-yellow transition-colors py-4 border-b border-shuka-red/30 hover:border-shuka-yellow -mx-6 px-6 flex items-center">
                                        <div class="mr-4 p-2 bg-shuka-red rounded-full">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path></svg>
                                        </div>
                                        <?php esc_html_e( 'About', 'portfolio' ); ?>
                                    </a>
                                    <a href="#skills" class="mobile-nav-link font-medium text-white hover:text-shuka-yellow transition-colors py-4 border-b border-shuka-red/30 hover:border-shuka-yellow -mx-6 px-6 flex items-center">
                                        <div class="mr-4 p-2 bg-shuka-blue rounded-full">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg>
                                        </div>
                                        <?php esc_html_e( 'Skills', 'portfolio' ); ?>
                                    </a>
                                    <a href="#experience" class="mobile-nav-link font-medium text-white hover:text-shuka-yellow transition-colors py-4 border-b border-shuka-red/30 hover:border-shuka-yellow -mx-6 px-6 flex items-center">
                                        <div class="mr-4 p-2 bg-shuka-yellow rounded-full">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="5"></circle><path d="M3 21h18a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2z"></path></svg>
                                        </div>
                                        <?php esc_html_e( 'Experience', 'portfolio' ); ?>
                                    </a>
                                    <a href="#projects" class="mobile-nav-link font-medium text-white hover:text-shuka-yellow transition-colors py-4 border-b border-shuka-red/30 hover:border-shuka-yellow -mx-6 px-6 flex items-center">
                                        <div class="mr-4 p-2 bg-shuka-earth rounded-full">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                                        </div>
                                        <?php esc_html_e( 'Projects', 'portfolio' ); ?>
                                    </a>

                                    <a href="#contact" class="mobile-nav-link font-medium text-white hover:text-shuka-yellow transition-colors py-4 border-b border-shuka-red/30 hover:border-shuka-yellow -mx-6 px-6 flex items-center">
                                        <div class="mr-4 p-2 bg-shuka-red rounded-full">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                        </div>
                                        <?php esc_html_e( 'Contact', 'portfolio' ); ?>
                                    </a>
                                    
                                    <!-- Social Media Links -->
                                    <div class="mt-8 pt-6 border-t border-shuka-yellow/30">
                                        <h3 class="font-bold text-shuka-yellow mb-4"><?php esc_html_e( 'Connect With Me', 'portfolio' ); ?></h3>
                                        <div class="flex space-x-3">
                                            <a href="https://github.com/Mid4s-dev" target="_blank" rel="noopener noreferrer" class="p-3 bg-shuka-red/20 border border-shuka-red/30 rounded-full text-shuka-red hover:bg-shuka-red hover:text-white hover:border-transparent transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path></svg>
                                            </a>
                                            <a href="https://linkedin.com/in/joshua-lugaya-mid4s-dev" target="_blank" rel="noopener noreferrer" class="p-3 bg-shuka-blue/20 border border-shuka-blue/30 rounded-full text-shuka-blue hover:bg-shuka-blue hover:text-white hover:border-transparent transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle></svg>
                                            </a>
                                            <a href="https://twitter.com/mid4s_dev" target="_blank" rel="noopener noreferrer" class="p-3 bg-shuka-yellow/20 border border-shuka-yellow/30 rounded-full text-shuka-yellow hover:bg-shuka-yellow hover:text-shuka-black hover:border-transparent transition-colors">
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
