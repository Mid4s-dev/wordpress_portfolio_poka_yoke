<?php
/**
 * The front page template file
 *
 * @package WordPress
 * @subpackage Portfolio
 * @since Portfolio 1.0
 */

get_header();
?>

<!-- Hero Section -->
<section id="js-home" class="hero-section min-h-screen flex items-center bg-gradient-to-br from-gray-50 to-white">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="hero-content">
                <h1 class="heading-xl text-gray-900 mb-6">
                    <?php esc_html_e( 'Hi, I\'m ', 'portfolio' ); ?>
                    <span class="text-maroon">Joshua Lugaya</span>
                </h1>
                <h2 class="text-2xl md:text-3xl text-gray-600 font-semibold mb-6">Cybersecurity, Web Development, and Cloud Enthusiast</h2>
                <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                    <?php esc_html_e( 'Motivated and adaptable tech professional with a BSc in Information Security and Forensics, specializing in secure web applications, scalable cloud solutions, and robust cybersecurity strategies.', 'portfolio' ); ?>
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="#js-contact" class="btn btn-primary btn-lg bg-maroon hover:bg-shuka-yellow hover:text-maroon transition-colors">
                        <?php esc_html_e( 'Let\'s Collaborate', 'portfolio' ); ?>
                    </a>
                    <a href="#js-portfolio" class="btn btn-outline btn-lg border-maroon text-maroon hover:bg-maroon hover:text-white transition-colors">
                        <?php esc_html_e( 'Explore My Projects', 'portfolio' ); ?>
                    </a>
                </div>
            </div>
            <div class="hero-image">
                <div class="relative">
                    <!-- Maasai-styled Profile Container with enhanced frame styling -->
                    <div class="maasai-image-frame">
                        <!-- Corner medallions for Maasai styling -->
                        <div class="frame-corner top-left"></div>
                        <div class="frame-corner top-right"></div>
                        <div class="frame-corner bottom-left"></div>
                        <div class="frame-corner bottom-right"></div>
                        
                        <!-- Additional beadwork rows and columns -->
                        <div class="bead-row top"></div>
                        <div class="bead-row bottom"></div>
                        <div class="bead-column left"></div>
                        <div class="bead-column right"></div>
                        
                        <div class="maasai-image-frame-inner">
                        <?php 
                        // Get profile image from theme customizer
                        $profile_image = portfolio_get_profile_image();
                        if ($profile_image) : ?>
                            <img src="<?php echo esc_url($profile_image); ?>" alt="<?php echo esc_attr('Joshua Lugaya'); ?>" class="maasai-framed-image">
                        <?php 
                        // Fall back to custom logo
                        elseif (has_custom_logo()) : ?>
                            <?php the_custom_logo(); ?>
                        <?php 
                        // Default fallback to placeholder
                        else : ?>
                            <div class="w-full aspect-square flex items-center justify-center bg-gray-100 rounded-xl">
                                <svg class="w-1/3 h-1/3 text-maroon" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
                                </svg>
                            </div>
                        <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section id="about" class="section bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="heading-lg mb-6">Skills & Competencies</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Leveraging technology to solve complex problems and create innovative solutions.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 items-center">
            <div class="col-span-1">
                <div class="relative">
                    <div class="absolute inset-0 bg-primary-600 rounded-lg transform -translate-x-4 -translate-y-4"></div>
                    <img src="<?php echo esc_url( portfolio_get_skills_image() ); ?>" alt="<?php echo esc_attr( portfolio_get_owner_name() ); ?>" class="relative z-10 rounded-lg shadow-lg w-full h-auto">
                </div>
                <?php if (current_user_can('edit_theme_options')): ?>
                <div class="mt-3 text-sm">
                    <a href="<?php echo admin_url('customize.php?autofocus[section]=portfolio_frontpage_images&autofocus[control]=portfolio_skills_image_control'); ?>" class="text-primary-600 hover:text-primary-800 underline">
                        <?php echo get_theme_mod('portfolio_skills_image') ? 'Change' : 'Set'; ?> Skills Image in Customizer
                    </a>
                </div>
                <?php endif; ?>
            </div>
            <div class="col-span-1 md:col-span-2">
                <h3 class="heading-md mb-4">Core Competencies</h3>
                <div class="mb-6">
                    <div class="flex flex-wrap gap-2 mb-8">
                        <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full">Cybersecurity</span>
                        <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full">Web Development</span>
                        <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full">Cloud Architecture</span>
                        <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full">Penetration Testing</span>
                        <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full">DevOps</span>
                        <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full">API Development</span>
                        <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full">Network Security</span>
                        <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full">Cloud Security</span>
                        <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full">Full-Stack Development</span>
                    </div>
                </div>
                <h4 class="heading-sm mb-3">Tech Projects & Events</h4>
                <p class="text-gray-600 mb-6">I have contributed to various tech campaigns and events, focusing on secure web development, cloud solutions, and community engagement through social media initiatives.</p>
                <ul class="list-disc list-inside text-gray-600">
                    <li>Ajira Digital Programme: Developed portfolio websites and mobilized youth for digital skills training.</li>
                    <li>Ministry of Lands: Supported digital migration of land records and ensured ICT security compliance.</li>
                    <li>Hackathons & CTFs: Participated in events showcasing problem-solving and cybersecurity skills.</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section id="services" class="section bg-gray-50" 
         <?php if (get_theme_mod('portfolio_services_bg')): ?>
         style="background-image: url('<?php echo esc_url(portfolio_get_services_bg()); ?>'); background-size: cover; background-position: center;"
         <?php endif; ?>>
    <div class="container mx-auto px-4">
        <?php if (current_user_can('edit_theme_options')): ?>
        <div class="mb-4 text-sm text-right">
            <a href="<?php echo admin_url('customize.php?autofocus[section]=portfolio_frontpage_images&autofocus[control]=portfolio_services_bg_control'); ?>" class="text-primary-600 hover:text-primary-800 underline">
                <?php echo get_theme_mod('portfolio_services_bg') ? 'Change' : 'Set'; ?> Background Image
            </a>
        </div>
        <?php endif; ?>
        <div class="text-center mb-16">
            <span class="inline-block text-sm font-semibold text-primary-600 uppercase tracking-wider mb-2">Services</span>
            <h2 class="heading-lg mb-6">Tech Services</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Offering secure web development, scalable cloud solutions, and robust cybersecurity strategies tailored to your needs.</p>
        </div>
        
        <div class="services-carousel section-carousel">
            <?php echo do_shortcode('[portfolio_services count="6" layout="carousel" columns="3"]'); ?>
        </div>
        
        <div class="text-center mt-12">
            <a href="<?php echo esc_url(get_permalink(get_page_by_path('services'))); ?>" class="btn btn-primary">Explore Tech Services</a>
        </div>
    </div>
