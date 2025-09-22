/**
 * Script to ensure all carousel items display properly
 * This simplified version focuses on placeholder images without height manipulation
 */

document.addEventListener('DOMContentLoaded', function() {
    // Function to add placeholder images to empty thumbnail containers
    function ensureThumbnails() {
        // Check all carousel slides
        document.querySelectorAll('.swiper-slide').forEach(slide => {
            // Look for thumbnail container
            const thumbContainers = slide.querySelectorAll('.portfolio-campaign-thumbnail, .blog-post-thumbnail, .testimonial-thumbnail, .card-thumbnail, .post-thumbnail, .service-thumbnail');
            
            thumbContainers.forEach(container => {
                // Check if container has an image
                const hasImage = container.querySelector('img');
                
                // Only add placeholder if no image exists
                if (!hasImage) {
                    const placeholder = document.createElement('div');
                    placeholder.className = 'image-placeholder';
                    placeholder.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>';
                    container.appendChild(placeholder);
                }
            });
            
            // If slide has no thumbnail container but has a direct img
            const directImage = slide.querySelector('img.wp-post-image, img.attachment-medium, img.attachment-post-thumbnail');
            if (directImage && !slide.querySelector('.portfolio-campaign-thumbnail, .blog-post-thumbnail, .testimonial-thumbnail, .card-thumbnail, .post-thumbnail')) {
                // Wrap the image in a thumbnail container
                const parent = directImage.parentNode;
                const wrapper = document.createElement('div');
                wrapper.className = 'post-thumbnail';
                parent.insertBefore(wrapper, directImage);
                wrapper.appendChild(directImage);
            }
        });
        
        // Mark carousels as initialized
        document.querySelectorAll('.swiper-container, .swiper').forEach(carousel => {
            carousel.classList.add('carousel-initialized');
        });
    }
    
    // Run initialization once when the page loads
    ensureThumbnails();
    
    // Initialize any Swiper carousels that might be created dynamically
    if (typeof Swiper !== 'undefined') {
        // Add an event listener for new Swiper instances
        document.addEventListener('swiper:created', function(event) {
            // Short timeout to ensure DOM is updated
            setTimeout(ensureThumbnails, 100);
        });
    }
});
