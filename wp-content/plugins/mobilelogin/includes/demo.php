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
        global $wpdb;
        $table_name = $wpdb->prefix . 'mobile_users';
        $user_table = $wpdb->prefix . 'users';


        $query = $wpdb->prepare('SHOW TABLES LIKE %s', $wpdb->esc_like($table_name));

        if (!$wpdb->get_var($query) == $table_name) {
            $charset_collate = $wpdb->get_charset_collate();

            $sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		user_id int(199) NOT NULL ,
		user_login varchar(60)  NULL ,
		user_pass varchar(255)  NOT NULL ,
		user_nicename  varchar(50)   NOT NULL ,
		user_email  varchar(100)  NULL ,
		user_url  varchar(100)  NULL ,
		user_registered datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		user_activation_key  varchar(255) NOT NULL ,
		user_status  int(11) NOT NULL ,
		display_name varchar(250) NOT NULL,
		country_code  VARCHAR (50) NOT NULL DEFAULT '+880',
		user_phone VARCHAR (100) NULL,
		token text NOT NULL DEFAULT '767678',
		PRIMARY KEY  (id)
	) $charset_collate;";

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);

            $user_nicenames = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}users", ARRAY_A);

            foreach ($user_nicenames as $nice_name) {


                $wpdb->insert(
                    $table_name,
                    array(

                        'user_id' => $nice_name['ID'],
                        'user_login' => $nice_name['user_login'],
                        'user_pass' => $nice_name['user_pass'],
                        'user_nicename' => $nice_name['user_nicename'],
                        'user_email' => $nice_name['user_email'],
                        'user_url' => $nice_name['user_url'],
                        'user_registered' => $nice_name['user_registered'],
                        'user_activation_key' => $nice_name['user_activation_key'],
                        'user_status' => $nice_name['user_status'],
                        'display_name' => $nice_name['display_name'],

                    )
                );
            }

//            $alter = "ALTER table {$user_table}
//        ADD COLUMN country_code VARCHAR (50) NOT NULL DEFAULT '+880',
//        ADD COLUMN user_phone VARCHAR (100) NULL ,
//        ADD COLUMN token VARCHAR (50) NULL DEFAULT '767678',
//
//
//        ";
//            $wpdb->query($alter);
        } else {
            $user_nicenames = $wpdb->get_results("SELECT ID,user_login,user_email FROM {$wpdb->prefix}users", ARRAY_A);

            foreach ($user_nicenames as $nice_name) {


                $wpdb->insert(
                    $table_name,
                    array(
                        'time' => current_time('mysql'),
                        'user_id' => $nice_name['ID'],
                        'user_login' => $nice_name['user_login'],
                        'user_email' => $nice_name['user_email']
                    )
                );
            }

//            $alter = "ALTER table {$user_table}
//        ADD COLUMN country_code VARCHAR (50) NOT NULL DEFAULT '+880',
//        ADD COLUMN user_phone VARCHAR (100) NULL ,
//        ADD COLUMN token VARCHAR (50) NULL DEFAULT '767678',
//
//
//        ";
//            $wpdb->query( $alter );
        }


    }


}