</section>

<!-- Portfolio Section - Recent Campaigns & Projects -->
<section id="portfolio" class="section-carousel bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="heading-lg mb-6">Recent Tech Campaigns & Projects</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Showcasing innovative tech solutions, secure applications, and impactful cloud projects.</p>
        </div>
        
        <div class="campaigns-carousel">
            <?php 
            // Display recent campaigns using our shortcode with carousel layout
            echo do_shortcode('[portfolio_campaigns count="9" orderby="date" order="DESC" layout="carousel"]'); 
            ?>
        </div>
        
        <div class="text-center mt-12">
            <a href="<?php echo esc_url(portfolio_get_campaigns_page_url()); ?>" class="btn btn-primary">View All Tech Campaigns</a>
        </div>
    </div>
</section>



<!-- Blog Section -->
<section id="blog" class="section-carousel bg-gray-50 py-16">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="heading-xl mb-4">Latest Tech Insights</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Stay updated with the latest trends, strategies, and insights in technology and innovation.</p>
        </div>
        
        <div class="blog-carousel">
            <?php
            $args = array(
                'post_type'      => 'post',
                'posts_per_page' => 9, // Show more posts in the carousel
                'orderby'        => 'date',
                'order'          => 'DESC',
            );
            
            $latest_posts = new WP_Query( $args );
            
            if ( $latest_posts->have_posts() ) :
            ?>
            <div class="swiper-container">
                <div class="swiper-wrapper">
                <?php while ( $latest_posts->have_posts() ) : $latest_posts->the_post(); ?>
                    <div class="swiper-slide">
                        <article id="js-blog-card-<?php echo get_the_ID(); ?>" class="h-full card">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <a href="<?php the_permalink(); ?>" class="block overflow-hidden">
                                    <?php the_post_thumbnail( 'medium_large', array( 'class' => 'w-full h-48 object-cover transition-transform duration-500 hover:scale-105' ) ); ?>
                                </a>
                            <?php endif; ?>
                            
                            <div class="card-content">
                                <div class="mb-2">
                                    <?php
                                    $categories = get_the_category();
                                    if ( $categories ) {
                                        $category = $categories[0];
                                        echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" class="inline-block px-2.5 py-0.5 rounded-full text-xs font-medium text-primary-600 bg-primary-50">' . esc_html( $category->name ) . '</a>';
                                    }
                                    ?>
                                </div>
                                
                                <h3 class="heading-sm mb-2">
                                    <a href="<?php the_permalink(); ?>" class="hover:text-primary-600 transition-colors"><?php the_title(); ?></a>
                                </h3>
                                
                                <div class="text-gray-500 text-sm mb-3">
                                    <?php echo get_the_date(); ?> • <?php echo get_the_author(); ?>
                                </div>
                                
                                <div class="text-gray-600 mb-4">
                                    <?php echo wp_trim_words( get_the_excerpt(), 15 ); ?>
                                </div>
                                
                                <a href="<?php the_permalink(); ?>" class="text-primary-600 hover:underline inline-flex items-center font-medium mt-auto">
                                    Read More
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </a>
                            </div>
                        </article>
                    </div>
                <?php endwhile; wp_reset_postdata(); ?>
                </div>
                
                <!-- Add pagination -->
                <div class="swiper-pagination"></div>
                
                <!-- Navigation arrows -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
            <?php else : ?>
                <div class="text-center py-12">
                    <p class="text-lg text-gray-500">No posts found. <a href="<?php echo esc_url( admin_url( 'post-new.php' ) ); ?>" class="text-primary-600 hover:underline">Add your first blog post</a>.</p>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="text-center mt-12">
            <a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>" class="btn btn-primary">View All Posts</a>
        </div>
    </div>


