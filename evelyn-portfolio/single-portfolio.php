<?php get_header(); ?>

<article class="pb-24">
  <?php if (have_posts()): while (have_posts()): the_post(); ?>
    <!-- Hero section with full-width image -->
    <div class="relative h-[70vh] overflow-hidden">
      <?php if (has_post_thumbnail()): ?>
        <?php echo get_the_post_thumbnail(null, 'full', ['class' => 'w-full h-full object-cover']); ?>
      <?php else: ?>
        <div class="w-full h-full bg-gradient-to-r from-blue-600 to-purple-800"></div>
      <?php endif; ?>
      
      <!-- Overlay gradient -->
      <div class="absolute inset-0 bg-gradient-to-b from-black/30 via-transparent to-black/70"></div>
      
      <!-- Title and metadata -->
      <div class="absolute bottom-0 left-0 right-0 p-8 md:p-16">
        <div class="container mx-auto">
          <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 font-heading"><?php the_title(); ?></h1>
          
          <div class="flex flex-wrap items-center text-white/80 text-sm">
            <span class="mr-6 flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
              <?php echo get_the_date(); ?>
            </span>
            
            <?php if (function_exists('portfolio_render_social_links')): ?>
            <div class="flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
              </svg>
              <?php echo portfolio_render_social_links(get_the_ID()); ?>
            </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Main content -->
    <div class="container mx-auto px-6 py-12">
      <div class="max-w-4xl mx-auto">
        <!-- Content with typography styles -->
        <div class="prose prose-lg max-w-none mb-12">
          <?php the_content(); ?>
        </div>
        
        <!-- Portfolio gallery -->
        <?php
        // Extract images from content
        $content = get_the_content();
        $pattern = '/<img[^>]+>/i';
        preg_match_all($pattern, $content, $matches);
        
        $images = $matches[0];
        
        // If we have multiple images, display them in a gallery
        if (count($images) > 1): 
        ?>
        <div class="mt-16">
          <h2 class="text-3xl font-bold mb-8 font-heading">Gallery</h2>
          <div class="portfolio-gallery">
            <?php 
            foreach ($images as $image) {
              // Extract src from image tag
              preg_match('/src=["\'](.*?)["\']/', $image, $src);
              if (!empty($src[1])) {
                echo '<a href="' . esc_url($src[1]) . '" class="portfolio-gallery-item">';
                echo $image;
                echo '</a>';
              } else {
                echo $image;
              }
            }
            ?>
          </div>
        </div>
        <?php endif; ?>
        
        <!-- Password protected content notice -->
        <?php if (post_password_required()): ?>
        <div class="mt-12 bg-purple-50 p-8 rounded-lg border border-purple-200">
          <div class="flex items-start">
            <div class="bg-purple-100 p-3 rounded-full mr-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
              </svg>
            </div>
            <div>
              <h3 class="text-xl font-bold mb-2 text-purple-800">Private Content</h3>
              <p class="text-purple-700">This content is password protected. Enter the password to view.</p>
            </div>
          </div>
        </div>
        <?php endif; ?>
        
        <!-- Social sharing -->
        <div class="mt-12 pt-8 border-t border-gray-200">
          <h3 class="text-lg font-semibold mb-4">Share this project</h3>
          <div class="flex gap-3">
            <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" target="_blank" rel="noopener" class="bg-gray-100 hover:bg-gray-200 p-3 rounded-full transition">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
            </a>
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" rel="noopener" class="bg-gray-100 hover:bg-gray-200 p-3 rounded-full transition">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385h-3.047v-3.47h3.047v-2.642c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953h-1.514c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385c5.736-.9 10.125-5.864 10.125-11.854z"/></svg>
            </a>
            <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(get_permalink()); ?>&title=<?php echo urlencode(get_the_title()); ?>" target="_blank" rel="noopener" class="bg-gray-100 hover:bg-gray-200 p-3 rounded-full transition">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
            </a>
            <a href="mailto:?subject=<?php echo urlencode(get_the_title()); ?>&body=<?php echo urlencode(get_permalink()); ?>" class="bg-gray-100 hover:bg-gray-200 p-3 rounded-full transition">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
              </svg>
            </a>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Related projects -->
    <?php
    $related_args = array(
      'post_type' => 'portfolio',
      'posts_per_page' => 3,
      'post_status' => 'publish',
      'post__not_in' => array(get_the_ID()),
      'orderby' => 'rand'
    );
    $related_query = new WP_Query($related_args);
    
    if ($related_query->have_posts()):
    ?>
    <div class="bg-gray-50 py-16">
      <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold mb-12 font-heading text-center">More Projects</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <?php while($related_query->have_posts()): $related_query->the_post(); ?>
            <article class="portfolio-item bg-white rounded-xl shadow-lg overflow-hidden group">
              <div class="relative overflow-hidden">
                <?php if (has_post_thumbnail()): ?>
                  <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail('portfolio-thumbnail', ['class' => 'w-full h-56 object-cover transition duration-700 group-hover:scale-105']); ?>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent opacity-60 transition duration-300"></div>
                  </a>
                <?php endif; ?>
              </div>
              <div class="p-6">
                <h3 class="text-xl font-semibold">
                  <a href="<?php the_permalink(); ?>" class="hover:text-blue-600 transition"><?php the_title(); ?></a>
                </h3>
              </div>
            </article>
          <?php endwhile; wp_reset_postdata(); ?>
        </div>
      </div>
    </div>
    <?php endif; ?>
    
  <?php endwhile; endif; ?>
</article>

<?php get_footer(); ?>
