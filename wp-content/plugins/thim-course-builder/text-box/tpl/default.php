<div class="thim-sc-text-box <?php echo esc_attr( $params['style'] ); ?> <?php echo esc_attr( $params['size_style'] ); ?> <?php echo esc_attr( $params['el_class'] ); ?>">
	<?php if ( $params['title_1'] ): ?>
		<div class="title-1"><?php echo ent2ncr( $params['title_1'] ); ?></div>
	<?php endif; ?>

	<?php if ( $params['content'] ): ?>
		<div class="title-2"><?php echo ent2ncr( $params['content'] ); ?></div>
	<?php endif; ?>

	<?php
	if ( $params['button'] ) {
		$link_detail = vc_build_link( $params['button'] );

		$link_detail['url'] = $link_detail['url'] ? esc_url( $link_detail['url'] ) : "#";

		$link_detail['target'] = $link_detail['target'] ? ' target="' . esc_attr( $link_detail['target'] ) . '"' : '';
		$link_detail['rel']    = $link_detail['rel'] ? ' rel="' . esc_attr( $link_detail['rel'] ) . '"' : '';
		$link_output           = $link_detail['target'] . $link_detail['rel'];

		echo '<a href="' . ( $link_detail['url'] ) . '"' . ( $link_output ) . ' class="btn btn-default"><span class="text">' . esc_html( $link_detail['title'] ) . '</span></a>';
	}
	?>
</div>
