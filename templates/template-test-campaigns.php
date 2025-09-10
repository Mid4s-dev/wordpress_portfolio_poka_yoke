<?php
/**
 * Template Name: Test Campaigns and Testimonials
 * Description: A template for testing campaigns and testimonials display
 *
 * @package Portfolio
 */

get_header();
?>

<div class="container mx-auto px-4 py-12">
    <h1 class="heading-xl mb-12 text-center">Testing Campaigns and Testimonials</h1>
    
    <!-- Test Campaigns Section -->
    <section id="test-campaigns" class="mb-16">
        <h2 class="heading-lg mb-8 text-center">Campaign Tests</h2>
        
        <div class="bg-white p-8 rounded-lg shadow-md">
            <h3 class="heading-md mb-4">Recent Campaigns</h3>
            <?php 
            // Display recent campaigns using shortcode
            echo do_shortcode('[portfolio_campaigns count="3" orderby="date" order="DESC"]'); 
            ?>
            
            <div class="mt-8">
                <h3 class="heading-md mb-4">Campaign Categories</h3>
                <?php 
                // Display campaign categories
                $terms = get_terms(array(
                    'taxonomy' => 'portfolio_campaign_cat',
                    'hide_empty' => false,
                ));
                
                if (!empty($terms) && !is_wp_error($terms)) {
                    echo '<ul class="list-disc pl-5">';
                    foreach ($terms as $term) {
                        echo '<li><a href="' . esc_url(get_term_link($term)) . '" class="text-primary-600 hover:underline">' . 
                            esc_html($term->name) . '</a> (' . esc_html($term->count) . ')</li>';
                    }
                    echo '</ul>';
                } else {
                    echo '<p>No campaign categories found.</p>';
                }
                ?>
            </div>
        </div>
    </section>
    
    <!-- Test Testimonials Section -->
    <section id="test-testimonials" class="mb-16">
        <h2 class="heading-lg mb-8 text-center">Testimonial Tests</h2>
        
        <div class="bg-white p-8 rounded-lg shadow-md">
            <?php
            // Debug output for admins
            if (current_user_can('manage_options')) {
                echo '<div class="mb-8 p-4 bg-gray-100 rounded text-sm font-mono">';
                echo '<h3 class="text-lg font-bold">Debug Info:</h3>';
                
                echo 'Post Type Registered: ' . (post_type_exists('portfolio_testimonial') ? 'Yes' : 'No') . '<br>';
                
                $testimonial_count = wp_count_posts('portfolio_testimonial');
                echo 'Testimonial Post Count: ' . ($testimonial_count->publish ?? 0) . ' published, ' . ($testimonial_count->draft ?? 0) . ' draft<br>';
                
                echo '</div>';
            }
            
            // Direct query approach
            $testimonials_query = new WP_Query([
                'post_type'      => 'portfolio_testimonial',
                'posts_per_page' => 3,
                'orderby'        => 'date',
                'order'          => 'DESC',
                'post_status'    => 'publish',
            ]);
            
            // Add debug info
            if (current_user_can('manage_options')) {
                echo '<div class="mb-8 p-4 bg-gray-100 rounded text-sm font-mono">';
                echo '<p>Query SQL: ' . $testimonials_query->request . '</p>';
                echo '<p>Found posts: ' . $testimonials_query->found_posts . '</p>';
                echo '</div>';
            }
            
            if ($testimonials_query->have_posts()) {
                echo '<h3 class="heading-md mb-6">Recent Testimonials</h3>';
                echo '<div class="grid grid-cols-1 md:grid-cols-3 gap-6">';
                while ($testimonials_query->have_posts()) : $testimonials_query->the_post();
                    // Get testimonial meta data
                    $client_name = get_post_meta(get_the_ID(), '_portfolio_testimonial_client_name', true);
                    $client_title = get_post_meta(get_the_ID(), '_portfolio_testimonial_client_title', true);
                    $client_company = get_post_meta(get_the_ID(), '_portfolio_testimonial_client_company', true);
                    $rating = get_post_meta(get_the_ID(), '_portfolio_testimonial_rating', true);
                    
                    // Fallbacks
                    $client_name = !empty($client_name) ? $client_name : get_the_title();
                    ?>
                    <div class="testimonial-item bg-white p-6 rounded-lg shadow-md">
                        <?php if (!empty($rating)) : ?>
                            <!-- Rating Stars -->
                            <div class="testimonial-rating flex text-yellow-500 mb-4">
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
                        <div class="testimonial-content mb-6">
                            <blockquote class="text-gray-700 italic">
                                <?php the_content(); ?>
                            </blockquote>
                        </div>
                        
                        <!-- Client Info -->
                        <div class="testimonial-client flex items-center">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="mr-4">
                                    <?php the_post_thumbnail('thumbnail', ['class' => 'profile-image w-12 h-12 rounded-full object-cover']); ?>
                                </div>
                            <?php else : ?>
                                <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            <?php endif; ?>
                            
                            <div class="testimonial-client-info">
                                <h4 class="font-semibold text-shuka-black"><?php echo esc_html($client_name); ?></h4>
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
                
                echo '<div class="mt-8 text-center">';
                echo '<a href="' . esc_url(get_post_type_archive_link('portfolio_testimonial')) . '" class="btn btn-primary">View All Testimonials</a>';
                echo '</div>';
            } else {
                // No testimonials found - show message and link to Quick Testimonials for admins
                echo '<div class="text-center py-8">';
                echo '<p class="text-lg mb-4">No testimonials found.</p>';
                
                if (current_user_can('manage_options')) {
                    echo '<div class="bg-yellow-50 p-4 rounded-lg mb-4">';
                    echo '<p class="mb-2"><strong>Admin Notice:</strong> No testimonials exist in the database.</p>';
                    echo '<p class="mb-4">Add testimonials using the Quick Testimonials page:</p>';
                    echo '<a href="' . esc_url(admin_url('admin.php?page=portfolio-quick-testimonial')) . '" class="admin-quick-add-button">Quick Add Testimonial</a>';
                    echo '</div>';
                }
                echo '</div>';
            }
            ?>
        </div>
    </section>
    
    <!-- Admin Actions Section (for admins only) -->
    <?php if (current_user_can('manage_options')) : ?>
    <section id="admin-actions" class="mb-16">
        <h2 class="heading-lg mb-8 text-center">Admin Actions</h2>
        
        <div class="bg-white p-8 rounded-lg shadow-md">
            <h3 class="heading-md mb-4">Quick Links</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="<?php echo esc_url(admin_url('edit.php?post_type=portfolio_campaign')); ?>" class="p-4 bg-gray-100 hover:bg-gray-200 rounded flex items-center justify-between">
                    <span>Manage Campaigns</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
                <a href="<?php echo esc_url(admin_url('edit.php?post_type=portfolio_testimonial')); ?>" class="p-4 bg-gray-100 hover:bg-gray-200 rounded flex items-center justify-between">
                    <span>Manage Testimonials</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
                <a href="<?php echo esc_url(admin_url('admin.php?page=portfolio-quick-testimonial')); ?>" class="p-4 bg-gray-100 hover:bg-gray-200 rounded flex items-center justify-between">
                    <span>Quick Add Testimonial</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
                <a href="<?php echo esc_url(admin_url('options-permalink.php')); ?>" class="p-4 bg-gray-100 hover:bg-gray-200 rounded flex items-center justify-between">
                    <span>Refresh Permalinks</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
    </section>
    <?php endif; ?>
</div>

<?php get_footer(); ?>