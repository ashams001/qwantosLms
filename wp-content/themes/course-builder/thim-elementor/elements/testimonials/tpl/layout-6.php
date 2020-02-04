<div class="slider-container">

	<div id="slider" class="owl-carousel">
		<?php foreach ( $params['testimonials'] as $key => $testimonial ) : ?>
			<div class="item">
				<?php echo esc_html( $testimonial['content'] ) ?>
			</div>
		<?php endforeach; ?>
	</div>

	<div id="thumbnails" class="owl-carousel">
		<?php $id = 0;
		foreach ( $params['testimonials'] as $key => $testimonial ) :
			$id ++;
			?>
			<div class="item" data-id="<?php echo esc_attr( $id ) ?>">
				<?php
				$thumbnail_id = (int) $testimonial['image']['id'];
				thim_thumbnail( $thumbnail_id, '57x57', 'attachment', false );
				?>
				<div class="user-info">
					<?php if ( isset( $testimonial['website'] ) ) : ?>
						<a href="<?php echo esc_html( $testimonial['website'] ) ?>" class="title"
						   target="_blank"><?php echo esc_html( $testimonial['name'] ); ?></a>
					<?php else: ?>
						<div
							class="name"><?php echo esc_html( $testimonial['name'] ) ?></div>                    <?php endif; ?>
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
			var $sc = jQuery('.thim-sc-testimonials.layout-6');
			var sync1 = $sc.find('#slider');
			var sync2 = $sc.find('#thumbnails');
			var flag = false;
			var slides = sync1.owlCarousel({
				items    : 1,
				nav      : false,
				mouseDrag: false,
				loop     : true
			}).on('change.owl.carousel', function (e) {
				if (e.namespace && e.property.name === 'position' && !flag) {
					flag = true;
					thumbs.to(e.relatedTarget.relative(e.property.value), 300, true);
					flag = false;
				}
			}).data('owl.carousel');
			var thumbs = sync2.owlCarousel({
				responsive: {
					0   : {
						items: 1
					},
					768 : {
						items: 2
					},
					1000: {
						items: 3
					}
				},
				rtl       : rtlval,
				center    : true,
				loop      : true,
				nav       : true,
				navText   : ["<i class='ion-ios-arrow-left'></i>", "<i class='ion-ios-arrow-right'></i>"],
				mouseDrag : false
			}).on('click', '.item', function (e) {
				e.preventDefault();
				var sliderIndex = parseInt(jQuery(this).attr('data-id'));
				sync1.trigger('to.owl.carousel', [sliderIndex - 1, 300, true]);
			}).on('change.owl.carousel', function (e) {
				if (e.namespace && e.property.name === 'position' && !flag) {
					flag = true;
					slides.to(e.relatedTarget.relative(e.property.value), 300, true);
					flag = false;
				}
			}).data('owl.carousel');
		}
	});
</script>