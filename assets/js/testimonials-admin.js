/**
 * Testimonials admin functionality for WordPress
 */
jQuery(document).ready(function($) {
    // Handle the create sample testimonials button click
    $('#create-sample-testimonials').on('click', function(e) {
        e.preventDefault();
        
        const $button = $(this);
        const originalText = $button.text();
        
        // Disable button and show loading state
        $button.prop('disabled', true).text('Creating...');
        
        // Send AJAX request
        $.ajax({
            url: portfolio_testimonials.ajax_url,
            type: 'POST',
            data: {
                action: 'create_sample_testimonials',
                nonce: portfolio_testimonials.nonce
            },
            success: function(response) {
                if (response.success) {
                    // Show success message
                    $('#testimonial-message')
                        .removeClass('error')
                        .addClass('success')
                        .html('<p>' + response.data + '</p>')
                        .show();
                    
                    // Reload page after a short delay to show the new testimonials
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                } else {
                    // Show error message
                    $('#testimonial-message')
                        .removeClass('success')
                        .addClass('error')
                        .html('<p>Error: ' + response.data + '</p>')
                        .show();
                    
                    // Restore button
                    $button.prop('disabled', false).text(originalText);
                }
            },
            error: function() {
                // Show general error message
                $('#testimonial-message')
                    .removeClass('success')
                    .addClass('error')
                    .html('<p>Error: Something went wrong. Please try again.</p>')
                    .show();
                
                // Restore button
                $button.prop('disabled', false).text(originalText);
            }
        });
    });
});
