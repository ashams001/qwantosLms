<?php

namespace Elementor;

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Google_Map_Element extends Widget_Base {

	public function get_name() {
		return 'thim-google-map';
	}

	public function get_title() {
		return esc_html__( 'Thim: Google Map', 'course-builder' );
	}

	public function get_icon() {
		return 'thim-widget-icon thim-widget-icon-sc-google-map';
	}

	public function get_categories() {
		return [ 'thim-elements' ];
	}

	public function get_base() {
		return basename( __FILE__, '.php' );
	}

	protected function _register_controls() {

		wp_register_script( 'thim-google-map', THIM_URI . 'thim-elementor/elements/' . $this->get_base() . '/assets/js/google-map-custom.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'thim-google-map' );

		$this->start_controls_section(
			'google_map_settings',
			[
				'label' => esc_html__( 'Google Map Settings', 'course-builder' )
			]
		);

		$this->add_control(
			'map_center',
			[
				'label'       => esc_html__( 'Map center location', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter a location. It can be a town, city, country or exact address.', 'course-builder' ),
				'default'     => 'Paris'
			]
		);

		$this->add_control(
			'api_key',
			[
				'label'       => esc_html__( 'Google Map API Key', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter Google Map API Key. Get an API Key https://developers.google.com/maps/documentation/javascript/get-api-key#get-an-api-key', 'course-builder' ),
				'default'     => 'AIzaSyDNnrBbNMIqC2x_wTYJNEzHYSrMqQF-YVo'
			]
		);

		$this->add_control(
			'height',
			[
				'label'   => esc_html__( 'Height', 'course-builder' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => '480',
			]
		);

		$this->add_control(
			'zoom',
			[
				'label'   => esc_html__( 'Zoom level', 'course-builder' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => '12',
				'min'     => '0',
				'max'     => '21',
			]
		);

		$this->add_control(
			'marker_at_center',
			[
				'label'   => esc_html__( 'Pinpoint marker', 'course-builder' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'marker_icon',
			[
				'label'   => esc_html__( 'Choose pinpoint marker icon', 'course-builder' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				]
			]
		);

		$this->add_control(
			'scroll_zoom',
			[
				'label'   => esc_html__( 'Scroll to zoom', 'course-builder' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
			]
		);

		$this->add_control(
			'draggable',
			[
				'label'   => esc_html__( 'Draggable', 'course-builder' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
			]
		);

		$this->add_control(
			'map_cover',
			[
				'label'   => esc_html__( 'Preload cover image', 'course-builder' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
			]
		);

		$this->add_control(
			'map_cover_image',
			[
				'label'     => esc_html__( 'Choose preload cover image', 'course-builder' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => array(
					'map_cover' => [ 'yes' ]
				)
			]
		);

		$this->add_control(
			'map_style',
			[
				'label'   => esc_html__( 'Map Style', 'course-builder' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'default' => esc_html__( 'Default', 'course-builder' ),
					'light'   => esc_html__( 'Ultra light with location labels', 'course-builder' )
				],
				'default' => 'default',
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
		thim_get_elementor_template( $this->get_base(), array( 'setting' => $settings ) );
	}

}

Plugin::instance()->widgets_manager->register_widget_type( new Thim_Google_Map_Element() );