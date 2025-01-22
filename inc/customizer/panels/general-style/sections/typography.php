<?php

$priority = 1;

$variant_primary = array(
	'200',
	'300',
	'300italic',
	'400',
	'400italic',
	'600',
	'600italic',
);

$variant_secondary = array(
	'500',
);

$choices_primary   = arts_add_custom_choice();
$choices_secondary = arts_add_custom_choice();

$choices_primary['variant']   = $variant_primary;
$choices_secondary['variant'] = $variant_secondary;

/**
 * Primary Font
 */
Kirki::add_field(
	'arts',
	array(
		'type'     => 'typography',
		'settings' => 'font_primary',
		'label'    => esc_html__( 'Primary Font', 'rubenz' ),
		'section'  => 'typography',
		'default'  => array(
			'font-family' => 'Poppins',
		),
		'priority' => $priority++,
		'choices'  => $choices_primary,
	)
);

/**
 * Secondary Font
 */
Kirki::add_field(
	'arts',
	array(
		'type'     => 'typography',
		'settings' => 'font_secondary',
		'label'    => esc_html__( 'Secondary Font', 'rubenz' ),
		'section'  => 'typography',
		'default'  => array(
			'font-family' => 'Oswald',
		),
		'priority' => $priority++,
		'choices'  => $choices_secondary,
	)
);

/**
 * Force Load All Fonts Variations
 */
Kirki::add_field(
	'arts',
	array(
		'type'        => 'switch',
		'settings'    => 'force_load_all_fonts_variations',
		'label'       => esc_html__( 'Force Load All Selected Fonts Variations', 'rubenz' ),
		'description' => esc_html__( 'Please also note that this may significantly decrease site loading speed if your font contains a lot of weights & styles. Use with caution.', 'rubenz' ),
		'section'     => 'typography',
		'default'     => false,
		'priority'    => $priority++,
	)
);
