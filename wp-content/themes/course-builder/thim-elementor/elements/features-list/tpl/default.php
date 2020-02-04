<div class="thim-sc-features-list <?php echo esc_attr( $setting['style'] ); ?> <?php echo esc_attr( $setting['el_class'] ); ?>">
	<?php if ( $setting['title'] ): ?>
		<h3 class="title">
			<?php echo esc_attr( $setting['title'] ) ?>
		</h3>
	<?php endif; ?>
	<ul class="meta-content">
		<?php
		$rank = 0;
		foreach ( $setting['features_list'] as $features ):
			$rank ++;
			?>
			<li>
			<?php if ( $features['sub_title'] ) : ?>
			<h4 class="sub-title">
					<span class="rank">
						<span class="number"><?php echo esc_attr( $rank ); ?></span>
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 220 220" width="100%" height="100%" preserveAspectRatio="none">
							<defs>
						    <linearGradient id="gradient">
						      <stop offset="0" class="stop1" />
						      <stop offset="0.6" class="stop2" />
						    </linearGradient>
						  </defs>
						  <ellipse ry="100" rx="100" cy="110" cx="110" style="fill:none;stroke:url(#gradient);stroke-width:4;" />
						</svg>
					</span>
				<?php if ( !empty( $features['link'] ) ) { ?>
					<a href="<?php echo esc_attr( $features['link']['url'] ) ?>" target="<?php echo esc_attr( $features['link']['is_external'] ) ?>">
						<?php echo esc_attr( $features['sub_title'] ); ?>
					</a>
				<?php } else {
					echo esc_attr( $features['sub_title'] );
				} ?>
			</h4>
		<?php endif;
			if ( $features['sub_title'] ) : ?>
				<p class="description">
					<?php echo esc_attr( $features['description'] ) ?>
				</p>
				</li>
			<?php endif;
		endforeach; ?>
	</ul>
</div>