<?php

$items_visible = empty( $setting["items_visible"] ) ? '6' : $setting["items_visible"];
$items_tablet  = empty( $setting["items-tablet"] ) ? '4' : $setting["items-tablet"];
$items_mobile  = empty( $setting["items-mobile"] ) ? '1' : $setting["items-mobile"];

$navigation = empty( $setting['nav'] ) ? 'no' : 'yes';
?>
<div class="thim-brands  <?php echo esc_attr( $setting["el_class"] ); ?>"
	 data-items-visible="<?php echo esc_attr( $items_visible ); ?>"
	 data-nav="<?php echo esc_attr( $navigation ); ?>" data-items-tablet="<?php echo esc_attr( $items_tablet ); ?>"
	 data-items-mobile="<?php echo esc_attr( $items_mobile ); ?>">
	<div class="container">
		<div class="owl-carousel owl-theme">
			<?php
			if ( $setting['items'] ) {
				foreach ( $setting['items'] as $key => $brands ) {
					echo '<div class="item-brands">';
					if ( isset( $brands['brand_img'] ) ) {
						$brand = wp_get_attachment_image_src( $brands['brand_img']['id'], 'full' );
						$img   = '<img src="' . $brand[0] . '" width="' . $brand[1] . '" height="' . $brand[2] . '" alt="' . esc_attr__( 'Logo', 'course-builder' ) . '">';
						if ( isset( $brands['brand_link'] ) ) {
							?>
							<a href="<?php echo esc_attr( $brands['brand_link'] ) ?>" target="_blank">
								<?php echo ent2ncr( $img ); ?>
							</a>
							<?php
						} else {
							echo ent2ncr( $img );
						}
					}
					echo '</div>';
				}
			}
			?>
		</div>
	</div>
</div>

<script type="text/javascript">
	jQuery(document).ready(function () {
		"use strict";
		if (jQuery("body").hasClass("elementor-editor-active")) {
			var $thim_brands = jQuery('.thim-brands');
			$thim_brands.each(function () {
				var items_visible = jQuery(this).attr('data-items-visible'),
					items_tablet = jQuery(this).attr('data-items-tablet'),
					items_mobile = jQuery(this).attr('data-items-mobile');

				var navigation = (jQuery(this).attr('data-nav') == 'yes') ? true : false;
				var rtlval = false;
				if (jQuery('body').hasClass('rtl')) {
					var rtlval = true;
				}
				jQuery(this).find('.owl-carousel').owlCarousel({
						dots      : navigation,
						rtl       : rtlval,
						responsive: {
							0   : {
								items: items_mobile,
							},
							600 : {
								items: 2,
							},
							768 : {
								items: items_tablet,
							},
							1200: {
								items: items_visible,
							}
						},
					}
				)
			})
		}
	});
</script>
