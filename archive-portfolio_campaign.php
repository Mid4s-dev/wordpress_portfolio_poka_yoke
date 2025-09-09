<?php
/**
 * The template for displaying campaigns archive
 *
 * @package Portfolio
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container mx-auto px-4 py-12">
        <header class="page-header text-center mb-12">
            <h1 class="page-title text-4xl font-bold"><?php _e('Campaigns & Projects', 'portfolio'); ?></h1>
            <div class="archive-description mt-4 text-xl text-gray-600 max-w-3xl mx-auto">
                <p><?php _e('Browse all my recent campaigns, projects, and social media posts', 'portfolio'); ?></p>
            </div>
        </header>

        <?php if (have_posts()) : ?>
            <div class="filters-container mb-8">
                <form action="<?php echo esc_url(get_post_type_archive_link('portfolio_campaign')); ?>" method="get" class="flex flex-wrap gap-4 justify-center">
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
                            <a href="<?php echo esc_url(get_post_type_archive_link('portfolio_campaign')); ?>" class="ml-2 px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition"><?php _e('Reset', 'portfolio'); ?></a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
            
            <div class="portfolio-campaigns-grid">
                <?php while (have_posts()) : the_post(); 
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
                                            <?php if (!empty($url)) : ?>
                                                <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener">
                                                    <?php the_post_thumbnail('medium'); ?>
                                                </a>
                                            <?php else : ?>
                                                <?php the_post_thumbnail('medium'); ?>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="portfolio-campaign-excerpt">
                                        <h3 class="portfolio-campaign-title">
                                            <?php if (!empty($url)) : ?>
                                                <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener">
                                                    <?php the_title(); ?>
                                                </a>
                                            <?php else : ?>
                                                <?php the_title(); ?>
                                            <?php endif; ?>
                                        </h3>
                                        
                                        <?php the_excerpt(); ?>
                                        
                                        <?php if (!empty($url)) : ?>
                                            <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener" class="portfolio-campaign-link">
                                                <?php _e('View Original', 'portfolio'); ?> <span class="screen-reader-text"><?php _e('(opens in a new tab)', 'portfolio'); ?></span>
                                            </a>
                                        <?php endif; ?>
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
                    'prev_text' => '<span class="dashicons dashicons-arrow-left-alt2"></span> ' . __('Previous', 'portfolio'),
                    'next_text' => __('Next', 'portfolio') . ' <span class="dashicons dashicons-arrow-right-alt2"></span>',
                ));
                ?>
            </div>
            
        <?php else : ?>
            <div class="no-campaigns text-center py-12 bg-gray-50 rounded-lg">
                <div class="dashicons dashicons-portfolio text-5xl text-gray-400 mx-auto mb-4"></div>
                <h2 class="text-2xl font-medium text-gray-600 mb-2"><?php _e('No Campaigns Found', 'portfolio'); ?></h2>
                <p class="text-gray-500 mb-6"><?php _e('No campaigns or projects have been added yet.', 'portfolio'); ?></p>
                <?php if (current_user_can('edit_posts')) : ?>
                    <a href="<?php echo esc_url(admin_url('post-new.php?post_type=portfolio_campaign')); ?>" class="inline-block px-5 py-3 bg-primary-500 text-white font-medium rounded-lg hover:bg-primary-600 transition"><?php _e('Add Your First Campaign', 'portfolio'); ?></a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php
get_footer();
