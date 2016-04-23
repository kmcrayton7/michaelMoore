<?php
/**
 * Plugin Name: Mashshare - Open Graph Add-On
 * Plugin URI: https://www.mashshare.net
 * Description: This plugin allows you to add facebook open graph protocol to your blog
 * Author: René Hermenau
 * Author URI: https://www.mashshare.net
 * Version: 1.0.8
 * Text Domain: mashog
 * Domain Path: languages
 *
 *
 * @package MASHOG
 * @category Add-On
 * @author René Hermenau
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'MashshareOpenGraph' ) ) :

/**
 * Main mashog Class
 *
 * @since 1.0.0
 */
class MashshareOpenGraph {
	/** Singleton *************************************************************/

	/**
	 * @var MashshareOpenGraph The one and only MashshareOpenGraph
	 * @since 1.0.0
	 */
	private static $instance;
        
        /**
	 * MASHOG HTML Element Helper Object
	 *
	 * @var object
	 * @since 1.0.0
	 */
	//public $html;
        
        public $MASHOG_OG_Output;
        
        public $MASHOG_OG_Admin;
       
	
	
	/**
	 * Main Instance
	 *
	 * Insures that only one instance of this Add-On exists in memory at any one
	 * time. Also prevents needing to define globals all over the place.
	 *
	 * @since 1.0.0
	 * @static
	 * @staticvar array $instance
	 * @uses MashshareOpenGraph::setup_constants() Setup the constants needed
	 * @uses MashshareOpenGraph::includes() Include the required files
	 * @uses MashshareOpenGraph::load_textdomain() load the language files
	 * @see MASHOG()
	 * @return The one true Add-On
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof MashshareOpenGraph ) ) {
			self::$instance = new MashshareOpenGraph;
			self::$instance->setup_constants();
			self::$instance->includes();
			self::$instance->load_textdomain();
                        //self::$instance->html = new MASHOG_HTML_Elements();
                        self::$instance->MASHOG_OG_Output = new MASHOG_OG_Output();
                        self::$instance->MASHOG_OG_Admin = new MASHOG_OG_Admin();
                        self::$instance->hooks();
		}
		return self::$instance;
        }

	/**
	 * Throw error on object clone
	 *
	 * The whole idea of the singleton design pattern is that there is a single
	 * object therefore, we don't want the object to be cloned.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @return void
	 */
	public function __clone() {
		// Cloning instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'MASHOG' ), '1.0.0' );
	}

	/**
	 * Disable unserializing of the class
	 *
	 * @since 1.0.0
	 * @access protected
	 * @return void
	 */
	public function __wakeup() {
		// Unserializing instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'MASHOG' ), '1.0.0' );
	}
        
        /**
	 * Constructor Function
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	public function __construct() {
		//self::$instance = $this;
	}

	/**
	 * Setup plugin constants
	 *
	 * @access private
	 * @since 1.0.0
	 * @return void
	 */
	private function setup_constants() {
		global $wpdb, $mashog_options; 
		// Plugin version
		if ( ! defined( 'MASHOG_VERSION' ) ) {
			define( 'MASHOG_VERSION', '1.0.8' );
		}

		// Plugin Folder Path
		if ( ! defined( 'MASHOG_PLUGIN_DIR' ) ) {
			define( 'MASHOG_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		}

		// Plugin Folder URL
		if ( ! defined( 'MASHOG_PLUGIN_URL' ) ) {
			define( 'MASHOG_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
		}

		// Plugin Root File
		if ( ! defined( 'MASHOG_PLUGIN_FILE' ) ) {
			define( 'MASHOG_PLUGIN_FILE', __FILE__ );
		}
                
	}

	/**
	 * Include required files
	 *
	 * @access private
	 * @since 1.0.0
	 * @return void
	 */
	private function includes() {
            require_once MASHOG_PLUGIN_DIR . 'includes/scripts.php';
            require_once MASHOG_PLUGIN_DIR . 'includes/output.class.php';
            require_once MASHOG_PLUGIN_DIR . 'includes/opengraph.class.php';
		if ( is_admin() || ( defined( 'WP_CLI' ) && WP_CLI ) ) {
                        require_once MASHOG_PLUGIN_DIR . 'includes/admin/welcome.php';
                        require_once MASHOG_PLUGIN_DIR . 'includes/admin/plugins.php';
                        require_once MASHOG_PLUGIN_DIR . 'includes/admin/settings.php';
                        require_once MASHOG_PLUGIN_DIR . 'includes/admin/admin-notices.php';
                        
		}
	}
        
        /**
         * Run action and filter hooks
         *
         * @access      private
         * @since       1.0.0
         * @return      void
         *
         */
        private function hooks() {

             /* Instantiate class MASHOG_licence 
             * Create 
             * @since 1.0.0
             * @return apply_filter mashsb_settings_licenses and create licence key input field in core mashsbs
              * @deprecated since 1.0.7
             */
            /*if (class_exists('MASHSB_License')) {
                $mashsb_sl_license = new MASHSB_License(__FILE__, 'Mashshare Open Graph', MASHOG_VERSION, 'Rene Hermenau', 'edd_sl_license_key'); 
            }*/
        }

	/**
	 * Loads the plugin language files
	 *
	 * @access public
	 * @since 1.4
	 * @return void
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'mashog', false, dirname( plugin_basename( MASHOG_PLUGIN_FILE ) ) . '/languages/' );
	}
        
        /**
	 * Activation function fires when the plugin is activated.
	 * This function is fired when the activation hook is called by WordPress.
	 *
	 * @since 1.0
	 * @access public
	 *
	 * @return void
	 */
	public static function activation() {

            // Add Upgraded From Option
            $current_version = get_option('mashog_version');
            if ($current_version) {
                update_option('mashog_version_upgraded_from', $current_version);
            }
            // Bail if activating from network, or bulk
             if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
              return;
              } 
            // Add the current version
            update_option('mashog_version', MASHOG_VERSION);
            // Add the transient to redirect
            set_transient('_mashog_activation_redirect', true, 30);
        }   
}




/**
 * The main function responsible for returning the one true Add-On
 * Instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $MASHOG = MASHOG(); ?>
 *
 * @since 1.0.0
 * @return object The one true MashshareOpenGraph Instance
 *
 * @todo        Inclusion of the activation code below isn't mandatory, but
 *              can prevent any number of errors, including fatal errors, in
 *              situations where this extension is activated but MASHSB is not
 *              present.
 */

function MASHOG() {
	if( ! class_exists( 'Mashshare' ) ) {
        if( ! class_exists( 'MASHOG_Extension_Activation' ) ) {
            require_once 'includes/class.extension-activation.php';
        }
        $activation = new MASHOG_Extension_Activation( plugin_dir_path( __FILE__ ), basename( __FILE__ ) );
        $activation = $activation->run();
        return MashshareOpenGraph::instance();
    } else {
        return MashshareOpenGraph::instance();
    }
}

/**
 * The activation hook is called outside of the singleton because WordPress doesn't
 * register the call from within the class hence, needs to be called outside and the
 * function also needs to be static.
 */
register_activation_hook( __FILE__, array( 'MashshareOpenGraph', 'activation' ) );

// Get MASHOG Running after other plugins loaded
add_action( 'plugins_loaded', 'MASHOG' );
//MASHOG();

endif; // End if class_exists check