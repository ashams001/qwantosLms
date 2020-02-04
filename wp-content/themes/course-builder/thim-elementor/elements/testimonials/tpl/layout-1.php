<div class="slider-container">
	<div class="slider owl-carousel">
		<?php foreach ( $params['testimonials'] as $key => $testimonial ) : ?>
			<div class="item">
				<div class="content">
					<?php echo esc_html( $testimonial['content'] ) ?>
				</div>
				<div class="user-info">
					<?php if ( isset( $testimonial['website'] ) ) : ?>
						<a href="<?php echo esc_html( $testimonial['website'] ) ?>" class="title" target="_blank"><?php echo esc_html( $testimonial['name'] ); ?></a>
					<?php else: ?>
						<?php echo esc_html( $testimonial['name'] ); ?>
					<?php endif; ?>
					<span class="regency"><?php echo esc_html( $testimonial['regency'] ) ?></span>
				</div>
				<div class="thim-sc-social-links">
					<ul class="socials">
						<?php if ( $testimonial['show_facebook'] == 'yes' ): ?>
							<li>
								<a target="_blank" href="<?php echo esc_url( $testimonial['link_facebook'] ) ?>"><?php echo esc_html( $testimonial['name_social_facebook'] ); ?></a>
							</li>
						<?php endif; ?>
						<?php if ( $testimonial['show_dribbble'] == 'yes' ): ?>
							<li>
								<a target="_blank" href="<?php echo esc_url( $testimonial['link_dribbble'] ) ?>"><?php echo esc_html( $testimonial['name_social_dribbble'] ); ?></a>
							</li>
						<?php endif; ?>
						<?php if ( $testimonial['show_instagram'] == 'yes' ): ?>
							<li>
								<a target="_blank" href="<?php echo esc_url( $testimonial['link_instagram'] ) ?>"><?php echo esc_html( $testimonial['name_social_instagram'] ); ?></a>
							</li>
						<?php endif; ?>
						<?php if ( $testimonial['show_twitter'] == 'yes' ): ?>
							<li>
								<a target="_blank" href="<?php echo esc_url( $testimonial['link_twitter'] ) ?>"><?php echo esc_html( $testimonial['name_social_twitter'] ); ?></a>
							</li>
						<?php endif; ?>
						<?php if ( $testimonial['show_youtube'] == 'yes' ): ?>
							<li>
								<a target="_blank" href="<?php echo esc_url( $testimonial['link_youtube'] ) ?>"><?php echo esc_html( $testimonial['name_social_youtube'] ); ?></a>
							</li>
						<?php endif; ?>
						<?php if ( $testimonial['show_google'] == 'yes' ): ?>
							<li>
								<a target="_blank" href="<?php echo esc_url( $testimonial['link_google'] ) ?>"><?php echo esc_html( $testimonial['name_social_google'] ); ?></a>
							</li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
		<?php endforeach; ?>
	</div>

	<div class="slider-controls">
		<a class="slider-left" href="javascript:;"></a>
		<a class="slider-right" href="javascript:;"></a>
	</div>

	<div class="thumbnail-slider owl-carousel">
		<?php foreach ( $params['testimonials'] as $key => $testimonial ) : ?>
			<div class="item">
				<div class="content">
					<?php
					$thumbnail_id = (int) $testimonial['image']['id'];
					thim_thumbnail( $thumbnail_id, '68x68', 'attachment', false );
					?>
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
			var $sc = jQuery('.thim-sc-testimonials.layout-1');
			var slider = $sc.find('.slider');
			// reference for thumbnail items
			var thumbnailSlider = $sc.find('.thumbnail-slider');
			//transition time in ms
			var duration = 250;

			// carousel function for main slider
			slider.owlCarousel({
				rtl: rtlval,
				loop : false,
				nav  : false,
				items: 1
			}).on('changed.owl.carousel', function (e) {
				//On change of main item to trigger thumbnail item
				thumbnailSlider.trigger('to.owl.carousel', [e.item.index, duration, true]);
			});

			// carousel function for thumbnail slider
			thumbnailSlider.owlCarousel({
				rtl: rtlval,
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
				slider.trigger('to.owl.carousel', [jQuery(this).index(), duration, true]);

			}).on('changed.owl.carousel', function (e) {
				// On change of thumbnail item to trigger main item
				slider.trigger('to.owl.carousel', [e.item.index, duration, true]);
			});


			//These two are navigation for main items
			$sc.on('click', '.slider-right', function () {
				slider.trigger('next.owl.carousel');
			});
			$sc.on('click', '.slider-left', function () {
				slider.trigger('prev.owl.carousel');
			});
		}
	});
</script>