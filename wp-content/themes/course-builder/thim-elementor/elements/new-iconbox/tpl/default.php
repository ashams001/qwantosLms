<?php

$layout      = isset( $setting['layout'] ) ? $setting['layout'] : 'layout-1';
$border_left = '';
if ( $setting['border_left'] == 'yes' ) {
	$border_left = 'has_border';
}

?>
<div
	class="thim-new-iconbox <?php echo esc_attr( $layout ); ?> <?php echo esc_attr( $setting['el_class'] ); ?> <?php echo $border_left; ?>">
	<?php thim_get_elementor_template( $setting['sc-name'], array( 'setting' => $setting ), $layout ); ?>
</div>
