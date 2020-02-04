<?php
/**
 * User Courses tab
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post;
$args = array(
	'user' => $user
);

$paged     = 1;
$userid    = $user->ID;
$limit     = LP()->settings->get( 'profile_courses_limit', 10 );
$limit     = apply_filters( 'learn_press_profile_tab_courses_all_limit', $limit );
$count     = count( $user->get( 'courses' ) );
$courses   = $user->get( 'courses', array( 'limit' => $limit, 'paged' => $paged ) );
$num_pages = learn_press_get_num_pages( $user->_get_found_rows(), $limit );

if ( $courses ) {
	?>
	<div class="learn-press-subtab-content">
		<div class="profile-courses archive-courses courses-list row" data-count='<?php echo esc_attr( $count ); ?>' data-limit='<?php echo esc_attr( $limit ); ?>' data-page='<?php echo esc_attr( $paged ); ?>' data-user="<?php echo esc_attr( $userid ) ?>">
			<?php foreach ( $courses as $post ) {
				setup_postdata( $post );
				?>

				<?php
				learn_press_get_template( 'profile/tabs/courses/loop.php', array(
					'user'      => $user,
					'course_id' => $post->ID
				) );
				wp_reset_postdata();
				?>

			<?php } ?>
		</div>
		<?php if ( $count > $limit ) { ?>
			<div id="load-more-button">
				<div class="btn btn-primary btn-lg loadmore">
<!--					<i class="fa fa-spin fa-spinner"></i>-->
					<div class="sk-three-bounce">
						<div class="sk-child sk-bounce1"></div>
						<div class="sk-child sk-bounce2"></div>
						<div class="sk-child sk-bounce3"></div>
					</div>
					<span><?php echo esc_html__( 'Load more', 'course-builder' ); ?></span>
				</div>
			</div>
		<?php } ?>
	</div>
	<?php
} else {
	learn_press_display_message( esc_html__( 'You haven\'t got any courses yet!', 'course-builder' ) );
}
?>
