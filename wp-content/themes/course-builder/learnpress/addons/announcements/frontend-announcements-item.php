<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$announcement_id = $announcement->ID;
$title           = $announcement->post_title;
$before_title    = '<h4 class="thim-title">';
$after_title     = '</h4>';
$before_content  = '<div class="lp-announcement-content">';
$content         = $announcement->post_content;
$after_content   = '</div>';
$link            = learn_press_user_profile_link( get_the_author_meta( 'ID' ) );
if ( empty( $title ) ) {
	$title = esc_attr__( 'No Title', 'course-builder' );
}

if ( empty( $content ) ) {
	$content = esc_attr__( 'No Content', 'course-builder' );
}
?>
<div id="lp-announcement-<?php echo esc_attr( $announcement_id ); ?>" class="lp-announcement-item">
	<div class="author">
		<a href="<?php echo esc_url( $link ); ?>" class="img-avatar">
			<?php echo get_avatar( get_the_author_meta( 'ID' ), 58 ); ?>
		</a>
		<div class="info">
			<span class="name">
				<a href="<?php echo esc_url( $link ); ?>">
					<?php echo get_the_author(); ?>
				</a>
			</span>
			<span class="time">
			<?php echo esc_html__( 'Posted an announcement - ', 'course-builder' ) . get_the_date( get_option( 'date_format' ), $announcement_id ); ?>
				<span class="ion-flag"></span>
		</span>
		</div>
	</div>
	<?php
	apply_filters( 'learnpress-announcements-before-title-item', $before_title );
	apply_filters( 'learnpress-announcements-title-item', $title );
	apply_filters( 'learnpress-announcements-after-title-item', $after_title );

	echo( $before_title );
	echo wp_kses_post( $title );
	echo( $after_title );

	apply_filters( 'learnpress-announcements-before-content-item', $before_content );
	apply_filters( 'learnpress-announcements-content-item', $content );
	apply_filters( 'learnpress-announcements-after-content-item', $after_content );

	echo( $before_content );
	?>

	<div class="lp-announcement-wrap-content">
		<?php echo wp_kses_post( $content ); ?>
	</div>

	<?php

	$comment_open = comments_open( $announcement_id );
	if ( $comment_open ) {
		learn_press_announcements_template( 'frontend-comments.php', array( 'announcement_id' => $announcement_id ) );
	} else {
		echo apply_filters( 'lp_announcement_hide_comments', esc_attr__( '<p> Comments is closed </p>', 'course-builder' ) );
	}

	echo ($after_content);

	?>
</div>



