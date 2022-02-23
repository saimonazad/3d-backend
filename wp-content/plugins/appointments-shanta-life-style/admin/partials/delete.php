<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       dcastalia.com
 * @since      1.0.0
 *
 * @package    Appointments_Shanta_Life_Style
 * @subpackage Appointments_Shanta_Life_Style/admin/partials
 */
?>


<?php

global $wpdb;

$dataid = $_POST['dataID'];

if (isset( $dataid)){
    $tablename = $wpdb->prefix . 'wp_appointments_slot';
    $wpdb->delete($tablename, array('id' => $dataid));
}


?>

