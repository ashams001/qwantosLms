<?php
$i             = 0;
$class_columns = '';
$row_index     = 1;
?>

<div class="thim-sc-new-image-box <?php echo $params['el_class']; ?>">
	<div class="row wrap-image-box">
		<?php foreach ( $params['image_box'] as $key => $image_box ) :

			if ( $row_index > 1 && ( $row_index - 1 ) % 3 == 0 ) {
				echo '<div class="row wrap-image-box">';
			}

			$i ++;
			if ( ( $i - 1 ) % 3 == 0 ) {
				$class_columns = 'first';
			} elseif ( ( $i % 2 ) == 0 ) {
				$class_columns = 'center';
			} else {
				$class_columns = 'last';
			}
			?>
			<div class="col-md-4 <?php echo esc_attr( $class_columns ); ?>">
				<div class="item">
					<div class="image">
						<?php
						$image_bk = wp_get_attachment_image_src( $image_box['upload_image_background'], '380x283' );
						$alt      = isset( $image_box['title'] ) ? $image_box['title'] : esc_attr__( 'Background Image Box', 'course-builder' );
						$image    = '<img class="image-background" src="' . $image_bk[0] . '" width="' . $image_bk[1] . '" height="' . $image_bk[2] . '" alt="' . $alt . '">';
						echo $image;
						?>
					</div>
					<div class="content <?php echo $image_box['layout']; ?>">
						<?php
						$image_icon = wp_get_attachment_image_src( $image_box['icon_image'], 'full' );
						$alt        = isset( $image_box['title'] ) ? $image_box['title'] : esc_attr__( 'Icon Image Box', 'course-builder' );
						$icon_image = '<img class="image-icon" src="' . $image_icon[0] . '" width="' . $image_icon[1] . '" height="' . $image_icon[2] . '" alt="' . $alt . '">';
						echo $icon_image;

						$link = isset( $image_box['link_title'] ) ? $image_box['link_title'] : '';
						?>
						<h6 class="title">
							<?php if ( $link ) { ?>
							<a href="<?php echo $link; ?>">
								<?php }
								echo $image_box['title'];
								if ( $link ) { ?>
							</a>
						<?php } ?>
						</h6>
					</div>
				</div>
			</div>
			<?php
			if ( $row_index > 1 && ( $row_index ) % 3 == 0 ) {
				echo '</div>';
			}
			$row_index ++;
			?>
		<?php endforeach; ?>
	</div>
</div>