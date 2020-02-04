<?php
/**
 * Plugin Name: Thim Element Course Builder
 * Plugin URI: http://thimpress.com
 * Description: Advanced features for Course Builder theme.
 * Author: ThimPress
 * Author URI: http://thimpress.com
 * Version: 1.0.0
 * Text Domain: course-builder
 */
// Exit if accessed directly

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists( 'Thim_Element_Course_Builder' ) ) {

	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

	class Thim_Element_Course_Builder {

		/**
		 * @var null
		 *
		 * @since 1.0.0
		 */
		protected static $_instance = null;

		/**
		 * Return unique instance.
		 *
		 * @since 1.0.0
		 */
		static function instance() {
			if ( !self::$_instance ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			define( 'THIM_CBEL_PATH', plugin_dir_path( __FILE__ ) );
			define( 'THIM_LIST_EL_PATH', THIM_CBEL_PATH . 'elements/' );
			define( 'THIM_CBE_URL', plugin_dir_url( __FILE__ ) );

			add_filter( 'user_contactmethods', array( $this, 'modify_contact_methods' ) );
			add_action( 'learn_press_update_user_profile_basic-information', array( $this, 'update_contact_methods' ), 9 );

			$this->init();

			add_action( 'init', array( $this, 'load_element' ), 30 );

			// Depend on Elementor
			if ( !is_plugin_active( 'elementor/elementor.php' ) ) {
				return;
			}
		}

		/**
		 * Add field to user profile
		 *
		 * @param $user_contact_method
		 *
		 * @return mixed
		 */
		public function modify_contact_methods( $user_contact_method ) {
			//Add Major
			$user_contact_method['lp_info_major'] = 'Major';
			//Add status
			$user_contact_method['lp_info_status'] = 'Status';
			//Add Phone
			$user_contact_method['lp_info_phone'] = 'Phone Number';
			//Add Facebook
			$user_contact_method['lp_info_facebook'] = 'Facebook';
			// Add Twitter
			$user_contact_method['lp_info_twitter'] = 'Twitter';
			// Add Twitter
			$user_contact_method['lp_info_skype'] = 'Skype';
			//Add Facebook
			$user_contact_method['lp_info_pinterest'] = 'Pinterest';
			//Add Google Plus URL
			$user_contact_method['lp_info_google_plus'] = 'Google Plus URL';

			$user_contact_method['lp_info_linkedin'] = 'Linkedin URL';

			$user_contact_method['lp_info_instagram'] = 'Instagram URL';

			return $user_contact_method;
		}

		public function update_contact_methods() {
			$user_id     = get_current_user_id();
			$update_data = array(
				'ID'                  => $user_id,
				'lp_info_major'       => filter_input( INPUT_POST, 'lp_info_major', FILTER_SANITIZE_STRING ),
				'lp_info_status'      => filter_input( INPUT_POST, 'lp_info_status', FILTER_SANITIZE_STRING ),
				'lp_info_phone'       => filter_input( INPUT_POST, 'lp_info_phone', FILTER_SANITIZE_STRING ),
				'lp_info_facebook'    => filter_input( INPUT_POST, 'lp_info_facebook', FILTER_SANITIZE_STRING ),
				'lp_info_twitter'     => filter_input( INPUT_POST, 'lp_info_twitter', FILTER_SANITIZE_STRING ),
				'lp_info_skype'       => filter_input( INPUT_POST, 'lp_info_skype', FILTER_SANITIZE_STRING ),
				'lp_info_pinterest'   => filter_input( INPUT_POST, 'lp_info_pinterest', FILTER_SANITIZE_STRING ),
				'lp_info_google_plus' => filter_input( INPUT_POST, 'lp_info_google_plus', FILTER_SANITIZE_STRING ),
				'lp_info_linkedin'    => filter_input( INPUT_POST, 'lp_info_linkedin', FILTER_SANITIZE_STRING ),
				'lp_info_instagram'   => filter_input( INPUT_POST, 'lp_info_instagram', FILTER_SANITIZE_STRING ),
			);
			$res         = wp_update_user( $update_data );
		}

		/**
		 * Register element.
		 *
		 * @since 1.0.0
		 */
		public function load_element() {

			$is_support = get_theme_support( 'thim-extend-vc-sc' );

			if ( !$is_support ) {
				return;
			}

			include_once( THIM_CBEL_PATH . 'elements/brands/brands.php' );
			include_once( THIM_CBEL_PATH . 'elements/social-links/social-links.php' );
			include_once( THIM_CBEL_PATH . 'elements/heading/heading.php' );
			include_once( THIM_CBEL_PATH . 'elements/google-map/google-map.php' );
			include_once( THIM_CBEL_PATH . 'elements/skills-bar/skills-bar.php' );
			include_once( THIM_CBEL_PATH . 'elements/icon-box/icon-box.php' );
			include_once( THIM_CBEL_PATH . 'elements/button/button.php' );
			include_once( THIM_CBEL_PATH . 'elements/count-down/count-down.php' );
			include_once( THIM_CBEL_PATH . 'elements/image-box/image-box.php' );
			include_once( THIM_CBEL_PATH . 'elements/scroll-heading/scroll-heading.php' );
			include_once( THIM_CBEL_PATH . 'elements/testimonials/testimonials.php' );
			include_once( THIM_CBEL_PATH . 'elements/counter-box/counter-box.php' );
			include_once( THIM_CBEL_PATH . 'elements/steps/steps.php' );
			include_once( THIM_CBEL_PATH . 'elements/video-box/video-box.php' );
			include_once( THIM_CBEL_PATH . 'elements/post-block-1/post-block-1.php' );
			include_once( THIM_CBEL_PATH . 'elements/photo-wall/photo-wall.php' );
			include_once( THIM_CBEL_PATH . 'elements/user-info/user-info.php' );
			include_once( THIM_CBEL_PATH . 'elements/features-list/features-list.php' );
			include_once( THIM_CBEL_PATH . 'elements/login-form/login-form.php' );
			include_once( THIM_CBEL_PATH . 'elements/gallery-carousel/gallery-carousel.php' );
			include_once( THIM_CBEL_PATH . 'elements/pricing/pricing.php' );
			include_once( THIM_CBEL_PATH . 'elements/introduction-box/introduction-box.php' );
			include_once( THIM_CBEL_PATH . 'elements/text-box/text-box.php' );
			include_once( THIM_CBEL_PATH . 'elements/gallery/gallery.php' );
			include_once( THIM_CBEL_PATH . 'elements/posts/posts.php' );
			include_once( THIM_CBEL_PATH . 'elements/new-iconbox/new-iconbox.php' );
			include_once( THIM_CBEL_PATH . 'elements/new-image-box/new-image-box.php' );
			include_once( THIM_CBEL_PATH . 'elements/new-post/new-post.php' );
			include_once( THIM_CBEL_PATH . 'elements/new-video/new-video.php' );

			// Shortcodes for LearnPress
			if ( class_exists( 'LearnPress' ) ) {
				include_once( THIM_CBEL_PATH . 'elements/enroll-course/enroll-course.php' );
				include_once( THIM_CBEL_PATH . 'elements/courses-carousel/courses-carousel.php' );
				include_once( THIM_CBEL_PATH . 'elements/course-search/course-search.php' );
				include_once( THIM_CBEL_PATH . 'elements/courses-block-1/courses-block-1.php' );
				include_once( THIM_CBEL_PATH . 'elements/courses-block-2/courses-block-2.php' );
				include_once( THIM_CBEL_PATH . 'elements/courses-block-3/courses-block-3.php' );
				include_once( THIM_CBEL_PATH . 'elements/courses-block-4/courses-block-4.php' );
				include_once( THIM_CBEL_PATH . 'elements/courses-megamenu/courses-megamenu.php' );
			}

			if ( class_exists( 'LP_Co_Instructor_Preload' ) ) {
				include_once( THIM_CBEL_PATH . 'elements/instructors/instructors.php' );
				include_once( THIM_CBEL_PATH . 'elements/new-instructor/new-instructor.php' );
			}

			if ( class_exists( 'LP_Addon_Course_Review' ) ) {
				include_once( THIM_CBEL_PATH . 'elements/review-course/review-course.php' );
			}

			// Shortcodes for WP Events Manager
			if ( class_exists( 'WPEMS' ) ) {
				include_once( THIM_CBEL_PATH . 'elements/events/events.php' );
			}

			// Shortcodes for LearnPress Collections
			if ( class_exists( 'LP_Addon_Collections' ) ) {
				include_once( THIM_CBEL_PATH . 'elements/courses-collection/courses-collection.php' );
			}

			// Shortcodes for Portfolio
			if ( class_exists( 'Thim_Portfolio' ) ) {
				include_once( THIM_CBEL_PATH . 'elements/portfolio/portfolio.php' );
			}

		}

		/**
		 * Load functions.
		 *
		 * @since 1.0.0
		 */
		public function init() {

			include_once( THIM_CBEL_PATH . 'inc/elementor-helper.php' );

			include_once( THIM_CBEL_PATH . 'inc/class-elementor-extend-icons.php' );

			include_once( THIM_CBEL_PATH . 'inc/elementor-get-template.php' );

			include_once( THIM_CBEL_PATH . 'inc/functions.php' );

		}

	}

	Thim_Element_Course_Builder::instance();
}
