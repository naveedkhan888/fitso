<?php

/**
 * Register Widget Areas
 *
 * @return void
 */
add_action( 'widgets_init', 'xpertpoint_register_widget_areas' );
function xpertpoint_register_widget_areas() {
	$menu_style     = get_theme_mod( 'menu_style', 'classic' );
	$footer_columns = get_theme_mod( 'footer_columns', 3 );

	register_sidebar(
		array(
			'name'          => esc_html__( 'Blog Sidebar', 'fitso' ),
			'id'            => 'blog-sidebar',
			'description'   => esc_html__( 'Appears in blog.', 'fitso' ),
			'before_widget' => '<section class="widget %2$s">',
			'after_widget'  => '</section>',
		)
	);

	if ( $menu_style == 'fullscreen' ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Fullscreen Menu Widgets', 'fitso' ),
				'id'            => 'header-sidebar',
				'description'   => esc_html__( 'Appears on desktop in the page header if menu type is set to "fullscreen".', 'fitso' ),
				'before_widget' => '<div class="header__wrapper-property"><div class="figure-property"><div class="widget widget_%2$s split-text">',
				'after_widget'  => '</div></div></div>',
				'before_title'  => '<div class="figure-property__wrapper-heading"><h6 class="widgettitle split-text">',
				'after_title'   => '</h6></div>',
			)
		);
	}

	for ( $i = 1; $i <= $footer_columns; $i++ ) {
		register_sidebar(
			array(
				'name'          => sprintf( esc_html__( 'Footer %s Column', 'fitso' ), $i ),
				'id'            => 'footer-sidebar-' . $i,
				'description'   => esc_html__( 'Appears in Page Footer.', 'fitso' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
			)
		);
	}

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Bottom Row', 'fitso' ),
			'id'            => 'footer-sidebar-bottom',
			'description'   => esc_html__( 'Appears in Page Footer.', 'fitso' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
		)
	);

	if ( class_exists( 'SitePress' ) || class_exists( 'Polylang' ) || class_exists( 'TRP_Translate_Press' ) ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Language Switcher Area', 'fitso' ),
				'id'            => 'lang-switcher-sidebar',
				'description'   => esc_html__( 'Appears in the top menu.', 'fitso' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
			)
		);
	}
}

