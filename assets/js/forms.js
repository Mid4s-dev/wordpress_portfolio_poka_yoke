/**
 * Form handling scripts
 */
jQuery(document).ready(function($) {
    'use strict';
    
    // Contact form submission 
    $('.contact-form form').on('submit', function(e) {
        e.preventDefault();
        
        const $form = $(this);
        const $submit = $form.find('button[type="submit"]');
        const $response = $form.find('.form-response');
        
        // If response container doesn't exist, create it
        if (!$response.length) {
            $form.append('<div class="form-response mt-4"></div>');
        }
        
        const formData = {
            action: 'portfolio_contact_form',
            nonce: portfolioForms.nonce,
            name: $form.find('input[name="name"]').val(),
            email: $form.find('input[name="email"]').val(),
            subject: $form.find('input[name="subject"]').val(),
            message: $form.find('textarea[name="message"]').val()
        };
        
        // Disable submit button
        $submit.prop('disabled', true).addClass('opacity-70');
        
        // Show loading message
        $form.find('.form-response').html('<div class="text-gray-600">Sending your message...</div>');
        
        $.ajax({
            url: portfolioForms.ajaxUrl,
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    $form.find('.form-response').html('<div class="text-green-600 font-medium">' + portfolioForms.contactSuccess + '</div>');
                    $form.trigger('reset');
                } else {
                    $form.find('.form-response').html('<div class="text-red-600 font-medium">' + response.data + '</div>');
                }
            },
            error: function() {
                $form.find('.form-response').html('<div class="text-red-600 font-medium">' + portfolioForms.error + '</div>');
            },
            complete: function() {
                // Re-enable submit button
                $submit.prop('disabled', false).removeClass('opacity-70');
            }
        });
    });
    
    // Newsletter form submission
    $('.newsletter-form form').on('submit', function(e) {
        e.preventDefault();
        
        const $form = $(this);
        const $submit = $form.find('button[type="submit"]');
        const $response = $form.find('.form-response');
        
        // If response container doesn't exist, create it
        if (!$response.length) {
            $form.append('<div class="form-response mt-4"></div>');
        }
        
        const formData = {
            action: 'portfolio_newsletter_form',
            nonce: portfolioForms.nonce,
            name: $form.find('input[name="name"]').val(),
            email: $form.find('input[name="email"]').val()
        };
        
        // Disable submit button
        $submit.prop('disabled', true).addClass('opacity-70');
        
        // Show loading message
        $form.find('.form-response').html('<div class="text-gray-600">Processing your subscription...</div>');
        
        $.ajax({
            url: portfolioForms.ajaxUrl,
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    $form.find('.form-response').html('<div class="text-green-600 font-medium">' + portfolioForms.newsletterSuccess + '</div>');
                    $form.trigger('reset');
                } else {
                    $form.find('.form-response').html('<div class="text-red-600 font-medium">' + response.data + '</div>');
                }
            },
            error: function() {
                $form.find('.form-response').html('<div class="text-red-600 font-medium">' + portfolioForms.error + '</div>');
            },
            complete: function() {
                // Re-enable submit button
                $submit.prop('disabled', false).removeClass('opacity-70');
            }
        });
    });

    // Backup form handling using direct event delegation
    $(document).on('submit', '.contact-form form', function(e) {
        e.preventDefault();
        
        const $form = $(this);
        const formData = {
            action: 'portfolio_contact_form',
            nonce: portfolioForms.nonce,
            name: $form.find('input[name="name"]').val(),
            email: $form.find('input[name="email"]').val(),
            subject: $form.find('input[name="subject"]').val(),
            message: $form.find('textarea[name="message"]').val()
        };
        
        // Show loading message
        let $response = $form.find('.form-response');
        if (!$response.length) {
            $form.append('<div class="form-response mt-4"></div>');
            $response = $form.find('.form-response');
        }
        
        $response.html('<div class="text-gray-600">Sending your message...</div>');
        
        // Disable submit button
        const $submit = $form.find('button[type="submit"]');
        $submit.prop('disabled', true).addClass('opacity-70');
        
        $.ajax({
            url: portfolioForms.ajaxUrl,
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    $response.html('<div class="text-green-600 font-medium">' + portfolioForms.contactSuccess + '</div>');
                    $form.trigger('reset');
                } else {
                    $response.html('<div class="text-red-600 font-medium">' + response.data + '</div>');
                }
            },
            error: function(xhr, status, error) {
                $response.html('<div class="text-red-600 font-medium">' + portfolioForms.error + '</div>');
            },
            complete: function() {
                // Re-enable submit button
                $submit.prop('disabled', false).removeClass('opacity-70');
            }
        });
    });

    $(document).on('submit', '.newsletter-form form', function(e) {
        e.preventDefault();
        
        const $form = $(this);
        const formData = {
            action: 'portfolio_newsletter_form',
            nonce: portfolioForms.nonce,
            name: $form.find('input[name="name"]').val(),
            email: $form.find('input[name="email"]').val()
        };
        
        // Show loading message
        let $response = $form.find('.form-response');
        if (!$response.length) {
            $form.append('<div class="form-response mt-4"></div>');
            $response = $form.find('.form-response');
        }
        
        $response.html('<div class="text-gray-600">Processing your subscription...</div>');
        
        // Disable submit button
        const $submit = $form.find('button[type="submit"]');
        $submit.prop('disabled', true).addClass('opacity-70');
        
        $.ajax({
            url: portfolioForms.ajaxUrl,
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    $response.html('<div class="text-green-600 font-medium">' + portfolioForms.newsletterSuccess + '</div>');
                    $form.trigger('reset');
                } else {
                    $response.html('<div class="text-red-600 font-medium">' + response.data + '</div>');
                }
            },
            error: function(xhr, status, error) {
                $response.html('<div class="text-red-600 font-medium">' + portfolioForms.error + '</div>');
            },
            complete: function() {
                // Re-enable submit button
                $submit.prop('disabled', false).removeClass('opacity-70');
            }
        });
    });
});
