<?php

$priority = 1;

Kirki::add_section(
	'smooth_scroll',
	array(
		'title'    => esc_html__( 'Smooth Scroll', 'rubenz' ),
		'priority' => $priority ++,
		'panel'    => 'theme_options',
	)
);
get_template_part( '/inc/customizer/panels/theme-options/sections/smooth-scroll' );

Kirki::add_section(
	'ajax_transitions',
	array(
		'title'    => esc_html__( 'AJAX Transitions', 'rubenz' ),
		'priority' => $priority ++,
		'panel'    => 'theme_options',
	)
);
get_template_part( '/inc/customizer/panels/theme-options/sections/ajax-transitions' );

Kirki::add_section(
	'cursor_follower',
	array(
		'title'    => esc_html__( 'Mouse Cursor Follower', 'rubenz' ),
		'priority' => $priority ++,
		'panel'    => 'theme_options',
	)
);
get_template_part( '/inc/customizer/panels/theme-options/sections/cursor-follower' );

Kirki::add_section(
	'contact_form_7',
	array(
		'title'    => esc_html__( 'Contact Form 7', 'rubenz' ),
		'priority' => $priority ++,
		'panel'    => 'theme_options',
	)
);
get_template_part( '/inc/customizer/panels/theme-options/sections/contact-form-7' );

Kirki::add_section(
	'404',
	array(
		'title'    => esc_html__( 'Page 404', 'rubenz' ),
		'priority' => $priority ++,
		'panel'    => 'theme_options',
	)
);
get_template_part( '/inc/customizer/panels/theme-options/sections/404' );

Kirki::add_section(
	'outdated_browsers',
	array(
		'title'    => esc_html__( 'Outdated Browsers', 'rubenz' ),
		'priority' => $priority ++,
		'panel'    => 'theme_options',
	)
);
get_template_part( '/inc/customizer/panels/theme-options/sections/outdated-browsers' );

Kirki::add_section(
	'lazy_images',
	array(
		'title'    => esc_html__( 'Lazy Images', 'rubenz' ),
		'priority' => $priority ++,
		'panel'    => 'theme_options',
	)
);
get_template_part( '/inc/customizer/panels/theme-options/sections/lazy-images' );

