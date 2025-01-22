<?php

$priority = 1;

Kirki::add_section(
	'header',
	array(
		'title'    => esc_html__( 'Header', 'rubenz' ),
		'priority' => $priority ++,
		'icon'     => 'dashicons-arrow-up-alt',
	)
);

Kirki::add_field(
	'rubenz',
	array(
		'type'      => 'radio-buttonset',
		'settings'  => 'header_container',
		'label'     => esc_html__( 'Container', 'rubenz' ),
		'section'   => 'header',
		'default'   => 'container-fluid',
		'priority'  => $priority++,
		'choices'   => array(
			'container-fluid' => esc_html__( 'Fullwidth', 'rubenz' ),
			'container'       => esc_html__( 'Boxed', 'rubenz' ),
		),
		'transport' => 'postMessage',
	)
);

Kirki::add_field(
	'arts',
	array(
		'type'     => 'radio-buttonset',
		'settings' => 'header_position',
		'label'    => esc_html__( 'Position', 'rubenz' ),
		'section'  => 'header',
		'default'  => 'header_fixed',
		'priority' => $priority++,
		'choices'  => array(
			'header_absolute' => esc_html__( 'Absolute', 'rubenz' ),
			'header_fixed'    => esc_html__( 'Fixed', 'rubenz' ),
		),
	)
);


Kirki::add_field(
	'arts',
	array(
		'type'        => 'radio-buttonset',
		'settings'    => 'menu_style',
		'label'       => esc_html__( 'Menu', 'rubenz' ),
		'description' => esc_html__( 'This option has an effect only on desktop. On mobile there is always a fullscreen overlay menu.', 'rubenz' ),
		'section'     => 'header',
		'default'     => 'classic',
		'priority'    => $priority++,
		'choices'     => array(
			'classic'    => esc_html__( 'Classic', 'rubenz' ),
			'fullscreen' => esc_html__( 'Fullscreen', 'rubenz' ),
		),
	)
);

Kirki::add_field(
	'arts',
	array(
		'type'        => 'switch',
		'settings'    => 'enhance_header_contrast',
		'label'       => esc_html__( 'Header Smart Contrast', 'rubenz' ),
		'description' => esc_html__( 'Not recommended for "Classic" menu style if you have submenus.', 'rubenz' ),
		'section'     => 'header',
		'default'     => true,
		'priority'    => $priority++,
	)
);