<!-- Contact Section with Newsletter -->
<section id="contact" class="section bg-gray-50">
    <div class="container mx-auto px-4">
        <?php if (current_user_can('edit_theme_options')): ?>
        <div class="mb-4 text-sm text-right">
            <a href="<?php echo admin_url('customize.php?autofocus[section]=portfolio_frontpage_images&autofocus[control]=portfolio_contact_image_control'); ?>" class="text-primary-600 hover:text-primary-800 underline">
                <?php echo get_theme_mod('portfolio_contact_image') ? 'Change' : 'Set'; ?> Contact Image
            </a>
        </div>
        <?php endif; ?>
        <div class="text-center mb-16">

            <h2 class="heading-lg mb-6">Get In Touch</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Have a project in mind or just want to say hello? Feel free to reach out!</p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            <!-- Contact Form -->
            <div id="js-contact-card" class="p-8 card">
                <h3 class="heading-md mb-6">Send Me a Message</h3>
                
                <form id="js-contact-form" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                            <input type="text" id="name" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500" required>
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500" required>
                        </div>
                    </div>
                    
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                        <input type="text" id="subject" name="subject" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500" required>
                    </div>
                    
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                        <textarea id="message" name="message" rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500" required></textarea>
                    </div>
                    
                    <div>
                        <button type="submit" class="button-link py-3 px-6">Send Message</button>
                    </div>
                    
                    <!-- Form response message will appear here -->
                    <div id="js-contact-form-response" class="mt-4"></div>
                </form>
                
                <script>
                jQuery(document).ready(function($) {
                    $('#js-contact-form').on('submit', function(e) {
                        e.preventDefault();
                        
                        const $form = $(this);
                        const $submit = $form.find('button[type="submit"]');
                        const $response = $('#js-contact-form-response');
                        
                        const formData = {
                            action: 'portfolio_contact_form',
                            nonce: '<?php echo wp_create_nonce('portfolio_form_nonce'); ?>',
                            name: $form.find('input[name="name"]').val(),
                            email: $form.find('input[name="email"]').val(),
                            subject: $form.find('input[name="subject"]').val(),
                            message: $form.find('textarea[name="message"]').val()
                        };
                        
                        // Disable submit button
                        $submit.prop('disabled', true).addClass('opacity-70');
                        
                        // Show loading message
                        $response.html('<div class="text-gray-600">Sending your message...</div>');
                        
                        $.ajax({
                            url: '<?php echo admin_url('admin-ajax.php'); ?>',
                            type: 'POST',
                            data: formData,
                            success: function(response) {
                                if (response.success) {
                                    $response.html('<div class="text-green-600 font-medium">Thank you! Your message has been sent successfully.</div>');
                                    $form.trigger('reset');
                                } else {
                                    $response.html('<div class="text-red-600 font-medium">' + (response.data || 'Something went wrong. Please try again.') + '</div>');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Error:', error);
                                $response.html('<div class="text-red-600 font-medium">Something went wrong. Please try again.</div>');
                            },
                            complete: function() {
                                // Re-enable submit button
                                $submit.prop('disabled', false).removeClass('opacity-70');
                            }
                        });
                    });
                });
                </script>
            </div>
            
            <!-- Newsletter and Contact Info -->
            <div class="space-y-8">
                <!-- Newsletter Signup -->
                <div id="js-newsletter-card" class="p-8 text-white bg-gradient-to-br from-maroon to-maroon-700 card">
                    <h3 class="heading-md text-white mb-4">Subscribe to My Newsletter</h3>
                    <p class="mb-6">Stay updated with my latest projects, articles, and insights. No spam, just valuable content.</p>
                    
                    <form id="js-newsletter-form" class="space-y-4">
                        <div>
                            <label for="js-newsletter-name" class="sr-only">Your Name</label>
                            <input type="text" id="js-newsletter-name" name="name" placeholder="Your name" class="w-full px-4 py-3 border-0 rounded-md focus:ring-2 focus:ring-white text-gray-900 mb-3" required>
                        </div>
                        
                        <div>
                            <label for="js-newsletter-email" class="sr-only">Email</label>
                            <input type="email" id="js-newsletter-email" name="email" placeholder="Enter your email" class="w-full px-4 py-3 border-0 rounded-md focus:ring-2 focus:ring-white text-gray-900" required>
                        </div>
                        
                        <button type="submit" class="w-full py-3 bg-white text-primary-600 font-medium rounded-md hover:bg-gray-100 transition-colors">
                            Subscribe Now
                        </button>
                        
                        <!-- Form response message will appear here -->
                        <div id="js-newsletter-form-response" class="mt-4"></div>
                    </form>
                    
                    <script>
                    jQuery(document).ready(function($) {
                        $('#js-newsletter-form').on('submit', function(e) {
                            e.preventDefault();
                            
                            const $form = $(this);
                            const $submit = $form.find('button[type="submit"]');
                            const $response = $('#js-newsletter-form-response');
                            
                            const formData = {
                                action: 'portfolio_newsletter_form',
                                nonce: '<?php echo wp_create_nonce('portfolio_form_nonce'); ?>',
                                name: $form.find('input[name="name"]').val(),
                                email: $form.find('input[name="email"]').val()
                            };
                            
                            // Disable submit button
                            $submit.prop('disabled', true).addClass('opacity-70');
                            
                            // Show loading message
                            $response.html('<div class="text-white opacity-80">Processing your subscription...</div>');
                            
                            $.ajax({
                                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                                type: 'POST',
                                data: formData,
                                success: function(response) {
                                    if (response.success) {
                                        $response.html('<div class="text-white font-medium">Thank you for subscribing to our newsletter!</div>');
                                        $form.trigger('reset');
                                    } else {
                                        $response.html('<div class="text-white bg-opacity-25 bg-red-600 p-2 rounded font-medium">' + 
                                            (response.data || 'Something went wrong. Please try again.') + '</div>');
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error('Error:', error);
                                    $response.html('<div class="text-white bg-opacity-25 bg-red-600 p-2 rounded font-medium">Something went wrong. Please try again.</div>');
                                },
                                complete: function() {
                                    // Re-enable submit button
                                    $submit.prop('disabled', false).removeClass('opacity-70');
                                }
                            });
                        });
                    });
                    </script>
                </div>
                
                <!-- Contact Information -->
                <div id="js-contact-info-card" class="p-8 card">
                    <h3 class="heading-md mb-6">Contact Information</h3>
                    
                    <?php if (get_theme_mod('portfolio_contact_image')): ?>
                    <div class="mb-6">
                        <img src="<?php echo esc_url(portfolio_get_contact_image()); ?>" alt="Contact Me" class="rounded-lg shadow-lg w-full h-auto">
                    </div>
                    <?php endif; ?>
                    
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="text-primary-600 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-medium">Email</h4>
                                <a href="mailto:hello@example.com" class="text-gray-600 hover:text-primary-600">hello@example.com</a>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="text-primary-600 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-medium">Phone</h4>
                                <a href="tel:+254700123456" class="text-gray-600 hover:text-primary-600">+254 700 123 456</a>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="text-primary-600 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-medium">Location</h4>
                                <p class="text-gray-600">Nairobi, Kenya</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Social Links -->
                    <div class="mt-8">
                        <h4 class="font-medium mb-4">Follow Me</h4>
                        <div class="flex space-x-3">
                            <a href="#" class="bg-gray-100 p-2 rounded-full text-gray-600 hover:bg-primary-100 hover:text-primary-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-linkedin" viewBox="0 0 16 16">
                                    <path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854V1.146zm4.943 12.248V6.169H2.542v7.225h2.401zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248-.822 0-1.359.54-1.359 1.248 0 .694.521 1.248 1.327 1.248h.016zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016a5.54 5.54 0 0 1 .016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225h2.4z"/>
                                </svg>
                            </a>
                            <a href="#" class="bg-gray-100 p-2 rounded-full text-gray-600 hover:bg-primary-100 hover:text-primary-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16">
                                    <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/>
                                </svg>
                            </a>
                            <a href="#" class="bg-gray-100 p-2 rounded-full text-gray-600 hover:bg-primary-100 hover:text-primary-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-github" viewBox="0 0 16 16">
                                    <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z"/>
                                </svg>
                            </a>
                            <a href="#" class="bg-gray-100 p-2 rounded-full text-gray-600 hover:bg-primary-100 hover:text-primary-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                                    <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
get_footer();
