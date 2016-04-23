<?php
/**
 * Admin Plugins
 *
 * @package     MASHOG
 * @subpackage  Admin/Plugins
 * @copyright   Copyright (c) 2014, René Hermenau
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Plugins row action links
 *
 * @author Michael Cannon <mc@aihr.us>
 * @since 1.0
 * @param array $links already defined action links
 * @param string $file plugin file path and name being processed
 * @return array $links
 */
function mashog_plugin_action_links( $links, $file ) {
	$settings_link = '<a href="' . admin_url( 'admin.php?page=mashsb-settings&tab=extensions' ) . '">' . esc_html__( 'General Settings', 'mashog' ) . '</a>';
	if ( $file == 'mashshare-opengraph/mashshare-opengraph.php' )
		array_unshift( $links, $settings_link );

	return $links;
}
add_filter( 'plugin_action_links', 'mashog_plugin_action_links', 10, 2 );


/**
 * Plugin row meta links
 *
 * @author Michael Cannon <mc@aihr.us>
 * @since 2.0
 * @param array $input already defined meta links
 * @param string $file plugin file path and name being processed
 * @return array $input
 */
function mashog_plugin_row_meta( $input, $file ) {
	if ( $file != 'mashshare/mashshare.php' )
		return $input;

	$links = array(
		'<a href="' . admin_url( 'options-general.php?page=mashog-settings' ) . '">' . esc_html__( 'Getting Started', 'mashog' ) . '</a>',
		'<a href="https://www.mashshare.net/downloads/">' . esc_html__( 'Add Ons', 'mashog' ) . '</a>',
	);

	$input = array_merge( $input, $links );

	return $input;
}
add_filter( 'plugin_row_meta', 'mashog_plugin_row_meta', 10, 2 );