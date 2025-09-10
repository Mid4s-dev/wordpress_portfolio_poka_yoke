<?php
/**
 * The template for displaying single Simple Testimonial
 *
 * @package WordPress
 * @subpackage Portfolio
 * @since Portfolio 1.0
 */

get_header();

// Get testimonial meta
$client_name = get_post_meta(get_the_ID(), '_simple_testimonial_client_name', true);
$client_position = get_post_meta(get_the_ID(), '_simple_testimonial_client_position', true);
$client_company = get_post_meta(get_the_ID(), '_simple_testimonial_client_company', true);
$rating = get_post_meta(get_the_ID(), '_simple_testimonial_rating', true);

// Fallbacks
$client_name = !empty($client_name) ? $client_name : get_the_title();
?>

<div class="container mx-auto px-4 py-16">
    <div class="max-w-4xl mx-auto">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            
            <div class="mb-8">
                <a href="<?php echo esc_url(get_post_type_archive_link('simple_testimonial')); ?>" class="inline-flex items-center text-primary-600 hover:underline">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    Back to All Testimonials
                </a>
            </div>
            
            <div class="testimonial-item single-testimonial bg-white rounded-xl shadow-xl p-8 mb-12">
                <?php if (!empty($rating)) : ?>
                    <div class="testimonial-rating mb-6">
                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                            <?php if ($i <= $rating) : ?>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 inline-block" viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                                </svg>
                            <?php else : ?>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>
                
                <h1 class="heading-lg mb-8"><?php the_title(); ?></h1>
                
                <div class="testimonial-content text-xl mb-12 relative">
                    <div class="absolute -left-6 -top-6 text-8xl text-gray-100 font-serif leading-none">"</div>
                    <div class="relative z-10">
                        <?php the_content(); ?>
                    </div>
                    <div class="absolute -bottom-16 right-0 text-8xl text-gray-100 font-serif leading-none">"</div>
                </div>
                
                <div class="testimonial-meta border-t border-gray-200 pt-8 mt-8">
                    <div class="flex items-center">
                        <div class="mr-6">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('thumbnail', ['class' => 'rounded-full w-24 h-24 object-cover']); ?>
                            <?php else : ?>
                                <div class="bg-primary-100 text-primary-700 rounded-full w-24 h-24 flex items-center justify-center text-4xl font-bold">
                                    <?php echo substr($client_name, 0, 1); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div>
                            <h3 class="heading-sm mb-2"><?php echo esc_html($client_name); ?></h3>
                            <?php if (!empty($client_position) || !empty($client_company)) : ?>
                                <p class="text-gray-600">
                                    <?php 
                                    if (!empty($client_position)) {
                                        echo esc_html($client_position);
                                        
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
            </div>
            
            <div class="mt-16">
                <h3 class="heading-md mb-8">More Client Testimonials</h3>
                
                <?php
                // Get related testimonials
                $args = array(
                    'post_type'      => 'simple_testimonial',
                    'posts_per_page' => 3,
                    'post__not_in'   => array(get_the_ID()),
                    'orderby'        => 'rand',
                );
                
                $related_testimonials = new WP_Query($args);
                
                if ($related_testimonials->have_posts()) :
                    echo '<div class="testimonials-grid">';
                    
                    while ($related_testimonials->have_posts()) :
                        $related_testimonials->the_post();
                        
                        // Get testimonial meta
                        $r_client_name = get_post_meta(get_the_ID(), '_simple_testimonial_client_name', true);
                        $r_client_position = get_post_meta(get_the_ID(), '_simple_testimonial_client_position', true);
                        $r_client_company = get_post_meta(get_the_ID(), '_simple_testimonial_client_company', true);
                        $r_rating = get_post_meta(get_the_ID(), '_simple_testimonial_rating', true);
                        
                        // Fallbacks
                        $r_client_name = !empty($r_client_name) ? $r_client_name : get_the_title();
                        ?>
                        <div class="testimonial-item">
                            <div class="testimonial-content">
                                <blockquote>
                                    <?php echo wp_trim_words(get_the_content(), 30, '... <a href="' . get_permalink() . '" class="text-primary-600 hover:underline">Read More</a>'); ?>
                                </blockquote>
                            </div>
                            
                            <div class="testimonial-meta">
                                <div class="client-info">
                                    <div class="client-image">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <?php the_post_thumbnail('thumbnail'); ?>
                                        <?php else : ?>
                                            <span><?php echo substr($r_client_name, 0, 1); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="client-details">
                                        <h4><?php echo esc_html($r_client_name); ?></h4>
                                        <?php if (!empty($r_client_position)) : ?>
                                            <span class="client-position"><?php echo esc_html($r_client_position); ?></span>
                                        <?php endif; ?>
                                        <?php if (!empty($r_client_company)) : ?>
                                            <span class="client-company"><?php echo esc_html($r_client_company); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <?php if (!empty($r_rating)) : ?>
                                    <div class="testimonial-rating">
                                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                                            <?php if ($i <= $r_rating) : ?>
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
                    <?php endwhile;
                    
                    echo '</div>';
                    wp_reset_postdata();
                else :
                    echo '<p>No more testimonials found.</p>';
                endif;
                ?>
            </div>
            
        <?php endwhile; else : ?>
            <div class="text-center py-16">
                <p class="text-xl mb-8">Testimonial not found.</p>
                <a href="<?php echo esc_url(get_post_type_archive_link('simple_testimonial')); ?>" class="btn btn-primary">View All Testimonials</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
get_footer();
