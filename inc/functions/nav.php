<?php

require_once XPERTPOINT_THEME_PATH . '/inc/classes/class-xpertpoint-walker-nav-menu-overlay.php';

/**
 * Register Theme Menus
 *
 * @return void
 */
add_action( 'after_setup_theme', 'xpertpoint_init_navigation' );
function xpertpoint_init_navigation() {
	if ( function_exists( 'register_nav_menus' ) ) {
		register_nav_menus(
			array(
				'main_menu' => esc_html__( 'Main Menu', 'fitso' ),
			)
		);
	}
}
