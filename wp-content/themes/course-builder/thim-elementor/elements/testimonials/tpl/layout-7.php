<div class="slider-container">
	<div id="slider" class="owl-carousel">
		<?php $id = 0;
		foreach ( $params['testimonials'] as $key => $testimonial ) :
			$id ++;
			?>
			<div class="item" data-id="<?php echo esc_attr( $id ) ?>">
				<div class="images">
					<?php
					$thumbnail_id = (int) $testimonial['image']['id'];
					thim_thumbnail( $thumbnail_id, '404x404', 'attachment', false );
					?>
					<a href="<?php echo esc_html( $testimonial['website'] ) ?>" class="title" target="_blank">
						<i class="ion-ios-email-outline"></i>
					</a>
				</div>

				<div class="user-info">
					<img src="<?php echo THIM_CB_URL . '/testimonials/assets/images/icon-testimonial-7.png' ?>"
						 alt="icon">
					<?php echo esc_html( $testimonial['content'] ) ?>
					<div class="name"><?php echo esc_html( $testimonial['name'] ) ?></div>
					<div class="regency"><?php echo esc_html( $testimonial['regency'] ) ?></div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>

<script type="text/javascript">
	jQuery(document).ready(function () {
		"use strict";
		if (jQuery("body").hasClass("elementor-editor-active")) {
			var rtlval = false;
			if (jQuery('body').hasClass('rtl')) {
				var rtlval = true;
			}
			var $sc = jQuery('.thim-sc-testimonials.layout-7');
			var slider = $sc.find('#slider');

			// carousel function for main slider
			slider.owlCarousel({
				rtl     : rtlval,
				loop    : false,
				nav     : true,
				dots    : false,
				items   : 1,
				autoplay: false,
				single  : true
			});
		}
	});
</script>