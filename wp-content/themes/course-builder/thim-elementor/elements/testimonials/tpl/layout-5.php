<div class="slider-container">
	<div class="slider owl-carousel owl-theme">
		<?php foreach ( $params['testimonials'] as $key => $testimonial ) : ?>
			<div class="item">
				<?php if ( isset( $testimonial['image']['id'] ) ) : ?>
					<div class="image">
						<?php $thumbnail_id = (int) $testimonial['image']['id'];
						thim_thumbnail( $thumbnail_id, '743x456', 'attachment', false );
						?>
					</div>
				<?php endif; ?>
				<div class="content-wrap">
					<div class="content">
						<?php echo esc_html( $testimonial['content'] ) ?>
					</div>
					<div class="user-info">
						<?php if ( isset( $testimonial['website'] ) ) : ?>
							<a href="<?php echo esc_html( $testimonial['website'] ) ?>" class="title"
							   target="_blank"><?php echo esc_html( $testimonial['name'] ); ?></a>
						<?php else: ?>
							<?php echo esc_html( $testimonial['name'] ); ?>
						<?php endif; ?>
						<?php if ( isset( $testimonial['regency'] ) ) : ?>
							<span class="regency"><?php echo esc_html( $testimonial['regency'] ) ?></span>
						<?php endif; ?>

						<div class="thim-sc-social-links">
							<ul class="socials">
								<?php if ( $testimonial['show_facebook'] == 'yes' ): ?>
									<li>
										<a target="_blank"
										   href="<?php echo esc_url( $testimonial['link_facebook'] ) ?>"><?php echo esc_html( $testimonial['name_social_facebook'] ); ?></a>
									</li>
								<?php endif; ?>
								<?php if ( $testimonial['show_dribbble'] == 'yes' ): ?>
									<li>
										<a target="_blank"
										   href="<?php echo esc_url( $testimonial['link_dribbble'] ) ?>"><?php echo esc_html( $testimonial['name_social_dribbble'] ); ?></a>
									</li>
								<?php endif; ?>
								<?php if ( $testimonial['show_instagram'] == 'yes' ): ?>
									<li>
										<a target="_blank"
										   href="<?php echo esc_url( $testimonial['link_instagram'] ) ?>"><?php echo esc_html( $testimonial['name_social_instagram'] ); ?></a>
									</li>
								<?php endif; ?>
								<?php if ( $testimonial['show_twitter'] == 'yes' ): ?>
									<li>
										<a target="_blank"
										   href="<?php echo esc_url( $testimonial['link_twitter'] ) ?>"><?php echo esc_html( $testimonial['name_social_twitter'] ); ?></a>
									</li>
								<?php endif; ?>
								<?php if ( $testimonial['show_youtube'] == 'yes' ): ?>
									<li>
										<a target="_blank"
										   href="<?php echo esc_url( $testimonial['link_youtube'] ) ?>"><?php echo esc_html( $testimonial['name_social_youtube'] ); ?></a>
									</li>
								<?php endif; ?>
								<?php if ( $testimonial['show_google'] == 'yes' ): ?>
									<li>
										<a target="_blank"
										   href="<?php echo esc_url( $testimonial['link_google'] ) ?>"><?php echo esc_html( $testimonial['name_social_google'] ); ?></a>
									</li>
								<?php endif; ?>
							</ul>
						</div>
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
			var $sc = jQuery('.thim-sc-testimonials.layout-5');
			var slider = $sc.find('.slider');

			// carousel function for main slider
			slider.owlCarousel({
				rtl     : rtlval,
				loop    : false,
				nav     : false,
				dots    : true,
				items   : 1,
				autoplay: true,
				single  : true
			});
		}
	});
</script>