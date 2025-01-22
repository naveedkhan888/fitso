<?php

$priority = 1;

/**
 * Post Show All Info
 */
Kirki::add_field(
	'arts',
	array(
		'type'        => 'switch',
		'settings'    => 'post_show_info',
		'label'       => esc_html__( 'Show All info', 'rubenz' ),
		'description' => esc_html__( 'Show post information (posted date, author, comments, etc...).', 'rubenz' ),
		'section'     => 'post',
		'default'     => 'on',
		'priority'    => $priority++,
		'choices'     => array(
			true  => esc_html__( 'On', 'rubenz' ),
			false => esc_html__( 'Off', 'rubenz' ),
		),
	)
);

/**
 * Post Date
 */
Kirki::add_field(
	'arts',
	array(
		'type'            => 'checkbox',
		'settings'        => 'post_show_date',
		'label'           => esc_html__( 'Show Date', 'rubenz' ),
		'section'         => 'post',
		'default'         => 'on',
		'priority'        => $priority++,
		'choices'         => array(
			true  => esc_html__( 'On', 'rubenz' ),
			false => esc_html__( 'Off', 'rubenz' ),
		),
		'active_callback' => array(
			array(
				'setting' => 'post_show_info',
				'value'   => true,
			),
		),
	)
);

/**
 * Post Categories
 */
Kirki::add_field(
	'arts',
	array(
		'type'            => 'checkbox',
		'settings'        => 'post_show_categories',
		'label'           => esc_html__( 'Show Categories', 'rubenz' ),
		'section'         => 'post',
		'default'         => 'on',
		'priority'        => $priority++,
		'choices'         => array(
			true  => esc_html__( 'On', 'rubenz' ),
			false => esc_html__( 'Off', 'rubenz' ),
		),
		'active_callback' => array(
			array(
				'setting' => 'post_show_info',
				'value'   => true,
			),
		),
	)
);

/**
 * Post Comments Counter
 */
Kirki::add_field(
	'arts',
	array(
		'type'            => 'checkbox',
		'settings'        => 'post_show_comments_counter',
		'label'           => esc_html__( 'Show Comments Counter', 'rubenz' ),
		'section'         => 'post',
		'default'         => 'on',
		'priority'        => $priority++,
		'choices'         => array(
			true  => esc_html__( 'On', 'rubenz' ),
			false => esc_html__( 'Off', 'rubenz' ),
		),
		'active_callback' => array(
			array(
				'setting' => 'post_show_info',
				'value'   => true,
			),
		),
	)
);

/**
 * Post Author
 */
Kirki::add_field(
	'arts',
	array(
		'type'            => 'checkbox',
		'settings'        => 'post_show_author',
		'label'           => esc_html__( 'Show Author', 'rubenz' ),
		'section'         => 'post',
		'default'         => 'on',
		'priority'        => $priority++,
		'choices'         => array(
			true  => esc_html__( 'On', 'rubenz' ),
			false => esc_html__( 'Off', 'rubenz' ),
		),
		'active_callback' => array(
			array(
				'setting' => 'post_show_info',
				'value'   => true,
			),
		),
	)
);

/**
 * Post Read More Button
 */
Kirki::add_field(
	'arts',
	array(
		'type'            => 'checkbox',
		'settings'        => 'post_show_read_more',
		'label'           => esc_html__( 'Show "More" Button', 'rubenz' ),
		'section'         => 'post',
		'default'         => 'on',
		'priority'        => $priority++,
		'choices'         => array(
			true  => esc_html__( 'On', 'rubenz' ),
			false => esc_html__( 'Off', 'rubenz' ),
		),
		'active_callback' => array(
			array(
				'setting' => 'post_show_info',
				'value'   => true,
			),
		),
	)
);
