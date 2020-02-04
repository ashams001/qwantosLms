<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Thim_SC_Events' ) ) {

	class Thim_SC_Events {

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
			$this->name        = esc_attr__( 'Thim: Events', 'course-builder' );
			$this->description = esc_attr__( 'Display a events list.', 'course-builder' );
			$this->base        = 'events';
			//====================== END: CONFIG =====================


			$this->map();
			add_action( 'wp_enqueue_scripts', array( $this, 'assets' ) );
			add_shortcode( 'thim-' . $this->base, array( $this, 'shortcode' ) );
		}

		/**
		 * Load assets
		 */
		public function assets() {
			wp_register_script( 'thim-events', THIM_CB_URL . $this->base . '/assets/js/events-custom.js', array( 'jquery' ), '', true );
			wp_enqueue_script( 'thim-events' );
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
							'heading'          => esc_html__( 'Select event category', 'course-builder' ),
							'param_name'       => 'cat_events',
							'admin_label'      => true,
							'value'            => $this->thim_get_event_categories(),
							'edit_field_class' => 'vc_col-sm-6',
						),
						array(
							'type'             => 'dropdown',
							'admin_label'      => true,
							'heading'          => esc_html__( 'Event status', 'course-builder' ),
							'param_name'       => 'status_events',
							'value'            => array(
								esc_html__( 'All', 'course-builder' )  => array('upcoming','happenning','expired'),
								esc_html__( 'All (NOT expired)', 'course-builder' )  => 'not-expired',
								esc_html__( 'Upcoming', 'course-builder' )  => 'upcoming',
								esc_html__( 'Happening', 'course-builder' ) => 'happening',
								esc_html__( 'Expired', 'course-builder' )   => 'expired',
							),
							'edit_field_class' => 'vc_col-sm-6',
						),
						array(
							'type'             => 'number',
							'admin_label'      => true,
							'heading'          => esc_html__( 'Number of events', 'course-builder' ),
							'param_name'       => 'number_events',
							'edit_field_class' => 'vc_col-sm-6',
							'description'      => esc_html__( 'Choose number of events to show', 'course-builder' ),
							'value'            => '1',
						),
						array(
							'type'             => 'dropdown',
							'admin_label'      => true,
							'heading'          => esc_html__( 'Order by', 'course-builder' ),
							'param_name'       => 'orderby',
							'value'            => array(
								esc_html__( 'Popular', 'course-builder' )  => 'popular',
								esc_html__( 'Recent', 'course-builder' )  => 'recent',
								esc_html__( 'Title', 'course-builder' ) => 'title',
								esc_html__( 'Random', 'course-builder' )   => 'random',
								esc_html__( 'Time', 'course-builder' )   => 'time',
							),
							'edit_field_class' => 'vc_col-sm-6',
						),
						array(
							'type'             => 'dropdown',
							'admin_label'      => true,
							'heading'          => esc_html__( 'Order', 'course-builder' ),
							'param_name'       => 'order',
							'value'            => array(
								esc_html__( 'ASC', 'course-builder' )  => 'asc',
								esc_html__( 'DESC', 'course-builder' )  => 'desc',
							),
							'std'         => 'desc',
							'edit_field_class' => 'vc_col-sm-6',
						),
						array(
							"type"       => "radio_image",
							"heading"    => esc_attr__( "Layout", 'course-builder' ),
							"param_name" => "layer_events",
							"options"    => array(
								'event-1' => THIM_CB_URL . $this->base . '/assets/images/layouts/event-1.png',
								'event-2' => THIM_CB_URL . $this->base . '/assets/images/layouts/event-2.png',
								'event-3' => THIM_CB_URL . $this->base . '/assets/images/layouts/event-3.png',
								'event-4' => THIM_CB_URL . $this->base . '/assets/images/layouts/event-4.png',
							),
						),
						array(
							'type'        => 'textfield',
							'admin_label' => true,
							'heading'     => esc_attr__( 'Extra class name', 'course-builder' ),
							'param_name'  => 'el_class',
							'value'       => '',
							'description' => esc_attr__( 'Add extra class name for Thim Events shortcode to use in CSS customizations.', 'course-builder' ),
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
				'cat_events'    => 0,
				'status_events' => 'upcoming',
				'number_events' => '1',
				'layer_events'  => 'event-1',
				'image_events'  => '',
				'orderby'       => '',
				'order'         => 'desc',
				'el_class'      => '',

			), $atts );

			$params['base'] = $this->base;

			$number_events = ! empty( $params['number_events'] ) ? $params['number_events'] : 1;

			$args          = array(
				'post_type'      => 'tp_event',
				'posts_per_page' => $params['number_events'],
				'order'          => $params['order'] == 'asc' ? 'asc' : 'desc',
			);
			switch ( $params['status_events'] ) {
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
							'value'   => array('upcoming','happening'),
							'compare' => 'IN',
						),
					);
					break;
				default:
					$args['meta_query'] = array(
						array(
							'key'     => 'tp_event_status',
							'value'   => array('upcoming','happening','expired'),
							'compare' => 'IN',
						),
					);
			}


			switch ( $params['orderby'] ) {
				case 'time' :
					$args['orderby']  = 'meta_value';
					$args['meta_key'] = 'tp_event_date_end';
					break;
				case 'recent' :
					$params['orderby'] = 'post_date';
					break;
				case 'title' :
					$params['orderby'] = 'post_title';
					break;
				case 'popular' :
					$params['orderby'] = 'comment_count';
					break;
				default : //random
					$params['orderby'] = 'rand';
			}


			if ( $params['cat_events'] ) {
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'tp_event_category',
						'field'    => 'slug',
						'terms'    => array( $params['cat_events'] ),
					),
				);
			}

			$events = new WP_Query( $args );

			$params['query'] = $events;

			ob_start();
			thim_get_template( $params['layer_events'], array( 'params' => $params ), $this->base . '/tpl/' );

			$html = ob_get_contents();
			ob_end_clean();
			wp_reset_postdata();

			return $html;
		}

		/*
		 * Get categories of LearnPress ( has count > 0 )
		 * */
        // Get list category
        public function thim_get_event_categories($cats = false)
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
                'tp_event_category', 0
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

	new Thim_SC_Events();
}