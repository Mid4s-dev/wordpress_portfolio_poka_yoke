/**
 * JavaScript for the Campaigns template
 */

document.addEventListener('DOMContentLoaded', function() {
    // Filter form handling
    const filterForm = document.getElementById('campaigns-filter-form');
    const resetButton = document.getElementById('filter-reset');
    
    if (filterForm) {
        // Apply filter button click event
        filterForm.addEventListener('submit', function(e) {
            // Submit form normally - no need to prevent default
        });
        
        // Reset filters
        if (resetButton) {
            resetButton.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Reset all select elements
                const selects = filterForm.querySelectorAll('select');
                selects.forEach(select => {
                    select.selectedIndex = 0;
                });
                
                // Submit the form with reset values
                filterForm.submit();
            });
        }
    }
    
    // Featured campaign - Improve image loading
    const featuredImage = document.querySelector('.featured-image img');
    if (featuredImage) {
        // Add loading="lazy" attribute for better performance
        featuredImage.setAttribute('loading', 'lazy');
    }
    
    // Add smooth scrolling effect when clicking on pagination links
    const paginationLinks = document.querySelectorAll('.pagination-container a.page-numbers');
    paginationLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const href = this.getAttribute('href');
            
            // Scroll to the top of the campaigns section with smooth behavior
            const campaignsSection = document.querySelector('.campaigns-page-content');
            if (campaignsSection) {
                campaignsSection.scrollIntoView({
                    behavior: 'smooth'
                });
                
                // Wait for scroll animation to finish, then navigate
                setTimeout(() => {
                    window.location.href = href;
                }, 500);
            } else {
                // If section not found, navigate directly
                window.location.href = href;
            }
        });
    });
    
    // Add animation effects to campaign cards
    const campaignCards = document.querySelectorAll('.portfolio-campaign-item');
    if (campaignCards.length) {
        // Check if IntersectionObserver is available
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('opacity-100', 'translate-y-0');
                        entry.target.classList.remove('opacity-0', 'translate-y-4');
                        // Once the animation has run, no need to observe this element
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                root: null,
                threshold: 0.1, // Trigger when at least 10% of the item is visible
                rootMargin: '0px 0px -50px 0px' // Adjust when the effect triggers
            });
            
            // Add initial styling and observe each card
            campaignCards.forEach((card, index) => {
                // Add delay based on index for staggered animation
                card.style.transitionDelay = `${index * 75}ms`;
                card.classList.add('transition-all', 'duration-500', 'ease-out', 'opacity-0', 'translate-y-4');
                observer.observe(card);
            });
        } else {
            // Fallback for browsers that don't support IntersectionObserver
            campaignCards.forEach(card => {
                card.classList.add('opacity-100', 'translate-y-0');
            });
        }
    }
});
