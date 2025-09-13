/**
 * Main theme JavaScript file
 */
(function() {
    'use strict';

    // Mobile menu toggle
    function setupMobileMenu() {
        // Debug - log all IDs that start with mobile
        document.querySelectorAll('[id^="mobile"]').forEach(el => {
            console.log('Found mobile element:', el.id);
        });
        
        const menuButton = document.getElementById('mobile-menu-button');
        console.log('Mobile menu button found:', menuButton);
        
        const mobileDrawer = document.getElementById('mobile-menu-drawer');
        console.log('Mobile drawer found:', mobileDrawer);
        
        const body = document.body;
        
        if (!menuButton || !mobileDrawer) {
            console.error('Mobile menu elements not found. menuButton:', menuButton, 'mobileDrawer:', mobileDrawer);
            return;
        }
        
        console.log('Mobile menu initialized successfully.');

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
            body.style.overflow = 'hidden';
            
            // Toggle icons visibility
            const hamburgerIcon = document.getElementById('js-hamburger-icon');
            const closeIcon = document.getElementById('js-close-icon');
            
            if (hamburgerIcon && closeIcon) {
                hamburgerIcon.classList.add('hidden');
                closeIcon.classList.remove('hidden');
                console.log('Icon state updated - hamburger hidden, close icon visible');
            } else {
                console.error('Could not toggle icon visibility!');
            }
            
            console.log('Mobile menu opened');
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
            body.style.overflow = '';
            
            // Toggle icons visibility
            const hamburgerIcon = document.getElementById('js-hamburger-icon');
            const closeIcon = document.getElementById('js-close-icon');
            
            if (hamburgerIcon && closeIcon) {
                hamburgerIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
                console.log('Icon state updated - hamburger visible, close icon hidden');
            }
            
            // Wait for animation to complete before hiding
            setTimeout(function() {
                mobileDrawer.style.display = 'none';
                mobileDrawer.style.visibility = 'hidden';
                console.log('Mobile menu closed and hidden');
            }, 300);
        }

        // Toggle menu on button click
        menuButton.addEventListener('click', function(e) {
            e.preventDefault();
            
            const isOpen = mobileDrawer.classList.contains('open');
            
            if (isOpen) {
                closeMobileMenu();
            } else {
                openMobileMenu();
            }
        });
        
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

        // Handle window resize
        window.addEventListener('resize', function() {
            // Close mobile menu if screen gets larger
            if (window.innerWidth >= 768 && mobileDrawer.classList.contains('open')) {
                closeMobileMenu();
            }
        });
    }

    // Smooth scrolling for anchor links
    function setupSmoothScroll() {
        const navLinks = document.querySelectorAll('.nav-link, .mobile-nav-link, a[href^="#"]');
        
        navLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                
                if (href && href.startsWith('#')) {
                    e.preventDefault();
                    const target = document.querySelector(href);
                    
                    if (target) {
                        const headerHeight = document.querySelector('.site-header')?.offsetHeight || 0;
                        const targetPosition = target.offsetTop - headerHeight - 20;
                        
                        window.scrollTo({
                            top: targetPosition,
                            behavior: 'smooth'
                        });
                    }
                }
            });
        });
    }

    // Sticky header effects and active navigation
    function setupStickyHeader() {
        const header = document.querySelector('.site-header');
        const navLinks = document.querySelectorAll('.nav-link');
        const sections = document.querySelectorAll('section[id]');
        
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
            
            // Update active navigation
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop - 100;
                const sectionHeight = section.offsetHeight;
                
                if (currentScrollY >= sectionTop && currentScrollY < sectionTop + sectionHeight) {
                    current = section.getAttribute('id');
                }
            });
            
            navLinks.forEach(link => {
                // Remove any previous active classes
                link.classList.remove('text-primary-600');
                link.classList.remove('text-shuka-yellow');
                
                // Add appropriate active class based on the current section
                if (link.getAttribute('href') === `#${current}`) {
                    // Use Maasai theme color
                    link.classList.add('text-shuka-yellow');
                }
            });
            
            lastScrollY = currentScrollY;
        });
    }

    // Newsletter form handling
    function setupNewsletterForm() {
        const newsletterForm = document.getElementById('newsletter-form');
        const newsletterResponse = document.getElementById('newsletter-response');
        
        if (!newsletterForm) return;
        
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const email = formData.get('newsletter_email');
            const name = formData.get('newsletter_name');
            
            if (!email) return;
            
            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Subscribing...';
            submitBtn.disabled = true;
            
            // Simulate form submission (replace with actual implementation)
            setTimeout(() => {
                if (newsletterResponse) {
                    newsletterResponse.classList.remove('hidden');
                    newsletterResponse.innerHTML = '<p class="bg-white text-primary-600 py-2 px-4 rounded-md shadow-md inline-block font-medium">Thank you for subscribing!</p>';
                }
                
                this.reset();
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
                
                setTimeout(() => {
                    if (newsletterResponse) {
                        newsletterResponse.classList.add('hidden');
                    }
                }, 5000);
            }, 1000);
        });
    }

    // Initialize when the DOM is fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM content loaded - initializing menu components');
        
        // Debug check for mobile menu drawer and ensure it's properly hidden initially
        const mobileDrawer = document.getElementById('mobile-menu-drawer');
        if (mobileDrawer) {
            console.log('Mobile menu drawer found, initializing...');
            
            // Make sure it's hidden initially
            mobileDrawer.style.display = 'none';
            mobileDrawer.classList.remove('open');
            mobileDrawer.style.visibility = 'hidden';
        } else {
            console.error('Mobile menu drawer not found!');
        }
        
        // Ensure mobile menu button is properly set up
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        if (mobileMenuButton) {
            console.log('Mobile menu button found');
            
            // Make sure aria-expanded is initially false
            mobileMenuButton.setAttribute('aria-expanded', 'false');
            
            // Show/hide button based on screen width
            if (window.innerWidth >= 768) {
                mobileMenuButton.style.display = 'none';
            } else {
                mobileMenuButton.style.display = 'flex';
                console.log('Mobile view detected - hamburger should be visible');
            }
            
            // Ensure proper icon visibility
            const hamburgerIcon = document.getElementById('js-hamburger-icon');
            const closeIcon = document.getElementById('js-close-icon');
            
            if (hamburgerIcon && closeIcon) {
                hamburgerIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
                console.log('Icons initialized - hamburger visible, close icon hidden');
            } else {
                console.error('Mobile menu icons not found!');
            }
        } else {
            console.error('Mobile menu button not found!');
        }
        
        // Set up all components
        setupMobileMenu();
        setupSmoothScroll();
        setupStickyHeader();
        setupNewsletterForm();
    });

})();
