<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<h2 class="title"><?php esc_html_e( 'Announcements', 'course-builder' ); ?></h2>
<div id="lp-announcements" class="lp-announcements">
	<?php
	$course_id = get_the_ID();
	$arg_query = array(
		'post_type'      => 'lp_announcements',
		'type'           => 'publish',
		'posts_per_page' => '-1',
		'meta_query'     => array(
			'relation' => 'AND',
			array(
				'key'     => '_lp_course_announcement',
				'value'   => get_the_ID(),
				'compare' => 'LIKE'
			),
		)
	);
	$query     = new WP_Query( $arg_query );

	if ( $query->have_posts() ) {
		foreach ( $query->posts as $announcement ) {
			learn_press_announcements_template( 'frontend-announcements-item.php', array( 'announcement' => $announcement ) );
		}
		wp_reset_postdata();
	} else {
		learn_press_announcements_template( 'frontend-announcements-not-found.php' );
	}

	?>
</div>
