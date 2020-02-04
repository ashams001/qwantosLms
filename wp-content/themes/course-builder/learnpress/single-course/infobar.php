<?php
$course_info_button = get_post_meta( get_the_ID(), 'thim_course_info_button', true );
$course_includes    = get_post_meta( get_the_ID(), 'thim_course_includes', true );
?>

<div class="info-bar">

	<div class="price-box">
		<?php learn_press_course_price(); ?>
	</div>

	<div class="inner-content">
		<div class="button-box">
			<?php learn_press_course_buttons(); ?>
			<?php if ( ! empty( $course_info_button ) ) { ?>
				<p class="intro"><?php echo ent2ncr( $course_info_button ); ?></p>
			<?php } ?>
		</div>

		<?php if ( ! empty( $course_includes ) ) { ?>
			<div class="includes-box">
				<?php echo ent2ncr( $course_includes ); ?>
			</div>
		<?php } ?>

		<?php thim_social_share( 'learnpress_single_' ); ?>
	</div>

</div>
