<?php
/**
 * Handles support for Third Party.
 *
 * @author   Sébastien Dumont
 * @category Classes
 * @package  CoCart\Third Party
 * @since    2.8.1
 * @version  3.0.0
 * @license  GPL-2.0+
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'CoCart_Third_Party' ) ) {

	class CoCart_Third_Party {

		/**
		 * Constructor.
		 *
		 * @access public
		 */
		public function __construct() {
			self::include_hosts();
			self::include_plugins();
		}

		/**
		 * Load support for third-party hosts.
		 *
		 * @access public
		 * @return string
		 */
		public function include_hosts() {
			include_once COCART_ABSPATH . 'includes/third-party/hosting/pantheon/class-cocart-host-pantheon.php'; // Pantheon.io
		}

		/**
		 * Load support for third-party plugins.
		 *
		 * @access public
		 * @return string
		 */
		public function include_plugins() {
			include_once COCART_ABSPATH . 'includes/third-party/plugin/jwt-auth-by-useful-team/class-cocart-plugin-jwt-auth.php'; // JWT Auth
			include_once COCART_ABSPATH . 'includes/third-party/plugin/taxjar/class-cocart-plugin-taxjar.php'; // TaxJar
		}

	} // END class.

} // END if class exists.

return new CoCart_Third_Party();
