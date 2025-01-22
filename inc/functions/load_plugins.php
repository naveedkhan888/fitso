<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1 for parent theme Rubenz for publication on ThemeForest
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once ARTS_THEME_PATH . '/inc/classes/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'arts_register_required_plugins' );
function arts_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
		array(
			'name'     => esc_html__( 'Advanced Custom Fields PRO', 'rubenz' ),
			'slug'     => 'advanced-custom-fields-pro',
			'source'   => esc_url( 'https://artemsemkin.com/wp-json/edd/v1/file/acf-pro/plugin' ),
			'required' => true,
		),
		array(
			'name'     => esc_html__( 'Contact Form 7', 'rubenz' ),
			'slug'     => 'contact-form-7',
			'required' => false,
		),

		array(
			'name'     => esc_html__( 'Elementor', 'rubenz' ),
			'slug'     => 'elementor',
			'required' => true,
		),
		array(
			'name'     => esc_html__( 'Kirki', 'rubenz' ),
			'slug'     => 'kirki',
			'required' => true,
		),
		array(
			'name'     => esc_html__( 'Intuitive Custom Post Order', 'rubenz' ),
			'slug'     => 'intuitive-custom-post-order',
			'required' => false,
		),
		array(
			'name'     => esc_html__( 'Rubenz Core', 'rubenz' ),
			'slug'     => 'rubenz-core',
			'source'   => esc_url( 'https://artemsemkin.com/wp-json/edd/v1/file/' . ARTS_THEME_SLUG . '/core-plugin' ),
			'required' => true,
			'version'  => '3.1.0',
		),
	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 */
	$config = array(
		'id'           => 'rubenz',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}
