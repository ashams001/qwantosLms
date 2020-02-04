<div class="thim-events-block clearfix layout-4 <?php echo esc_attr( $params['el_class'] ); ?> ">
	<div class="event-wrapper">
		<?php
		$first_event = true;
		if ( $params['query']->have_posts() ) : ?>
			<?php while ( $params['query']->have_posts() ) : $params['query']->the_post(); ?>
				<?php if ( ! $first_event ) : ?>
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
						<a class="view-detail" href="<?php the_permalink(); ?>"><?php echo esc_html__('view event','course-builder') ?><i class="ion-ios-arrow-right"></i></a>
					</div>
				<?php endif; ?>
			<?php endwhile; ?>
		<?php else : ?>
			<p><?php esc_html_e( 'Sorry, no posts matched your criteria.', 'course-builder' ); ?></p>
		<?php endif; ?>
	</div>
</div>