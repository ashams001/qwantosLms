<?php
$number_events = !empty( $setting['number_events'] ) ? $setting['number_events'] : 1;

$args = array(
	'post_type'      => 'tp_event',
	'posts_per_page' => $setting['number_events'],
	'order'          => $setting['order'] == 'asc' ? 'asc' : 'desc',
);
switch ( $setting['status_events'] ) {
	case 'upcoming':
		$args['meta_query'] = array(
			array(
				'key'     => 'tp_event_status',
				'value'   => 'upcoming',
				'compare' => '=',
			),
		);
		break;
	case 'happening':
		$args['meta_query'] = array(
			array(
				'key'     => 'tp_event_status',
				'value'   => 'happening',
				'compare' => '=',
			),
		);
		break;
	case 'expired':
		$args['meta_query'] = array(
			array(
				'key'     => 'tp_event_status',
				'value'   => 'expired',
				'compare' => '=',
			),
		);
		break;
	case 'not-expired':
		$args['meta_query'] = array(
			array(
				'key'     => 'tp_event_status',
				'value'   => array( 'upcoming', 'happening' ),
				'compare' => 'IN',
			),
		);
		break;
	default:
		$args['meta_query'] = array(
			array(
				'key'     => 'tp_event_status',
				'value'   => array( 'upcoming', 'happening', 'expired' ),
				'compare' => 'IN',
			),
		);
}


switch ( $setting['orderby'] ) {
	case 'time' :
		$args['orderby']  = 'meta_value';
		$args['meta_key'] = 'tp_event_date_end';
		break;
	case 'recent' :
		$setting['orderby'] = 'post_date';
		break;
	case 'title' :
		$setting['orderby'] = 'post_title';
		break;
	case 'popular' :
		$setting['orderby'] = 'comment_count';
		break;
	default : //random
		$setting['orderby'] = 'rand';
}


if ( $setting['cat_events'] ) {
	$args['tax_query'] = array(
		array(
			'taxonomy' => 'tp_event_category',
			'field'    => 'slug',
			'terms'    => array( $setting['cat_events'] ),
		),
	);
}

$events = new WP_Query( $args );
?>

<div class="row thim-sc-events owl-carousel owl-theme events-layer-2 <?php echo esc_attr( $setting['el_class'] ); ?> " data-cols="1">
	<?php if ( $events->have_posts() ) : ?>
		<?php while ( $events->have_posts() ) : $events->the_post(); ?>
			<div class="events">
				<div class="events-before">
					<div class="content-inner">
						<div class="date">
							<span class="date-start"><?php echo( wpems_event_start( 'd' ) ); ?></span>
							<span class="month-start"><?php echo( wpems_event_start( 'M Y' ) ); ?></span>
						</div>
						<h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
						<div class="time-location">
								<span class="time">
									<i class="ion-android-alarm-clock"></i> <?php echo( wpems_event_start( get_option( 'date_format' ) ) ); ?> - <?php echo( wpems_event_end( get_option( 'date_format' ) ) ); ?>
								</span>
							<?php if ( wpems_event_location() ) { ?>
								<span class="location">
										<i class="ion-ios-location"></i> <?php echo( wpems_event_location() ); ?>
									</span>
							<?php } ?>
						</div>
						<div class="line"></div>
						<a href="<?php the_permalink(); ?>"><p class="description">
								<?php echo wp_trim_words( get_the_content(), 35 ); ?>
							</p></a>
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