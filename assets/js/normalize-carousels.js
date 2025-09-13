/**
 * Script to ensure all carousel items display properly
 * This script helps normalize the display of cards in carousels
 */

document.addEventListener('DOMContentLoaded', function() {
    // Function to normalize card heights in a carousel
    function normalizeCardHeights(carousel) {
        if (!carousel) return;
        
        // Get all slides in this carousel
        const slides = carousel.querySelectorAll('.swiper-slide');
        if (!slides.length) return;
        
        // Reset heights to auto first
        slides.forEach(slide => {
            const contentEl = slide.querySelector('.portfolio-campaign-content, .blog-post-content, .testimonial-content, .card-content, .entry-content');
            if (contentEl) contentEl.style.height = 'auto';
        });
        
        // Delay to ensure content is rendered
        setTimeout(() => {
            // Find max content height
            let maxContentHeight = 0;
            slides.forEach(slide => {
                const contentEl = slide.querySelector('.portfolio-campaign-content, .blog-post-content, .testimonial-content, .card-content, .entry-content');
                if (contentEl) {
                    const height = contentEl.offsetHeight;
                    maxContentHeight = Math.max(maxContentHeight, height);
                }
            });
            
            // Set all content areas to the max height
            if (maxContentHeight > 0) {
                slides.forEach(slide => {
                    const contentEl = slide.querySelector('.portfolio-campaign-content, .blog-post-content, .testimonial-content, .card-content, .entry-content');
                    if (contentEl) contentEl.style.height = `${maxContentHeight}px`;
                });
            }
        }, 300);
    }
    
    // Function to ensure all thumbnail images exist
    function ensureThumbnails() {
        // Check all carousel slides
        document.querySelectorAll('.swiper-slide').forEach(slide => {
            // Look for thumbnail container
            const thumbContainers = slide.querySelectorAll('.portfolio-campaign-thumbnail, .blog-post-thumbnail, .testimonial-thumbnail, .card-thumbnail, .post-thumbnail');
            
            thumbContainers.forEach(container => {
                // Check if container has an image
                const hasImage = container.querySelector('img');
                
                // If no image, add a placeholder
                if (!hasImage) {
                    const placeholder = document.createElement('div');
                    placeholder.className = 'image-placeholder';
                    placeholder.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>';
                    container.appendChild(placeholder);
                }
            });
            
            // If slide has no thumbnail container but has a direct img
            const directImage = slide.querySelector('img.wp-post-image, img.attachment-medium');
            if (directImage && !slide.querySelector('.portfolio-campaign-thumbnail, .blog-post-thumbnail, .testimonial-thumbnail, .card-thumbnail, .post-thumbnail')) {
                // Wrap the image in a thumbnail container
                const parent = directImage.parentNode;
                const wrapper = document.createElement('div');
                wrapper.className = 'post-thumbnail';
                parent.insertBefore(wrapper, directImage);
                wrapper.appendChild(directImage);
            }
        });
    }
    
    // Initialize for all carousels
    function initAllCarousels() {
        // Add placeholder images where needed
        ensureThumbnails();
        
        // Normalize heights for each carousel
        document.querySelectorAll('.swiper-container').forEach(carousel => {
            normalizeCardHeights(carousel);
        });
    }
    
    // Run initialization
    initAllCarousels();
    
    // Re-run on window resize
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(initAllCarousels, 300);
    });
    
    // Run again after swiper initialization
    if (typeof Swiper !== 'undefined') {
        // Hook into any existing Swiper instances
        document.querySelectorAll('.swiper-container').forEach(container => {
            if (container.swiper) {
                container.swiper.on('slideChangeTransitionEnd', function() {
                    normalizeCardHeights(container);
                });
            }
        });
    }
});
