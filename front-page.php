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
<section id="home" class="hero-section min-h-screen flex items-center bg-gradient-to-br from-gray-50 to-white">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="hero-content">
                <h1 class="heading-xl text-gray-900 mb-6">
                    <?php esc_html_e( 'Hi, I\'m ', 'portfolio' ); ?>
                    <span class="text-primary-600">Evelyn Kanyua</span>
                </h1>
                <h2 class="text-2xl md:text-3xl text-gray-600 font-semibold mb-6"><?php esc_html_e( 'PR & Communications Lead', 'portfolio' ); ?></h2>
                <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                    <?php esc_html_e( 'I create compelling narratives, build strong brand relationships, and drive strategic communication campaigns that engage audiences and deliver measurable results.', 'portfolio' ); ?>
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="#contact" class="btn btn-primary btn-lg">
                        <?php esc_html_e( 'Let\'s Connect', 'portfolio' ); ?>
                    </a>
                    <a href="#portfolio" class="btn btn-outline btn-lg">
                        <?php esc_html_e( 'View My Work', 'portfolio' ); ?>
                    </a>
                </div>
            </div>
            <div class="hero-image">
                <div class="relative">
                    <?php if ( has_custom_logo() ) : ?>
                        <div class="hero-avatar rounded-full overflow-hidden">
                            <?php the_custom_logo(); ?>
                        </div>
                    <?php else : ?>
                        <div class="relative">
                            <div class="absolute inset-0 bg-primary-600 rounded-full transform translate-x-4 translate-y-4"></div>
                            <div class="relative z-10 bg-white rounded-full border-4 border-white shadow-lg w-80 h-80 mx-auto flex items-center justify-center">
                                <svg class="w-32 h-32 text-primary-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
                                </svg>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section id="about" class="section bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <span class="inline-block text-sm font-semibold text-primary-600 uppercase tracking-wider mb-2">About Me</span>
            <h2 class="heading-lg mb-6">Strategic Communications Professional</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Experienced PR and Communications Lead with a passion for storytelling and brand building.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 items-center">
            <div class="col-span-1">
                <div class="relative">
                    <div class="absolute inset-0 bg-primary-600 rounded-lg transform -translate-x-4 -translate-y-4"></div>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/about-me.jpg' ); ?>" alt="Evelyn Kanyua" class="relative z-10 rounded-lg shadow-lg w-full h-auto">
                </div>
            </div>
            
            <div class="col-span-1 md:col-span-2">
                <h3 class="heading-md mb-4">My Professional Journey</h3>
                <p class="text-gray-600 mb-6">With over 7 years of experience in public relations and strategic communications, I specialize in building compelling brand narratives, managing crisis communications, and developing integrated campaigns that drive meaningful engagement across traditional and digital media channels.</p>
                
                <h4 class="heading-sm mb-3">Core Competencies</h4>
                <div class="mb-6">
                    <div class="flex flex-wrap gap-2 mb-8">
                        <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full">Media Relations</span>
                        <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full">Crisis Communication</span>
                        <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full">Content Strategy</span>
                        <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full">Brand Management</span>
                        <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full">Social Media Strategy</span>
                        <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full">Stakeholder Engagement</span>
                        <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full">Event Management</span>
                        <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full">Press Release Writing</span>
                        <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full">Campaign Management</span>
                    </div>
                </div>
                
                <a href="#" class="btn btn-primary">Download My CV</a>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section id="services" class="section bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <span class="inline-block text-sm font-semibold text-primary-600 uppercase tracking-wider mb-2">Services</span>
            <h2 class="heading-lg mb-6">How I Can Help Your Brand</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Comprehensive PR and communications solutions tailored to your brand's unique needs.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Service 1 -->
            <div class="card p-6 hover:shadow-xl transition-shadow duration-300">
                <div class="text-primary-600 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15" />
                    </svg>
                </div>
                <h3 class="heading-sm mb-3">Media Relations</h3>
                <p class="text-gray-600 mb-4">Building strong relationships with journalists and securing strategic media coverage that amplifies your brand message and credibility.</p>
                <a href="#" class="text-primary-600 hover:underline font-medium inline-flex items-center">
                    Learn More
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
            
            <!-- Service 2 -->
            <div class="card p-6 hover:shadow-xl transition-shadow duration-300">
                <div class="text-primary-600 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                    </svg>
                </div>
                <h3 class="heading-sm mb-3">Crisis Communication</h3>
                <p class="text-gray-600 mb-4">Managing reputation during challenging times with strategic crisis communication plans and rapid response protocols.</p>
                <a href="#" class="text-primary-600 hover:underline font-medium inline-flex items-center">
                    Learn More
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
            
            <!-- Service 3 -->
            <div class="card p-6 hover:shadow-xl transition-shadow duration-300">
                <div class="text-primary-600 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h3 class="heading-sm mb-3">Content Strategy</h3>
                <p class="text-gray-600 mb-4">Developing compelling content strategies that engage your target audience across multiple channels and platforms.</p>
                <a href="#" class="text-primary-600 hover:underline font-medium inline-flex items-center">
                    Learn More
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>

            <!-- Service 4 -->
            <div class="card p-6 hover:shadow-xl transition-shadow duration-300">
                <div class="text-primary-600 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h3 class="heading-sm mb-3">Stakeholder Engagement</h3>
                <p class="text-gray-600 mb-4">Creating meaningful connections with key stakeholders through targeted communication and relationship-building strategies.</p>
                <a href="#" class="text-primary-600 hover:underline font-medium inline-flex items-center">
                    Learn More
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>

            <!-- Service 5 -->
            <div class="card p-6 hover:shadow-xl transition-shadow duration-300">
                <div class="text-primary-600 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z" />
                    </svg>
                </div>
                <h3 class="heading-sm mb-3">Social Media Strategy</h3>
                <p class="text-gray-600 mb-4">Developing and executing comprehensive social media strategies that build community and drive engagement.</p>
                <a href="#" class="text-primary-600 hover:underline font-medium inline-flex items-center">
                    Learn More
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>

            <!-- Service 6 -->
            <div class="card p-6 hover:shadow-xl transition-shadow duration-300">
                <div class="text-primary-600 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="heading-sm mb-3">Event Management</h3>
                <p class="text-gray-600 mb-4">Planning and executing memorable corporate events, press conferences, and brand activations that create lasting impact.</p>
                <a href="#" class="text-primary-600 hover:underline font-medium inline-flex items-center">
                    Learn More
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Portfolio Section -->
<section id="portfolio" class="section bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <span class="inline-block text-sm font-semibold text-primary-600 uppercase tracking-wider mb-2">Portfolio</span>
            <h2 class="heading-lg mb-6">Recent Campaigns & Projects</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Showcasing successful PR campaigns, brand launches, and communication strategies that delivered measurable results.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Project 1 -->
            <div class="card overflow-hidden group">
                <div class="relative overflow-hidden">
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/project-1.jpg' ); ?>" alt="Tech Startup Launch Campaign" class="w-full h-64 object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent opacity-0 group-hover:opacity-90 transition-opacity duration-300 flex items-end p-6">
                        <div>
                            <h4 class="text-white font-semibold text-xl mb-2">Tech Startup Launch</h4>
                            <p class="text-gray-200 mb-4">Integrated campaign that secured 150+ media placements and 50M+ media impressions within 3 months.</p>
                            <div class="flex space-x-2">
                                <a href="#" class="bg-white text-gray-900 px-3 py-1 rounded-full text-sm font-medium">View Case Study</a>
                                <a href="#" class="bg-transparent border border-white text-white px-3 py-1 rounded-full text-sm font-medium">Results</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Project 2 -->
            <div class="card overflow-hidden group">
                <div class="relative overflow-hidden">
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/project-2.jpg' ); ?>" alt="Crisis Communication Management" class="w-full h-64 object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent opacity-0 group-hover:opacity-90 transition-opacity duration-300 flex items-end p-6">
                        <div>
                            <h4 class="text-white font-semibold text-xl mb-2">Crisis Communication</h4>
                            <p class="text-gray-200 mb-4">Successfully managed reputation crisis with strategic messaging, reducing negative sentiment by 80%.</p>
                            <div class="flex space-x-2">
                                <a href="#" class="bg-white text-gray-900 px-3 py-1 rounded-full text-sm font-medium">View Case Study</a>
                                <a href="#" class="bg-transparent border border-white text-white px-3 py-1 rounded-full text-sm font-medium">Strategy</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Project 3 -->
            <div class="card overflow-hidden group">
                <div class="relative overflow-hidden">
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/project-3.jpg' ); ?>" alt="Non-Profit Awareness Campaign" class="w-full h-64 object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent opacity-0 group-hover:opacity-90 transition-opacity duration-300 flex items-end p-6">
                        <div>
                            <h4 class="text-white font-semibold text-xl mb-2">Non-Profit Campaign</h4>
                            <p class="text-gray-200 mb-4">Awareness campaign that increased donations by 200% and volunteer sign-ups by 150%.</p>
                            <div class="flex space-x-2">
                                <a href="#" class="bg-white text-gray-900 px-3 py-1 rounded-full text-sm font-medium">View Case Study</a>
                                <a href="#" class="bg-transparent border border-white text-white px-3 py-1 rounded-full text-sm font-medium">Impact</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Project 4 -->
            <div class="card overflow-hidden group">
                <div class="relative overflow-hidden">
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/project-4.jpg' ); ?>" alt="Corporate Rebrand Campaign" class="w-full h-64 object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent opacity-0 group-hover:opacity-90 transition-opacity duration-300 flex items-end p-6">
                        <div>
                            <h4 class="text-white font-semibold text-xl mb-2">Corporate Rebrand</h4>
                            <p class="text-gray-200 mb-4">Complete rebrand communication strategy that improved brand perception by 60% across all demographics.</p>
                            <div class="flex space-x-2">
                                <a href="#" class="bg-white text-gray-900 px-3 py-1 rounded-full text-sm font-medium">View Case Study</a>
                                <a href="#" class="bg-transparent border border-white text-white px-3 py-1 rounded-full text-sm font-medium">Results</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Project 5 -->
            <div class="card overflow-hidden group">
                <div class="relative overflow-hidden">
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/project-5.jpg' ); ?>" alt="Product Launch Campaign" class="w-full h-64 object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent opacity-0 group-hover:opacity-90 transition-opacity duration-300 flex items-end p-6">
                        <div>
                            <h4 class="text-white font-semibold text-xl mb-2">Product Launch</h4>
                            <p class="text-gray-200 mb-4">Multi-channel campaign generating 10M+ social impressions and exceeding sales targets by 40%.</p>
                            <div class="flex space-x-2">
                                <a href="#" class="bg-white text-gray-900 px-3 py-1 rounded-full text-sm font-medium">View Case Study</a>
                                <a href="#" class="bg-transparent border border-white text-white px-3 py-1 rounded-full text-sm font-medium">Metrics</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Project 6 -->
            <div class="card overflow-hidden group">
                <div class="relative overflow-hidden">
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/project-6.jpg' ); ?>" alt="Thought Leadership Campaign" class="w-full h-64 object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent opacity-0 group-hover:opacity-90 transition-opacity duration-300 flex items-end p-6">
                        <div>
                            <h4 class="text-white font-semibold text-xl mb-2">Thought Leadership</h4>
                            <p class="text-gray-200 mb-4">Executive positioning campaign resulting in 50+ speaking opportunities and industry recognition.</p>
                            <div class="flex space-x-2">
                                <a href="#" class="bg-white text-gray-900 px-3 py-1 rounded-full text-sm font-medium">View Case Study</a>
                                <a href="#" class="bg-transparent border border-white text-white px-3 py-1 rounded-full text-sm font-medium">Awards</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-12">
            <a href="#" class="btn btn-primary">View All Case Studies</a>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section id="testimonials" class="section bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <span class="inline-block text-sm font-semibold text-primary-600 uppercase tracking-wider mb-2">Testimonials</span>
            <h2 class="heading-lg mb-6">Client Success Stories</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Hear from brands and organizations I've helped achieve their communication goals.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Testimonial 1 -->
            <div class="card p-8">
                <div class="flex items-center mb-6">
                    <div class="text-primary-600">
                        <!-- 5 Stars -->
                        <div class="flex">
                            <?php for ($i = 0; $i < 5; $i++): ?>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
                <blockquote class="text-gray-600 mb-6">"Evelyn's strategic communication expertise was instrumental in our successful market expansion. Her ability to craft compelling narratives and build relationships with key stakeholders resulted in unprecedented media coverage and brand awareness. She's a true professional who delivers exceptional results."</blockquote>
                <div class="flex items-center">
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/testimonial-1.jpg' ); ?>" alt="Sarah Johnson" class="w-12 h-12 rounded-full object-cover mr-4">
                    <div>
                        <p class="font-medium">Sarah Johnson</p>
                        <p class="text-sm text-gray-500">CEO, InnovateX Technologies</p>
                    </div>
                </div>
            </div>
            
            <!-- Testimonial 2 -->
            <div class="card p-8">
                <div class="flex items-center mb-6">
                    <div class="text-primary-600">
                        <!-- 5 Stars -->
                        <div class="flex">
                            <?php for ($i = 0; $i < 5; $i++): ?>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
                <blockquote class="text-gray-600 mb-6">"During our organization's most challenging crisis, Evelyn provided exceptional crisis communication leadership. Her calm approach, strategic thinking, and media expertise helped us navigate the situation with transparency and integrity. Our stakeholder trust actually increased post-crisis."</blockquote>
                <div class="flex items-center">
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/testimonial-2.jpg' ); ?>" alt="Michael Chen" class="w-12 h-12 rounded-full object-cover mr-4">
                    <div>
                        <p class="font-medium">Michael Chen</p>
                        <p class="text-sm text-gray-500">Director, Global Impact Foundation</p>
                    </div>
                </div>
            </div>

            <!-- Testimonial 3 -->
            <div class="card p-8">
                <div class="flex items-center mb-6">
                    <div class="text-primary-600">
                        <!-- 5 Stars -->
                        <div class="flex">
                            <?php for ($i = 0; $i < 5; $i++): ?>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
                <blockquote class="text-gray-600 mb-6">"Evelyn transformed our brand's communication strategy completely. Her integrated approach to PR and digital communications increased our brand visibility by 300% and established us as thought leaders in our industry. She's a strategic communicator with exceptional execution skills."</blockquote>
                <div class="flex items-center">
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/testimonial-3.jpg' ); ?>" alt="Lisa Rodriguez" class="w-12 h-12 rounded-full object-cover mr-4">
                    <div>
                        <p class="font-medium">Lisa Rodriguez</p>
                        <p class="text-sm text-gray-500">VP Marketing, EcoSolutions Inc.</p>
                    </div>
                </div>
            </div>

            <!-- Testimonial 4 -->
            <div class="card p-8">
                <div class="flex items-center mb-6">
                    <div class="text-primary-600">
                        <!-- 5 Stars -->
                        <div class="flex">
                            <?php for ($i = 0; $i < 5; $i++): ?>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
                <blockquote class="text-gray-600 mb-6">"Working with Evelyn was a game-changer for our product launch. Her media relations expertise and strategic storytelling secured coverage in top-tier publications and generated massive buzz. The campaign exceeded all our KPIs and set a new standard for our future launches."</blockquote>
                <div class="flex items-center">
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/testimonial-4.jpg' ); ?>" alt="James Wilson" class="w-12 h-12 rounded-full object-cover mr-4">
                    <div>
                        <p class="font-medium">James Wilson</p>
                        <p class="text-sm text-gray-500">Head of Product, FutureTech Labs</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Blog Section -->
