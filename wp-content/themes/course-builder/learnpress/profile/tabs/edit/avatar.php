<?php
/**
 * User avatar
 *
 * @package LearnPress/Templates
 * @author  ThimPress
 * @version 2.1.1
 */
$user         = learn_press_get_current_user();
$custom_img   = $user->get_upload_profile_src();
$gravatar_img = $user->get_profile_picture( 'gravatar' );
$thumb_size   = learn_press_get_avatar_thumb_size();

?>
<script type="text/html" id="tmpl-crop-user-avatar">
	<div class="lp-avatar-crop-image" style="width: {{data.viewWidth}}px; height: {{data.viewHeight}}px;">
		<img src="{{data.url}}?r={{data.r}}" />
		<div class="lp-crop-controls">
			<div class="lp-zoom">
				<div />
			</div>
			<a href="" class="lp-cancel-upload dashicons dashicons-no-alt"></a>
		</div>
		<input type="hidden" name="lp-user-avatar-crop[name]" data-name="name" value="{{data.name}}" />
		<input type="hidden" name="lp-user-avatar-crop[width]" data-name="width" value="" />
		<input type="hidden" name="lp-user-avatar-crop[height]" data-name="height" value="" />
		<input type="hidden" name="lp-user-avatar-crop[points]" data-name="points" value="" />
		<input type="hidden" name="lp-user-avatar-custom" value="yes" />
		<input type="hidden" name="update-custom-avatar" value="yes" />

	</div>
</script>

<div id="lp-user-edit-avatar" class="lp-edit-profile lp-edit-avatar learn-press-user-profile">
	<ul class="lp-form-field-wrap">
		<li class="lp-form-field">
			<label class="lp-form-field-label"><?php esc_html_e( 'Avatar', 'course-builder' ); ?></label>
			<div class="lp-form-field-input lp-form-field-avatar">
				<div class="lp-avatar-preview" style="width: <?php echo esc_attr($thumb_size['width']); ?>px;height: <?php echo esc_attr($thumb_size['height']); ?>px;">
					<input type="hidden" name="update-custom-avatar" value="yes" />

					<div class="profile-picture profile-avatar-current">
						<?php if ( $custom_img ) { ?>
							<img src="<?php echo esc_attr($custom_img); ?>" />
						<?php } else { ?>
							<?php echo ($gravatar_img); ?>
						<?php } ?>
						<input type="hidden" name="update-custom-avatar" value="no" />

					</div>
					<?php if ( $custom_img ) { ?>
						<div class="profile-picture profile-avatar-hidden">
							<?php echo ($gravatar_img); ?>
						</div>
					<?php } ?>

					<div class="lp-avatar-upload-progress">
						<div class="lp-avatar-upload-progress-value"></div>
					</div>

					<div class="lp-avatar-upload-error">
					</div>

					<div id="lp-avatar-actions">
						<button id="lp-upload-photo">
							<i class="fa fa-camera" aria-hidden="true" title="<?php esc_html_e( 'Upload', 'course-builder' ) ?>"></i>
						</button>
						<?php if ( $custom_img != '' ): ?>
							<button id="lp-remove-upload-photo" title="<?php esc_attr_e( 'Remove', 'course-builder' ) ?>">
								<i class="fa fa-times" aria-hidden="true"></i></button>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</li>
	</ul>
</div>