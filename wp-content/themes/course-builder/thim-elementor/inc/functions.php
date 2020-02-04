<?php
/**
 * @param $css_animation
 *
 * @return string
 */
function thim_element_getCSSAnimation( $css_animation ) {
	$output = '';
	if ( $css_animation != '' ) {
		wp_enqueue_script( 'waypoints' );
		$output = ' wpb_animate_when_almost_visible wpb_' . $css_animation;
	}

	return $output;
}

/**
 * @param array  $params
 * @param string $position
 */
function thim_element_display_widget_area( $params = array(), $position = '' ) {

	if ( $position === $params['widget_area'] && $params['widget_area'] != '' && $position != '' ) {
		if ( $params['widget_area_id'] ) {
			if ( is_active_sidebar( $params['widget_area_id'] ) ) {
				$html = '<div class="thim-sidebar-area">';

				ob_start();
				WPBMap::addAllMappedShortcodes();
				dynamic_sidebar( $params['widget_area_id'] );
				$html .= ob_get_contents();
				ob_end_clean();

				$html .= '</div>';
				echo ent2ncr( $html );
			}
		}
	}

}

/**
 * @param $id
 * @param $size
 *
 * @return string
 */
function thim_element_thumbnail_no_loaded( $id, $size ) {
	$thumbnail_size = explode( 'x', $size );
	$width          = 0;
	$height         = 0;
	$src            = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'full' );
	$img_src        = $src[0];

	if ( $img_src ) {
		if ( !isset( $thumbnail_size[1] ) ) {
			$thumbnail_size[1] = null;
		}

		if ( $size != 'full' && !in_array( $size, get_intermediate_image_sizes() ) ) {
			$width  = $thumbnail_size[0];
			$height = $thumbnail_size[1];

			$img_src = thim_aq_resize( $src[0], $width, $height, true );

		} else {
			if ( $size == 'full' ) {
				$img_src = $src[0];
			} else {
				$image_size = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), $size );
				$width      = $image_size[1];
				$height     = $image_size[2];
			}
		}

		return '<img ' . image_hwstring( $width, $height ) . ' src="' . esc_attr( $img_src ) . '" alt="' . get_the_title( $id ) . '">';
	}
}

/**
 * @param        $id
 * @param        $size
 * @param string $hw
 *
 * @return int|null
 */
function thim_element_get_thumbnail_hw( $id, $size, $hw = 'width' ) {
	$thumbnail_size = explode( 'x', $size );

	$width  = 0;
	$height = 0;
	$src    = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'full' );

	if ( !isset( $thumbnail_size[1] ) ) {
		$thumbnail_size[1] = null;
	}

	if ( $size != 'full' && !in_array( $size, get_intermediate_image_sizes() ) ) {
		$width  = $thumbnail_size[0];
		$height = $thumbnail_size[1];
	} else {
		if ( $size == 'full' ) {
			$width  = $src[1];
			$height = $src[2];
		} else {
			$image_size = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), $size );
			$width      = $image_size[1];
			$height     = $image_size[2];
		}
	}

	if ( $hw == 'width' ) {
		return $width;
	} else {
		return $height;
	}

}

/**
 * Show userid in profile edit
 */
add_action( 'show_user_profile', 'thim_element_extra_profile_show_userid' );
add_action( 'edit_user_profile', 'thim_element_extra_profile_show_userid' );
function thim_element_extra_profile_show_userid( $user ) {
	?>
	<table class="form-table">
		<tr>
			<th>
				<label><?php esc_html_e( 'User ID', 'course-builder' ); ?></label>
			</th>
			<td>

				<input type="text" value="<?php echo esc_attr( $user->ID ) ?>" disabled="disabled" class="regular-text">
				<span class="description"><?php esc_html_e( 'ID cannot be changed.', 'course-builder' ); ?></span>
			</td>
		</tr>
	</table>
	<?php
}

function element_course_number( $course_id ) {
	$number_courses = count( get_post_meta( $course_id, '_lp_collection_courses' ) );

	if ( $number_courses >= 1000 ) {
		$number_courses = intval( $number_courses / 1000 ) * 1000;
		echo '<div class="number-courses">' . esc_html( sprintf( __( 'Over %d courses', 'course-builder' ), $number_courses ) ) . '</div>';
	} elseif ( $number_courses >= 100 ) {
		$number_courses = intval( $number_courses / 100 ) * 100;
		echo '<div class="number-courses">' . esc_html( sprintf( __( 'Over %d courses', 'course-builder' ), $number_courses ) ) . '</div>';
	} elseif ( $number_courses > 1 ) {
		echo '<div class="number-courses">' . esc_html( sprintf( __( '%d courses', 'course-builder' ), $number_courses ) ) . '</div>';
	} else {
		echo '<div class="number-courses">' . esc_html( sprintf( __( '%d course', 'course-builder' ), $number_courses ) ) . '</div>';
	}
}

