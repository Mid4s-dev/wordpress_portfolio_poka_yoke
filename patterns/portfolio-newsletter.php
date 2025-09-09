<?php
/**
 * Title: Portfolio Newsletter Section
 * Slug: portfolio/newsletter
 * Categories: portfolio-sections
 * Description: A newsletter subscription form section.
 *
 * @package Portfolio
 */
?>

<!-- wp:group {"className":"section","align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"backgroundColor":"gray-light","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull section has-gray-light-background-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
  <!-- wp:group {"align":"wide","className":"container"} -->
  <div class="wp-block-group alignwide container">
    <!-- wp:group {"className":"text-center mb-12"} -->
    <div class="wp-block-group text-center mb-12">
      <!-- wp:heading {"style":{"typography":{"fontStyle":"normal","fontWeight":"600"}}} -->
      <h2 class="wp-block-heading" style="font-style:normal;font-weight:600">Subscribe to My Newsletter</h2>
      <!-- /wp:heading -->
      
      <!-- wp:paragraph {"className":"mx-auto max-w-xl"} -->
      <p class="mx-auto max-w-xl">Get exclusive updates, insights, and tips delivered directly to your inbox. Stay in the loop with my latest projects and announcements.</p>
      <!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->

    <!-- wp:group {"className":"max-w-md mx-auto newsletter-form"} -->
    <div class="wp-block-group max-w-md mx-auto newsletter-form">
      <!-- wp:html -->
      <form class="ankara-card p-6">
        <div class="mb-4">
          <label for="newsletter-name" class="sr-only">Your Name</label>
          <input type="text" id="newsletter-name" name="name" placeholder="Your Name" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
        </div>
        <div class="mb-4">
          <label for="newsletter-email" class="sr-only">Your Email</label>
          <input type="email" id="newsletter-email" name="email" placeholder="Your Email Address" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
        </div>
        <div class="text-center">
          <button type="submit" class="button-link py-3 px-6 w-full">Subscribe Now</button>
        </div>
        <div class="form-response mt-4"></div>
      </form>
      <!-- /wp:html -->
    </div>
    <!-- /wp:group -->
  </div>
  <!-- /wp:group -->
</div>
<!-- /wp:group -->
