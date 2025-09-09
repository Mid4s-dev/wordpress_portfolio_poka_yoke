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
    <!-- wp:group {"className":"text-center mb-16"} -->
    <div class="wp-block-group text-center mb-16">
      <!-- wp:paragraph {"className":"mb-2 text-primary-600 font-semibold"} -->
      <p class="mb-2 text-primary-600 font-semibold">Get in Touch</p>
      <!-- /wp:paragraph -->
      
      <!-- wp:heading -->
      <h2 class="wp-block-heading">Contact Me</h2>
      <!-- /wp:heading -->
      
      <!-- wp:paragraph -->
      <p>Feel free to reach out if you have any questions or want to work together</p>
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
        
        <!-- wp:group {"className":"mt-8"} -->
        <div class="wp-block-group mt-8">
          <!-- wp:heading {"level":4,"style":{"typography":{"fontSize":"1rem"}}} -->
          <h4 class="wp-block-heading" style="font-size:1rem">Email</h4>
          <!-- /wp:heading -->
          
          <!-- wp:paragraph -->
          <p><a href="mailto:hello@example.com">hello@example.com</a></p>
          <!-- /wp:paragraph -->
        </div>
        <!-- /wp:group -->
        
        <!-- wp:group {"className":"mt-4"} -->
        <div class="wp-block-group mt-4">
          <!-- wp:heading {"level":4,"style":{"typography":{"fontSize":"1rem"}}} -->
          <h4 class="wp-block-heading" style="font-size:1rem">Phone</h4>
          <!-- /wp:heading -->
          
          <!-- wp:paragraph -->
          <p><a href="tel:+11234567890">+1 (123) 456-7890</a></p>
          <!-- /wp:paragraph -->
        </div>
        <!-- /wp:group -->
        
        <!-- wp:group {"className":"mt-4"} -->
        <div class="wp-block-group mt-4">
          <!-- wp:heading {"level":4,"style":{"typography":{"fontSize":"1rem"}}} -->
          <h4 class="wp-block-heading" style="font-size:1rem">Location</h4>
          <!-- /wp:heading -->
          
          <!-- wp:paragraph -->
          <p>San Francisco, CA</p>
          <!-- /wp:paragraph -->
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
              <div>
                <label for="name" class="sr-only">Full Name</label>
                <input type="text" id="name" name="name" placeholder="Full Name" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
              </div>
              <div>
                <label for="email" class="sr-only">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Email Address" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
              </div>
            </div>
            <div class="mt-4">
              <label for="subject" class="sr-only">Subject</label>
              <input type="text" id="subject" name="subject" placeholder="Subject" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
            <div class="mt-4">
              <label for="message" class="sr-only">Message</label>
              <textarea id="message" name="message" placeholder="Your Message" required rows="5" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"></textarea>
            </div>
            <div class="mt-6">
              <button type="submit" class="button-link py-3 px-6">Send Message</button>
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
