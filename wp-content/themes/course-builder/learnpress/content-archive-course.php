<?php
/**
 * Template for displaying archive course content
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 2.0.6
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $post, $wp_query;

if ( is_tax() ) {
	$total = get_queried_object();
	$total = $total->count;
} elseif ( ! empty( $_REQUEST['s'] ) ) {
	$total = $wp_query->found_posts;
} else {
	$total = wp_count_posts( 'lp_course' );
	$total = $total->publish;
}

if ( $total == 0 ) {
	echo '<p class="message message-error">' . esc_html__( 'There are no available courses!', 'course-builder' ) . '</p>';

	return;
} elseif ( $total == 1 ) {
	$index = esc_html__( 'Showing only one result', 'course-builder' );
} else {
	$courses_per_page = absint( LP()->settings->get( 'archive_course_limit' ) );
	if ( ! empty( $_REQUEST['number'] ) ) {
		$courses_per_page = $_REQUEST['number'];
	}
	$paged = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;

	$from = 1 + ( $paged - 1 ) * $courses_per_page;
	$to   = ( $paged * $courses_per_page > $total ) ? $total : $paged * $courses_per_page;

	if ( $from == $to ) {
		$index = sprintf(
			esc_html__( 'Showing last course of %s results', 'course-builder' ),
			$total
		);
	} else {
		$index = sprintf(
			esc_html__( 'Showing %s-%s of %s results', 'course-builder' ),
			$from,
			$to,
			$total
		);
	}
}

$courses_layout = get_theme_mod( 'learnpress_cate_style' ) ? get_theme_mod( 'learnpress_cate_style' ) : 'grid';
$has_param      = '';
if ( isset( $_GET['layout'] ) && $_GET['layout'] != '' ) {
	$courses_layout = $_GET['layout'];
	$has_param      = 'has-layout';
}

?>
<?php do_action( 'learn_press_archive_description' ); ?>
<?php if ( LP()->wp_query->have_posts() ) : ?>

	<div class="thim-course-top">
		<div class="row">
			<div class="col-md-6 hidden-md-down course-top1">
				<div class="course-index">
					<span><?php echo( $index ); ?></span>
				</div>
			</div>
			<div class="col-md-6 col-sm-12 course-top2">
				<div class="display grid-list-switch lpr_course-switch <?php echo esc_attr( $has_param ); ?>" data-cookie="lpr_course-switch" data-layout="<?php echo esc_attr( $courses_layout ); ?>">
					<a href="javascript:;" class="grid switchToGrid switcher-active"><i class="fa fa-th"></i></a>
					<a href="javascript:;" class="list switchToList"><i class="fa fa-th-list"></i></a>
				</div>
				<div class="courses-searching">
					<form method="get" action="<?php echo esc_url( get_post_type_archive_link( 'lp_course' ) ); ?>">
						<input type="text" value="" name="s" placeholder="<?php esc_html_e( 'What do you want to learn?', 'course-builder' ) ?>" class="thim-s form-control courses-search-input" autocomplete="off" />
						<input type="hidden" value="course" name="ref" />
						<button type="submit"><i class="ion-ios-search-strong"></i></button>
						<span class="widget-search-close"></span>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="archive-courses course-<?php echo esc_attr( $courses_layout ); ?> archive_switch" itemscope itemtype="http://schema.org/ItemList">
		<?php learn_press_begin_courses_loop(); ?>

		<?php while ( LP()->wp_query->have_posts() ) : LP()->wp_query->the_post(); ?>

			<?php learn_press_get_template_part( 'content', 'course' ); ?>

		<?php endwhile; ?>

		<?php learn_press_end_courses_loop(); ?>
	</div>

	<?php do_action( 'learn_press_after_courses_loop' ); ?>
<?php else: ?>
	<?php learn_press_display_message( esc_attr__( 'No course found.', 'course-builder' ), 'error' ); ?>
<?php endif; ?>
