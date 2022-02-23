<?php
/**
 * CoCart API
 *
 * Handles CoCart endpoint requests for CoCart API.
 *
 * @author   Sébastien Dumont
 * @category API
 * @package  CoCart\Classes
 * @since    1.0.0
 * @version  3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * CoCart API class.
 */
class CoCart_API {

	/**
	 * Setup class.
	 *
	 * @access  public
	 * @since   1.0.0
	 * @version 3.0.0
	 */
	public function __construct() {
		// Add query vars.
		add_filter( 'query_vars', array( $this, 'add_query_vars' ), 0 );

		// Register API endpoint.
		add_action( 'init', array( $this, 'add_endpoint' ), 0 );

		// Handle cocart endpoint requests.
		add_action( 'parse_request', array( $this, 'handle_api_requests' ), 0 );
	} // END __construct()

	/**
	 * Add new query vars.
	 *
	 * @access public
	 * @since  2.0.0
	 * @param  array $vars Query vars.
	 * @return string[]
	 */
	public function add_query_vars( $vars ) {
		$vars[] = 'cocart';

		return $vars;
	} // END add_query_vars()

	/**
	 * Add rewrite endpoint.
	 *
	 * @access public
	 * @static
	 * @since  2.0.0
	 */
	public static function add_endpoint() {
		add_rewrite_endpoint( 'cocart', EP_ALL );
	} // END add_endpoint()

	/**
	 * API request - Trigger any API requests.
	 *
	 * @access public
	 * @since  2.0.0
	 * @global $wp
	 */
	public function handle_api_requests() {
		global $wp;

		if ( ! empty( $_GET['cocart'] ) ) {
			$wp->query_vars['cocart'] = sanitize_key( wp_unslash( $_GET['cocart'] ) );
		}

		// CoCart endpoint requests.
		if ( ! empty( $wp->query_vars['cocart'] ) ) {

			// Buffer, we won't want any output here.
			ob_start();

			// No cache headers.
			wc_nocache_headers();

			// Clean the API request.
			$api_request = strtolower( wc_clean( $wp->query_vars['cocart'] ) );

			// Trigger generic action before request hook.
			do_action( 'cocart_api_request', $api_request );

			// Is there actually something hooked into this API request? If not trigger 400 - Bad request.
			status_header( has_action( 'cocart_api_' . $api_request ) ? 200 : 400 );

			// Trigger an action which plugins can hook into to fulfill the request.
			do_action( 'cocart_api_' . $api_request );

			// Done, clear buffer and exit.
			ob_end_clean();
			die( '-1' );
		}
	} // END handle_api_requests()

} // END class

return new CoCart_API();
