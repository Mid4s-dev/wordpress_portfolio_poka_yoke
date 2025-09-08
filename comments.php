<?php
/**
 * The template for displaying comments
 *
 * @package Portfolio
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password,
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title text-xl font-semibold mb-8">
			<?php
			$portfolio_comment_count = get_comments_number();
			if ( '1' === $portfolio_comment_count ) {
				printf(
					/* translators: 1: title. */
					esc_html__( 'One comment on "%1$s"', 'portfolio' ),
					'<span>' . wp_kses_post( get_the_title() ) . '</span>'
				);
			} else {
				printf( 
					/* translators: 1: comment count number, 2: title. */
					esc_html( _nx( '%1$s comment on "%2$s"', '%1$s comments on "%2$s"', $portfolio_comment_count, 'comments title', 'portfolio' ) ),
					number_format_i18n( $portfolio_comment_count ),
					'<span>' . wp_kses_post( get_the_title() ) . '</span>'
				);
			}
			?>
		</h2>

		<?php the_comments_navigation(); ?>

		<ol class="comment-list space-y-6 mb-8">
			<?php
			wp_list_comments(
				array(
					'style'       => 'ol',
					'short_ping'  => true,
                    'avatar_size' => 60,
                    'callback'    => 'portfolio_comment_callback',
				)
			);
			?>
		</ol>

		<?php
		the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note.
		if ( ! comments_open() ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'portfolio' ); ?></p>
			<?php
		endif;

	endif; // Check for have_comments().

    // Custom comment form
    $portfolio_comment_form_args = array(
        'title_reply'          => esc_html__( 'Leave a Comment', 'portfolio' ),
        'title_reply_before'   => '<h3 id="reply-title" class="comment-reply-title text-xl font-semibold mb-4">',
        'title_reply_after'    => '</h3>',
        'class_form'           => 'comment-form space-y-4',
        'comment_notes_before' => '<p class="comment-notes text-gray-600">' . esc_html__( 'Your email address will not be published.', 'portfolio' ) . '</p>',
        'comment_field'        => '<div class="comment-form-comment">
                                     <label for="comment" class="block text-sm font-medium text-gray-700 mb-1">' . esc_html__( 'Comment', 'portfolio' ) . '</label>
                                     <textarea id="comment" name="comment" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500" rows="5" required></textarea>
                                   </div>',
        'fields'               => array(
            'author' => '<div class="comment-form-author">
                         <label for="author" class="block text-sm font-medium text-gray-700 mb-1">' . esc_html__( 'Name', 'portfolio' ) . ' <span class="required">*</span></label>
                         <input id="author" name="author" type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" required />
                       </div>',
            'email'  => '<div class="comment-form-email">
                         <label for="email" class="block text-sm font-medium text-gray-700 mb-1">' . esc_html__( 'Email', 'portfolio' ) . ' <span class="required">*</span></label>
                         <input id="email" name="email" type="email" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" required />
                       </div>',
            'url'    => '<div class="comment-form-url">
                         <label for="url" class="block text-sm font-medium text-gray-700 mb-1">' . esc_html__( 'Website', 'portfolio' ) . '</label>
                         <input id="url" name="url" type="url" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" />
                       </div>',
        ),
        'class_submit'         => 'btn btn-primary py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500',
        'submit_button'        => '<input name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s" />',
    );
    
    comment_form( $portfolio_comment_form_args );
	?>

</div><!-- #comments -->
