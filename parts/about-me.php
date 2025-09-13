<?php
/**
 * Template part for displaying the About Me section with Maasai styling
 *
 * @package WordPress
 * @subpackage Portfolio
 */
?>

<section id="about-me" class="py-16 bg-shuka-beige relative">
    <div class="absolute top-0 left-0 right-0 h-3 from-shuka-red to-shuka-black bg-shuka-pattern"></div>
    
    <div class="container mx-auto px-4">
        <h2 class="text-3xl md:text-4xl font-bold mb-12 text-center section-title">About Me</h2>
        
        <div class="flex flex-col md:flex-row items-center">
            <div class="md:w-1/3 mb-8 md:mb-0">
                <div class="profile-image-wrapper rounded-lg overflow-hidden mx-auto max-w-xs">
                    <?php
                    $about_image = portfolio_get_about_image();
                    if (!empty($about_image)) :
                    ?>
                        <img src="<?php echo esc_url($about_image); ?>" alt="<?php echo esc_attr(portfolio_get_owner_name()); ?>" class="profile-image w-full h-auto">
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="md:w-2/3 md:pl-12">
                <div id="js-about-card" class="p-8 shuka-card">
                    <h3 class="text-2xl font-bold mb-6 text-shuka-red"><?php echo esc_html(portfolio_get_owner_name()); ?></h3>
                    
                    <div class="mb-8">
                        <p class="text-gray-800 mb-4">Motivated and highly adaptable tech professional with a strong foundation in cybersecurity, cloud infrastructure, and full-stack development. I've contributed to digital transformation projects at eMobilis and the Ministry of Lands, as well as programs like Cyber Shujaa and AWS Restart.</p>
                        
                        <p class="text-gray-800 mb-4">With expertise in offensive security labs, CTFs, and real-world application deployments, I bring a comprehensive skill set that spans programming, web development, cloud services, and security tools. My experience includes coordinating tech initiatives, providing IT support, and building secure, scalable systems.</p>
                        
                        <p class="text-gray-800">My career vision is to become a leading cybersecurity and technology solutions architect in Africa, building secure, scalable systems that empower businesses and communities.</p>
                    </div>
                    
                    <div class="flex flex-col md:flex-row flex-wrap border-t border-gray-200 pt-6 mt-6">
                        <div class="w-full md:w-1/2 mb-6 md:mb-0">
                            <h4 class="text-lg font-semibold mb-3 flex items-center text-shuka-earth">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                    <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                                </svg>
                                Education
                            </h4>
                            <div class="pl-7">
                                <p class="font-semibold">BSc. Information Security & Forensics</p>
                                <p class="text-gray-700">KCA University (Expected Jul 2025)</p>
                                <p class="text-gray-700">Second Upper Class</p>
                            </div>
                        </div>
                        
                        <div class="w-full md:w-1/2">
                            <h4 class="text-lg font-semibold mb-3 flex items-center text-shuka-earth">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                Contact Information
                            </h4>
                            <div class="pl-7">
                                <p class="mb-2">
                                    <a href="mailto:lugayajoshua@gmail.com" class="text-shuka-blue hover:text-shuka-red transition-colors flex items-center">
                                        <span class="dashicons dashicons-email-alt mr-2"></span>
                                        lugayajoshua@gmail.com
                                    </a>
                                </p>
                                <p>
                                    <a href="tel:+254723352139" class="text-shuka-blue hover:text-shuka-red transition-colors flex items-center">
                                        <span class="dashicons dashicons-phone mr-2"></span>
                                        +254 723 352 139
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="absolute bottom-0 left-0 right-0 h-3 from-shuka-red to-shuka-black bg-shuka-pattern"></div>
</section>
