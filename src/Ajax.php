<?php
/**
 * Ajax.
 *
 * @package Plugin\Task
 *
 * @since 0.1.0
 */

namespace Plugin\Task;

defined( 'ABSPATH' ) || exit;

/**
 * Aajx class.
 *
 * @class Plugin\Task\Ajax
 */

class Ajax {

	/**
	 * Actions.
	 *
	 * @since 0.1.0
	 *
	 * @var array
	 */
	private $actions = array();


	/**
	 * Constructor.
	 *
	 * @since 0.1.0
	 */
	public function __construct() {
		$this->init();
	}
	/**
	 * Initialize
	 *
	 * @since 0.1.0
	 */
	private function init() {
		$this->init_hooks();
	}

	/**
	 * Initialize hooks.
	 *
	 * @since 0.1.0
	 *
	 * @return void
	 */
	private function init_hooks() {
		$this->actions = apply_filters( 'plugin_task_ajax_actions', array(
			'get_json' => array(
				'priv'   => array( $this, 'get_json' ),
			)
		) );

		foreach ( $this->actions as $key => $action ) {
			foreach ( $action as $type => $callback ) {
				$type = 'priv' === $type ? '' : '_nopriv';
				$slug = PLUGIN_TASK_SLUG;
				add_action( "wp_ajax{$type}_{$slug}_{$key}", $callback );
			}
		}
	}

	/**
	 * Get json data.
	 *
	 * @since 0.1.0
	 *
	 * @return void
	 */
	public function get_json() {
		$data = $this->validate();

		if ( is_wp_error( $data ) ) {
			wp_send_json_error( $data, 400 );
		}

		$response = wp_remote_get( 'https://orbisius.com/apps/qs_cmd/?json', array(
			'timeout' => 120
		) );

		if ( is_wp_error( $response ) ) {
			wp_send_json_error( new \WP_Error(
				'request_error',
				esc_html__( 'Something went wrong. Try again!!!', 'plugin-task' )
			), 400 );
		}

		if ( 200 !== wp_remote_retrieve_response_code( $response ) ) {
			wp_send_json_error( new \WP_Error(
				'response_not_success',
				esc_html__( 'Something went wrong. Try again!!!', 'plugin-task' )
			), 400 );
		}

		$data = wp_remote_retrieve_body( $response );

		wp_send_json_success( $data );
	}

	/**
	 * Validat the request.
	 *
	 * @since 0.1.0
	 *
	 * @return WP_Error|mixed
	 */
	private function validate() {
		if ( false === check_admin_referer( 'plugin-task' ) ) {
			return new \WP_Error(
				'invalid_nonce',
				esc_html__( 'Invalid Nonce' , 'plugin-task' )
			);
		}


		if( ! isset( $_POST['fullname'] ) ) {
			return new \WP_Error(
				'fullname_required',
				esc_html__( 'Fullname is required' , 'plugin-task' )
			);
		}

		$data['fullname'] = sanitize_text_field( $_POST['fullname'] );

		if ( empty( $data['fullname'] ) ) {
			return new \WP_Error(
				'fullname_required',
				esc_html__( 'Fullname is required' , 'plugin-task' )
			);
		}

		return $data;
	}
}
