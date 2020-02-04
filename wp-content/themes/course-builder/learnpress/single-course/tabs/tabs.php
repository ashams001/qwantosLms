<?php
/**
 * Template for displaying tab nav of single course.
 *
 * @author  ThimPress
 * @package  Learnpress/Templates
 * @version  3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<?php
$tabs = apply_filters( 'learn_press_course_tabs', array() );
$id = get_the_ID();
if ( ! empty( $tabs ) ) : ?>
	<?php
	$index        = 0;
	$active_index = - 1;
	$tab_review   = '';
	foreach ( $tabs as $key => $tab ) {
		if ( ! empty( $tab['active'] ) && $tab['active'] == true ) {
			$active_index = $index;
		}
		$index ++;
	}
	if ( $active_index == - 1 ) {
		$active_index = 0;
	}
	$index = 0;
	?>
	<div class="learn-press-tabs learn-press-tabs-wrapper">
		<div class="nav-tabs-wrapper">
			<div class="container">
				<ul class="learn-press-nav-tabs" data-cookie="tab-cookie" data-cookie2="tab-id">
					<?php foreach ( $tabs as $key => $tab ) : ?>
						<?php
						$unikey              = uniqid( $key . '-' );
						$tabs[ $key ]['key'] = $unikey;
						if ( ( isset( $_GET['tab'] ) ) && ( $_GET['tab'] == 'reviews' ) && ( $key == 'reviews' ) ) {
							$tab_review = 'active';
						} else {
							$tab_review = '';
						}
						?>
						<li class="learn-press-nav-tab learn-press-nav-tab-<?php echo esc_attr( $key ); ?><?php echo esc_attr( ' ' . $tab_review );
						echo( $index ++ == $active_index ? ' active' : '' );
						?>">
							<a href="" data-id="<?php echo esc_attr($id); ?>" data-key="<?php echo esc_attr( $key ); ?>" data-tab="#tab-<?php echo esc_attr( $unikey ); ?>"><?php echo apply_filters( 'learn_press_course_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?></a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
		<div class="tabs-wrapper">
			<div class="container">
				<?php $index = 0; ?>
				<?php foreach ( $tabs as $key => $tab ) : ?>
					<div class="learn-press-tab-panel learn-press-tab-panel-<?php echo esc_attr( $key ); ?> panel learn-press-tab<?php echo esc_attr( $index ++ == $active_index ? ' active' : '' );
					?>" id="tab-<?php echo esc_attr( $tab['key'] ); ?>">
						<?php if ( apply_filters( 'learn_press_allow_display_tab_section', true, $key, $tab ) ) : ?>
							<?php call_user_func( $tab['callback'], $key, $tab ); ?>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
				<?php do_action( 'thim_learning_after_tabs_wrapper' ); ?>
			</div>
		</div>
	</div>
<?php endif; ?>