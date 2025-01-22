<?php

/**
 * Custom Slugs for Custom Post Types
 */
function arts_change_cpt_slug( $args, $post_type ) {
	$enable_custom_portfolio_slug = get_theme_mod( 'enable_custom_portfolio_slug', false );
	$portfolio_slug               = get_theme_mod( 'portfolio_slug' );

	if ( $enable_custom_portfolio_slug && ! empty( $portfolio_slug ) && $post_type == 'arts_portfolio_item' ) {
		$args['rewrite']['slug'] = $portfolio_slug;
	}

	return $args;
}
add_filter( 'register_post_type_args', 'arts_change_cpt_slug', 10, 2 );
