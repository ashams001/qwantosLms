<?php
#todo check with empty string
$default_instance = array(
	'text_register' => esc_attr__( 'Register', 'course-builder' ),
	'text_login'    => esc_attr__( 'Login', 'course-builder' ),
	'text_logout'   => esc_attr__( 'Logout', 'course-builder' ),
	'link'          => get_permalink( get_page_by_path( 'account' ) ),
	'shortcode'     => '[wordpress_social_login]',
	'captcha'       => false,
	'term'          => '',
    'popup'         => true,
);

$instance = array(
	'text_register' => $setting['text_register'],
	'text_login'    => $setting['text_login'],
	'text_logout'   => $setting['text_logout'],
	'link'          => $setting['link'],
	'shortcode'     => $setting['content'],
	'captcha'       => (bool) $setting['captcha'],
	'phone'         => (bool) $setting['phone'],
	'term'         => $setting['term'],
    'popup'         => (bool) $setting['popup'],
);

$instance = wp_parse_args( (array) $instance, $default_instance);

?>

<div class="thim-sc-login <?php echo esc_attr($setting['el_class'])?>">
	<?php
	do_action( 'thim_login_widget_before' );

	the_widget( 'Thim_Login_Widget', $instance );

	do_action( 'thim_login_widget_after' );
	?>
</div>

