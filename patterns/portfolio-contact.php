<?php
/**
 * Title: Portfolio Contact Section
 * Slug: portfolio/contact
 * Categories: portfolio-sections
 * Description: A contact form section with heading and description.
 *
 * @package Portfolio
 */
?>

<!-- wp:group {"className":"section","align":"full","layout":{"type":"constrained"}} -->
<div id="contact" class="wp-block-group alignfull section">
  <!-- wp:group {"align":"wide","className":"container"} -->
  <div class="wp-block-group alignwide container">
    <!-- wp:group {"className":"text-center mb-16 contact-header"} -->
    <div class="wp-block-group text-center mb-16 contact-header">
      <!-- wp:paragraph {"className":"mb-2 text-primary-600 font-semibold"} -->
      <p class="mb-2 text-primary-600 font-semibold">Get in Touch</p>
      <!-- /wp:paragraph -->
      
      <!-- wp:heading -->
      <h2 class="wp-block-heading">Let's Work Together</h2>
      <!-- /wp:heading -->
      
      <!-- wp:paragraph {"className":"contact-subtitle"} -->
      <p class="contact-subtitle">Have a project in mind or want to collaborate? I'm just a message away.</p>
      <!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->

    <!-- wp:columns {"align":"wide"} -->
    <div class="wp-block-columns alignwide">
      <!-- wp:column {"width":"40%"} -->
      <div class="wp-block-column" style="flex-basis:40%">
        <!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"1.25rem"}}} -->
        <h3 class="wp-block-heading" style="font-size:1.25rem">Contact Information</h3>
        <!-- /wp:heading -->
        
        <!-- wp:paragraph -->
        <p>I'm available for freelance projects and full-time positions. Let's connect and discuss how I can help bring your ideas to life.</p>
        <!-- /wp:paragraph -->
        
        <!-- wp:group {"className":"mt-8 contact-info-wrapper"} -->
        <div class="wp-block-group mt-8 contact-info-wrapper">
          <!-- wp:group {"className":"contact-info-item"} -->
          <div class="wp-block-group contact-info-item flex items-center mb-6">
            <div class="icon-container bg-maroon rounded-full p-2 mr-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
              </svg>
            </div>
            <div>
              <h4 class="wp-block-heading font-bold" style="font-size:1rem">Email</h4>
              <p><a href="mailto:hello@example.com" class="hover:underline">hello@example.com</a></p>
            </div>
          </div>
          <!-- /wp:group -->
          
          <!-- wp:group {"className":"contact-info-item"} -->
          <div class="wp-block-group contact-info-item flex items-center mb-6">
            <div class="icon-container bg-shuka-yellow rounded-full p-2 mr-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-maroon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
              </svg>
            </div>
            <div>
              <h4 class="wp-block-heading font-bold" style="font-size:1rem">Phone</h4>
              <p><a href="tel:+11234567890" class="hover:underline">+1 (123) 456-7890</a></p>
            </div>
          </div>
          <!-- /wp:group -->
          
          <!-- wp:group {"className":"contact-info-item"} -->
          <div class="wp-block-group contact-info-item flex items-center mb-6">
            <div class="icon-container bg-shuka-blue rounded-full p-2 mr-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
            </div>
            <div>
              <h4 class="wp-block-heading font-bold" style="font-size:1rem">Location</h4>
              <p>San Francisco, CA</p>
            </div>
          </div>
          <!-- /wp:group -->
        </div>
        <!-- /wp:group -->
      </div>
      <!-- /wp:column -->

      <!-- wp:column {"width":"60%"} -->
      <div class="wp-block-column" style="flex-basis:60%">
        <!-- wp:group {"className":"contact-form"} -->
        <div class="wp-block-group contact-form">
          <!-- wp:html -->
          <form class="contact-form">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
              <div class="form-group">
                <label for="name" class="block text-sm font-medium mb-1 text-shuka-yellow">Full Name</label>
                <input type="text" id="name" name="name" placeholder="Your name" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
              </div>
              <div class="form-group">
                <label for="email" class="block text-sm font-medium mb-1 text-shuka-yellow">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Your email" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
              </div>
            </div>
            <div class="mt-4 form-group">
              <label for="subject" class="block text-sm font-medium mb-1 text-shuka-yellow">Subject</label>
              <input type="text" id="subject" name="subject" placeholder="What's this about?" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
            <div class="mt-4 form-group">
              <label for="message" class="block text-sm font-medium mb-1 text-shuka-yellow">Message</label>
              <textarea id="message" name="message" placeholder="Tell me about your project..." required rows="5" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"></textarea>
            </div>
            <div class="mt-6">
              <button type="submit" class="button-link py-3 px-6">
                <span>Send Message</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 inline-block" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
              </button>
            </div>
            <div class="form-response mt-4"></div>
          </form>
          <!-- /wp:html -->
        </div>
        <!-- /wp:group -->
      </div>
      <!-- /wp:column -->
    </div>
    <!-- /wp:columns -->
  </div>
  <!-- /wp:group -->
</div>
<!-- /wp:group -->
