<?php

$priority = 1;

Kirki::add_section(
	'header',
	array(
		'title'    => esc_html__( 'Header', 'fitso' ),
		'priority' => $priority ++,
		'icon'     => 'dashicons-arrow-up-alt',
	)
);

Kirki::add_field(
	'fitso',
	array(
		'type'      => 'radio-buttonset',
		'settings'  => 'header_container',
		'label'     => esc_html__( 'Container', 'fitso' ),
		'section'   => 'header',
		'default'   => 'container-fluid',
		'priority'  => $priority++,
		'choices'   => array(
			'container-fluid' => esc_html__( 'Fullwidth', 'fitso' ),
			'container'       => esc_html__( 'Boxed', 'fitso' ),
		),
		'transport' => 'postMessage',
	)
);

Kirki::add_field(
	'xpertpoint',
	array(
		'type'     => 'radio-buttonset',
		'settings' => 'header_position',
		'label'    => esc_html__( 'Position', 'fitso' ),
		'section'  => 'header',
		'default'  => 'header_fixed',
		'priority' => $priority++,
		'choices'  => array(
			'header_absolute' => esc_html__( 'Absolute', 'fitso' ),
			'header_fixed'    => esc_html__( 'Fixed', 'fitso' ),
		),
	)
);


Kirki::add_field(
	'xpertpoint',
	array(
		'type'        => 'radio-buttonset',
		'settings'    => 'menu_style',
		'label'       => esc_html__( 'Menu', 'fitso' ),
		'description' => esc_html__( 'This option has an effect only on desktop. On mobile there is always a fullscreen overlay menu.', 'fitso' ),
		'section'     => 'header',
		'default'     => 'classic',
		'priority'    => $priority++,
		'choices'     => array(
			'classic'    => esc_html__( 'Classic', 'fitso' ),
			'fullscreen' => esc_html__( 'Fullscreen', 'fitso' ),
		),
	)
);

Kirki::add_field(
	'xpertpoint',
	array(
		'type'        => 'switch',
		'settings'    => 'enhance_header_contrast',
		'label'       => esc_html__( 'Header Smart Contrast', 'fitso' ),
		'description' => esc_html__( 'Not recommended for "Classic" menu style if you have submenus.', 'fitso' ),
		'section'     => 'header',
		'default'     => true,
		'priority'    => $priority++,
	)
);
