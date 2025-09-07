<?php get_header(); ?>

<!-- Portfolio Archive Hero -->
<section class="bg-gradient-to-r from-blue-600 to-purple-800 text-white py-20">
  <div class="container mx-auto px-6 text-center">
    <span class="inline-block bg-white/20 backdrop-blur-sm text-white px-4 py-2 rounded-full text-sm font-medium uppercase tracking-wider mb-4">My Collection</span>
    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 font-heading">Photography Portfolio</h1>
    <p class="text-xl text-white/80 max-w-3xl mx-auto">Explore my complete collection of visual stories and captured moments.</p>
  </div>
</section>

<!-- Filtering options -->
<div class="bg-white border-b">
  <div class="container mx-auto px-6 py-4">
    <div class="flex flex-wrap items-center justify-between gap-4">
      <!-- Portfolio count -->
      <div class="text-gray-600">
        <?php
        $portfolio_count = $wp_query->found_posts;
        echo sprintf(_n('%s Project', '%s Projects', $portfolio_count, 'evelyn-portfolio'), number_format_i18n($portfolio_count));
        ?>
      </div>
      
      <!-- Simple sorting (if enabled) -->
      <?php if (false): // Enable this if you want to add sorting ?>
      <div class="flex items-center gap-2">
        <span class="text-gray-600">Sort by:</span>
        <select class="py-2 px-3 bg-gray-50 border border-gray-300 rounded-md text-sm">
          <option value="date-desc">Newest First</option>
          <option value="date-asc">Oldest First</option>
          <option value="title">Title A-Z</option>
        </select>
      </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- Portfolio Grid -->
<section class="py-16 bg-gray-50">
  <div class="container mx-auto px-6">
    <?php if (have_posts()): ?>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php $counter = 0; ?>
        <?php while (have_posts()): the_post(); $counter++; ?>
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
              <h2 class="text-2xl font-semibold mb-3 font-heading">
                <a href="<?php the_permalink(); ?>" class="hover:text-blue-600 transition"><?php the_title(); ?></a>
              </h2>
              
              <div class="text-gray-600 mb-4 line-clamp-3">
                <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
              </div>
              
              <div class="flex justify-between items-center">
                <a href="<?php the_permalink(); ?>" class="text-blue-600 font-semibold flex items-center group/link">
                  <span>View details</span>
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
        <?php endwhile; ?>
      </div>
      
      <!-- Pagination -->
      <div class="mt-12 flex justify-center">
        <?php
        echo paginate_links([
          'prev_text' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>',
          'next_text' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>',
          'before_page_number' => '<span class="px-3 py-2">',
          'after_page_number' => '</span>',
          'class' => 'flex items-center gap-2'
        ]);
        ?>
      </div>
      
    <?php else: ?>
      <div class="py-16 text-center">
        <div class="bg-white rounded-lg shadow-md p-12 max-w-xl mx-auto">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300 mx-auto mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
          </svg>
          <h2 class="text-2xl font-semibold mb-4">No Portfolio Items Yet</h2>
          <p class="text-gray-500 mb-6">Start adding your beautiful work from the admin dashboard!</p>
          <?php if (current_user_can('edit_posts')): ?>
          <a href="<?php echo admin_url('post-new.php?post_type=portfolio'); ?>" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 transition">Add Portfolio Item</a>
          <?php endif; ?>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>

<?php get_footer(); ?>
