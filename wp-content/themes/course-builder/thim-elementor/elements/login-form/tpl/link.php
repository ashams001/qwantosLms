<div class="thim-sc-login link-to-account <?php echo esc_attr($setting['el_class'])?>">
	<?php
	$html = '';
	if ( is_user_logged_in() ) {
		$html .= '<a href="' . wp_logout_url() . '" title="' . esc_attr( $setting['text_logout'] ) . '">' . esc_html( $setting['text_logout'] ) . '</a>';
	} else {
		$login_url = thim_get_login_page_url();
		if ( isset($setting['login_url'] )) {
			$login_url = $setting['login_url'];
		}
		$html .= '<a class="register-link" href="' . esc_url( $login_url . '/?action=register' ) . '" title="' . esc_attr( $setting['text_register'] ) . '">' . esc_html( $setting['text_register'] ) . '</a>' . '/' .
		         '<a href = "' . esc_url( $login_url ) . '" title = "' . esc_attr( $setting['text_login'] ) . '" > ' . esc_html( $setting['text_login'] ) . ' </a > ';
	}

	echo ent2ncr( $html );
	?>
</div>