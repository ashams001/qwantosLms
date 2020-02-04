<?php
/**
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$course     = LP()->global['course'];
$viewable   = learn_press_user_can_view_lesson( $item->ID, $course->id );
$tag        = $viewable ? 'a' : 'span';
$target     = $viewable ? 'target="' . apply_filters( 'learn_press_section_item_link_target', '_blank', $item ) . '"' : '';
$item_title = apply_filters( 'learn_press_section_item_title', get_the_title( $item->ID ), $item );
$item_link  = $viewable ? 'href="' . $course->get_item_link( $item->ID ) . '"' : '';
$time       = thim_duration_time_calculator( $item->ID, 'lp_lesson' );

?>

<li <?php learn_press_course_item_class( $item->ID ); ?> data-type="<?php echo esc_attr( $item->post_type ); ?>">
	<?php
	do_action( 'learn_press_before_section_item_title', $item, $section, $course, 1 );

	do_action( 'learn_press_course_lesson_quiz_before_title', $item );

	echo '<' . esc_attr( $tag ) . ' class="course-item-title button-load-item" ' . esc_attr( $target ) . ' ' . esc_url( $item_link ) . ' data-id="' . esc_attr( $item->ID ) . '" data-complete-nonce="' . wp_create_nonce( 'learn-press-complete-' . $item->post_type . '-' . $item->ID ) . '">' . esc_html( $item_title ) . '</' . esc_attr( $tag ) . '>';
	if ( $time ) {
		echo '<span class="time">' . esc_html( $time ) . '</span>';
	}

	do_action( 'learn_press_after_section_item_title', $item, $section, $course );
	?>
</li>
