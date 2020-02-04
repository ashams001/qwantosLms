<div class="thim-sc-image-box <?php echo esc_attr( $setting['layout'] ); ?> ">
	<section id="<?php echo esc_html( $setting['el_class'] ); ?>">
		<div class="row no-gutters">
			<div class="col-sm-12 col-lg-6 image-box">
				<img src="<?php echo wp_get_attachment_url( $setting['upload_image']['id'] ); ?>" alt="<?php echo esc_attr( $setting['title'] ); ?>">
				<span class="number" style="color: <?php echo esc_attr( $setting['number_color'] ); ?>"><?php echo esc_html( $setting['number'] ); ?></span>
			</div>
			<div class="col-sm-12 col-lg-6 text-content">
				<?php if ( $setting['bg_content'] ) : ?>
					<img src="<?php echo wp_get_attachment_url( $setting['bg_content']['id'] ); ?>" class="bg-content">
				<?php endif; ?>
				<div class="text-content-inner">
					<h3 class="title-box"><?php echo esc_html( $setting['title'] ); ?></h3>
					<p class="sub-title"><?php echo esc_html( $setting['sub-title'] ); ?></p>
					<p class="underline"></p>
					<div class="content"><?php echo $setting['content']; ?></div>
				</div>
			</div>
		</div>
	</section>
</div>
