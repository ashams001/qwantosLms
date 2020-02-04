<?php
/**
 * Section Custom CSS
 * 
 * @package Course_Builder
 */

thim_customizer()->add_section(
	array(
		'id'       => 'box_custom_css',
		'panel'    => 'general',
		'title'    => esc_html__( 'Custom CSS', 'course-builder' ),
		'priority' => 99,
	)
);

thim_customizer()->add_field( array(
	'type'        => 'code',
	'id'          => 'thim_custom_css',
	'label'       => esc_html__( 'Custom CSS', 'course-builder' ),
	'description' => esc_html__( 'Just want to do some quick CSS changes? Enter theme here, they will be applied to the theme.', 'course-builder' ),
	'section'     => 'box_custom_css',
	'default'     => '.test-class{ color: red; }',
	'priority'    => 10,
	'choices'     => array(
		'language' => 'css',
		'theme'    => 'monokai',
		'height'   => 250,
	),
	'transport'   => 'postMessage',
	'js_vars'     => array()
) );