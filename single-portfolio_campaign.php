<?php
/**
 * The template for displaying single campaign
 *
 * @package Portfolio
 */

get_header();

// Get campaign meta
$url = get_post_meta(get_the_ID(), '_campaign_url', true);
$date = get_post_meta(get_the_ID(), '_campaign_date', true);
$platform = get_post_meta(get_the_ID(), '_campaign_platform', true);
$embed_code = get_post_meta(get_the_ID(), '_campaign_embed_code', true);

$formatted_date = !empty($date) ? date_i18n(get_option('date_format'), strtotime($date)) : '';

// Get platform icon class
$platform_icon = '';
switch ($platform) {
    case 'linkedin':
        $platform_icon = 'dashicons-linkedin';
        break;
    case 'instagram':
        $platform_icon = 'dashicons-instagram';
        break;
    case 'twitter':
        $platform_icon = 'dashicons-twitter';
        break;
    case 'project':
        $platform_icon = 'dashicons-portfolio';
        break;
    case 'campaign':
        $platform_icon = 'dashicons-megaphone';
        break;
    default:
        $platform_icon = 'dashicons-admin-links';
}
?>

<main id="primary" class="site-main">
    <div class="container mx-auto px-4 py-12">
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-lg overflow-hidden shadow-lg'); ?>>
                <header class="entry-header p-6 bg-gradient-to-r from-primary-500 to-primary-600 text-white">
                    <div class="container mx-auto">
                        <h1 class="entry-title text-3xl font-bold mb-4"><?php the_title(); ?></h1>
                        
                        <div class="entry-meta flex flex-wrap items-center gap-4 text-white text-opacity-90">
                            <?php if (!empty($platform)) : ?>
                                <span class="campaign-platform flex items-center">
                                    <span class="dashicons <?php echo esc_attr($platform_icon); ?> mr-1"></span>
                                    <?php echo esc_html(ucfirst($platform)); ?>
                                </span>
                            <?php endif; ?>
                            
                            <?php if (!empty($formatted_date)) : ?>
                                <span class="campaign-date flex items-center">
                                    <span class="dashicons dashicons-calendar-alt mr-1"></span>
                                    <?php echo esc_html($formatted_date); ?>
                                </span>
                            <?php endif; ?>
                            
                            <?php
                            // Get campaign types
                            $campaign_types = get_the_terms(get_the_ID(), 'campaign_type');
                            if (!empty($campaign_types) && !is_wp_error($campaign_types)) :
                            ?>
                                <span class="campaign-type flex items-center">
                                    <span class="dashicons dashicons-tag mr-1"></span>
                                    <?php
                                    $type_names = array();
                                    foreach ($campaign_types as $type) {
                                        $type_names[] = $type->name;
                                    }
                                    echo esc_html(implode(', ', $type_names));
                                    ?>
                                </span>
                            <?php endif; ?>
                            
                            <?php if (!empty($url)) : ?>
                                <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener" class="campaign-link flex items-center bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full px-4 py-1 transition">
                                    <span class="dashicons dashicons-external mr-1"></span>
                                    <?php _e('View Original', 'portfolio'); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </header>

                <div class="entry-content p-6">
                    <?php if (!empty($embed_code)) : ?>
                        <div class="campaign-embed mb-8 max-w-4xl mx-auto">
                            <?php echo wp_kses_post($embed_code); ?>
                        </div>
                    <?php elseif (has_post_thumbnail()) : ?>
                        <div class="campaign-featured-image mb-8 max-w-4xl mx-auto">
                            <?php the_post_thumbnail('large', array('class' => 'rounded-lg shadow')); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="campaign-content prose prose-lg max-w-4xl mx-auto">
                        <?php the_content(); ?>
                    </div>
                </div>

                <footer class="entry-footer p-6 bg-gray-50 border-t">
                    <div class="flex justify-between items-center">
                        <div class="campaign-navigation">
                            <?php
                            $prev_post = get_previous_post();
                            $next_post = get_next_post();
                            ?>
                            
                            <?php if (!empty($prev_post)) : ?>
                                <a href="<?php echo esc_url(get_permalink($prev_post)); ?>" class="inline-flex items-center mr-4 text-gray-600 hover:text-primary-500">
                                    <span class="dashicons dashicons-arrow-left-alt2 mr-1"></span>
                                    <?php _e('Previous', 'portfolio'); ?>
                                </a>
                            <?php endif; ?>
                            
                            <?php if (!empty($next_post)) : ?>
                                <a href="<?php echo esc_url(get_permalink($next_post)); ?>" class="inline-flex items-center text-gray-600 hover:text-primary-500">
                                    <?php _e('Next', 'portfolio'); ?>
                                    <span class="dashicons dashicons-arrow-right-alt2 ml-1"></span>
                                </a>
                            <?php endif; ?>
                        </div>
                        
                        <a href="<?php echo esc_url(get_post_type_archive_link('portfolio_campaign')); ?>" class="inline-flex items-center text-gray-600 hover:text-primary-500">
                            <span class="dashicons dashicons-grid-view mr-1"></span>
                            <?php _e('All Campaigns', 'portfolio'); ?>
                        </a>
                    </div>
                </footer>
            </article>
            
            <?php
            // Get related campaigns (same campaign type)
            $campaign_types = wp_get_post_terms(get_the_ID(), 'campaign_type', array('fields' => 'ids'));
            
            if (!empty($campaign_types) && !is_wp_error($campaign_types)) {
                $related_args = array(
                    'post_type' => 'portfolio_campaign',
                    'post__not_in' => array(get_the_ID()),
                    'posts_per_page' => 3,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'campaign_type',
                            'field' => 'term_id',
                            'terms' => $campaign_types,
                        ),
                    ),
                );
                
                $related_campaigns = new WP_Query($related_args);
                
                if ($related_campaigns->have_posts()) :
                ?>
                    <div class="related-campaigns mt-12">
                        <h2 class="text-2xl font-bold mb-6"><?php _e('Related Campaigns', 'portfolio'); ?></h2>
                        
                        <div class="portfolio-campaigns-grid">
                            <?php while ($related_campaigns->have_posts()) : $related_campaigns->the_post(); 
                                $rel_url = get_post_meta(get_the_ID(), '_campaign_url', true);
                                $rel_date = get_post_meta(get_the_ID(), '_campaign_date', true);
                                $rel_platform = get_post_meta(get_the_ID(), '_campaign_platform', true);
                                $rel_embed_code = get_post_meta(get_the_ID(), '_campaign_embed_code', true);
                                
                                $rel_formatted_date = !empty($rel_date) ? date_i18n(get_option('date_format'), strtotime($rel_date)) : '';
                                
                                // Get platform icon
                                $rel_platform_icon = '';
                                switch ($rel_platform) {
                                    case 'linkedin':
                                        $rel_platform_icon = 'dashicons-linkedin';
                                        break;
                                    case 'instagram':
                                        $rel_platform_icon = 'dashicons-instagram';
                                        break;
                                    case 'twitter':
                                        $rel_platform_icon = 'dashicons-twitter';
                                        break;
                                    case 'project':
                                        $rel_platform_icon = 'dashicons-portfolio';
                                        break;
                                    case 'campaign':
                                        $rel_platform_icon = 'dashicons-megaphone';
                                        break;
                                    default:
                                        $rel_platform_icon = 'dashicons-admin-links';
                                }
                            ?>
                                <div class="portfolio-campaign-item">
                                    <div class="portfolio-campaign-content">
                                        <div class="portfolio-campaign-preview">
                                            <?php if (has_post_thumbnail()) : ?>
                                                <div class="portfolio-campaign-thumbnail">
                                                    <a href="<?php the_permalink(); ?>">
                                                        <?php the_post_thumbnail('medium'); ?>
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <div class="portfolio-campaign-excerpt">
                                                <h3 class="portfolio-campaign-title">
                                                    <a href="<?php the_permalink(); ?>">
                                                        <?php the_title(); ?>
                                                    </a>
                                                </h3>
                                                
                                                <?php the_excerpt(); ?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="portfolio-campaign-meta">
                                        <?php if (!empty($rel_platform_icon)) : ?>
                                            <span class="portfolio-campaign-platform">
                                                <span class="dashicons <?php echo esc_attr($rel_platform_icon); ?>"></span>
                                                <?php echo esc_html(ucfirst($rel_platform)); ?>
                                            </span>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($rel_formatted_date)) : ?>
                                            <span class="portfolio-campaign-date">
                                                <span class="dashicons dashicons-calendar-alt"></span>
                                                <?php echo esc_html($rel_formatted_date); ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                <?php
                endif;
                wp_reset_postdata();
            }
            ?>
            
        <?php endwhile; ?>
    </div>
</main>

<?php
get_footer();
