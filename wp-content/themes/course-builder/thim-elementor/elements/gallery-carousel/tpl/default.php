<?php

$navigation = empty( $setting['nav'] ) ? 'no' : 'yes';
?>
<div class="thim-gallery-carousel  <?php echo esc_attr( $setting["el_class"] ); ?>" data-nav="<?php echo esc_attr( $navigation ); ?>">
	<div class="gallery-carousel owl-carousel owl-theme">
		<?php
		if ( $setting['items'] ) {
			foreach ( $setting['items'] as $key => $gallery ) {
				echo '<div class="item-gallery">';
				if ( isset( $gallery['gallery_img'] ) ) {
					$thumbnail_id = (int) $gallery['gallery_img']['id'];
					thim_thumbnail( $thumbnail_id, '1516x652', 'attachment', false, 'no-lazy' );
					if ( isset( $gallery['gallery_title'] ) || isset( $gallery['gallery_subtitle'] ) ) {
						echo '<div class="info">';
						echo '<h3>' . ent2ncr( $gallery['gallery_title'] ) . '</h3>';
						echo '<h4>' . ent2ncr( $gallery['gallery_subtitle'] ) . '</h4>';
						echo '</div>';
					}
				}
				echo '</div>';
			}
		}
		?>
	</div>
</div>

<script type="text/javascript">
	jQuery(document).ready(function () {
		"use strict";
		if (jQuery("body").hasClass("elementor-editor-active")) {
			var $thim_gallery_carousel = jQuery('.thim-gallery-carousel');

			$thim_gallery_carousel.each(function () {

				var navigation = (jQuery(this).attr('data-nav') == 'yes') ? true : false;
				var rtlval = false;
				if(jQuery('body').hasClass('rtl')) {
					var rtlval = true;
				}
				jQuery(this).find('.owl-carousel').owlCarousel({
						rtl: rtlval,
						dots: navigation,
						items: 1,
					}
				)
			})
		}
	});
</script>