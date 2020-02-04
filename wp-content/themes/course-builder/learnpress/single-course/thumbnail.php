<?php
/**
 * Template for displaying the thumbnail of a course
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 2.0.6
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $post;
$course      = learn_press_get_course();
$user        = learn_press_get_current_user();
$video_embed = $course->get_video_embed();
$video_intro = get_post_meta( get_the_ID(), 'thim_course_media', true );
$thim_course_page = LP()->settings->get( 'single_course_image_size' );
$width            = !empty ( $thim_course_page['width'] ) ? $thim_course_page['width'] : 1022;
$height           = !empty ( $thim_course_page['height'] ) ? $thim_course_page['height'] : 608;
if ( $video_embed ):
	?>
	<div class="course-video">
		<?php echo esc_attr( $video_embed ); ?>
	</div>
	<?php
endif;
if ( ! has_post_thumbnail() || $video_embed ) {
	return;
}
?>
<div class="course-thumbnail">
	<?php
	$image_title   = get_the_title( get_post_thumbnail_id() ) ? esc_attr( get_the_title( get_post_thumbnail_id() ) ) : '';
	$image_caption = get_post( get_post_thumbnail_id() ) ? esc_attr( get_post( get_post_thumbnail_id() )->post_excerpt ) : '""';
	$image_link    = wp_get_attachment_url( get_post_thumbnail_id() );
	$image_crop    = thim_aq_resize( $image_link, $width, $height, true );
	$image         = '<img src="' .esc_url($image_crop).  '" alt="'. esc_attr($image_title) .'" title="'. esc_attr($image_title) .'" />';

	?>
	<?php
	if ( $user->has_course_status( $course->id, array(
			'enrolled',
			'finished'
		) ) || ! $course->is_require_enrollment()
	) {
		thim_thumbnail( $course->id, '647x399', 'post', false );
	} else {
		echo( $image );
	}
	?>
	<?php if ( $video_intro ) : ?>
		<a href="<?php echo esc_url( $video_intro ); ?>" class="play-button video-thumbnail">
			<span class="video-thumbnail hvr-push"></span>
		</a>
	<?php endif; ?>
	<div class="time">
		<div class="date-start"><?php echo get_the_date( 'd' ); ?></div>
		<div class="month-start"><?php echo get_the_date( 'M' ); ?></div>
	</div>
</div>
