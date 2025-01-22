<?php

$priority = 1;

/**
 * Sidebar Position
 */
Kirki::add_field(
	'arts',
	array(
		'type'        => 'radio-buttonset',
		'settings'    => 'sidebar_position',
		'label'       => esc_html__( 'Sidebar Position', 'fitso' ),
		'description' => esc_html__( ' This option has an effect only on desktop. On mobile the sidebar is always below the content.', 'fitso' ),
		'tooltip'     => esc_html__( 'You can also disable blog sidebar from the admin panel by removing all the widgets that it contains.', 'fitso' ),
		'section'     => 'sidebar',
		'default'     => 'right_side',
		'priority'    => $priority++,
		'choices'     => array(
			'left_side'  => esc_html__( 'Left Side', 'fitso' ),
			'right_side' => esc_html__( 'Right Side', 'fitso' ),
		),
		'transport'   => 'postMessage',
	)
);
