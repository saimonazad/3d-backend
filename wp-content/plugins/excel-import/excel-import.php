<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              dcastalia.com
 * @since             1.0.0
 * @package           Excel_Import
 *
 * @wordpress-plugin
 * Plugin Name:       Shanta Life Excel File import (DC)
 * Plugin URI:        dcastalia.com
 * Description:       This plugin import woocommerce product data from excel file. Custom Plugin made by Dcastalia
 * Version:           1.0.0
 * Author:            Dcastaila
 * Author URI:        dcastalia.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       excel-import
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'EXCEL_IMPORT_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-excel-import-activator.php
 */
function activate_excel_import() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-excel-import-activator.php';
	Excel_Import_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-excel-import-deactivator.php
 */
function deactivate_excel_import() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-excel-import-deactivator.php';
	Excel_Import_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_excel_import' );
register_deactivation_hook( __FILE__, 'deactivate_excel_import' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-excel-import.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_excel_import() {

	$plugin = new Excel_Import();
	$plugin->run();

}
run_excel_import();
