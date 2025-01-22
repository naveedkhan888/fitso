<?php

$priority = 1;

Kirki::add_field(
	'arts',
	array(
		'type'     => 'switch',
		'settings' => 'enable_smooth_scroll',
		'label'    => esc_html__( 'Enable Page Smooth Scroll', 'rubenz' ),
		'section'  => 'smooth_scroll',
		'default'  => false,
		'priority' => $priority++,
	)
);

Kirki::add_field(
	'arts',
	array(
		'type'            => 'checkbox',
		'settings'        => 'smooth_scroll_elementor_canvas_template_enabled',
		'label'           => esc_html__( 'Enable on Elementor Canvas Pages ', 'rubenz' ),
		'section'         => 'smooth_scroll',
		'default'         => true,
		'priority'        => $priority++,
		'active_callback' => array(
			array(
				'setting'  => 'enable_smooth_scroll',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

Kirki::add_field(
	'arts',
	array(
		'type'            => 'switch',
		'settings'        => 'enable_smooth_scroll_mobile',
		'label'           => esc_html__( 'Enable Page Smooth Scroll on Touch Devices', 'rubenz' ),
		'description'     => esc_html__( 'This option is NOT recommended as it replaces native momentum scroll experience. Use with caution!', 'rubenz' ),
		'section'         => 'smooth_scroll',
		'default'         => false,
		'priority'        => $priority++,
		'active_callback' => array(
			array(
				'setting'  => 'enable_smooth_scroll',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

Kirki::add_field(
	'arts',
	array(
		'type'            => 'number',
		'settings'        => 'smooth_scroll_damping',
		'label'           => esc_html__( 'Damping', 'rubenz' ),
		'description'     => esc_html__( 'The lower the value is, the more smooth the scrolling will be.', 'rubenz' ),
		'tooltip'         => esc_html__( 'A float value between 0.0 and 1.0 defining the momentum reduction damping factor.', 'rubenz' ),
		'section'         => 'smooth_scroll',
		'default'         => 0.06,
		'priority'        => $priority++,
		'choices'         => array(
			'min'  => 0,
			'max'  => 1,
			'step' => 0.01,
		),
		'active_callback' => array(
			array(
				'setting'  => 'enable_smooth_scroll',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

Kirki::add_field(
	'arts',
	array(
		'type'            => 'switch',
		'settings'        => 'smooth_scroll_render_by_pixels',
		'label'           => esc_html__( 'Enable Render by Pixels', 'rubenz' ),
		'description'     => esc_html__( 'Render every frame in integer pixel values, set to true to improve scrolling performance.', 'rubenz' ),
		'section'         => 'smooth_scroll',
		'default'         => true,
		'priority'        => $priority++,
		'active_callback' => array(
			array(
				'setting'  => 'enable_smooth_scroll',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

Kirki::add_field(
	'arts',
	array(
		'type'            => 'switch',
		'settings'        => 'smooth_scroll_plugin_easing',
		'label'           => esc_html__( 'Enable Edge Easing', 'rubenz' ),
		'description'     => esc_html__( 'The scroll will slow down with ease when reaching the page edges.', 'rubenz' ),
		'section'         => 'smooth_scroll',
		'default'         => false,
		'priority'        => $priority++,
		'active_callback' => array(
			array(
				'setting'  => 'enable_smooth_scroll',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);
