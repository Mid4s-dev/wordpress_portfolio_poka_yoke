<?php
/**
 * Template part for displaying the Projects section with Maasai styling
 *
 * @package WordPress
 * @subpackage Portfolio
 */
?>

<section id="projects" class="py-16 bg-white relative">
    <div class="absolute top-0 left-0 right-0 h-3 from-shuka-red to-shuka-yellow bg-shuka-pattern"></div>

    <div class="container mx-auto px-4">
        <h2 class="text-3xl md:text-4xl font-bold mb-12 text-center section-title">Featured Projects</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <!-- Project 1: Offensive Security -->
            <div id="js-project-1" class="rounded-lg overflow-hidden shadow-lg transition-transform hover:shadow-xl hover:-translate-y-2 bg-white project-card">
                <div class="relative flex items-center justify-center h-48 overflow-hidden bg-shuka-red">
                    <div class="absolute top-0 left-0 w-full h-full opacity-20 from-shuka-red to-shuka-black bg-shuka-pattern"></div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-white relative z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-3 text-shuka-red">Offensive Security Labs</h3>
                    <p class="mb-4 text-gray-700">Completed Kioptrix series, Brainpan lab, 30+ TryHackMe rooms, BSides Nairobi & university hackathons.</p>
                    <div class="mt-4">
                        <span class="block mb-2 text-sm font-medium text-shuka-black">Skills applied:</span>
                        <div class="flex flex-wrap gap-2">
                            <span class="skill-badge">Enumeration</span>
                            <span class="skill-badge">Privilege Escalation</span>
                            <span class="skill-badge">Buffer Overflow</span>
                            <span class="skill-badge">Reverse Shells</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Project 2: Full-Stack Development -->
            <div id="js-project-2" class="rounded-lg overflow-hidden shadow-lg transition-transform hover:shadow-xl hover:-translate-y-2 bg-white project-card">
                <div class="relative flex items-center justify-center h-48 overflow-hidden bg-shuka-blue">
                    <div class="absolute top-0 left-0 w-full h-full opacity-20 from-shuka-blue to-shuka-black bg-shuka-pattern"></div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-white relative z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                    </svg>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-3 text-shuka-blue">Full-Stack Application Development</h3>
                    <p class="mb-4 text-gray-700">Built applications using Laravel, Django, React, and WordPress with secure authentication systems and RESTful APIs.</p>
                    <div class="mt-4">
                        <span class="block mb-2 text-sm font-medium text-shuka-black">Technologies used:</span>
                        <div class="flex flex-wrap gap-2">
                            <span class="skill-badge alt-1">Laravel</span>
                            <span class="skill-badge alt-1">Django</span>
                            <span class="skill-badge alt-1">React</span>
                            <span class="skill-badge alt-1">WordPress</span>
                            <span class="skill-badge alt-1">REST APIs</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Project 3: IT Infrastructure -->
            <div id="js-project-3" class="rounded-lg overflow-hidden shadow-lg transition-transform hover:shadow-xl hover:-translate-y-2 bg-white project-card">
                <div class="relative flex items-center justify-center h-48 overflow-hidden bg-shuka-earth">
                    <div class="absolute top-0 left-0 w-full h-full opacity-20 from-shuka-earth to-shuka-black bg-shuka-pattern"></div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-white relative z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                    </svg>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-3 text-shuka-earth">SME & Home IT Infrastructure</h3>
                    <p class="mb-4 text-gray-700">Installed secure Wi-Fi, firewalls, VPNs, CCTV; provided cybersecurity training and OS hardening.</p>
                    <div class="mt-4">
                        <span class="block mb-2 text-sm font-medium text-shuka-black">Services provided:</span>
                        <div class="flex flex-wrap gap-2">
                            <span class="skill-badge alt-3">Secure Networking</span>
                            <span class="skill-badge alt-3">Firewall Config</span>
                            <span class="skill-badge alt-3">VPN Setup</span>
                            <span class="skill-badge alt-3">OS Hardening</span>
                            <span class="skill-badge alt-3">Security Training</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-12 text-center">
            <a href="<?php echo esc_url(portfolio_get_campaigns_page_url()); ?>" class="shuka-button bg-shuka-red hover:bg-shuka-red-600 inline-block">
                View All Projects
            </a>
        </div>
    </div>
    
    <div class="absolute bottom-0 left-0 right-0 h-3 from-shuka-black to-shuka-red bg-shuka-pattern"></div>
</section>
