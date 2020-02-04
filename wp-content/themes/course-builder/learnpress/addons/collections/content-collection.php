<?php
/**
 * Template for displaying collection content within the loop
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
//learn_press_get_template_part( 'content', 'course' );

?>
<?php do_action( 'learn_press_collections_before_loop_item' ); ?>
	<li class="collection-item">
		<?php
		if ( has_post_thumbnail() ) {
			thim_thumbnail( get_the_ID(), '264x177' );
		}
		?>
		<a class="collection-wrapper" href="<?php echo esc_url( get_the_permalink() ); ?>">
			<?php do_action( 'learn_press_collections_loop_item_title' ); ?>
			<?php Thim_SC_Courses_Collection::course_number( get_the_ID() ); ?>
		</a>
	</li>
<?php //do_action( 'learn_press_collections_after_loop_item' ); ?>