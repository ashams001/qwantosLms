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

<div class="thim-sc-events events-layer-1 <?php echo esc_attr( $setting['el_class'] ); ?> " data-cols="1">
	<div class="sc-title">
		<?php echo esc_html__( 'events', 'course-builder' ) ?>
	</div>
	<div class="event-wrapper owl-carousel owl-theme">
		<?php if ( $events->have_posts() ) : ?>
			<?php while ( $events->have_posts() ) : $events->the_post(); ?>
				<div class="events">
					<div class="events-before">
						<div class="title-date">
							<div class="date">
								<span class="date-start"><?php echo( wpems_event_end( 'd' ) ); ?></span>
								<span class="month-year-start"><?php echo( wpems_event_end( 'M / Y' ) ); ?></span>
							</div>
						</div>
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="thumbnail">
								<a href="<?php the_permalink() ?>"><?php thim_thumbnail( get_the_ID(), '465x389', 'post', false ); ?></a>
							</div>
						<?php endif; ?>
					</div>
					<div class="events-after">
						<div class="content">
							<div class="content-inner">
								<h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
								<div class="time-location">
								<span class="time">
									<i class="ion-android-alarm-clock"></i> <?php echo( wpems_event_start( 'g:i a' ) ); ?> - <?php echo( wpems_event_end( 'g:i a' ) ); ?>
								</span>
									<?php if ( wpems_event_location() ) { ?>
										<span class="location">
										<i class="ion-ios-location"></i> <?php echo( wpems_event_location() ); ?>
									</span>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php endwhile; ?>
		<?php else : ?>
			<p><?php esc_html_e( 'Sorry, no posts matched your criteria.', 'course-builder' ); ?></p>
		<?php endif; ?>
	</div>
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