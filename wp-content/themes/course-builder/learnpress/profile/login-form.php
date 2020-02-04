<?php
/**
 * Template for displaying template of login form
 *
 * @author  ThimPress
 * @package Templates
 * @version 2.0
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit();
}

/**
 * Overwrite template in your theme at [YOUR_THEME]/learnpress/profile/login-form.php.
 * By default, it load default login form of WP core.
 */
$login_page_id = intval(get_option( 'thim_login_page' ));

if ( $login_page_id && 'publish' == get_post_status( $login_page_id ) ) {
    $login_page = get_post( $login_page_id );
    $profile_page_id   = LP()->settings->get( 'profile_page_id', false);
    echo apply_filters( 'the_content', $login_page->post_content );
}else{
    ?>
    <div class="thim-login-form-wrapper">
        <div class="sc-thim-login-form">
            <?php echo do_shortcode( '[thim-login-form]' ); ?>
        </div>
        <div></div>
    </div>
    <?php
}
