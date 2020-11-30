<?php
    add_action( 'wp_ajax_plugin_task_get_json', 'pt_get_json' );

    /**
	 * Get json data.
	 *
	 * @since 0.1.0
	 *
	 * @return void
	 */
	function pt_get_json() {
		$data = pt_validate();

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
	function pt_validate() {
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