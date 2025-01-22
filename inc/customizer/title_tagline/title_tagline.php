<?php

$priority = 9;

$lg = intval( get_option( 'elementor_viewport_lg', 992 ) );
$md = intval( get_option( 'elementor_viewport_md', 768 ) );
$sm = intval( get_option( 'elementor_viewport_sm', 480 ) );

/**
 * Retina Logo
 */
Kirki::add_field(
	'arts',
	array(
		'type'            => 'image',
		'settings'        => 'custom_logo_retina_url',
		'label'           => esc_html__( 'Retina Logo', 'rubenz' ),
		'description'     => esc_html__( 'Upload site logo in @2x resolution for smooth display on high-dpi screens.', 'rubenz' ),
		'section'         => 'title_tagline',
		'default'         => '',
		'priority'        => $priority,
		'active_callback' => array(
			array(
				'setting'  => 'custom_logo',
				'operator' => '!=',
				'value'    => false,
			),
		),
	)
);

/**
 * Logo Max Height Desktop
 */
Kirki::add_field(
	'arts',
	array(
		'type'            => 'slider',
		'settings'        => 'custom_logo_max_height',
		'label'           => esc_html__( 'Logo Max Height', 'rubenz' ),
		'description'     => esc_html__( 'Desktop screens', 'rubenz' ),
		'section'         => 'title_tagline',
		'default'         => 80,
		'choices'         => array(
			'min'  => 0,
			'max'  => 512,
			'step' => 1,
		),
		'priority'        => $priority,
		'transport'       => 'auto',
		'output'          => array(
			array(
				'element'     => '.logo__wrapper-img img',
				'property'    => 'height',
				'units'       => 'px',
				'media_query' => '@media (min-width: ' . $md++ . 'px)',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'custom_logo',
				'operator' => '!=',
				'value'    => false,
			),
		),
	)
);

/**
 * Logo Max Height Tablet
 */
Kirki::add_field(
	'arts',
	array(
		'type'            => 'slider',
		'settings'        => 'custom_logo_max_height_tablet',
		'label'           => esc_html__( 'Logo Max Height', 'rubenz' ),
		'description'     => sprintf(
			'%1s %2s%3s %4s',
			esc_html__( 'Tablet screens', 'rubenz' ),
			esc_attr( $md ),
			esc_html__( 'px', 'rubenz' ),
			esc_html__( 'and lower', 'rubenz' )
		),
		'section'         => 'title_tagline',
		'default'         => 80,
		'choices'         => array(
			'min'  => 0,
			'max'  => 512,
			'step' => 1,
		),
		'priority'        => $priority,
		'transport'       => 'auto',
		'output'          => array(
			array(
				'element'     => '.logo__wrapper-img img',
				'property'    => 'height',
				'units'       => 'px',
				'media_query' => '@media (max-width: ' . $md . 'px)',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'custom_logo',
				'operator' => '!=',
				'value'    => false,
			),
		),
	)
);

/**
 * Logo Max Height Mobile
 */
Kirki::add_field(
	'arts',
	array(
		'type'            => 'slider',
		'settings'        => 'custom_logo_max_height_mobile',
		'label'           => esc_html__( 'Logo Max Height', 'rubenz' ),
		'description'     => sprintf(
			'%1s %2s%3s %4s',
			esc_html__( 'Mobile screens', 'rubenz' ),
			esc_attr( $sm ),
			esc_html__( 'px', 'rubenz' ),
			esc_html__( 'and lower', 'rubenz' )
		),
		'section'         => 'title_tagline',
		'default'         => 80,
		'choices'         => array(
			'min'  => 0,
			'max'  => 512,
			'step' => 1,
		),
		'priority'        => $priority,
		'transport'       => 'auto',
		'output'          => array(
			array(
				'element'     => '.logo__wrapper-img img',
				'property'    => 'height',
				'units'       => 'px',
				'media_query' => '@media (max-width: ' . $sm . 'px)',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'custom_logo',
				'operator' => '!=',
				'value'    => false,
			),
		),
	)
);

