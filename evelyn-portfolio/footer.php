<footer class="bg-gray-800 text-white py-12">
  <div class="container mx-auto px-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <div>
        <h3 class="text-xl font-bold mb-4">Evelyn Portfolio</h3>
        <p class="text-gray-300">Showcasing photography and stories.</p>
      </div>
      <div>
        <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
        <ul class="space-y-2">
          <li><a href="#about" class="text-gray-300 hover:text-white transition">About</a></li>
          <li><a href="<?php echo get_post_type_archive_link('portfolio'); ?>" class="text-gray-300 hover:text-white transition">Portfolio</a></li>
          <li><a href="<?php echo get_permalink(get_option('page_for_posts')); ?>" class="text-gray-300 hover:text-white transition">Blog</a></li>
        </ul>
      </div>
      <div>
        <h3 class="text-lg font-semibold mb-4">Connect</h3>
        <?php
        $social = get_option('owner_profile_social', []);
        if (!empty($social)) {
          echo '<div class="flex space-x-4">';
          foreach ($social as $key => $url) {
            if ($url) {
              $label = ucfirst($key);
              echo '<a href="' . esc_url($url) . '" target="_blank" rel="noopener" class="text-gray-300 hover:text-white transition">' . esc_html($label) . '</a>';
            }
          }
          echo '</div>';
        }
        ?>
      </div>
    </div>
    <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
      <p>&copy; <?php echo date('Y'); ?> <?php echo esc_html(get_bloginfo('name')); ?>. All rights reserved.</p>
    </div>
  </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
