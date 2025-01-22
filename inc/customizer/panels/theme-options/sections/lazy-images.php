<?php

$priority = 1;

Kirki::add_field(
	'arts',
	array(
		'type'        => 'switch',
		'settings'    => 'full_size_images_enabled',
		'label'       => esc_html__( 'Force Load Full Size Images', 'rubenz' ),
		'description' => esc_html__( 'Always use the original images uploaded to media library and don\'t use the sets of WordPress generated thumbnails.', 'rubenz' ),
		'section'     => 'lazy_images',
		'default'     => false,
		'priority'    => $priority++,
	)
);

Kirki::add_field(
	'arts',
	array(
		'type'        => 'radio-buttonset',
		'settings'    => 'lazy_placeholder_type',
		'label'       => esc_html__( 'Lazy Placeholder', 'rubenz' ),
		'description' => esc_html__( 'Temporary lightweight image that appears before a lazy image is fully loaded.', 'rubenz' ),
		'section'     => 'lazy_images',
		'default'     => 'inline',
		'priority'    => $priority++,
		'choices'     => array(
			'inline'       => esc_html__( 'Inline Source', 'rubenz' ),
			'custom_image' => esc_html__( 'Custom Image', 'rubenz' ),
		),
	)
);

Kirki::add_field(
	'arts',
	array(
		'type'            => 'textarea',
		'settings'        => 'lazy_placeholder_inline',
		'description'     => esc_html__( 'Base64 encoded image or external URL that will be appended to <img src="..."> attribute.', 'rubenz' ),
		'section'         => 'lazy_images',
		'default'         => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAHCGzyUAAAABGdBTUEAALGPC/xhBQAAADhlWElmTU0AKgAAAAgAAYdpAAQAAAABAAAAGgAAAAAAAqACAAQAAAABAAAAAaADAAQAAAABAAAAAQAAAADa6r/EAAAAC0lEQVQI12NolQQAASYAn89qhTcAAAAASUVORK5CYII=',
		'priority'        => $priority++,
		'active_callback' => array(
			array(
				'setting' => 'lazy_placeholder_type',
				'value'   => 'inline',
			),
		),
	)
);

Kirki::add_field(
	'arts',
	array(
		'type'            => 'image',
		'settings'        => 'lazy_placeholder_image_url',
		'section'         => 'lazy_images',
		'default'         => '',
		'priority'        => $priority++,
		'active_callback' => array(
			array(
				'setting' => 'lazy_placeholder_type',
				'value'   => 'custom_image',
			),
		),
	)
);
