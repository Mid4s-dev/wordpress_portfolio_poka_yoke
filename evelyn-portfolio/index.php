<?php get_header(); ?>

<!-- Blog Archive Hero -->
<section class="bg-gradient-to-r from-green-600 to-blue-600 text-white py-20">
  <div class="container mx-auto px-6 text-center">
    <span class="inline-block bg-white/20 backdrop-blur-sm text-white px-4 py-2 rounded-full text-sm font-medium uppercase tracking-wider mb-4">My Blog</span>
    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 font-heading">
      <?php
      if (is_home() && !is_front_page()) {
        single_post_title();
      } elseif (is_archive()) {
        the_archive_title();
      } elseif (is_search()) {
        echo 'Search Results for: ' . get_search_query();
      } else {
        echo 'Latest Stories';
      }
      ?>
    </h1>
    <p class="text-xl text-white/80 max-w-3xl mx-auto">
      Thoughts, adventures, and behind-the-scenes insights from my journey.
    </p>
  </div>
</section>

<!-- Filtering options -->
<div class="bg-white border-b">
  <div class="container mx-auto px-6 py-4">
    <div class="flex flex-wrap items-center justify-between gap-4">
      <!-- Post count -->
      <div class="text-gray-600">
        <?php
        global $wp_query;
        $post_count = $wp_query->found_posts;
        echo sprintf(_n('%s Post', '%s Posts', $post_count, 'evelyn-portfolio'), number_format_i18n($post_count));
        ?>
      </div>
      
      <!-- Search form -->
      <div>
        <form role="search" method="get" class="search-form flex" action="<?php echo esc_url(home_url('/')); ?>">
          <label class="sr-only">Search for:</label>
          <input type="search" class="py-2 px-3 bg-gray-50 border border-gray-300 rounded-l-md text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition w-40 md:w-64" placeholder="Search posts..." value="<?php echo get_search_query(); ?>" name="s">
          <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-r-md transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Blog Grid -->
<section class="py-16 bg-gray-50">
  <div class="container mx-auto px-6">
    <?php if (have_posts()): ?>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php while (have_posts()): the_post(); ?>
          <article class="blog-post bg-white rounded-xl shadow-md overflow-hidden group transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
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
                  
                  <h3 class="blog-post-content text-white text-xl font-semibold transform translate-y-8 transition-transform duration-300">
                    <?php the_title(); ?>
                  </h3>
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
              
              <div class="flex justify-between items-center">
                <a href="<?php the_permalink(); ?>" class="inline-flex items-center text-green-600 font-semibold hover:text-green-700 transition">
                  <span>Continue Reading</span>
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                  </svg>
                </a>
                
                <div class="text-sm text-gray-500">
                  <?php comments_number('No comments', '1 comment', '% comments'); ?>
                </div>
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
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
          </svg>
          <h2 class="text-2xl font-semibold mb-4">No Posts Found</h2>
          <p class="text-gray-500 mb-6">Start writing your thoughts and stories to share with the world.</p>
          <?php if (current_user_can('edit_posts')): ?>
          <a href="<?php echo admin_url('post-new.php'); ?>" class="inline-block bg-green-600 text-white px-6 py-3 rounded-md hover:bg-green-700 transition">Create Your First Post</a>
          <?php endif; ?>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>

<?php get_footer(); ?>
