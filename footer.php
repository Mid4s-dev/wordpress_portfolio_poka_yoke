    </div><!-- #content -->

    <!-- Newsletter Section before footer -->
    <section class="bg-primary-600 text-white py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="text-3xl font-bold mb-6"><?php esc_html_e( 'Stay Updated', 'portfolio' ); ?></h2>
                <p class="text-lg mb-8 text-primary-100"><?php esc_html_e( 'Subscribe to my newsletter for the latest updates, articles, and resources.', 'portfolio' ); ?></p>
                <form id="newsletter-form" class="flex flex-col md:flex-row gap-3 max-w-lg mx-auto">
                    <input type="email" name="newsletter_email" placeholder="<?php esc_attr_e( 'Your email address', 'portfolio' ); ?>" required 
                        class="flex-grow px-4 py-3 rounded-md border-2 border-primary-400 focus:border-white bg-primary-700 text-white placeholder-primary-300 focus:outline-none">
                    <button type="submit" class="bg-white text-primary-600 hover:bg-primary-50 px-6 py-3 rounded-md font-medium transition-colors">
                        <?php esc_html_e( 'Subscribe', 'portfolio' ); ?>
                    </button>
                </form>
                <div id="newsletter-response" class="mt-4 hidden"></div>
            </div>
        </div>
    </section>

    <footer id="colophon" class="site-footer bg-gradient-to-r from-primary-900 to-primary-800 text-white py-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="footer-heading text-xl font-bold mb-6 text-white border-b border-primary-600 pb-2"><?php esc_html_e( 'About', 'portfolio' ); ?></h3>
                    <p class="mb-6 text-primary-100"><?php echo get_bloginfo( 'description' ); ?></p>
                    
                    <?php if ( has_custom_logo() ) : ?>
                        <div class="w-32 bg-white p-2 rounded-lg">
                            <?php the_custom_logo(); ?>
                        </div>
                    <?php else : ?>
                        <h4 class="text-xl font-bold text-white">
                            <?php bloginfo( 'name' ); ?>
                        </h4>
                    <?php endif; ?>
                </div>
                
                <div>
                    <h3 class="footer-heading text-xl font-bold mb-6 text-white border-b border-primary-600 pb-2"><?php esc_html_e( 'Navigation', 'portfolio' ); ?></h3>
                    <div class="footer-links flex flex-col space-y-3">
                        <a href="#about" class="text-primary-100 hover:text-white transition-colors flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            <?php esc_html_e( 'About', 'portfolio' ); ?>
                        </a>
                        <a href="#services" class="text-primary-100 hover:text-white transition-colors flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            <?php esc_html_e( 'Services', 'portfolio' ); ?>
                        </a>
                        <a href="#portfolio" class="text-primary-100 hover:text-white transition-colors flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            <?php esc_html_e( 'Portfolio', 'portfolio' ); ?>
                        </a>
                        <a href="#blog" class="text-primary-100 hover:text-white transition-colors flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            <?php esc_html_e( 'Blog', 'portfolio' ); ?>
                        </a>
                        <a href="#contact" class="text-primary-100 hover:text-white transition-colors flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            <?php esc_html_e( 'Contact', 'portfolio' ); ?>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h3 class="footer-heading text-xl font-bold mb-6 text-white border-b border-primary-600 pb-2"><?php esc_html_e( 'Services', 'portfolio' ); ?></h3>
                    <div class="footer-links flex flex-col space-y-3">
                        <a href="#" class="text-primary-100 hover:text-white transition-colors flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                            <?php esc_html_e( 'Web Development', 'portfolio' ); ?>
                        </a>
                        <a href="#" class="text-primary-100 hover:text-white transition-colors flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect><line x1="12" y1="18" x2="12" y2="18"></line></svg>
                            <?php esc_html_e( 'App Development', 'portfolio' ); ?>
                        </a>
                        <a href="#" class="text-primary-100 hover:text-white transition-colors flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M16.24 7.76a6 6 0 0 1-8.49 8.48"></path><path d="M12 18v-2"></path><path d="M12 8V6"></path></svg>
                            <?php esc_html_e( 'UI/UX Design', 'portfolio' ); ?>
                        </a>
                        <a href="#" class="text-primary-100 hover:text-white transition-colors flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            <?php esc_html_e( 'SEO Optimization', 'portfolio' ); ?>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h3 class="footer-heading text-xl font-bold mb-6 text-white border-b border-primary-600 pb-2"><?php esc_html_e( 'Connect', 'portfolio' ); ?></h3>
                    <div class="footer-social flex gap-3 mb-6">
                        <a href="#" aria-label="Facebook" class="p-3 rounded-md bg-primary-700 hover:bg-primary-600 text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                        </a>
                        <a href="#" aria-label="Twitter" class="p-3 rounded-md bg-primary-700 hover:bg-primary-600 text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>
                        </a>
                        <a href="#" aria-label="Instagram" class="p-3 rounded-md bg-primary-700 hover:bg-primary-600 text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                        </a>
                        <a href="#" aria-label="LinkedIn" class="p-3 rounded-md bg-primary-700 hover:bg-primary-600 text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle></svg>
                        </a>
                    </div>
                    
                    <address class="not-italic text-primary-100">
                        <div class="flex items-center gap-2 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                            <a href="mailto:info@example.com" class="hover:text-white transition-colors">info@example.com</a>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                            <a href="tel:+1234567890" class="hover:text-white transition-colors">(123) 456-7890</a>
                        </div>
                    </address>
                </div>
            </div>
            
            <div class="footer-bottom mt-12 pt-6 border-t border-primary-700 text-center text-primary-200">
                <p>&copy; <?php echo date_i18n( 'Y' ); ?> <?php echo get_bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'portfolio' ); ?></p>
            </div>
        </div>
    </footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
