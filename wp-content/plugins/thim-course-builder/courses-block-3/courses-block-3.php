<?php
/**
 * Class Course block 3 shortcode.
 *
 * @author  ThimPress
 * @package Course Builder/Shortcodes/Class
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

if ( ! class_exists( 'Thim_SC_Courses_Block_3' ) ) {
	/**
	 * Class Thim_SC_Courses_Block_3.
	 */
	class Thim_SC_Courses_Block_3 {

		/**
		 * @var string
		 */
		protected $name = '';

		/**
		 * @var string
		 */
		protected $description = '';

		/**
		 * @var string
		 */
		protected $base = '';

		/**
		 * Thim_SC_Courses_Block_3 constructor.
		 */
		public function __construct() {

			//======================== CONFIG ========================
			$this->name        = esc_attr__( 'Thim: Courses - Block 3', 'course-builder' );
			$this->description = esc_attr__( 'Display a courses block', 'course-builder' );
			$this->base        = 'courses-block-3';
			//====================== END: CONFIG =====================

			$this->map();
			add_action( 'wp_enqueue_scripts', array( $this, 'assets' ) );
			add_shortcode( 'thim-' . $this->base, array( $this, 'shortcode' ) );
		}

		/**
		 * Load assets.
		 */
		public function assets() {
			wp_register_script( 'thim-courses-block-3', THIM_CB_URL . $this->base . '/assets/js/courses-block-3-custom.js', array( 'jquery' ), '', true );
			wp_enqueue_script( 'thim-courses-block-3' );
		}

		/**
		 * VC map shortcode.
		 */
		public function map() {
			vc_map( array(
				'name'        => $this->name,
				'base'        => 'thim-' . $this->base,
				'category'    => esc_html__( 'Thim Shortcodes', 'course-builder' ),
				'icon'        => THIM_CB_URL . $this->base . '/assets/images/icon/sc-courses-block-3.png',
				'description' => $this->description,
				'params'      => array(
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Course Block Title:', 'course-builder' ),
						'param_name'  => 'title',
						'value'       => esc_html__( 'Our Top Courses', 'course-builder' ),
						'admin_label' => true,
					),

					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Button text:', 'course-builder' ),
						'description' => esc_html__( 'Enter button text linked to course archive page', 'course-builder' ),
						'param_name'  => 'button_text',
						'value'       => 'View all courses',
						'admin_label' => true,
					),

					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Hide categories filter?', 'course-builder' ),
						'param_name'  => 'filter',
						'description' => esc_html__( 'Check yes to hide the course category filter bar', 'course-builder' ),
						'value'       => array(
							esc_html__( 'Yes', 'course-builder' ) => 'yes',
						),
						'admin_label' => true,
					),

					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Number of columns:', 'course-builder' ),
						'param_name'  => 'cols',
						'admin_label' => true,
						'value'       => array(
							esc_html__( '3', 'course-builder' ) => '3',
							esc_html__( '4', 'course-builder' ) => '4',
						),
						'std'         => '4',
					),

					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Show courses by:', 'course-builder' ),
						'param_name'  => 'course_list',
						'admin_label' => true,
						'value'       => array(
							esc_html__( 'Latest', 'course-builder' )   => 'latest',
							esc_html__( 'Popular', 'course-builder' )  => 'popular',
							esc_html__( 'Category', 'course-builder' ) => 'category',
						)
					),

					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Select Category', 'course-builder' ),
						'param_name'  => 'course_cat',
						'admin_label' => true,
						'value'       => $this->thim_get_course_categories(),
						"description" => esc_attr__( "Select which category if you choose to show courses by category.", 'course-builder' ),
					),

					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Show Featured Courses?', 'course-builder' ),
						'description' => esc_html__( 'Check yes to only show the featured courses.', 'course-builder' ),
						'value'       => array(
							esc_html__( 'Yes', 'course-builder' ) => esc_attr( 'yes' ),
						),
						'param_name'  => 'course_featured',
						'admin_label' => true,
					),

					array(
						'type'        => 'number',
						'heading'     => esc_html__( 'Number of visible courses:', 'course-builder' ),
						'description' => esc_html__( 'Number of courses to display in this block', 'course-builder' ),
						'param_name'  => 'course_limit',
						'value'       => 8,
						'admin_label' => true,
					),
				),
			) );
		}

		/**
		 * Add shortcode.
		 *
		 * @param $atts
		 *
		 * @return string
		 */
		public function shortcode( $atts ) {
			$params = shortcode_atts( array(
				'title'           => 'Our Top Courses',
				'filter'          => '',
				'button_text'     => 'View all courses',
				'course_list'     => 'latest',
				'course_featured' => '',
				'course_cat'      => '',
				'course_limit'    => 8,
				'cols'            => '4',
			), $atts );

			$path = thim_is_new_learnpress( '3.0' ) ? 'lp3/' : '';
			ob_start();
			thim_get_template( $path . 'default', array( 'params' => $params ), $this->base . '/tpl/' );
			$html = ob_get_contents();
			ob_end_clean();

			return $html;
		}

		/*
		 * Get categories of LearnPress ( has count > 0 )
		 * */
		public function get_categories() {
			$categories                                    = get_categories( 'taxonomy=course_category&type=lp_course' );
			$cats                                          = array();
			$cats[ esc_attr__( 'All', 'course-builder' ) ] = 0;
			if ( ! empty( $categories ) ) {
				foreach ( $categories as $key => $value ) {
					$cats[ $value->name ] = $value->slug;
				}
			}

			return $cats;
		}

        // Get list category
        public function thim_get_course_categories($cats = false)
        {
            global $wpdb;
            $query = $wpdb->get_results($wpdb->prepare(
                "
				  SELECT      t1.term_id, t2.name
				  FROM        $wpdb->term_taxonomy AS t1
				  INNER JOIN $wpdb->terms AS t2 ON t1.term_id = t2.term_id
				  WHERE t1.taxonomy = %s
				  AND t1.count > %d
				  ",
                'course_category', 0
            ));

            if (empty($cats)) {
                $cats = array();
            }

            $cats[esc_attr__('All', 'course-builder')] = '';

            if ( !empty($query) ) {
                foreach ($query as $key => $value) {
                    $cats[$value->term_id] = $value->name;
                }
            }

            return $cats;

        }
	}
}

new Thim_SC_Courses_Block_3();
