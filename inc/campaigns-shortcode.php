<?php

/**
 * Get platform icon
 * 
 * @param string $platform The platform name
 * @return string Dashicon class for the platform
 */
function get_platform_icon($platform) {
    switch ($platform) {
        case 'linkedin':
            return 'dashicons-linkedin';
        case 'instagram':
            return 'dashicons-instagram';
        case 'twitter':
            return 'dashicons-twitter';
        case 'project':
            return 'dashicons-portfolio';
        case 'campaign':
            return 'dashicons-megaphone';
        default:
            return 'dashicons-admin-links';
    }
}

/**
 * Full implementation of the campaigns shortcode function
 */
function campaigns_shortcode($atts) {
    $atts = shortcode_atts(array(
        'count'    => 6,
        'type'     => '',
        'platform' => '',
        'orderby'  => 'date',
        'order'    => 'DESC',
        'layout'   => 'grid', // grid or carousel
    ), $atts);
    
    $args = array(
        'post_type'      => 'portfolio_campaign',
        'posts_per_page' => intval($atts['count']),
        'orderby'        => $atts['orderby'],
        'order'          => $atts['order'],
    );
    
    // Add taxonomy query if type is specified
    if (!empty($atts['type'])) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'campaign_type',
                'field'    => 'slug',
                'terms'    => explode(',', $atts['type']),
            ),
        );
    }
    
    // Add meta query if platform is specified
    if (!empty($atts['platform'])) {
        $args['meta_query'] = array(
            array(
                'key'     => '_campaign_platform',
                'value'   => explode(',', $atts['platform']),
                'compare' => 'IN',
            ),
        );
    }
    
    $campaigns = new WP_Query($args);
    
    if (!$campaigns->have_posts()) {
        return '<div class="portfolio-campaigns-empty">' . __('No campaigns or projects found.', 'portfolio') . '</div>';
    }
    
    ob_start();
    
    // Check if we're using carousel layout
    if ($atts['layout'] === 'carousel') {
        ?>
        <div class="campaigns-carousel">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php while ($campaigns->have_posts()) : $campaigns->the_post(); 
                        $url = get_post_meta(get_the_ID(), '_campaign_url', true);
                        $date = get_post_meta(get_the_ID(), '_campaign_date', true);
                        $platform = get_post_meta(get_the_ID(), '_campaign_platform', true);
                        $embed_code = get_post_meta(get_the_ID(), '_campaign_embed_code', true);
                        
                        $formatted_date = !empty($date) ? date_i18n(get_option('date_format'), strtotime($date)) : '';
                        $platform_icon = get_platform_icon($platform);
                    ?>
                        <div class="swiper-slide">
                            <div class="portfolio-campaign-item">
                                <?php if (!empty($embed_code)) : ?>
                                    <div class="portfolio-campaign-embed">
                                        <?php echo wp_kses_post($embed_code); ?>
                                    </div>
                                <?php else : ?>
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
                                <?php endif; ?>
                                
                                <div class="portfolio-campaign-content">
                                    <h3 class="portfolio-campaign-title">
                                        <?php if (!empty($url)) : ?>
                                            <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener">
                                                <?php the_title(); ?>
                                            </a>
                                        <?php else : ?>
                                            <?php the_title(); ?>
                                        <?php endif; ?>
                                    </h3>
                                    
                                    <div class="portfolio-campaign-excerpt">
                                        <?php echo wp_trim_words(get_the_excerpt(), 15); ?>
                                    </div>
                                    
                                    <div class="portfolio-campaign-meta">
                                        <?php if (!empty($platform)) : ?>
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
                                    
                                    <?php if (!empty($url)) : ?>
                                        <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener" class="portfolio-campaign-link">
                                            <span class="dashicons dashicons-external"></span> View Campaign
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
                
                <!-- Add pagination -->
                <div class="swiper-pagination"></div>
                
                <!-- Navigation arrows -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
        <?php
    } else {
        // Standard grid layout
        ?>
        <div class="portfolio-campaigns-container">
            <div class="portfolio-campaigns-grid">
                <?php while ($campaigns->have_posts()) : $campaigns->the_post(); ?>
                    <?php
                    $url = get_post_meta(get_the_ID(), '_campaign_url', true);
                    $date = get_post_meta(get_the_ID(), '_campaign_date', true);
                    $platform = get_post_meta(get_the_ID(), '_campaign_platform', true);
                    $embed_code = get_post_meta(get_the_ID(), '_campaign_embed_code', true);
                    
                    $formatted_date = !empty($date) ? date_i18n(get_option('date_format'), strtotime($date)) : '';
                    $platform_icon = get_platform_icon($platform);
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
                                                <span class="dashicons dashicons-external"></span> View Campaign
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <div class="portfolio-campaign-meta">
                                <?php if (!empty($platform)) : ?>
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
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
        <?php
    }
    
    wp_reset_postdata();
    
    return ob_get_clean();
}
