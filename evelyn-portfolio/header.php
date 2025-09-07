<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="bg-white shadow-lg sticky top-0 z-50 transition-all duration-300" id="site-header">
  <div class="container mx-auto px-6 py-4 flex justify-between items-center">
    <div class="flex items-center">
      <?php 
      if (has_custom_logo()) {
        the_custom_logo();
      } else {
      ?>
        <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center">
          <span class="text-2xl font-heading font-bold text-gray-800 hover:text-blue-600 transition">
            <?php echo esc_html(get_bloginfo('name')); ?>
          </span>
        </a>
      <?php } ?>
    </div>
    
    <nav class="hidden md:flex space-x-8">
      <?php
      wp_nav_menu([
        'theme_location' => 'primary',
        'container' => false,
        'menu_class' => 'flex space-x-8',
        'fallback_cb' => function() {
          echo '<a href="#about" class="text-gray-700 hover:text-blue-600 transition font-medium">About</a>';
          echo '<a href="' . get_post_type_archive_link('portfolio') . '" class="text-gray-700 hover:text-blue-600 transition font-medium">Portfolio</a>';
          echo '<a href="' . get_permalink(get_option('page_for_posts')) . '" class="text-gray-700 hover:text-blue-600 transition font-medium">Blog</a>';
          echo '<a href="#newsletter" class="text-gray-700 hover:text-blue-600 transition font-medium">Contact</a>';
        },
        'link_before' => '<span class="relative inline-block transition-all duration-300 hover:text-blue-600">',
        'link_after' => '<span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span></span>'
      ]);
      ?>
    </nav>
    
    <div class="md:hidden">
      <button id="mobile-menu-button" class="text-gray-700 focus:outline-none" aria-label="Toggle mobile menu">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
      </button>
    </div>
  </div>
  
  <div id="mobile-menu" class="hidden md:hidden bg-white border-t">
    <div class="container mx-auto px-6 py-4">
      <?php
      wp_nav_menu([
        'theme_location' => 'primary',
        'container' => false,
        'menu_class' => 'space-y-4',
        'fallback_cb' => function() {
          echo '<a href="#about" class="block text-gray-700 hover:text-blue-600 transition py-2">About</a>';
          echo '<a href="' . get_post_type_archive_link('portfolio') . '" class="block text-gray-700 hover:text-blue-600 transition py-2">Portfolio</a>';
          echo '<a href="' . get_permalink(get_option('page_for_posts')) . '" class="block text-gray-700 hover:text-blue-600 transition py-2">Blog</a>';
          echo '<a href="#newsletter" class="block text-gray-700 hover:text-blue-600 transition py-2">Contact</a>';
        }
      ]);
      ?>
    </div>
  </div>
</header>