<section id="blog" class="section bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <span class="inline-block text-sm font-semibold text-primary-600 uppercase tracking-wider mb-2">Blog</span>
            <h2 class="heading-lg mb-6">Latest Articles</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Insights, tutorials, and updates from my blog.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php
            // Get the latest 3 blog posts
            $args = array(
                'post_type'      => 'post',
                'posts_per_page' => 3,
                'orderby'        => 'date',
                'order'          => 'DESC',
            );
            
            $latest_posts = new WP_Query( $args );
            
            if ( $latest_posts->have_posts() ) :
                while ( $latest_posts->have_posts() ) :
                    $latest_posts->the_post();
            ?>
                <article class="card transform transition-all duration-300 hover:-translate-y-1">
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
                                echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" class="inline-block text-xs font-medium text-primary-600 bg-primary-50 px-2.5 py-0.5 rounded-full">' . esc_html( $category->name ) . '</a>';
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
                            <?php the_excerpt(); ?>
                        </div>
                        
                        <a href="<?php the_permalink(); ?>" class="text-primary-600 hover:underline inline-flex items-center font-medium">
                            Read More
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                </article>
            <?php
                endwhile;
                wp_reset_postdata();
            else:
            ?>
                <div class="col-span-1 md:col-span-3 text-center p-8 bg-gray-50 rounded-lg">
                    <p>No blog posts found. <a href="<?php echo admin_url('post-new.php'); ?>" class="text-primary-600">Create your first post</a>.</p>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="text-center mt-12">
            <a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>" class="btn btn-primary">View All Posts</a>
        </div>
    </div>
