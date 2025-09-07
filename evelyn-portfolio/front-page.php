<?php get_header(); ?>
<div class="min-h-screen bg-gray-50">
  <!-- Hero Section -->
  <section class="hero-section relative h-screen flex items-center justify-center overflow-hidden">
    <!-- Video or image background -->
    <div class="absolute inset-0 z-0">
      <?php 
      // Check for a featured image on the homepage
      if (has_post_thumbnail()) {
        the_post_thumbnail('full', ['class' => 'w-full h-full object-cover']);
      } else {
        // Default background gradient with animated overlay
        echo '<div class="w-full h-full bg-gradient-to-r from-blue-600 to-purple-800 relative">';
        echo '<div class="absolute inset-0 opacity-20" style="background-image: url(\'data:image/svg+xml,%3Csvg width="100" height="100" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"%3E%3Cpath d="M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z" fill="%23ffffff" fill-opacity="0.1" fill-rule="evenodd"/%3E%3C/svg%3E\')"></div>';
        echo '</div>';
      }
      ?>
      <!-- Overlay gradient -->
      <div class="absolute inset-0 bg-gradient-to-b from-transparent via-black/30 to-black/70 z-10"></div>
    </div>

    <!-- Hero content -->
    <div class="container mx-auto px-6 text-center relative z-20">
      <h1 class="text-6xl md:text-7xl font-bold mb-6 text-white hero-text font-heading"><?php echo esc_html(get_bloginfo('name')); ?></h1>
      <p class="text-xl md:text-2xl mb-10 text-white max-w-3xl mx-auto">
        <?php echo esc_html(get_bloginfo('description')); ?>
        <span class="block mt-4 text-white/80">
          <?php echo esc_html(portfolio_get_description("{name}'s photography portfolio & stories")); ?>
        </span>
      </p>
      
      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="#about" class="btn-hover bg-white text-blue-800 px-8 py-4 rounded-lg font-semibold hover:bg-gray-100 transition shadow-lg">Learn About Me</a>
        <a href="#portfolio" class="btn-hover bg-blue-600 text-white px-8 py-4 rounded-lg font-semibold hover:bg-blue-700 transition shadow-lg">See My Work</a>
      </div>

      <!-- Scroll indicator -->
      <div class="absolute bottom-10 left-0 right-0 flex justify-center">
        <a href="#about" class="animate-bounce p-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
          </svg>
        </a>
      </div>
    </div>
  </section>

  <!-- About Section -->
  <section id="about" class="py-24 bg-white">
    <div class="container mx-auto px-6">
      <div class="max-w-5xl mx-auto">
        <div class="flex flex-col md:flex-row gap-12 items-center">
          <!-- About image - placeholder for portfolio owner -->
          <div class="md:w-1/2 relative">
            <div class="bg-blue-100 absolute -top-4 -left-4 w-full h-full rounded-lg"></div>
            <?php 
            $about_img = get_theme_mod('evelyn_about_image', get_template_directory_uri() . '/images/placeholder-about.jpg');
            $owner_name = portfolio_owner_name(); // Get dynamic owner name
            
            if (!empty($about_img)) {
              echo '<img src="' . esc_url($about_img) . '" alt="' . esc_attr($owner_name) . '" class="w-full h-auto rounded-lg shadow-lg relative z-10">';
            } else {
              echo '<div class="w-full aspect-[4/5] bg-gray-200 rounded-lg shadow-lg relative z-10 flex items-center justify-center">';
              echo '<p class="text-gray-500">About Image Placeholder</p>';
              echo '</div>';
            }
            ?>
          </div>
          
          <!-- About content -->
          <div class="md:w-1/2">
            <h2 class="text-4xl font-bold mb-6 font-heading relative inline-block">
              About <span class="text-blue-600"><?php echo esc_html(portfolio_owner_name()); ?></span>
              <span class="absolute -bottom-2 left-0 w-1/3 h-1 bg-blue-600"></span>
            </h2>
            
            <?php echo evelyn_owner_profile_html(); ?>
            
            <!-- Additional call to action -->
            <div class="mt-8 flex gap-4">
              <a href="#portfolio" class="btn-hover bg-blue-600 text-white px-6 py-3 rounded-md font-semibold hover:bg-blue-700 transition">View My Work</a>
              <a href="#contact" class="btn-hover border-2 border-blue-600 text-blue-600 px-6 py-3 rounded-md font-semibold hover:bg-blue-50 transition">Contact Me</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Portfolio Section -->
  <section id="portfolio" class="py-24 bg-gray-50">
    <div class="container mx-auto px-6">
      <div class="text-center max-w-3xl mx-auto mb-16">
        <span class="text-blue-600 font-medium uppercase tracking-wider">My Portfolio</span>
        <h2 class="text-4xl md:text-5xl font-bold mt-2 mb-6 font-heading">Featured Photography</h2>
        <p class="text-gray-600 leading-relaxed">Explore my collection of photographs and stories captured through my lens.</p>
      </div>
      
      <!-- Portfolio grid with animations -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php
        $portfolio_query = new WP_Query([
          'post_type' => 'portfolio',
          'posts_per_page' => 6,
          'post_status' => 'publish'
        ]);
        
        if ($portfolio_query->have_posts()):
          while ($portfolio_query->have_posts()): $portfolio_query->the_post();
        ?>
          <article class="portfolio-item bg-white rounded-xl shadow-lg overflow-hidden group">
            <div class="relative overflow-hidden">
              <?php if (has_post_thumbnail()): ?>
                <a href="<?php the_permalink(); ?>">
                  <?php the_post_thumbnail('portfolio-thumbnail', ['class' => 'w-full h-72 object-cover transition duration-700 group-hover:scale-105']); ?>
                  
                  <!-- Overlay effect on hover -->
                  <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent opacity-60 transition duration-300"></div>
                  
                  <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300">
                    <span class="bg-white/90 backdrop-blur-sm text-blue-800 px-6 py-3 rounded-full font-semibold transform translate-y-4 group-hover:translate-y-0 transition duration-300">
                      View Project
                    </span>
                  </div>
                </a>
              <?php endif; ?>
            </div>
            
            <div class="p-6">
              <h3 class="text-2xl font-semibold mb-3 font-heading">
                <a href="<?php the_permalink(); ?>" class="hover:text-blue-600 transition"><?php the_title(); ?></a>
              </h3>
              
              <div class="text-gray-600 mb-4 line-clamp-3">
                <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
              </div>
              
              <div class="flex justify-between items-center">
                <a href="<?php the_permalink(); ?>" class="text-blue-600 font-semibold flex items-center group/link">
                  <span>Read more</span>
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1 transform transition-transform group-hover/link:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                  </svg>
                </a>
                
                <span class="text-gray-500 text-sm">
                  <?php echo get_the_date(); ?>
                </span>
              </div>
            </div>
          </article>
        <?php
          endwhile;
          wp_reset_postdata();
        else:
        ?>
          <div class="col-span-full py-16 text-center">
            <div class="bg-white rounded-lg shadow-md p-8 max-w-lg mx-auto">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
              <p class="text-gray-500 mb-4">No portfolio items yet. Start adding your beautiful work from the admin dashboard!</p>
              <?php if (current_user_can('edit_posts')): ?>
              <a href="<?php echo admin_url('post-new.php?post_type=portfolio'); ?>" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">Add Portfolio Item</a>
              <?php endif; ?>
            </div>
          </div>
        <?php endif; ?>
      </div>
      
      <div class="text-center mt-12">
        <a href="<?php echo get_post_type_archive_link('portfolio'); ?>" class="btn-hover bg-blue-600 text-white px-8 py-4 rounded-lg font-semibold hover:bg-blue-700 transition shadow-lg flex items-center gap-2 mx-auto w-fit">
          <span>View All Portfolio</span>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
          </svg>
        </a>
      </div>
    </div>
  </section>

  <!-- Blog Section -->
  <section id="blog" class="py-24 bg-white">
    <div class="container mx-auto px-6">
      <div class="text-center max-w-3xl mx-auto mb-16">
        <span class="text-green-600 font-medium uppercase tracking-wider">My Blog</span>
        <h2 class="text-4xl md:text-5xl font-bold mt-2 mb-6 font-heading">Latest Stories</h2>
        <p class="text-gray-600 leading-relaxed">Discover my thoughts, experiences, and behind-the-scenes insights.</p>
      </div>
      
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php
        $blog_query = new WP_Query([
          'post_type' => 'post',
          'posts_per_page' => 3,
          'post_status' => 'publish'
        ]);
        if ($blog_query->have_posts()):
          while ($blog_query->have_posts()): $blog_query->the_post();
        ?>
          <article class="blog-post bg-white rounded-xl shadow-md overflow-hidden group">
            <!-- Featured image with hover effect -->
            <?php if (has_post_thumbnail()): ?>
            <div class="relative overflow-hidden h-60">
              <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('blog-featured', ['class' => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-110']); ?>
                
                <!-- Overlay with blog details -->
                <div class="blog-post-overlay absolute inset-0 bg-gradient-to-t from-black/80 via-black/50 to-transparent opacity-0 transition-opacity duration-300 flex flex-col justify-end p-6">
                  <!-- Blog metadata -->
                  <div class="flex items-center text-white/80 text-sm mb-2">
                    <span class="mr-4 flex items-center">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                      </svg>
                      <?php echo get_the_date(); ?>
                    </span>
                    
                    <?php
                    $categories = get_the_category();
                    if (!empty($categories)) {
                      echo '<span class="flex items-center">';
                      echo '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">';
                      echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />';
                      echo '</svg>';
                      echo esc_html($categories[0]->name);
                      echo '</span>';
                    }
                    ?>
                  </div>
                </div>
              </a>
            </div>
            <?php endif; ?>
            
            <!-- Blog content -->
            <div class="p-6">
              <h3 class="text-2xl font-semibold mb-3 font-heading line-clamp-2">
                <a href="<?php the_permalink(); ?>" class="hover:text-green-600 transition"><?php the_title(); ?></a>
              </h3>
              
              <div class="text-gray-600 mb-5 line-clamp-3">
                <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
              </div>
              
              <a href="<?php the_permalink(); ?>" class="inline-flex items-center text-green-600 font-semibold hover:text-green-700 transition">
                <span>Continue Reading</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
              </a>
            </div>
          </article>
        <?php
          endwhile;
          wp_reset_postdata();
        else:
        ?>
          <div class="col-span-full py-16 text-center">
            <div class="bg-white rounded-lg shadow-md p-8 max-w-lg mx-auto">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
              </svg>
              <p class="text-gray-500 mb-4">No blog posts yet. Start sharing your stories and experiences!</p>
              <?php if (current_user_can('edit_posts')): ?>
              <a href="<?php echo admin_url('post-new.php'); ?>" class="inline-block bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700 transition">Create First Post</a>
              <?php endif; ?>
            </div>
          </div>
        <?php endif; ?>
      </div>
      
      <div class="text-center mt-12">
        <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>" class="btn-hover bg-green-600 text-white px-8 py-4 rounded-lg font-semibold hover:bg-green-700 transition shadow-lg flex items-center gap-2 mx-auto w-fit">
          <span>Read All Blog Posts</span>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
          </svg>
        </a>
      </div>
    </div>
  </section>

  <!-- Hidden Photography Section (Password Protected) -->
  <section id="hidden-work" class="py-24 bg-gray-900 text-white">
    <div class="container mx-auto px-6">
      <div class="text-center max-w-3xl mx-auto mb-16">
        <span class="text-purple-400 font-medium uppercase tracking-wider">Private Collection</span>
        <h2 class="text-4xl md:text-5xl font-bold mt-2 mb-6 font-heading">Hidden Photography</h2>
        <p class="text-gray-300 leading-relaxed">Exclusive works available only to selected viewers.</p>
      </div>
      
      <?php
      $private_query = new WP_Query([
        'post_type' => 'portfolio',
        'posts_per_page' => 1,
        'post_status' => 'private',
        'orderby' => 'rand'
      ]);
      
      if ($private_query->have_posts()): $private_query->the_post();
      ?>
        <div class="max-w-3xl mx-auto bg-gray-800/80 rounded-xl p-8 backdrop-blur">
          <div class="text-center">
            <h3 class="text-2xl font-semibold mb-6 font-heading"><?php the_title(); ?></h3>
            <p class="text-gray-300 mb-8">This exclusive work is password protected. Enter the password to view.</p>
            
            <!-- Mock password form - will use core WordPress protected content -->
            <div class="max-w-md mx-auto">
              <a href="<?php the_permalink(); ?>" class="btn-hover bg-purple-600 text-white px-8 py-4 rounded-lg font-semibold hover:bg-purple-700 transition shadow-lg inline-block">
                Access Private Collection
              </a>
            </div>
          </div>
        </div>
      <?php else: ?>
        <div class="max-w-3xl mx-auto bg-gray-800/80 rounded-xl p-8 backdrop-blur text-center">
          <p class="text-gray-300 mb-4">No private collections available yet.</p>
          <?php if (current_user_can('edit_posts')): ?>
          <p class="text-gray-400 text-sm mb-4">As an admin, you can create private portfolio items that will only be visible to viewers with the password.</p>
          <a href="<?php echo admin_url('post-new.php?post_type=portfolio'); ?>" class="inline-block bg-purple-600 text-white px-6 py-2 rounded-md hover:bg-purple-700 transition">Create Private Work</a>
          <?php endif; ?>
        </div>
      <?php 
      endif;
      wp_reset_postdata();
      ?>
    </div>
  </section>

  <!-- Newsletter Section -->
  <section id="newsletter" class="py-24 bg-gray-50">
    <div class="container mx-auto px-6">
      <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-xl p-12 relative">
        <!-- Decorative elements -->
        <div class="absolute -top-6 -left-6 w-12 h-12 bg-blue-600 rounded-full opacity-20"></div>
        <div class="absolute -bottom-6 -right-6 w-12 h-12 bg-green-600 rounded-full opacity-20"></div>
        
        <div class="text-center mb-10">
          <span class="text-blue-600 font-medium uppercase tracking-wider">Stay Connected</span>
          <h2 class="text-3xl md:text-4xl font-bold mt-2 mb-4 font-heading">Join My Newsletter</h2>
          <p class="text-gray-600 leading-relaxed">Subscribe to receive updates, behind-the-scenes content, and exclusive offers.</p>
        </div>
        
        <div class="newsletter-form">
          <?php 
          $newsletter_shortcode = do_shortcode('[newsletter_signup]');
          
          // Add Tailwind classes to form elements
          $newsletter_shortcode = str_replace(
            ['<input type="text"', '<input type="email"', '<button type="submit"'], 
            ['<input type="text" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition mb-4"', 
             '<input type="email" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition mb-4"', 
             '<button type="submit" class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-700 transition shadow"'],
            $newsletter_shortcode
          );
          
          echo $newsletter_shortcode;
          ?>
        </div>
        
        <p class="text-gray-500 text-sm text-center mt-6">
          Your privacy is respected. Unsubscribe at any time.
        </p>
      </div>
    </div>
  </section>
  
  <!-- Contact Section -->
  <section id="contact" class="py-24 bg-white">
    <div class="container mx-auto px-6">
      <div class="max-w-5xl mx-auto">
        <div class="text-center mb-16">
          <span class="text-blue-600 font-medium uppercase tracking-wider">Get In Touch</span>
          <h2 class="text-4xl md:text-5xl font-bold mt-2 mb-6 font-heading">Contact Me</h2>
          <p class="text-gray-600 leading-relaxed max-w-3xl mx-auto">
            Have questions about my photography or interested in collaborating? Feel free to reach out!
          </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
          <div>
            <div class="bg-gray-50 p-8 rounded-xl">
              <h3 class="text-2xl font-semibold mb-6 font-heading">Contact Information</h3>
              
              <?php
              $owner = get_owner_profile();
              if (!empty($owner['social']) && is_array($owner['social'])) {
                echo '<div class="space-y-4">';
                foreach ($owner['social'] as $platform => $url) {
                  if (!empty($url)) {
                    echo '<div class="flex items-center">';
                    echo '<div class="bg-blue-100 p-3 rounded-full mr-4">';
                    
                    // Platform icons
                    switch ($platform) {
                      case 'twitter':
                        echo '<svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>';
                        break;
                      case 'instagram':
                        echo '<svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>';
                        break;
                      case 'linkedin':
                        echo '<svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z"/></svg>';
                        break;
                      default:
                        echo '<svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12.713l-11.985-9.713h23.97l-11.985 9.713zm0 2.574l-12-9.725v15.438h24v-15.438l-12 9.725z"/></svg>';
                    }
                    
                    echo '</div>';
                    echo '<div>';
                    echo '<h4 class="font-semibold text-gray-800">' . ucfirst($platform) . '</h4>';
                    echo '<a href="' . esc_url($url) . '" class="text-blue-600 text-sm hover:underline" target="_blank" rel="noopener">' . esc_html($url) . '</a>';
                    echo '</div>';
                    echo '</div>';
                  }
                }
                echo '</div>';
              } else {
                echo '<p class="text-gray-500">Contact details will appear here once set in the Owner Profile.</p>';
              }
              ?>
              
              <!-- Add contact form shortcode if needed -->
              <?php if (shortcode_exists('contact_form')): ?>
                <div class="mt-6">
                  <?php echo do_shortcode('[contact_form]'); ?>
                </div>
              <?php endif; ?>
            </div>
          </div>
          
          <div>
            <div class="relative">
              <div class="bg-blue-100 absolute -top-4 -right-4 w-full h-full rounded-lg"></div>
              <img src="<?php echo get_template_directory_uri(); ?>/images/contact-image.jpg" alt="Contact" class="w-full h-auto rounded-lg shadow-lg relative z-10">
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<?php get_footer(); ?>
