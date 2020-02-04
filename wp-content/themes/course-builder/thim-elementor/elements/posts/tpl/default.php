<?php
$number_events = !empty( $params['number_post'] ) ? $params['number_post'] : 1;
$args          = array(
	'post_type'      => 'post',
	'posts_per_page' => $number_events,
);

if ( $params['cat_post'] ) {
	$args['tax_query'] = array(
		array(
			'taxonomy' => 'category',
			'field'    => 'slug',
			'terms'    => array( $params['cat_post'] ),
		),
	);
}

$events = new WP_Query( $args );

?>
<div class="row thim-sc-events owl-carousel owl-theme events-layer-2 <?php echo esc_attr( $params['el_class'] ); ?> " data-cols="1">
	<?php if ( $events->have_posts() ) : ?>
		<?php while ( $events->have_posts() ) : $events->the_post(); ?>
			<div class="events">
				<div class="events-before">
					<div class="content-inner">


						<h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
						<div class="time-location">
								<span class="time">
                                    <span><i class="ion-android-alarm-clock"></i><?php echo get_the_date( get_option( 'date_format' ) ); ?></span>
                                    <span style="margin-left: 10px"><i class="fa fa-comments-o"></i><?php thim_entry_meta_comment_number(); ?></span>
								</span>
						</div>
						<div class="line"></div>
						<p class="description">
							<?php echo wp_trim_words( get_the_content(), 15, '...' ); ?>
						</p>
						<div class="author">
							<?php echo get_avatar( get_the_author_meta( 'ID' ), 40 ); ?>
							<div class="author-contain">
								<span class="jobTitle"><?php esc_html_e( 'Host', 'course-builder' ); ?></span>
								<span class="name">
											<a href="<?php echo esc_url( learn_press_user_profile_link( $events->post->post_author ) ); ?>">
												<?php echo get_the_author(); ?>
											</a>
										</span>
							</div>
						</div>
					</div>
				</div>

				<div class="events-after">
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="thumbnail">
							<?php thim_thumbnail( get_the_ID(), '342x381', 'post', true ); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		<?php endwhile; ?>
	<?php else : ?>
		<p><?php esc_html_e( 'Sorry, no posts matched your criteria.', 'course-builder' ); ?></p>
	<?php endif; ?>
</div>

<script type="text/javascript">
	jQuery(document).ready(function () {
		"use strict";
		if (jQuery("body").hasClass("elementor-editor-active")) {
			jQuery(".thim-sc-events").each(function (index, element) {
				var cols = jQuery(element).attr('data-cols');
				var cols_mobile = 2;
				var cols_ipad = cols;
				var $carousel = jQuery(element);
				if(jQuery(element).hasClass('events-layer-3')) {
					cols_mobile = 1;
					cols_ipad = 2;
				}
				if(jQuery(element).hasClass('events-layer-2')) {
					cols_mobile = 1;
				}
				if(jQuery(element).hasClass('events-layer-1')) {
					cols_mobile = 1;
					var $carousel = jQuery(element).find('.event-wrapper');
				}
				var rtlval = false;
				if(jQuery('body').hasClass('rtl')) {
					var rtlval = true;
				}
				var test = $carousel.owlCarousel({
					rtl		  : rtlval,
					items     : cols,
					nav       : true,
					dots      : false,
					margin    : 40,
					navText   : ['<i class="ion-ios-arrow-left" aria-hidden="true"></i>', '<i class="ion-ios-arrow-right"></i>'],
					responsive: {
						0  : {
							items: 1
						},
						480: {
							items: cols_mobile
						},
						481: {
							items: cols_ipad
						},
						769: {
							items: cols
						}
					}
				});
			});
		}
	});
</script>