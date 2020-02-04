<?php
$title       = $params['title'];
$title2      = $params['title_line_2'];
$link_before = $link_after = '';

if ( $params['icon_link'] ) {
	$link_detail = vc_build_link( $params['icon_link'] );
	$link_before = '<a href="' . esc_attr( $link_detail['url'] ) . '" target="' . esc_attr( $link_detail['target'] ) . '">';
	$link_after  = '</a>';
}

$color = 'style="color:' . $params['primary_color'] . ';"';

switch ( $params['icon'] ) {
	case 'upload_icon':
		if ( $params['icon_upload'] ) {
			$icon_upload = wp_get_attachment_image_src( $params['icon_upload'], 'full' );
			$alt         = isset( $params['title'] ) ? $params['title'] : esc_attr__( 'Icon', 'course-builder' );
			$icon        = '<img class="image-upload" src="' . $icon_upload[0] . '" width="' . $icon_upload[1] . '" height="' . $icon_upload[2] . '" alt="' . $alt . '">';
		}
		break;
	case 'font_ionicons':
		if ( $params['font_ionicons'] ) {
			$icon = '<i ' . $color . ' class="icon-ionicons ' . $params['font_ionicons'] . '" aria-hidden="true"></i>';
		}
		break;
	default:
		if ( $params['font_awesome'] ) {
			$icon = '<i ' . $color . ' class="icon-fontawesome ' . $params['font_awesome'] . '" aria-hidden="true"></i>';
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