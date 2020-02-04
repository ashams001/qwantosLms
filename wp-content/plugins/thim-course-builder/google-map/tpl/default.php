<?php

// Get settings
$id     = 'ob-map-canvas-' . md5( $params['map_center'] ) . '';
$height = $params['height'] . 'px';
$data   = 'data-address="' . $params['map_center'] . '" ';
$data   .= 'data-zoom="' . $params['zoom'] . '" ';
$data   .= 'data-scroll-zoom="' . $params['scroll_zoom'] . '" ';
$data   .= 'data-draggable="' . $params['draggable'] . '" ';
$data   .= 'data-marker-at-center="' . $params['marker_at_center'] . '" ';
$data   .= 'data-style="' . $params['map_style'] . '" ';
$data   .= 'data-api_key="' . $params['api_key'] . '" ';

$icon_attachment = wp_get_attachment_image_src( $params['marker_icon'] );
$icon            = $icon_attachment ? $icon_attachment[0] : '';

$data .= 'data-marker-icon="' . $icon . '" ';

$cover_attachment = wp_get_attachment_image_src( $params['map_cover_image'], 'full' );
$cover            = $cover_attachment ? $cover_attachment[0] : '';

$class = 'ob-google-map-canvas';

$html = '<div class="thim-sc-googlemap" style="height: ' . $height . ';" data-cover="' . $params['map_cover'] . '">';
if ( $params['map_cover'] ) {
	$html .= '<div class="map-cover" style="height: ' . $height . '; background-image: url(' . $cover . ');"></div>';
}
$html .= '<div class="' . $class . ' ' . esc_attr( $params['el_class'] ) . '" style="height: ' . $height . ';" id="' . $id . '" ' . $data . ' ></div>';
$html .= '</div>';

echo ent2ncr($html);