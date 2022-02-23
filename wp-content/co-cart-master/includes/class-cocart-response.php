<?php
/**
 * Handles the REST API response even if it returns an error.
 *
 * @author   Sébastien Dumont
 * @category Classes
 * @package  CoCart\Classes
 * @since    3.0.0
 * @license  GPL-2.0+
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'CoCart_Response' ) ) {

	class CoCart_Response {

		/**
		 * Returns either the default response of the API requested or a filtered response.
		 *
		 * @throws CoCart_Data_Exception Exception if invalid data is detected.
		 *
		 * @access public
		 * @param  mixed  $response  - The original response of the API requested.
		 * @param  string $namespace - The namespace of the API requested.
		 * @param  string $rest_base - The rest base of the API requested.
		 * @return WP_REST_Response  - The returned response.
		 */
		public static function get_response( $response, $namespace = '', $rest_base = '' ) {
			if ( empty( $rest_base ) ) {
				$rest_base = 'cart';
			}

			$rest_base = str_replace( '-', '_', $rest_base );

			try {
				/**
				 * The response can only return empty based on a few things.
				 *
				 * 1. Something seriously has gone wrong server side and no response could be provided.
				 * 2. The response returned nothing because the cart is empty.
				 * 3. The developer filtered the response incorrectly and returned nothing.
				 */
				if ( $rest_base !== 'cart' && $rest_base !== 'session' && empty( $response ) ) {
					/* translators: %s: REST API URL */
					throw new CoCart_Data_Exception( 'cocart_response_returned_empty', sprintf( __( 'Request returned nothing for "%s"! Please seek assistance.', 'cart-rest-api-for-woocommerce' ), rest_url( sprintf( '/%s/%s/', $namespace, $rest_base ) ) ) );
				}

				// Set as true by default until store is ready to go to production.
				$default_response = apply_filters( 'cocart_return_default_response', true );

				if ( ! $default_response ) {
					// This filter can be used as a final straw for changing the response to what ever needs.
					$response = apply_filters( 'cocart_' . $rest_base . '_response', $response );
				}

				return new WP_REST_Response( $response, 200 );
			} catch ( \CoCart_Data_Exception $e ) {
				$response = self::get_error_response( $e->getErrorCode(), $e->getMessage(), $e->getCode(), $e->getAdditionalData() );
			} catch ( \Exception $e ) {
				$response = self::get_error_response( 'cocart_unknown_server_error', $e->getMessage(), 500 );
			}

			if ( is_wp_error( $response ) ) {
				$response = self::error_to_response( $response );
			}

			return $response;
		} // END get_response()

		/**
		 * Converts an error to a response object. Based on \WP_REST_Server.
		 *
		 * @access public
		 * @static
		 * @param  WP_Error $error WP_Error instance.
		 * @return WP_REST_Response List of associative arrays with code and message keys.
		 */
		public static function error_to_response( $error ) {
			$error_data = $error->get_error_data();
			$status     = isset( $error_data, $error_data['status'] ) ? $error_data['status'] : 500;
			$errors     = array();

			foreach ( (array) $error->errors as $code => $messages ) {
				foreach ( (array) $messages as $message ) {
					$errors[] = array(
						'code'    => $code,
						'message' => $message,
						'data'    => $error->get_error_data( $code ),
					);
				}
			}

			$data = array_shift( $errors );

			if ( count( $errors ) ) {
				$data['additional_errors'] = $errors;
			}

			return new \WP_REST_Response( $data, $status );
		} // END error_to_response()

		/**
		 * Get route response when something went wrong.
		 *
		 * @access public
		 * @static
		 * @param  string $error_code String based error code.
		 * @param  string $error_message User facing error message.
		 * @param  int    $http_status_code HTTP status. Defaults to 500.
		 * @param  array  $additional_data  Extra data (key value pairs) to expose in the error response.
		 * @return \WP_Error WP Error object.
		 */
		public static function get_error_response( $error_code, $error_message, $http_status_code = 500, $additional_data = array() ) {
			return new \WP_Error( $error_code, $error_message, array_merge( $additional_data, array( 'status' => $http_status_code ) ) );
		}

	} // END class

} // END if class exists
