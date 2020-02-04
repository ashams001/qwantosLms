<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('Thim_SC_Courses_MegaMenu')) {

    class Thim_SC_Courses_MegaMenu
    {

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


        public function __construct()
        {

            //======================== CONFIG ========================
            $this->name = esc_attr__('Thim: Courses - MegaMenu', 'course-builder');
            $this->description = esc_attr__('Display a courses', 'course-builder');
            $this->base = 'courses-megamenu';
            //====================== END: CONFIG =====================


            $this->map();
            add_shortcode('thim-' . $this->base, array($this, 'shortcode'));

        }

        /**
         * vc map shortcode
         */
        public function map()
        {
            vc_map(array(
                'name' => $this->name,
                'base' => 'thim-' . $this->base,
                'category' => esc_html__('Thim Shortcodes', 'course-builder'),
                'icon' => THIM_CB_URL . $this->base . '/assets/images/icon/course-megamenu.jpg',
                'description' => $this->description,
                'params' => array(

	                array(
		                'type'        => 'dropdown',
		                'heading'     => esc_html__( 'Number of columns:', 'course-builder' ),
		                'param_name'  => 'cols',
		                'admin_label' => true,
		                'value'       => array(
			                esc_html__( '1', 'course-builder' ) => '1',
			                esc_html__( '2', 'course-builder' ) => '2',
			                esc_html__( '3', 'course-builder' ) => '3',
			                esc_html__( '4', 'course-builder' ) => '4',
		                ),
		                'std'         => '1',
	                ),

                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__('Show courses by', 'course-builder'),
                        'param_name' => 'list_courses',
                        'admin_label' => true,
                        'value' => array(
                            esc_html__('Latest', 'course-builder') => 'latest',
                            esc_html__('Popular', 'course-builder') => 'popular',
                            esc_html__('Category', 'course-builder') => 'category',
                        )
                    ),

                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__('Select Category', 'course-builder'),
                        'param_name' => 'cat_courses',
                        'admin_label' => true,
                        'value' => $this->thim_get_course_categories(),
                        "description" => esc_attr__("Select which category if you choose to show courses by category.", 'course-builder'),
                    ),

                    array(
                        'type' => 'checkbox',
                        'heading' => esc_html__('Show Featured Courses?', 'course-builder'),
                        'description' => esc_html__('Check yes to only show the featured courses.', 'course-builder'),
                        'value' => array(
                            esc_html__('Yes', 'course-builder') => esc_attr('yes'),
                        ),
                        'param_name' => 'featured_courses',
                        'admin_label' => true,
                    ),
                ),
            ));
        }

        /**
         * @param $atts
         *
         * @return string
         */
        public function shortcode($atts)
        {
            $params = shortcode_atts(array(
                'cols' => '1',
                'list_courses' => 'latest',
                'cat_courses' => '',
                'featured_courses' => '',
            ), $atts);

            ob_start();
            thim_get_template('default', array('params' => $params), $this->base . '/tpl/');
            $html = ob_get_contents();
            ob_end_clean();

            return $html;

        }

        /*
         * Get categories of LearnPress ( has count > 0 )
         * */
        public function get_categories()
        {

            $categories = get_categories('taxonomy=course_category&type=lp_course');

            $cats = array();
            $cats[esc_attr__('All', 'course-builder')] = 0;


            if (!empty($categories)) {
                foreach ($categories as $key => $value) {
                    $cats[$value->name] = $value->slug;
                }
            }

            return $cats;
        }

        // Get list category
        public function thim_get_course_categories($cats = false)
        {
            global $wpdb;
            $query = $wpdb->get_results($wpdb->prepare(
                "
				  SELECT      t1.term_id, t2.name
				  FROM        $wpdb->term_taxonomy AS t1
				  INNER JOIN $wpdb->terms AS t2 ON t1.term_id = t2.term_id
				  WHERE t1.taxonomy = %s
				  AND t1.count > %d
				  ",
                'course_category', 0
            ));

            if (empty($cats)) {
                $cats = array();
            }

            $cats[esc_attr__('All', 'course-builder')] = 0;

            if ( !empty($query) ) {
                foreach ($query as $key => $value) {
                    $cats[$value->term_id] = $value->name;
                }
            }

            return $cats;

        }
    }

    new Thim_SC_Courses_MegaMenu();
}