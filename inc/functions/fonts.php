<?php

require_once ARTS_THEME_PATH . '/inc/classes/class-arts-add-custom-fonts.php';

/**
 * Create Instance
 */
function arts_add_custom_fonts() {
	return Arts_Add_Custom_Fonts::instance();
}
arts_add_custom_fonts();

/**
 * Add custom fonts choice
 */
function arts_add_custom_choice() {
	return array(
		'fonts' => apply_filters( 'arts/kirki_font_choices', array() ),
	);
}


/**
 * Force Load all fonts variations (Kirki)
 */
add_action( 'after_setup_theme', 'arts_font_add_all_variants', 100 );
function arts_font_add_all_variants() {
	$force_load_all_fonts_variations = get_theme_mod( 'force_load_all_fonts_variations', false );

	if ( class_exists( 'Kirki_Fonts_Google' ) && $force_load_all_fonts_variations ) {
		Kirki_Fonts_Google::$force_load_all_variants = true;
	}
}
