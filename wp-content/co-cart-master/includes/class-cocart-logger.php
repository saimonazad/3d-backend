<?php
/**
 * CoCart REST API logger.
 *
 * Handles logging errors.
 *
 * @author   Sébastien Dumont
 * @category API
 * @package  CoCart\Classes
 * @since    2.1.0
 * @version  3.0.0
 * @license  GPL-2.0+
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * CoCart REST API logger class.
 *
 * @package CoCart REST API/Logger
 */
class CoCart_Logger {

	public static $logger;

	/**
	 * Log issues or errors within CoCart.
	 *
	 * @access public
	 * @static
	 * @since   2.1.0
	 * @version 3.0.0
	 * @param   string $message - The message of the log.
	 * @param   string $type    - The type of log to record.
	 * @param   string $plugin  - The CoCart plugin being logged.
	 */
	public static function log( $message, $type, $plugin = 'cocart-lite' ) {
		if ( ! class_exists( 'WC_Logger' ) ) {
			return;
		}

		if ( apply_filters( 'cocart_logging', true, $type, $plugin ) && defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			if ( empty( self::$logger ) ) {
				self::$logger = wc_get_logger();
			}

			if ( $plugin == 'cocart-lite' ) {
				$log_entry = "\n" . '====CoCart Lite Version: ' . COCART_VERSION . '====' . "\n";
				$context   = array( 'source' => 'cocart-lite' );
			} elseif ( $plugin == 'cocart-pro' ) {
				$log_entry = "\n" . '====CoCart Pro Version: ' . COCART_PRO_VERSION . '====' . "\n";
				$context   = array( 'source' => 'cocart-pro' );
			} else {
				/* translators: %1$s: Log entry name, %2$s: log entry version */
				$log_entry = "\n" . sprintf( esc_html__( '====%1$s Version: %2$s====', 'cart-rest-api-for-woocommerce' ), apply_filters( 'cocart_log_entry_name', '', $plugin ), apply_filters( 'cocart_log_entry_version', '', $plugin ) ) . "\n";
				$context   = array( 'source' => apply_filters( 'cocart_log_entry_source', '' ) );
			}

			$log_time = date_i18n( get_option( 'date_format' ) . ' g:ia', current_time( 'timestamp' ) );

			$log_entry .= '====Start Log ' . $log_time . '====' . "\n" . $message . "\n";
			$log_entry .= '====End Log====' . "\n\n";

			switch ( $type ) {
				// Interesting events.
				case 'info':
					self::$logger->info( $log_entry, $context );
					break;
				// Normal but significant events.
				case 'notice':
					self::$logger->notice( $log_entry, $context );
					break;
				// Exceptional occurrences that are not errors.
				case 'warning':
					self::$logger->warning( $log_entry, $context );
					break;
				// Runtime errors that do not require immediate.
				case 'error':
					self::$logger->error( $log_entry, $context );
					break;
				// Critical conditions.
				case 'critical':
					self::$logger->critical( $log_entry, $context );
					break;
				// Action must be taken immediately.
				case 'alert':
					self::$logger->alert( $log_entry, $context );
					break;
				// System is unusable.
				case 'emergency':
					self::$logger->emergency( $log_entry, $context );
					break;
				// Detailed debug information.
				case 'debug':
				default:
					self::$logger->debug( $log_entry, $context );
					break;
			}
		}
	} // END log()

} // END class
