<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
 * @package digitale-pracht
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

$comments_no = get_comments_number();
$comments_closed = ! comments_open() && post_type_supports( get_post_type(), 'comments' );
$comments_closed_and_has_comments = $comments_closed && $comments_no > 0;
$comments_closed_and_has_no_comments = $comments_closed && $comments_no === 0;

if ( $comments_closed_and_has_no_comments !== true ) : ?>

	<div id="comments" class="comments-area<?php echo $comments_no > 0 ? " has-comments" : " has-no-comments"; ?> no-print">

		<?php if ( have_comments() ) : ?>
			<h2 class="comments-title">
				<?php printf(
					esc_html( _n( 'One comment', '%d comments', $comments_no, 'digitale-pracht' ) ),
					number_format_i18n( $comments_no )
				); ?>
			</h2>

			<ol class="comment-list">
				<?php
				wp_list_comments( array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 56,
				) );
				?>
			</ol><!-- .comment-list -->

			<?php the_comments_navigation(); ?>

		<?php endif; // have_comments()

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( $comments_closed_and_has_comments === true ) : ?>
			<p class="no-comments"><?php _e( 'Comments are closed.', 'digitale-pracht' ); ?></p>
		<?php
		endif;

		comment_form( array(
			'title_reply'          => __( 'Leave a Reply', 'digitale-pracht' ),
			'title_reply_to'       => __( 'Leave a Reply to %s', 'digitale-pracht' ),
			'comment_notes_before' => '<p class="comment-notes"><span id="email-notes">' . __( 'Your email address will not be published.', 'digitale-pracht' ) . '</span> '  . __( 'Required fields are marked. <span class="required">*</span>', 'digitale-pracht' ) . '</p>',
		) );
		?>

	</div><!-- .comments-area -->

<?php endif; ?>
