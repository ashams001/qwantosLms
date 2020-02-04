<?php

namespace Elementor;

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Courses_Block_1_Element extends Widget_Base {

	public function get_name() {
		return 'thim-courses-block-1';
	}

	public function get_title() {
		return esc_html__( 'Thim: Courses - Block 1', 'course-builder' );
	}

	public function get_icon() {
		return 'thim-widget-icon thim-widget-icon-sc-courses-block-1';
	}

	public function get_categories() {
		return [ 'thim-elements' ];
	}

	public function get_base() {
		return basename( __FILE__, '.php' );
	}

	// Get list category
	public function thim_get_course_categories( $cats = false ) {
		global $wpdb;
		$query = $wpdb->get_results( $wpdb->prepare(
			"
				  SELECT      t1.term_id, t2.name
				  FROM        $wpdb->term_taxonomy AS t1
				  INNER JOIN $wpdb->terms AS t2 ON t1.term_id = t2.term_id
				  WHERE t1.taxonomy = %s
				  AND t1.count > %d
				  ",
			'course_category', 0
		) );

		if ( empty( $cats ) ) {
			$cats = array();
		}

		$cats[0] = esc_html__( 'All', 'course-builder' );

		if ( !empty( $query ) ) {
			foreach ( $query as $key => $value ) {
				$cats[$value->term_id] = $value->name;
			}
		}

		return $cats;

	}

	protected function _register_controls() {

		wp_register_script( 'thim-jquery-popup', THIM_URI . 'thim-elementor/elements/' . $this->get_base() . '/assets/js/jquery.magnific-popup.min.js', array( 'jquery' ), '', true );
		wp_register_script( 'thim-courses-block-1', THIM_URI . 'thim-elementor/elements/' . $this->get_base() . '/assets/js/courses-block-1-custom.js', array( 'jquery', 'thim-jquery-popup' ), '', true );
		wp_enqueue_script( 'thim-courses-block-1' );

		$this->start_controls_section(
			'courses_block_1_settings',
			[
				'label' => esc_html__( 'Courses Block 1 Settings', 'course-builder' )
			]
		);

		$this->add_control(
			'list_courses',
			[
				'label'   => esc_html__( 'Show courses by', 'course-builder' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'latest'   => esc_html__( 'Latest', 'course-builder' ),
					'popular'  => esc_html__( 'Popular', 'course-builder' ),
					'category' => esc_html__( 'Category', 'course-builder' ),
				],
				'default' => 'latest',
			]
		);

		$this->add_control(
			'cat_courses',
			[
				'label'     => esc_html__( 'Select Category', 'course-builder' ),
				'type'      => Controls_Manager::SELECT2,
				'multiple'  => false,
				'options'   => $this->thim_get_course_categories(),
				'default'   => '0',
				'condition' => [
					'list_courses' => [ 'category' ]
				]
			]
		);

		$this->add_control(
			'featured_courses',
			[
				'label'   => esc_html__( 'Show Featured Courses?', 'course-builder' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		thim_get_elementor_template( $this->get_base(), array( 'setting' => $settings ) );
	}

}

Plugin::instance()->widgets_manager->register_widget_type( new Thim_Courses_Block_1_Element() );