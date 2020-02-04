<div class="thim-sc-image-box <?php echo esc_attr( $params['layout'] ); ?> ">
	<section id="<?php echo esc_html( $params['el_class'] ); ?>">
		<div class="row no-gutters">
			<div class="col-sm-12 col-lg-6 image-box">
				<img src="<?php echo wp_get_attachment_url( $params['upload_image'] ); ?>" alt="<?php echo esc_attr( $params['title'] ); ?>">
				<span class="number" style="color: <?php echo esc_attr( $params['number_color'] ); ?>"><?php echo esc_html( $params['number'] ); ?></span>
			</div>
			<div class="col-sm-12 col-lg-6 text-content">
				<?php if($params['bg_content']) : ?>
					<img src="<?php echo wp_get_attachment_url( $params['bg_content'] ); ?>" class="bg-content" >
				<?php endif; ?>
				<div class="text-content-inner">
					<h3 class="title-box"><?php echo esc_html( $params['title'] ); ?></h3>
					<p class="sub-title"><?php echo esc_html( $params['sub-title'] ); ?></p>
					<p class="underline"></p>
					<div class="content"><?php echo wpb_js_remove_wpautop( $params['content'], true ); ?></div>
				</div>
			</div>
		</div>
	</section>
</div>
