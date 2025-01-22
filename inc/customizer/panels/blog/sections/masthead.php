<?php

$priority = 1;

/**
 * Masthead Layout
 */
Kirki::add_field(
	'arts',
	array(
		'type'     => 'select',
		'settings' => 'masthead_style',
		'label'    => esc_html__( 'Style', 'rubenz' ),
		'section'  => 'blog_masthead',
		'default'  => '',
		'priority' => $priority++,
		'choices'  => array(
			'solid_color'      => esc_html__( 'Solid Color', 'rubenz' ),
			'background_image' => esc_html__( 'Post Featured Image as Background', 'rubenz' ),
		),
	)
);

/**
 * Content Alignment
 */
Kirki::add_field(
	'arts',
	array(
		'type'     => 'radio-buttonset',
		'settings' => 'masthead_alignment',
		'label'    => esc_html__( 'Content Alignment', 'rubenz' ),
		'section'  => 'blog_masthead',
		'default'  => 'text-left',
		'priority' => $priority++,
		'choices'  => array(
			'text-left'   => esc_html__( 'Left', 'rubenz' ),
			'text-center' => esc_html__( 'Center', 'rubenz' ),
			'text-right'  => esc_html__( 'Right', 'rubenz' ),
		),
	)
);

Kirki::add_field(
	'arts',
	array(
		'type'            => 'slider',
		'settings'        => 'masthead_overlay_opacity',
		'label'           => esc_html__( 'Image Overlay Opacity', 'rubenz' ),
		'section'         => 'blog_masthead',
		'default'         => 0.60,
		'priority'        => $priority++,
		'choices'         => array(
			'min'  => 0.00,
			'max'  => 1.00,
			'step' => 0.01,
		),
		'transport'       => 'auto',
		'output'          => array(
			array(
				'element'  => '.section-masthead_blog .section-masthead__overlay',
				'property' => 'opacity',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'masthead_style',
				'operator' => '==',
				'value'    => 'background_image',
			),
		),
	)
);

Kirki::add_field(
	'arts',
	array(
		'type'            => 'switch',
		'settings'        => 'masthead_image_parallax',
		'label'           => esc_html__( 'Enable Parallax', 'rubenz' ),
		'section'         => 'blog_masthead',
		'default'         => true,
		'priority'        => $priority++,
		'active_callback' => array(
			array(
				'setting'  => 'masthead_style',
				'operator' => '==',
				'value'    => 'background_image',
			),
		),
	)
);

Kirki::add_field(
	'arts',
	array(
		'type'            => 'slider',
		'settings'        => 'masthead_image_parallax_speed',
		'label'           => esc_html__( 'Parallax Speed', 'rubenz' ),
		'section'         => 'blog_masthead',
		'default'         => 0.1,
		'priority'        => $priority++,
		'choices'         => array(
			'min'  => -0.50,
			'max'  => 0.50,
			'step' => 0.01,
		),
		'active_callback' => array(
			array(
				'setting'  => 'masthead_style',
				'operator' => '==',
				'value'    => 'background_image',
			),
			array(
				'setting'  => 'masthead_image_parallax',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);
