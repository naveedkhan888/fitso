<?php

$priority = 1;

/**
 * 404 Preview Link
 */
Kirki::add_field(
	'arts',
	array(
		'type'     => 'generic',
		'settings' => '404_preview_link',
		'label'    => esc_html__( 'Preview', 'rubenz' ),
		'section'  => '404',
		'priority' => $priority++,
		'default'  => esc_html__( 'Load Page', 'rubenz' ),
		'choices'  => array(
			'element' => 'input',
			'type'    => 'button',
			'class'   => 'button button-secondary',
			'onclick' => 'javascript:wp.customize.previewer.previewUrl.set( "../not-found-" + String( Math.random() ) + "/" );',
		),
	)
);

/**
 * 404 Title
 */
Kirki::add_field(
	'arts',
	array(
		'type'      => 'text',
		'settings'  => '404_title',
		'label'     => esc_html__( 'Title', 'rubenz' ),
		'section'   => '404',
		'default'   => esc_html__( 'Page not Found', 'rubenz' ),
		'priority'  => $priority++,
		'transport' => 'postMessage',
	)
);

/**
 * 404 Message
 */
Kirki::add_field(
	'arts',
	array(
		'type'      => 'textarea',
		'settings'  => '404_message',
		'label'     => esc_html__( 'Message', 'rubenz' ),
		'section'   => '404',
		'default'   => esc_html__( 'It looks like nothing found here. Try to navigate the menu or return to the home page.', 'rubenz' ),
		'priority'  => $priority++,
		'transport' => 'postMessage',
	)
);

/**
 * 404 Big
 */
Kirki::add_field(
	'arts',
	array(
		'type'      => 'text',
		'settings'  => '404_big',
		'label'     => esc_html__( 'Big Text', 'rubenz' ),
		'section'   => '404',
		'default'   => esc_html__( '404', 'rubenz' ),
		'priority'  => $priority++,
		'transport' => 'postMessage',
	)
);

/**
 * 404 Button
 */
Kirki::add_field(
	'arts',
	array(
		'type'      => 'text',
		'settings'  => '404_button',
		'label'     => esc_html__( 'Button Text', 'rubenz' ),
		'section'   => '404',
		'default'   => esc_html__( 'Back to home page', 'rubenz' ),
		'priority'  => $priority++,
		'transport' => 'postMessage',
	)
);
