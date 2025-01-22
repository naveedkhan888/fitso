<?php

if ( ! class_exists( 'Kirki' ) ) {
	return;
}

add_filter( 'kirki_telemetry', '__return_false' );

$priority = 1;

Kirki::add_config(
	'arts',
	array(
		'capability'  => 'edit_theme_options',
		'option_type' => 'theme_mod',
	)
);

/**
 * Panel General Style
 */
Kirki::add_panel(
	'general-style',
	array(
		'priority' => $priority++,
		'title'    => esc_html__( 'General Style', 'rubenz' ),
		'icon'     => 'dashicons-admin-appearance',
	)
);
get_template_part( '/inc/customizer/panels/general-style/general-style' );

/**
 * Section Header
 */
get_template_part( '/inc/customizer/header/header' );

/**
 * Panel Footer
 */
Kirki::add_panel(
	'footer',
	array(
		'priority' => $priority++,
		'title'    => esc_html__( 'Footer', 'rubenz' ),
		'icon'     => 'dashicons-arrow-down-alt',
	)
);
get_template_part( '/inc/customizer/panels/footer/footer' );

/**
 * Section Portfolio
 */
get_template_part( '/inc/customizer/portfolio/portfolio' );

/**
 * Panel Blog
 */
Kirki::add_panel(
	'blog',
	array(
		'priority' => $priority++,
		'title'    => esc_html__( 'Blog', 'rubenz' ),
		'icon'     => 'dashicons-editor-bold',
	)
);
get_template_part( '/inc/customizer/panels/blog/blog' );

/**
 * Panel Options
 */
Kirki::add_panel(
	'theme_options',
	array(
		'priority' => $priority++,
		'title'    => esc_html__( 'Theme Options', 'rubenz' ),
		'icon'     => 'dashicons-admin-tools',
	)
);
get_template_part( '/inc/customizer/panels/theme-options/theme-options' );

/**
 * Extend Title & Tagline Section
 */
get_template_part( 'inc/customizer/title_tagline/title_tagline' );
