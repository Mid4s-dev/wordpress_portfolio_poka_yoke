/**
 * Card Image Standardization Script
 * Ensures that all images in cards and carousels display properly
 */

document.addEventListener('DOMContentLoaded', function() {
    // Get all card images
    const cardImages = document.querySelectorAll('.service-card img, .card-thumbnail img, .portfolio-campaign-thumbnail img, .blog-post-thumbnail img, .testimonial-thumbnail img, .post-thumbnail img, .wp-post-image, .swiper-slide .attachment-medium');
    
    // Standardize each image
    cardImages.forEach(img => {
        // Apply standard sizing
        img.style.width = '100%';
        img.style.height = '200px';
        img.style.objectFit = 'cover';
        img.style.objectPosition = 'center';
        
        // Add transition for hover effects
        img.style.transition = 'transform 0.5s ease';
        
        // Add event listeners for hover effect
        img.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.05)';
        });
        
        img.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
    
    // Get all card containers
    const cardContainers = document.querySelectorAll('.service-thumbnail, .card-thumbnail, .portfolio-campaign-thumbnail, .blog-post-thumbnail, .testimonial-thumbnail, .post-thumbnail');
    
    // Standardize containers
    cardContainers.forEach(container => {
        container.style.height = '200px';
        container.style.overflow = 'hidden';
        container.style.position = 'relative';
        container.style.display = 'block';
        container.style.backgroundColor = '#f5f5f5';
        
        // If no image inside, add a placeholder
        if (!container.querySelector('img')) {
            const placeholder = document.createElement('div');
            placeholder.className = 'image-placeholder';
            placeholder.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="#999" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>';
            container.appendChild(placeholder);
        }
    });
    
    // Ensure cards have consistent heights
    const cards = document.querySelectorAll('.swiper-slide .portfolio-campaign-item, .swiper-slide .blog-post-item, .swiper-slide .testimonial-item, .swiper-slide .card, .swiper-slide .portfolio-service');
    
    cards.forEach(card => {
        card.style.display = 'flex';
        card.style.flexDirection = 'column';
        card.style.height = '100%';
        card.style.minHeight = '450px';
    });
    
    // Handle lazy-loaded images
    document.addEventListener('lazyloaded', function(e) {
        const img = e.target;
        if (img.tagName === 'IMG' && (
            img.closest('.service-card') || 
            img.closest('.card-thumbnail') || 
            img.closest('.portfolio-campaign-thumbnail') ||
            img.closest('.blog-post-thumbnail') ||
            img.closest('.testimonial-thumbnail') ||
            img.closest('.post-thumbnail')
        )) {
            // Apply standard sizing
            img.style.width = '100%';
            img.style.height = '200px';
            img.style.objectFit = 'cover';
            img.style.objectPosition = 'center';
        }
    });
});
