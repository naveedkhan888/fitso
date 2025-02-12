<?php

$priority = 1;

/**
 * Section Masthead
 */
Kirki::add_section(
	'blog_masthead',
	array(
		'title'    => esc_html__( 'Masthead', 'fitso' ),
		'priority' => $priority ++,
		'panel'    => 'blog',
	)
);
get_template_part( '/inc/customizer/panels/blog/sections/masthead' );

/**
 * Section Post
 */
Kirki::add_section(
	'post',
	array(
		'title'    => esc_html__( 'Post Display', 'fitso' ),
		'priority' => $priority ++,
		'panel'    => 'blog',
	)
);
get_template_part( '/inc/customizer/panels/blog/sections/post' );

/**
 * Section Sidebar
 */
Kirki::add_section(
	'sidebar',
	array(
		'title'    => esc_html__( 'Sidebar Display', 'fitso' ),
		'priority' => $priority ++,
		'panel'    => 'blog',
	)
);
get_template_part( '/inc/customizer/panels/blog/sections/sidebar' );
