<?php
/**
 * Displaying the certs in user's profile settings tab
 *
 * @author ThimPress
 */

! defined( 'ABSPATH' ) && exit();

$certificates = learn_press_get_user_certificates( get_current_user_id() );

if ( sizeof( $certificates ) == 0 ) {
	if ( ( $message = apply_filters( 'learn_press_user_profile_no_certificates', esc_html__( 'You have not received any certificates yet!', 'course-builder' ) ) ) !== false ) {
		learn_press_display_message( $message );
	}

	return;
}

?>
<div class="certificates-section">
	<label class="lp-form-field-label"><?php esc_html_e( 'Certificates', 'course-builder' ) ?></label>
	<div class="certificates-section-wrap">
		<ul class="learn-press-user-profile-certs owl-carousel owl-theme">
			<?php foreach ( $certificates as $cert ): ?>
				<li class="item">
					<?php $cert_data = LP_Addon_Certificates::instance()->get_json( $cert->cert_id, $cert->course_id, $cert->user_id ); ?>
					<div class="inside">
						<div class="course-certificate-preview">
							<div class="learn-press-cert-preview">
								<div id="learn-press-cert-wrap-settings-tab<?php echo esc_attr( $cert->cert_id ); ?>-<?php echo esc_attr( $cert->course_id ); ?>">
									<div id="cert-design-viewport">
										<img class="cert-template" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/certificate-preview.jpg' ) ?>" alt="<?php esc_attr_e( 'Preview', 'course-builder' ) ?>">
										<a class="permalink" target="_blank" href="<?php echo learn_press_certificate_permalink( $cert->cert_id, $cert->course_id ); ?>" title="<?php echo get_the_title( $cert->course_id ); ?>"></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</li>
			<?php endforeach; ?>
			<li class="item more-info">
				<a href="<?php echo esc_url( learn_press_user_profile_link( $user->ID, 'certificates' ) ); ?>" title="<?php esc_attr_e( 'More details', 'course-builder' ) ?>"></a>
			</li>
		</ul>
	</div>
</div>

