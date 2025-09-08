<?php
/**
 * Title: Portfolio Projects Section
 * Slug: portfolio/projects
 * Categories: portfolio-sections
 * Description: A section displaying featured projects with images and descriptions.
 *
 * @package Portfolio
 */
?>

<!-- wp:group {"className":"section","align":"full","layout":{"type":"constrained"}} -->
<div id="projects" class="wp-block-group alignfull section">
  <!-- wp:group {"align":"wide","className":"container"} -->
  <div class="wp-block-group alignwide container">
    <!-- wp:group {"className":"text-center mb-16"} -->
    <div class="wp-block-group text-center mb-16">
      <!-- wp:paragraph {"className":"mb-2 text-primary-600 font-semibold"} -->
      <p class="mb-2 text-primary-600 font-semibold">My Work</p>
      <!-- /wp:paragraph -->
      
      <!-- wp:heading -->
      <h2 class="wp-block-heading">Featured Projects</h2>
      <!-- /wp:heading -->
      
      <!-- wp:paragraph -->
      <p>Here are some of my recent projects that showcase my skills and expertise</p>
      <!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->

    <!-- wp:columns -->
    <div class="wp-block-columns">
      <!-- wp:column -->
      <div class="wp-block-column">
        <!-- wp:group {"className":"project-card"} -->
        <div class="wp-block-group project-card">
          <!-- wp:group {"className":"project-image"} -->
          <div class="wp-block-group project-image">
            <!-- wp:image {"sizeSlug":"large"} -->
            <figure class="wp-block-image size-large"><img src="https://via.placeholder.com/600x400" alt="E-commerce Website"/></figure>
            <!-- /wp:image -->
          </div>
          <!-- /wp:group -->
          
          <!-- wp:group {"className":"project-info"} -->
          <div class="wp-block-group project-info">
            <!-- wp:paragraph {"className":"project-category"} -->
            <p class="project-category">Web Development</p>
            <!-- /wp:paragraph -->
            
            <!-- wp:heading {"level":3,"className":"project-title"} -->
            <h3 class="wp-block-heading project-title">E-commerce Platform</h3>
            <!-- /wp:heading -->
            
            <!-- wp:paragraph {"className":"project-description"} -->
            <p class="project-description">A fully responsive e-commerce platform with seamless checkout experience and inventory management system.</p>
            <!-- /wp:paragraph -->
            
            <!-- wp:buttons -->
            <div class="wp-block-buttons">
              <!-- wp:button {"className":"btn btn-primary"} -->
              <div class="wp-block-button btn btn-primary"><a class="wp-block-button__link wp-element-button" href="#">View Project</a></div>
              <!-- /wp:button -->
            </div>
            <!-- /wp:buttons -->
          </div>
          <!-- /wp:group -->
        </div>
        <!-- /wp:group -->
      </div>
      <!-- /wp:column -->

      <!-- wp:column -->
      <div class="wp-block-column">
        <!-- wp:group {"className":"project-card"} -->
        <div class="wp-block-group project-card">
          <!-- wp:group {"className":"project-image"} -->
          <div class="wp-block-group project-image">
            <!-- wp:image {"sizeSlug":"large"} -->
            <figure class="wp-block-image size-large"><img src="https://via.placeholder.com/600x400" alt="Mobile App"/></figure>
            <!-- /wp:image -->
          </div>
          <!-- /wp:group -->
          
          <!-- wp:group {"className":"project-info"} -->
          <div class="wp-block-group project-info">
            <!-- wp:paragraph {"className":"project-category"} -->
            <p class="project-category">Mobile App</p>
            <!-- /wp:paragraph -->
            
            <!-- wp:heading {"level":3,"className":"project-title"} -->
            <h3 class="wp-block-heading project-title">Fitness Tracker App</h3>
            <!-- /wp:heading -->
            
            <!-- wp:paragraph {"className":"project-description"} -->
            <p class="project-description">A cross-platform mobile app that helps users track their workouts, set goals, and monitor their progress over time.</p>
            <!-- /wp:paragraph -->
            
            <!-- wp:buttons -->
            <div class="wp-block-buttons">
              <!-- wp:button {"className":"btn btn-primary"} -->
              <div class="wp-block-button btn btn-primary"><a class="wp-block-button__link wp-element-button" href="#">View Project</a></div>
              <!-- /wp:button -->
            </div>
            <!-- /wp:buttons -->
          </div>
          <!-- /wp:group -->
        </div>
        <!-- /wp:group -->
      </div>
      <!-- /wp:column -->

      <!-- wp:column -->
      <div class="wp-block-column">
        <!-- wp:group {"className":"project-card"} -->
        <div class="wp-block-group project-card">
          <!-- wp:group {"className":"project-image"} -->
          <div class="wp-block-group project-image">
            <!-- wp:image {"sizeSlug":"large"} -->
            <figure class="wp-block-image size-large"><img src="https://via.placeholder.com/600x400" alt="Dashboard UI"/></figure>
            <!-- /wp:image -->
          </div>
          <!-- /wp:group -->
          
          <!-- wp:group {"className":"project-info"} -->
          <div class="wp-block-group project-info">
            <!-- wp:paragraph {"className":"project-category"} -->
            <p class="project-category">UI/UX Design</p>
            <!-- /wp:paragraph -->
            
            <!-- wp:heading {"level":3,"className":"project-title"} -->
            <h3 class="wp-block-heading project-title">Analytics Dashboard</h3>
            <!-- /wp:heading -->
            
            <!-- wp:paragraph {"className":"project-description"} -->
            <p class="project-description">A clean and intuitive analytics dashboard that visualizes complex data in an accessible format for business users.</p>
            <!-- /wp:paragraph -->
            
            <!-- wp:buttons -->
            <div class="wp-block-buttons">
              <!-- wp:button {"className":"btn btn-primary"} -->
              <div class="wp-block-button btn btn-primary"><a class="wp-block-button__link wp-element-button" href="#">View Project</a></div>
              <!-- /wp:button -->
            </div>
            <!-- /wp:buttons -->
          </div>
          <!-- /wp:group -->
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
