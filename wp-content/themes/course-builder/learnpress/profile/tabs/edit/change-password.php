<?php
/**
 * Form for displaying change password form in profile page
 *
 * @author  ThimPress
 * @version 2.1.1
 * @package LearnPress/Templates
 */

defined( 'ABSPATH' ) || exit;
?>

<div id="lp-profile-edit-password-form">
	<label class="lp-form-field-label"><?php esc_attr_e( 'Change Password', 'course-builder' ); ?></label>
	<ul class="lp-form-field-wrap">
		<?php do_action( 'learn_press_before_' . $section . '_edit_fields' ); ?>

		<li class="lp-form-field">
			<div class="lp-form-field-input">
				<input type="password" id="pass0" name="pass0" autocomplete="off" class="regular-text" placeholder="<?php esc_attr_e('Old Password','course-builder') ?>" />
			</div>
		</li>

		<li class="lp-form-field">
			<div class="lp-form-field-input">
				<input type="password" name="pass1" id="pass1" class="regular-text" value="" placeholder="<?php esc_attr_e('New Password','course-builder') ?>"/>
			</div>
		</li>

		<li class="lp-form-field">
			<div class="lp-form-field-input">
				<input name="pass2" type="password" id="pass2" class="regular-text" value="" placeholder="<?php esc_attr_e('Confirm New Password','course-builder') ?>"/>
				<p id="lp-password-not-match" class="description lp-field-error-message hide-if-js"><?php esc_html_e( 'New password does not match!', 'course-builder' ); ?></p>
			</div>
		</li>
		<?php do_action( 'learn_press_after_' . $section . '_edit_fields' ); ?>
	</ul>
</div>


