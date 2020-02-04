<?php $data = esc_attr( $setting['time'] ); ?>
<div class="thim-sc-count-down <?php echo esc_attr( $setting['el_class'] ); ?>" data-countdown="<?php echo date_format( date_create( esc_attr( $data ) ), ( 'Y/m/d H:i' ) ); ?>">
	<div class="title"><?php echo ( isset( $setting['title'] ) ) ? esc_attr( $setting['title'] ) : '' ?><?php echo ' ' . date_format( date_create( esc_attr( $data ) ), ( 'D M jS H:i' ) ); ?> </div>
	<div class="counter">
		<?php
		if ( $setting['style'] == 'style2' ) { ?>
			<div class="days count-item">
				<span class="label"><?php esc_html_e( 'Day(s)', 'course-builder' ); ?></span>
				<span class="number"></span>
			</div>
			<div class="hours count-item">
				<span class="label"><?php esc_html_e( 'Hour(s)', 'course-builder' ); ?></span>
				<span class="number"></span>
			</div>
			<div class="minutes count-item">
				<span class="label"><?php esc_html_e( 'Minute(s)', 'course-builder' ); ?></span>
				<span class="number"></span>
			</div>
			<div class="seconds count-item">
				<span class="label"><?php esc_html_e( 'Second(s)', 'course-builder' ); ?></span>
				<span class="number"></span>
			</div>
		<?php } else { ?>
			<div class="days count-item">
				<span class="number"></span>
				<span class="label"><?php esc_html_e( 'Day(s)', 'course-builder' ); ?></span>
			</div>
			<div class="hours count-item">
				<span class="number"></span>
				<span class="label"><?php esc_html_e( 'Hour(s)', 'course-builder' ); ?></span>
			</div>
			<div class="minutes count-item">
				<span class="number"></span>
				<span class="label"><?php esc_html_e( 'Minute(s)', 'course-builder' ); ?></span>
			</div>
			<div class="seconds count-item">
				<span class="number"></span>
				<span class="label"><?php esc_html_e( 'Second(s)', 'course-builder' ); ?></span>
			</div>
		<?php }
		?>
	</div>
</div>

<script type="text/javascript">
	jQuery(document).ready(function () {
		"use strict";
		if (jQuery("body").hasClass("elementor-editor-active")) {
			jQuery('.thim-sc-count-down').each(function() {
				var $this = jQuery(this),
					finalDate = jQuery(this).attr('data-countdown');
				$this.countdown(finalDate, function(event) {
					$this.find('.days .number').text(
						event.strftime('%D')
					);
					$this.find('.hours .number').text(
						event.strftime('%H')
					);
					$this.find('.minutes .number').text(
						event.strftime('%M')
					);
					$this.find('.seconds .number').text(
						event.strftime('%S')
					);
				});
			});
		}
	});
</script>

