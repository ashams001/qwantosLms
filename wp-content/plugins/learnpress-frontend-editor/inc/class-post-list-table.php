<?php

/**
 * Class LP_Frontend_Editor_Post_List_Table
 */
class LP_Frontend_Editor_Post_List_Table extends WP_Posts_List_Table {

	/**
	 * @var LP_Frontend_Editor_Post_List_Table
	 */
	protected static $instance = null;

	protected $baseUrl = '';

	/**
	 * LP_Frontend_Editor_Post_List_Table constructor.
	 *
	 * @param array $args
	 */
	public function __construct( $args = array() ) {

		global $frontend_editor;

		$backtrace = debug_backtrace();
		if ( empty( $backtrace[1]['class'] ) || $backtrace[1]['class'] !== __CLASS__ ) {
			die( __( 'You should not locate new instance of this class directly.', 'learnpress-frontend-editor' ) );
		}

		parent::__construct( $args );

		$this->screen->post_type = $frontend_editor->post_manage->get_post_type();

		add_action( 'wp_enqueue_scripts', array( $this, 'assets' ) );
		add_filter( 'post_row_actions', array( $this, '_row_actions' ), 10, 2 );
		add_filter( 'page_row_actions', array( $this, '_row_actions' ), 10, 2 );
	}

	/**
	 * Assets
	 */
	public function assets() {
		wp_enqueue_style( 'list-table', get_site_url() . '/wp-admin/css/list-tables.css' );
		wp_enqueue_style( 'list-table', get_site_url() . '/wp-admin/css/common.css' );
		wp_enqueue_style( 'list-table', get_site_url() . '/wp-admin/css/dashboard.css' );
	}

	/**
	 * @return array
	 */
	public function get_columns() {
		$columns = parent::get_columns(); // TODO: Change the autogenerated stub

		if ( isset( $columns['taxonomy-question_tag'] ) ) {
			unset( $columns['taxonomy-question_tag'] );
		}

		return $columns;
	}

	public function display_tablenav( $which ) {
		frontend_editor()->get_template( 'list/table-nav-' . $which );

		return '';
	}

	/**
	 * @param string $link
	 * @param int    $post_id
	 * @param string $context
	 *
	 * @return string
	 */
	public function _get_edit_post_link( $link, $post_id, $context ) {
		global $frontend_editor;
		remove_filter( 'get_edit_post_link', array( $this, '_get_edit_post_link' ), 100 );

		return $frontend_editor->post_manage->get_edit_post_link( get_post_type( $post_id ), get_the_ID() );
	}

	/**
	 * @param WP_Post $post
	 */
	public function column_title( $post ) {
		add_filter( 'get_edit_post_link', array( $this, '_get_edit_post_link' ), 100, 3 );
		parent::column_title( $post ); // TODO: Change the autogenerated stub
	}

	/**
	 * @param array  $args
	 * @param string $label
	 * @param string $class
	 *
	 * @return string
	 */
	protected function get_edit_link( $args, $label, $class = '' ) {
		global $frontend_editor;

		return parent::get_edit_link( $args, $label, $class );
	}

	protected function get_table_classes() {
		return array_merge( array( 'e-post-list-table' ), array() );
	}

	public function _row_actions( $actions, $post ) {
		if ( ! empty( $actions['inline hide-if-no-js'] ) ) {
			unset( $actions['inline hide-if-no-js'] );
		}

		if ( ! empty( $actions['lp-duplicate-row-action'] ) ) {
			unset( $actions['lp-duplicate-row-action'] );
		}

		return $actions;
	}

	public function get_pagenum() {
		/**
		 * @var WP_Query $wp_query
		 */
		global $e_wp_query;

		return $e_wp_query->query_vars['paged'];
	}

	/**
	 * Wrap function that output the pagination of list posts
	 * and replace some link with our rules.
	 *
	 * @param string $which
	 */
	public function page_nav( $which = 'top' ) {
		/**
		 * @var WP_Query $wp_query
		 */
		global $e_wp_query;

		$this->baseUrl = frontend_editor()->post_manage->get_post_type_link( $e_wp_query->get( 'post_type' ) );
		$pagenum       = $this->get_pagenum();

		$this->_pagination_args['total_items'] = $e_wp_query->found_posts;
		$this->_pagination_args['total_pages'] = $e_wp_query->max_num_pages;
		ob_start();

		add_filter( 'set_url_scheme', array( $this, 'filter_set_url_scheme' ), - 1, 3 );
		$this->pagination( $which );
		remove_filter( 'set_url_scheme', array( $this, 'filter_set_url_scheme' ), - 1 );

		$output = ob_get_clean();

//		print_r( $output );
//
//		if ( preg_match( '~href=\'(.*)\'~iSU', $output, $mmm ) ) {
//			foreach ( $mmm as $k => $hrefs ) {
//				$href = html_entity_decode( $hrefs[1] );
//				$x    = explode( '?', $href );
//
//				print_r($hrefs);
//				echo $href;
//				if ( ! empty( $x[1] ) ) {
//					if ( preg_match( '~(\?|&)paged=([0-9]+)~', $x[1], $nnn ) ) {
//						print_r( $nnn );
//					}
//				}
//			}
//		}
//		print_r( $mmm );
//		print_r( $mmm );

		if ( preg_match_all( '~(/page/([0-9]+)/)?/?\?paged=([0-9]+)~', $output, $matches ) ) {
			$output = preg_replace( '~/page/([0-9]+)/?\'~', '/\'', $output );


			foreach ( $matches[0] as $k => $v ) {
				if ( $matches[3][ $k ] > 1 ) {
					$replace = '/page/' . $matches[3][ $k ] . '/';
					$output  = str_replace( $v, $replace, $output );
				} else {
					$output = str_replace( $v, '/', $output );
				}
			}
		}
		echo $output;

		//die();
	}

public
function filter_set_url_scheme( $url, $scheme, $orig_scheme ) {
	global $frontend_editor;

	$x = explode( '?', $url );

	return $this->baseUrl . ( ! empty( $x[1] ) ? '?' . $x[1] : '' );

}

public
function displayx() {
	global $e_wp_query, $wp_query;

	$x        = $wp_query;
	$wp_query = $e_wp_query;
	parent::display(); // TODO: Change the autogenerated stub

	$wp_query = $x;
}

/**
 * @return LP_Frontend_Editor_Post_List_Table
 */
public
static function instance() {
	if ( ! self::$instance ) {
		self::$instance = new self();
	}

	return self::$instance;
}
}