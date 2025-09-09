<?php
/**
 * Recent Campaigns & Projects Pattern
 * 
 * @package Portfolio
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>

<div class="portfolio-section portfolio-campaigns-section">
    <div class="container mx-auto px-4 py-16">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold mb-4"><?php _e('Recent Campaigns & Projects', 'portfolio'); ?></h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto"><?php _e('Check out my latest work, social media posts, and professional activities', 'portfolio'); ?></p>
        </div>
        
        <div class="campaigns-wrapper">
            <?php echo do_shortcode('[portfolio_campaigns count="6" orderby="date" order="DESC"]'); ?>
        </div>
        
        <div class="text-center mt-8">
            <a href="<?php echo esc_url(portfolio_get_campaigns_page_url()); ?>" class="inline-block px-6 py-3 bg-primary-500 text-white font-semibold rounded-lg hover:bg-primary-600 transition duration-300 ease-in-out">
                <?php _e('View All Campaigns & Projects', 'portfolio'); ?>
            </a>
        </div>
    </div>
</div>
