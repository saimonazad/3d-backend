<?php
/**
 * Handles support for Advanced Shipping Packages extension.
 *
 * @author   Sébastien Dumont
 * @category Classes
 * @package  CoCart\Compatibility\Modules
 * @since    3.0.0
 * @license  GPL-2.0+
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'CoCart_ASP_Compatibility' ) ) {

	class CoCart_ASP_Compatibility {

		/**
		 * Constructor.
		 *
		 * @access public
		 */
		public function __construct() {
			add_filter( 'cocart_shipping_package_name', array( $this, 'cocart_asp_shipping_package_name' ), 10, 3 );
		}

		/**
		 * Name shipping packages.
		 *
		 * Set the shipping package name accordingly.
		 *
		 * @access public
		 * @param  string $name    Original shipping package name.
		 * @param  int    $i       Shipping package index.
		 * @param  array  $package Package list.
		 * @return string          Modified shipping package name.
		 */
		public function cocart_asp_shipping_package_name( $name, $i, $package ) {
			if ( is_numeric( $i ) && 'shipping_package' == get_post_type( $i ) ) {
				$name = get_post_meta( $i, '_name', true );
			}

			// Default package name.
			if ( $i === 0 && $title = get_option( 'advanced_shipping_packages_default_package_name', '' ) ) {
				$name = $title;
			}

			return $name;
		}

	} // END class.

} // END if class exists.

return new CoCart_ASP_Compatibility();
