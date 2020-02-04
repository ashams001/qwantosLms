<?php
/**
 * Template for displaying course content within the loop
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$theme_options_data = get_theme_mods();
$column_product     = 4;
if ( isset( $theme_options_data['learnpress_cate_collection_column'] ) && ( $theme_options_data['learnpress_cate_collection_column'] <> '' ) && ( get_query_var( 'post_type' ) == 'lp_collection' ) ) {
	$column_product = 12 / $theme_options_data['learnpress_cate_collection_column'];
} else if ( isset( $theme_options_data['learnpress_cate_grid_column'] ) && $theme_options_data['learnpress_cate_grid_column'] <> '' && $theme_options_data['learnpress_cate_style'] == 'grid' ) {
	$column_product = 12 / $theme_options_data['learnpress_cate_grid_column'];
}
if ( ! empty( $_REQUEST['cols'] ) ) {
	$column_product = 12 / $_REQUEST['cols'];
}
$classes[]    = 'col-md-' . $column_product . ' col-sm-6 col-xs-6 lpr-course';
$width        = $height = '';
$lp_thumbnail = get_option( 'learn_press_course_thumbnail_image_size' );
if ( $lp_thumbnail ) {
	$width  = $lp_thumbnail['width'];
	$height = $lp_thumbnail['height'];
} else {
	$width  = 320;
	$height = 355;
}
$thumbnail_size = $width . 'x' . $height;

$course_id  = get_the_ID();
$course     = new LP_Course( $course_id );
$price_sale = $course->get_sale_price();
$price      = $course->get_origin_price_html();
if ( class_exists( 'LP_Addon_Course_Review' ) ) {
	$course_number_vote       = learn_press_get_course_rate_total( $course_id );
	$html_course_number_votes = $course_number_vote ? sprintf( _n( '(%1$s vote )', ' (%1$s votes)', $course_number_vote, 'course-builder' ), number_format_i18n( $course_number_vote ) ) : esc_html__( '(0 vote)', 'course-builder' );
}
$count          = $course->count_users_enrolled( 'append' ) ? $course->count_users_enrolled( 'append' ) : 0;
$course_classes = '';
if ( ( $price_sale > '0' ) || ( ( $price_sale == '0' ) && ( $price != '' ) ) ) {
	$course_classes .= 'sale';
}
$extra_class = '';
if ( ! empty( $course_number_vote ) ) {
	$extra_class = 'review-course';
}
$link = learn_press_user_profile_link( get_the_author_meta( 'ID' ) );
$user = new WP_User( get_the_author_meta( 'ID' ) );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>
	<div class="content">
		<div class="thumbnail">
			<?php
			if ( $course_classes ) {
				echo '<span class="sale">' . '<span class="text-sale">' . esc_attr__( 'Sale', 'course-builder' ) . '</span>' . '</span>';
			}
			?>
			<?php if ( has_post_thumbnail() ) : ?>
				<a href="<?php the_permalink(); ?>" class="img_thumbnail"> <?php echo thim_get_thumbnail( get_the_ID(), $thumbnail_size, 'post', false ); ?> </a>
			<?php endif; ?>
			<?php if ( $price >= 0 ): ?>
				<span class="price"><?php learn_press_course_price(); ?></span>
			<?php endif; ?>
			<?php if ( class_exists( 'LP_Addon_Course_Review' ) ): ?>
				<div class="review <?php echo esc_attr( $extra_class ) ?>">
					<div class="sc-review-stars">
						<?php
						$course_id   = get_the_ID();
						$course_rate = learn_press_get_course_rate( $course_id );
						?>
						<?php
						learn_press_course_review_template( 'rating-stars.php', array( 'rated' => $course_rate ) );
						?>
					</div>
					<?php if ( ! empty( $html_course_number_votes ) ): ?>
						<span class="vote"><?php echo esc_attr( $html_course_number_votes ); ?></span>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
		<div class="sub-content">
			<h3 class="title">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h3>
			<div class="date-comment">
				<?php echo get_the_date() . ' / '; ?>
				<?php $comment = get_comments_number();
				if ( $comment == 0 ) {
					echo esc_html__( "No Comments", 'course-builder' );
				} else {
                    echo sprintf( _n( '%d Comment', '%d Comments', $comment, 'course-builder' ), $comment);
				}
				?>
			</div>

			<div class="content-list">
				<div class="course-description">
					<?php
					do_action( 'learn_press_before_course_content' );
					the_excerpt();
					do_action( 'learn_press_after_course_content' );
					?>
				</div>
				<ul class="courses_list_info">
					<li>
						<span class="avatar">
							<a href="<?php echo esc_url( $link ); ?>">
								<?php echo get_avatar( get_the_author_meta( 'ID' ), 40 ); ?>
							</a>
						</span>
						<span class="info">
							<span class="major"><?php echo esc_html__( 'Teacher', 'course-builder' ); ?></span>
							<a href="<?php echo esc_url( $link ); ?>" class="name">
								<?php echo get_the_author(); ?>
							</a>
						</span>
					</li>
					<?php if ( class_exists( 'LP_Addon_Course_Review' ) ): ?>
						<li>
							<label><?php echo esc_html__( 'Review:', 'course-builder' ); ?></label>
							<div class="review <?php echo esc_attr( $extra_class ) ?>">
								<div class="sc-review-stars">
									<?php
									$course_id   = get_the_ID();
									$course_rate = learn_press_get_course_rate( $course_id );
									?>
									<?php
									learn_press_course_review_template( 'rating-stars.php', array( 'rated' => $course_rate ) );
									?>
								</div>
								<?php if ( ! empty( $html_course_number_votes ) ): ?>
									<span class="vote"><?php echo esc_attr( $html_course_number_votes ); ?></span>
								<?php endif; ?>
							</div>
						</li>
					<?php endif; ?>
					<li>
						<label><?php echo esc_attr__( 'Students:', 'course-builder' ); ?></label>
						<strong class="students"><?php echo esc_html( $count ); ?><?php echo esc_html__( ' Students', 'course-builder' ); ?></strong>
					</li>
				</ul>
			</div>
		</div>
	</div>
</article>