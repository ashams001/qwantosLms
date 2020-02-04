<?php

include_once 'lp-template-hooks.php';


function thim_learnpress_body_classes( $classes ) {

	if ( is_singular( 'lp_course' ) ) {
		$layouts = get_theme_mod( 'learnpress_single_course_style', 1 );
		$layouts = isset( $_GET['layout'] ) ? $_GET['layout'] : $layouts;

		$classes[] = 'thim-lp-layout-' . $layouts;

		$course = learn_press_get_the_course();
		$user   = learn_press_get_current_user();
		if ( $user->has_course_status( $course->id, array(
				'enrolled',
				'finished'
			) ) || ! $course->is_require_enrollment()
		) {
			$classes[] = 'lp-learning';
		} else {
			$classes[] = 'lp-landing';
		}
	}

	if ( learn_press_is_profile() ) {
		$classes[] = 'lp-profile';
	}

	return $classes;
}

add_filter( 'body_class', 'thim_learnpress_body_classes' );


/** * Add media meta data for a course
 *
 * @param $meta_box
 */
if ( ! function_exists( 'thim_add_course_meta' ) ) {
	function thim_add_course_meta( $meta_box ) {
		$fields             = $meta_box['fields'];
		$fields[]           = array(
			'name' => esc_html__( 'Media URL', 'course-builder' ),
			'id'   => 'thim_course_media',
			'type' => 'text',
			'size' => 100,
			'desc' => esc_html__( 'Supports 3 types of video urls: Direct video link, Youtube link, Vimeo link.', 'course-builder' ),
		);
		$fields[]           = array(
			'name' => esc_html__( 'Info Button Box', 'course-builder' ),
			'id'   => 'thim_course_info_button',
			'type' => 'text',
			'size' => 100,
			'desc' => esc_html__( 'Add text info button', 'course-builder' ),
		);
		$fields[]           = array(
			'name' => esc_html__( 'Includes', 'course-builder' ),
			'id'   => 'thim_course_includes',
			'type' => 'wysiwyg',
			'desc' => esc_html__( 'Includes infomation of Courses', 'course-builder' ),
		);
		$meta_box['fields'] = $fields;

		return $meta_box;
	}
}
add_filter( 'learn_press_course_settings_meta_box_args', 'thim_add_course_meta' );


if ( ! function_exists( 'thim_add_lesson_meta' ) ) {
	function thim_add_lesson_meta( $meta_box ) {
		$fields             = $meta_box['fields'];
		$fields[]           = array(
			'name' => esc_html__( 'Media', 'course-builder' ),
			'id'   => '_lp_lesson_video_intro',
			'type' => 'textarea',
			'desc' => esc_html__( 'Add an embed link like video, PDF, slider...', 'course-builder' ),
		);
		$meta_box['fields'] = $fields;

		return $meta_box;
	}
}
add_filter( 'learn_press_lesson_meta_box_args', 'thim_add_lesson_meta' );

/*
 *  Update additional fields user info
 * */
if ( ! function_exists( 'thim_save_extra_user_profile_fields' ) ) {
	function thim_save_extra_user_profile_fields( $user_id ) {
		if ( ! current_user_can( 'edit_user', $user_id ) ) {
			return false;
		}

		update_user_meta( $user_id, 'lp_info', $_POST['lp_info'] );
	}
}

