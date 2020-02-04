<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Thim_SC_Video_Box' ) ) {

	class Thim_SC_Video_Box {

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
			$this->name        = esc_attr__( 'Thim: Video Box', 'course-builder' );
			$this->description = esc_attr__( 'Display a video box.', 'course-builder' );
			$this->base        = 'video-box';
			//====================== END: CONFIG =====================


			$this->map();
			add_action( 'wp_enqueue_scripts', array( $this, 'assets' ) );
			add_action( 'thim_social_share_video', array( $this, 'social_share_video' ) );
			add_shortcode( 'thim-' . $this->base, array( $this, 'shortcode' ) );
		}


		/**
		 * Load assets
		 */
		public function assets() {
			wp_register_script( 'thim-sc-video-box', THIM_CB_URL . $this->base . '/assets/js/video-box-custom.js', array( 'jquery' ), '', true );
			wp_enqueue_script( 'thim-sc-video-box' );
		}

		/**
		 * vc map shortcode
		 */
		public function map() {
			vc_map( array(
					'name'        => $this->name,
					'base'        => 'thim-' . $this->base,
					'category'    => esc_attr__( 'Thim Shortcodes', 'course-builder' ),
					'description' => $this->description,
					'icon'        => THIM_CB_URL . $this->base . '/assets/images/icon/sc-video-box.png',
					'params'      => array(
						array(
							"type"        => "radio_image",
							"heading"     => esc_attr__( "Layout", 'course-builder' ),
							"param_name"  => "layout",
							"options"     => array(
								'layout-1' => THIM_CB_URL . $this->base . '/assets/images/layouts/layout1.jpg',
								'layout-2' => THIM_CB_URL . $this->base . '/assets/images/layouts/layout2.jpg',
								'layout-3' => THIM_CB_URL . $this->base . '/assets/images/layouts/layout3.jpg',
							),
						),

						array(
							"type"        => "attach_image",
							"heading"     => esc_attr__( "Choose video thumbnail image", 'course-builder' ),
							"param_name"  => "upload_image",
							"admin_label" => true,
							"description" => esc_attr__( "Select an image to upload", 'course-builder' ),
							'edit_field_class' => 'vc_col-sm-6',
						),

						array(
							'type'             => 'dropdown',
							'heading'          => esc_html__( 'Choose background image', 'course-builder' ),
							'param_name'       => 'bg_image',
							'edit_field_class' => 'vc_col-sm-6',
							'value'            => array(
								esc_html__( 'Macbook', 'course-builder' ) => '',
								esc_html__( 'iMac', 'course-builder' )   => 'imac',
							),
							'admin_label'      => true,
							'dependency'       => array(
								'element' => 'layout',
								'value'   => array(
									'layout-2'
								),
							),
						),

						array(
							"type"        => "textfield",
							"heading"     => esc_attr__( "Video Link", 'course-builder' ),
							"param_name"  => "link_video",
							"description" => esc_attr__( "Support Youtube and Vimeo format. Add '?rel=0&showinfo=0' to the video URL to turn off related videos", 'course-builder' )
						),
						array(
							"type"        => "textarea_html",
							"heading"     => esc_attr__( "Video content", 'course-builder' ),
							"param_name"  => "content",
							"admin_label" => true,
							'dependency'  => array(
								'element' => 'layout',
								'value'   => array( 'layout-1' ),
							),
						),
						array(
							'type'        => 'checkbox',
							'heading'     => esc_html__( 'Show button to share video', 'course-builder' ),
							'value'       => array(
								esc_html__( 'Yes', 'course-builder' ) => esc_attr( 'yes' ),
							),
							'param_name'  => 'share_link',
							'admin_label' => true,
							'dependency'  => array(
								'element' => 'layout',
								'value'   => array( 'layout-1' ),
							),
						),
						array(
							'type'        => 'textfield',
							'admin_label' => true,
							'heading'     => esc_attr__( 'Extra class name', 'course-builder' ),
							'param_name'  => 'el_class',
							'value'       => '',
							'description' => esc_attr__( 'Add extra class name for Thim Video Box shortcode to use in CSS customizations.', 'course-builder' ),
						),
					),
				)
			);
		}

		/**
		 * Add shortcode
		 *
		 * @param $atts
		 */
		public function shortcode( $atts, $content = null ) {

			$params            = shortcode_atts( array(
				'upload_image' => '',
				'link_video'   => '',
				'bg_image'   => '',
				'share_link'   => '',
				'el_class'     => '',
				'layout'       => 'layout-1',
			), $atts );
			$params['content'] = wpb_js_remove_wpautop( $content, true ); // fix unclosed/unwanted paragraph tags in $content

			ob_start();

			thim_get_template( 'default', array( 'params' => $params ), $this->base . '/tpl/' );

			$html = ob_get_contents();
			ob_end_clean();

			return $html;
		}

		function social_share_video() {
			echo '<span class="label">' . esc_html__( 'Share', 'course-builder' ) . '</span>';
			echo '<ul>';
			global $post;
			$src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
			echo '<li><a class="link facebook" title="' . esc_html__( 'Facebook', 'course-builder' ) . '" href="http://www.facebook.com/sharer/sharer.php?u=' . urlencode( get_permalink() ) . '&amp;media=' . ( ! empty( $src[0] ) ? $src[0] : '' ) . '&description=' . esc_attr( urlencode( get_the_title() ) ) . '" onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>';
			echo '<li><a class="link twitter" title="' . esc_html__( 'Twitter', 'course-builder' ) . '" href="https://twitter.com/intent/tweet?url=' . urlencode( get_permalink() ) . '&amp;text=' . esc_attr( urlencode( get_the_title() ) ) . '" onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>';
			echo '<li><a class="link google" title="' . esc_html__( 'Google', 'course-builder' ) . '" href="https://plus.google.com/share?url=' . esc_url( urlencode( get_permalink() ) ) . '&amp;media=' . ( ! empty( $src[0] ) ? $src[0] : '' ) . '&description=' . esc_attr( urlencode( get_the_title() ) ) . '" onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="ion-social-googleplus" aria-hidden="true"></i></a></li>';
			echo '<li><a class="link pinterest" title="' . esc_html__( 'Pinterest', 'course-builder' ) . '" href="http://pinterest.com/pin/create/button/?url=' . urlencode( get_permalink() ) . '&amp;media=' . ( ! empty( $src[0] ) ? $src[0] : '' ) . '&description=' . esc_attr( urlencode( get_the_title() ) ) . '" onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>';
			echo '</ul>';
		}

	}


	new Thim_SC_Video_Box();
}


