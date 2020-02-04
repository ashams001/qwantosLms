<?php

// Get settings
$id = 'ob-map-canvas-' . md5( $setting['map_center'] ) . '';

if ( $setting['marker_at_center'] == 'yes' ) {
	$marker_at_center = true;
} else {
	$marker_at_center = false;
}

if ( $setting['scroll_zoom'] == 'yes' ) {
	$scroll_zoom = true;
} else {
	$scroll_zoom = false;
}

if ( $setting['draggable'] == 'yes' ) {
	$draggable = true;
} else {
	$draggable = false;
}

$height = $setting['height'] . 'px';
$data   = 'data-address="' . $setting['map_center'] . '" ';
$data   .= 'data-zoom="' . $setting['zoom'] . '" ';
$data   .= 'data-scroll-zoom="' . $scroll_zoom . '" ';
$data   .= 'data-draggable="' . $draggable . '" ';
$data   .= 'data-marker-at-center="' . $marker_at_center . '" ';
$data   .= 'data-style="' . $setting['map_style'] . '" ';
$data   .= 'data-api_key="' . $setting['api_key'] . '" ';

if ( $setting['map_cover'] == 'yes' ) {
	$map_cover = true;
} else {
	$map_cover = false;
}

$icon_attachment = wp_get_attachment_image_src( $setting['marker_icon'] );
$icon            = $icon_attachment ? $icon_attachment[0] : '';

$data .= 'data-marker-icon="' . $icon . '" ';

$cover_attachment = wp_get_attachment_image_src( $setting['map_cover_image']['id'], 'full' );
$cover            = $cover_attachment ? $cover_attachment[0] : '';

$class = 'ob-google-map-canvas';

$html = '<div class="thim-sc-googlemap" style="height: ' . $height . ';" data-cover="' . $map_cover . '">';
if ( $setting['map_cover'] == 'yes' ) {
	$html .= '<div class="map-cover" style="height: ' . $height . '; background-image: url(' . $cover . ');"></div>';
}
$html .= '<div class="' . $class . ' ' . esc_attr( $setting['el_class'] ) . '" style="height: ' . $height . ';" id="' . $id . '" ' . $data . ' ></div>';
$html .= '</div>';

echo ent2ncr( $html );