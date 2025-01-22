<?php

/**
 * Register theme locations for Elementor Theme Builder API
 */
add_action( 'elementor/theme/register_locations', 'arts_register_elementor_locations' );
function arts_register_elementor_locations( $elementor_theme_manager ) {
	$elementor_theme_manager->register_location( 'header' );
	$elementor_theme_manager->register_location( 'footer' );
	$elementor_theme_manager->register_location( 'popup' );
	$elementor_theme_manager->register_location( 'single-post' );
	$elementor_theme_manager->register_location( 'single-page' );
}

/**
 * Elementor Pro AJAX compatibility
 * Enforce widgets assets to load on all the pages
 */
add_action( 'elementor_pro/init', 'arts_enqueue_elementor_pro_widgets_assets' );
function arts_enqueue_elementor_pro_widgets_assets() {
	$enable_ajax               = get_theme_mod( 'enable_ajax', false );
	$ajax_load_missing_scripts = get_theme_mod( 'ajax_load_missing_scripts', false );
	$ajax_load_missing_styles  = get_theme_mod( 'ajax_load_missing_styles', false );

	if ( $enable_ajax ) {
		// JS assets
		if ( ! $ajax_load_missing_scripts ) {
			add_action(
				'elementor/frontend/before_enqueue_scripts',
				function() {
					wp_enqueue_script( 'elementor-gallery' ); // Elementor Gallery
					wp_enqueue_script( 'lottie' ); // Elementor Lottie animations
				}
			);
		}
		// CSS assets
		if ( ! $ajax_load_missing_styles ) {
			add_action(
				'elementor/frontend/before_enqueue_styles',
				function() {
					wp_enqueue_style( 'elementor-gallery' ); // Elementor Gallery
				}
			);
		}
	}
}

/**
 * Remove Elementor welcome splash screen
 * on the initial plugin activation
 * This prevents some issues when Merlin wizard
 * installs and activates the required plugins
 */
add_action( 'init', 'arts_remove_elementor_welcome_screen' );
function arts_remove_elementor_welcome_screen() {
	delete_transient( 'elementor_activation_redirect' );
}
