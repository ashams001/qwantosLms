<?php

$link_before = $link_after = '';
if ( $params['icon_link'] ) {
	$link_detail = vc_build_link( $params['icon_link'] );

	$link_before = '<a href="' . esc_attr( $link_detail['url'] ) . '" target="' . esc_attr( $link_detail['target'] ) . '">';
	$link_after  = '</a>';
}


$line_css = '';
if ( $params['primary_color'] ) {
	$line_css .= ' border-color: ' . $params['primary_color'] . ';';
	$line_css .= ' color: ' . $params['primary_color'] . ';';
}

$icon = '';

switch ( $params['icon'] ) {
	case 'upload_icon':
		if ( $params['icon_upload'] ) {
			$icon_upload = wp_get_attachment_image_src( $params['icon_upload'], 'full' );
			$alt         = isset( $params['icon_title'] ) ? $params['icon_title'] : esc_attr__( 'Icon', 'course-builder' );
			$icon        = '<img class="image-upload" src="' . $icon_upload[0] . '" width="' . $icon_upload[1] . '" height="' . $icon_upload[2] . '" alt="' . $alt . '">';
		}
		break;
	case 'font_ionicons':
		if ( $params['font_ionicons'] ) {
			$icon = '<i class="icon-ionicons ' . $params['font_ionicons'] . '" aria-hidden="true"></i>';
		}
		break;
	default:
		if ( $params['font_awesome'] ) {
			$icon = '<i class="icon-fontawesome ' . $params['font_awesome'] . '" aria-hidden="true"></i>';
		}
}

?>

<div
	class="thim-sc-icon-box <?php echo esc_attr( $params['el_class'] ); ?> <?php echo esc_attr( $params['box_style'] ); ?> <?php echo esc_attr( $params['style_layout'] ); ?>">
	<?php echo( $link_before ); ?>
	<div class="icon-box-wrapper" style="<?php echo esc_attr( $line_css ); ?>">
		<?php if ( $icon ): ?>
			<div class="box-icon" style="background-color: <?php echo $params['background_color']; ?>;">
				<?php echo ent2ncr( $icon ); ?>
			</div>
		<?php endif; ?>
		<div class="box-content">
			<?php if ( $params['icon_title'] ): ?>
				<h3 class="title">
					<?php echo esc_html( $params['icon_title'] ); ?>
				</h3>
			<?php endif; ?>
			<?php if ( $params['description'] ): ?>
				<div class="description">
					<?php echo( $params['description'] ); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<?php echo( $link_after ); ?>
</div>


