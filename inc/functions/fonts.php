<?php

require_once XPERTPOINT_THEME_PATH . '/inc/classes/class-xpertpoint-add-custom-fonts.php';

/**
 * Create Instance
 */
function xpertpoint_add_custom_fonts() {
	return Xpertpoint_Add_Custom_Fonts::instance();
}
xpertpoint_add_custom_fonts();

/**
 * Add custom fonts choice
 */
function xpertpoint_add_custom_choice() {
	return array(
		'fonts' => apply_filters( 'xpertpoint/kirki_font_choices', array() ),
	);
}


/**
 * Force Load all fonts variations (Kirki)
 */
add_action( 'after_setup_theme', 'xpertpoint_font_add_all_variants', 100 );
function xpertpoint_font_add_all_variants() {
	$force_load_all_fonts_variations = get_theme_mod( 'force_load_all_fonts_variations', false );

	if ( class_exists( 'Kirki_Fonts_Google' ) && $force_load_all_fonts_variations ) {
		Kirki_Fonts_Google::$force_load_all_variants = true;
	}
}
