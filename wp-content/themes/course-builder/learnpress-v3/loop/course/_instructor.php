<?php
/**
 * Template for displaying the instructor of a course
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$course = LP_Global::course();
?>
<div class="author" itemprop="creator">
    <a href="<?php echo esc_url( learn_press_user_profile_link( get_post_field( 'post_author', $course->get_id() ) ) ); ?>"><span
                class="avatar"><?php echo get_avatar( get_post_field( 'post_author', get_the_ID() ), 50 ); ?></span></a>
    <div class="info">
        <label><?php echo esc_attr__( 'Teacher', 'course-builder' ); ?></label>
        <a href="<?php echo esc_url( learn_press_user_profile_link( get_post_field( 'post_author', $course->get_id() ) ) ); ?>">
            <span><?php echo get_the_author_meta( 'user_login', $course->post->post_author ); ?></span>
        </a>
    </div>
</div>