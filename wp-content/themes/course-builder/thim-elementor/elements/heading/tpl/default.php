<?php
/**
 * Shortcode Heading
 *
 * @param $atts
 *
 * @return string
 */

$heading_icon_url      = '';
$primary_heading_style = 'color: ' . $setting['font_color'] . '; font-size: ' . $setting['font_size'] . 'px; font-weight: ' . $setting['font_weight'] . '; font-style: ' . $setting['font_style'] . ';';

if ( $setting['separator'] == 'yes' ) {
	$separators = true;
} else {
	$separators = false;
}

switch ( $setting['heading_style'] ) {
	case 'layout-2':
		$underline = $separators;
		$separator = false;
		break;
	default:
		$separator = $separators;
		$underline = false;
		if ( !empty( $setting['heading_icon'] ) ) {
			$heading_icon_url = wp_get_attachment_image_src( $setting['heading_icon']['id'], 'full', true );
			$heading_icon_url = $heading_icon_url[0];
		} else {
			$heading_icon_url = get_template_directory_uri() . '/assets/images/icon-heading.png';
		}
		break;
}

?>
<div
	class="thim-sc-heading <?php echo 'text-' . esc_attr( $setting['heading_position'] ); ?> <?php echo esc_attr( $setting['heading_style'] ); ?> <?php echo esc_attr( $setting['el_class'] ); ?>">
	<div class="heading-content">

		<?php
		if ( $setting['heading_style'] == 'default' ) {
			if ( $separator ) {
				?>
				<div class="border border-top"></div>
				<img src="<?php echo esc_url( $heading_icon_url ); ?>" alt="separator"></span>
				<div class="border border-bottom"></div>
				<?php
			} else {
				?>
				<img src="<?php echo esc_url( $heading_icon_url ); ?>" alt="separator"></span>
				<?php
			}
		}
		?>

		<?php
		// Primary Heading
		if ( $setting['primary_heading'] ) {
			if ( $setting['heading_custom'] != 'yes' ) {
				echo '<' . $setting['tag'] . ' class="primary-heading">' . ent2ncr( $setting['primary_heading'] ) . '</' . $setting['tag'] . '>';
			} else {
				echo '<' . $setting['tag'] . ' class="primary-heading" style="' . esc_attr( $primary_heading_style ) . '">' . ent2ncr( $setting['primary_heading'] ) . '</' . $setting['tag'] . '>';
			}
		}

		if ( $setting['primary_heading_2'] ) {
			if ( $setting['heading_custom'] != 'yes' ) {
				echo '<' . $setting['tag'] . ' class="primary-heading-2">' . ent2ncr( $setting['primary_heading_2'] ) . '</' . $setting['tag'] . '>';
			} else {
				echo '<' . $setting['tag'] . ' class="primary-heading-2" style="' . esc_attr( $primary_heading_style ) . '">' . ent2ncr( $setting['primary_heading_2'] ) . '</' . $setting['tag'] . '>';
			}
		}
		?>
	</div>
	<?php if ( $setting['secondary_heading'] ) : ?>
		<p class="secondary-heading">
			<?php echo ent2ncr( $setting['secondary_heading'] ); ?>
		</p>
	<?php endif; ?>
	<?php if ( $underline ): ?>
		<span class="underline"></span>
	<?php endif; ?>
</div>
