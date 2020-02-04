<?php
/**
 * Display content item
 *
 * @author  ThimPress
 * @version 2.1.7
 */

$course = learn_press_get_the_course();
$item   = LP()->global['course-item'];
$user   = learn_press_get_current_user();
if ( ! $item ) {
    return;
}
$item_id = isset( $item->id ) ? $item->id : ( isset( $item->ID ) ? $item->ID : 0 );
?>
<div id="learn-press-content-item">
    <?php
    ?>
    <div class="learn-press-content-item-container">
        <?php
        do_action( 'learn_press/before_course_item_content', $item_id, $course->id );
        if ( $item ){
            if ( $user->can( 'view-item', $item->id, $course->id ) ){
                // Display meta lesson video intro - created by theme
                $item_detail = $item->post;
                if ( $item_detail->post_type === 'lp_lesson' ) {
                    $video_intro = get_post_meta( $item_detail->item_id, '_lp_lesson_video_intro', true );
                    if ( ! empty( $video_intro ) ) {
                        ?>
                        <div class="learn-press-video-intro">
                            <div class="video-content">
                                <?php echo( $video_intro ); ?>
                            </div>
                        </div>
                        <?php
                    } else {
                        if ( has_post_thumbnail( $item_id ) ) {
                            echo '<div class="lesson-image">' . get_the_post_thumbnail( $item->id, 'full' ) . '</div>';
                        }
                    }
                }
                // End Display meta lesson video intro

                do_action( 'learn_press_course_item_content', $item );
            }else {
                learn_press_get_template( 'single-course/content-protected.php', array( 'item' => $item ) );
            }

            //do_action( 'learn_press_after_content_item', $item_id, $course->id, true );
            do_action( 'learn_press/after_course_item_content', $item_id, $course->id );
        }
        ?>

        <?php if ( $item_detail->post_type === 'lp_lesson' ) : ?>
            <div id="comments">
                <?php
                $current_user = wp_get_current_user();
                $user_id      = $current_user->ID;
                $avatar       = get_avatar( $user_id, 84 );
                // If comments are open or we have at least one comment, load up the comment template
                $args = array(
                    'title_reply'   => '',
                    'logged_in_as'  => '',
                    'label_submit'  => esc_html__( 'Send', 'course-builder' ),
                    'comment_field' => '<div class="author-avatar">' . get_avatar( $user_id, 84 ) . '</div><p class="comment-form-comment"><textarea placeholder="' . esc_html__( 'Ask a question...', 'course-builder' ) . '" id="comment" name="comment" cols="45" rows="8" aria-required="true">' .
                        '</textarea></p>',
                );
                if ( is_user_logged_in() ) {
                    if ( comments_open() || '0' != get_comments_number() ) :
                        echo '<div id="form-question">';
                        comment_form( $args, $item->id );
                        echo '</div>';
                    endif;
                } else {
                    echo '<p class="link-bottom">' . esc_html__( 'Are you a member? ', 'course-builder' ) . '<a href="' . esc_url( thim_get_login_page_url() ) . '">' . esc_html__( 'Login now', 'course-builder' ) . '</a></p>';
                }
                ?>
                <div id="question-list" class="list-comments">
                    <?php if ( $item_detail->comment_count > 0 ) { ?>
                        <h3 class="comments-title">
                            <?php
                            printf( _n( '1 comment', '%1$s comments', $item_detail->comment_count, 'course-builder' ),
                                number_format_i18n( $item_detail->comment_count ) );
                            ?>
                        </h3>

                        <ul class="comment-list">
                            <?php
                            $comments = get_comments( array(
                                'post_id' => $item_detail->ID,
                                'status'  => 'approve'
                            ) );

                            //Display the list of comments
                            wp_list_comments( array(
                                'reverse_top_level' => false,
                                'callback'          => 'thim_comment'
                            ), $comments );
                            //						?>
                        </ul>

                    <?php } else {
                        echo '<p class="link-bottom">' . esc_html__( 'No comments yet! You be the first to comment.', 'course-builder' ) . '</p>';
                    } // have_comments() ?>
                    <?php if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
                        <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'course-builder' ); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <script>
        jQuery(function ($) {
            "use strict";
            $(window).load(function () {
                //Set can to press esc
                window.parent.can_escape = true;
                window.parent.jQuery('#course-curriculum-popup').removeClass('loading');
            });

            $(document).on('click', '.course-content-lesson-nav .nav-link-item', function (e) {
                e.preventDefault();
                var data_id = $(this).data('nav-id');
                window.parent.jQuery('[data-id="' + data_id + '"]').trigger('click');
            });


            var content_H = $('#learn-press-content-item').height();
            if (window.parent.jQuery(window).width() < 1025) {
                //jQuery('html, body').css('min-height', content_H);
                window.parent.jQuery('#popup-content-inner iframe').css('min-height', content_H);
                //window.parent.jQuery('#popup-content-inner').css('min-height', content_H);
                //console.log(content_H);
            }

            function updateIframe() {
                window.parent.jQuery(window).trigger('resize.update-iframe');
            }

            window.parent.jQuery(window).on('resize.update-iframe', function () {
                var content_newH = $('#learn-press-content-item').height();
                //console.log('new', content_newH);
                if (window.parent.jQuery(window).width() < 1025) {
                    //jQuery('html, body').css('min-height', content_newH);
                    window.parent.jQuery('#popup-content-inner iframe').css('min-height', content_newH);
                    window.parent.jQuery('#course-curriculum-popup').scrollTop(0);
                    //window.parent.jQuery('#popup-content-inner').css('min-height', content_newH);

                } else {
                    window.parent.jQuery('#popup-content-inner iframe').css('min-height', 0);
                }
            });

            $(document).on('click', 'button, a', function () {
                updateIframe();
            });
            $(document).ajaxComplete(function () {
                updateIframe();
            });

            //updateIframe when all images loaded
            var imgArr = $('.learn-press-content-item-only img'),
                imgLength = imgArr.length;
            if (imgLength) {
                imgArr.each(function (index, val) {
                    $(this).on('load', function () {
                        if (index == imgLength - 1) {
                            updateIframe();
                        }
                    });
                });
            }
        })
    </script>
</div>