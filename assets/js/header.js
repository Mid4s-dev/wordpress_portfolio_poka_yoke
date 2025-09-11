/**
 * Modern Header JavaScript
 * Handles mobile menu and scroll effects
 */
(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
        initializeHeader();
    });

    /**
     * Initialize the header functionality
     */
    function initializeHeader() {
        setupMobileMenu();
        setupScrollEffects();
        setupSmoothScrolling();
    }

    /**
     * Setup mobile menu toggle functionality
     */
    function setupMobileMenu() {
        const menuButton = document.getElementById('mobile-menu-button');
        const mobileDrawer = document.getElementById('mobile-menu-drawer');
        const body = document.body;

        if (!menuButton || !mobileDrawer) {
            console.error('Mobile menu elements not found.');
            return;
        }

        console.log('Mobile menu initialized successfully.');

        // Toggle mobile menu
        menuButton.addEventListener('click', function() {
            const isOpen = mobileDrawer.classList.contains('open');
            
            if (isOpen) {
                closeMobileMenu();
            } else {
                openMobileMenu();
            }
        });

        // Close mobile menu when clicking on the backdrop
        mobileDrawer.addEventListener('click', function(e) {
            if (e.target === mobileDrawer) {
                closeMobileMenu();
            }
        });

        // Close mobile menu when clicking on navigation links
        const mobileNavLinks = mobileDrawer.querySelectorAll('a');
        mobileNavLinks.forEach(link => {
            link.addEventListener('click', closeMobileMenu);
        });

        // Close mobile menu when ESC key is pressed
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && mobileDrawer.classList.contains('open')) {
                closeMobileMenu();
            }
        });

        // Function to open mobile menu
        function openMobileMenu() {
            mobileDrawer.classList.add('open');
            menuButton.classList.add('active');
            menuButton.setAttribute('aria-expanded', 'true');
            body.style.overflow = 'hidden';

            // Show close icon
            document.getElementById('hamburger-icon').classList.add('hidden');
            document.getElementById('close-icon').classList.remove('hidden');

            console.log('Mobile menu opened');
        }

        // Function to close mobile menu
        function closeMobileMenu() {
            mobileDrawer.classList.remove('open');
            menuButton.classList.remove('active');
            menuButton.setAttribute('aria-expanded', 'false');
            body.style.overflow = '';

            // Show hamburger icon
            document.getElementById('hamburger-icon').classList.remove('hidden');
            document.getElementById('close-icon').classList.add('hidden');

            console.log('Mobile menu closed');
        }
    }

    /**
     * Setup header effects on scroll
     */
    function setupScrollEffects() {
        const header = document.querySelector('.site-header');
        if (!header) return;

        let lastScrollTop = 0;

        window.addEventListener('scroll', function() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

            // Add shadow when scrolled down
            if (scrollTop > 10) {
                header.classList.add('shadow-lg');
            } else {
                header.classList.remove('shadow-lg');
            }

            lastScrollTop = scrollTop;
        });
    }

    /**
     * Setup smooth scrolling for navigation links
     */
    function setupSmoothScrolling() {
        const links = document.querySelectorAll('a[href^="#"]:not([href="#"])');

        links.forEach(link => {
            link.addEventListener('click', function(e) {
                // Get the target element
                const target = document.querySelector(this.getAttribute('href'));
                
                if (target) {
                    e.preventDefault();
                    
                    // Calculate offset considering fixed header
                    const headerHeight = document.querySelector('.site-header').offsetHeight;
                    const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - headerHeight;
                    
                    // Smooth scroll to target
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });
    }
})();
