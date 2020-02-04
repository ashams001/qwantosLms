<?php

global $post;

$limit      = !empty( $params['limit'] ) ? $params['limit'] : 8;
$filter     = isset( $params['filter'] ) ? $params['filter'] : true;
$columns    = !empty( $params['columns'] ) ? $params['columns'] : 4;

$query_args = array(
	'post_type'      => 'post',
	'tax_query'      => array(
		array(
			'taxonomy' => 'post_format',
			'field'    => 'slug',
			'terms'    => array( 'post-format-gallery' ),
		)
	),
	'posts_per_page' => $limit
);

if ( !empty( $params['cat'] ) ) {
	if ( '' != get_cat_name( $params['cat'] ) ) {
		$query_args['cat'] = $params['cat'];
	}
}

switch ( $columns ) {
	case 2:
		$class_col = "col-sm-6";
		break;
	case 3:
		$class_col = "col-sm-4";
		break;
	case 4:
		$class_col = "col-sm-3";
		break;
	case 5:
		$class_col = "thim-col-5";
		break;
	case 6:
		$class_col = "col-sm-2";
		break;
	default:
		$class_col = "col-sm-3";
}

$posts_display = new WP_Query( $query_args );

if ( $posts_display->have_posts() ) :

	$categories = array();
	$html      = '';

	while ( $posts_display->have_posts() ) : $posts_display->the_post();

	    $class = '';
		$cats  = get_the_category();
		$image_id = get_post_thumbnail_id( $post->ID );
		$imgurl     = wp_get_attachment_image_src( $image_id, 'full' );
		$image_crop_popup = thim_aq_resize( $imgurl[0], 800, 640, true );

		if ( !empty( $cats ) ) {
			foreach ( $cats as $key => $value ) {
				$class .= ' filter-' . $value->term_id;
				$categories[$value->term_id] = $value->name;
			}
		}
		$html .= '<div class="' . $class_col . $class . '">';
		$html .= '<a class="thim-gallery-popup" href="'. $image_crop_popup .'" data-id="' . get_the_ID() . '"><span class="fa  fa-expand"></span>' . thim_get_thumbnail( get_the_ID(), '400x400', 'post', false ) . '</a>';
		$html .= '</div>';

	endwhile;

	?>

	<div class="thim-sc-gallery">
		<div class="wrapper-filter-controls">
			<ul class="filter-controls">
				<li>
					<a class="filter active" data-filter="*" href="javascript:;"><?php esc_html_e( 'All', 'course-builder' ); ?></a>
				</li>
				<?php

				if ( !empty( $categories ) ) {
					foreach ( $categories as $key => $value ) {
						echo '<li><a class="filter" href="javascript:;" data-filter=".filter-' . $key . '">' . $value . '</a></li>';
					}
				}
				?>
			</ul>
		</div>

		<div class="wrapper-gallery row" itemscope itemtype="http://schema.org/ItemList">
			<?php
			echo ent2ncr( $html );
			?>
		</div>
        <div class="thim-gallery-show"></div>
	</div>


<?php
endif;
wp_reset_postdata();
