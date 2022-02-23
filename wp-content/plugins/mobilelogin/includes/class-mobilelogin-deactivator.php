<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://dcastalia.com/
 * @since      1.0.0
 *
 * @package    Mobilelogin
 * @subpackage Mobilelogin/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Mobilelogin
 * @subpackage Mobilelogin/includes
 * @author     Dcastaila <infor@dcastalia.com>
 */
class Mobilelogin_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {


        global $wpdb;
        $table_name = $wpdb->prefix . 'mobile_users';
        $sql = "TRUNCATE TABLE {$table_name}";
        $wpdb->query($sql);
        $user_table = $wpdb->prefix . 'users';




        $user_table = $wpdb->prefix . 'users';
        $row = $wpdb->get_results("SELECT COLUMN_NAME  FROM INFORMATION_SCHEMA.COLUMNS 
WHERE $user_table AND column_name = 'country_code' , column_name = 'user_phone' , column_name = 'token'");
        $alter = "ALTER table {$user_table} DROP COLUMN country_code ,DROP COLUMN user_phone ,DROP COLUMN token,DROP COLUMN verify_token  ";
        $wpdb->query($alter);
    }

}
