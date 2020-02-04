<div class="slider testimonial-slider">
	<?php foreach ( $params['testimonials'] as $key => $testimonial ) : ?>
		<div class="item">
			<div class="content">
				<div class="image">
					<?php
					$thumbnail_id = (int) $testimonial['image'];
					thim_thumbnail( $thumbnail_id, 'full', 'attachment', false, 'no-lazy' );
					?>
				</div>
				<?php
				$has_social = 'no-social';
				if ( isset( $testimonial['social_links'] ) ):
					$social_links = vc_param_group_parse_atts( $testimonial['social_links'] );
					if ( $social_links ): ?>
						<div class="thim-sc-social-links">
							<ul class="socials">
								<?php foreach ( $social_links as $index => $social ):
									if ( isset( $social['link'] ) && isset( $social['name'] ) ):
										$has_social = 'has-social';
										?>
										<li>
											<a target="_blank" href="<?php echo esc_url( $social['link'] ) ?>"><?php echo esc_html( $social['name'] ); ?></a>
										</li>
									<?php endif; ?>
								<?php endforeach; ?>
							</ul>
						</div>
					<?php endif; ?>
				<?php endif; ?>
				<div class="description <?php echo esc_attr( $has_social ); ?>"><?php echo esc_html( $testimonial['content'] ) ?></div>
				<div class="user-info">
					<?php if ( isset( $testimonial['website'] ) ) : ?>
						<a href="<?php echo esc_html( $testimonial['website'] ) ?>" class="title" target="_blank"><?php echo esc_html( $testimonial['name'] ); ?></a>
					<?php else: ?>
						<?php echo esc_html( $testimonial['name'] ); ?>
					<?php endif; ?>
					<span class="regency"><?php echo esc_html( $testimonial['regency'] ) ?></span>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
</div>