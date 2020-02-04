<?php

namespace Elementor;

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Posts_Element extends Widget_Base {

	public function get_name() {
		return 'thim-posts';
	}

	public function get_title() {
		return esc_html__( 'Thim: Posts Gallery', 'course-builder' );
	}

	public function get_icon() {
		return 'thim-widget-icon thim-widget-icon-sc-events';
	}

	public function get_categories() {
		return [ 'thim-elements' ];
	}

	public function get_base() {
		return basename( __FILE__, '.php' );
	}

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

		$cats[0] = esc_attr__( 'All', 'course-builder' );

		if ( !empty( $query ) ) {
			foreach ( $query as $key => $value ) {
				$cats[$value->term_id] = $value->name;
			}
		}

		return $cats;

	}

	protected function _register_controls() {

		wp_register_script( 'thim-posts', THIM_URI . 'thim-elementor/elements/' . $this->get_base() . '/assets/js/post-custom.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'thim-posts' );


		$this->start_controls_section(
			'posts_settings',
			[
				'label' => esc_html__( 'Posts Gallery Settings', 'course-builder' )
			]
		);

		$this->add_control(
			'cat_post',
			[
				'label'    => esc_html__( 'Select Category', 'course-builder' ),
				'type'     => Controls_Manager::SELECT2,
				'multiple' => false,
				'options'  => $this->thim_get_post_categories(),
				'default'  => '0',
			]
		);

		$this->add_control(
			'number_post',
			[
				'label'   => esc_html__( 'Number of posts', 'course-builder' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => '3',
			]
		);

		$this->add_control(
			'layer_events',
			[
				'label'   => __( 'Layout', 'course-builder' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'default' => [
						'title' => '<img src="' . THIM_URI . 'thim-elementor/elements/' . $this->get_base() . '/assets/images/layouts/layout.png' . '">',
						'icon'  => 'bp_el_class'
					],
				],
				'default' => 'default',
				'toggle'  => false,
			]
		);

		$this->add_control(
			'el_class',
			[
				'label'       => esc_html__( 'Extra Class', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Extra Class', 'course-builder' ),
				'default'     => ''
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		thim_get_elementor_template( $this->get_base(), array( 'params' => $settings ) );
	}

}

Plugin::instance()->widgets_manager->register_widget_type( new Thim_Posts_Element() );