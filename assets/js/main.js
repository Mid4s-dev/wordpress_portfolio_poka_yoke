/**
 * Main theme JavaScript file
 */
(function() {
    'use strict';

    // Mobile menu toggle
    function setupMobileMenu() {
        const mobileToggle = document.querySelector('.mobile-menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        const mobileMenuContent = document.querySelector('.mobile-menu-content');
        const body = document.body;
        
        if (!mobileToggle || !mobileMenu) {
            console.error('Mobile menu elements not found');
            return;
        }
        
        console.log('Mobile menu setup initialized');

        function openMobileMenu() {
            console.log('Opening mobile menu');
            
            // First make the menu visible but without transitions
            mobileMenu.classList.remove('hidden');
            
            // Force a reflow to ensure the removal of hidden takes effect before adding active
            void mobileMenu.offsetWidth;
            
            // Apply direct styling to ensure it works
            if (mobileMenuContent) {
                // Reset any inline styles that might be interfering
                mobileMenuContent.style.width = '85%';
                mobileMenuContent.style.maxWidth = '320px';
                mobileMenuContent.style.height = '100%';
                
                // Ensure menu stays in place on smaller screens
                if (window.innerWidth <= 480) {
                    mobileMenuContent.style.width = '90%';
                    mobileMenuContent.style.maxWidth = '280px';
                }
            }
            
            // Now add the active class to trigger the animation
            requestAnimationFrame(() => {
                mobileMenu.classList.add('active');
                body.classList.add('overflow-hidden');
                
                // Toggle button class for X animation
                mobileToggle.classList.add('is-active');
                mobileToggle.setAttribute('aria-expanded', 'true');
                
                // Force the transform to be applied correctly after a small delay
                setTimeout(() => {
                    if (mobileMenuContent) {
                        // Log for debugging
                        console.log('Menu content transform:', window.getComputedStyle(mobileMenuContent).transform);
                        
                        // Force transform to 0
                        mobileMenuContent.style.transform = 'translateX(0)';
                        console.log('Forcing transform reset');
                    }
                }, 50);
            });
        }

        function closeMobileMenu() {
            console.log('Closing mobile menu');
            
            // Remove active class first to trigger the slide-out animation
            mobileMenu.classList.remove('active');
            mobileToggle.classList.remove('is-active');
            mobileToggle.setAttribute('aria-expanded', 'false');
            
            // Wait for the animation to complete before hiding completely
            setTimeout(() => {
                mobileMenu.classList.add('hidden');
                body.classList.remove('overflow-hidden');
            }, 300);
        }

        // Toggle menu on hamburger click
        mobileToggle.addEventListener('click', function(e) {
            e.preventDefault();
            
            const isOpen = mobileMenu.classList.contains('active');
            
            if (isOpen) {
                closeMobileMenu();
            } else {
                openMobileMenu();
            }
        });
        
        // Close menu when clicking overlay
        if (mobileMenu) {
            mobileMenu.addEventListener('click', function(e) {
                if (e.target === mobileMenu) {
                    closeMobileMenu();
                }
            });
        }
        
        // Close menu when clicking the close button
        const mobileMenuCloseBtn = document.querySelector('.mobile-menu-close');
        if (mobileMenuCloseBtn) {
            mobileMenuCloseBtn.addEventListener('click', function(e) {
                e.preventDefault();
                closeMobileMenu();
            });
        }
        
        // Close menu when clicking nav links
        const mobileNavLinks = document.querySelectorAll('.mobile-nav-link');
        mobileNavLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (mobileMenu.classList.contains('active')) {
                    closeMobileMenu();
                }
            });
        });
        
        // Close menu on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && mobileMenu.classList.contains('active')) {
                closeMobileMenu();
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            // Close mobile menu if screen gets larger
            if (window.innerWidth >= 768 && mobileMenu.classList.contains('active')) {
                closeMobileMenu();
            }
            
            // Ensure toggle button visibility is correct based on screen size
            if (window.innerWidth >= 768) {
                // On desktop/tablet, force hide the toggle
                mobileToggle.style.display = 'none';
            } else {
                // On mobile, allow CSS to control display
                mobileToggle.style.display = '';
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
        // Set up all components
        setupMobileMenu();
        setupSmoothScroll();
        setupStickyHeader();
        setupNewsletterForm();
        
        // Additional check to ensure hamburger menu is hidden on desktop
        const mobileToggle = document.querySelector('.mobile-menu-toggle');
        if (mobileToggle && window.innerWidth >= 768) {
            mobileToggle.style.display = 'none';
        }
    });

})();
