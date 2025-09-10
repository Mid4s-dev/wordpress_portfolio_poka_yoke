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
        const hamburgerIcon = document.querySelector('.hamburger-icon');
        const closeIcon = document.querySelector('.close-icon');
        const body = document.body;
        
        if (!mobileToggle || !mobileMenu) return;

        function openMobileMenu() {
            mobileMenu.classList.remove('hidden');
            mobileMenu.classList.add('active');
            body.classList.add('overflow-hidden');
            
            // Toggle icons
            if (hamburgerIcon) hamburgerIcon.classList.add('hidden');
            if (closeIcon) closeIcon.classList.remove('hidden');
            
            mobileToggle.setAttribute('aria-expanded', 'true');
            
            // Animate menu in
            setTimeout(() => {
                if (mobileMenuContent) {
                    mobileMenuContent.style.transform = 'translateX(0)';
                }
            }, 10);
        }

        function closeMobileMenu() {
            // Animate menu out
            if (mobileMenuContent) {
                mobileMenuContent.style.transform = 'translateX(100%)';
            }
            body.classList.remove('overflow-hidden');
            
            // Toggle icons
            if (hamburgerIcon) hamburgerIcon.classList.remove('hidden');
            if (closeIcon) closeIcon.classList.add('hidden');
            
            mobileToggle.setAttribute('aria-expanded', 'false');
            
            setTimeout(() => {
                mobileMenu.classList.remove('active');
                mobileMenu.classList.add('hidden');
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
            if (window.innerWidth >= 768 && mobileMenu.classList.contains('active')) {
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
        setupMobileMenu();
        setupSmoothScroll();
        setupStickyHeader();
        setupNewsletterForm();
    });

})();
