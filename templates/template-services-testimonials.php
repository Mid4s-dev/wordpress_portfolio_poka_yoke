<?php
/**
 * Template Name: Services & Testimonials
 * 
 * A template for displaying services and testimonials.
 *
 * @package WordPress
 * @subpackage Portfolio
 * @since 1.0
 */

get_header();
?>

<main id="main" class="site-main">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <div class="entry-content">
            <div class="container mx-auto px-4 py-8">
                <?php
                // Display the page content at the top (if any)
                if (have_posts()) :
                    while (have_posts()) :
                        the_post();
                        the_content();
                    endwhile;
                endif;
                ?>

                <!-- Services Section -->
                <section class="services-section my-12">
                    <h2 class="text-3xl font-bold text-center mb-8"><?php _e('Our Services', 'portfolio'); ?></h2>
                    
                    <?php echo do_shortcode('[portfolio_services count="-1" layout="grid" columns="3"]'); ?>
                </section>

                <!-- Testimonials Section -->
                <section class="testimonials-section my-12 bg-gray-100 py-12 px-4 rounded-lg">
                    <h2 class="text-3xl font-bold text-center mb-8"><?php _e('What Our Clients Say', 'portfolio'); ?></h2>
                    
                    <?php echo do_shortcode('[portfolio_testimonials count="6" layout="grid"]'); ?>
                </section>

                <!-- Call to Action -->
                <section class="cta-section my-12 text-center">
                    <h2 class="text-3xl font-bold mb-4"><?php _e('Ready to Get Started?', 'portfolio'); ?></h2>
                    <p class="text-xl mb-6"><?php _e('Contact us today to discuss your project requirements.', 'portfolio'); ?></p>
                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                        <?php _e('Contact Us', 'portfolio'); ?>
                    </a>
                </section>
            </div>
        </div>
    </article>
</main>

<?php
get_footer();
?>
