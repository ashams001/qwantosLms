<?php
$layout = 'layout-1';
switch ( $params['layout'] ) {
	case 'layout-2':
		$layout = 'layout-1';
		break;
	case 'layout-4':
		$layout = 'layout-4';
		break;
	case 'layout-3':
		$layout = 'layout-3';
		break;
	default:
		$layout = 'layout-1';
		break;
}
?>
<div class="thim-sc-steps <?php echo esc_attr( $params['layout'] ); ?> <?php echo esc_attr( $params['el_class'] ); ?>">
	<?php thim_get_elementor_template( $params['sc-name'], array( 'params' => $params ), $layout ); ?>
</div>
