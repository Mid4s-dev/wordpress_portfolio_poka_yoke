<?php
/**
 * Title: Portfolio Services Section
 * Slug: portfolio/services
 * Categories: portfolio-sections
 * Description: A section displaying services offered with icons and descriptions.
 *
 * @package Portfolio
 */
?>

<!-- wp:group {"className":"services-section section","align":"full","layout":{"type":"constrained"}} -->
<div id="services" class="wp-block-group alignfull services-section section">
  <!-- wp:group {"align":"wide","className":"container"} -->
  <div class="wp-block-group alignwide container">
    <!-- wp:group {"className":"text-center mb-16"} -->
    <div class="wp-block-group text-center mb-16">
      <!-- wp:paragraph {"className":"mb-2 text-primary-600 font-semibold"} -->
      <p class="mb-2 text-primary-600 font-semibold">My Services</p>
      <!-- /wp:paragraph -->
      
      <!-- wp:heading -->
      <h2 class="wp-block-heading">What I Can Do For You</h2>
      <!-- /wp:heading -->
      
      <!-- wp:paragraph -->
      <p>I offer a wide range of services to meet your project needs</p>
      <!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->

    <!-- wp:columns -->
    <div class="wp-block-columns">
      <!-- wp:column -->
      <div class="wp-block-column">
        <!-- wp:group {"className":"service-card"} -->
        <div class="wp-block-group service-card">
          <!-- wp:html -->
          <div class="service-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg>
          </div>
          <!-- /wp:html -->
          
          <!-- wp:heading {"level":3,"className":"service-title"} -->
          <h3 class="wp-block-heading service-title">Web Development</h3>
          <!-- /wp:heading -->
          
          <!-- wp:paragraph {"className":"service-description"} -->
          <p class="service-description">I create responsive websites that work across all devices, providing an optimal user experience with fast loading times and smooth interactions.</p>
          <!-- /wp:paragraph -->
        </div>
        <!-- /wp:group -->
      </div>
      <!-- /wp:column -->

      <!-- wp:column -->
      <div class="wp-block-column">
        <!-- wp:group {"className":"service-card"} -->
        <div class="wp-block-group service-card">
          <!-- wp:html -->
          <div class="service-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect><line x1="12" y1="18" x2="12.01" y2="18"></line></svg>
          </div>
          <!-- /wp:html -->
          
          <!-- wp:heading {"level":3,"className":"service-title"} -->
          <h3 class="wp-block-heading service-title">Mobile App Development</h3>
          <!-- /wp:heading -->
          
          <!-- wp:paragraph {"className":"service-description"} -->
          <p class="service-description">I specialize in creating responsive and intuitive mobile apps that work seamlessly across iOS & Android devices. From concept to deployment, I handle every stage of the development process.</p>
          <!-- /wp:paragraph -->
        </div>
        <!-- /wp:group -->
      </div>
      <!-- /wp:column -->

      <!-- wp:column -->
      <div class="wp-block-column">
        <!-- wp:group {"className":"service-card"} -->
        <div class="wp-block-group service-card">
          <!-- wp:html -->
          <div class="service-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
          </div>
          <!-- /wp:html -->
          
          <!-- wp:heading {"level":3,"className":"service-title"} -->
          <h3 class="wp-block-heading service-title">Consulting & Training</h3>
          <!-- /wp:heading -->
          
          <!-- wp:paragraph {"className":"service-description"} -->
          <p class="service-description">I provide expert consulting services and training to help your team level up their skills. Whether you need technical advice or workshops, I'm here to guide you.</p>
          <!-- /wp:paragraph -->
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
