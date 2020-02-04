<li>
	<div class="review-author">
		<a href="<?php echo esc_url( learn_press_user_profile_link( $review->ID ) ); ?>">
			<?php echo get_avatar( $review->user_email, 84 ) ?>
		</a>
	</div>
	<div class="review-content">
		<div class="review-author-info">
			<a href="<?php echo esc_url( learn_press_user_profile_link( $review->ID ) ); ?>">
				<h4 class="user-name">
					<?php do_action( 'learn_press_before_review_username' ); ?>
					<?php echo esc_html( $review->display_name ); ?>
					<?php do_action( 'learn_press_after_review_username' ); ?>
				</h4>
			</a>
			<?php learn_press_course_review_template( 'rating-stars.php', array( 'rated' => $review->rate ) ); ?>
			<p class="review-time">
				<?php echo date( 'F j, Y', strtotime( $review->user_registered ) ); ?><?php echo esc_html__( ' at ', 'course-builder' ); ?><?php echo date( 'h:i A', strtotime( $review->user_registered ) ); ?>
			</p>
		</div>
		<div class="review-text">
            <p class="review-title">
                <?php do_action( 'learn_press_before_review_title' ); ?>
                <?php echo esc_html( $review->title ); ?>
                <?php do_action( 'learn_press_before_review_title' ); ?>
            </p>
			<p class="review-content">
				<?php do_action( 'learn_press_before_review_content' ); ?>
				<?php echo( $review->content ) ?>
				<?php do_action( 'learn_press_after_review_content' ); ?>
			</p>
		</div>
	</div>
</li>