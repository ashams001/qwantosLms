<?php

namespace Elementor;

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Courses_Magamenu_Element extends Widget_Base {

	public function get_name() {
		return 'thim-courses-megamenu';
	}

	public function get_title() {
		return esc_html__( 'Thim: Courses - MegaMenu', 'course-builder' );
	}

	public function get_icon() {
		return 'thim-widget-icon thim-widget-icon-course-megamenu';
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

		$this->start_controls_section(
			'courses_megamenu_settings',
			[
				'label' => esc_html__( 'Courses Megamenu Settings', 'course-builder' )
			]
		);

		$this->add_control(
			'cols',
			[
				'label'   => esc_html__( 'Number of columns', 'course-builder' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'1' => esc_html__( '1', 'course-builder' ),
					'2' => esc_html__( '2', 'course-builder' ),
					'3' => esc_html__( '3', 'course-builder' ),
					'4' => esc_html__( '4', 'course-builder' ),
				],
				'default' => '1',
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
			'course_featured',
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

Plugin::instance()->widgets_manager->register_widget_type( new Thim_Courses_Magamenu_Element() );