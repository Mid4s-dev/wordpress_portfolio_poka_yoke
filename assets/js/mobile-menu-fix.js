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
        const menuButton = document.getElementById('js-mobile-menu-button');
        const mobileDrawer = document.getElementById('js-mobile-menu-drawer');
        const hamburgerIcon = document.getElementById('js-hamburger-icon');
        const closeIcon = document.getElementById('js-close-icon');
        
        console.log('Menu button found:', menuButton);
        console.log('Mobile drawer found:', mobileDrawer);
        console.log('Hamburger icon found:', hamburgerIcon);
        console.log('Close icon found:', closeIcon);
        
        if (!menuButton || !mobileDrawer) {
            console.error('Critical mobile menu elements not found!');
            return;
        }

        // Add click event to the menu button
        menuButton.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Mobile menu button clicked');
            
            const isMenuOpen = mobileDrawer.classList.contains('open');
            
            if (isMenuOpen) {
                closeMobileMenu();
            } else {
                openMobileMenu();
            }
        });
        
        // Function to open mobile menu
        function openMobileMenu() {
            console.log('Opening mobile menu');
            
            // Make drawer visible first
            mobileDrawer.style.display = 'block';
            mobileDrawer.style.visibility = 'visible';
            
            // Force a reflow to ensure display change takes effect
            void mobileDrawer.offsetWidth;
            
            // Apply active class to show menu with animation
            mobileDrawer.classList.add('open');
            
            // Update button state
            menuButton.classList.add('active');
            menuButton.setAttribute('aria-expanded', 'true');
            
            // Prevent body scrolling
            document.body.style.overflow = 'hidden';
            
            // Toggle icons visibility
            if (hamburgerIcon && closeIcon) {
                hamburgerIcon.classList.add('hidden');
                closeIcon.classList.remove('hidden');
                console.log('Icon state updated - hamburger hidden, close icon visible');
            }
        }
        
        // Function to close mobile menu
        function closeMobileMenu() {
            console.log('Closing mobile menu');
            
            // Remove open class to trigger animation
            mobileDrawer.classList.remove('open');
            
            // Update button state
            menuButton.classList.remove('active');
            menuButton.setAttribute('aria-expanded', 'false');
            
            // Restore body scrolling
            document.body.style.overflow = '';
            
            // Toggle icons visibility
            if (hamburgerIcon && closeIcon) {
                hamburgerIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
                console.log('Icon state updated - hamburger visible, close icon hidden');
            }
            
            // Wait for animation to complete before hiding
            setTimeout(function() {
                mobileDrawer.style.display = 'none';
                mobileDrawer.style.visibility = 'hidden';
            }, 300);
        }
        
        // Make absolutely sure the menu button is visible on mobile and hidden on desktop
        function updateMenuButtonVisibility() {
            if (window.innerWidth >= 768) {
                // Desktop view
                menuButton.style.display = 'none';
                if (mobileDrawer.classList.contains('open')) {
                    closeMobileMenu();
                }
            } else {
                // Mobile view
                menuButton.style.display = 'flex';
                console.log('Mobile view active - hamburger should be visible');
                
                // Ensure icons are in correct state
                if (hamburgerIcon && closeIcon) {
                    // If menu is open, show close icon, otherwise show hamburger
                    const isMenuOpen = mobileDrawer.classList.contains('open');
                    hamburgerIcon.classList.toggle('hidden', isMenuOpen);
                    closeIcon.classList.toggle('hidden', !isMenuOpen);
                }
            }
        }
        
        // Initial call
        updateMenuButtonVisibility();
        
        // Update on window resize
        window.addEventListener('resize', updateMenuButtonVisibility);
        
        // Fix mobile menu height to ensure proper scrolling
        if (mobileDrawer) {
            const drawerContent = mobileDrawer.querySelector('.w-4/5');
            if (drawerContent) {
                drawerContent.style.height = '100%';
                drawerContent.style.overflowY = 'auto';
                drawerContent.style.overflowX = 'hidden';
                drawerContent.style.webkitOverflowScrolling = 'touch';
            }
        }
        
        // Close menu when clicking outside of it
        mobileDrawer.addEventListener('click', function(e) {
            // If clicking on the dark overlay (not the menu content)
            if (e.target === mobileDrawer) {
                closeMobileMenu();
            }
        });
        
        // Close menu when clicking nav links
        const mobileNavLinks = document.querySelectorAll('.mobile-nav-item');
        mobileNavLinks.forEach(link => {
            link.addEventListener('click', () => {
                closeMobileMenu();
            });
        });
        
        // Close menu on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && mobileDrawer.classList.contains('open')) {
                closeMobileMenu();
            }
        });

        // Make sure the drawer is initially hidden
        if (!mobileDrawer.classList.contains('open')) {
            mobileDrawer.style.display = 'none';
            mobileDrawer.style.visibility = 'hidden';
        }
        
        // Make sure the aria state is correct initially
        menuButton.setAttribute('aria-expanded', 'false');
    }
})();
