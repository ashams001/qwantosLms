<?php
/**
 * Build courses content
 */

defined( 'ABSPATH' ) || exit();


/* remove default breadcrumb */
remove_action( 'learn_press_before_main_content', 'learn_press_breadcrumb' );
remove_action( 'learn_press_courses_loop_item_title', 'learn_press_courses_loop_item_title', 10 );
remove_action( 'learn_press_content_landing_summary', 'learn_press_course_buttons', 15 );
remove_action( 'learn_press_content_landing_summary', 'learn_press_course_students', 30 );

/**
 * Landing
 */
remove_action( 'learn_press_content_landing_summary', 'learn_press_course_buttons', 70 );
remove_action( 'learn_press_content_landing_summary', 'learn_press_course_price', 25 );
remove_action( 'learn_press_content_landing_summary', 'learn_press_course_tabs', 50 );
remove_action( 'learn_press_content_landing_summary', 'learn_press_course_instructor', 60 );

add_action( 'learn_press_content_landing_summary', 'learn_press_course_curriculum', 60 );
add_action( 'learn_press_content_landing_summary', 'learn_press_course_overview_tab', 51 );
add_action( 'learn_press_content_landing_summary', 'learn_press_course_instructor', 65 );
remove_action( 'learn_press_content_landing_summary', 'thim_course_rate', 70 );
remove_action( 'learn_press_content_landing_summary', 'thim_related_courses', 75 );
remove_action( 'learn_press_content_landing_summary', 'thim_course_review', 71 );
//add_action( 'learn_press_content_landing_summary', 'thim_course_rate', 70 );
//add_action( 'learn_press_content_landing_summary', 'thim_related_courses', 75 );
//add_action( 'learn_press_content_landing_summary', 'thim_course_review', 71 );


/**
 * Learning
 */
remove_action( 'learn_press_content_learning_summary', 'learn_press_course_instructor', 20 );
remove_action( 'learn_press_content_learning_summary', 'learn_press_course_status', 15 );
remove_action( 'learn_press_content_learning_summary', 'learn_press_course_students', 25 );
remove_action( 'learn_press_content_learning_summary', 'learn_press_course_progress', 45 );
remove_action( 'learn_press_content_learning_summary', 'learn_press_course_buttons', 65 );

add_action( 'thim_learning_after_tabs_wrapper', 'learn_press_course_remaining_time', 10 );
add_action( 'thim_learning_end_tab_curriculum', 'learn_press_course_buttons', 65 );
add_action( 'learn_press_course_lesson_quiz_before_title', 'thim_add_format_icon', 11, 2 );
add_action( 'comment_form_course', 'thim_course_get_avatar', 60 );

//remove tab instructor learning page
add_filter( 'learn_press_course_tabs', function ( $tabs ) {
	if ( ! empty( $tabs['co-instructor'] ) ) {
		unset( $tabs['co-instructor'] );
	}

	return $tabs;
}, 10 );

//Remove Wishlist
if ( thim_plugin_active( 'learnpress-wishlist/learnpress-wishlist.php' ) || class_exists( 'LP_Addon_Wishlist' ) ) {
	$addon_wishlist = LP_Addon_Wishlist::instance();
	remove_action( 'learn_press_content_learning_summary', array( $addon_wishlist, 'wishlist_button' ), 100 );
}

// Remove default forum link in single course
if ( thim_plugin_active( 'learnpress-bbpress/learnpress-bbpress.php' ) || class_exists( 'LP_Addon_BBPress_Course_Forum' ) ) {
	$addon_bbpress = LP_Addon_BBPress_Course_Forum::instance();
	remove_action( 'learn_press_after_single_course_summary', array( $addon_bbpress, 'forum_link' ) );
}

//Profile Page
remove_action( 'learn_press_after_profile_loop_course', 'learn_press_after_profile_tab_loop_course', 5, 2 );
if ( thim_plugin_active( 'learnpress-co-instructor/learnpress-co-instructor.php' ) || class_exists( 'LP_Addon_Co_Instructor' ) ) {
	$addon_co_instructor = LP_Addon_Co_Instructor::instance();
	remove_filter( 'learn_press_user_profile_tabs', array(
		$addon_co_instructor,
		'learn_press_add_tab_instructor_in_profile'
	), 15, 2 );
}

//Collections
remove_action( 'learn_press_collections_before_single_summary', 'learn_press_collections_title', 5 );

