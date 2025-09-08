/**
 * Main theme JavaScript file
 */
(function() {
    'use strict';

    // Mobile menu toggle
    function setupMobileMenu() {
        const mobileToggle = document.querySelector('.mobile-menu-toggle');
        if (!mobileToggle) return;

        const menuContainer = document.querySelector('.main-navigation');
        const menuItems = document.getElementById('primary-menu');
        
        mobileToggle.addEventListener('click', function() {
            menuContainer.classList.toggle('menu-open');
            if (menuItems) {
                if (menuContainer.classList.contains('menu-open')) {
                    menuItems.classList.remove('hidden');
                } else {
                    menuItems.classList.add('hidden');
                }
            }
            
            mobileToggle.setAttribute('aria-expanded', 
                mobileToggle.getAttribute('aria-expanded') === 'true' ? 'false' : 'true'
            );
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            const isClickInside = menuContainer.contains(event.target) || mobileToggle.contains(event.target);
            if (!isClickInside && menuContainer.classList.contains('menu-open')) {
                menuContainer.classList.remove('menu-open');
                if (menuItems) {
                    menuItems.classList.add('hidden');
                }
                mobileToggle.setAttribute('aria-expanded', 'false');
            }
        });
    }

    // Sticky header effects
    function setupStickyHeader() {
        const header = document.querySelector('.site-header');
        if (!header) return;

        let lastScrollY = window.scrollY;
        
        window.addEventListener('scroll', function() {
            const currentScrollY = window.scrollY;
            
            // Add shadow when scrolling down
            if (currentScrollY > 50) {
                header.classList.add('shadow-md');
            } else {
                header.classList.remove('shadow-md');
            }
            
            lastScrollY = currentScrollY;
        });
    }

    // Smooth scrolling for anchor links
    function setupSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const target = document.querySelector(this.getAttribute('href'));
                
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
    }

    // Initialize when the DOM is fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        setupMobileMenu();
        setupStickyHeader();
        setupSmoothScroll();
    });

})();
