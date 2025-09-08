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

    <header id="masthead" class="site-header bg-white sticky top-0 z-50 shadow-sm backdrop-blur-sm bg-white/95">
        <div class="container mx-auto flex items-center px-4 py-3 sm:px-6">
            <div class="site-branding flex-shrink-0">
                <?php if ( has_custom_logo() ) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <h1 class="site-title text-xl sm:text-2xl font-bold truncate">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="text-gray-900 hover:text-primary-600 transition-colors">
                            <?php bloginfo( 'name' ); ?>
                        </a>
                    </h1>
                <?php endif; ?>
            </div>

            <!-- Spacer to push hamburger to the right -->
            <div class="flex-1"></div>

            <button class="mobile-menu-toggle md:hidden p-2 rounded-md hover:bg-gray-100 transition-colors" aria-controls="primary-menu" aria-expanded="false">
                <span class="screen-reader-text"><?php esc_html_e( 'Menu', 'portfolio' ); ?></span>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-800 hamburger-icon">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-800 close-icon hidden">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>

            <nav id="site-navigation" class="main-navigation">
                <!-- Desktop Menu -->
                <div class="hidden md:flex md:items-center md:gap-8">
                    <a href="#home" class="nav-link text-gray-800 hover:text-primary-600 font-medium transition-colors"><?php esc_html_e( 'Home', 'portfolio' ); ?></a>
                    <a href="#about" class="nav-link text-gray-800 hover:text-primary-600 font-medium transition-colors"><?php esc_html_e( 'About', 'portfolio' ); ?></a>
                    <a href="#services" class="nav-link text-gray-800 hover:text-primary-600 font-medium transition-colors"><?php esc_html_e( 'Services', 'portfolio' ); ?></a>
                    <a href="#portfolio" class="nav-link text-gray-800 hover:text-primary-600 font-medium transition-colors"><?php esc_html_e( 'Portfolio', 'portfolio' ); ?></a>
                    <a href="#blog" class="nav-link text-gray-800 hover:text-primary-600 font-medium transition-colors"><?php esc_html_e( 'Blog', 'portfolio' ); ?></a>
                    <a href="#contact" class="nav-link text-gray-800 hover:text-primary-600 font-medium transition-colors"><?php esc_html_e( 'Contact', 'portfolio' ); ?></a>
                    
                    <?php
                    // Fallback to WordPress menu if exists
                    wp_nav_menu(
                        array(
                            'theme_location' => 'primary',
                            'menu_id'        => 'primary-menu-additional',
                            'container'      => false,
                            'menu_class'     => 'flex gap-8',
                            'fallback_cb'    => false,
                            'depth'          => 1,
                        )
                    );
                    ?>
                </div>

                <!-- Mobile Menu -->
                <div id="mobile-menu" class="mobile-menu-overlay fixed inset-0 bg-black bg-opacity-50 z-40 hidden md:hidden">
                    <div class="mobile-menu-content fixed top-0 right-0 h-full w-full max-w-sm bg-white shadow-xl transform translate-x-full transition-transform duration-300 ease-in-out">
                        <div class="flex flex-col h-full bg-white">
                            <!-- Header section with branding -->
                            <div class="flex items-center justify-between p-6 border-b border-gray-100 bg-white">
                                <h2 class="text-xl font-bold text-gray-900"><?php echo portfolio_get_owner_name(); ?></h2>
                            </div>
                            
                            <!-- Navigation links -->
                            <div class="flex-1 flex flex-col justify-center px-6 bg-white">
                                <div class="space-y-6">
                                    <a href="#home" class="mobile-nav-link block text-xl font-medium text-gray-800 hover:text-primary-600 transition-colors py-4 border-b border-gray-100 hover:bg-gray-50 -mx-6 px-6"><?php esc_html_e( 'Home', 'portfolio' ); ?></a>
                                    <a href="#about" class="mobile-nav-link block text-xl font-medium text-gray-800 hover:text-primary-600 transition-colors py-4 border-b border-gray-100 hover:bg-gray-50 -mx-6 px-6"><?php esc_html_e( 'About', 'portfolio' ); ?></a>
                                    <a href="#services" class="mobile-nav-link block text-xl font-medium text-gray-800 hover:text-primary-600 transition-colors py-4 border-b border-gray-100 hover:bg-gray-50 -mx-6 px-6"><?php esc_html_e( 'Services', 'portfolio' ); ?></a>
                                    <a href="#portfolio" class="mobile-nav-link block text-xl font-medium text-gray-800 hover:text-primary-600 transition-colors py-4 border-b border-gray-100 hover:bg-gray-50 -mx-6 px-6"><?php esc_html_e( 'Portfolio', 'portfolio' ); ?></a>
                                    <a href="#blog" class="mobile-nav-link block text-xl font-medium text-gray-800 hover:text-primary-600 transition-colors py-4 border-b border-gray-100 hover:bg-gray-50 -mx-6 px-6"><?php esc_html_e( 'Blog', 'portfolio' ); ?></a>
                                    <a href="#contact" class="mobile-nav-link block text-xl font-medium text-gray-800 hover:text-primary-600 transition-colors py-4 border-b border-gray-100 hover:bg-gray-50 -mx-6 px-6"><?php esc_html_e( 'Contact', 'portfolio' ); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <div id="content" class="site-content">
