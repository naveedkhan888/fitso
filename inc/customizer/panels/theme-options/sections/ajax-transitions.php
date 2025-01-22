<?php

$priority = 1;

Kirki::add_field(
	'arts',
	array(
		'type'     => 'switch',
		'settings' => 'enable_ajax',
		'label'    => esc_html__( 'Enable Seamless AJAX Transitions', 'rubenz' ),
		'section'  => 'ajax_transitions',
		'default'  => false,
		'priority' => $priority++,
	)
);

/**
 * AJAX Loading Spinner
 */
Kirki::add_field(
	'arts',
	array(
		'type'            => 'generic',
		'label'           => esc_html__( 'AJAX Loading Spinner', 'rubenz' ),
		'settings'        => 'ajax_generic_heading' . $priority,
		'section'         => 'ajax_transitions',
		'priority'        => $priority++,
		'choices'         => array(
			'element' => 'span',
		),
		'active_callback' => array(
			array(
				'setting'  => 'enable_ajax',
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
		'settings'        => 'enable_spinner_desktop',
		'label'           => esc_html__( 'Enable on desktops', 'rubenz' ),
		'section'         => 'ajax_transitions',
		'default'         => false,
		'priority'        => $priority++,
		'active_callback' => array(
			array(
				'setting'  => 'enable_ajax',
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
		'settings'        => 'enable_spinner_mobile',
		'label'           => esc_html__( 'Enable on mobiles', 'rubenz' ),
		'section'         => 'ajax_transitions',
		'default'         => true,
		'priority'        => $priority++,
		'active_callback' => array(
			array(
				'setting'  => 'enable_ajax',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

Kirki::add_field(
	'arts',
	array(
		'type'     => 'generic',
		'settings' => 'ajax_transitions_generic_divider' . $priority,
		'section'  => 'ajax_transitions',
		'priority' => $priority++,
		'choices'  => array(
			'element' => 'hr',
		),
	)
);

Kirki::add_field(
	'arts',
	array(
		'type'            => 'textarea',
		'settings'        => 'ajax_prevent_rules',
		'label'           => esc_html__( 'Prevent elements from being AJAX triggered', 'rubenz' ),
		'description'     => esc_html__( 'jQuery selectors. Example: [data-elementor-open-lightbox], .myPreventClass', 'rubenz' ),
		'section'         => 'ajax_transitions',
		'priority'        => $priority++,
		'active_callback' => array(
			array(
				'setting'  => 'enable_ajax',
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
		'settings'        => 'ajax_prevent_header_widgets',
		'label'           => esc_html__( 'Prevent header widget area', 'rubenz' ),
		'section'         => 'ajax_transitions',
		'default'         => false,
		'priority'        => $priority++,
		'active_callback' => array(
			array(
				'setting'  => 'enable_ajax',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

if ( class_exists( 'woocommerce' ) && function_exists( 'arts_get_woocommerce_urls' ) ) {
	Kirki::add_field(
		'arts',
		array(
			'type'            => 'checkbox',
			'settings'        => 'ajax_prevent_woocommerce_pages',
			'label'           => esc_html__( 'Prevent WooCommerce Pages', 'rubenz' ),
			'section'         => 'ajax_transitions',
			'default'         => false,
			'priority'        => $priority++,
			'active_callback' => array(
				array(
					'setting'  => 'enable_ajax',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	Kirki::add_field(
		'arts',
		array(
			'type'            => 'generic',
			'description'     => sprintf(
				'%1s:<br><br><strong>%2s</strong>',
				esc_html__( 'WooCommerce pages with the following URL base will be excluded from AJAX transitions', 'rubenz' ),
				implode( '<br>', arts_get_woocommerce_urls() )
			),
			'settings'        => 'ajax_transitions_generic_heading' . $priority,
			'section'         => 'ajax_transitions',
			'priority'        => $priority++,
			'choices'         => array(
				'element' => 'span',
			),
			'active_callback' => array(
				array(
					'setting'  => 'enable_ajax',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'setting'  => 'ajax_prevent_woocommerce_pages',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);
}

Kirki::add_field(
	'arts',
	array(
		'type'     => 'generic',
		'settings' => 'ajax_transitions_generic_divider' . $priority,
		'section'  => 'ajax_transitions',
		'priority' => $priority++,
		'choices'  => array(
			'element' => 'hr',
		),
	)
);

Kirki::add_field(
	'arts',
	array(
		'type'            => 'code',
		'settings'        => 'custom_js_init',
		'label'           => esc_html__( 'Eval Custom JavaScript', 'rubenz' ),
		'description'     => esc_html__( 'The code inserted below will be executed after each AJAX transition.', 'rubenz' ),
		'tooltip'         => esc_html__( 'Useful for adding the frontend compatibility with 3rd party scripts. Please check theme documentation to learn more.', 'rubenz' ),
		'section'         => 'ajax_transitions',
		'priority'        => $priority++,
		'choices'         => array(
			'language' => 'js',
		),
		'active_callback' => array(
			array(
				'setting'  => 'enable_ajax',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

Kirki::add_field(
	'arts',
	array(
		'type'            => 'textarea',
		'settings'        => 'ajax_update_script_nodes',
		'label'           => esc_html__( 'Update Page Script Nodes', 'rubenz' ),
		'description'     => esc_html__( 'jQuery selectors separated by comma. Only exact ID selectors are supported. Example: script[id="theplus-front-js-js"]', 'rubenz' ),
		'tooltip'         => esc_html__( 'Useful for adding the frontend compatibility with 3rd party scripts which require a page reload to function properly.', 'rubenz' ),
		'section'         => 'ajax_transitions',
		'priority'        => $priority++,
		'active_callback' => array(
			array(
				'setting'  => 'enable_ajax',
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
		'settings'        => 'ajax_load_missing_scripts',
		'label'           => esc_html__( 'Load Missing Scripts from the Next Page', 'rubenz' ),
		'tooltip'         => esc_html__( 'Pontentially this may bring AJAX compatibility to the plugins which place their JS assets on-demand (only when the certain plugin\'s functionality or widget is used)', 'rubenz' ),
		'section'         => 'ajax_transitions',
		'default'         => false,
		'priority'        => $priority++,
		'active_callback' => array(
			array(
				'setting'  => 'enable_ajax',
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
		'settings'        => 'ajax_eval_inline_container_scripts',
		'label'           => esc_html__( 'Eval Inline JavaScript in Content Area', 'rubenz' ),
		'tooltip'         => esc_html__( 'Pontentially this may bring AJAX compatibility to the plugins which inject their JavaScript code right into HTML of the content area. E.g. Slider Revolution plugin.', 'rubenz' ),
		'section'         => 'ajax_transitions',
		'default'         => false,
		'priority'        => $priority++,
		'active_callback' => array(
			array(
				'setting'  => 'enable_ajax',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

Kirki::add_field(
	'arts',
	array(
		'type'            => 'generic',
		'settings'        => 'ajax_transitions_generic_divider' . $priority,
		'section'         => 'ajax_transitions',
		'priority'        => $priority++,
		'choices'         => array(
			'element' => 'hr',
		),
		'active_callback' => array(
			array(
				'setting'  => 'enable_ajax',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

Kirki::add_field(
	'arts',
	array(
		'type'            => 'textarea',
		'settings'        => 'ajax_update_head_nodes',
		'label'           => esc_html__( 'Update Page Head Nodes', 'rubenz' ),
		'description'     => esc_html__( 'jQuery selectors separated by comma. Example: link[id*="eael"], style[id*="theplus-"]', 'rubenz' ),
		'tooltip'         => esc_html__( 'Useful for adding the frontend compatibility with 3rd party styles. Please check theme documentation to learn more.', 'rubenz' ),
		'section'         => 'ajax_transitions',
		'priority'        => $priority++,
		'active_callback' => array(
			array(
				'setting'  => 'enable_ajax',
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
		'settings'        => 'ajax_load_missing_styles',
		'label'           => esc_html__( 'Load Missing Styles from the Next Page', 'rubenz' ),
		'tooltip'         => esc_html__( 'Pontentially this may bring AJAX compatibility to the plugins which place their CSS assets on-demand (only when the certain plugin\'s functionality or widget is used)', 'rubenz' ),
		'section'         => 'ajax_transitions',
		'default'         => false,
		'priority'        => $priority++,
		'active_callback' => array(
			array(
				'setting'  => 'enable_ajax',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);
