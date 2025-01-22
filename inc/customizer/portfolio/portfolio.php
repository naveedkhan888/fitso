<?php

$priority = 1;

Kirki::add_section(
	'portfolio',
	array(
		'title'    => esc_html__( 'Portfolio', 'rubenz' ),
		'priority' => $priority ++,
		'icon'     => 'dashicons-art',
	)
);

Kirki::add_field(
	'arts',
	array(
		'type'     => 'switch',
		'settings' => 'enable_custom_portfolio_slug',
		'label'    => esc_html__( 'Enable custom portfolio slug', 'rubenz' ),
		'section'  => 'portfolio',
		'default'  => true,
		'priority' => $priority++,
	)
);

Kirki::add_field(
	'arts',
	array(
		'type'            => 'generic',
		'description'     => sprintf(
			'%1$s <a href="%2$s" target="_blank">%3$s</a>',
			esc_html__( 'To customize the portfolio post slug please use this free WordPress plugin:', 'rubenz' ),
			esc_url( 'https://wordpress.org/plugins/simple-post-type-permalinks/' ),
			esc_html__( 'Simple Post Type Permalinks', 'rubenz' )
		),
		'settings'        => 'portfolio_generic_heading' . $priority,
		'section'         => 'portfolio',
		'priority'        => $priority++,
		'choices'         => array(
			'element' => 'span',
		),
		'active_callback' => array(
			array(
				'setting' => 'enable_custom_portfolio_slug',
				'value'   => true,
			),
		),
	)
);

Kirki::add_field(
	'arts',
	array(
		'type'     => 'switch',
		'settings' => 'enable_portfolio_nav',
		'label'    => esc_html__( 'Show prev / next portfolio navigation on portfolio item pages', 'rubenz' ),
		'section'  => 'portfolio',
		'default'  => true,
		'priority' => $priority++,
	)
);

Kirki::add_field(
	'arts',
	array(
		'type'            => 'checkbox',
		'settings'        => 'enable_portfolio_loop',
		'label'           => esc_html__( 'Loop the portfolio navigation', 'rubenz' ),
		'section'         => 'portfolio',
		'default'         => true,
		'priority'        => $priority++,
		'active_callback' => array(
			array(
				'setting'  => 'enable_portfolio_nav',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

Kirki::add_field(
	'arts',
	array(
		'type'            => 'checkbox',
		'settings'        => 'enable_portfolio_next_first_mobile',
		'label'           => esc_html__( 'Position "next" portfolio item before "previous" on mobile', 'rubenz' ),
		'section'         => 'portfolio',
		'default'         => false,
		'priority'        => $priority++,
		'active_callback' => array(
			array(
				'setting'  => 'enable_portfolio_nav',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

Kirki::add_field(
	'arts',
	array(
		'type'            => 'text',
		'settings'        => 'portfolio_nav_prev_title',
		'label'           => esc_html__( '"Previous" label', 'rubenz' ),
		'section'         => 'portfolio',
		'default'         => esc_html__( 'Prev', 'rubenz' ),
		'priority'        => $priority++,
		'active_callback' => array(
			array(
				'setting'  => 'enable_portfolio_nav',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

Kirki::add_field(
	'arts',
	array(
		'type'            => 'text',
		'settings'        => 'portfolio_nav_next_title',
		'label'           => esc_html__( '"Next" label', 'rubenz' ),
		'section'         => 'portfolio',
		'default'         => esc_html__( 'Next', 'rubenz' ),
		'priority'        => $priority++,
		'active_callback' => array(
			array(
				'setting'  => 'enable_portfolio_nav',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);
