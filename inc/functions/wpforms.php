<?php

/**
 * WPForms: Force enable "Load Assets Globally" option if AJAX is on
 */
add_filter( 'wpforms_global_assets', 'arts_wp_forms_force_load_global_assets' );
function arts_wp_forms_force_load_global_assets( $value ) {
	return get_theme_mod( 'enable_ajax', false ) ? true : $value;
}
