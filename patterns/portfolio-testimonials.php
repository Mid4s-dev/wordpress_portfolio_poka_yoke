<?php
/**
 * Testimonials pattern for Portfolio theme
 *
 * This file implements a standardized way to display testimonials
 * that can be included in various templates.
 * 
 * @package Portfolio
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Display a testimonials section with title and description
 *
 * @param string $title Section title
 * @param string $description Section description
 * @param int $count Number of testimonials to display
 * @param int $columns Number of columns (1, 2, or 3)
 * @param string $bg_color Background color class (e.g., 'bg-gray-50')
 * @return string HTML output of the testimonials section
 */
function portfolio_testimonials_pattern($title = 'Client Success Stories', $description = 'Hear from brands and organizations I\'ve helped achieve their communication goals.', $count = 4, $columns = 2, $bg_color = 'bg-gray-50') {
    ob_start();
    ?>
    <section id="testimonials" class="section <?php echo esc_attr($bg_color); ?>">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <span class="inline-block text-sm font-semibold text-primary-600 uppercase tracking-wider mb-2">Testimonials</span>
                <h2 class="heading-lg mb-6"><?php echo esc_html($title); ?></h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto"><?php echo esc_html($description); ?></p>
            </div>
            
            <?php
            // Make sure testimonials-display.php is included
            if (!function_exists('portfolio_display_testimonials')) {
                $display_file = get_template_directory() . '/inc/testimonials-display.php';
                if (file_exists($display_file)) {
                    require_once $display_file;
                }
            }
            
            // Display testimonials if function exists
            if (function_exists('portfolio_display_testimonials')) {
                echo portfolio_display_testimonials($count, $columns, true, true);
            } else {
                // Fallback direct implementation
                $testimonials_query = new WP_Query([
                    'post_type'      => 'portfolio_testimonial',
                    'posts_per_page' => $count,
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                    'post_status'    => 'publish',
                ]);
                
                if ($testimonials_query->have_posts()) {
                    echo '<div class="grid grid-cols-1 md:grid-cols-' . esc_attr($columns) . ' gap-8">';
                    while ($testimonials_query->have_posts()) : $testimonials_query->the_post();
                        // Get testimonial meta data
                        $client_name = get_post_meta(get_the_ID(), '_portfolio_testimonial_client_name', true);
                        $client_title = get_post_meta(get_the_ID(), '_portfolio_testimonial_client_title', true);
                        $client_company = get_post_meta(get_the_ID(), '_portfolio_testimonial_client_company', true);
                        $rating = get_post_meta(get_the_ID(), '_portfolio_testimonial_rating', true);
                        
                        // Fallbacks
                        $client_name = !empty($client_name) ? $client_name : get_the_title();
                        ?>
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <?php if (!empty($rating)) : ?>
                                <!-- Rating Stars -->
                                <div class="flex text-yellow-500 mb-4">
                                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                                        <?php if ($i <= $rating) : ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        <?php else : ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                            </svg>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Testimonial Content -->
                            <blockquote class="text-gray-700 italic mb-6">
                                <?php the_content(); ?>
                            </blockquote>
                            
                            <!-- Client Info -->
                            <div class="flex items-center">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="mr-4">
                                        <?php the_post_thumbnail('thumbnail', ['class' => 'w-12 h-12 rounded-full object-cover']); ?>
                                    </div>
                                <?php else : ?>
                                    <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center mr-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                <?php endif; ?>
                                
                                <div>
                                    <h4 class="font-semibold"><?php echo esc_html($client_name); ?></h4>
                                    <?php if (!empty($client_title) || !empty($client_company)) : ?>
                                        <p class="text-sm text-gray-600">
                                            <?php 
                                            if (!empty($client_title)) {
                                                echo esc_html($client_title);
                                                
                                                if (!empty($client_company)) {
                                                    echo ', ';
                                                }
                                            }
                                            
                                            if (!empty($client_company)) {
                                                echo esc_html($client_company);
                                            }
                                            ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endwhile;
                    echo '</div>';
                    wp_reset_postdata();
                } else {
                    // No testimonials found
                    echo '<div class="bg-white p-8 rounded-lg shadow-md text-center">';
                    echo '<p class="text-lg mb-4">No testimonials found.</p>';
                    
                    if (current_user_can('manage_options')) {
                        echo '<div class="bg-yellow-50 p-4 rounded-lg mb-4">';
                        echo '<p class="mb-2"><strong>Admin Notice:</strong> No testimonials exist in the database.</p>';
                        
                        // Check if post type exists
                        if (!post_type_exists('portfolio_testimonial')) {
                            echo '<p class="mb-2 text-red-600"><strong>Error:</strong> The testimonial post type is not registered correctly!</p>';
                        } else {
                            echo '<p>To add testimonials, use the Quick Testimonials page in the admin dashboard.</p>';
                            echo '<div class="mt-4 flex justify-center">';
                            echo '<a href="' . esc_url(admin_url('admin.php?page=portfolio-quick-testimonial')) . '" class="btn btn-primary btn-sm">Add Testimonial</a>';
                            echo '</div>';
                        }
                        
                        echo '</div>';
                    }
                    
                    echo '</div>';
                }
            }
            ?>
            
            <?php if (post_type_exists('portfolio_testimonial') && get_post_type_archive_link('portfolio_testimonial')) : ?>
                <div class="text-center mt-12">
                    <a href="<?php echo esc_url(get_post_type_archive_link('portfolio_testimonial')); ?>" class="btn btn-primary">View All Testimonials</a>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
