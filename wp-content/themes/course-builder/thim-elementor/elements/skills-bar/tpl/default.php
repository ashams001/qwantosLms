<div class="thim-sc-skills-bar <?php echo esc_attr( $params['el_class'] ); ?>">
	<?php if ( $params['skills_bar'] ): ?>
		<?php foreach ( $params['skills_bar'] as $skills_bar ): ?>
			<?php
			$style_title       = $style_numbertitle = '';
			$style_title       .= 'color:' . $skills_bar['color'];
			$style_numbertitle .= 'color:' . $skills_bar['numbertitle'];
			?>

			<div class="circle" data-value="<?php echo esc_attr( $skills_bar['number'] ) ?>"
				 data-color="<?php echo esc_attr( $skills_bar['color'] ) ?>"
				 data-emptyfill="<?php echo esc_attr( $skills_bar['emptyfill'] ) ?>">
				<p class="number"
				   style="<?php echo esc_attr( $style_numbertitle ); ?>"> <?php echo esc_html( $skills_bar['number'] ) ?> </p>
				<p class="title"
				   style="<?php echo esc_attr( $style_title ); ?>"><?php echo esc_html( $skills_bar['title'] ) ?></p>
				<?php if ( isset( $skills_bar['sub_title'] ) ) { ?>
					<p class="sub-title"
					   style="<?php echo esc_attr( $style_numbertitle ); ?>"><?php echo esc_html( $skills_bar['sub_title'] ) ?></p>
				<?php } ?>
			</div>
		<?php endforeach; ?>
	<?php endif ?>
</div>

<script type="text/javascript">
	jQuery(document).ready(function () {
		"use strict";
		if (jQuery("body").hasClass("elementor-editor-active")) {
			jQuery('.thim-sc-skills-bar').each(function (index, element) {
				var circle = jQuery(element).find('.circle');
				jQuery(circle).each(function (i, ele) {
					var value = jQuery(ele).attr('data-value');
					var color = jQuery(ele).attr('data-color');
					var emptyfill = jQuery(ele).attr('data-emptyfill');
					var number = 0;
					var number2 = (parseInt(value / 100) + 1) * 100;
					if (value > 100) {
						number = value / number2;
					} else {
						number = value / 100;
					}
					jQuery(ele).circleProgress({
						value     : number,
						thickness : 4,
						animation : {duration: 3500, easing: "circleProgressEasing"},
						fill      : {
							color: color
						},
						emptyFill : emptyfill,
						startAngle: -1.5
					}).on('circle-animation-progress', function (event, progress) {
						jQuery(ele).find('.number').html(Math.round(value * progress));
					});
				});
			});
		}
	});
</script>