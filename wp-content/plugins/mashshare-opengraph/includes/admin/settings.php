<?php

/**
 * Registers the new Mashshare Open Graph options in Extensions
 * *
 * @access      private
 * @since       1.0
 * @param 	$settings array the existing plugin settings
 * @return      array
*/

function mashog_extension_settings( $settings ) {

	$ext_settings = array(
		array(
			'id' => 'mashog_opengraph_header',
			'name' => '<strong>' . __( 'Open Graph General', 'mashog' ) . '</strong>',
			'desc' => '',
			'type' => 'header',
			'size' => 'regular'
		),
		array(
			'id' => 'mashog_default_image',
			'name' => __( 'Default Image URL', 'mashog' ),
			'desc' => __( 'This image is used when no post featured image is defined.', 'mashog' ),
			'type' => 'upload_image'
		),
                array(
			'id' => 'mashog_homepage_header',
			'name' => '<strong>' . __( 'Open Graph Front and Default Page settings', 'mashog' ) . '</strong>',
			'desc' => 'Open Graph Settings for your static home page (front page)',
			'type' => 'header',
			'size' => 'regular'
		),
		array(
			'id' => 'mashog_homepage_title',
			'name' => __( 'Title', 'mashog' ),
			'desc' => __( '', 'mashog' ),
			'type' => 'text',
                        'size' => 'large'
		),
                array(
			'id' => 'mashog_homepage_desc',
			'name' => __( 'Description', 'mashog' ),
			'desc' => __( '', 'mashog' ),
                        'type' => 'textarea',
                        'size' => 5
		),
                array(
			'id' => 'mashog_homepage_type',
			'name' => __( 'Type', 'mashog' ),
			'desc' => __( '(article / blog / website / product etc.)', 'mashog' ),
			'type' => 'text',
                        'size' => 'medium'
		),
                array(
			'id' => 'mashog_homepage_image',
			'name' => __( 'Image URL', 'mashog' ),
			'desc' => __( '', 'mashog' ),
			'type' => 'upload_image'
		),
                array(
			'id' => 'mashog_blog_header',
			'name' => '<strong>' . __( 'Open Graph Blog Page', 'mashog' ) . '</strong>',
			'desc' => 'Open Graph Blog Page (e.g. yoursite.com/blog)',
			'type' => 'header',
			'size' => 'regular'
		),
		array(
			'id' => 'mashog_blog_title',
			'name' => __( 'Title', 'mashog' ),
			'desc' => __( '', 'mashog' ),
			'type' => 'text',
                        'size' => 'large'
		),
                array(
			'id' => 'mashog_blog_desc',
			'name' => __( 'Description', 'mashog' ),
			'desc' => __( '', 'mashog' ),
                        'type' => 'textarea',
                        'size' => 5
		),
                array(
			'id' => 'mashog_blog_type',
			'name' => __( 'Type', 'mashog' ),
			'desc' => __( '(article / blog / website / product etc.)', 'mashog' ),
			'type' => 'text',
                        'size' => 'medium'
		),
                array(
			'id' => 'mashog_blog_image',
			'name' => __( 'Image URL', 'mashog' ),
			'desc' => __( '', 'mashog' ),
			'type' => 'upload_image'
		),
	);

	return array_merge( $settings, $ext_settings );

}
add_filter('mashsb_settings_extension', 'mashog_extension_settings');
