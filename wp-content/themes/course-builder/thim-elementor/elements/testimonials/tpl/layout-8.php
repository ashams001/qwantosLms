<div class="slider-container">
	<div class="thumbnail-slider owl-carousel">
		<?php foreach ( $params['testimonials'] as $key => $testimonial ) : ?>
			<div class="item">
				<div class="content">
					<?php
					$thumbnail_id = (int) $testimonial['image']['id'];
					thim_thumbnail( $thumbnail_id, '85x85', 'attachment', false );
					?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<div class="slider owl-carousel">
		<?php foreach ( $params['testimonials'] as $key => $testimonial ) : ?>
			<div class="item">
				<div class="content">
					<?php echo $testimonial['content'] ?>
				</div>
				<div class="user-info">
					<?php if ( isset( $testimonial['website'] ) ) : ?>
						<a href="<?php echo esc_html( $testimonial['website'] ) ?>" class="title"
						   target="_blank"><?php echo esc_html( $testimonial['name'] ); ?></a>
					<?php else: ?>
						<?php echo esc_html( $testimonial['name'] ); ?>
					<?php endif; ?>
					<span class="regency"><?php echo esc_html( $testimonial['regency'] ) ?></span>
					<div class="star">
						<i class="ion ion-android-star"></i>
						<i class="ion ion-android-star"></i>
						<i class="ion ion-android-star"></i>
						<i class="ion ion-android-star"></i>
						<i class="ion ion-android-star"></i>
					</div>
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
			// reference for main items
			var $sc = jQuery('.thim-sc-testimonials.layout-8');
			var slider = $sc.find('.slider');
			// reference for thumbnail items
			var thumbnailSlider = $sc.find('.thumbnail-slider');
			//transition time in ms
			var duration = 250;

			// carousel function for main slider
			slider.owlCarousel({
				rtl  : rtlval,
				loop : false,
				nav  : true,
				items: 1
			}).on('changed.owl.carousel', function (e) {
				//On change of main item to trigger thumbnail item
				thumbnailSlider.trigger('to.owl.carousel', [e.item.index, duration, true]);
			});

			// carousel function for thumbnail slider
			thumbnailSlider.owlCarousel({
				rtl       : rtlval,
				loop      : false,
				center    : true, //to display the thumbnail item in center
				nav       : false,
				responsive: {
					0   : {
						items: 3
					},
					600 : {
						items: 4
					},
					1000: {
						items: 6
					}
				}
			}).on('click', '.owl-item', function () {
				// On click of thumbnail items to trigger same main item
				slider.trigger('to.owl.carousel', [$(this).index(), duration, true]);

			}).on('changed.owl.carousel', function (e) {
				// On change of thumbnail item to trigger main item
				slider.trigger('to.owl.carousel', [e.item.index, duration, true]);
			});
		}
	});
</script>