<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Thim_SC_Posts' ) ) {

	class Thim_SC_Posts {

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
			$this->name        = esc_attr__( 'Thim: Posts Gallery', 'course-builder' );
			$this->description = esc_attr__( 'Display a post list.', 'course-builder' );
			$this->base        = 'posts';
			//====================== END: CONFIG =====================


			$this->map();
			add_action( 'wp_enqueue_scripts', array( $this, 'assets' ) );
			add_shortcode( 'thim-' . $this->base, array( $this, 'shortcode' ) );
		}

		/**
		 * Load assets
		 */
		public function assets() {
			wp_register_script( 'thim-posts', THIM_CB_URL . $this->base . '/assets/js/post-custom.js', array( 'jquery' ), '', true );
			wp_enqueue_script( 'thim-posts' );
		}

		/**
		 * vc map shortcode
		 */
		public function map() {
			vc_map(
				array(
					'name'        => $this->name,
					'base'        => 'thim-' . $this->base,
					'category'    => esc_attr__( 'Thim Shortcodes', 'course-builder' ),
					'description' => $this->description,
					'icon'        => THIM_CB_URL . $this->base . '/assets/images/icon/sc-events.png',
					'params'      => array(
						array(
							'type'             => 'dropdown',
							'heading'          => esc_html__( 'Select post category', 'course-builder' ),
							'param_name'       => 'cat_post',
							'admin_label'      => true,
							'value'            => $this->thim_get_post_categories(),
							'edit_field_class' => 'vc_col-sm-6',
						),

						array(
							'type'             => 'number',
							'admin_label'      => true,
							'heading'          => esc_html__( 'Number of posts', 'course-builder' ),
							'param_name'       => 'number_post',
							'edit_field_class' => 'vc_col-sm-12',
							'description'      => esc_html__( 'Choose number of posts to show', 'course-builder' ),
							'value'            => '3',
						),

						array(
							"type"       => "radio_image",
							"heading"    => esc_attr__( "Layout", 'course-builder' ),
							"param_name" => "layer_events",
							"options"    => array(
								'default' => THIM_CB_URL . $this->base . '/assets/images/layouts/layout.png',
							),
							"std"        => "default",
						),

						array(
							'type'        => 'textfield',
							'admin_label' => true,
							'heading'     => esc_attr__( 'Extra class name', 'course-builder' ),
							'param_name'  => 'el_class',
							'value'       => '',
							'description' => esc_attr__( 'Add extra class name for Thim Posts shortcode to use in CSS customizations.', 'course-builder' ),
						),
					)
				)
			);
		}

		/**
		 * Add shortcode
		 *
		 * @param $atts
		 */
		public function shortcode( $atts ) {

			$params = shortcode_atts( array(
				'cat_post'    => 0,
				'number_post' => '3',
				'el_class'      => '',

			), $atts );

			$params['base'] = $this->base;

			$number_events = ! empty( $params['number_post'] ) ? $params['number_post'] : 1;
			$args          = array(
				'post_type'      => 'post',
				'posts_per_page' => $number_events,
			);

			if ( $params['cat_post'] ) {
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'category',
						'field'    => 'slug',
						'terms'    => array( $params['cat_post'] ),
					),
				);
			}

			$events = new WP_Query( $args );

			$params['query'] = $events;

			ob_start();
			thim_get_template( 'default', array( 'params' => $params ), $this->base . '/tpl/' );

			$html = ob_get_contents();
			ob_end_clean();
			wp_reset_postdata();

			return $html;
		}

		/*
		 * Get categories of LearnPress ( has count > 0 )
		 * */
        // Get list category
        public function thim_get_post_categories($cats = false)
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
                'category', 0
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

	new Thim_SC_Posts();
}