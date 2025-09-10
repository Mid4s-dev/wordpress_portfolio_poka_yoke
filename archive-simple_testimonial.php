<?php
/**
 * The template for displaying Simple Testimonials archive
 *
 * @package WordPress
 * @subpackage Portfolio
 * @since Portfolio 1.0
 */

get_header();
?>

<div class="container mx-auto px-4 py-16">
    <header class="archive-header text-center mb-16">
        <h1 class="heading-xl mb-6">Client Testimonials</h1>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            Discover what our clients have to say about their experience working with us.
        </p>
    </header>

    <?php if (have_posts()) : ?>
        <div class="testimonials-grid">
            <?php while (have_posts()) : the_post(); 
                // Get testimonial meta
                $client_name = get_post_meta(get_the_ID(), '_simple_testimonial_client_name', true);
                $client_position = get_post_meta(get_the_ID(), '_simple_testimonial_client_position', true);
                $client_company = get_post_meta(get_the_ID(), '_simple_testimonial_client_company', true);
                $rating = get_post_meta(get_the_ID(), '_simple_testimonial_rating', true);

                // Fallbacks
                $client_name = !empty($client_name) ? $client_name : get_the_title();
            ?>
                <div class="testimonial-item">
                    <div class="testimonial-content">
                        <blockquote>
                            <?php the_content(); ?>
                        </blockquote>
                    </div>
                    
                    <div class="testimonial-meta">
                        <div class="client-info">
                            <div class="client-image">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('thumbnail'); ?>
                                <?php else : ?>
                                    <span><?php echo substr($client_name, 0, 1); ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="client-details">
                                <h4><?php echo esc_html($client_name); ?></h4>
                                <?php if (!empty($client_position)) : ?>
                                    <span class="client-position"><?php echo esc_html($client_position); ?></span>
                                <?php endif; ?>
                                <?php if (!empty($client_company)) : ?>
                                    <span class="client-company"><?php echo esc_html($client_company); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <?php if (!empty($rating)) : ?>
                            <div class="testimonial-rating">
                                <?php for ($i = 1; $i <= 5; $i++) : ?>
                                    <?php if ($i <= $rating) : ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                                        </svg>
                                    <?php else : ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                        </svg>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <?php the_posts_pagination(array(
            'prev_text' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>',
            'next_text' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>',
        )); ?>

    <?php else : ?>
        <div class="text-center py-16">
            <p class="text-xl mb-8">No testimonials found.</p>
            <?php if (current_user_can('publish_posts')) : ?>
                <a href="<?php echo esc_url(admin_url('post-new.php?post_type=simple_testimonial')); ?>" class="btn btn-primary">Add Your First Testimonial</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<?php
get_footer();
