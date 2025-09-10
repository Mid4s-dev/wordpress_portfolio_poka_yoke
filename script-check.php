<?php
/**
 * Simple debug script to check if required files are loaded
 */

// Just check for Swiper scripts without loading WordPress
?>
<html>
<head>
    <title>Script Check</title>
</head>
<body>
    <h1>Script Loading Check</h1>
    
    <?php
    // Check if Swiper JS file is accessible
    $swiper_js_url = 'https://unpkg.com/swiper@8/swiper-bundle.min.js';
    $swiper_css_url = 'https://unpkg.com/swiper@8/swiper-bundle.min.css';
    
    $js_headers = @get_headers($swiper_js_url);
    $css_headers = @get_headers($swiper_css_url);
    
    echo '<h2>Swiper JS URL Check:</h2>';
    echo '<p>' . $swiper_js_url . '</p>';
    
    if($js_headers && strpos($js_headers[0], '200') !== false) {
        echo '<p style="color: green;">✓ Swiper JS is accessible</p>';
    } else {
        echo '<p style="color: red;">✗ Swiper JS is NOT accessible</p>';
    }
    
    echo '<h2>Swiper CSS URL Check:</h2>';
    echo '<p>' . $swiper_css_url . '</p>';
    
    if($css_headers && strpos($css_headers[0], '200') !== false) {
        echo '<p style="color: green;">✓ Swiper CSS is accessible</p>';
    } else {
        echo '<p style="color: red;">✗ Swiper CSS is NOT accessible</p>';
    }
    ?>
    
    <h2>Script Test</h2>
    <div id="test-container" style="width: 100%; max-width: 800px; margin: 0 auto;">
        <div class="swiper test-swiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide" style="background: #f0f0f0; padding: 20px;">Slide 1</div>
                <div class="swiper-slide" style="background: #e0e0e0; padding: 20px;">Slide 2</div>
                <div class="swiper-slide" style="background: #d0d0d0; padding: 20px;">Slide 3</div>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
    
    <!-- Load Swiper -->
    <link rel="stylesheet" href="<?php echo $swiper_css_url; ?>">
    <script src="<?php echo $swiper_js_url; ?>"></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        try {
            const swiper = new Swiper('.test-swiper', {
                slidesPerView: 1,
                spaceBetween: 30,
                loop: true,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
            
            document.getElementById('test-container').insertAdjacentHTML('afterend', 
                '<p style="color: green;">✓ Swiper initialized successfully</p>');
        } catch (e) {
            document.getElementById('test-container').insertAdjacentHTML('afterend', 
                '<p style="color: red;">✗ Swiper initialization failed: ' + e.message + '</p>');
        }
    });
    </script>
</body>
</html>
