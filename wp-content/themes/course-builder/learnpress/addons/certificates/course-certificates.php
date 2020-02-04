<?php
/**
 * Displaying the certs in user's profile
 *
 * @author ThimPress
 */

!defined( 'ABSPATH' ) && exit();


$user_profile = learn_press_get_profile_user();
$user_current = learn_press_get_current_user();
if(($user_profile->ID) != ($user_current->ID)) {
	echo esc_html__('You have not received any certificates yet', 'course-builder');
	return;
} else if (sizeof($certificates) == 0) {
	if (($message = apply_filters('learn_press_user_profile_no_certificates', esc_attr__('You have not received any certificates yet!', 'course-builder'))) !== false) {
		learn_press_display_message($message);
	}
	return;
}
?>
<ul class="learn-press-user-profile-certs">
	<?php foreach ( $certificates as $cert ): ?>
		<?php learn_press_certificates_template( 'loop-cert.php', array( 'cert' => $cert ) ); ?>
	<?php endforeach; ?>
</ul>
