<div class="thim-sc-text-box <?php echo esc_attr( $setting['style'] ); ?> <?php echo esc_attr( $setting['size_style'] ); ?> <?php echo esc_attr( $setting['el_class'] ); ?>">
	<?php if ( $setting['title_1'] ): ?>
		<div class="title-1"><?php echo ent2ncr( $setting['title_1'] ); ?></div>
	<?php endif; ?>

	<?php if ( $setting['content'] ): ?>
		<div class="title-2"><?php echo ent2ncr( $setting['content'] ); ?></div>
	<?php endif; ?>

	<?php
	if ( $setting['button']['url'] ) {
		$link_detail = $setting['button'];

		$link_detail['url']         = $link_detail['url'] ? esc_url( $link_detail['url'] ) : "#";
		$link_detail['is_external'] = $link_detail['is_external'] ? ' target="_blank"' : '';
		$link_detail['nofollow']    = $link_detail['nofollow'] ? ' rel="nofollow"' : '';
		$link_output                = $link_detail['is_external'] . $link_detail['nofollow'];

		echo '<a href="' . ( $link_detail['url'] ) . '"' . ( $link_output ) . ' class="btn btn-default"><span class="text">' . esc_html( $setting['button_text'] ) . '</span></a>';
	}
	?>
</div>
