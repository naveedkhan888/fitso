<?php

/**
 * Register WordPress Features
 *
 * @return void
 */
add_action( 'after_setup_theme', 'arts_after_setup_theme' );
function arts_after_setup_theme() {
	load_theme_textdomain( 'rubenz', ARTS_THEME_PATH . '/languages' );

	add_editor_style( 'css/style-editor.css' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'html5',
		array(
			'comment-list',
			'comment-form',
			'search-form',
			'gallery',
			'caption',
		)
	);
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 80,
			'width'       => 80,
			'flex-height' => true,
			'flex-width'  => true,
			'header-text' => array( 'logo__text' ),
		)
	);
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support(
		'post-formats',
		array(
			'aside',
			'gallery',
			'link',
			'image',
			'quote',
			'status',
			'video',
			'audio',
			'chat',
		)
	);
	add_theme_support( 'title-tag' );
}

/**
 * Set content width
 */
if ( ! isset( $content_width ) ) {
	$content_width = 800;
}
