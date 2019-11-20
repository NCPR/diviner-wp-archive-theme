<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) :
		?>
		<div class="h3 comments__title">
			<?php
			$comments_number = get_comments_number();
			if ( '1' === $comments_number ) {
				printf(
					/* translators: %s: post title */
					esc_html_x(
						'One Reply to &ldquo;%s&rdquo;',
						'comments title',
						'diviner-archive'
					),
					// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					get_the_title()
				);
			} else {
				printf(
					/* translators: 1: number of comments, 2: post title */
					// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped, WordPress.WP.I18n.MissingTranslatorsComment
					_nx(
						'%1$s Reply to &ldquo;%2$s&rdquo;',
						'%1$s Replies to &ldquo;%2$s&rdquo;',
						$comments_number,
						'comments title',
						'diviner-archive'
					),
					// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					number_format_i18n( $comments_number ),
					// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					get_the_title()
				);
			}
			?>
		</div>

		<ol class="comment__list">
			<?php
				wp_list_comments(
					array(
						'avatar_size' => 100,
						'max_depth'   => 5,
						'style'       => 'ol',
						'short_ping'  => true,
						'reply_text'  => __( 'Reply', 'diviner-archive' ),
					)
				);
			?>
		</ol>

		<?php
		the_comments_pagination(
			array(
				'prev_text' => '<span class="a11y-visual-hide">' . __( 'Previous', 'diviner-archive' ) . '</span>',
				'next_text' => '<span class="a11y-visual-hide">' . __( 'Next', 'diviner-archive' ) . '</span>',
			)
		);

	endif; // Check for have_comments().

	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>

		<p class="comments__none"><?php esc_html_e( 'Comments are closed.', 'diviner-archive' ); ?></p>
		<?php
	endif;

	comment_form([
		'title_reply_before' => '<div id="reply-title" class="h3 comment-reply-title">',
		'title_reply_after' => '</div>'
	]);
	?>

</div><!-- #comments -->
