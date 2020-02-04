<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
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

global $post, $wp_query;

$current_user = wp_get_current_user();
$user_id      = $current_user->ID;

?>
<div id="comments" class="comments-area">
	<div class="list-comments">
		<?php if ( get_comments_number() ) { ?>
			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through  ?>
				<nav id="comment-nav-above" class="comment-navigation" role="navigation">
					<h1 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'course-builder' ); ?></h1>
					<div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'course-builder' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'course-builder' ) ); ?></div>
				</nav><!-- #comment-nav-above -->
			<?php endif; // check for comment navigation  ?>

			<ul class="comment-list">
				<?php
				$comments = get_comments( 'post_id=' . $post->ID );
				wp_list_comments( 'type=comment&callback=thim_comment_single_course', $comments ); ?>
			</ul>

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through  ?>
				<nav id="comment-nav-below" class="comment-navigation" role="navigation">
					<h1 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'course-builder' ); ?></h1>
					<div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'course-builder' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'course-builder' ) ); ?></div>
				</nav><!-- #comment-nav-below -->
			<?php endif; // check for comment navigation  ?>

		<?php } else {
			echo '<p class="no_comment">';
			echo esc_html__( 'No comments yet! You be the first to comment.', 'course-builder' );
			echo '</p>';
		} // have_comments() ?>
		<?php if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'course-builder' ); ?></p>
		<?php endif; ?>
	</div>
	<div class="form-comment">
		<?php comment_form( array(
			'comment_field' => '<p class="comment-form-comment"><textarea placeholder="' . esc_attr__( 'Enter your comment', 'course-builder' ) . '" id="comment" name="comment" cols="45" rows="8" aria-required="true">' . '</textarea></p>'
		) );
		?>
		<?php do_action('comment_form_course')?>
	</div>
</div><!-- #comments -->