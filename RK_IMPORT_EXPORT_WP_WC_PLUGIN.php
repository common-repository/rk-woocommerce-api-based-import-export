<?php
/*
  Plugin Name: WooCommerce Import Export Plugin
  Plugin URI: http://wp.ravikatre.in/
  Version: 1.0.0
  Description: Plugin for WooCommerce customization.
  Author: Ravi
  Author URI: http://www.ravikatre.in/
 download_url: https://github.com/ravi2katre/RK_IMPORT_EXPORT_WP_WC_PLUGIN/archive/master.zip,
  Text Domain: RK
  Domain Path: /languages/

  License: GNU General Public License v3.0
  License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */
error_reporting(1);
if ( !defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly


    // Put your plugin code here
if ( !class_exists( 'RK_ravi' ) ) {

$plugin_name = 'RK_IMPORT_EXPORT_WP_WC_PLUGIN';
define("RK_PLUGIN_NAME",$plugin_name );
define('RK_PLUGIN_ROOT_DIR', dirname(__FILE__) . '/');


	class RK_ravi {

		/**
		 * @var Singleton The reference the *Singleton* instance of this class
		 */
		private static $instance;
		
                
		/**
		 * @var Reference to logging class.
		 */
		private static $log;

		/**
		 * Returns the *Singleton* instance of this class.
		 *
		 * @return Singleton The *Singleton* instance.
		 */
		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Private clone method to prevent cloning of the instance of the
		 * *Singleton* instance.
		 *
		 * @return void
		 */
		private function __clone() {
			
		}

		/**
		 * Private unserialize method to prevent unserializing of the *Singleton*
		 * instance.
		 *
		 * @return void
		 */
		private function __wakeup() {
			
		}

		/**
		 * Notices (array)
		 * @var array
		 */
		public $notices = array();

		/**
		 * Protected constructor to prevent creating a new instance of the
		 * *Singleton* via the `new` operator from outside of this class.
		 */
		public function __construct() {

			//$this->scripts();
			$this->define_constants();
			$this->includes();
			$this->init_hooks();
		}

		public function __destruct() {
			
		}

		/**
		 * Init the plugin after plugins_loaded so environment variables are set.
		 */
		public function init() {
			
		}

		public function scripts_admin_head() {
			wp_register_script( 'scripts_boot','//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js', false );
			wp_enqueue_script( 'scripts_boot' );
			wp_register_script( 'scripts_jquery_form','//cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js', false );
			wp_enqueue_script( 'scripts_jquery_form' );
			wp_register_script( 'custom_js',plugins_url('/'.RK_PLUGIN_NAME.'/js/rk_js.js'),array( 'jquery' ));
			wp_enqueue_script( 'custom_js' );

			
			wp_register_style( 'fontawesome','//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css', null, '4.0.1' );
			wp_enqueue_style( 'fontawesome' );
			wp_register_style( 'custom_css',plugins_url('/'.RK_PLUGIN_NAME.'/css/rk_style.css'), false, '1.0.0', 'all' );
			wp_enqueue_style( 'custom_css' );
			//$this->custom_post_css();
			



		}

		public function scripts_admin_init() {
			wp_register_style( 'bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css', false, '1.0.0', 'all' );
			wp_enqueue_style( 'bootstrap' );
			
			//print_r($this->define);
		}
		
	
		function custom_post_css() {
 

   
		}
		
	

		/**
		 * Hook into actions and filters.
		 * @since  2.3
		 */
		private function init_hooks() {
			
		}

		/**
		 * Define WC Constants.
		 */
		private function define_constants() {
			
		}

		/**
		 * Define constant if not already set.
		 *
		 * @param  string $name
		 * @param  string|bool $value
		 */
		private function define( $name, $value ) {
			if ( !defined( $name ) ) {
				define( $name, $value );
			}
		}

		/**
		 * Include required core files used in admin and on the frontend.
		 */
		public function includes() {
		if ( $this->is_request( 'admin' ) ) {

				include_once( 'admin/admin_init.php' );
				
				add_action( 'admin_init', array( $this, 'scripts_admin_init' ) );
				add_action( 'admin_head', array( $this, 'scripts_admin_head' ) );
			}

			if ( $this->is_request( 'frontend' ) ) {
				include_once( 'frontend/frontend_init.php' );
			}
                        
		}

		/**
		 * What type of request is this?
		 *
		 * @param  string $type admin, ajax, cron or frontend.
		 * @return bool
		 */
		private function is_request( $type ) {
			switch ( $type ) {
				case 'admin' :
					return is_admin();
				case 'ajax' :
					return defined( 'DOING_AJAX' );
				case 'cron' :
					return defined( 'DOING_CRON' );
				case 'frontend' :
					return (!is_admin() || defined( 'DOING_AJAX' ) ) && !defined( 'DOING_CRON' );
			}
		}

	}

	RK_ravi::get_instance();
}

