<?php

$priority    = 1;
$max_columns = 8;

/**
 * Footer Container
 */
Kirki::add_field(
	'rubenz',
	array(
		'type'      => 'radio-buttonset',
		'settings'  => 'footer_container',
		'label'     => esc_html__( 'Container', 'rubenz' ),
		'section'   => 'layout',
		'default'   => 'container-fluid',
		'priority'  => $priority++,
		'choices'   => array(
			'container-fluid' => esc_html__( 'Fullwidth', 'rubenz' ),
			'container'       => esc_html__( 'Boxed', 'rubenz' ),
		),
		'transport' => 'postMessage',
	)
);

/**
 * Footer Layout
 */
Kirki::add_field(
	'rubenz',
	array(
		'type'        => 'slider',
		'settings'    => 'footer_columns',
		'label'       => esc_html__( 'Number of Columns', 'rubenz' ),
		'description' => esc_html__( 'This setting creates a widget area per each column. You can edit your widgets in WordPress admin panel.', 'rubenz' ),
		'section'     => 'layout',
		'default'     => 3,
		'priority'    => $priority++,
		'choices'     => array(
			'min'  => '1',
			'max'  => $max_columns,
			'step' => '1',
		),
		'transport'   => 'refresh',
	)
);

/**
 * Mobile Ordering Info
 */
Kirki::add_field(
	'rubenz',
	array(
		'type'            => 'custom',
		'settings'        => 'footer_columns_info',
		'label'           => esc_html__( 'Mobile Columns Stack Order', 'rubenz' ),
		'description'     => esc_html__( 'You can control how your columns stack on mobile screens. For example, you can place copyright column very first on desktop and reorder it as very last on mobile.', 'rubenz' ),
		'section'         => 'layout',
		'priority'        => $priority++,
		'active_callback' => array(
			array(
				'setting'  => 'footer_columns',
				'operator' => '>',
				'value'    => '1',
			),
		),
	)
);

/**
 * Mobile Column Order
 */

for ( $i = 1; $i <= $max_columns; $i++ ) {

	$descr = sprintf( '%1$s (%2$s %3$s)', esc_html__( 'Mobile Order', 'rubenz' ), esc_html__( 'Column', 'rubenz' ), $i );

	Kirki::add_field(
		'rubenz',
		array(
			'type'            => 'slider',
			'settings'        => 'order_column_' . $i,
			'description'     => $descr,
			'section'         => 'layout',
			'default'         => 1,
			'priority'        => $priority++,
			'choices'         => array(
				'min'  => '1',
				'max'  => $max_columns,
				'step' => '1',
			),
			'active_callback' => array(
				array(
					'setting'  => 'footer_columns',
					'operator' => '>=',
					'value'    => $i,
				),
				array(
					'setting'  => 'footer_columns',
					'operator' => '!=',
					'value'    => 1,
				),
			),
		)
	);

}
