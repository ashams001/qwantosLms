<?php
/**
 * Form for editing basic information of user in profile page
 *
 * @author  ThimPress
 * @version 2.1.1
 * @package LearnPress/Templates
 */

defined( 'ABSPATH' ) || exit;

$major  = ! empty( $user_meta['lp_info_major'] ) ? $user_meta['lp_info_major'] : '';
$status = ! empty( $user_meta['lp_info_status'] ) ? $user_meta['lp_info_status'] : '';
?>

<ul class="lp-form-field-wrap">
	<?php do_action( 'learn_press_before_' . $section . '_edit_fields' ); ?>

	<li class="lp-form-field">
		<label class="lp-form-field-label"><?php esc_html_e( 'Name', 'course-builder' ); ?></label>
		<div class="lp-form-field-input">
			<input type="text" name="display_name" id="display_name" value="<?php echo esc_attr( $user_info->display_name ) ?>" class="regular-text" />
		</div>
	</li>

	<li class="lp-form-field">
		<label class="lp-form-field-label"><?php esc_html_e( 'Job - Major', 'course-builder' ); ?></label>
		<div class="lp-form-field-input">
			<input type="text" name="lp_info_major" id="lp_info_major" value="<?php echo esc_attr( $major ) ?>" class="regular-text" />
		</div>
	</li>


	<li class="lp-form-field">
		<label class="lp-form-field-label"><?php esc_html_e( 'About', 'course-builder' ); ?></label>
		<div class="lp-form-field-input">
			<textarea name="description" id="description" rows="5" cols="30"><?php echo esc_html( $user_info->description ); ?></textarea>
		</div>
	</li>

	<li class="lp-form-field">
		<label class="lp-form-field-label"><?php esc_html_e( 'Status', 'course-builder' ); ?></label>
		<div class="lp-form-field-input">
			<textarea name="lp_info_status" id="lp_info_status" rows="3" cols="30"><?php echo esc_html( $status ); ?></textarea>
		</div>
	</li>

	<?php do_action( 'learn_press_after_' . $section . '_edit_fields' ); ?>
</ul>
