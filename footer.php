    </div><!-- #content -->

    <!-- Newsletter Section before footer -->
    <section class="bg-shuka-black text-white py-16 relative">
        <div class="absolute top-0 left-0 right-0 h-3 from-shuka-red to-shuka-yellow bg-shuka-pattern"></div>
        
       
        
        <div class="absolute bottom-0 left-0 right-0 h-3 from-shuka-yellow to-shuka-blue bg-shuka-pattern"></div>
    </section>

    <footer id="colophon" class="site-footer bg-shuka-earth text-white py-16 relative">
        <div class="bg-shuka-pattern-large from-shuka-earth to-shuka-black opacity-20 absolute inset-0"></div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="footer-heading text-xl font-bold mb-6 text-shuka-yellow border-b border-shuka-red/30 pb-2">
                        <?php esc_html_e( 'About', 'portfolio' ); ?>
                    </h3>
                    <p class="mb-6 text-white/80"><?php echo get_bloginfo( 'description' ); ?></p>
                    
                    <?php if ( has_custom_logo() ) : ?>
                        <div class="w-32 bg-white p-2 rounded-lg border border-shuka-yellow/30">
                            <?php the_custom_logo(); ?>
                        </div>
                    <?php else : ?>
                        <h4 class="text-xl font-bold text-shuka-yellow">
                            <?php bloginfo( 'name' ); ?>
                        </h4>
                    <?php endif; ?>
                </div>
                
                <div>
                    <h3 class="footer-heading text-xl font-bold mb-6 text-shuka-yellow border-b border-shuka-red/30 pb-2">
                        <?php esc_html_e( 'Navigation', 'portfolio' ); ?>
                    </h3>
                    <div class="footer-links flex flex-col space-y-3">
                        <a href="#about" class="text-white/80 hover:text-shuka-yellow transition-colors flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            <?php esc_html_e( 'About', 'portfolio' ); ?>
                        </a>
                        <a href="#skills" class="text-white/80 hover:text-shuka-yellow transition-colors flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            <?php esc_html_e( 'Skills', 'portfolio' ); ?>
                        </a>
                        <a href="#experience" class="text-white/80 hover:text-shuka-yellow transition-colors flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            <?php esc_html_e( 'Experience', 'portfolio' ); ?>
                        </a>
                        <a href="#projects" class="text-white/80 hover:text-shuka-yellow transition-colors flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            <?php esc_html_e( 'Projects', 'portfolio' ); ?>
                        </a>
                        <a href="#testimonials" class="text-white/80 hover:text-shuka-yellow transition-colors flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            <?php esc_html_e( 'Testimonials', 'portfolio' ); ?>
                        </a>
                        <a href="#contact" class="text-white/80 hover:text-shuka-yellow transition-colors flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            <?php esc_html_e( 'Contact', 'portfolio' ); ?>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h3 class="footer-heading text-xl font-bold mb-6 text-shuka-yellow border-b border-shuka-red/30 pb-2">
                        <?php esc_html_e( 'Services', 'portfolio' ); ?>
                    </h3>
                    <div class="footer-links flex flex-col space-y-3">
                        <a href="#" class="text-white/80 hover:text-shuka-yellow transition-colors flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                            <?php esc_html_e( 'Web Development', 'portfolio' ); ?>
                        </a>
                        <a href="#" class="text-white/80 hover:text-shuka-yellow transition-colors flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect><line x1="12" y1="18" x2="12" y2="18"></line></svg>
                            <?php esc_html_e( 'Cybersecurity', 'portfolio' ); ?>
                        </a>
                        <a href="#" class="text-white/80 hover:text-shuka-yellow transition-colors flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M16.24 7.76a6 6 0 0 1-8.49 8.48"></path><path d="M12 18v-2"></path><path d="M12 8V6"></path></svg>
                            <?php esc_html_e( 'IT Infrastructure', 'portfolio' ); ?>
                        </a>
                        <a href="#" class="text-white/80 hover:text-shuka-yellow transition-colors flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            <?php esc_html_e( 'Technical Training', 'portfolio' ); ?>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h3 class="footer-heading text-xl font-bold mb-6 text-shuka-yellow border-b border-shuka-red/30 pb-2">
                        <?php esc_html_e( 'Connect', 'portfolio' ); ?>
                    </h3>
                    <div class="footer-social flex gap-3 mb-6">
                        <a href="https://github.com/Mid4s-dev" target="_blank" rel="noopener noreferrer" aria-label="GitHub" 
                           class="p-3 rounded-full bg-shuka-red/20 border border-shuka-red/30 text-shuka-red 
                           hover:bg-shuka-red hover:text-white hover:border-transparent transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path></svg>
                        </a>
                        <a href="https://linkedin.com/in/joshua-lugaya-mid4s-dev" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn" 
                           class="p-3 rounded-full bg-shuka-blue/20 border border-shuka-blue/30 text-shuka-blue 
                           hover:bg-shuka-blue hover:text-white hover:border-transparent transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle></svg>
                        </a>
                        <a href="https://twitter.com/mid4s_dev" target="_blank" rel="noopener noreferrer" aria-label="Twitter" 
                           class="p-3 rounded-full bg-shuka-yellow/20 border border-shuka-yellow/30 text-shuka-yellow 
                           hover:bg-shuka-yellow hover:text-shuka-black hover:border-transparent transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>
                        </a>
                    </div>
                    
                    <address class="not-italic text-white/80">
                        <div class="flex items-start gap-3 mb-3">
                            <div class="p-2 bg-shuka-red/20 border border-shuka-red/30 rounded-full text-shuka-red mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                            </div>
                            <div>
                                <span class="block text-xs text-shuka-red font-bold mb-1">Email</span>
                                <a href="mailto:lugayajoshua@gmail.com" class="hover:text-shuka-yellow transition-colors">lugayajoshua@gmail.com</a>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="p-2 bg-shuka-blue/20 border border-shuka-blue/30 rounded-full text-shuka-blue mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                            </div>
                            <div>
                                <span class="block text-xs text-shuka-blue font-bold mb-1">Phone</span>
                                <a href="tel:+254723352139" class="hover:text-shuka-yellow transition-colors">+254 723 352 139</a>
                            </div>
                        </div>
                    </address>
                </div>
            </div>
            
            <div class="footer-bottom mt-12 pt-6 border-t border-shuka-yellow/20 text-center">
                <p class="text-white/80">&copy; <?php echo date_i18n( 'Y' ); ?> <?php echo get_bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'portfolio' ); ?></p>
            </div>
        </div>
    </footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
