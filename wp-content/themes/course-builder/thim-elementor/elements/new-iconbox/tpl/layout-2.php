<?php
$title       = $setting['title'];
$title2      = $setting['title_line_2'];
$link_before = $link_after = '';

if ( $setting['icon_link']['url'] ) {
	$target      = $setting['icon_link']['is_external'] ? ' target="_blank"' : '';
	$nofollow    = $setting['icon_link']['nofollow'] ? ' rel="nofollow"' : '';
	$link_before = '<a href="' . esc_attr( $setting['icon_link']['url'] ) . '" ' . $target . ' ' . $nofollow . '">';
	$link_after  = '</a>';
}

$color = 'style="color:' . $setting['primary_color'] . ';"';

switch ( $setting['icon'] ) {
	case 'upload_icon':
		if ( $settings['icon_upload'] ) {
			$icon_upload = wp_get_attachment_image_src( $settings['icon_upload']['id'], 'full' );
			$alt         = isset( $params['title'] ) ? $setting['title'] : esc_attr__( 'Icon', 'course-builder' );
			$icon        = '<img class="image-upload" src="' . $icon_upload[0] . '" width="' . $icon_upload[1] . '" height="' . $icon_upload[2] . '" alt="' . $alt . '">';
		}
		break;
	case 'font_ionicons':
		if ( $setting['font_ionicons'] ) {
			$icon = '<i ' . $color . ' class="icon-ionicons ' . $setting['font_ionicons'] . '" aria-hidden="true"></i>';
		}
		break;
	default:
		if ( $setting['font_awesome'] ) {
			$icon = '<i ' . $color . ' class="icon-fontawesome ' . $setting['font_awesome'] . '" aria-hidden="true"></i>';
		}
}
?>

<?php echo( $link_before ); ?>
	<div class="icon-box">
		<?php echo $icon; ?>
	</div>
	<div class="title">
		<p>
			<?php echo $title; ?>
		</p>
		<p>
			<?php echo $title2; ?>
		</p>
	</div>
<?php echo( $link_after ); ?>