<?php
/**
 * User Information
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$user_meta = get_user_meta( $user->ID );
$user_meta = array_map( function ( $a ) {
	return $a[0];
}, $user_meta );

if ( is_user_logged_in() ) :
	?>
	<div class="list-contact">
		<?php if ( ! empty( $user_meta['lp_info_phone'] ) ): ?>
			<div class="item">
				<a class="contact-icon" href="tel:<?php echo esc_attr( $user_meta['lp_info_phone'] ); ?>" title="<?php esc_attr_e( 'Phone', 'course-builder' ) ?>"><i class="fa fa-phone"></i></a>
				<div class="contact-content">
					<div class="title"><?php esc_html_e( 'Phone Number', 'course-builder' ) ?></div>
					<a href="tel:<?php echo esc_attr( $user_meta['lp_info_phone'] ); ?>"><?php echo esc_html( $user_meta['lp_info_phone'] ); ?></a>
				</div>
			</div>
		<?php endif; ?>

		<div class="item">
			<a class="contact-icon" href="mailto:<?php echo esc_attr( $user->user_email ); ?>" title="<?php esc_attr_e( 'Email', 'course-builder' ) ?>"><i class="fa fa-envelope-o"></i></a>
			<div class="contact-content">
				<div class="title"><?php esc_html_e( 'Email', 'course-builder' ) ?></div>
				<a href="mailto:<?php echo esc_attr( $user->user_email ); ?>"><?php echo esc_html( $user->user_email ); ?></a>
			</div>
		</div>

		<?php if ( ! empty( $user_meta['lp_info_skype'] ) ): ?>
			<div class="item">
				<a class="contact-icon" href="<?php echo esc_url( $user_meta['lp_info_skype'] ); ?>" title="<?php esc_attr_e( 'Skype', 'course-builder' ) ?>"><i class="fa fa-skype"></i></a>
				<div class="contact-content">
					<div class="title"><?php esc_html_e( 'Skype', 'course-builder' ) ?></div>
					<a href="tel:<?php echo esc_attr( $user_meta['lp_info_skype'] ); ?>"><?php echo esc_html( $user_meta['lp_info_skype'] ); ?></a>
				</div>
			</div>
		<?php endif; ?>
	</div>

<?php endif; ?>

<div class="info-general">
	<div class="avatar">
		<?php
		echo( $user->get_profile_picture( null, '496' ) ); ?>
	</div>

	<div class="biographical">
		<h4 class="title"><?php esc_html_e( 'About', 'course-builder' ) ?></h4>
		<?php if ( ! empty( $user_meta['description'] ) ) : ?>
			<div class="content"><?php echo( $user_meta['description'] ); ?></div>
		<?php endif; ?>
	</div>
</div>
