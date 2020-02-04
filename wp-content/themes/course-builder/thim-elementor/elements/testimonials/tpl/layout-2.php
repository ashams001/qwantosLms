<?php

$items_visile = is_array( $params['testimonials'] ) ? count( $params['testimonials'] ) : 3;

?>

<div class="slider testimonial-slider" data-itemsvisible="<?php echo esc_attr( $items_visile ); ?>">
	<?php foreach ( $params['testimonials'] as $key => $testimonial ) : ?>
		<div class="item">
			<div class="content">
				<div class="image">
					<?php
					$thumbnail_id = (int) $testimonial['image']['id'];
					thim_thumbnail( $thumbnail_id, '130x130', 'attachment', false, 'no-lazy' );
					?>
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
				</div>


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


				<div class="description"><?php echo esc_html( $testimonial['content'] ) ?></div>

			</div>
		</div>
	<?php endforeach; ?>
</div>

<script type="text/javascript">
	jQuery(document).ready(function () {
		"use strict";
		if (jQuery("body").hasClass("elementor-editor-active")) {
			var $sc = jQuery('.thim-sc-testimonials.layout-2');

			$sc.each(function () {
				var elem = jQuery(this).find('.slider'),
					autoplay = elem.data('autoplay') ? true : false,
					mousewheel = elem.data('mousewheel') ? true : false,
					itemsvisible = elem.data('itemsvisible');
				var testimonial_slider = elem.thimContentSlider({
					items            : elem,
					itemsVisible     : itemsvisible,
					mouseWheel       : mousewheel,
					autoPlay         : autoplay,
					itemMaxWidth     : 130,
					itemMinWidth     : 108,
					activeItemRatio  : 1.35,
					activeItemPadding: 0,
					itemPadding      : -24
				});
			});
		}
	});
</script>