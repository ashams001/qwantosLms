<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists( 'Thim_SC_New_Posts' ) ) {

	class Thim_SC_New_Posts {

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
			$this->name        = esc_attr__( 'Thim: New Posts', 'course-builder' );
			$this->description = esc_attr__( 'Display a post list.', 'course-builder' );
			$this->base        = 'new-post';
			//====================== END: CONFIG =====================


			$this->map();
			add_shortcode( 'thim-' . $this->base, array( $this, 'shortcode' ) );
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
							"type"       => "dropdown",
							"heading"    => esc_attr__( "Layout", 'course-builder' ),
							"param_name" => "layout",
							"value"      => array(
								esc_attr__( "Layout 1", 'course-builder' )           => "layout-1",
								esc_attr__( "Layout 2", 'course-builder' )           => "layout-2",
								esc_attr__( "Layout Kit Builder", 'course-builder' ) => "layout-kit"
							),
						),

						array(
							'type'             => 'dropdown',
							'heading'          => esc_html__( 'Select post category', 'course-builder' ),
							'param_name'       => 'cat_post',
							'admin_label'      => true,
							'value'            => $this->thim_get_post_categories(),
							'edit_field_class' => 'vc_col-sm-6',
							"dependency"       => array(
								"element" => "layout",
								"value"   => array( "layout-2", "layout-kit" )
							)
						),

						array(
							'type'             => 'number',
							'admin_label'      => true,
							'heading'          => esc_html__( 'Number of posts', 'course-builder' ),
							'param_name'       => 'number_post',
							'edit_field_class' => 'vc_col-sm-12',
							'description'      => esc_html__( 'Choose number of posts to show', 'course-builder' ),
							'value'            => '1',
							"dependency"       => array(
								"element" => "layout",
								"value"   => array( "layout-2", "layout-kit" )
							)
						),

						array(
							'type'        => 'textfield',
							'admin_label' => true,
							'heading'     => esc_attr__( 'ID post', 'course-builder' ),
							'param_name'  => 'id_post',
							'value'       => '',
							'description' => esc_attr__( 'id post ex: 123 ...', 'course-builder' ),
							"dependency"  => array(
								"element" => "layout",
								"value"   => array( "layout-1" )
							)
						),

						array(
							"type"       => "dropdown",
							"heading"    => esc_attr__( "Image Align", 'course-builder' ),
							"param_name" => "featured_align",
							"value"      => array(
								esc_attr__( "Image Left", 'course-builder' )  => "layout-left",
								esc_attr__( "Image Right", 'course-builder' ) => "layout-right"
							),
							"dependency" => array(
								"element" => "layout",
								"value"   => array( "layout-1" )
							)
						),

						array(
							"type"       => "dropdown",
							"heading"    => esc_attr__( "Columns", 'course-builder' ),
							"param_name" => "column",
							"value"      => array(
								esc_attr__( "2", 'course-builder' ) => "2",
								esc_attr__( "3", 'course-builder' ) => "3",
								esc_attr__( "4", 'course-builder' ) => "4",
								esc_attr__( "5", 'course-builder' ) => "5"
							),
							"dependency" => array(
								"element" => "layout",
								"value"   => array( "layout-2", "layout-kit" )
							)
						),

						array(
							"type"        => "attach_image",
							"heading"     => esc_attr__( "Upload Icon Image", 'course-builder' ),
							"param_name"  => "icon_upload",
							"admin_label" => true,
							"description" => esc_attr__( "Select an image to upload", 'course-builder' ),
							"dependency"  => array(
								"element" => "layout",
								"value"   => array( "layout-1" )
							)
						),

						array(
							'type'        => 'textfield',
							'admin_label' => true,
							'heading'     => esc_attr__( 'Text button view more', 'course-builder' ),
							'param_name'  => 'text_button',
							'value'       => 'View more',
							'description' => esc_attr__( 'Text button view more for Thim New Posts.', 'course-builder' ),
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
				'cat_post'       => 0,
				'number_post'    => '1',
				'layout'         => 'layout-1',
				'icon_upload'    => '',
				'featured_align' => 'layout-left',
				'column'         => '3',
				'text_button'    => 'View more',
				'id_post'        => '',
				'el_class'       => '',

			), $atts );

			$params['base'] = $this->base;

			$number_posts = !empty( $params['number_post'] ) ? $params['number_post'] : 1;

			if ( $params['layout'] == 'layout-1' ) {
				$args = array(
					'post_type'      => 'post',
					'p'              => $params['id_post'],
					'posts_per_page' => 1,
				);
			} else {
				$args = array(
					'post_type'      => 'post',
					'posts_per_page' => $number_posts,
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
			}

			$posts = new WP_Query( $args );

			$params['query'] = $posts;

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
		public function thim_get_post_categories( $cats = false ) {
			global $wpdb;
			$query = $wpdb->get_results( $wpdb->prepare(
				"
				  SELECT      t1.term_id, t2.name
				  FROM        $wpdb->term_taxonomy AS t1
				  INNER JOIN $wpdb->terms AS t2 ON t1.term_id = t2.term_id
				  WHERE t1.taxonomy = %s
				  AND t1.count > %d
				  ",
				'category', 0
			) );

			if ( empty( $cats ) ) {
				$cats = array();
			}

			$cats[esc_attr__( 'All', 'course-builder' )] = 0;

			if ( !empty( $query ) ) {
				foreach ( $query as $key => $value ) {
					$cats[$value->term_id] = $value->name;
				}
			}

			return $cats;

		}
	}

	new Thim_SC_New_Posts();
}