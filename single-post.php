<?php

get_header();

// Elementor "single-post" location
if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single-post' ) ) {
	get_template_part( 'template-parts/masthead/masthead' );
	get_template_part( 'template-parts/blog/blog' );
}

get_footer();
