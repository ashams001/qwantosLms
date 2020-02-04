<?php

$link_before = $link_after = '';
if ( $setting['icon_link'] ) {

	$url = $setting['icon_link']['url'];
	if ( $setting['icon_link']['is_external'] == true ) {
		$target = '_blank';
	} else {
		$target = '_self';
	}

	$link_before = '<a href="' . esc_attr( $url ) . '" target="' . esc_attr( $target ) . '">';
	$link_after  = '</a>';
}


$line_css = '';
if ( $setting['primary_color'] ) {
	$line_css .= ' border-color: ' . $setting['primary_color'] . ';';
	$line_css .= ' color: ' . $setting['primary_color'] . ';';
}

$icon = '';

switch ( $setting['icon'] ) {
	case 'upload_icon':
		if ( $setting['icon_upload'] ) {
			$icon_upload = wp_get_attachment_image_src( $setting['icon_upload']['id'], 'full' );
			$alt         = isset( $setting['icon_title'] ) ? $setting['icon_title'] : esc_attr__( 'Icon', 'course-builder' );
			$icon        = '<img class="image-upload" src="' . $icon_upload[0] . '" width="' . $icon_upload[1] . '" height="' . $icon_upload[2] . '" alt="' . $alt . '">';
		}
		break;
	case 'font_ionicons':
		if ( $setting['font_ionicons'] ) {
			$icon = '<i class="icon-ionicons ' . $setting['font_ionicons'] . '" aria-hidden="true"></i>';
		}
		break;
	default:
		if ( $setting['font_awesome'] ) {
			$icon = '<i class="icon-fontawesome ' . $setting['font_awesome'] . '" aria-hidden="true"></i>';
		}
}

?>

<div
	class="thim-sc-icon-box <?php echo esc_attr( $setting['el_class'] ); ?> <?php echo esc_attr( $setting['box_style'] ); ?> <?php echo esc_attr( $setting['style_layout'] ); ?>">
	<?php echo( $link_before ); ?>
	<div class="icon-box-wrapper" style="<?php echo esc_attr( $line_css ); ?>">
		<?php if ( $icon ): ?>
			<div class="box-icon" style="background-color: <?php echo $setting['background_color']; ?>;">
				<?php echo ent2ncr( $icon ); ?>
			</div>
		<?php endif; ?>
		<div class="box-content">
			<?php if ( $setting['icon_title'] ): ?>
				<h3 class="title">
					<?php echo esc_html( $setting['icon_title'] ); ?>
				</h3>
			<?php endif; ?>
			<?php if ( $setting['description'] ): ?>
				<div class="description">
					<?php echo( $setting['description'] ); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<?php echo( $link_after ); ?>
</div>


