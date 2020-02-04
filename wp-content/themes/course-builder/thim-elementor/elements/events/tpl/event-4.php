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

<div class="thim-events-block clearfix layout-4 <?php echo esc_attr( $setting['el_class'] ); ?> ">
	<div class="event-wrapper">
		<?php
		$first_event = true;
		if ( $events->have_posts() ) : ?>
			<?php while ( $events->have_posts() ) : $events->the_post(); ?>
				<?php if ( !$first_event ) : ?>
					<div class="event-item">
						<div class="event-detail">
							<div class="date">
								<?php echo wpems_get_time( 'd F' ); ?>
							</div>
							<h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
						</div>

					</div>
				<?php else: $first_event = false; ?>
					<div class="main-event">
						<div class="sc-title">
							<?php echo esc_html__( 'New events', 'course-builder' ) ?>
						</div>
						<div class="event-detail">
							<div class="date-month">
								<div class="date">
									<?php echo wpems_get_time( 'd' ); ?>
								</div>
								<div class="month">
									<?php echo wpems_get_time( 'F' ); ?>
								</div>
							</div>
							<div class="content clearfix">
								<h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
								<div class="meta">
									<div class="time">
										<i class="ion-android-alarm-clock"></i> <?php echo( wpems_event_start( 'g:i a' ) ); ?> - <?php echo( wpems_event_end( 'g:i a' ) ); ?>
									</div>
									<?php if ( wpems_event_location() ) { ?>
										<div class="location">
											<i class="ion-ios-location"></i> <?php echo( wpems_event_location() ); ?>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
						<div class="description">
							<?php echo the_excerpt(); ?>
						</div>
						<a class="view-detail" href="<?php the_permalink(); ?>"><?php echo esc_html__( 'view event', 'course-builder' ) ?>
							<i class="ion-ios-arrow-right"></i></a>
					</div>
				<?php endif; ?>
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