<?php
/**
 * Template Name: Blog Page
 * Template Post Type: page
 *
 * @package Portfolio
 */

get_header();
?>

<div class="container mx-auto px-4 py-12 md:py-16">
    <div class="max-w-5xl mx-auto">
        <header class="page-header text-center mb-12">
            <h1 class="page-title text-3xl md:text-4xl font-bold mb-4"><?php the_title(); ?></h1>
            
            <?php if ( has_excerpt() ) : ?>
                <div class="page-description max-w-3xl mx-auto text-gray-600">
                    <?php the_excerpt(); ?>
                </div>
            <?php endif; ?>
        </header>

        <?php
        // Set up a custom query for blog posts
        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
        $blog_args = array(
            'post_type'      => 'post',
            'posts_per_page' => get_option( 'posts_per_page' ),
            'paged'          => $paged,
        );

        $blog_query = new WP_Query( $blog_args );

        if ( $blog_query->have_posts() ) :
        ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php
                while ( $blog_query->have_posts() ) :
                    $blog_query->the_post();
                ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-card bg-white rounded-lg overflow-hidden shadow-md transition-all hover:-translate-y-1 hover:shadow-lg' ); ?>>
                        <?php if ( has_post_thumbnail() ) : ?>
                            <a href="<?php the_permalink(); ?>" class="block">
                                <?php the_post_thumbnail( 'medium_large', array( 'class' => 'w-full h-48 md:h-56 object-cover' ) ); ?>
                            </a>
                        <?php endif; ?>

                        <div class="p-6">
                            <!-- Categories -->
                            <div class="post-categories mb-2">
                                <?php
                                $categories = get_the_category();
                                if ( $categories ) {
                                    echo '<span class="inline-block text-sm font-medium text-primary-600">';
                                    foreach ( $categories as $index => $category ) {
                                        echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a>';
                                        if ( $index < count( $categories ) - 1 ) {
                                            echo ', ';
                                        }
                                    }
                                    echo '</span>';
                                }
                                ?>
                            </div>

                            <!-- Title -->
                            <h2 class="entry-title text-xl font-bold mb-3">
                                <a href="<?php the_permalink(); ?>" class="hover:text-primary-600 transition-colors"><?php the_title(); ?></a>
                            </h2>

                            <!-- Meta -->
                            <div class="post-meta text-sm text-gray-600 mb-4">
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
                                <a href="<?php the_permalink(); ?>" class="inline-flex items-center text-primary-600 font-medium hover:underline">
                                    <?php esc_html_e( 'Read More', 'portfolio' ); ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                $big = 999999999; // need an unlikely integer
                echo paginate_links(
                    array(
                        'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                        'format'    => '?paged=%#%',
                        'current'   => max( 1, get_query_var( 'paged' ) ),
                        'total'     => $blog_query->max_num_pages,
                        'prev_text' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>',
                        'next_text' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>',
                    )
                );
                ?>
            </div>
        <?php
        else :
        ?>
            <div class="no-results bg-gray-50 p-8 rounded-lg text-center">
                <h2 class="text-xl font-bold mb-3"><?php esc_html_e( 'No Posts Found', 'portfolio' ); ?></h2>
                <p class="text-gray-600"><?php esc_html_e( 'It seems there are no posts published yet.', 'portfolio' ); ?></p>
            </div>
        <?php
        endif;
        wp_reset_postdata();
        ?>
    </div>
</div>

<?php
get_footer();
