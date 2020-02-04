<?php
/**
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $post;

//$user       = learn_press_get_current_user();
$course_id  = $post->ID;
$course     = new LP_Course( $course_id );
$price_sale = $course->get_sale_price();
if ( class_exists( 'LP_Addon_Course_Review' ) ) {
    $course_number_vote       = learn_press_get_course_rate_total( $course_id );
    $html_course_number_votes = $course_number_vote ? sprintf( _n( '(%1$s vote)', ' (%1$s votes)', $course_number_vote, 'course-builder' ), number_format_i18n( $course_number_vote ) ) : esc_html__( '(0 vote)', 'course-builder' );
}
$count          = $course->count_users_enrolled( 'append' ) ? $course->count_users_enrolled( 'append' ) : 0;
$course_classes = '';

if ( $price_sale ) {
    $course_classes .= 'sale';
}
$extra_class = '';

if ( ! empty( $course_number_vote ) ) {
    $extra_class = 'review-course';
}

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

?>
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
        <span class="price"><?php learn_press_course_price(); ?></span>
        <div class="review <?php echo esc_attr( $extra_class ) ?>">
            <div class="sc-review-stars">
                <?php
                $course_id = get_the_ID();
                if ( class_exists( 'LP_Addon_Course_Review' ) ) {
                    $course_rate = learn_press_get_course_rate( $course_id );
                    learn_press_course_review_template( 'rating-stars.php', array( 'rated' => $course_rate ) );
                }
                ?>
            </div>
            <?php if ( isset( $html_course_number_votes ) ): ?>
                <span class="vote"><?php echo esc_html( $html_course_number_votes ); ?></span>
            <?php endif; ?>
        </div>
    </div>
    <div class="thim-course-content">
        <div class="sub-content">
            <div class="title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </div>
            <?php learn_press_get_template( 'profile/tabs/courses/progress.php', array(
                'user'      => $user,
                'course_id' => $post->ID
            ) ); ?>
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
        </div>
    </div>
</div>