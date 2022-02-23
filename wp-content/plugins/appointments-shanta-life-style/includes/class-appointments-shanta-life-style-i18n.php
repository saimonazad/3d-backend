<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       dcastalia.com
 * @since      1.0.0
 *
 * @package    Appointments_Shanta_Life_Style
 * @subpackage Appointments_Shanta_Life_Style/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Appointments_Shanta_Life_Style
 * @subpackage Appointments_Shanta_Life_Style/includes
 * @author     Dcastaila <infor@dcastalia.com>
 */
class Appointments_Shanta_Life_Style_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'appointments-shanta-life-style',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
