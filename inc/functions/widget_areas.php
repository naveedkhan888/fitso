<?php

/**
 * Register Widget Areas
 *
 * @return void
 */
add_action( 'widgets_init', 'arts_register_widget_areas' );
function arts_register_widget_areas() {
	$menu_style     = get_theme_mod( 'menu_style', 'classic' );
	$footer_columns = get_theme_mod( 'footer_columns', 3 );

	register_sidebar(
		array(
			'name'          => esc_html__( 'Blog Sidebar', 'rubenz' ),
			'id'            => 'blog-sidebar',
			'description'   => esc_html__( 'Appears in blog.', 'rubenz' ),
			'before_widget' => '<section class="widget %2$s">',
			'after_widget'  => '</section>',
		)
	);

	if ( $menu_style == 'fullscreen' ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Fullscreen Menu Widgets', 'rubenz' ),
				'id'            => 'header-sidebar',
				'description'   => esc_html__( 'Appears on desktop in the page header if menu type is set to "fullscreen".', 'rubenz' ),
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
				'name'          => sprintf( esc_html__( 'Footer %s Column', 'rubenz' ), $i ),
				'id'            => 'footer-sidebar-' . $i,
				'description'   => esc_html__( 'Appears in Page Footer.', 'rubenz' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
			)
		);
	}

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Bottom Row', 'rubenz' ),
			'id'            => 'footer-sidebar-bottom',
			'description'   => esc_html__( 'Appears in Page Footer.', 'rubenz' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
		)
	);

	if ( class_exists( 'SitePress' ) || class_exists( 'Polylang' ) || class_exists( 'TRP_Translate_Press' ) ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Language Switcher Area', 'rubenz' ),
				'id'            => 'lang-switcher-sidebar',
				'description'   => esc_html__( 'Appears in the top menu.', 'rubenz' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
			)
		);
	}
}

