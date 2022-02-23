<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       dcastalia.com
 * @since      1.0.0
 *
 * @package    Appointments_Shanta_Life_Style
 * @subpackage Appointments_Shanta_Life_Style/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Appointments_Shanta_Life_Style
 * @subpackage Appointments_Shanta_Life_Style/admin
 * @author     Dcastaila <infor@dcastalia.com>
 */
class Appointments_Shanta_Life_Style_Admin {

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
		 * defined in Appointments_Shanta_Life_Style_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Appointments_Shanta_Life_Style_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style("bootstrapCss", 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'bootstrapDatepickerCss', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/appointments-shanta-life-style-admin.css', array(), $this->version, 'all' );


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
		 * defined in Appointments_Shanta_Life_Style_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Appointments_Shanta_Life_Style_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( 'boostrapJs', "https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js", array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'boostrapDatepickerJs', "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js", array( 'jquery' ), $this->version, false );
        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/appointments-shanta-life-style-admin.js', array( 'jquery' ), $this->version, false );


        $script_data_array = array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'security' => wp_create_nonce('load_more_posts'),
        );
        wp_localize_script($this->plugin_name, 'blog', $script_data_array);

        // Enqueued script with localized data.
        wp_enqueue_script($this->plugin_name);
	}



    function my_action_callback(){
        check_ajax_referer('load_more_posts', 'security');
        global $wpdb;

        $dataid = $_POST['dataID'];
        echo $dataid;
        if (isset($dataid)) {
            $tablename = $wpdb->prefix . 'wp_appointments_slot';
            $wpdb->delete($tablename, array('id' => $dataid));
        }
        die();
    }

	function appointments_admin_page(){

        $page_title = __($this->plugin_name, '');
        $menu_title = __($this->plugin_name, '');
        $capability = 'manage_options';
        $slug = 'appointment_admin_page';
        $callback = array($this, 'appointments_admin_content');
        add_menu_page($page_title, $menu_title, $capability, $slug, $callback, 'dashicons-list-view');
    }






    function appointments_admin_content()
    {
        require plugin_dir_path(__FILE__) . 'partials/class-appointments_admin-content.php';
    }

}
