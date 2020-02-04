<?php

namespace Elementor;

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_New_Video_Element extends Widget_Base {

	public function get_name() {
		return 'thim-new-video';
	}

	public function get_title() {
		return esc_html__( 'Thim: Video Simple', 'course-builder' );
	}

	public function get_icon() {
		return 'thim-widget-icon thim-widget-icon-sc-button';
	}

	public function get_categories() {
		return [ 'thim-elements' ];
	}

	public function get_base() {
		return basename( __FILE__, '.php' );
	}

	protected function _register_controls() {

		wp_register_script( 'thim-sc-new-video-box', THIM_URI . 'thim-elementor/elements/' . $this->get_base() . '/assets/js/video-box-custom.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'thim-sc-new-video-box' );

		$this->start_controls_section(
			'video_simple_settings',
			[
				'label' => esc_html__( 'Video Simple Settings', 'course-builder' )
			]
		);

		$this->add_control(
			'upload_image',
			[
				'label'   => esc_html__( 'Video Background', 'course-builder' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'background_image_1',
			[
				'label'   => esc_html__( 'Background right', 'course-builder' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'background_image_2',
			[
				'label'   => esc_html__( 'Background left', 'course-builder' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'link_video',
			[
				'label'       => esc_html__( 'Video Link', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Support Youtube and Vimeo format', 'course-builder' ),
				'default'     => ''
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

Plugin::instance()->widgets_manager->register_widget_type( new Thim_New_Video_Element() );