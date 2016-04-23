<?php
/**
 * Scripts
 *
 * @package     MASHOG
 * @subpackage  Functions
 * @copyright   Copyright (c) 2014, René Hermenau
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Load Scripts
 *
 * Enqueues the required scripts.
 *
 * @since 1.0.0
 * @global $mashog_options
 * @global $post
 * @return void
 */
function mashog_load_scripts($hook) {
    
        if ( ! apply_filters( 'mashsga_load_scripts', mashogGetActiveStatus(), $hook ) ) {
            //echo "disabled";
            return;
	}
    
	global $mashsb_options;
            
	$js_dir = MASHOG_PLUGIN_URL . 'assets/js/';
        if ($mashsb_options['analytics_code'] == 'classic'){
                    $js_title = 'mashog_classic';
        }else 
        {
                    $js_title = 'mashog';
        }

	// Use minified libraries if SCRIPT_DEBUG is turned off
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
        //echo $js_dir . $js_title . $suffix . '.js';
        isset($mashsb_options['load_scripts_footer']) ? $in_footer = true : $in_footer = false;   
	wp_enqueue_script( 'mashog', $js_dir . $js_title . $suffix . '.js', array( 'jquery' ), MASHOG_VERSION, $in_footer );             
}
//add_action( 'wp_enqueue_scripts', 'mashog_load_scripts' );

/**
 * Register Styles
 *
 * Checks the styles option and hooks the required filter.
 *
 * @since 1.0.0
 * @global $mashog_options
 * @return void
 */
function mashog_register_styles() {
	global $mashog_options;

	if ( isset( $mashog_options['disable_styles'] ) ) {
		return;
	}

	// Use minified libraries if SCRIPT_DEBUG is turned off
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	$file          = 'mashog' . $suffix . '.css';

	$url = trailingslashit( plugins_url(). '/mashshare/templates/'    ) . $file;
	wp_enqueue_style( 'mashog-styles', $url, array(), MASHOG_VERSION );
}
//add_action( 'wp_enqueue_scripts', 'mashog_register_styles' );

    /* Returns active status of MASHOG
     * Used for scripts.php $hook
     * @since 2.0.3
     * @return bool True if post.php is open
     */
   
    function mashogGetActiveStatus(){
        global $pagenow;
        if(is_admin() && $pagenow=='post.php' ){
        return true;
        }
    }

/**
 * Load Admin Scripts
 *
 * Enqueues the required admin scripts.
 *
 * @since 1.0.0
 * @global $post
 * @param string $hook Page hook
 * @return void
 */

function mashog_load_admin_scripts( $hook ) {
	if (! apply_filters( 'mashog_load_admin_scripts', mashogGetActiveStatus(), $hook ) ) {
		return;
	}

	global $wp_version;

	$js_dir  = MASHOG_PLUGIN_URL . 'assets/js/';
	$css_dir = MASHOG_PLUGIN_URL . 'assets/css/';

	// Use minified libraries if SCRIPT_DEBUG is turned off
	$suffix  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
        //echo $css_dir . 'mashog-admin' . $suffix . '.css', MASHOG_VERSION;
	// These have to be global
	wp_enqueue_script( 'mashog-admin-scripts', $js_dir . 'mashog_admin' . $suffix . '.js', array( 'jquery' ), MASHOG_VERSION, false );
	//wp_enqueue_style( 'mashog-admin', $css_dir . 'mashog_admin' . $suffix . '.css', MASHOG_VERSION );
}
add_action( 'admin_enqueue_scripts', 'mashog_load_admin_scripts', 100 );