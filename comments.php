<?php

if ( post_password_required() ) {
	return;
}

require_once ARTS_THEME_PATH . '/inc/classes/class-arts-walker-comment.php';

?>


<div id="comments" class="comments-area">
	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) :
		?>
		<h4 class="comments-title">
			<?php
			$comments_number = get_comments_number();
			if ( '1' === $comments_number ) {
				$output = sprintf( '%1$s %2$s', $comments_number, esc_html__( 'Comment', 'rubenz' ) );
				echo esc_html( $output );
			} else {
				$output = sprintf( '%1$s %2$s', $comments_number, esc_html__( 'Comments', 'rubenz' ) );
				echo esc_html( $output );
			}
			?>
		</h4>

		<ol class="comment-list">
			<?php
				wp_list_comments(
					array(
						'avatar_size' => 80,
						'style'       => 'ol',
						'short_ping'  => true,
						'walker'      => new Arts_Walker_Comment(),
					)
				);
			?>
		</ol>

		<?php
		the_comments_pagination();

	endif; // Check for have_comments().

	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>

		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'rubenz' ); ?></p>
		<?php
	endif;

	comment_form(
		array(
			'title_reply_before' => '<h4 id="reply-title" class="comment-reply-title">',
			'title_reply_after'  => '</h4>',
		)
	);
	?>
</div><!-- #comments -->
