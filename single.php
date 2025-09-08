<?php
/**
 * Template for displaying single posts
 *
 * @package Portfolio
 */

get_header();
?>

<div class="container mx-auto px-4 py-12 md:py-16">
    <div class="max-w-4xl mx-auto">
        <?php
        while ( have_posts() ) :
            the_post();
        ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('blog-single-post'); ?>>
                <!-- Post Header -->
                <header class="post-header mb-8">
                    <!-- Categories -->
                    <div class="post-categories mb-3">
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
                    <h1 class="post-title text-3xl md:text-4xl font-bold mb-4"><?php the_title(); ?></h1>

                    <!-- Meta -->
                    <div class="post-meta flex flex-wrap items-center text-gray-600 mb-6">
                        <!-- Author -->
                        <div class="flex items-center mr-6 mb-2">
                            <?php
                            $author_id = get_the_author_meta( 'ID' );
                            $avatar = get_avatar( $author_id, 32 );
                            if ( $avatar ) {
                                echo '<div class="w-8 h-8 rounded-full overflow-hidden mr-2">' . $avatar . '</div>';
                            }
                            ?>
                            <span>
                                <?php 
                                printf(
                                    esc_html__( 'By %s', 'portfolio' ),
                                    '<a href="' . esc_url( get_author_posts_url( $author_id ) ) . '" class="font-medium hover:text-primary-600 transition-colors">' . esc_html( get_the_author() ) . '</a>'
                                );
                                ?>
                            </span>
                        </div>
                        
                        <!-- Date -->
                        <div class="mr-6 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                                <?php echo esc_html( get_the_date() ); ?>
                            </time>
                        </div>
                        
                        <!-- Comments -->
                        <?php if ( comments_open() || get_comments_number() ) : ?>
                        <div class="mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                            </svg>
                            <a href="#comments">
                                <?php
                                printf(
                                    _nx(
                                        '%1$s Comment',
                                        '%1$s Comments',
                                        get_comments_number(),
                                        'comments title',
                                        'portfolio'
                                    ),
                                    number_format_i18n( get_comments_number() )
                                );
                                ?>
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                </header>

                <!-- Featured Image -->
                <?php if ( has_post_thumbnail() ) : ?>
                <div class="featured-image mb-8 rounded-lg overflow-hidden shadow-lg">
                    <?php the_post_thumbnail( 'large', array( 'class' => 'w-full h-auto' ) ); ?>
                </div>
                <?php endif; ?>

                <!-- Content -->
                <div class="post-content prose prose-lg max-w-none mb-10">
                    <?php 
                    the_content();
                    
                    wp_link_pages(
                        array(
                            'before' => '<div class="page-links mt-4 pt-4 border-t">' . esc_html__( 'Pages:', 'portfolio' ),
                            'after'  => '</div>',
                        )
                    );
                    ?>
                </div>

                <!-- Tags -->
                <?php if ( has_tag() ) : ?>
                <div class="post-tags mb-10">
                    <h4 class="text-lg font-semibold mb-2"><?php esc_html_e( 'Tags:', 'portfolio' ); ?></h4>
                    <div class="flex flex-wrap gap-2">
                        <?php
                        $tags = get_the_tags();
                        foreach ( $tags as $tag ) {
                            echo '<a href="' . esc_url( get_tag_link( $tag->term_id ) ) . '" class="inline-block bg-gray-100 hover:bg-gray-200 transition-colors px-3 py-1 rounded-full text-sm">' . esc_html( $tag->name ) . '</a>';
                        }
                        ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Author Box -->
                <div class="author-box bg-gray-50 p-6 rounded-lg mb-10">
                    <div class="flex items-center">
                        <?php
                        $author_id = get_the_author_meta( 'ID' );
                        $avatar = get_avatar( $author_id, 80 );
                        if ( $avatar ) {
                            echo '<div class="w-20 h-20 rounded-full overflow-hidden mr-4">' . $avatar . '</div>';
                        }
                        ?>
                        <div>
                            <h4 class="text-lg font-semibold">
                                <?php echo esc_html( get_the_author_meta( 'display_name' ) ); ?>
                            </h4>
                            <?php if ( get_the_author_meta( 'description' ) ) : ?>
                            <p class="text-gray-600 mt-2"><?php echo esc_html( get_the_author_meta( 'description' ) ); ?></p>
                            <?php endif; ?>
                            <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="inline-block mt-2 text-primary-600 hover:underline">
                                <?php
                                printf(
                                    esc_html__( 'View all posts by %s', 'portfolio' ),
                                    get_the_author()
                                );
                                ?>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Post Navigation -->
                <nav class="post-navigation border-t border-b py-6 mb-10">
                    <div class="flex flex-wrap justify-between">
                        <?php
                        $prev_post = get_previous_post();
                        if ( ! empty( $prev_post ) ) :
                        ?>
                        <div class="w-full md:w-1/2 md:pr-4 mb-4 md:mb-0">
                            <span class="block text-sm text-gray-500 mb-1"><?php esc_html_e( 'Previous Post', 'portfolio' ); ?></span>
                            <a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>" class="block font-medium hover:text-primary-600 transition-colors">
                                <?php echo esc_html( get_the_title( $prev_post->ID ) ); ?>
                            </a>
                        </div>
                        <?php
                        endif;
                        
                        $next_post = get_next_post();
                        if ( ! empty( $next_post ) ) :
                        ?>
                        <div class="w-full md:w-1/2 md:pl-4 text-left md:text-right">
                            <span class="block text-sm text-gray-500 mb-1"><?php esc_html_e( 'Next Post', 'portfolio' ); ?></span>
                            <a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>" class="block font-medium hover:text-primary-600 transition-colors">
                                <?php echo esc_html( get_the_title( $next_post->ID ) ); ?>
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                </nav>

                <!-- Related Posts -->
                <?php
                // Get current post categories
                $categories = get_the_category();
                $category_ids = array();
                foreach ( $categories as $category ) {
                    $category_ids[] = $category->term_id;
                }
                
                if ( ! empty( $category_ids ) ) :
                    // Query related posts
                    $related_args = array(
                        'post_type'      => 'post',
                        'posts_per_page' => 3,
                        'post__not_in'   => array( get_the_ID() ),
                        'category__in'   => $category_ids,
                    );
                    
                    $related_query = new WP_Query( $related_args );
                    
                    if ( $related_query->have_posts() ) :
                ?>
                <div class="related-posts mb-10">
                    <h3 class="text-xl font-semibold mb-6"><?php esc_html_e( 'Related Posts', 'portfolio' ); ?></h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <?php
                        while ( $related_query->have_posts() ) :
                            $related_query->the_post();
                        ?>
                        <div class="related-post bg-white rounded-lg overflow-hidden shadow-md transition-transform hover:-translate-y-1">
                            <?php if ( has_post_thumbnail() ) : ?>
                            <a href="<?php the_permalink(); ?>" class="block">
                                <?php the_post_thumbnail( 'medium', array( 'class' => 'w-full h-40 object-cover' ) ); ?>
                            </a>
                            <?php endif; ?>
                            <div class="p-4">
                                <h4 class="font-semibold text-lg mb-2">
                                    <a href="<?php the_permalink(); ?>" class="hover:text-primary-600 transition-colors">
                                        <?php the_title(); ?>
                                    </a>
                                </h4>
                                <div class="text-sm text-gray-600">
                                    <?php echo get_the_date(); ?>
                                </div>
                            </div>
                        </div>
                        <?php
                        endwhile;
                        wp_reset_postdata();
                        ?>
                    </div>
                </div>
                <?php
                    endif;
                endif;
                ?>

                <!-- Comments -->
                <?php
                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;
                ?>
            </article>
        <?php
        endwhile;
        ?>
    </div>
</div>

<?php
get_footer();
