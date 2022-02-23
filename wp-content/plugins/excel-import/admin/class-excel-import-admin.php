<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       dcastalia.com
 * @since      1.0.0
 *
 * @package    Excel_Import
 * @subpackage Excel_Import/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Excel_Import
 * @subpackage Excel_Import/admin
 * @author     Dcastaila <infor@dcastalia.com>
 */
class Excel_Import_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Excel_Import_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Excel_Import_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/excel-import-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Excel_Import_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Excel_Import_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( "jzip", 'https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/jszip.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( "xlsjs", 'https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/xlsx.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/excel-import-admin.js', array( 'jquery' ), $this->version, false );
        wp_localize_script ( $this->plugin_name, 'ajax', array( 'ajax_url' => admin_url( 'admin-ajax.php' )));

	}




    function import_admin_view()
    {


       // echo "Admin view";

        $page_title = __($this->plugin_name, 'excel-import');
        $menu_title = __($this->plugin_name, 'excel-import');
        $capability = 'manage_options';
        $slug = 'import_from_excel';
        $callback = array($this, 'admin_content');
        add_menu_page($page_title, $menu_title, $capability, $slug, $callback, 'dashicons-external');

    }




    function admin_content()
    {
        require plugin_dir_path(__FILE__) . 'partials/admin_view_import.php';

    }


    function f711_get_post_content_callback() {


        // retrieve post_id, and sanitize it to enhance security

    }


}

