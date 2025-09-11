/**
 * Mobile Menu Debug Tool
 * This file helps debug mobile menu issues
 */

document.addEventListener('DOMContentLoaded', function() {
    // Create a debug panel for monitoring the mobile menu state
    function createDebugPanel() {
        const panel = document.createElement('div');
        panel.className = 'fixed bottom-0 left-0 bg-black/80 text-white p-2 text-xs z-[9999] max-w-xs overflow-auto';
        panel.id = 'debug-panel';
        
        // Toggle button to hide/show details
        const toggleBtn = document.createElement('button');
        toggleBtn.innerText = 'Toggle Debug';
        toggleBtn.className = 'bg-yellow-600 text-black px-2 py-1 rounded text-xs mb-2';
        
        const content = document.createElement('div');
        content.id = 'debug-content';
        content.className = 'hidden';
        
        toggleBtn.addEventListener('click', () => {
            content.classList.toggle('hidden');
        });
        
        panel.appendChild(toggleBtn);
        panel.appendChild(content);
        document.body.appendChild(panel);
        
        return {
            panel,
            content
        };
    }
    
    // Check if we're in development mode
    const isDevMode = window.location.hostname === 'localhost' || 
                     window.location.hostname === '127.0.0.1' || 
                     window.location.hostname.includes('local');
    
    if (isDevMode) {
        const debug = createDebugPanel();
        
        // Monitor the mobile menu state
        const mobileMenu = document.getElementById('mobile-menu');
        const mobileMenuContent = document.querySelector('.mobile-menu-content');
        
        function updateDebugInfo() {
            if (!mobileMenu || !mobileMenuContent) {
                debug.content.innerHTML = '<div class="text-red-400">Mobile menu elements not found!</div>';
                return;
            }
            
            const menuStyle = window.getComputedStyle(mobileMenu);
            const contentStyle = window.getComputedStyle(mobileMenuContent);
            
            debug.content.innerHTML = `
                <div class="grid grid-cols-2 gap-1 mb-2">
                    <span class="font-bold">Menu Classes:</span>
                    <span>${mobileMenu.className}</span>
                    
                    <span class="font-bold">Menu Visibility:</span>
                    <span>${menuStyle.visibility}</span>
                    
                    <span class="font-bold">Menu Opacity:</span>
                    <span>${menuStyle.opacity}</span>
                    
                    <span class="font-bold">Menu Display:</span>
                    <span>${menuStyle.display}</span>
                    
                    <span class="font-bold">Content Transform:</span>
                    <span class="overflow-hidden text-ellipsis">${contentStyle.transform}</span>
                    
                    <span class="font-bold">Content Position:</span>
                    <span>${contentStyle.position}</span>
                    
                    <span class="font-bold">Z-Index Values:</span>
                    <span>Menu: ${menuStyle.zIndex}, Content: ${contentStyle.zIndex}</span>
                </div>
                <button id="fix-menu-btn" class="bg-green-600 text-white px-2 py-1 rounded text-xs">Emergency Fix Menu</button>
            `;
            
            // Add emergency fix button
            document.getElementById('fix-menu-btn').addEventListener('click', () => {
                mobileMenu.style.visibility = 'visible';
                mobileMenu.style.opacity = '1';
                mobileMenu.classList.remove('hidden');
                mobileMenu.classList.add('active');
                mobileMenuContent.style.transform = 'translateX(0)';
                debug.content.innerHTML += '<div class="text-green-400 mt-2">Emergency fix applied!</div>';
            });
        }
        
        // Update the debug panel info periodically
        setInterval(updateDebugInfo, 500);
        
        // Also monitor clicks on the toggle button
        const mobileToggle = document.querySelector('.mobile-menu-toggle');
        if (mobileToggle) {
            mobileToggle.addEventListener('click', () => {
                debug.content.innerHTML += `<div class="text-blue-400">[${new Date().toLocaleTimeString()}] Menu toggle clicked</div>`;
                setTimeout(updateDebugInfo, 100);
            });
        }
    }
});
