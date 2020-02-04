<?php
/**
 * User Information
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 2.1.6
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$user                    = learn_press_get_current_user();
$user_info               = get_userdata( $user->id );
$user_meta               = get_user_meta( $user->ID );
$user_meta               = array_map( function ( $a ) {
	return $a[0];
}, $user_meta );
$username                = $user_info->user_login;
$nick_name               = $user_info->nickname;
$first_name              = $user_info->first_name;
$last_name               = $user_info->last_name;
$profile_picture_type    = $user->profile_picture ? 'picture' : 'gravatar';
$profile_picture         = $user->profile_picture;
$class_gravatar_selected = ( 'gravatar' === $profile_picture_type ) ? ' lp-menu-item-selected' : '';
$class_picture_selected  = ( 'picture' === $profile_picture_type ) ? ' lp-menu-item-selected' : '';
$section                 = ! empty( $_REQUEST['section'] ) ? $_REQUEST['section'] : 'basic-information';
$url_tab                 = learn_press_user_profile_link( $user->id, $current );

$edit_tabs = array(
	'avatar',
	'basic-information',
	'change-password',
	'additional-information'
);

if ( class_exists( 'LP_Addon_Certificates' ) ) {
	$edit_tabs[] = 'certificates';
}

?>
	<div id="lp-user-profile-form" class="lp-user-profile-form">
		<form method="post" name="lp-edit-profile">

			<div class="learn-press-subtab-content user-profile-section-content">
				<?php
				foreach ( $edit_tabs as $template ) {
					if ( $template === 'avatar' ) {
						echo '<div class="info-left">';
					}
					if ( $template === 'additional-information' ) {
						echo '<div class="info-right">';
					}
					echo '<div class="lp-profile-section">';
					$template_dir = learn_press_locate_template( 'profile/tabs/edit/' . $template . '.php' );
					include $template_dir;
					echo '<input type="hidden" name="lp-profile-section" value=' . $template . ' />';
					echo '</div>';

					if ( $template === 'change-password' ) {
						echo '</div>';
					}
				}
				echo '</div>';
				?>
			</div>

			<input type="hidden" name="user_id" id="user_id" value="<?php echo esc_attr( $user->id ); ?>" />
			<input type="hidden" name="profile-nonce" value="<?php echo esc_attr( wp_create_nonce( 'learn-press-update-user-profile-' . $user->id ) ); ?>" />
			<div class="submit update-profile">
				<button type="submit" name="submit" id="submit" class="button button-primary"><?php esc_html_e( 'Update', 'course-builder' ); ?>
					<div class="sk-three-bounce hidden">
						<div class="sk-child sk-bounce1"></div>
						<div class="sk-child sk-bounce2"></div>
						<div class="sk-child sk-bounce3"></div>
					</div>
				</button>
			</div>
		</form>
	</div>
<?php