add_action( 'wp_ajax_nopriv_thim_course_search', 'thim_element_course_search_callback' );
add_action( 'wp_ajax_thim_course_search', 'thim_element_course_search_callback' );
function thim_element_course_search_callback() {
	$keyword = $_REQUEST['keyword'];
	$newdata = array();
	if ( $keyword ) {
		$keyword   = strtoupper( $keyword );
		$arr_query = array(
			'post_type'           => 'lp_course',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
			's'                   => $keyword
		);
		$search    = new WP_Query( $arr_query );
		foreach ( $search->posts as $post ) {
			$newdata[] = array(
				'id'    => $post->ID,
				'title' => $post->post_title,
				'guid'  => get_permalink( $post->ID ),
			);
		}

		if ( !count( $search->posts ) ) {
			$newdata[] = array(
				'id'    => '',
				'title' => esc_attr__( 'No course found', 'course-builder' ),
				'guid'  => '#',
			);
		}
	}
	wp_send_json_success( $newdata );
	wp_die();
}

add_action( 'elementor/editor/after_enqueue_styles', 'admin_enqueue_assets' );
function admin_enqueue_assets() {
	wp_enqueue_style( 'thim-wplms-custom-radio-image', get_template_directory_uri() . '/thim-elementor/assets/css/admin-element-css.css' );
	wp_enqueue_style( 'thim-wplms-albert-icon', get_template_directory_uri() . '/thim-elementor/assets/css/icon.css' );
	wp_enqueue_style( 'ionicons', THIM_URI . 'assets/css/libs/ionicons/ionicons.css', array() );
}

add_action( 'elementor/editor/before_enqueue_scripts', 'admin_enqueue_script' );
function admin_enqueue_script() {
	wp_enqueue_script( 'owlcarousel', THIM_URI . 'assets/js/libs/owl.carousel.min.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'thim-brands', THIM_URI . 'thim-elementor/elements/brands/assets/js/brands-custom.js', array(
		'jquery',
		'owlcarousel'
	), '', true );
}

function element_get_video( $url = '' ) {
	$video_id = $html = '';
	switch ( element_video_type( $url ) ) {
		case 'vimeo':
			$video_id = element_parse_vimeo( $url );
			$html     .= '<iframe src="https://player.vimeo.com/video/' . $video_id . '?title=0&byline=0" width="640" height="268"  webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
			break;
		case 'youtube':
			$video_id = element_parse_youtube( $url );
			$html     .= '<iframe width="560" height="315" src="https://www.youtube.com/embed/' . $video_id . '" allowfullscreen></iframe>';
			break;
		default:
			$html .= esc_html_e( 'Supported: Vimeo, Youtube', 'course-builder' );
			break;
	}

	return $html;
}

function element_video_type( $url ) {
	if ( strpos( $url, 'youtube' ) > 0 ) {
		return 'youtube';
	} elseif ( strpos( $url, 'vimeo' ) > 0 ) {
		return 'vimeo';
	} else {
		return 'unknown';
	}
}

