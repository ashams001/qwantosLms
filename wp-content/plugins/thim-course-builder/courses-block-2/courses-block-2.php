<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Thim_SC_Courses_Block_2' ) ) {

	class Thim_SC_Courses_Block_2 {

		/**
		 * Shortcode name
		 * @var string
		 */
		protected $name = '';

		/**
		 * Shortcode description
		 * @var string
		 */
		protected $description = '';

		/**
		 * Shortcode base
		 * @var string
		 */
		protected $base = '';


		public function __construct() {

			//======================== CONFIG ========================
			$this->name        = esc_attr__( 'Thim: Courses - Block 2', 'course-builder' );
			$this->description = esc_attr__( 'Display a courses block', 'course-builder' );
			$this->base        = 'courses-block-2';
			//====================== END: CONFIG =====================


			$this->map();
			add_shortcode( 'thim-' . $this->base, array( $this, 'shortcode' ) );

		}

		/**
		 * vc map shortcode
		 */
		public function map() {
			vc_map( array(
				'name'        => $this->name,
				'base'        => 'thim-' . $this->base,
				'category'    => esc_html__( 'Thim Shortcodes', 'course-builder' ),
				'icon'        => THIM_CB_URL . $this->base . '/assets/images/icon/sc-courses-block-2.png',
				'description' => $this->description,
				'params'      => array(
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Course Block Title:', 'course-builder' ),
						'param_name'  => 'title',
						'value'       => 'Our Top Courses',
						'admin_label' => true,
					),

					array(
						'type'        => 'textarea',
						'heading'     => esc_html__( 'Course Block Description:', 'course-builder' ),
						'param_name'  => 'description',
						'value'       => 'Customize your online school with an intuitive user interface. Design your homepage and lectures.',
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
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Button link:', 'course-builder' ),
						'description' => esc_html__( 'Enter button link to course archive page', 'course-builder' ),
						'param_name'  => 'button_link',
						'admin_label' => true,
					),

					array(
						'type'        => 'number',
						'heading'     => esc_html__( 'Number of visible courses:', 'course-builder' ),
						'description' => esc_html__( 'Number of courses to display in this block', 'course-builder' ),
						'param_name'  => 'number_courses',
						'value'       => 7,
						'admin_label' => true,
					),


					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Select Course Category', 'course-builder' ),
						'param_name'  => 'cat_courses',
						'admin_label' => true,
                        'value'      => thim_sc_get_course_categories( array( 'All' => esc_html__( 'all', 'coaching' ) ) ),
					),

					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Show Featured Courses?', 'course-builder' ),
						'description' => esc_html__( 'Check yes to only show the featured courses.', 'course-builder' ),
						'value'       => array(
							esc_html__( 'Yes', 'course-builder' ) => esc_attr( 'yes' ),
						),
						'param_name'  => 'featured_courses',
						'admin_label' => true,
					),
				),
			) );
		}

		/**
		 * Add shortcode
		 *
		 * @param $atts
		 */
		public function shortcode( $atts ) {
			$params = shortcode_atts( array(
				'title'            => 'Our Top Courses',
				'description'      => 'Customize your online school with an intuitive user interface. Design your homepage and lectures.',
				'button_text'      => 'View all courses',
				'button_link'      => '',
				'number_courses'   => 7,
				'list_courses'     => 'latest',
				'cat_courses'      => '',
				'featured_courses' => '',
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

			$categories = get_categories( 'taxonomy=course_category&type=lp_course' );

            $cate       = array();
            $cate['All']    = esc_html__( '', 'course-builder' );
            if ( is_array( $categories ) ) {
                foreach ( $categories as $cat ) {
                    $cate[ $cat->term_id ] = $cat->name;
                }
            }

            return $cate;
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

            $cats[esc_attr__('All', 'course-builder')] = 0;

            if ( !empty($query) ) {
                foreach ($query as $key => $value) {
                    $cats[$value->term_id] = $value->name;
                }
            }

            return $cats;

        }
	}

	new Thim_SC_Courses_Block_2();
}