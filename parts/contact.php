<?php
/**
 * Template part for displaying the Contact section with Maasai styling
 *
 * @package WordPress
 * @subpackage Portfolio
 */
?>

<section id="contact" class="py-16 bg-shuka-black text-white relative">
    <div class="absolute top-0 left-0 right-0 h-3 from-shuka-blue to-shuka-yellow bg-shuka-pattern"></div>
    
    <div class="container mx-auto px-4">
        <h2 class="text-3xl md:text-4xl font-bold mb-12 text-center section-title">Get In Touch</h2>
        
        <div class="max-w-5xl mx-auto">
            <div class="flex flex-col md:flex-row gap-8">
                <!-- Contact Information -->
                <div class="md:w-1/2">
                    <div class="bg-black/30 p-6 rounded-lg border border-shuka-yellow/30 mb-8">
                        <h3 class="text-2xl font-bold mb-4 text-shuka-yellow">Contact Information</h3>
                        <p class="text-white/80 mb-6">Feel free to reach out for collaboration opportunities, consultation requests, or to discuss potential projects.</p>
                        
                        <ul class="space-y-6">
                            <li class="flex items-start">
                                <div class="mr-4 p-3 bg-shuka-red rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="block text-sm text-shuka-red font-bold mb-1">Email</span>
                                    <a href="mailto:lugayajoshua@gmail.com" class="text-white hover:text-shuka-yellow transition-colors">lugayajoshua@gmail.com</a>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <div class="mr-4 p-3 bg-shuka-blue rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="block text-sm text-shuka-blue font-bold mb-1">Phone</span>
                                    <a href="tel:+254723352139" class="text-white hover:text-shuka-yellow transition-colors">+254 723 352 139</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Social Media Links -->
                    <div class="bg-black/30 p-6 rounded-lg border border-shuka-yellow/30">
                        <h3 class="text-2xl font-bold mb-4 text-shuka-yellow">Connect With Me</h3>
                        <div class="flex space-x-4">
                            <a href="https://github.com/Mid4s-dev" target="_blank" rel="noopener noreferrer" 
                               class="p-4 bg-shuka-red/20 rounded-full text-shuka-red hover:bg-shuka-red hover:text-white transition-colors">
                                <span class="sr-only">GitHub</span>
                                <svg class="h-8 w-8" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path>
                                </svg>
                            </a>
                            <a href="https://linkedin.com/in/joshua-lugaya-mid4s-dev" target="_blank" rel="noopener noreferrer" 
                               class="p-4 bg-shuka-blue/20 rounded-full text-shuka-blue hover:bg-shuka-blue hover:text-white transition-colors">
                                <span class="sr-only">LinkedIn</span>
                                <svg class="h-8 w-8" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Contact Form -->
                <div class="md:w-1/2">
                    <div class="bg-white/10 backdrop-blur-sm p-6 rounded-lg border border-shuka-yellow/30 shadow-lg">
                        <div class="mb-6 border-b-2 border-shuka-red pb-4">
                            <h3 class="text-2xl font-bold text-shuka-yellow">Send Me a Message</h3>
                        </div>
                        
                        <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
                            <input type="hidden" name="action" value="portfolio_contact_form">
                            <?php wp_nonce_field('portfolio_contact_nonce', 'portfolio_contact_nonce'); ?>
                            
                            <div class="mb-4">
                                <label for="name" class="block text-sm font-medium text-shuka-yellow mb-1">Name</label>
                                <input type="text" id="name" name="name" 
                                    class="w-full px-3 py-2 bg-black/30 border border-shuka-yellow/30 rounded-md 
                                    text-white focus:outline-none focus:ring-2 focus:ring-shuka-yellow/50 focus:border-shuka-yellow/60
                                    placeholder-white/50" required>
                            </div>
                            
                            <div class="mb-4">
                                <label for="email" class="block text-sm font-medium text-shuka-yellow mb-1">Email</label>
                                <input type="email" id="email" name="email" 
                                    class="w-full px-3 py-2 bg-black/30 border border-shuka-yellow/30 rounded-md 
                                    text-white focus:outline-none focus:ring-2 focus:ring-shuka-yellow/50 focus:border-shuka-yellow/60
                                    placeholder-white/50" required>
                            </div>
                            
                            <div class="mb-4">
                                <label for="subject" class="block text-sm font-medium text-shuka-yellow mb-1">Subject</label>
                                <input type="text" id="subject" name="subject" 
                                    class="w-full px-3 py-2 bg-black/30 border border-shuka-yellow/30 rounded-md 
                                    text-white focus:outline-none focus:ring-2 focus:ring-shuka-yellow/50 focus:border-shuka-yellow/60
                                    placeholder-white/50" required>
                            </div>
                            
                            <div class="mb-6">
                                <label for="message" class="block text-sm font-medium text-shuka-yellow mb-1">Message</label>
                                <textarea id="message" name="message" rows="4" 
                                    class="w-full px-3 py-2 bg-black/30 border border-shuka-yellow/30 rounded-md 
                                    text-white focus:outline-none focus:ring-2 focus:ring-shuka-yellow/50 focus:border-shuka-yellow/60
                                    placeholder-white/50" required></textarea>
                            </div>
                            
                            <div class="text-center">
                                <button type="submit" 
                                    class="shuka-button bg-shuka-red hover:bg-shuka-red-600 inline-block w-full">
                                    Send Message
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="absolute bottom-0 left-0 right-0 h-3 from-shuka-yellow to-shuka-blue bg-shuka-pattern"></div>
</section>
