<?php
/**
 * Template for displaying Course collection shortcode default style for Learnpress v3.
 *
 * @author  ThimPress
 * @package Course Builder/Templates
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$arr_collection = array(
	'post_type'      => 'lp_collection',
	'posts_per_page' => $setting['limit'],
	'post_status'    => 'publish',
);

$query_collection = new WP_Query( $arr_collection ); ?>

	<div class="thim-courses-collection-wrapper-kit">
		<?php if ( $setting['title'] || $setting['description'] ) { ?>
			<div class="thim-collection-info-kit">
				<?php if ( $setting['title'] ): ?>
					<h3 class="title"><?php echo esc_html( $setting['title'] ); ?></h3>
				<?php endif; ?>

				<?php if ( $setting['description'] ) : ?>
					<div class="description"><?php echo $setting['description']; ?> </div>
				<?php endif; ?>
			</div>
		<?php } ?>
		<?php if ( $query_collection->have_posts() ): ?>
			<div class="thim-courses-collection">
				<div class="collection-slick" data-item="<?php echo $setting['visible']; ?>"
					 data-nav="<?php echo $setting['nav']; ?>">
					<ul class="slider-collection owl-carousel">
						<?php while ( $query_collection->have_posts() ) : $query_collection->the_post(); ?>
							<li class="collection-item">
								<a class="collection-wrapper" href="<?php echo esc_url( get_the_permalink() ); ?>">
									<h4 class="name"><?php echo get_the_title(); ?></h4>
									<?php element_course_number( get_the_ID() ); ?>
								</a>
								<img class="background-collection"
									 src="<?php echo esc_url( THIM_CB_URL . 'courses-collection/assets/images/bl-collection.png' ); ?>"
									 alt="bk_collection">
								<?php if ( has_post_thumbnail() ) {
									thim_thumbnail( get_the_ID(), 'full', 'post', false );
								} ?>

							</li>
						<?php endwhile; ?>
					</ul>
				</div>
			</div>
		<?php endif; ?>
	</div>
<?php wp_reset_postdata();
