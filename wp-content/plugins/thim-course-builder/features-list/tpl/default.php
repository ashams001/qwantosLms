<div class="thim-sc-features-list <?php echo esc_attr( $params['style'] ); ?> <?php echo esc_attr( $params['el_class'] ); ?>">
	<?php if ( $params['title'] ): ?>
		<h3 class="title">
			<?php echo esc_attr( $params['title'] ) ?>
		</h3>
	<?php endif; ?>
	<ul class="meta-content">
		<?php
		$rank = 0;
		foreach ( $params['features_list'] as $features ):
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
						      <stop offset="0" class="stop1"  />
						      <stop offset="0.6"class="stop2"  />
						    </linearGradient>
						  </defs>
						  <ellipse ry="100" rx="100" cy="110" cx="110" style="fill:none;stroke:url(#gradient);stroke-width:4;" />
						</svg>
					</span>
                <?php if ( ! empty( $features['link'] )) {
                    $link_detail = vc_build_link( $features['link'] ); ?>
                    <a href="<?php echo esc_attr( $link_detail['url'] ) ?>" target="<?php echo esc_attr( $link_detail['target'] ) ?>">
                        <?php echo esc_attr( $features['sub_title'] ); ?>
                    </a>
                <?php } else {
                    echo esc_attr( $features['sub_title'] );
                }?>
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