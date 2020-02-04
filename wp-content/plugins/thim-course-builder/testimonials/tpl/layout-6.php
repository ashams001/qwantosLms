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
			$id++;
			?>
			<div class="item" data-id="<?php echo esc_attr($id)?>">
				<?php
				$thumbnail_id = (int) $testimonial['image'];
				thim_thumbnail( $thumbnail_id, '57x57', 'attachment', false );
				?>
				<div class="user-info">
					<?php if ( isset( $testimonial['website'] ) ) : ?>
						<a href="<?php echo esc_html( $testimonial['website'] ) ?>" class="title" target="_blank"><?php echo esc_html( $testimonial['name'] ); ?></a>
					<?php else: ?>
						<div class="name"><?php echo esc_html( $testimonial['name'] ) ?></div>                    <?php endif; ?>
					<div class="regency"><?php echo esc_html( $testimonial['regency'] ) ?></div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>

</div>