function element_parse_youtube( $link ) {

	$regexstr = '~
			# Match Youtube link and embed code
			(?:				 				# Group to match embed codes
				(?:&lt;iframe [^&gt;]*src=")?	 
				|(?:				 		# Group to match if older embed
					(?:&lt;object .*&gt;)?		# Match opening Object tag
					(?:&lt;param .*&lt;/param&gt;)*  # Match all param tags
					(?:&lt;embed [^&gt;]*src=")?  # Match embed tag to the first quote of src
				)?				 			# End older embed code group
			)?				 				# End embed code groups
			(?:				 				# Group youtube url
				https?:\/\/		         	# Either http or https
				(?:[\w]+\.)*		        # Optional subdomains
				(?:               	        # Group host alternatives.
				youtu\.be/      	        # Either youtu.be,
				| youtube\.com		 		# or youtube.com 
				| youtube-nocookie\.com	 	# or youtube-nocookie.com
				)				 			# End Host Group
				(?:\S*[^\w\-\s])?       	# Extra stuff up to VIDEO_ID
				([\w\-]{11})		        # $1: VIDEO_ID is numeric
				[^\s]*			 			# Not a space
			)				 				# End group
			"?				 				# Match end quote if part of src
			(?:[^&gt;]*&gt;)?			 			# Match any extra stuff up to close brace
			(?:				 				# Group to match last embed code
				&lt;/iframe&gt;		         
				|&lt;/embed&gt;&lt;/object&gt;	        # or Match the end of the older embed
			)?				 				# End Group of last bit of embed code
			~ix';

	preg_match( $regexstr, $link, $matches );

	return $matches[1];

}

function element_parse_vimeo( $link ) {

	$regexstr = '~
			# Match Vimeo link and embed code
			(?:&lt;iframe [^&gt;]*src=")?	
			(?:							# Group vimeo url
				https?:\/\/				# Either http or https
				(?:[\w]+\.)*			# Optional subdomains
				vimeo\.com				# Match vimeo.com
				(?:[\/\w]*\/videos?)?	# Optional video sub directory this handles groups links also
				\/						# Slash before Id
				([0-9]+)				# $1: VIDEO_ID is numeric
				[^\s]*					# Not a space
			)							# End group
			"?							# Match end quote if part of src
			(?:[^&gt;]*&gt;&lt;/iframe&gt;)?	
			(?:&lt;p&gt;.*&lt;/p&gt;)?		        # Match any title information stuff
			~ix';

	preg_match( $regexstr, $link, $matches );

	return $matches[1];

}

add_action( 'thim_element_social_share_video', 'element_social_share_video' );
function element_social_share_video() {
	echo '<span class="label">' . esc_html__( 'Share', 'course-builder' ) . '</span>';
	echo '<ul>';
	global $post;
	$src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
	echo '<li><a class="link facebook" title="' . esc_html__( 'Facebook', 'course-builder' ) . '" href="http://www.facebook.com/sharer/sharer.php?u=' . urlencode( get_permalink() ) . '&amp;media=' . ( !empty( $src[0] ) ? $src[0] : '' ) . '&description=' . esc_attr( urlencode( get_the_title() ) ) . '" onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>';
	echo '<li><a class="link twitter" title="' . esc_html__( 'Twitter', 'course-builder' ) . '" href="https://twitter.com/intent/tweet?url=' . urlencode( get_permalink() ) . '&amp;text=' . esc_attr( urlencode( get_the_title() ) ) . '" onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>';
	echo '<li><a class="link google" title="' . esc_html__( 'Google', 'course-builder' ) . '" href="https://plus.google.com/share?url=' . esc_url( urlencode( get_permalink() ) ) . '&amp;media=' . ( !empty( $src[0] ) ? $src[0] : '' ) . '&description=' . esc_attr( urlencode( get_the_title() ) ) . '" onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="ion-social-googleplus" aria-hidden="true"></i></a></li>';
	echo '<li><a class="link pinterest" title="' . esc_html__( 'Pinterest', 'course-builder' ) . '" href="http://pinterest.com/pin/create/button/?url=' . urlencode( get_permalink() ) . '&amp;media=' . ( !empty( $src[0] ) ? $src[0] : '' ) . '&description=' . esc_attr( urlencode( get_the_title() ) ) . '" onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>';
	echo '</ul>';
}

if ( !function_exists( 'lp_element_get_courses_popular' ) ) {
	function lp_element_get_courses_popular() {
		global $wpdb;
		$popular_courses_query = $wpdb->prepare(
			"SELECT po.*, count(*) as number_enrolled 
					FROM {$wpdb->prefix}learnpress_user_items ui
					INNER JOIN {$wpdb->posts} po ON po.ID = ui.item_id
					WHERE ui.item_type = %s
						AND ( ui.status = %s OR ui.status = %s )
						AND po.post_status = %s
					GROUP BY ui.item_id 
					ORDER BY ui.item_id DESC
				",
			LP_COURSE_CPT,
			'enrolled',
			'finished',
			'publish'
		);
		$popular_courses       = $wpdb->get_results(
			$popular_courses_query
		);

		$temp_arr = array();
		foreach ( $popular_courses as $course ) {
			array_push( $temp_arr, $course->ID );
		}

		return $temp_arr;
	}
}

if ( !function_exists( 'thim_element_get_all_courses_instructors' ) ) {
	function thim_element_get_all_courses_instructors() {
		$teacher       = array();
		$users_by_role = get_users( array( 'role' => 'lp_teacher' ) );
		if ( $users_by_role ) {
			foreach ( $users_by_role as $user ) {
				$teacher[] = $user->ID;
			}
		}
		$result = array();
		if ( $teacher ) {
			foreach ( $teacher as $id ) {
				$courses        = learn_press_get_course_of_user_instructor( array( 'user_id' => $id ) );
				$count_students = $count_rate = 0;
				foreach ( $courses["rows"] as $key => $course ) {
					//$user_count = $course->get_users_enrolled() ? $course->get_users_enrolled() : 0;
					$curd            = new LP_Course_CURD();
					$number_students = $curd->get_user_enrolled( $course->ID );
					$count_students  = count( $number_students ) ? $count_students + count( $number_students ) : $count_students;
					if ( thim_plugin_active( 'learnpress-course-review/learnpress-course-review.php' ) ) {
						$rate = learn_press_get_course_rate_total( $course->ID );
					} else {
						$rate = 0;
					}

					$count_rate = $rate ? $rate + $count_rate : $count_rate;
				}
				$result[] = array(
					'user_id'    => $id,
					'students'   => $count_students,
					'count_rate' => $count_rate
				);
			}
		}

		return $result;
	}
}