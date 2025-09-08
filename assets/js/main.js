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
        const body = document.body;
        
        mobileToggle.addEventListener('click', function() {
            menuContainer.classList.toggle('menu-open');
            
            if (menuItems) {
                if (menuContainer.classList.contains('menu-open')) {
                    menuItems.classList.remove('hidden');
                    menuItems.classList.add('flex', 'flex-col', 'items-center', 'fixed', 'inset-0', 'bg-white', 'bg-opacity-95', 'pt-20', 'z-40');
                    body.classList.add('overflow-hidden');
                } else {
                    menuItems.classList.add('hidden');
                    menuItems.classList.remove('flex', 'flex-col', 'items-center', 'fixed', 'inset-0', 'bg-white', 'bg-opacity-95', 'pt-20', 'z-40');
                    body.classList.remove('overflow-hidden');
                }
            }
            
            // Toggle the aria-expanded attribute
            mobileToggle.setAttribute('aria-expanded', 
                mobileToggle.getAttribute('aria-expanded') === 'true' ? 'false' : 'true'
            );
            
            // Update the icon
            const icon = mobileToggle.querySelector('svg');
            if (menuContainer.classList.contains('menu-open')) {
                icon.innerHTML = '<line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line>';
            } else {
                icon.innerHTML = '<line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line>';
            }
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            const isClickInside = menuContainer.contains(event.target) || mobileToggle.contains(event.target);
            if (!isClickInside && menuContainer.classList.contains('menu-open')) {
                menuContainer.classList.remove('menu-open');
                
                if (menuItems) {
                    menuItems.classList.add('hidden');
                    menuItems.classList.remove('flex', 'flex-col', 'items-center', 'fixed', 'inset-0', 'bg-white', 'bg-opacity-95', 'pt-20', 'z-40');
                    body.classList.remove('overflow-hidden');
                }
                
                mobileToggle.setAttribute('aria-expanded', 'false');
                
                // Reset the icon
                const icon = mobileToggle.querySelector('svg');
                icon.innerHTML = '<line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line>';
            }
        });
        
        // Add click handlers for mobile menu items to close menu when clicking a link
        if (menuItems) {
            const menuLinks = menuItems.querySelectorAll('a');
            menuLinks.forEach(link => {
                link.addEventListener('click', () => {
                    if (menuContainer.classList.contains('menu-open')) {
                        menuContainer.classList.remove('menu-open');
                        menuItems.classList.add('hidden');
                        menuItems.classList.remove('flex', 'flex-col', 'items-center', 'fixed', 'inset-0', 'bg-white', 'bg-opacity-95', 'pt-20', 'z-40');
                        body.classList.remove('overflow-hidden');
                        mobileToggle.setAttribute('aria-expanded', 'false');
                        
                        // Reset the icon
                        const icon = mobileToggle.querySelector('svg');
                        icon.innerHTML = '<line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line>';
                    }
                });
            });
        }
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
