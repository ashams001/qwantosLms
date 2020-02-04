<?php
/**
 * Form for display additional info user in profile page
 *
 * @author  ThimPress
 * @version 2.1.1
 */

defined( 'ABSPATH' ) || exit;

$phone = ! empty( $user_meta['lp_info_phone'] ) ? $user_meta['lp_info_phone'] : '';
$skype = ! empty( $user_meta['lp_info_skype'] ) ? $user_meta['lp_info_skype'] : '';
$gg    = ! empty( $user_meta['lp_info_google_plus'] ) ? $user_meta['lp_info_google_plus'] : '';
$fb    = ! empty( $user_meta['lp_info_facebook'] ) ? $user_meta['lp_info_facebook'] : '';
$tt    = ! empty( $user_meta['lp_info_twitter'] ) ? $user_meta['lp_info_twitter'] : '';
$pt    = ! empty( $user_meta['lp_info_pinterest'] ) ? $user_meta['lp_info_pinterest'] : '';

?>

<ul class="lp-form-field-wrap additional-information">
	<li class="lp-form-field">
		<h5 class="lp-form-field-label"><?php esc_html_e( 'Phone Number', 'course-builder' ); ?></h5>
		<div class="lp-form-field-input">
			<input type="text" name="lp_info_phone" id="lp_info_phone" value="<?php echo esc_attr( $phone ); ?>" class="regular-text">
			<label class="icon" for="lp_info_phone">
				<i class="fa fa-phone" aria-hidden="true"></i>
			</label>
			<span class="clear-field"><?php esc_html_e( 'Remove', 'course-builder' ) ?></span>
		</div>
	</li>

	<li class="lp-form-field">
		<h5 class="lp-form-field-label"><?php esc_html_e( 'Email', 'course-builder' ); ?></h5>
		<div class="lp-form-field-input">
			<input type="text" name="email" id="email" value="<?php echo esc_attr( $user_info->user_email ); ?>" class="regular-text" disabled>
			<label class="icon" for="email">
				<i class="fa fa-envelope-o" aria-hidden="true"></i>
			</label>
		</div>
	</li>

	<li class="lp-form-field">
		<h5 class="lp-form-field-label"><?php esc_html_e( 'Skype', 'course-builder' ); ?></h5>
		<div class="lp-form-field-input">
			<input type="text" name="lp_info_skype" id="lp_info_skype" value="<?php echo esc_attr( $skype ); ?>" class="regular-text">
			<label class="icon" for="lp_info_skype">
				<i class="fa fa-skype" aria-hidden="true"></i>
			</label>
			<span class="clear-field"><?php esc_html_e( 'Remove', 'course-builder' ) ?></span>
		</div>
	</li>

	<li class="lp-form-field">
		<h5 class="lp-form-field-label"><?php esc_html_e( 'Google Plus URL', 'course-builder' ); ?></h5>
		<div class="lp-form-field-input">
			<input type="text" name="lp_info_google_plus" id="lp_info_google_plus" value="<?php echo esc_attr( $gg ); ?>" class="regular-text">
			<label class="icon" for="lp_info_google_plus">
				<i class="fa fa-google-plus" aria-hidden="true"></i>
			</label>
			<span class="clear-field"><?php esc_html_e( 'Remove', 'course-builder' ) ?></span>
		</div>
	</li>

	<li class="lp-form-field">
		<h5 class="lp-form-field-label"><?php esc_html_e( 'Facebook URL', 'course-builder' ); ?></h5>
		<div class="lp-form-field-input">
			<input type="text" name="lp_info_facebook" id="lp_info_facebook" value="<?php echo esc_attr( $fb ); ?>" class="regular-text">
			<label class="icon" for="lp_info_facebook">
				<i class="fa fa-facebook" aria-hidden="true"></i>
			</label>
			<span class="clear-field"><?php esc_html_e( 'Remove', 'course-builder' ) ?></span>
		</div>
	</li>

	<li class="lp-form-field">
		<h5 class="lp-form-field-label"><?php esc_html_e( 'Twitter URL', 'course-builder' ); ?></h5>
		<div class="lp-form-field-input">
			<input type="text" name="lp_info_twitter" id="lp_info_twitter" value="<?php echo esc_attr( $tt ); ?>" class="regular-text">
			<label class="icon" for="lp_info_twitter">
				<i class="fa fa-twitter" aria-hidden="true"></i>
			</label>
			<span class="clear-field"><?php esc_html_e( 'Remove', 'course-builder' ) ?></span>
		</div>
	</li>

	<li class="lp-form-field">
		<h5 class="lp-form-field-label"><?php esc_html_e( 'Pinterest URL', 'course-builder' ); ?></h5>
		<div class="lp-form-field-input">
			<input type="text" name="lp_info_pinterest" id="lp_info_pinterest" value="<?php echo esc_attr( $pt ); ?>" class="regular-text">
			<label class="icon" for="lp_info_pinterest">
				<i class="fa fa-pinterest" aria-hidden="true"></i>
			</label>
			<span class="clear-field"><?php esc_html_e( 'Remove', 'course-builder' ) ?></span>
		</div>
	</li>
</ul>
