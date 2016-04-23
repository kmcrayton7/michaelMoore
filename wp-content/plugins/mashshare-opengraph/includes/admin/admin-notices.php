<?php
/**
 * Admin admin-notices
 *
 * @package     MASHOG
 * @subpackage  Admin/admin-notices
 * @copyright   Copyright (c) 2014, René Hermenau
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.3
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Admin Messages
 *
 * @since 1.0
 * @global $mashsb_options Array of all the MASHOG Options
 * @return void
 */
function mashog_admin_messages() {
	global $mashsb_options;
        
        if ( is_plugin_active( 'wordpress-seo/wp-seo.php' ) ) {
            $opts = get_option( 'wpseo_social' );
				if ( ! empty( $opts['opengraph'] ) ) {
						$notice = sprintf( __( 'Mashshare Open Graph Add-On Warning: Please uncheck the \'<em>Add Open Graph meta data</em>\' Facebook option in the '.
							'<a href="%s">Yoast WordPress SEO: Social</a> settings.', 'mashog' ), 
							get_admin_url( null, 'admin.php?page=wpseo_social' ) );
                                                		add_settings_error( 'mashog-notices', 'mashog-settings-waring', $notice, 'error' );

				}
        } 

	//settings_errors( 'mashog-notices' );
}
add_action( 'admin_notices', 'mashog_admin_messages' );


/**
 * Dismisses admin notices when Dismiss links are clicked
 *
 * @since 1.8
 * @return void
*/
function mashog_dismiss_notices() {

	$notice = isset( $_GET['mashog_notice'] ) ? $_GET['mashog_notice'] : false;

	if( ! $notice )
		return; // No notice, so get out of here

	update_user_meta( get_current_user_id(), '_mashog_' . $notice . '_dismissed', 1 );

	wp_redirect( remove_query_arg( array( 'mashog_action', 'mashog_notice' ) ) ); exit;

}
add_action( 'mashog_dismiss_notices', 'mashog_dismiss_notices' );
