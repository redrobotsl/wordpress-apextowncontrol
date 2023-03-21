<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * HELPER COMMENT START
 * 
 * This is the main class that is responsible for registering
 * the core functions, including the files and setting up all features. 
 * 
 * To add a new class, here's what you need to do: 
 * 1. Add your new class within the following folder: core/includes/classes
 * 2. Create a new variable you want to assign the class to (as e.g. public $helpers)
 * 3. Assign the class within the instance() function ( as e.g. self::$instance->helpers = new Api_For_Apex_Towncontrol_Helpers();)
 * 4. Register the class you added to core/includes/classes within the includes() function
 * 
 * HELPER COMMENT END
 */

if ( ! class_exists( 'Api_For_Apex_Towncontrol' ) ) :

	/**
	 * Main Api_For_Apex_Towncontrol Class.
	 *
	 * @package		APIFORAPEX
	 * @subpackage	Classes/Api_For_Apex_Towncontrol
	 * @since		1.0.0
	 * @author		Nolan Perry, LLC
	 */
	final class Api_For_Apex_Towncontrol {

		/**
		 * The real instance
		 *
		 * @access	private
		 * @since	1.0.0
		 * @var		object|Api_For_Apex_Towncontrol
		 */
		private static $instance;

		/**
		 * APIFORAPEX helpers object.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @var		object|Api_For_Apex_Towncontrol_Helpers
		 */
		public $helpers;

		/**
		 * APIFORAPEX settings object.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @var		object|Api_For_Apex_Towncontrol_Settings
		 */
		public $settings;
        public $options;
		/**
		 * Throw error on object clone.
		 *
		 * Cloning instances of the class is forbidden.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @return	void
		 */
		public function __clone() {
			_doing_it_wrong( __FUNCTION__, __( 'You are not allowed to clone this class.', 'api-for-apex-towncontrol' ), '1.0.0' );
		}

		/**
		 * Disable unserializing of the class.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @return	void
		 */
		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, __( 'You are not allowed to unserialize this class.', 'api-for-apex-towncontrol' ), '1.0.0' );
		}

		/**
		 * Main Api_For_Apex_Towncontrol Instance.
		 *
		 * Insures that only one instance of Api_For_Apex_Towncontrol exists in memory at any one
		 * time. Also prevents needing to define globals all over the place.
		 *
		 * @access		public
		 * @since		1.0.0
		 * @static
		 * @return		object|Api_For_Apex_Towncontrol	The one true Api_For_Apex_Towncontrol
		 */
		public static function instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Api_For_Apex_Towncontrol ) ) {
				self::$instance					= new Api_For_Apex_Towncontrol;
				self::$instance->base_hooks();
				self::$instance->includes();
				self::$instance->settings		= new Api_For_Apex_Towncontrol_Settings();
				self::$instance->options		= new Api_for_Apex_Towncontrol_Options();

				//Fire the plugin logic
				new Api_For_Apex_Towncontrol_Run();

				/**
				 * Fire a custom action to allow dependencies
				 * after the successful plugin setup
				 */
				do_action( 'APIFORAPEX/plugin_loaded' );
				
				

				self::$instance->options->towncontrol_register_stuff();
                new RR_APX_Shortcodes_Arrests();
                new RR_APX_Shortcodes_Phonebook();
				new RR_APX_Shortcodes_Roster();

			}

			return self::$instance;
		}

		/**
		 * Include required files.
		 *
		 * @access  private
		 * @since   1.0.0
		 * @return  void
		 */
		private function includes() {
			require_once APIFORAPEX_PLUGIN_DIR . 'core/includes/classes/class-api-for-apex-towncontrol-settings.php';

			require_once APIFORAPEX_PLUGIN_DIR . 'core/includes/classes/class-api-for-apex-towncontrol-run.php';
			
			require_once APIFORAPEX_PLUGIN_DIR . 'core/includes/classes/class-api-for-apex-towncontrol-options.php';
			require_once APIFORAPEX_PLUGIN_DIR . 'core/includes/classes/class-rr-apx-shortcodes-arrests.php';
			require_once APIFORAPEX_PLUGIN_DIR . 'core/includes/classes/class-rr-apx-shortcodes-phonebook.php';
			require_once APIFORAPEX_PLUGIN_DIR . 'core/includes/classes/class-rr-apx-shortcodes-roster.php';


		}

		/**
		 * Add base hooks for the core functionality
		 *
		 * @access  private
		 * @since   1.0.0
		 * @return  void
		 */
		private function base_hooks() {
			add_action( 'plugins_loaded', array( self::$instance, 'load_textdomain' ) );
		}

		/**
		 * Loads the plugin language files.
		 *
		 * @access  public
		 * @since   1.0.0
		 * @return  void
		 */
		public function load_textdomain() {
			load_plugin_textdomain( 'api-for-apex-towncontrol', FALSE, dirname( plugin_basename( APIFORAPEX_PLUGIN_FILE ) ) . '/languages/' );
		}

	}

endif; // End if class_exists check.