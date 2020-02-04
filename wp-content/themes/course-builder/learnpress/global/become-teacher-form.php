<?php
/**
 * Template for displaying the form let user fill out their information to become a teacher
 *
 * @author        ThimPress
 * @package       LearnPress/Templates
 * @version       1.0
 */

$request                    = $method == 'post' ? $_POST : $_REQUEST;
$form_id                    = uniqid( 'become-teacher-form-' );
$submit_button_process_text = esc_html__( 'Submitting...', 'course-builder' );
$submit_button_text         = esc_html__( 'Submit', 'course-builder' );
$warning                    = '';
$ban_click                  = '';
$disable                    = '';
$current_user               = wp_get_current_user();
if ( learn_press_become_teacher_sent( $current_user->ID ) || $current_user->roles == 'administrator' ) {
    $disable   = 'disabled="disabled"';
    $warning   = 'warning';
    $ban_click = 'ban_click';
}
?>

<div class="register-content <?php echo esc_attr( $ban_click ); ?>">
    <div id="learn-press-become-teacher-form" class="learn-press-become-teacher-form register-form">
        <div class="title">
            <h4 class="title-form">
                <?php echo esc_html__( 'Start the change', 'course-builder' ) ?>
            </h4>
            <h3 class="register">
                <?php echo esc_html__( 'Register to become an Instructor', 'course-builder' ) ?>
            </h3>
        </div>
        <?php
        if ( ! learn_press_become_teacher_sent() ) {
            if ( $message ) {
                learn_press_display_message( $message );
            }
        }
        ?>
        <form id="<?php echo esc_attr( $form_id ); ?>" name="become-teacher-form" method="<?php echo esc_attr( $method ); ?>" enctype="multipart/form-data" action="<?php echo esc_attr( $action ); ?>">
            <?php if ( $fields ): ?>
                <ul class="become-teacher-fields register-fields">
                    <?php foreach ( $fields as $name => $option ):
                        $option = wp_parse_args(
                            $option,
                            array(
                                'title'       => '',
                                'type'        => '',
                                'def'         => '',
                                'placeholder' => ''
                            )
                        );

                        $value                 = ! empty( $request[ $name ] ) ? $request[ $name ] : ( ! empty( $option['def'] ) ? $option['def'] : '' );
                        $requested             = strtolower( $_SERVER['REQUEST_METHOD'] ) == $method;
                        $error_message         = null;
                        $option['placeholder'] = ( $option['type'] == 'email' ) ? esc_attr__( 'Your email', 'course-builder' ) : $option['placeholder'];
                        if ( $requested ) {
                            $error_message = apply_filters( 'learn_press_become_teacher_form_validate_' . $name, $value );
                        }
                        ?>
                        <li>
                            <div class="label-form">
                                <?php echo esc_html( $option['placeholder'] ); ?>
                            </div>
                            <?php
                            switch ( $option['type'] ) {
                                case 'text':
                                case 'email':
                                    printf( '<input type="%s" name="%s" placeholder="" value="%s" %s />', $option['type'], $name, esc_attr( $value ), $disable );
                                    break;
                            }
                            if ( $error_message ) {
                                learn_press_display_message( $error_message );
                            }
                            ?>
                        </li>
                    <?php endforeach; ?>
                    <li>
                        <button <?php echo esc_attr( $disable ); ?> class="submit" type="submit" data-text="<?php echo esc_attr( $submit_button_text ); ?>" data-text-process="<?php echo esc_attr( $submit_button_process_text ); ?>"><?php echo esc_html( $submit_button_text ); ?></button>
                    </li>
                </ul>
                <input type="hidden" name="lp-ajax" value="become-a-teacher" />
            <?php endif; ?>
        </form>
    </div>
</div>