add_action( 'personal_options_update', 'thim_save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'thim_save_extra_user_profile_fields' );

if ( ! function_exists( 'thim_get_user_socials' ) ) {
	function thim_get_user_socials( $user_meta ) {
		if ( ! empty( $user_meta['lp_info_instagram'] ) || ! empty( $user_meta['lp_info_linkedin'] ) || ! empty( $user_meta['lp_info_facebook'] ) || ! empty( $user_meta['lp_info_twitter'] ) || ! empty( $user_meta['lp_info_skype'] ) || ! empty( $user_meta['lp_info_pinterest'] ) || ! empty( $user_meta['lp_info_google_plus'] ) ):
			?>
            <ul class="profile-list-social breadcrumbs" itemprop="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList" id="breadcrumbs">
				<?php if ( ! empty( $user_meta['lp_info_facebook'] ) ): ?>
                    <li class="item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                        <a itemprop="item" href="<?php echo esc_url( $user_meta['lp_info_facebook'] ); ?>" title="<?php esc_attr_e( 'Facebook', 'course-builder' ) ?>"><i class="fa fa-facebook"></i></a>
                    </li>
				<?php endif; ?>

				<?php if ( ! empty( $user_meta['lp_info_twitter'] ) ): ?>
                    <li class="item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                        <a itemprop="item" href="<?php echo esc_url( $user_meta['lp_info_twitter'] ); ?>" title="<?php esc_attr_e( 'Twitter', 'course-builder' ) ?>"><i class="fa fa-twitter"></i></a>
                    </li>
				<?php endif; ?>

				<?php if ( ! empty( $user_meta['lp_info_skype'] ) ): ?>
                    <li class="item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                        <a itemprop="item" href="<?php echo esc_url( $user_meta['lp_info_skype'] ); ?>" title="<?php esc_attr_e( 'Skype', 'course-builder' ) ?>"><i class="fa fa-skype"></i></a>
                    </li>
				<?php endif; ?>

				<?php if ( ! empty( $user_meta['lp_info_pinterest'] ) ): ?>
                    <li class="item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                        <a itemprop="item" href="<?php echo esc_url( $user_meta['lp_info_pinterest'] ); ?>" title="<?php esc_attr_e( 'Pinterest', 'course-builder' ) ?>"><i class="fa fa-pinterest"></i></a>
                    </li>
				<?php endif; ?>

				<?php if ( ! empty( $user_meta['lp_info_google_plus'] ) ): ?>
                    <li class="item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                        <a itemprop="item" href="<?php echo esc_url( $user_meta['lp_info_google_plus'] ); ?>" title="<?php esc_attr_e( 'Google Plus', 'course-builder' ) ?>"><i class="fa fa-google-plus"></i></a>
                    </li>
				<?php endif; ?>

                <?php if ( ! empty( $user_meta['lp_info_linkedin'] ) ): ?>
                    <li class="item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                        <a itemprop="item" href="<?php echo esc_url( $user_meta['lp_info_linkedin'] ); ?>" title="<?php esc_attr_e( 'Linkedin', 'course-builder' ) ?>"><i class="fa fa-linkedin"></i></a>
                    </li>
                <?php endif; ?>

                <?php if ( ! empty( $user_meta['lp_info_instagram'] ) ): ?>
                    <li class="item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                        <a itemprop="item" href="<?php echo esc_url( $user_meta['lp_info_instagram'] ); ?>" title="<?php esc_attr_e( 'Instagram', 'course-builder' ) ?>"><i class="fa fa-instagram"></i></a>
                    </li>
                <?php endif; ?>

            </ul>
		<?php
		endif;
	}
}

function thim_profile_loadmore_ajax() {
	global $post;
	$userid = $_POST['userid'];
	$user   = learn_press_get_current_user( $userid );
	$paged  = $_POST['paged'];
	$limit  = $_POST['limit'];

	$courses = $user->get( 'courses', array( 'limit' => $limit, 'paged' => $paged ) );

	if ( $courses ) {
		?>
		<?php foreach ( $courses as $post ) {
			setup_postdata( $post );
			?>

			<?php
			learn_press_get_template( 'profile/tabs/courses/loop.php', array(
				'user'      => $user,
				'course_id' => $post->ID
			) );
			?>

		<?php }
	}
	wp_reset_postdata();
	die();
}

add_action( 'wp_ajax_thim_profile_loadmore', 'thim_profile_loadmore_ajax' );
add_action( 'wp_ajax_nopriv_thim_profile_loadmore', 'thim_profile_loadmore_ajax' );

/**
 * Display co instructors
 *
 * @param $course_id
 */
if ( ! function_exists( 'thim_co_instructors' ) ) {
	function thim_co_instructors( $course_id, $author_id ) {
		if ( ! $course_id ) {
			return;
		}
		if ( thim_plugin_active( 'learnpress-co-instructor/learnpress-co-instructor.php' ) || class_exists( 'LP_Addon_Co_Instructor' ) ) {
			$instructors = get_post_meta( $course_id, '_lp_co_teacher' );
			$instructors = array_diff( $instructors, array( $author_id ) );
			if ( $instructors ) {
				foreach ( $instructors as $instructor ) {
					//Check if instructor not exist
					$user = get_userdata( $instructor );
					if ( $user === false ) {
						break;
					}

					$major = get_the_author_meta( 'lp_info_major', $instructor );
					$link  = learn_press_user_profile_link( $instructor );
					?>
                    <div class="thim-course-author instructors thim-co-instructor" itemprop="contributor" itemscope itemtype="http://schema.org/Person">
                        <div class="info thim-co-instructor">
                            <div class="lp-avatar">
                                <a href="<?php echo esc_url( $link ); ?>" class="role">
									<?php echo get_avatar( $instructor, 147 ); ?>
                                </a>
                                <div class="social">
									<?php thim_get_author_social_link(); ?>
                                </div>
                            </div>
                            <div class="content">
                                <div class="author">
                                    <a href="<?php echo esc_url( $link ); ?>" class="name">
										<?php echo get_the_author_meta( 'display_name', $instructor ); ?>
                                    </a>
									<?php if ( isset( $major ) && $major ) : ?>
                                        <div class="role"><?php echo esc_html( $major ); ?></div>
									<?php endif; ?>
                                </div>
                                <div class="author-description">
									<?php echo get_the_author_meta( 'description', $instructor ); ?>
                                </div>
                            </div>
                        </div>
                    </div>
					<?php
				}
			}
		}
	}
}

/**
 * About the author
 */
if ( ! function_exists( 'thim_instructors_author' ) ) {
	function thim_instructors_author() {
		$link  = learn_press_user_profile_link( get_the_author_meta( 'ID' ) );
		$user  = new WP_User( get_the_author_meta( 'ID' ) );
		$major = get_the_author_meta( 'lp_info_major', get_the_author_meta( 'ID' ) );
		?>
        <div class="thim-course-author instructors">
            <div class="text"><?php echo esc_html__( 'Instructors', 'course-builder' ) ?></div>
            <div class="info">
                <div class="lp-avatar">
                    <a href="<?php echo esc_url( $link ); ?>" class="role">
						<?php echo get_avatar( get_the_author_meta( 'ID' ), 147 ); ?>
                    </a>
                    <div class="social">
						<?php thim_get_author_social_link(); ?>
                    </div>
                </div>
                <div class="content">
                    <div class="author">
                        <a href="<?php echo esc_url( $link ); ?>" class="name">
							<?php echo get_the_author_meta( 'display_name', get_the_author_meta( 'ID' ) ); ?>
                        </a>
						<?php if ( isset( $major ) && $major ) : ?>
                            <div class="role"><?php echo esc_html( $major ); ?></div>
						<?php endif; ?>
                    </div>
                    <div class="author-description">
						<?php echo get_the_author_meta( 'description', get_the_author_meta( 'ID' ) ); ?>
                    </div>
                </div>
            </div>

        </div>
		<?php
		if ( thim_plugin_active( 'learnpress-co-instructor/learnpress-co-instructor.php' ) || class_exists( 'LP_Addon_Co_Instructor' ) ) {
			thim_co_instructors( get_the_ID(), get_the_author_meta( 'ID' ) );
		}

	}
}

//add_action( 'learn_press_content_learning_summary', 'thim_instructors_author', 60 );

if ( ! function_exists( 'thim_course_wishlist_button' ) ) {
	function thim_course_wishlist_button( $course_id = null ) {
		if ( ! thim_plugin_active( 'learnpress-wishlist/learnpress-wishlist.php' ) && ! class_exists( 'LP_Addon_Wishlist' ) ) {
			return;
		}
		LP_Addon_Wishlist::instance()->wishlist_button( $course_id );

	}
}

if ( ! function_exists( 'thim_course_get_avatar' ) ) {
	function thim_course_get_avatar() {
		$current_user = wp_get_current_user();
		$user_id      = $current_user->ID;
		$avatar       = get_avatar( $user_id, 42 );
		?>
        <span class="avatar"><?php echo( $avatar ); ?></span>
		<?php
	}
}


/**
 * Remove deps for learnpress.css
 *
 * @param $styles
 */
function thim_custom_learn_press_add_default_styles( $styles ) {
	$styles->registered['learn-press-style']->deps = array();
}

add_action( 'learn_press_add_default_styles', 'thim_custom_learn_press_add_default_styles' );


if ( ! function_exists( 'thim_is_learning' ) ) {
	/**
	 * true if is learning page, false if is landing page.
	 * @return bool
	 */
	function thim_is_learning() {
		$course = learn_press_get_the_course();
		$user   = learn_press_get_current_user();
		if ( $user->has_course_status( $course->id, array(
				'enrolled',
				'finished'
			) ) || ! $course->is_require_enrollment()
		) {
			return true;
		} else {
			return false;
		}
	}
}

/**
 * Get course, lesson, ... duration in hours
 *
 * @param $id
 *
 * @param $post_type
 *
 * @return string
 */

if ( ! function_exists( 'thim_duration_time_calculator' ) ) {
	function thim_duration_time_calculator( $id, $post_type = 'lp_course' ) {
		if ( $post_type == 'lp_course' ) {
			$course_duration_meta = get_post_meta( $id, '_lp_duration', true );
			$course_duration_arr  = array_pad( explode( ' ', $course_duration_meta, 2 ), 2, 'minute' );

			list( $number, $time ) = $course_duration_arr;

			switch ( $time ) {
				case 'week':
					$course_duration_text = sprintf( _n( "%s week", "%s weeks", $number, 'course-builder' ), $number );
					break;
				case 'day':
					$course_duration_text = sprintf( _n( "%s day", "%s days", $number, 'course-builder' ), $number );
					break;
				case 'hour':
					$course_duration_text = sprintf( _n( "%s hour", "%s hours", $number, 'course-builder' ), $number );
					break;
				default:
					$course_duration_text = sprintf( _n( "%s minute", "%s minutes", $number, 'course-builder' ), $number );
			}

			return $course_duration_text;
		} else { // lesson, quiz duration
			$duration = get_post_meta( $id, '_lp_duration', true );

			if ( ! $duration ) {
				return '';
			}
			$duration = ( strtotime( $duration ) - time() ) / 60;
			$hour     = floor( $duration / 60 );
			$minute   = $duration % 60;

			if ( $hour && $minute ) {
				$time = $hour . esc_html__( 'h', 'course-builder' ) . ' ' . $minute . esc_html__( 'm', 'course-builder' );
			} elseif ( ! $hour && $minute ) {
				$time = $minute . esc_html__( 'm', 'course-builder' );
			} elseif ( ! $minute && $hour ) {
				$time = $hour . esc_html__( 'h', 'course-builder' );
			} else {
				$time = '';
			}
			return $time;
		}
	}
}