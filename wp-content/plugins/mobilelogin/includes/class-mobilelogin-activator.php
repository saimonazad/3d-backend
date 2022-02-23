<?php

/**
 * Fired during plugin activation
 *
 * @link       https://dcastalia.com/
 * @since      1.0.0
 *
 * @package    Mobilelogin
 * @subpackage Mobilelogin/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Mobilelogin
 * @subpackage Mobilelogin/includes
 * @author     Dcastaila <infor@dcastalia.com>
 */
class Mobilelogin_Activator
{

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */

    public static function activate()
    {


//        variable
        global $wpdb;
        //Generate a random string.
        $token = openssl_random_pseudo_bytes(12);

//Convert the binary data into hexadecimal representation.
        $token = bin2hex($token);
        $user_table = $wpdb->prefix . 'users';











        $row = $wpdb->get_results("SELECT COLUMN_NAME  FROM INFORMATION_SCHEMA.COLUMNS 
WHERE $user_table AND column_name = 'country_code' , column_name = 'user_phone' , column_name = 'token' ,column_name = 'verify_token'");
        $alter = "ALTER table {$user_table} ADD COLUMN country_code VARCHAR (50) NOT NULL DEFAULT '+880',ADD COLUMN user_phone VARCHAR (100) NULL ,ADD COLUMN token VARCHAR (255) NULL DEFAULT '$token',ADD COLUMN verify_token VARCHAR (255) NULL DEFAULT '0' ";
        if (empty($row)) {
            $wpdb->query($alter);
        }







//        for forget password table







    }


}
