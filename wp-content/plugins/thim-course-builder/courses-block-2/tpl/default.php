<?php

$title            = $params['title'];
$des              = $params['description'];
$number_courses   = $params['number_courses'];
$button_text      = $params['button_text'];
$button_link      = $params['button_link'];
$list_courses     = $params['list_courses'];
$cat_courses      = $params['cat_courses'];
$cat_courses      = isset( $params['cat_courses'] ) ? $params['cat_courses'] : '';
$featured_courses = empty( $params['featured_courses'] ) ? '' : $params['featured_courses'];

$new_course_duration = get_theme_mod( 'learnpress_new_course_duration' ) ? get_theme_mod( 'learnpress_new_course_duration' ) : 2 ;
$new_course_duration = intval( $new_course_duration );

if ( $cat_courses ) {
	$tax_query_value = array(
		array(
			'taxonomy' => 'course_category',
			'field'    => 'term_id',
			'terms'    => $cat_courses,
		)
	);
} else {
	$tax_query_value = '';
}

$recent_days_course = mktime( 0, 0, 0, date( "m" ), date( "d" ) - $new_course_duration, date( "Y" ) );

$args_list_courses = array(
	'posts_per_page' => $number_courses,
	'post_type'      => 'lp_course',
	'post_status'    => 'publish',
	'tax_query'      => $tax_query_value,
);

if ( $list_courses === 'latest' ) {
	$args_list_courses['orderby'] = 'date';
}

if ( $list_courses == 'popular' ) {
	$args_list_courses['post__in'] = lp_get_courses_popular();
}


// Get featured courses
if ( $featured_courses != '' ) {
	$args_list_courses['meta_query'] = array(
		array(
			'key'   => '_lp_featured',
			'value' => 'yes',
		)
	);
}


$number_items_per_row = 4;
$row_index            = 1;

$query_list_courses = new WP_Query( $args_list_courses );

if ( $query_list_courses->have_posts() ) : ?>
	<div class="thim-courses-block-2">
		<div class="row no-gutter">
			<?php if ( $title || $des || $button_text ): ?>
				<div class="col-sm-3 intro-item">
					<div class="wrapper">
						<?php
						if ( $title ) {
							echo '<h3 class="title">' . esc_html( $title ) . '</h3>';
						}
						if ( $des ) {
							echo '<p class="description">' . esc_html( $des ) . '</p>';
						}
						if ( $button_text ) {

						    if ( empty($button_link)) {
							    $archive_courses_url = get_post_type_archive_link( 'lp_course' ) ? get_post_type_archive_link( 'lp_course' ) : '#';
						    }

							echo '<a href="' . esc_url( $button_link ) . '" class="view-courses-button">' . esc_html( $button_text ) . '</a>';
						}
						?>
					</div>
				</div>
			<?php endif; ?>

			<?php while ( $query_list_courses->have_posts() ):
			$query_list_courses->the_post(); ?>
			<?php
			if ( $title || $des || $button_text ) {
				$first_item_on_row = $row_index * $number_items_per_row - 2 + 1;
			} else {
				$first_item_on_row = $row_index * $number_items_per_row - 1 + 1;
			}

			$course_date      = strtotime( get_the_date() );
			$new_couser_class = $course_date > $recent_days_course ? 'new-course' : '';

			$course_id   = get_the_ID();
			$course      = new LP_Course( $course_id );
			$price       = $course->get_price_html();
			$price_class = $course->is_free() ? 'free' : '';

			?>
			<?php if ( $query_list_courses->current_post == $first_item_on_row ):
			$row_index ++; ?>
		</div>
		<div class="row no-gutter">
			<?php endif; ?>

			<div class="col-sm-3 course-item <?php echo esc_attr( $new_couser_class ); ?>">
				<?php if ( $new_couser_class ): ?>
					<span class="course-label"><?php esc_html_e( 'new', 'course-builder' ) ?></span>
				<?php endif; ?>

				<div class="featured-img">
					<?php thim_thumbnail( $course_id, '379x416' ); ?>
				</div>

				<div class="content-item">
					<div class="name">
						<a href="<?php echo esc_url( learn_press_user_profile_link( $course->post->post_author ) ); ?>">
							<?php
							$user_data   = get_userdata( $course->post->post_author );
							$author_name = '';
							if ( $user_data ) {
								if ( ! empty( $user_data->display_name ) ) {
									$author_name = $user_data->display_name;
								} else {
									$author_name = $user_data->user_login;
								}
							}
							echo ($author_name);
							?>
						</a>
					</div>
					<h4 class="title">
						<a href="<?php echo esc_url( get_the_permalink() ) ?>"><?php echo esc_html( get_the_title() ) ?></a>
					</h4>
					<div class="price"><?php learn_press_course_price(); ?></div>
				</div>
			</div>

			<?php endwhile;
			wp_reset_postdata();?>
		</div>
	</div>
<?php endif;
