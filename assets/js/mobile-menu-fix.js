/**
 * Mobile Menu Fix
 * Additional script to ensure mobile menu works properly
 */
(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
        fixMobileMenu();
        console.log('Mobile menu fix script loaded and running');
    });

    function fixMobileMenu() {
        // Get references to our elements with explicit error checking
        const menuButton = document.getElementById('mobile-menu-button');
        const mobileDrawer = document.getElementById('mobile-menu-drawer');
        const hamburgerIcon = document.getElementById('hamburger-icon');
        const closeIcon = document.getElementById('close-icon');
        
        console.log('Menu button found:', menuButton);
        console.log('Mobile drawer found:', mobileDrawer);
        console.log('Hamburger icon found:', hamburgerIcon);
        console.log('Close icon found:', closeIcon);
        
        if (!menuButton || !mobileDrawer) {
            console.error('Critical mobile menu elements not found!');
            return;
        }
        
        // Make absolutely sure the menu button is visible on mobile and hidden on desktop
        function updateMenuButtonVisibility() {
            if (window.innerWidth >= 768) {
                // Desktop view
                menuButton.classList.add('desktop-hidden');
                if (mobileDrawer.classList.contains('open')) {
                    mobileDrawer.classList.remove('open');
                }
                document.body.style.overflow = '';
            } else {
                // Mobile view
                menuButton.classList.remove('desktop-hidden');
                console.log('Mobile view active - hamburger should be visible');
                
                // Ensure icons are in correct state
                if (hamburgerIcon && closeIcon) {
                    // If menu is open, show close icon, otherwise show hamburger
                    const isMenuOpen = mobileDrawer.classList.contains('open');
                    hamburgerIcon.classList.toggle('hidden', isMenuOpen);
                    closeIcon.classList.toggle('hidden', !isMenuOpen);
                    
                    // Log icon state
                    console.log('Hamburger visible:', !hamburgerIcon.classList.contains('hidden'));
                    console.log('Close icon visible:', !closeIcon.classList.contains('hidden'));
                }
            }
        }
        
        // Initial call
        updateMenuButtonVisibility();
        
        // Update on window resize
        window.addEventListener('resize', updateMenuButtonVisibility);
        
        // Fix mobile menu height to ensure proper scrolling
        if (mobileDrawer) {
            const drawerContent = mobileDrawer.querySelector('.bg-shuka-black');
            if (drawerContent) {
                drawerContent.style.height = '100%';
                drawerContent.style.overflowY = 'auto';
                drawerContent.style.overflowX = 'hidden';
                drawerContent.style.webkitOverflowScrolling = 'touch';
            }
        }
    }
    })();
