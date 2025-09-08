<?php
/**
 * Title: Portfolio Hero Section
 * Slug: portfolio/hero
 * Categories: portfolio-sections
 * Description: A hero section with image, heading, text and call-to-action buttons.
 *
 * @package Portfolio
 */
?>

<!-- wp:group {"className":"hero-section","align":"full","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull hero-section">
  <!-- wp:columns {"verticalAlignment":"center","align":"wide"} -->
  <div class="wp-block-columns alignwide are-vertically-aligned-center">
    <!-- wp:column {"verticalAlignment":"center","width":"55%"} -->
    <div class="wp-block-column is-vertically-aligned-center" style="flex-basis:55%">
      <!-- wp:heading {"level":1,"className":"hero-title"} -->
      <h1 class="wp-block-heading hero-title">Hi, I'm John Doe<br>Creative Developer</h1>
      <!-- /wp:heading -->

      <!-- wp:paragraph {"className":"hero-text"} -->
      <p class="hero-text">I design and code beautifully simple things, and I love what I do. With over 10 years of experience as a professional developer, I've worked on diverse projects ranging from web applications to mobile apps.</p>
      <!-- /wp:paragraph -->

      <!-- wp:buttons -->
      <div class="wp-block-buttons">
        <!-- wp:button {"className":"btn btn-primary"} -->
        <div class="wp-block-button btn btn-primary"><a class="wp-block-button__link wp-element-button" href="#contact">Get in Touch</a></div>
        <!-- /wp:button -->

        <!-- wp:button {"className":"btn is-style-outline"} -->
        <div class="wp-block-button btn is-style-outline"><a class="wp-block-button__link wp-element-button" href="#portfolio">My Work</a></div>
        <!-- /wp:button -->
      </div>
      <!-- /wp:buttons -->
    </div>
    <!-- /wp:column -->

    <!-- wp:column {"verticalAlignment":"center","width":"45%"} -->
    <div class="wp-block-column is-vertically-aligned-center" style="flex-basis:45%">
      <!-- wp:image {"sizeSlug":"large","className":"rounded-lg shadow-lg"} -->
      <figure class="wp-block-image size-large rounded-lg shadow-lg"><img src="https://via.placeholder.com/600x600" alt="Profile Image"/></figure>
      <!-- /wp:image -->
    </div>
    <!-- /wp:column -->
  </div>
  <!-- /wp:columns -->
</div>
<!-- /wp:group -->
