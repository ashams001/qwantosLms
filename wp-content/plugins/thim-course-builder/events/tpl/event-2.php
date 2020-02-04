<div class="row thim-sc-events owl-carousel owl-theme events-layer-2 <?php echo esc_attr( $params['el_class'] ); ?> " data-cols="1">
	<?php if ( $params['query']->have_posts() ) : ?>
		<?php while ( $params['query']->have_posts() ) : $params['query']->the_post(); ?>
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
											<a href="<?php echo esc_url( learn_press_user_profile_link( $params['query']->post->post_author ) ); ?>">
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
