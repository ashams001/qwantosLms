<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$course_id       = get_the_ID();
$course_rate_res = learn_press_get_course_rate( $course_id, false );
$course_review   = learn_press_get_course_review( $course_id );
$course_rate     = $course_rate_res['rated'];
$total           = $course_rate_res['total'];
?>
<div class="reviews">
	<div class="average-rating">
		<span class="number-rate"><?php printf( __( ' %1.1f ', 'course-builder' ), $course_rate ); ?></span>
		<?php
		learn_press_course_review_template( 'rating-stars.php', array( 'rated' => $course_rate ) );
		?>
		<p class="review-number">
			<?php do_action( 'learn_press_before_total_review_number' ); ?>

			<?php printf( _n( ' %d rating', '%d rating', $total, 'course-builder' ), $total ); ?>
			<?php do_action( 'learn_press_after_total_review_number' ); ?>
		</p>
	</div>
	<div class="detailed_rating">
		<?php
		if ( isset( $course_rate_res['items'] ) && ! empty( $course_rate_res['items'] ) ):
			foreach ( $course_rate_res['items'] as $item ):
				$percent = round( $item['percent'], 0 );
				?>
				<div class="course-rate">
							<span class="number-star"><?php echo esc_html( $item['rated'] ); ?><?php
								echo ( $item['rated'] > 1 ) ? esc_html_e( ' stars', 'course-builder' ) : esc_html_e( ' star', 'course-builder' ); ?></span>
					<div class="review-bar">
						<div class="rating" style="width:<?php echo esc_attr( $percent ); ?>% "></div>
					</div>
					<span class="percent"><?php echo esc_html( $percent ); ?>%</span>
				</div>
			<?php
			endforeach;
		endif;
		?>
	</div>
</div>



