<div class="thim-sc-scroll-heading <?php echo esc_attr( $params['el_class'] ); ?>">
	<?php if ( $params['titles'] ) : ?>
		<?php foreach ( $params['titles'] as $key => $titles ) : ?>
			<?php if ( $titles['class'] && $titles['title'] ): ?>
				<div class="title"
					 data-scroll-to="#<?php echo esc_attr( $titles['class'] ); ?>"
					 data-scroll-speed="<?php echo esc_attr( $params['scroll_speed'] ); ?>"
					 data-scroll-offset="<?php echo esc_attr( $params['scroll_offset'] ); ?>">
					<div class="text"><?php echo esc_attr( $titles['title'] ); ?></div>
				</div>
			<?php endif; ?>
		<?php endforeach; ?>
	<?php endif; ?>
</div>

<script type="text/javascript">
	jQuery(document).ready(function () {
		"use strict";
		if (jQuery("body").hasClass("elementor-editor-active")) {
			jQuery(".thim-sc-scroll-heading [data-scroll-to]").on('click', function () {
				var $this = jQuery(this),
					$toElement = $this.attr('data-scroll-to'),
					$offset = $this.attr('data-scroll-offset') * 1 || 0,
					$speed = $this.attr('data-scroll-speed') * 1 || 500;

				jQuery('html, body').animate({
					scrollTop: jQuery($toElement).offset().top + $offset
				}, $speed);
			});
		}
	});
</script>