</section>

<!-- Contact Section with Newsletter -->
<section id="contact" class="section bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <span class="inline-block text-sm font-semibold text-primary-600 uppercase tracking-wider mb-2">Contact</span>
            <h2 class="heading-lg mb-6">Get In Touch</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Have a project in mind or just want to say hello? Feel free to reach out!</p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            <!-- Contact Form -->
            <div class="card p-8">
                <h3 class="heading-md mb-6">Send Me a Message</h3>
                
                <form class="space-y-4" action="#" method="post">
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
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </div>
                </form>
            </div>
            
            <!-- Newsletter and Contact Info -->
            <div class="space-y-8">
                <!-- Newsletter Signup -->
                <div class="card p-8 bg-gradient-to-br from-primary-600 to-primary-700 text-white">
                    <h3 class="heading-md text-white mb-4">Subscribe to My Newsletter</h3>
                    <p class="mb-6">Stay updated with my latest projects, articles, and insights. No spam, just valuable content.</p>
                    
                    <form class="space-y-4" action="#" method="post">
                        <div>
                            <label for="newsletter-email" class="sr-only">Email</label>
                            <input type="email" id="newsletter-email" name="email" placeholder="Enter your email" class="w-full px-4 py-3 border-0 rounded-md focus:ring-2 focus:ring-white text-gray-900" required>
                        </div>
                        
                        <button type="submit" class="w-full py-3 bg-white text-primary-600 font-medium rounded-md hover:bg-gray-100 transition-colors">
                            Subscribe Now
                        </button>
                    </form>
                </div>
                
                <!-- Contact Information -->
                <div class="card p-8">
                    <h3 class="heading-md mb-6">Contact Information</h3>
                    
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
