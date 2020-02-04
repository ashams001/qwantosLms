<?php
/**
 * Created by PhpStorm.
 * User: XuanLe
 * Date: 13/06/2017
 * Time: 2:11 CH
 */

$icon     = '';
$layout   = isset( $setting['layout'] ) ? $setting['layout'] : '';
$bg_image = wp_get_attachment_url( $setting['upload_image']['id'] );
$link     = $setting['link_video'];

?>
<div class="thim-sc-video-box <?php echo esc_attr( $setting['bg_image'] ); ?> <?php echo esc_attr( $setting['el_class'] ); ?> <?php echo esc_attr( $layout ); ?>">
	<div class="video">
		<?php if ( $setting['link_video'] ) : ?>
			<div class="video-box" style="background-image: url(<?php echo esc_url( $bg_image ); ?>)">
				<div class="play-button">
					<a href="<?php echo esc_url( $link ); ?>" class="video-thumbnail"><i class="icon-play"></i></a>
				</div>
			</div>
		<?php endif; ?>
	</div>

	<?php if ( $setting['content'] && ( $layout == 'layout-1' ) ): ?>
		<div class="row content-box">
			<div class="col-lg-2 share">
				<?php
				if ( $setting['share_link'] ) {
					do_action( 'thim_element_social_share_video' );
				}
				?>
			</div>
			<div class="col-lg-10 main-content">
				<?php echo( $setting['content'] ); ?>
			</div>
		</div>
		<hr>
	<?php endif; ?>
</div>
