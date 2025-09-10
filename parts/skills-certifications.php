<?php
/**
 * Template part for displaying Skills and Certifications with Maasai styling
 *
 * @package WordPress
 * @subpackage Portfolio
 */
?>

<section id="skills-certifications" class="py-16 bg-white relative">
    <div class="absolute top-0 left-0 right-0 h-3 from-shuka-black to-shuka-red bg-shuka-pattern"></div>
    
    <div class="container mx-auto px-4">
        <h2 class="text-3xl md:text-4xl font-bold mb-12 text-center section-title">Skills & Certifications</h2>
        
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Skills Column -->
            <div class="md:w-1/2">
                <div class="shuka-card p-8 h-full">
                    <h3 class="text-2xl font-bold mb-8 text-shuka-red">Technical Skills</h3>
                    
                    <div class="space-y-8">
                        <!-- Programming Skills -->
                        <div>
                            <h4 class="text-lg font-semibold mb-4 flex items-center text-shuka-earth">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                </svg>
                                Programming & Development
                            </h4>
                            <div class="flex flex-wrap gap-2">
                                <span class="skill-badge">Python</span>
                                <span class="skill-badge">Bash</span>
                                <span class="skill-badge">JavaScript</span>
                                <span class="skill-badge">C++</span>
                                <span class="skill-badge">SQL</span>
                                <span class="skill-badge">Laravel</span>
                                <span class="skill-badge">Django</span>
                                <span class="skill-badge">React</span>
                                <span class="skill-badge">REST APIs</span>
                                <span class="skill-badge">OAuth2</span>
                                <span class="skill-badge">JWT</span>
                            </div>
                        </div>
                        
                        <!-- Cloud Skills -->
                        <div>
                            <h4 class="text-lg font-semibold mb-4 flex items-center text-shuka-earth">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                                </svg>
                                Cloud & Infrastructure
                            </h4>
                            <div class="flex flex-wrap gap-2">
                                <span class="skill-badge alt-1">AWS (EC2, IAM, VPC)</span>
                                <span class="skill-badge alt-1">Google Cloud</span>
                                <span class="skill-badge alt-1">Azure (Basic)</span>
                                <span class="skill-badge alt-1">Linux</span>
                                <span class="skill-badge alt-1">Windows Server</span>
                                <span class="skill-badge alt-1">Terraform</span>
                            </div>
                        </div>
                        
                        <!-- Security Skills -->
                        <div>
                            <h4 class="text-lg font-semibold mb-4 flex items-center text-shuka-earth">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                Cybersecurity
                            </h4>
                            <div class="flex flex-wrap gap-2">
                                <span class="skill-badge alt-2">Burp Suite</span>
                                <span class="skill-badge alt-2">Metasploit</span>
                                <span class="skill-badge alt-2">Wireshark</span>
                                <span class="skill-badge alt-2">Nmap</span>
                                <span class="skill-badge alt-2">Fail2ban</span>
                                <span class="skill-badge alt-2">IDS/IPS</span>
                                <span class="skill-badge alt-2">VPN</span>
                                <span class="skill-badge alt-2">MFA</span>
                            </div>
                        </div>
                        
                        <!-- Soft Skills -->
                        <div>
                            <h4 class="text-lg font-semibold mb-4 flex items-center text-shuka-earth">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Professional Skills
                            </h4>
                            <div class="flex flex-wrap gap-2">
                                <span class="skill-badge alt-3">Documentation</span>
                                <span class="skill-badge alt-3">Risk Reporting</span>
                                <span class="skill-badge alt-3">Collaboration</span>
                                <span class="skill-badge alt-3">User Training</span>
                                <span class="skill-badge alt-3">ISO 27001</span>
                                <span class="skill-badge alt-3">GDPR</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Certifications Column -->
            <div class="md:w-1/2 mt-8 md:mt-0">
                <div class="shuka-card p-8 h-full">
                    <h3 class="text-2xl font-bold mb-8 text-shuka-red">Certifications & Education</h3>
                    
                    <!-- Certifications -->
                    <div class="mb-10">
                        <h4 class="text-lg font-semibold mb-6 flex items-center text-shuka-earth">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                            Professional Certifications
                        </h4>
                        <ul class="space-y-6">
                            <li class="flex items-start bg-shuka-beige p-4 rounded-lg border-l-4 border-shuka-red">
                                <svg class="h-6 w-6 text-shuka-red mr-3 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                <div>
                                    <span class="font-semibold block text-lg">Cyber Shujaa Network Security Analyst</span>
                                    <span class="text-sm text-gray-700">USIU, Sep–Dec 2024</span>
                                </div>
                            </li>
                            <li class="flex items-start bg-shuka-beige p-4 rounded-lg border-l-4 border-shuka-blue">
                                <svg class="h-6 w-6 text-shuka-blue mr-3 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                                </svg>
                                <div>
                                    <span class="font-semibold block text-lg">AWS Certified Cloud Practitioner</span>
                                    <span class="text-sm text-gray-700">Amazon Web Services</span>
                                </div>
                            </li>
                            <li class="flex items-start bg-shuka-beige p-4 rounded-lg border-l-4 border-shuka-yellow">
                                <svg class="h-6 w-6 text-shuka-earth mr-3 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                <div>
                                    <span class="font-semibold block text-lg">Google Cloud Skill Badges</span>
                                    <span class="text-sm text-gray-700">App Dev, Load Balancing, Compute Engine</span>
                                </div>
                            </li>
                            <li class="flex items-start bg-shuka-beige p-4 rounded-lg border-l-4 border-shuka-blue">
                                <svg class="h-6 w-6 text-shuka-blue mr-3 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                </svg>
                                <div>
                                    <span class="font-semibold block text-lg">Cisco Networking Academy Learn-A-Thon</span>
                                    <span class="text-sm text-gray-700">Participant</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Education -->
                    <div>
                        <h4 class="text-lg font-semibold mb-6 flex items-center text-shuka-earth">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                            </svg>
                            Education
                        </h4>
                        <div class="p-6 bg-shuka-beige rounded-lg border-l-6 border-shuka-red">
                            <h5 class="font-bold text-xl text-shuka-black mb-2">BSc. Information Security & Forensics</h5>
                            <p class="text-gray-800 font-medium">KCA University</p>
                            <div class="flex justify-between mt-3 text-sm font-medium">
                                <span class="bg-white px-3 py-1 rounded-full text-shuka-red">Expected July 2025</span>
                                <span class="bg-white px-3 py-1 rounded-full text-shuka-blue">Second Upper Class</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="absolute bottom-0 left-0 right-0 h-3 from-shuka-red to-shuka-black bg-shuka-pattern"></div>
</section>
