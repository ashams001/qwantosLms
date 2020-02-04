<?php
$unique_id = uniqid( 'thim_' );

$html_nav = $html_tab_content = '';

if ( $params['steps'] ):
	$active = 'active';
	foreach ( $params['steps'] as $key => $step ) {
		if ( $key != 0 ) {
			$active = '';
		}

		$tab_id    = $unique_id . '-step-' . $key;
		$step_text = ( $key + 1 ) . '<span>' . $params['circle-text'] . '</span>';

		switch ( $step['icon'] ) {
			case 'upload_icon':
				if ( !empty( $step['icon_upload'] ) ) {
					$icon_upload = wp_get_attachment_image_src( $step['icon_upload'], 'full' );
					$alt         = isset( $params['icon_title'] ) ? $params['icon_title'] : esc_attr__( 'Icon', 'course-builder' );
					$icon        = '<img class="image-upload" src="' . $icon_upload[0] . '" width="' . $icon_upload[1] . '" height="' . $icon_upload[2] . '" alt="' . $alt . '">';
				}
				break;
			case 'font_ionicons':
				if ( !empty( $step['font_ionicons'] ) ) {
					$icon = '<i class="step-icon icon-ionicons ' . $step['font_ionicons'] . '" aria-hidden="true"></i>';
				}
				break;
			default:
				if ( !empty($step['font_awesome']) ) {
					$icon = '<i class="step-icon icon-fontawesome ' . $step['font_awesome'] . '" aria-hidden="true"></i>';
				}
		}

		if (!empty($icon)){
			$step_text = $icon;
		}

		$html_nav .= '<li class="nav-item ' . $active . '" data-toggle="tab" href="#' . $tab_id . '" role="tab"><a class="nav-link">' . $step_text . '</a>';
		$html_nav .= '<p class="tab-title">' . $step['title'] . '</p>';
		$html_nav .= '</li>';
		$html_tab_content .= '<div class="tab-pane ' . $active . '" id="' . $tab_id . '" role="tabpanel">';
		$html_tab_content .= '<h4 class="tab-title">' . $step['title'] . '</h4>';
		if ( ! empty( $step['description'] ) ) {
			$html_tab_content .= '<p class="description">' . $step['description'] . '</p>';
		}
		if ( !empty($step['readmore'])) {
			$html_tab_content .= '<a href="' . $step['readmore'] . '" class="readmore">' . esc_attr__( 'Read More', 'course-builder' ) . '</a>';
		}
		$html_tab_content .= '</div>';
	}
endif;
?>
<div class="container">
	<div class="row">
		<div class="col-md-12 heading">
			<div class="steps-wrapper">
				<?php if ( ! empty( $params['title'] ) ): ?>
					<h3 class="sc-title">
						<?php
						$title = wp_kses( $params['title'], array( 'br' => array() ) );
						echo( $title );
						?>
					</h3>
				<?php endif; ?>
				<div class="steps">
					<ul class="nav" role="tablist">
						<?php echo ent2ncr( $html_nav ); ?>
					</ul>
				</div>
			</div>
		</div>

		<div class="col-md-6 media-box">
			<div class="media-wrapper">
				<?php thim_thumbnail( $params['image'], 'full', 'attachment', false ); ?>
			</div>
		</div>

		<div class="col-md-6 content-box">
			<div class="steps-wrapper">
				<div class="steps">
					<div class="tab-content">
						<?php echo ent2ncr( $html_tab_content ); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
$background_src = wp_get_attachment_image_src( $params['background_image'], 'full' );
$bg_style       = '';
$bg_style .= 'background-image: url(' . esc_url( $background_src[0] ) . ');';
?>
<div class="background-overlay" style="<?php echo esc_attr( $bg_style ); ?>"></div>