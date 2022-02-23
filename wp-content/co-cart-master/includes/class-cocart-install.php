<?php
/**
 * CoCart - Installation related functions and actions.
 *
 * @author   Sébastien Dumont
 * @category Classes
 * @package  CoCart\Classes
 * @since    1.2.0
 * @version  3.1.0
 * @license  GPL-2.0+
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'CoCart_Install' ) ) {

	class CoCart_Install {

		/**
		 * DB updates and callbacks that need to be run per version.
		 *
		 * @var array
		 */
		private static $db_updates = array(
			'3.0.0' => array(
				'cocart_update_300_db_structure',
				'cocart_update_300_db_version',
			),
		);

		/**
		 * Constructor.
		 *
		 * @access  public
		 * @since   1.2.0
		 * @version 3.1.0
		 */
		public static function init() {
			// Checks version of CoCart and install/update if needed.
			add_action( 'init', array( __CLASS__, 'check_version' ), 5 );
			add_action( 'init', array( __CLASS__, 'manual_database_update' ), 20 );
			add_action( 'cocart_run_update_callback', array( __CLASS__, 'run_update_callback' ) );
			add_action( 'admin_init', array( __CLASS__, 'install_actions' ) );

			// Redirect to Getting Started page once activated.
			add_action( 'activated_plugin', array( __CLASS__, 'redirect_getting_started' ), 10 );

			// Drop tables when MU blog is deleted.
			add_filter( 'wpmu_drop_tables', array( __CLASS__, 'wpmu_drop_tables' ) );
		} // END init()

		/**
		 * Check plugin version and run the updater if necessary.
		 *
		 * This check is done on all requests and runs if the versions do not match.
		 *
		 * @access public
		 * @static
		 */
		public static function check_version() {
			if ( ! defined( 'IFRAME_REQUEST' ) && version_compare( get_option( 'cocart_version' ), COCART_VERSION, '<' ) && current_user_can( 'install_plugins' ) ) {
				self::install();
				do_action( 'cocart_updated' );
			}
		} // END check_version()

		/**
		 * Perform a manual database update when triggered by WooCommerce System Tools.
		 *
		 * @access public
		 * @static
		 * @since  3.0.0
		 */
		public static function manual_database_update() {
			$blog_id = get_current_blog_id();

			add_action( 'wp_' . $blog_id . '_cocart_updater_cron', array( __CLASS__, 'run_manual_database_update' ) );
		} // END manual_database_update()

		/**
		 * Run manual database update.
		 *
		 * @access  public
		 * @static
		 * @version 3.0.0
		 */
		public static function run_manual_database_update() {
			self::update();
		} // END run_manual_database_update()

		/**
		 * Run an update callback when triggered by ActionScheduler.
		 *
		 * @access public
		 * @static
		 * @since  3.0.0
		 * @param  string $callback Callback name.
		 */
		public static function run_update_callback( $callback ) {
			include_once dirname( __FILE__ ) . '/cocart-update-functions.php';

			if ( is_callable( $callback ) ) {
				self::run_update_callback_start( $callback );
				$result = (bool) call_user_func( $callback );
				self::run_update_callback_end( $callback, $result );
			}
		} // END run_update_callback()

		/**
		 * Triggered when a callback will run.
		 *
		 * @access protected
		 * @static
		 * @since  3.0.0
		 * @param  string $callback Callback name.
		 */
		protected static function run_update_callback_start( $callback ) {
			define( 'COCART_UPDATING', true );
		} // END run_update_callback_start()

		/**
		 * Triggered when a callback has ran.
		 *
		 * @access protected
		 * @static
		 * @since  3.0.0
		 * @param  string $callback Callback name.
		 * @param  bool   $result Return value from callback. Non-false need to run again.
		 */
		protected static function run_update_callback_end( $callback, $result ) {
			if ( $result ) {
				WC()->queue()->add(
					'cocart_run_update_callback',
					array(
						'update_callback' => $callback,
					),
					'cocart-db-updates'
				);
			}
		} // END run_update_callback_end()

		/**
		 * Install actions when a update button is clicked within the admin area.
		 *
		 * @access public
		 * @static
		 * @since  3.0.0
		 */
		public static function install_actions() {
			if ( ! empty( $_GET['do_update_cocart'] ) ) {
				check_admin_referer( 'cocart_db_update', 'cocart_db_update_nonce' );
				self::update();
				CoCart_Admin_Notices::add_notice( 'update_db', true );
			}
		} // END install_actions()

		/**
		 * Install CoCart.
		 *
		 * @access public
		 * @static
		 * @since   1.2.0
		 * @version 3.1.0
		 */
		public static function install() {
			if ( ! is_blog_installed() ) {
				return;
			}

			// Check if we are not already running this routine.
			if ( 'yes' === get_transient( 'cocart_installing' ) ) {
				return;
			}

			// If we made it till here nothing is running yet, lets set the transient now for five minutes.
			set_transient( 'cocart_installing', 'yes', MINUTE_IN_SECONDS * 5 );
			if ( ! defined( 'COCART_INSTALLING' ) ) {
				define( 'COCART_INSTALLING', true );
			}

			// Remove all admin notices.
			self::remove_admin_notices();

			// Install database tables.
			self::create_tables();
			self::verify_base_tables();

			// Creates cron jobs.
			self::create_cron_jobs();

			// Create files.
			self::create_files();

			// Set activation date.
			self::set_install_date();

			// Maybe see if we need to enable the setup wizard or not.
			self::maybe_enable_setup_wizard();

			// Update plugin version.
			self::update_version();

			// Maybe update database version.
			self::maybe_update_db_version();

			delete_transient( 'cocart_installing' );

			do_action( 'cocart_installed' );
		} // END install()

		/**
		 * Check if all the base tables are present.
		 *
		 * @access public
		 * @static
		 * @since 3.0.0
		 * @param bool $modify_notice Whether to modify notice based on if all tables are present.
		 * @param bool $execute       Whether to execute get_schema queries as well.
		 * @return array List of querues.
		 */
		public static function verify_base_tables( $modify_notice = true, $execute = false ) {
			require_once ABSPATH . 'wp-admin/includes/upgrade.php';

			if ( $execute ) {
				self::create_tables();
			}

			$queries        = dbDelta( self::get_schema(), false );
			$missing_tables = array();

			foreach ( $queries as $table_name => $result ) {
				if ( "Created table $table_name" === $result ) {
					$missing_tables[] = $table_name;
				}
			}

			if ( 0 < count( $missing_tables ) ) {
				if ( $modify_notice ) {
					CoCart_Admin_Notices::add_notice( 'base_tables_missing' );
				}

				update_option( 'cocart_schema_missing_tables', $missing_tables );
			} else {
				if ( $modify_notice ) {
					CoCart_Admin_Notices::remove_notice( 'base_tables_missing' );
				}

				delete_option( 'cocart_schema_missing_tables' );
			}

			return $missing_tables;
		} // END verify_base_tables()

		/**
		 * Reset any notices added to admin.
		 *
		 * @access  private
		 * @static
		 * @since   3.0.0
		 * @version 3.1.0
		 */
		private static function remove_admin_notices() {
			include_once COCART_ABSPATH . 'includes/admin/class-cocart-admin-notices.php';
			CoCart_Admin_Notices::remove_all_notices();
		}

		/**
		 * Is this a brand new CoCart install?
		 *
		 * A brand new install has no version yet. Also treat empty installs as 'new'.
		 *
		 * @access public
		 * @static
		 * @since  3.0.0
		 * @return boolean
		 */
		public static function is_new_install() {
			return is_null( get_option( 'cocart_version', null ) );
		}

		/**
		 * Is a Database update needed?
		 *
		 * @access public
		 * @static
		 * @since  3.0.0
		 * @return boolean
		 */
		public static function needs_db_update() {
			$current_db_version = get_option( 'cocart_db_version', null );
			$updates            = self::get_db_update_callbacks();
			$update_versions    = array_keys( $updates );
			usort( $update_versions, 'version_compare' );

			return ! is_null( $current_db_version ) && version_compare( $current_db_version, end( $update_versions ), '<' );
		} // END needs_db_update()

		/**
		 * See if we need the setup wizard or not.
		 *
		 * @access private
		 * @static
		 * @since  3.1.0
		 */
		private static function maybe_enable_setup_wizard() {
			if ( apply_filters( 'cocart_enable_setup_wizard', true ) && self::is_new_install() ) {
				CoCart_Admin_Notices::add_notice( 'setup_wizard', true );
				set_transient( '_cocart_activation_redirect', 1, 30 );
			}
		} // END maybe_enable_setup_wizard()

		/**
		 * See if we need to show or run database updates during install.
		 *
		 * @access private
		 * @static
		 * @since  3.0.0
		 */
		private static function maybe_update_db_version() {
			if ( self::needs_db_update() ) {
				if ( apply_filters( 'cocart_enable_auto_update_db', false ) ) {
					self::update();
				} else {
					CoCart_Admin_Notices::add_notice( 'update_db', true );
				}
			} else {
				self::update_db_version();
			}
		} // END maybe_update_db_version()

		/**
		 * Update plugin version to current.
		 *
		 * @access  private
		 * @since   1.2.0
		 * @version 2.8.3
		 * @static
		 */
		private static function update_version() {
			update_option( 'cocart_version', COCART_VERSION );
		} // END update_version()

		/**
		 * Get list of DB update callbacks.
		 *
		 * @access public
		 * @static
		 * @since  3.0.0
		 * @return array
		 */
		public static function get_db_update_callbacks() {
			return self::$db_updates;
		} // END get_db_update_callbacks()

		/**
		 * Push all needed DB updates to the queue for processing.
		 *
		 * @access private
		 * @static
		 * @since  3.0.0
		 */
		private static function update() {
			$current_db_version = get_option( 'cocart_db_version' );
			$loop               = 0;

			foreach ( self::get_db_update_callbacks() as $version => $update_callbacks ) {
				if ( version_compare( $current_db_version, $version, '<' ) ) {
					foreach ( $update_callbacks as $update_callback ) {
						WC()->queue()->schedule_single(
							time() + $loop,
							'cocart_run_update_callback',
							array(
								'update_callback' => $update_callback,
							),
							'cocart-db-updates'
						);
						$loop++;
					}
				}
			}
		} // END update()

		/**
		 * Update DB version to current.
		 *
		 * @access  public
		 * @static
		 * @since   2.9.0
		 * @version 3.0.0
		 * @param   string|null $version New WooCommerce DB version or null.
		 */
		public static function update_db_version( $version = null ) {
			delete_option( 'cocart_db_version' );
			add_option( 'cocart_db_version', is_null( $version ) ? COCART_DB_VERSION : $version );
		} // END update_db_version()

		/**
		 * Set the time the plugin was installed.
		 *
		 * @access public
		 * @static
		 */
		public static function set_install_date() {
			add_option( 'cocart_install_date', time() );
		} // END set_install_date()

		/**
		 * Redirects to the Getting Started page upon plugin activation.
		 *
		 * @access  public
		 * @static
		 * @since   1.2.0
		 * @version 3.1.0
		 * @param   string $plugin - Activate plugin file.
		 */
		public static function redirect_getting_started( $plugin ) {
			// Prevent redirect if plugin name does not match or multiple plugins are being activated.
			if ( $plugin !== plugin_basename( COCART_FILE ) || isset( $_GET['activate-multi'] ) ) {
				return;
			}

			// Dont redirect to getting started page if CoCart is not a new install.
			if ( ! get_transient( '_cocart_activation_redirect' ) ) {
				return;
			}

			$page = admin_url( 'admin.php' );

			$getting_started = add_query_arg(
				array(
					'page'    => 'cocart',
					'section' => 'getting-started',
				),
				$page
			);

			/**
			 * Should CoCart be installed via WP-CLI,
			 * display a link to the Getting Started page.
			 */
			if ( defined( 'WP_CLI' ) && WP_CLI ) {
				/* translators: %1$s: message, %2$s: URL, %3$s: CoCart */
				WP_CLI::log(
					WP_CLI::colorize(
						'%y' . sprintf( '🎉 %1$s %2$s', __( 'Get started with %3$s here:', 'cart-rest-api-for-woocommerce' ), $getting_started, 'CoCart' ) . '%n'
					)
				);
				return;
			}

			wp_safe_redirect( $getting_started );
			exit;
		} // END redirect_getting_started()

		/**
		 * Create cron jobs (clear them first).
		 *
		 * @access private
		 * @static
		 * @since  2.1.0
		 */
		private static function create_cron_jobs() {
			wp_clear_scheduled_hook( 'cocart_cleanup_carts' );

			wp_schedule_event( time() + ( 6 * HOUR_IN_SECONDS ), 'twicedaily', 'cocart_cleanup_carts' );
		} // END create_cron_jobs()

		/**
		 * Creates database tables which the plugin needs to function.
		 * WARNING: If you are modifying this method, make sure that its safe to call regardless of the state of database.
		 *
		 * This is called from `install` method and is executed in-sync when CoCart is installed or updated.
		 * This can also be called optionally from `verify_base_tables`.
		 *
		 * @access private
		 * @static
		 * @since   2.1.0
		 * @version 3.0.0
		 * @global  $wpdb
		 */
		private static function create_tables() {
			global $wpdb;

			$wpdb->hide_errors();

			require_once ABSPATH . 'wp-admin/includes/upgrade.php';

			dbDelta( self::get_schema() );
		} // END create_tables()

		/**
		 * Get Table schema.
		 *
		 * @access private
		 * @static
		 * @since  3.0.0
		 * @global $wpdb
		 * @return string
		 */
		private static function get_schema() {
			global $wpdb;

			$collate = $wpdb->has_cap( 'collation' ) ? $wpdb->get_charset_collate() : '';

			$tables = "CREATE TABLE {$wpdb->prefix}cocart_carts (
 cart_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
 cart_key char(42) NOT NULL,
 cart_value longtext NOT NULL,
 cart_created BIGINT UNSIGNED NOT NULL,
 cart_expiry BIGINT UNSIGNED NOT NULL,
 cart_source varchar(200) NOT NULL,
 cart_hash varchar(200) NOT NULL,
 PRIMARY KEY  (cart_id),
 UNIQUE KEY cart_key (cart_key)
) $collate;";

			return $tables;
		} // END get_schema()

		/**
		 * Return a list of CoCart tables. Used to make sure all CoCart tables
		 * are dropped when uninstalling the plugin in a single site
		 * or multi site environment.
		 *
		 * @access public
		 * @static
		 * @since  2.1.0
		 * @global $wpdb
		 * @return array $tables.
		 */
		public static function get_tables() {
			global $wpdb;

			$tables = array(
				"{$wpdb->prefix}cocart_carts",
			);

			return $tables;
		} // END get_tables()

		/**
		 * Drop CoCart tables.
		 *
		 * @access public
		 * @static
		 * @since  2.1.0
		 * @global $wpdb
		 * @return void
		 */
		public static function drop_tables() {
			global $wpdb;

			$tables = self::get_tables();

			foreach ( $tables as $table ) {
				$wpdb->query( "DROP TABLE IF EXISTS {$table}" );
			}
		} // END drop_tables()

		/**
		 * Uninstall tables when MU blog is deleted.
		 *
		 * @access public
		 * @since  2.1.0
		 * @param  array $tables List of tables that will be deleted by WP.
		 * @return string[]
		 */
		public static function wpmu_drop_tables( $tables ) {
			return array_merge( $tables, self::get_tables() );
		} // END wpmu_drop_tables()

		/**
		 * Create files/directories.
		 *
		 * @access private
		 * @static
		 * @since 3.0.0
		 */
		private static function create_files() {
			// Bypass if filesystem is read-only and/or non-standard upload system is used.
			if ( apply_filters( 'cocart_install_skip_create_files', false ) ) {
				return;
			}

			// Install files and folders for uploading files and prevent hotlinking.
			$upload_dir = wp_get_upload_dir();

			$files = array(
				array(
					'base'    => $upload_dir['basedir'] . '/cocart_uploads',
					'file'    => 'index.html',
					'content' => '',
				),
				array(
					'base'    => $upload_dir['basedir'] . '/cocart_uploads',
					'file'    => '.htaccess',
					'content' => 'deny from all',
				),
			);

			foreach ( $files as $file ) {
				if ( wp_mkdir_p( $file['base'] ) && ! file_exists( trailingslashit( $file['base'] ) . $file['file'] ) ) {
					$file_handle = @fopen( trailingslashit( $file['base'] ) . $file['file'], 'wb' );

					if ( $file_handle ) {
						fwrite( $file_handle, $file['content'] );
						fclose( $file_handle );
					}
				}
			}
		} // create_files()

	} // END class.

} // END if class exists.

CoCart_Install::init();
