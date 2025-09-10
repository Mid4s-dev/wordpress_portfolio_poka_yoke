<?php
/**
 * Template Name: Joshua Lugaya Maasai Portfolio
 * 
 * A custom home page template for Joshua Lugaya's portfolio with Maasai styling.
 *
 * @package WordPress
 * @subpackage Portfolio
 */

// Enqueue Swiper JS for testimonials slider
wp_enqueue_script('swiper-js', 'https://unpkg.com/swiper@8/swiper-bundle.min.js', array('jquery'), '8.0.0', true);
wp_enqueue_style('swiper-css', 'https://unpkg.com/swiper@8/swiper-bundle.min.css', array(), '8.0.0');

get_header();
?>

<main id="primary" class="site-main">
    <!-- Hero Section with Maasai Styling -->
    <section id="hero" class="py-20 md:py-28 bg-shuka-red hero-section text-white">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-8 md:mb-0">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 animated-border">Joshua Lugaya</h1>
                    <h2 class="text-2xl md:text-3xl font-medium mb-6">Cybersecurity & Full-Stack Development Specialist</h2>
                    <p class="text-lg mb-8">
                        Building secure, scalable systems that empower businesses and communities across Africa.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="#contact" class="shuka-button bg-white text-shuka-red hover:bg-shuka-beige transition-colors">
                            Get In Touch
                        </a>
                        <a href="#projects" class="shuka-button outlined border-2 border-white text-white hover:bg-white hover:bg-opacity-10 transition-colors">
                            View Portfolio
                        </a>
                    </div>
                </div>
                <div class="md:w-1/2 flex justify-center">
                    <?php 
                    $about_image = portfolio_get_about_image();
                    if (!empty($about_image)) :
                    ?>
                        <div class="profile-image-wrapper">
                            <img src="<?php echo esc_url($about_image); ?>" alt="<?php echo esc_attr(portfolio_get_owner_name()); ?>" class="profile-image w-64 h-64 object-cover">
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    
    <?php 
    // Include About Me section
    get_template_part('parts/about-me');
    
    // Include Skills & Certifications section
    get_template_part('parts/skills-certifications');
    
    // Include Work Experience section
    get_template_part('parts/work-experience');
    
    // Include Projects section
    get_template_part('parts/projects');
    
    // Include Testimonials section
    get_template_part('parts/testimonials-maasai');
    
    // Include Contact section
    get_template_part('parts/contact');
    ?>

</main><!-- #main -->

<?php
get_footer();
