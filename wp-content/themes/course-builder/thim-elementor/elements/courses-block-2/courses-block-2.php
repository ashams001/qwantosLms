<?php

namespace Elementor;

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Courses_Block_2_Element extends Widget_Base {

	public function get_name() {
		return 'thim-courses-block-2';
	}

	public function get_title() {
		return esc_html__( 'Thim: Courses - Block 2', 'course-builder' );
	}

	public function get_icon() {
		return 'thim-widget-icon thim-widget-icon-sc-courses-block-2';
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
			'courses_block_2_settings',
			[
				'label' => esc_html__( 'Courses Block 2 Settings', 'course-builder' )
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Course Block Title', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Course Block Title', 'course-builder' ),
				'default'     => 'Our Top Courses'
			]
		);

		$this->add_control(
			'description',
			[
				'label'       => esc_html__( 'Course Block Description', 'course-builder' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Customize your online school with an intuitive user interface. Design your homepage and lectures.', 'course-builder' ),
				'default'     => ''
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'       => esc_html__( 'Button text', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Button text', 'course-builder' ),
				'default'     => 'View all courses'
			]
		);

		$this->add_control(
			'button_link',
			[
				'label'         => __( 'Button Link', 'course-builder' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => __( 'https://your-link.com', 'course-builder' ),
				'show_external' => false,
				'default'       => [
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				],
			]
		);

		$this->add_control(
			'number_courses',
			[
				'label'   => esc_html__( 'Number of visible courses', 'course-builder' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => '7',
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

Plugin::instance()->widgets_manager->register_widget_type( new Thim_Courses_Block_2_Element() );