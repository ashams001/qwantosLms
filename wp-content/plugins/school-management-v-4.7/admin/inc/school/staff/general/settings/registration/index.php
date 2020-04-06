<?php
defined( 'ABSPATH' ) || die();

// Registration settings.
$settings_registration                     = WLSM_M_Setting::get_settings_registration( $school_id );
$school_registration_form_title            = $settings_registration['form_title'];
$school_registration_login_user            = $settings_registration['login_user'];
$school_registration_redirect_url          = $settings_registration['redirect_url'];
$school_registration_create_invoice        = $settings_registration['create_invoice'];
$school_registration_auto_admission_number = $settings_registration['auto_admission_number'];
$school_registration_admin_phone           = $settings_registration['admin_phone'];
$school_registration_admin_email           = $settings_registration['admin_email'];
$school_registration_success_message       = $settings_registration['success_message'];

$school_registration_success_placeholders = WLSM_Helper::registration_success_message_placeholders();
?>
<div class="tab-pane fade" id="wlsm-school-registration" role="tabpanel" aria-labelledby="wlsm-school-registration-tab">

	<div class="row">
		<div class="col-md-9">
			<form action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>" method="post" id="wlsm-save-school-registration-settings-form">
				<?php
				$nonce_action = 'save-school-registration-settings';
				$nonce        = wp_create_nonce( $nonce_action );
				?>
				<input type="hidden" name="<?php echo esc_attr( $nonce_action ); ?>" value="<?php echo esc_attr( $nonce ); ?>">

				<input type="hidden" name="action" value="wlsm-save-school-registration-settings">

				<div class="row">
					<div class="col-md-3">
						<label for="wlsm_registration_form_title" class="wlsm-font-bold"><?php esc_html_e( 'Registration Form Title', 'school-management' ); ?>:</label>
					</div>
					<div class="col-md-9">
						<div class="form-group">
							<input name="registration_form_title" type="text" id="wlsm_registration_form_title" value="<?php echo esc_attr( $school_registration_form_title ); ?>" class="form-control" placeholder="<?php esc_attr_e( 'Registration form title', 'school-management' ); ?>">
							<p class="description">
								<?php esc_html_e( 'Works only when school_id is specified in the registration shortcode.', 'school-management' ); ?>
							</p>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="wlsm_registration_login_user" class="wlsm-font-bold"><?php esc_html_e( 'Login after Registration', 'school-management' ); ?>:</label>
					</div>
					<div class="col-md-9">
						<div class="form-group">
							<input <?php checked( $school_registration_login_user, true, true ); ?> class="form-check-input mt-1" type="checkbox" name="registration_login_user" id="wlsm_registration_login_user" value="1">
							<label class="ml-4 mb-1 form-check-label wlsm-font-bold text-dark" for="wlsm_registration_login_user">
								<?php esc_html_e( 'Login after Registration', 'school-management' ); ?>
							</label>
							<p class="description">
								<?php esc_html_e( 'This will login the student after registration.', 'school-management' ); ?>
							</p>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="wlsm_redirect_url" class="wlsm-font-bold"><?php esc_html_e( 'Redirect URL', 'school-management' ); ?>:</label>
					</div>
					<div class="col-md-9">
						<div class="form-group">
							<input name="redirect_url" type="text" id="wlsm_redirect_url" value="<?php echo esc_attr( $school_registration_redirect_url ); ?>" class="form-control" placeholder="<?php esc_attr_e( 'Redirect URL', 'school-management' ); ?>">
							<p class="description">
								<?php esc_html_e( 'Enter URL where to redirect the student after registration.', 'school-management' ); ?>
							</p>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="wlsm_registration_create_invoice" class="wlsm-font-bold"><?php esc_html_e( 'Create Invoice from Fee Type', 'school-management' ); ?>:</label>
					</div>
					<div class="col-md-9">
						<div class="form-group">
							<input <?php checked( $school_registration_create_invoice, true, true ); ?> class="form-check-input mt-1" type="checkbox" name="registration_create_invoice" id="wlsm_registration_create_invoice" value="1">
							<label class="ml-4 mb-1 form-check-label wlsm-font-bold text-dark" for="wlsm_registration_create_invoice">
								<?php esc_html_e( 'Create Invoice from Fee Type?', 'school-management' ); ?>
							</label>
							<p class="description">
								<?php esc_html_e( 'For every fee type, an invoice will be created. This is valid only for registrations from front registration form.', 'school-management' ); ?>
							</p>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="wlsm_registration_auto_admission_number" class="wlsm-font-bold"><?php esc_html_e( 'Auto Generate Admission Number', 'school-management' ); ?>:</label>
					</div>
					<div class="col-md-9">
						<div class="form-group">
							<input <?php checked( $school_registration_auto_admission_number, true, true ); ?> class="form-check-input mt-1" type="checkbox" name="registration_auto_admission_number" id="wlsm_registration_auto_admission_number" value="1">
							<label class="ml-4 mb-1 form-check-label wlsm-font-bold text-dark" for="wlsm_registration_auto_admission_number">
								<?php esc_html_e( 'Auto Generate Admission Number for Back-end Form?', 'school-management' ); ?>
							</label>
							<p class="description">
								<?php esc_html_e( 'Admission number is auto-generated in front-end form. With this, you can auto-generate admission number in back-end form also.', 'school-management' ); ?>
							</p>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="wlsm_registration_admin_phone" class="wlsm-font-bold"><?php esc_html_e( 'Admin Phone Number', 'school-management' ); ?>:</label>
					</div>
					<div class="col-md-9">
						<div class="form-group">
							<input name="registration_admin_phone" type="text" id="wlsm_registration_admin_phone" value="<?php echo esc_attr( $school_registration_admin_phone ); ?>" class="form-control" placeholder="<?php esc_attr_e( 'Admin phone number to receive registration notification', 'school-management' ); ?>">
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="wlsm_registration_admin_email" class="wlsm-font-bold"><?php esc_html_e( 'Admin Email Address', 'school-management' ); ?>:</label>
					</div>
					<div class="col-md-9">
						<div class="form-group">
							<input name="registration_admin_email" type="email" id="wlsm_registration_admin_email" value="<?php echo esc_attr( $school_registration_admin_email ); ?>" class="form-control" placeholder="<?php esc_attr_e( 'Admin email address to receive registration notification', 'school-management' ); ?>">
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="wlsm_registration_success_message" class="wlsm-font-bold"><?php esc_html_e( 'Success Message', 'school-management' ); ?>:</label>
					</div>
					<div class="col-md-9">
						<div class="mb-1">
							<span class="wlsm-font-bold text-dark"><?php esc_html_e( 'You can use the following variables:', 'school-management' ); ?></span>
							<div class="d-flex">
								<?php foreach ( $school_registration_success_placeholders as $key => $value ) { ?>
								<div class="col-sm-6 col-md-3 pb-1 pt-1 border">
									<span class="wlsm-font-bold text-secondary"><?php echo esc_html( $value ); ?></span>
									<br>
									<span><?php echo esc_html( $key ); ?></span>
								</div>
								<?php } ?>
							</div>
						</div>

						<div class="form-group">
							<textarea name="registration_success_message" id="wlsm_registration_success_message" class="form-control" rows="6" placeholder="<?php esc_attr_e( 'Success Message', 'school-management' ); ?>"><?php echo esc_html( $school_registration_success_message ); ?></textarea>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12 text-center">
						<button type="submit" class="btn btn-primary" id="wlsm-save-school-registration-settings-btn">
							<i class="fas fa-save"></i>&nbsp;
							<?php esc_html_e( 'Save', 'school-management' ); ?>
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>

</div>
