<?php

$priority = 1;

Kirki::add_field(
	'xpertpoint',
	array(
		'type'     => 'switch',
		'settings' => 'enable_cf_7_modals',
		'label'    => esc_html__( 'Enable Custom Modal Windows on Forms Submit', 'fitso' ),
		'section'  => 'contact_form_7',
		'default'  => true,
		'priority' => $priority++,
	)
);
