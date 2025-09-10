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