<?php
$course_id = get_the_ID();
$course    = learn_press_get_the_course();

$total       = 0;
$course_rate = 0;
if ( function_exists( "learn_press_get_course_rate" ) ) {
	$course_rate_res = learn_press_get_course_rate( $course_id, false );
	$course_rate     = $course_rate_res['rated'];
	$total           = $course_rate_res['total'];
}

$count = $course->count_users_enrolled( 'append' ) ? $course->count_users_enrolled( 'append' ) : 0;
?>
<div class="course-info">
	<ul class="list-inline">
		<li class="list-inline-item item-author">
			<div class="author" itemprop="creator">
				<span class="avatar"><?php echo get_avatar( get_post_field( 'post_author', get_the_ID() ), 60 ); ?></span>
				<div class="info">
					<label><?php esc_html_e( 'Teacher', 'course-builder' ); ?></label>
					<a href="<?php echo esc_url( learn_press_user_profile_link( $course->post->post_author ) ); ?>">
						<?php echo get_the_author_meta( 'display_name', $course->post->post_author ); ?>
					</a>
				</div>
			</div>
		</li>
		<li class="list-inline-item item-categories">
			<label><?php esc_html_e( 'Categories', 'course-builder' ); ?></label>
			<?php learn_press_get_template( 'single-course/categories.php' ) ?>
		</li>
		<li class="list-inline-item item-students">
			<label><?php esc_html_e( 'Students', 'course-builder' ); ?></label>
			<?php echo esc_html( $count ); ?> <?php esc_html_e( '(Registered)', 'course-builder' ); ?>
		</li>
		<?php if ( function_exists( "learn_press_get_course_rate" ) ) : ?>
			<li class="list-inline-item item-review">
				<label><?php esc_html_e( 'Review', 'course-builder' ); ?></label>
				<?php
				learn_press_course_review_template( 'rating-stars.php', array( 'rated' => $course_rate ) );
				if ( is_single() ) {
					$total = intval( $total );
					if ( $total > 0 ) {
						$text = sprintf( _n( '(%s Review)', '(%s Reviews)', $total, 'course-builder' ), $total );
					} else {
						$text = sprintf( '(%s Review)', $total );
					}
				} else {
					$text = sprintf( _n( '( %s Rating )', '( %s Rating )', $total, 'course-builder' ), $total );
				}
				echo ent2ncr( $text );
				?>
			</li>
		<?php endif; ?>
	</ul>
</div>