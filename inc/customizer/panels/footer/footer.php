<?php

$priority = 1;

/**
 * Section Layout
 */
Kirki::add_section(
	'layout',
	array(
		'title'    => esc_html__( 'Layout', 'rubenz' ),
		'priority' => $priority ++,
		'panel'    => 'footer',
	)
);
get_template_part( '/inc/customizer/panels/footer/sections/layout' );
