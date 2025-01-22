<?php

/**
 * Hide ACF Menu
 */
if ( ! ARTS_THEME_DEV ) {
	add_filter( 'acf/settings/show_admin', '__return_false' );
}

/**
 * ACF Fields
 */
if ( function_exists( 'acf_add_local_field_group' ) ) {
	acf_add_local_field_group(
		array(
			'key'                   => 'group_5cd5a9f03a2a8',
			'title'                 => esc_html__( 'Additional Content', 'fitso' ),
			'fields'                => array(
				array(
					'key'               => 'field_5cde3e8ff776c',
					'label'             => esc_html__( 'Subheading', 'fitso' ),
					'name'              => 'subheading',
					'type'              => 'textarea',
					'instructions'      => '',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => array(
						'width' => '',
						'class' => '',
						'id'    => '',
					),
					'default_value'     => '',
					'placeholder'       => '',
					'maxlength'         => '',
					'rows'              => '',
					'new_lines'         => '',
				),
				array(
					'key'               => 'field_5cd5aa039713f',
					'label'             => esc_html__( 'Properties', 'fitso' ),
					'name'              => 'properties',
					'type'              => 'repeater',
					'instructions'      => '',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => array(
						'width' => '',
						'class' => '',
						'id'    => '',
					),
					'collapsed'         => '',
					'min'               => 0,
					'max'               => 0,
					'layout'            => 'table',
					'button_label'      => '',
					'sub_fields'        => array(
						array(
							'key'               => 'field_5cd5aa1697140',
							'label'             => esc_html__( 'Name', 'fitso' ),
							'name'              => 'name',
							'type'              => 'text',
							'instructions'      => '',
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => array(
								'width' => '',
								'class' => '',
								'id'    => '',
							),
							'default_value'     => '',
							'placeholder'       => '',
							'prepend'           => '',
							'append'            => '',
							'maxlength'         => '',
						),
						array(
							'key'               => 'field_5cd5ad1e97141',
							'label'             => esc_html__( 'List', 'fitso' ),
							'name'              => 'list',
							'type'              => 'repeater',
							'instructions'      => '',
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => array(
								'width' => '',
								'class' => '',
								'id'    => '',
							),
							'collapsed'         => '',
							'min'               => 0,
							'max'               => 0,
							'layout'            => 'table',
							'button_label'      => '',
							'sub_fields'        => array(
								array(
									'key'               => 'field_5cd5ad4a97143',
									'label'             => esc_html__( 'Value', 'fitso' ),
									'name'              => 'value',
									'type'              => 'text',
									'instructions'      => '',
									'required'          => 0,
									'conditional_logic' => 0,
									'wrapper'           => array(
										'width' => '',
										'class' => '',
										'id'    => '',
									),
									'default_value'     => '',
									'placeholder'       => '',
									'prepend'           => '',
									'append'            => '',
									'maxlength'         => '',
								),
							),
						),
					),
				),
				array(
					'key'               => 'field_5d55449378eb9',
					'label'             => 'Text',
					'name'              => 'text',
					'type'              => 'textarea',
					'instructions'      => 'Shown in fullscreen sliders',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => array(
						'width' => '',
						'class' => '',
						'id'    => '',
					),
					'default_value'     => '',
					'placeholder'       => '',
					'maxlength'         => '',
					'rows'              => '',
					'new_lines'         => '',
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'page',
					),
				),
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'arts_portfolio_item',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'acf_after_title',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen'        => '',
			'active'                => true,
			'description'           => '',
		)
	);

	// custom fonts fields
	acf_add_local_field_group(
		array(
			'key'                   => 'group_5da01c79399ce',
			'title'                 => esc_html__( 'Custom Fonts', 'fitso' ),
			'fields'                => array(
				array(
					'key'               => 'field_5da01caa50c9a',
					'label'             => '',
					'name'              => 'custom_fonts',
					'type'              => 'repeater',
					'instructions'      => '',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => array(
						'width' => '',
						'class' => '',
						'id'    => '',
					),
					'collapsed'         => 'field_5da01cfa50c9b',
					'min'               => 0,
					'max'               => 0,
					'layout'            => 'block',
					'button_label'      => esc_html__( 'Add Custom Font', 'fitso' ),
					'sub_fields'        => array(
						array(
							'key'               => 'field_5da01cfa50c9b',
							'label'             => esc_html__( 'Font Family Name', 'fitso' ),
							'name'              => 'font_name',
							'type'              => 'text',
							'instructions'      => '',
							'required'          => 1,
							'conditional_logic' => 0,
							'wrapper'           => array(
								'width' => '',
								'class' => '',
								'id'    => '',
							),
							'default_value'     => '',
							'placeholder'       => '',
							'prepend'           => '',
							'append'            => '',
							'maxlength'         => '',
						),
						array(
							'key'               => 'field_5da3c469ba39d',
							'label'             => esc_html__( 'Font Display', 'fitso' ),
							'name'              => 'font_display',
							'type'              => 'select',
							'instructions'      => sprintf(
								'<a href="https://developer.mozilla.org/en-US/docs/Web/CSS/@font-face/font-display" target="_blank">%1s</a> %2s',
								esc_html__( 'More information', 'fitso' ),
								esc_html__( 'related to "font-display" descriptor.', 'fitso' )
							),
							'required'          => 1,
							'conditional_logic' => 0,
							'wrapper'           => array(
								'width' => '',
								'class' => '',
								'id'    => '',
							),
							'choices'           => array(
								'auto'     => 'auto',
								'block'    => 'block',
								'swap'     => 'swap',
								'fallback' => 'fallback',
								'optional' => 'optional',
							),
							'default_value'     => array(
								0 => 'auto',
							),
							'allow_null'        => 0,
							'multiple'          => 0,
							'ui'                => 0,
							'return_format'     => 'value',
							'ajax'              => 0,
							'placeholder'       => '',
						),
						array(
							'key'               => 'field_5da01d3550c9c',
							'label'             => esc_html__( 'Font Files', 'fitso' ),
							'name'              => 'font_files',
							'type'              => 'repeater',
							'instructions'      => '',
							'required'          => 1,
							'conditional_logic' => 0,
							'wrapper'           => array(
								'width' => '',
								'class' => '',
								'id'    => '',
							),
							'collapsed'         => 'field_5da01e9550c9e',
							'min'               => 0,
							'max'               => 0,
							'layout'            => 'block',
							'button_label'      => esc_html__( 'Add Font File', 'fitso' ),
							'sub_fields'        => array(
								array(
									'key'               => 'field_5da01d7250c9d',
									'label'             => 'Font File',
									'name'              => 'font_file',
									'type'              => 'file',
									'instructions'      => esc_html__( 'Upload .woff or .woff2 font file', 'fitso' ),
									'required'          => 1,
									'conditional_logic' => 0,
									'wrapper'           => array(
										'width' => '',
										'class' => '',
										'id'    => '',
									),
									'return_format'     => 'array',
									'library'           => 'all',
									'min_size'          => '',
									'max_size'          => '',
									'mime_types'        => 'woff, woff2',
								),
								array(
									'key'               => 'field_5da01e9550c9e',
									'label'             => esc_html__( 'Font Weight', 'fitso' ),
									'name'              => 'font_weight',
									'type'              => 'select',
									'instructions'      => esc_html__( 'Select a font weight of the uploaded font file', 'fitso' ),
									'required'          => 1,
									'conditional_logic' => 0,
									'wrapper'           => array(
										'width' => '',
										'class' => '',
										'id'    => '',
									),
									'choices'           => array(
										100         => esc_html__( '100 (Thin)', 'fitso' ),
										'100italic' => esc_html__( '100i (Thin Italic)', 'fitso' ),
										200         => esc_html__( ' 200 (Ultra Light)', 'fitso' ),
										'200italic' => esc_html__( '200i (Ultra Light Italic)', 'fitso' ),
										300         => esc_html__( ' 300 (Light)', 'fitso' ),
										'300italic' => esc_html__( '300i (Light Italic)', 'fitso' ),
										400         => esc_html__( '400 (Regular)', 'fitso' ),
										'400italic' => esc_html__( '400i (Regular Italic)', 'fitso' ),
										500         => esc_html__( '500 (Medium)', 'fitso' ),
										'500italic' => esc_html__( '500i (Medium Italic)', 'fitso' ),
										600         => esc_html__( '600 (Semi Bold)', 'fitso' ),
										'600italic' => esc_html__( '600i (Semi Bold Italic)', 'fitso' ),
										700         => esc_html__( '700 (Bold)', 'fitso' ),
										'700italic' => esc_html__( '700i (Bold Italic)', 'fitso' ),
										800         => esc_html__( '800 (Extra Bold)', 'fitso' ),
										'800italic' => esc_html__( '800i (Extra Bold Italic)', 'fitso' ),
										900         => esc_html__( '900 (Black)', 'fitso' ),
										'900italic' => esc_html__( '900i (Black Italic)', 'fitso' ),
									),
									'default_value'     => array(),
									'allow_null'        => 0,
									'multiple'          => 0,
									'ui'                => 0,
									'return_format'     => 'value',
									'ajax'              => 0,
									'placeholder'       => '',
								),
							),
						),
					),
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'custom-fonts-settings',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen'        => '',
			'active'                => true,
			'description'           => '',
		)
	);
}

/**
 * Custom Fonts Admin Page
 */
if ( function_exists( 'acf_add_options_page' ) ) {
	acf_add_options_page(
		array(
			'page_title'      => 'Custom Fonts',
			'menu_title'      => 'Custom Fonts',
			'menu_slug'       => 'custom-fonts-settings',
			'capability'      => 'customize',
			'icon_url'        => 'dashicons-editor-textcolor',
			'update_button'   => esc_html__( 'Save Changes', 'fitso' ),
			'updated_message' => sprintf(
				'%1s <a href="%2s" target="_blank">%3s</a>',
				esc_html__( 'Fonts are saved and ready to use from', 'fitso' ),
				admin_url( 'customize.php' ),
				esc_html__( 'WordPress Customizer.', 'fitso' )
			),
		)
	);
}
