<?php

$priority = 1;

/**
 * Typography
 */
Kirki::add_section(
	'typography',
	array(
		'title'    => esc_html__( 'Typography', 'rubenz' ),
		'panel'    => 'general-style',
		'priority' => $priority ++,
	)
);
get_template_part( '/inc/customizer/panels/general-style/sections/typography' );

/**
 * Layout
 */
Kirki::add_section(
	'layout-general',
	array(
		'title'    => esc_html__( 'Layout', 'rubenz' ),
		'panel'    => 'general-style',
		'priority' => $priority ++,
	)
);
get_template_part( '/inc/customizer/panels/general-style/sections/layout-general' );
