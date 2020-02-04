<?php

if ( $setting['line_counter'] == 'yes' ) {
	$line_counter = 'has-line';
} else {
	$line_counter = 'no-line';
}

$counter_style = $setting['counter_style'];

if ( !$setting['el_class'] ) {
	$setting['el_class'] = $setting['counter_style'];
} else {
	$setting['el_class'] .= ' ' . $setting['counter_style'];
}

if ( $setting['counter_style'] != 'circle' ) {
	?>
	<div class="thim-sc-counter-box <?php echo esc_attr( $setting['el_class'] ); ?>"
		 data-line="<?php echo esc_attr( $line_counter ); ?>">
		<?php if ( $setting['title'] ) : ?>
			<h3 class="sc-title"><?php echo esc_html( $setting['title'] ); ?></h3>
		<?php endif; ?>

		<?php if ( $setting['counter_box'] ): ?>
			<?php foreach ( $setting['counter_box'] as $counter_box ): ?>
				<?php
				$number_counter_dis = 0;
				$number_counter     = $counter_box['number_counter'] ? intval( $counter_box['number_counter'] ) : 0;

				$style_title     = !empty( $counter_box['color_title'] ) ? 'color: ' . $counter_box['color_title'] : '';
				$style_icon      = !empty( $counter_box['color_icon'] ) ? 'color: ' . $counter_box['color_icon'] : '';
				$style_separator = !empty( $counter_box['color_separator'] ) ? 'background-color: ' . $counter_box['color_separator'] : '';
				$style_number    = !empty( $counter_box['color_number'] ) ? 'color: ' . $counter_box['color_number'] : '';

				if ( !empty( $counter_box['color_separator'] ) ) {
					if ( $counter_style == 'style-2' ) {
						$style_separator = 'background-color: ' . $counter_box['color_separator'];
					} else { // style 1
						$style_separator = 'background-image: radial-gradient(circle 5px,' . $counter_box['color_separator'] . ' 12%, transparent 16%)';
					}
				}
				?>
				<div class="counter_box <?php echo esc_attr( $line_counter ); ?>">
					<?php if ( $line_counter == 'has-line' ): ?>
						<span class="separator" style="<?php echo esc_attr( $style_separator ); ?>"></span>
					<?php endif; ?>

					<?php
					switch ( $counter_box['icon'] ) {
						case 'font_awesome':
							if ( !empty( $counter_box['font_awesome'] ) ) {
								?>
								<div class="icon_counter" style="<?php echo esc_attr( $style_icon ); ?>">
									<i class="icon_counter <?php echo esc_attr( $counter_box['font_awesome'] ) ?>"
									   aria-hidden="true"></i>
								</div>
								<?php
							}
							break;
						case 'font_ionicons':
							if ( !empty( $counter_box['font_ionicons'] ) ) {
								?>
								<div class="icon_counter" style="<?php echo esc_attr( $style_icon ); ?>">
									<i class="icon_counter <?php echo esc_attr( $counter_box['font_ionicons'] ) ?>"
									   aria-hidden="true"></i>
								</div>
								<?php
							}
							break;
						case 'upload_icon':
							if ( !empty( $counter_box['icon_upload'] ) ) {
								$icon_upload = wp_get_attachment_image_src( $counter_box['icon_upload'], 'full' );
								echo '<img class="image-upload" src="' . $icon_upload[0] . '">';
							}
							break;
					}
					?>

					<div class="number" style="<?php echo esc_attr( $style_number ); ?>">
						<?php
						if ( $number_counter ) {
							$thousands_sep = ( $counter_style == 'style-2' ) ? 0 : 1;

							$number_counter_output = '';
							if ( !empty( $counter_box['currency_counter'] ) ) {
								$number_counter_output .= '<span class="currency">' . $counter_box['currency_counter'] . '</span>';
							}

							$number_counter_output .= '<span class="number_counter" data-number="' . $number_counter . '" data-thousands-sep="' . $thousands_sep . '"></span>';

							if ( !empty( $counter_box['unit'] ) ) {
								$number_counter_output .= '<span class="text-number">' . $counter_box['unit'] . '</span>';
							}

							echo( $number_counter_output );
						}
						?>
					</div>

					<?php if ( !empty( $counter_box['title_counter'] ) ) : ?>
						<div class="title_counter">
							<h4 class="title"
								style="<?php echo esc_html( $style_title ); ?>"><?php echo esc_html( $counter_box['title_counter'] ); ?></h4>
						</div>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>

<?php } else {
	?>
	<div class="thim-sc-counter-box <?php echo esc_attr( $setting['el_class'] ); ?>">
		<div class="sc-counter-circle">
			<div class="center-icon">
				<?php
				$icon_upload_center = wp_get_attachment_image_src( $setting['icon_upload_center']['id'], 'full' );
				echo '<img class="image-upload" src="' . $icon_upload_center[0] . '">'; ?>
			</div>

			<?php
			$style_title_1 = !empty( $setting['color_title_1'] ) ? 'color: ' . $setting['color_title_1'] : '';
			$style_title_2 = !empty( $setting['color_title_2'] ) ? 'color: ' . $setting['color_title_2'] : '';
			$style_title_3 = !empty( $setting['color_title_3'] ) ? 'color: ' . $setting['color_title_3'] : '';
			$style_title_4 = !empty( $setting['color_title_4'] ) ? 'color: ' . $setting['color_title_4'] : '';

			$style_number_1 = !empty( $setting['color_number_1'] ) ? 'color: ' . $setting['color_number_1'] : '';
			$style_number_2 = !empty( $setting['color_number_2'] ) ? 'color: ' . $setting['color_number_2'] : '';
			$style_number_3 = !empty( $setting['color_number_3'] ) ? 'color: ' . $setting['color_number_3'] : '';
			$style_number_4 = !empty( $setting['color_number_4'] ) ? 'color: ' . $setting['color_number_4'] : '';

			$number_counter_1 = $setting['number_counter_1'] ? intval( $setting['number_counter_1'] ) : 0;
			$number_counter_2 = $setting['number_counter_2'] ? intval( $setting['number_counter_2'] ) : 0;
			$number_counter_3 = $setting['number_counter_3'] ? intval( $setting['number_counter_3'] ) : 0;
			$number_counter_4 = $setting['number_counter_4'] ? intval( $setting['number_counter_4'] ) : 0;
			?>

			<div class="item-counter-box">
				<div class="number" style="<?php echo esc_attr( $style_number_1 ); ?>">
					<?php
					if ( $number_counter_1 ) {
						echo '<span class="number_counter" data-number="' . $number_counter_1 . '"></span>';
						if ( !empty( $setting['unit_1'] ) ) {
							echo '<span class="text-number">' . $setting['unit_1'] . '</span>';
						}
					}
					?>
					<?php if ( !empty( $setting['title_counter_1'] ) ) : ?>
						<div class="title_counter">
							<h4 class="title"
								style="<?php echo esc_html( $style_title_1 ); ?>"><?php echo esc_html( $setting['title_counter_1'] ); ?></h4>
						</div>
					<?php endif; ?>
				</div>
			</div>
			<div class="item-counter-box">
				<div class="number" style="<?php echo esc_attr( $style_number_2 ); ?>">
					<?php
					if ( $number_counter_2 ) {
						echo '<span class="number_counter" data-number="' . $number_counter_2 . '"></span>';
						if ( !empty( $setting['unit_2'] ) ) {
							echo '<span class="text-number">' . $setting['unit_2'] . '</span>';
						}
					}
					?>
					<?php if ( !empty( $setting['title_counter_2'] ) ) : ?>
						<div class="title_counter">
							<h4 class="title"
								style="<?php echo esc_html( $style_title_2 ); ?>"><?php echo esc_html( $setting['title_counter_2'] ); ?></h4>
						</div>
					<?php endif; ?>
				</div>
			</div>
			<div class="item-counter-box">
				<div class="number" style="<?php echo esc_attr( $style_number_3 ); ?>">
					<?php
					if ( $number_counter_3 ) {
						echo '<span class="number_counter" data-number="' . $number_counter_3 . '"></span>';
						if ( !empty( $setting['unit_3'] ) ) {
							echo '<span class="text-number">' . $setting['unit_3'] . '</span>';
						}
					}
					?>
					<?php if ( !empty( $setting['title_counter_3'] ) ) : ?>
						<div class="title_counter">
							<h4 class="title"
								style="<?php echo esc_html( $style_title_3 ); ?>"><?php echo esc_html( $setting['title_counter_3'] ); ?></h4>
						</div>
					<?php endif; ?>
				</div>
			</div>
			<div class="item-counter-box">
				<div class="number" style="<?php echo esc_attr( $style_number_4 ); ?>">
					<?php
					if ( $number_counter_4 ) {
						echo '<span class="number_counter" data-number="' . $number_counter_4 . '"></span>';
						if ( !empty( $setting['unit_4'] ) ) {
							echo '<span class="text-number">' . $setting['unit_4'] . '</span>';
						}
					}
					?>
					<?php if ( !empty( $setting['title_counter_4'] ) ) : ?>
						<div class="title_counter">
							<h4 class="title"
								style="<?php echo esc_html( $style_title_4 ); ?>"><?php echo esc_html( $setting['title_counter_4'] ); ?></h4>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
<?php } ?>

<script type="text/javascript">
	jQuery(document).ready(function () {
		"use strict";
		if (jQuery("body").hasClass("elementor-editor-active")) {
			jQuery('.thim-sc-counter-box').waypoint(function () {
				jQuery('.thim-sc-counter-box .counter_box .number_counter').each(function () {
					var number = jQuery(this).data('number'),
						thousands_sep = jQuery(this).data('thousands-sep');
					if (number == '') {
						jQuery(this).addClass('number-none');
					}
					var count_args = {
						from: number,
						to  : number
					};
					if (1 === thousands_sep) {
						count_args.formatter = function (value, options) {
							return value.toLocaleString();
						}
					}
					jQuery(this).countTo({
						from           : 0,
						to             : number,
						refreshInterval: 40,
						speed          : 1000,
						onComplete     : function (value) {
							jQuery(this).countTo(count_args);
						}
					});
				});
			}, {
				triggerOnce: true,
				offset     : 'bottom-in-view'
			});
		}
	});
</script>