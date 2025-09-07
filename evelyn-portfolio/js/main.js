/**
 * Evelyn Portfolio - Main JavaScript
 * 
 * Handles interactive UI elements for the Evelyn Portfolio theme
 */

document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    }

    // Header scroll effect
    function updateHeader() {
        const header = document.getElementById('site-header');
        if (!header) return;
        
        if (window.scrollY > 100) {
            header.classList.add('py-2');
            header.classList.add('bg-white/95');
            header.classList.add('backdrop-blur-md');
        } else {
            header.classList.remove('py-2');
            header.classList.remove('bg-white/95');
            header.classList.remove('backdrop-blur-md');
        }
    }
    
    // Initialize header state
    updateHeader();
    
    // Add scroll event listener
    window.addEventListener('scroll', updateHeader);

    // Portfolio image reveal animation
    const portfolioItems = document.querySelectorAll('.portfolio-item');
    
    if (portfolioItems.length > 0) {
        if ('IntersectionObserver' in window) {
            const portfolioObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('reveal');
                        portfolioObserver.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.2
            });
            
            portfolioItems.forEach(item => {
                portfolioObserver.observe(item);
            });
        } else {
            // Fallback for browsers without IntersectionObserver
            portfolioItems.forEach(item => {
                item.classList.add('reveal');
            });
        }
    }

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 80, // Adjust for header height
                    behavior: 'smooth'
                });
                
                // Update URL without page reload
                history.pushState(null, null, targetId);
            }
        });
    });

    // Lightbox for portfolio images
    const portfolioImages = document.querySelectorAll('.portfolio-gallery img');
    if (portfolioImages.length > 0) {
        portfolioImages.forEach(img => {
            img.addEventListener('click', function() {
                const lightbox = document.createElement('div');
                lightbox.className = 'fixed inset-0 bg-black bg-opacity-90 flex items-center justify-center z-50';
                
                const imgClone = this.cloneNode();
                imgClone.className = 'max-h-[90vh] max-w-[90vw] object-contain';
                
                lightbox.appendChild(imgClone);
                document.body.appendChild(lightbox);
                
                // Prevent scrolling when lightbox is open
                document.body.style.overflow = 'hidden';
                
                lightbox.addEventListener('click', function() {
                    document.body.style.overflow = '';
                    lightbox.remove();
                });
            });
        });
    }

    // Blog post hover effect
    const blogPosts = document.querySelectorAll('.blog-post');
    if (blogPosts.length > 0) {
        blogPosts.forEach(post => {
            post.addEventListener('mouseenter', function() {
                const overlay = this.querySelector('.blog-post-overlay');
                const content = this.querySelector('.blog-post-content');
                
                if (overlay) overlay.classList.add('opacity-100');
                if (content) content.classList.add('translate-y-0');
            });
            
            post.addEventListener('mouseleave', function() {
                const overlay = this.querySelector('.blog-post-overlay');
                const content = this.querySelector('.blog-post-content');
                
                if (overlay) overlay.classList.remove('opacity-100');
                if (content) content.classList.remove('translate-y-0');
            });
        });
    }
    
    // Hero text animation if it exists
    const heroText = document.querySelector('.hero-text');
    if (heroText) {
        const text = heroText.textContent;
        heroText.textContent = '';
        
        let i = 0;
        const typeWriter = () => {
            if (i < text.length) {
                heroText.textContent += text.charAt(i);
                i++;
                setTimeout(typeWriter, 100);
            }
        };
        
        // Start animation with a slight delay after page load
        setTimeout(typeWriter, 500);
    }
});
