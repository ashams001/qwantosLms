<?php

function thim_child_enqueue_styles() {

    if ( is_multisite() ) {
        wp_enqueue_style( 'thim-child-style', get_stylesheet_uri(), array('fontawesome','bootstrap','ionicons','magnific-popup','owl-carousel') );
    } else {
        wp_enqueue_style( 'thim-parent-style', get_template_directory_uri() . '/style.css', array('fontawesome','bootstrap','ionicons','magnific-popup','owl-carousel') );
    }
}

add_action( 'wp_enqueue_scripts', 'thim_child_enqueue_styles', 1000 );