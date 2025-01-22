<?php

$priority = 1;

Kirki::add_field(
	'arts',
	array(
		'type'        => 'switch',
		'settings'    => 'enable_fix_mobile_vh',
		'label'       => esc_html__( 'Fit Fullscreen Height Elements', 'fitso' ),
		'description' => esc_html__( 'This option calculates the full height elements to fit the entire screen considering the height of bottom navigation bar.', 'fitso' ),
		'section'     => 'layout-general',
		'default'     => true,
		'priority'    => $priority++,
	)
);

Kirki::add_field(
	'arts',
	array(
		'type'            => 'switch',
		'settings'        => 'enable_fix_mobile_vh_update',
		'label'           => esc_html__( 'Update Fullscreen Height Elements on Window Resize', 'fitso' ),
		'description'     => esc_html__( 'Disable to avoid page jump when scrolling on mobile devices.', 'fitso' ),
		'section'         => 'layout-general',
		'default'         => true,
		'priority'        => $priority++,
		'active_callback' => array(
			array(
				'setting'  => 'enable_fix_mobile_vh',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);
