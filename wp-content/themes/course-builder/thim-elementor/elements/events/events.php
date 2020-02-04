<?php

namespace Elementor;

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Event_Element extends Widget_Base {

	public function get_name() {
		return 'thim-event';
	}

	public function get_title() {
		return esc_html__( 'Thim: Events', 'course-builder' );
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

	public function thim_get_event_categories( $cats = false ) {
		global $wpdb;
		$query = $wpdb->get_results( $wpdb->prepare(
			"
				  SELECT      t1.term_id, t2.name
				  FROM        $wpdb->term_taxonomy AS t1
				  INNER JOIN $wpdb->terms AS t2 ON t1.term_id = t2.term_id
				  WHERE t1.taxonomy = %s
				  AND t1.count > %d
				  ",
			'tp_event_category', 0
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

		wp_register_script( 'thim-events', THIM_URI . 'thim-elementor/elements/' . $this->get_base() . '/assets/js/events-custom.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'thim-events' );

		$this->start_controls_section(
			'event_settings',
			[
				'label' => esc_html__( 'Event Settings', 'course-builder' )
			]
		);

		$this->add_control(
			'cat_events',
			[
				'label'    => esc_html__( 'Select Category', 'course-builder' ),
				'type'     => Controls_Manager::SELECT2,
				'multiple' => false,
				'options'  => $this->thim_get_event_categories(),
				'default'  => '0',
			]
		);

		$this->add_control(
			'status_events',
			[
				'label'   => esc_html__( 'Show event by', 'course-builder' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'all'         => esc_html__( 'All', 'course-builder' ),
					'not-expired' => esc_html__( 'All (NOT expired)', 'course-builder' ),
					'upcoming'    => esc_html__( 'Upcoming', 'course-builder' ),
					'happening'   => esc_html__( 'Happening', 'course-builder' ),
					'expired'     => esc_html__( 'Expired', 'course-builder' ),
				],
				'default' => 'all',
			]
		);

		$this->add_control(
			'number_events',
			[
				'label'   => esc_html__( 'Number of events', 'course-builder' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => '1',
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'   => esc_html__( 'Order by', 'course-builder' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'popular' => esc_html__( 'Popular', 'course-builder' ),
					'recent'  => esc_html__( 'Recent', 'course-builder' ),
					'title'   => esc_html__( 'Title', 'course-builder' ),
					'random'  => esc_html__( 'Random', 'course-builder' ),
					'time'    => esc_html__( 'Time', 'course-builder' ),
				],
				'default' => 'popular',
			]
		);

		$this->add_control(
			'order',
			[
				'label'   => esc_html__( 'Order', 'course-builder' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'asc'  => esc_html__( 'ASC', 'course-builder' ),
					'desc' => esc_html__( 'DESC', 'course-builder' ),
				],
				'default' => 'desc',
			]
		);

		$this->add_control(
			'layer_events',
			[
				'label'   => __( 'Layout', 'course-builder' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'event-1' => [
						'title' => '<img src="' . THIM_URI . 'thim-elementor/elements/' . $this->get_base() . '/assets/images/layouts/event-1.png' . '">',
						'icon'  => 'bp_el_class'
					],
					'event-2' => [
						'title' => '<img src="' . THIM_URI . 'thim-elementor/elements/' . $this->get_base() . '/assets/images/layouts/event-2.png' . '">',
						'icon'  => 'bp_el_class'
					],
					'event-3' => [
						'title' => '<img src="' . THIM_URI . 'thim-elementor/elements/' . $this->get_base() . '/assets/images/layouts/event-3.png' . '">',
						'icon'  => 'bp_el_class'
					],
					'event-4' => [
						'title' => '<img src="' . THIM_URI . 'thim-elementor/elements/' . $this->get_base() . '/assets/images/layouts/event-4.png' . '">',
						'icon'  => 'bp_el_class'
					],
				],
				'default' => 'event-1',
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
		thim_get_elementor_template( $this->get_base(), array( 'setting' => $settings ), $settings['layer_events'] );
	}

}

Plugin::instance()->widgets_manager->register_widget_type( new Thim_Event_Element() );