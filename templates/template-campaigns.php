<?php
/**
 * Template Name: Campaigns & Projects Showcase
 * 
 * A custom template for showcasing all campaigns with additional features
 * 
 * @package Portfolio
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container mx-auto px-4 py-12">
        <header class="page-header text-center mb-12">
            <h1 class="page-title text-4xl font-bold"><?php the_title(); ?></h1>
            <?php if (get_the_content()) : ?>
                <div class="page-description mt-4 text-xl text-gray-600 max-w-3xl mx-auto">
                    <?php the_content(); ?>
                </div>
            <?php else : ?>
                <div class="page-description mt-4 text-xl text-gray-600 max-w-3xl mx-auto">
                    <p><?php _e('Browse all my recent campaigns, projects, and social media posts.', 'portfolio'); ?></p>
                </div>
            <?php endif; ?>
        </header>

        <!-- Campaigns Filter Controls -->
        <div class="campaigns-filter mb-8">
            <form id="campaign-filters" class="flex flex-wrap gap-4 justify-center" method="get">
                <div class="filter-group">
                    <label for="platform-filter" class="mr-2 font-medium"><?php _e('Platform:', 'portfolio'); ?></label>
                    <select name="platform" id="platform-filter" class="rounded border-gray-300 focus:border-primary-500 focus:ring focus:ring-primary-200">
                        <option value=""><?php _e('All Platforms', 'portfolio'); ?></option>
                        <option value="linkedin" <?php selected(isset($_GET['platform']) && $_GET['platform'] === 'linkedin'); ?>><?php _e('LinkedIn', 'portfolio'); ?></option>
                        <option value="instagram" <?php selected(isset($_GET['platform']) && $_GET['platform'] === 'instagram'); ?>><?php _e('Instagram', 'portfolio'); ?></option>
                        <option value="twitter" <?php selected(isset($_GET['platform']) && $_GET['platform'] === 'twitter'); ?>><?php _e('Twitter', 'portfolio'); ?></option>
                        <option value="project" <?php selected(isset($_GET['platform']) && $_GET['platform'] === 'project'); ?>><?php _e('Project', 'portfolio'); ?></option>
                        <option value="campaign" <?php selected(isset($_GET['platform']) && $_GET['platform'] === 'campaign'); ?>><?php _e('Campaign', 'portfolio'); ?></option>
                    </select>
                </div>
                
                <?php 
                $types = get_terms(array(
                    'taxonomy' => 'campaign_type',
                    'hide_empty' => true,
                ));
                
                if (!empty($types) && !is_wp_error($types)) : ?>
                    <div class="filter-group">
                        <label for="type-filter" class="mr-2 font-medium"><?php _e('Type:', 'portfolio'); ?></label>
                        <select name="campaign_type" id="type-filter" class="rounded border-gray-300 focus:border-primary-500 focus:ring focus:ring-primary-200">
                            <option value=""><?php _e('All Types', 'portfolio'); ?></option>
                            <?php foreach ($types as $type) : ?>
                                <option value="<?php echo esc_attr($type->slug); ?>" <?php selected(isset($_GET['campaign_type']) && $_GET['campaign_type'] === $type->slug); ?>><?php echo esc_html($type->name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endif; ?>
                
                <div class="filter-group">
                    <button type="submit" class="px-4 py-2 bg-primary-500 text-white rounded hover:bg-primary-600 transition"><?php _e('Filter', 'portfolio'); ?></button>
                    <?php if (isset($_GET['platform']) || isset($_GET['campaign_type'])) : ?>
                        <a href="<?php echo esc_url(get_permalink()); ?>" class="ml-2 px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition"><?php _e('Reset', 'portfolio'); ?></a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <?php
        // Build query args based on filters
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        
        $args = array(
            'post_type' => 'portfolio_campaign',
            'posts_per_page' => 12,
            'paged' => $paged,
        );
        
        // Add platform filter
        if (isset($_GET['platform']) && !empty($_GET['platform'])) {
            $args['meta_query'] = array(
                array(
                    'key' => '_campaign_platform',
                    'value' => sanitize_text_field($_GET['platform']),
                    'compare' => '=',
                ),
            );
        }
        
        // Add campaign type filter
        if (isset($_GET['campaign_type']) && !empty($_GET['campaign_type'])) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'campaign_type',
                    'field' => 'slug',
                    'terms' => sanitize_text_field($_GET['campaign_type']),
                ),
            );
        }
        
        // Run the query
        $campaigns_query = new WP_Query($args);
        ?>

        <?php if ($campaigns_query->have_posts()) : ?>
            <!-- Featured Campaigns Section -->
            <?php if ($paged == 1 && !isset($_GET['platform']) && !isset($_GET['campaign_type'])) : ?>
                <?php
                // Get featured campaigns (marked with a "Featured" tag or category)
                $featured_args = array(
                    'post_type' => 'portfolio_campaign',
                    'posts_per_page' => 1,
                    'meta_query' => array(
                        array(
                            'key' => '_campaign_featured',
                            'value' => '1',
                            'compare' => '=',
                        ),
                    ),
                );
                
                $featured_campaigns = new WP_Query($featured_args);
                
                if ($featured_campaigns->have_posts()) :
                    while ($featured_campaigns->have_posts()) : $featured_campaigns->the_post();
                        // Get campaign meta
                        $url = get_post_meta(get_the_ID(), '_campaign_url', true);
                        $platform = get_post_meta(get_the_ID(), '_campaign_platform', true);
                ?>
                    <div class="featured-campaign mb-12">
                        <div class="bg-gradient-to-r from-primary-50 to-primary-100 rounded-xl p-6 md:p-8">
                            <div class="featured-label mb-4">
                                <span class="inline-block bg-primary-500 text-white text-xs font-bold px-3 py-1 rounded-full">
                                    <?php _e('Featured', 'portfolio'); ?>
                                </span>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                                <div class="featured-content order-2 md:order-1">
                                    <h3 class="text-2xl font-bold mb-4"><?php the_title(); ?></h3>
                                    <div class="featured-excerpt text-gray-700 mb-6">
                                        <?php the_excerpt(); ?>
                                    </div>
                                    <div class="featured-meta flex items-center mb-6">
                                        <?php if (!empty($platform)) : 
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
                                            <span class="inline-flex items-center mr-4 text-primary-600">
                                                <span class="dashicons <?php echo esc_attr($platform_icon); ?> mr-1"></span>
                                                <?php echo esc_html(ucfirst($platform)); ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="featured-actions">
                                        <a href="<?php the_permalink(); ?>" class="btn btn-primary mr-3"><?php _e('View Details', 'portfolio'); ?></a>
                                        <?php if (!empty($url)) : ?>
                                            <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener" class="btn btn-outline">
                                                <?php _e('View Original', 'portfolio'); ?>
                                                <span class="screen-reader-text"><?php _e('(opens in a new tab)', 'portfolio'); ?></span>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="featured-image order-1 md:order-2">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="rounded-lg overflow-hidden shadow-lg">
                                            <?php the_post_thumbnail('large', array('class' => 'w-full h-auto')); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            <?php endif; ?>

            <div class="portfolio-campaigns-grid">
                <?php while ($campaigns_query->have_posts()) : $campaigns_query->the_post();
                    // Don't show the featured campaign again in the grid on the first page
                    if ($paged == 1 && !isset($_GET['platform']) && !isset($_GET['campaign_type']) && 
                        get_post_meta(get_the_ID(), '_campaign_featured', true) == '1') {
                        continue;
                    }
                    
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
                    <div class="portfolio-campaign-item">
                        <div class="portfolio-campaign-content">
                            <?php if (!empty($embed_code)) : ?>
                                <div class="portfolio-campaign-embed">
                                    <?php echo wp_kses_post($embed_code); ?>
                                </div>
                            <?php else : ?>
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
                                        
                                        <div class="portfolio-campaign-links">
                                            <a href="<?php the_permalink(); ?>" class="portfolio-campaign-details-link">
                                                <?php _e('View Details', 'portfolio'); ?>
                                            </a>
                                            
                                            <?php if (!empty($url)) : ?>
                                                <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener" class="portfolio-campaign-link">
                                                    <?php _e('View Original', 'portfolio'); ?> <span class="screen-reader-text"><?php _e('(opens in a new tab)', 'portfolio'); ?></span>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="portfolio-campaign-meta">
                            <?php if (!empty($platform_icon)) : ?>
                                <span class="portfolio-campaign-platform">
                                    <span class="dashicons <?php echo esc_attr($platform_icon); ?>"></span>
                                    <?php echo esc_html(ucfirst($platform)); ?>
                                </span>
                            <?php endif; ?>
                            
                            <?php if (!empty($formatted_date)) : ?>
                                <span class="portfolio-campaign-date">
                                    <span class="dashicons dashicons-calendar-alt"></span>
                                    <?php echo esc_html($formatted_date); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
            
            <div class="pagination-container mt-8 flex justify-center">
                <?php
                echo paginate_links(array(
                    'base' => add_query_arg('paged', '%#%'),
                    'format' => '',
                    'current' => max(1, $paged),
                    'total' => $campaigns_query->max_num_pages,
                    'prev_text' => '<span class="dashicons dashicons-arrow-left-alt2"></span> ' . __('Previous', 'portfolio'),
                    'next_text' => __('Next', 'portfolio') . ' <span class="dashicons dashicons-arrow-right-alt2"></span>',
                ));
                ?>
            </div>
            
        <?php else : ?>
            <div class="no-campaigns text-center py-12 bg-gray-50 rounded-lg">
                <div class="dashicons dashicons-portfolio text-5xl text-gray-400 mx-auto mb-4"></div>
                <h2 class="text-2xl font-medium text-gray-600 mb-2"><?php _e('No Campaigns Found', 'portfolio'); ?></h2>
                <p class="text-gray-500 mb-6"><?php _e('No campaigns or projects match your filter criteria.', 'portfolio'); ?></p>
                <?php if (isset($_GET['platform']) || isset($_GET['campaign_type'])) : ?>
                    <a href="<?php echo esc_url(get_permalink()); ?>" class="inline-block px-5 py-3 bg-primary-500 text-white font-medium rounded-lg hover:bg-primary-600 transition"><?php _e('Reset Filters', 'portfolio'); ?></a>
                <?php elseif (current_user_can('edit_posts')) : ?>
                    <a href="<?php echo esc_url(admin_url('post-new.php?post_type=portfolio_campaign')); ?>" class="inline-block px-5 py-3 bg-primary-500 text-white font-medium rounded-lg hover:bg-primary-600 transition"><?php _e('Add Your First Campaign', 'portfolio'); ?></a>
                <?php endif; ?>
            </div>
        <?php endif; 
        
        wp_reset_postdata();
        ?>
    </div>
</main>

<?php
get_footer();
