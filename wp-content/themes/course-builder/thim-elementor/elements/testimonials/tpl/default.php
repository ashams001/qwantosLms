<?php
$layout = isset( $params['layout'] ) ? $params['layout'] : 'layout-1';
?>
<div class="thim-sc-testimonials <?php echo esc_attr( $layout ); ?> <?php echo esc_attr( $params['el_class'] ); ?>">
	<?php thim_get_elementor_template( $params['sc-name'], array( 'params' => $params ), $layout );  ?>
</div>
