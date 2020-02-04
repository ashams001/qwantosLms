<?php

if ( $setting['target'] == 'yes' ) {
	$target_link = '_blank';
} else {
	$target_link = '_self';
}
?>
<div
	class="thim-sc-button <?php echo esc_attr( $setting['el_class'] ); ?> <?php echo esc_attr( $setting['separator'] ); ?> <?php echo esc_attr( $setting['align'] ); ?>">
	<?php if ( $setting['link'] ): ?>
		<a href="<?php echo esc_attr( $setting['link']['url'] ); ?>" target="<?php echo esc_attr( $target_link ); ?>"
		   class="btn btn-<?php echo esc_attr( $setting['style'] ); ?> <?php echo esc_attr( $setting['size'] ); ?>">
			<span class="text"><?php echo esc_html( $setting['title'] ); ?></span>
		</a>
	<?php endif; ?>
</div>
