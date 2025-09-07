/**
 * Simple Portfolio Lightbox Implementation
 * This is a lightweight alternative to FSLightbox
 */
document.addEventListener('DOMContentLoaded', function() {
    // Create lightbox elements
    const lightbox = document.createElement('div');
    lightbox.id = 'portfolio-lightbox';
    lightbox.className = 'portfolio-lightbox';
    lightbox.style.display = 'none';
    
    const lightboxContent = document.createElement('div');
    lightboxContent.className = 'portfolio-lightbox-content';
    
    const closeBtn = document.createElement('button');
    closeBtn.className = 'portfolio-lightbox-close';
    closeBtn.innerHTML = '×';
    
    const prevBtn = document.createElement('button');
    prevBtn.className = 'portfolio-lightbox-nav portfolio-lightbox-prev';
    prevBtn.innerHTML = '‹';
    
    const nextBtn = document.createElement('button');
    nextBtn.className = 'portfolio-lightbox-nav portfolio-lightbox-next';
    nextBtn.innerHTML = '›';
    
    const image = document.createElement('img');
    image.className = 'portfolio-lightbox-image';
    
    const counter = document.createElement('div');
    counter.className = 'portfolio-lightbox-counter';
    
    lightboxContent.appendChild(closeBtn);
    lightboxContent.appendChild(prevBtn);
    lightboxContent.appendChild(nextBtn);
    lightboxContent.appendChild(image);
    lightboxContent.appendChild(counter);
    lightbox.appendChild(lightboxContent);
    
    document.body.appendChild(lightbox);
    
    // Variables to track state
    let currentIndex = 0;
    let galleryImages = [];
    
    // Find all gallery items with portfolio-gallery-item class
    const galleryItems = document.querySelectorAll('.portfolio-gallery-item');
    
    if (galleryItems.length > 0) {
        galleryItems.forEach((item, index) => {
            // Get image URL from href attribute
            const imageUrl = item.getAttribute('href');
            if (imageUrl) {
                galleryImages.push(imageUrl);
                
                // Add click event to open lightbox
                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    openLightbox(index);
                });
            }
        });
    }
    
    // Find all images with data-fancybox attribute
    const fancyboxItems = document.querySelectorAll('[data-fancybox]');
    if (fancyboxItems.length > 0) {
        const groupedGalleries = {};
        
        fancyboxItems.forEach((item) => {
            const galleryName = item.getAttribute('data-fancybox') || 'default';
            const imageUrl = item.getAttribute('src') || item.getAttribute('href');
            
            if (!groupedGalleries[galleryName]) {
                groupedGalleries[galleryName] = [];
            }
            
            if (imageUrl) {
                groupedGalleries[galleryName].push({
                    element: item,
                    url: imageUrl
                });
            }
        });
        
        // Set up click handlers for each gallery group
        for (let galleryName in groupedGalleries) {
            const gallery = groupedGalleries[galleryName];
            
            gallery.forEach((item, index) => {
                item.element.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Set the current gallery images
                    galleryImages = gallery.map(g => g.url);
                    
                    // Open lightbox at clicked image
                    openLightbox(index);
                });
            });
        }
    }
    
    // Function to open lightbox
    function openLightbox(index) {
        if (galleryImages.length === 0) return;
        
        currentIndex = index;
        updateLightboxImage();
        
        lightbox.style.display = 'flex';
        document.body.classList.add('lightbox-open');
        
        // Add keyboard navigation
        document.addEventListener('keydown', handleKeyDown);
    }
    
    // Function to close lightbox
    function closeLightbox() {
        lightbox.style.display = 'none';
        document.body.classList.remove('lightbox-open');
        
        // Remove keyboard navigation
        document.removeEventListener('keydown', handleKeyDown);
    }
    
    // Function to navigate to previous image
    function prevImage() {
        if (galleryImages.length <= 1) return;
        
        currentIndex = (currentIndex - 1 + galleryImages.length) % galleryImages.length;
        updateLightboxImage();
    }
    
    // Function to navigate to next image
    function nextImage() {
        if (galleryImages.length <= 1) return;
        
        currentIndex = (currentIndex + 1) % galleryImages.length;
        updateLightboxImage();
    }
    
    // Function to update the lightbox image
    function updateLightboxImage() {
        if (galleryImages.length === 0) return;
        
        image.src = galleryImages[currentIndex];
        counter.textContent = `${currentIndex + 1} / ${galleryImages.length}`;
        
        // Show/hide navigation buttons if there's only one image
        if (galleryImages.length <= 1) {
            prevBtn.style.display = 'none';
            nextBtn.style.display = 'none';
            counter.style.display = 'none';
        } else {
            prevBtn.style.display = '';
            nextBtn.style.display = '';
            counter.style.display = '';
        }
    }
    
    // Function to handle keyboard navigation
    function handleKeyDown(e) {
        switch (e.key) {
            case 'ArrowLeft':
                prevImage();
                break;
            case 'ArrowRight':
                nextImage();
                break;
            case 'Escape':
                closeLightbox();
                break;
        }
    }
    
    // Event listeners
    closeBtn.addEventListener('click', closeLightbox);
    prevBtn.addEventListener('click', prevImage);
    nextBtn.addEventListener('click', nextImage);
    
    // Close lightbox when clicking outside the image
    lightbox.addEventListener('click', function(e) {
        if (e.target === lightbox) {
            closeLightbox();
        }
    });
});
