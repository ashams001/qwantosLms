<?php
$icon               = '';
$bg_image           = wp_get_attachment_url( $setting['upload_image']['id'] );
$background_image_1 = wp_get_attachment_url( $setting['background_image_1']['id'] );
$background_image_2 = wp_get_attachment_url( $setting['background_image_2']['id'] );
$link               = $setting['link_video'];
?>
<div class="thim-sc-new-video <?php echo esc_attr( $setting['el_class'] ); ?>">
	<div class="video">
		<?php if ( $setting['link_video'] ) : ?>
			<div class="new-video" style="background-image: url(<?php echo esc_url( $bg_image ); ?>)">
				<div class="play-button">
					<a href="<?php echo esc_url( $link ); ?>" class="video-thumbnail"><i class="icon-play"></i></a>
				</div>
				<img class="icon-right" src="<?php echo $background_image_1; ?>" alt="icon-video-1">
				<img class="icon-bottom" src="<?php echo $background_image_2; ?>" alt="icon-video-2">
			</div>
		<?php endif; ?>
	</div>
</div>