//Lesson Quiz
remove_action( 'learn_press/after_course_item_content', 'learn_press_lesson_comment_form', 10, 2 );

// Certificates
if ( ! is_user_logged_in() ) {
	if ( thim_plugin_active( 'learnpress-certificates/learnpress-certificates.php' ) || class_exists( 'LP_Addon_Certificates' ) ) {
		$addon_certificates = LP_Addon_Certificates::instance();
		remove_filter( 'learn_press_user_profile_tabs', array( $addon_certificates, 'certificates_tab' ), 105, 2 );
	}
}

/*
 * Override LearnPress Review tab content
 * */

function thim_add_course_tab_reviews( $tabs ) {
	$tabs['reviews'] = array(
		'title'    => esc_attr__( 'Reviews', 'course-builder' ),
		'priority' => 0,
		'callback' => 'thim_add_course_tab_reviews_callback'
	);

	return $tabs;
}

function thim_add_course_tab_reviews_callback() {
	$course        = LP()->global['course'];
	$user          = learn_press_get_current_user();
	$rate          = true;
	$rate          = learn_press_get_user_rate( $course->id, $user->id );
	$status        = $user->get_course_status( $course->id );
	$style_landing = '';

	if ( $status == 'enrolled' || $status == 'finished' ) {
		?>
		<h4 class="title_row_course "><?php esc_html_e( 'Rating', 'course-builder' ); ?></h4>
	<?php } ?>
	<div class="rating-review">
		<?php
		if ( $status != 'enrolled' && $status != 'finished' ) {
			$style_landing = 'text-left';
			?>
			<h3 class="title_row_course <?php echo esc_attr( $style_landing ) ?>"><?php esc_html_e( 'Review', 'course-builder' ); ?></h3>
			<?php
		}
		thim_course_rate();
		thim_course_review();
		if ( $rate == false || ( $rate == true && $rate->rating == '' ) ) {
			if ( $status == 'enrolled' ) {
				add_review_button();
			}
		}
		?>
	</div>
	<?php
}

add_action( 'learn_press_before_template_part', 'thim_modify_course_review_template' );
function thim_modify_course_review_template( $template_name ) {
	if ( $template_name !== 'content-single-course.php' ) {
		return;
	}

	if ( class_exists( 'LP_Addon_Course_Review' ) ) {
		$addon_review = LP_Addon_Course_Review::instance();

		remove_filter( 'learn_press_course_tabs', array( $addon_review, 'add_course_tab_reviews' ), 5 );
		add_filter( 'learn_press_course_tabs', 'thim_add_course_tab_reviews', 5 );

		add_action( 'learn_press_content_landing_summary', 'thim_add_course_tab_reviews_callback', 70 );
	}
}

function thim_course_instructor() {
	learn_press_get_template( 'single-course/instructor.php' );
}

function thim_course_rate() {
	learn_press_course_review_template( 'course-rate.php' );
}

function thim_course_review() {
	learn_press_course_review_template( 'course-review.php' );
}


function add_review_button() {
	learn_press_course_review_template( 'review-form.php' );
}

function thim_get_related_courses( $limit ) {
	if ( ! $limit ) {
		$limit = 3;
	}
	$course_id = get_the_ID();

	$tag_ids = array();
	$tags    = get_the_terms( $course_id, 'course_tag' );

	if ( $tags ) {
		foreach ( $tags as $individual_tag ) {
			$tag_ids[] = $individual_tag->slug;
		}
	}

	$args = array(
		'posts_per_page'      => $limit,
		'paged'               => 1,
		'ignore_sticky_posts' => 1,
		'post__not_in'        => array( $course_id ),
		'post_type'           => 'lp_course'
	);

	if ( $tag_ids ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'course_tag',
				'field'    => 'slug',
				'terms'    => $tag_ids
			)
		);
	}
	$related = array();
	if ( $posts = new WP_Query( $args ) ) {
		global $post;
		while ( $posts->have_posts() ) {
			$posts->the_post();
			$related[] = $post;
		}
	}
	wp_reset_query();

	return $related;
}

