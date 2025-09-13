/**
 * Modern Header JavaScript
 * Controls the mobile menu toggle and other header interactions
 */

document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const header = document.querySelector('.site-header');
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileDrawer = document.getElementById('mobile-drawer');
    const overlay = document.getElementById('mobile-overlay');
    const hamburgerIcon = document.querySelector('.hamburger-icon');
    
    // Function to handle scroll effects
    function handleScroll() {
        if (window.scrollY > 10) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    }
    
    // Function to toggle mobile menu
    function toggleMobileMenu() {
        const isExpanded = mobileMenuToggle.getAttribute('aria-expanded') === 'true';
        
        // Toggle aria-expanded attribute
        mobileMenuToggle.setAttribute('aria-expanded', !isExpanded);
        
        // Toggle classes
        hamburgerIcon.classList.toggle('active');
        mobileDrawer.classList.toggle('active');
        overlay.classList.toggle('active');
        
        // Prevent body scrolling when menu is open
        document.body.classList.toggle('menu-open');
    }
    
    // Add event listeners
    window.addEventListener('scroll', handleScroll);
    
    // Add click event to mobile menu toggle button
    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', toggleMobileMenu);
    }
    
    // Close mobile menu when clicking on overlay
    if (overlay) {
        overlay.addEventListener('click', toggleMobileMenu);
    }
    
    // Close mobile menu when clicking on a link
    const mobileLinks = document.querySelectorAll('.mobile-nav-link');
    mobileLinks.forEach(link => {
        link.addEventListener('click', function() {
            toggleMobileMenu();
        });
    });
    
    // Initialize scroll handler on page load
    handleScroll();
});
