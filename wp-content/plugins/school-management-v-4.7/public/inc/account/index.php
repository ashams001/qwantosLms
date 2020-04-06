<?php
defined( 'ABSPATH' ) || die();

global $wp;

$current_page_url = home_url( add_query_arg( array(), $wp->request ) );
if ( ! is_user_logged_in() ) {
	$login_form_args = array(
		'form_id'        => 'wlsm-login-form',
		'id_username'    => 'wlsm-login-username',
		'id_password'    => 'wlsm-login-password',
		'id_remember'    => 'wlsm-login-remember',
		'id_submit'      => 'wlsm-login-submit',
		'value_username' => '',
	);
	wp_login_form( $login_form_args );
	?>
	<a target="_blank" href="<?php echo esc_url( wp_lostpassword_url( $current_page_url ) ); ?>">
		<?php esc_html_e( 'Lost your password?', 'school-management' ); ?>
	</a>
	<?php
} else {
	global $wpdb;

	$user_id = get_current_user_id();

	// Checks if user is student.
	$student = WLSM_M::get_student( $user_id );

	$logout_url = wp_logout_url( $current_page_url );
	?>
	<div class="wlsm-logged-in-info">
		<span class="wlsm-logged-in-text"><?php esc_html_e( 'You are logged in.', 'school-management' ); ?></span>
		<a class="wlsm-logout-link" href="<?php echo esc_url( $logout_url ); ?>">
			<?php esc_html_e( 'Logout', 'school-management' ); ?>
		</a>
		<br>
		<a href="<?php echo esc_url( add_query_arg( array( 'action' => 'settings' ), $current_page_url ) ); ?>"><?php esc_html_e( 'Account Settings', 'school-management' ); ?></a>
	</div>
	<?php
	if ( $student ) {
		$school_id  = $student->school_id;
		$session_id = $student->session_id;

		$class_school_id = $student->class_school_id;
		require_once WLSM_PLUGIN_DIR_PATH . 'public/inc/account/student/route.php';
	} else {
		require_once WLSM_PLUGIN_DIR_PATH . 'includes/helpers/WLSM_M_Parent.php';

		$unique_student_ids = WLSM_M_Parent::get_parent_student_ids( $user_id );

		if ( count( $unique_student_ids ) ) {
			require_once WLSM_PLUGIN_DIR_PATH . 'public/inc/account/parent/route.php';
		} else {
			require_once WLSM_PLUGIN_DIR_PATH . 'public/inc/account/no_record.php';
		}
	}
}