if ( ! function_exists( 'thim_related_courses' ) ) {

	function thim_related_courses() {
		$related_courses = thim_get_related_courses( 6 );
		if ( $related_courses ) {
			?>
			<div class="thim-related-course">
				<h3 class="related-title"><?php esc_html_e( 'CRelated Courses', 'course-builder' ); ?></h3>

				<div class="courses-carousel archive-courses course-grid owl-carousel owl-theme" data-cols="3">
					<?php foreach ( $related_courses as $course_item ) : ?>
						<?php
						$course      = LP_Course::get_course( $course_item->ID );
						$is_required = $course->is_required_enroll();
						$course_id   = $course_item->ID;
						if ( class_exists( 'LP_Addon_Course_Review' ) ) {
							$course_rate              = learn_press_get_course_rate( $course_id );
							$course_number_vote       = learn_press_get_course_rate_total( $course_id );
							$html_course_number_votes = $course_number_vote ? sprintf( _n( '(%1$s vote )', ' (%1$s votes)', $course_number_vote, 'course-builder' ), number_format_i18n( $course_number_vote ) ) : esc_html__( '(0 vote)', 'course-builder' );
						}
						?>
						<div class="inner-course">
							<?php do_action( 'learn_press_before_course_header' ); ?>

							<div class="wrapper-course-thumbnail">
								<?php if ( has_post_thumbnail( $course_id ) ) : ?>
									<a href="<?php the_permalink( $course_id ); ?>" class="img_thumbnail"><?php thim_thumbnail( $course_id, '277x310', 'post', false ); ?></a>
								<?php endif; ?>
								<div class="course-price">
									<?php if ( $price = $course->get_price_html() ) {

										$origin_price = $course->get_origin_price_html();
										$sale_price   = $course->get_sale_price();
										$sale_price   = isset( $sale_price ) ? $sale_price : '';
										?>
										<?php if ( $course->is_free() || ! $is_required ) { ?>
											<div class="value free-course" itemprop="price"
											     content="<?php esc_attr_e( 'Free', 'course-builder' ); ?>">
												<?php esc_html_e( 'Free', 'course-builder' ); ?>
											</div>
										<?php } else {
											if ( $sale_price !== '' ) {
												echo '<span class="course-origin-price">' . $origin_price . '</span>';
											}
											echo '<span class="price">' . esc_html( $price ) . '</span>';
										}
									} ?>
								</div>
								<?php if ( isset( $course_rate ) ): ?>
									<div class="course-rating">
										<?php learn_press_course_review_template( 'rating-stars.php', array( 'rated' => $course_rate ) ); ?>
									</div>
								<?php endif; ?>
							</div>
							<div class="item-list-center">
								<div class="course-title">
									<h2 class="title">
										<a href="<?php echo esc_url( get_the_permalink( $course_item->ID ) ); ?>"> <?php echo get_the_title( $course_item->ID ); ?></a>
									</h2>
								</div>
								<?php
								$count = $course->count_users_enrolled( 'append' ) ? $course->count_users_enrolled( 'append' ) : 0;
								?>
								<span class="date-comment"><?php echo get_the_date() . ' / '; ?>
									<?php $comment = get_comments_number();
									if ( $comment == 0 ) {
										echo esc_html__( "No Comments", 'course-builder' );
									} else {
                                        echo sprintf( _n( '%d Comment', '%d Comments', $comment, 'course-builder' ), $comment);
                                    }
									?>
								</span>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'thim_add_format_icon' ) ) {
	function thim_add_format_icon( $item ) {
		$format = get_post_format( $item->item_id );
		if ( get_post_type( $item->item_id ) == 'lp_quiz' ) {
			echo '<span class="course-format-icon"><i class="fa fa-question"></i></span>';
		} elseif ( $format == 'video' ) {
			echo '<span class="course-format-icon"><i class="fa fa-play"></i></span>';
		} elseif ( $format == 'audio' ) {
			echo '<span class="course-format-icon"><i class="fa fa-music"></i></span>';
		} elseif ( $format == 'image' ) {
			echo '<span class="course-format-icon"><i class="fa fa-picture-o"></i></span>';
		} elseif ( $format == 'aside' ) {
			echo '<span class="course-format-icon"><i class="fa fa-file-o"></i></span>';
		} elseif ( $format == 'quote' ) {
			echo '<span class="course-format-icon"><i class="fa fa-quote-left"></i></span>';
		} elseif ( $format == 'link' ) {
			echo '<span class="course-format-icon"><i class="fa fa-link"></i></span>';
		} else {
			echo '<span class="course-format-icon"><i class="fa fa-file-o"></i></span>';
		}
	}
}