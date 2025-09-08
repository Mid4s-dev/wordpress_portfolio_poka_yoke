<?php
/**
 * Main template file
 *
 * @package WordPress
 * @subpackage Portfolio
 * @since Portfolio 1.0
 */

get_header();
?>

<div class="container mx-auto px-4 py-12 md:py-16">
    <div class="max-w-5xl mx-auto">
        <?php if ( is_home() && ! is_front_page() ) : ?>
            <header class="page-header text-center mb-12">
                <h1 class="heading-lg text-gray-900 mb-4"><?php single_post_title(); ?></h1>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    <?php 
                    if (get_the_archive_description()) {
                        echo get_the_archive_description();
                    } else {
                        esc_html_e('Explore our latest articles, insights, and stories.', 'portfolio');
                    }
                    ?>
                </p>
            </header>
        <?php elseif ( is_archive() ) : ?>
            <header class="page-header text-center mb-12">
                <h1 class="heading-lg text-gray-900 mb-4"><?php the_archive_title(); ?></h1>
                <?php if ( the_archive_description() ) : ?>
                    <div class="archive-description text-lg text-gray-600 max-w-3xl mx-auto">
                        <?php the_archive_description(); ?>
                    </div>
                <?php endif; ?>
            </header>
        <?php endif; ?>

        <?php if ( have_posts() ) : ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php
                while ( have_posts() ) :
                    the_post();
                ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'card transform transition-all duration-300 hover:-translate-y-1' ); ?>>
                        <?php if ( has_post_thumbnail() ) : ?>
                            <a href="<?php the_permalink(); ?>" class="block overflow-hidden">
                                <?php the_post_thumbnail( 'medium_large', array( 'class' => 'w-full h-48 md:h-56 object-cover transition-transform duration-500 hover:scale-105' ) ); ?>
                            </a>
                        <?php endif; ?>

                        <div class="card-content">
                            <!-- Categories -->
                            <div class="post-categories mb-2 flex flex-wrap gap-2">
                                <?php
                                $categories = get_the_category();
                                if ( $categories ) {
                                    foreach ( $categories as $category ) {
                                        echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" class="inline-block text-xs font-medium text-primary-600 bg-primary-50 px-2.5 py-0.5 rounded-full hover:bg-primary-100 transition-colors">' . esc_html( $category->name ) . '</a>';
                                    }
                                }
                                ?>
                            </div>

                            <!-- Title -->
                            <h2 class="entry-title heading-sm text-gray-900 mb-3">
                                <a href="<?php the_permalink(); ?>" class="hover:text-primary-600 transition-colors"><?php the_title(); ?></a>
                            </h2>

                            <!-- Meta -->
                            <div class="post-meta text-sm text-gray-500 mb-4 flex items-center">
                                <?php if ( get_avatar( get_the_author_meta( 'ID' ) ) ) : ?>
                                    <div class="author-avatar mr-2">
                                        <?php echo get_avatar( get_the_author_meta( 'ID' ), 24, '', '', array('class' => 'rounded-full') ); ?>
                                    </div>
                                <?php endif; ?>
                                <span>
                                    <?php
                                    printf(
                                        esc_html__( 'By %s', 'portfolio' ),
                                        '<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" class="font-medium hover:text-primary-600 transition-colors">' . esc_html( get_the_author() ) . '</a>'
                                    );
                                    ?>
                                </span>
                                <span class="mx-2">•</span>
                                <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                                    <?php echo esc_html( get_the_date() ); ?>
                                </time>
                            </div>

                            <!-- Excerpt -->
                            <div class="entry-summary text-gray-600">
                                <?php the_excerpt(); ?>
                            </div>

                            <div class="mt-4">
                                <a href="<?php the_permalink(); ?>" class="btn btn-sm btn-outline">
                                    <?php esc_html_e( 'Read More', 'portfolio' ); ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </article>
                <?php
                endwhile;
                ?>
            </div>

            <div class="pagination mt-12 flex justify-center">
                <?php
                the_posts_pagination(
                    array(
                        'mid_size'  => 2,
                        'prev_text' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>',
                        'next_text' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>',
                        'screen_reader_text' => __('Posts navigation', 'portfolio'),
                        'class' => 'flex items-center justify-center gap-2',
                    )
                );
                ?>
            </div>
        <?php else : ?>
            <div class="no-results bg-gray-50 p-8 rounded-lg text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h2 class="text-xl font-bold mb-3 text-gray-900"><?php esc_html_e( 'Nothing Found', 'portfolio' ); ?></h2>
                <p class="text-gray-600 mb-6"><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'portfolio' ); ?></p>
                
                <div class="max-w-md mx-auto">
                    <?php get_search_form(); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
get_footer();
