<?php

/**
 * Import Demo Data
 */
add_filter( 'merlin_import_files', 'arts_merlin_import_files' );
function arts_merlin_import_files() {
	return array(
		array(
			'import_file_name'           => esc_html__( 'Rubenz Demo Data', 'rubenz' ),
			'import_file_url'            => esc_url( 'https://artemsemkin.com/wp-json/edd/v1/file/' . ARTS_THEME_SLUG . '/demo-data' ),
			'import_widget_file_url'     => esc_url( 'https://artemsemkin.com/wp-json/edd/v1/file/' . ARTS_THEME_SLUG . '/demo-widgets' ),
			'import_customizer_file_url' => esc_url( 'https://artemsemkin.com/wp-json/edd/v1/file/' . ARTS_THEME_SLUG . '/demo-customizer' ),
			'preview_url'                => esc_url( 'https://artemsemkin.com/' . ARTS_THEME_SLUG . '/wp/' ),
		),
	);
}

/**
 * Child theme screenshot
 */
add_filter( 'merlin_generate_child_screenshot', 'arts_merlin_generate_child_screenshot' );
function arts_merlin_generate_child_screenshot() {
	return ARTS_THEME_PATH . '/inc/merlin/assets/images/screenshot.png';
}

/**
 * Setup Elementor
 */
add_action( 'merlin_after_all_import', 'arts_merlin_setup_elementor' );
add_action( 'pt-ocdi/after_import', 'arts_merlin_setup_elementor' );
function arts_merlin_setup_elementor() {
	$cpt_support = get_option( 'elementor_cpt_support' );

	// Update CPT Support
	if ( ! $cpt_support ) {
		$cpt_support = array( 'page', 'post', 'arts_portfolio_item' );
		update_option( 'elementor_cpt_support', $cpt_support );
	} elseif ( ! in_array( 'arts_portfolio_item', $cpt_support ) ) {
		$cpt_support[] = 'arts_portfolio_item';
		update_option( 'elementor_cpt_support', $cpt_support );
	}

	// Update Default space between widgets
	update_option( 'elementor_space_between_widgets', '50' );

	// Update Content width
	update_option( 'elementor_container_width', '1140' );

	// Update Breakpoints
	update_option( 'elementor_viewport_lg', '992' );
	update_option( 'elementor_viewport_md', '768' );

	// Update Page title selector
	update_option( 'elementor_page_title_selector', '.section-masthead h1' );

	// Update Disable default color schemes and fonts
	update_option( 'elementor_disable_color_schemes', 'yes' );
	update_option( 'elementor_disable_typography_schemes', 'yes' );

	// Update CSS Print Method
	update_option( 'elementor_css_print_method', 'internal' );

	// Clear Theme Builder cache
	if ( class_exists( '\ElementorPro\Modules\ThemeBuilder\Classes\Conditions_Cache' ) ) {
		$cache = new \ElementorPro\Modules\ThemeBuilder\Classes\Conditions_Cache();
		$cache->regenerate();
	}

	// Update URLs from demo data with the ones pointing to current website
	if ( class_exists( '\Elementor\Utils' ) ) {
		$from = 'https://artemsemkin.com/' . ARTS_THEME_SLUG . '/wp/';
		$to   = trailingslashit( get_site_url() );

		try {
			\Elementor\Utils::replace_urls( $from, $to );
		} catch ( \Exception $e ) {
		}
	}

	// Regenerate Elementor CSS & data
	if ( class_exists( '\Elementor\Plugin' ) && \Elementor\Plugin::$instance && \Elementor\Plugin::$instance->files_manager ) {
		\Elementor\Plugin::$instance->files_manager->clear_cache();
	}
}

/**
 * Setup Menu
 */
add_action( 'merlin_after_all_import', 'arts_merlin_setup_menu' );
add_action( 'pt-ocdi/after_import', 'arts_merlin_setup_menu' );
function arts_merlin_setup_menu() {
	$top_menu = get_term_by( 'name', 'Top Menu', 'nav_menu' );

	set_theme_mod(
		'nav_menu_locations',
		array(
			'main_menu' => $top_menu->term_id,
		)
	);
}

/**
 * Setup Front/Blog Pages
 */
add_action( 'merlin_after_all_import', 'arts_merlin_setup_front_blog_pages' );
add_action( 'pt-ocdi/after_import', 'arts_merlin_setup_front_blog_pages' );
function arts_merlin_setup_front_blog_pages() {
	$front_page = arts_get_page_by_title( 'Portfolio Slider Headings' );
	$blog_page  = arts_get_page_by_title( 'Blog' );

	update_option( 'show_on_front', 'page' );

	if ( $front_page && $front_page->ID ) {
		update_option( 'page_on_front', $front_page->ID );
	}

	if ( $blog_page && $blog_page->ID ) {
		update_option( 'page_for_posts', $blog_page->ID );
	}
}

/**
 * Setup Date Format
 */
add_action( 'merlin_after_all_import', 'arts_merlin_setup_date_format' );
add_action( 'pt-ocdi/after_import', 'arts_merlin_setup_date_format' );
function arts_merlin_setup_date_format() {
	update_option( 'date_format', 'd M Y' );
}

/**
 * Setup Intuitive Custom Post Order
 * Define sortable post types
 */
add_action( 'merlin_after_all_import', 'arts_merlin_setup_hicpo' );
add_action( 'pt-ocdi/after_import', 'arts_merlin_setup_hicpo' );
function arts_merlin_setup_hicpo() {
	add_option( 'hicpo_options', array( 'objects', 'tags' ) );

	$hicpo_options = get_option( 'hicpo_options' );
	$hicpo_objects = isset( $hicpo_options['objects'] ) ? $hicpo_options['objects'] : '';
	$hicpo_tags    = isset( $hicpo_options['tags'] ) ? $hicpo_options['tags'] : '';

	// Sortable custom post types
	if ( ! $hicpo_objects ) {
		$hicpo_objects            = array( 'arts_portfolio_item' );
		$hicpo_options['objects'] = $hicpo_objects;
		update_option( 'hicpo_options', $hicpo_options );
	} elseif ( ! in_array( 'arts_portfolio_item', $hicpo_objects ) ) {
		$hicpo_objects[]          = 'arts_portfolio_item';
		$hicpo_options['objects'] = $hicpo_objects;
		update_option( 'hicpo_options', $hicpo_options );
	}

	// Sortable taxonomies
	if ( ! $hicpo_tags ) {
		$hicpo_tags            = array( 'arts_portfolio_category' );
		$hicpo_options['tags'] = $hicpo_tags;
		update_option( 'hicpo_options', $hicpo_options );
	} elseif ( ! in_array( 'arts_portfolio_category', $hicpo_tags ) ) {
		$hicpo_tags[]          = 'arts_portfolio_category';
		$hicpo_options['tags'] = $hicpo_tags;
		update_option( 'hicpo_options', $hicpo_options );
	}
}

/**
 * Setup permalinks format
 * Needed to make AJAX transitions work
 */
add_action( 'merlin_after_all_import', 'arts_merlin_setup_permalinks', 99 );
add_action( 'pt-ocdi/after_import', 'arts_merlin_setup_permalinks', 99 );
function arts_merlin_setup_permalinks() {
	global $wp_rewrite;

	// Set permalink structure
	$wp_rewrite->set_permalink_structure( '/%postname%/' );

	// Recreate rewrite rules
	$wp_rewrite->rewrite_rules();
	$wp_rewrite->wp_rewrite_rules();
	$wp_rewrite->flush_rules();
}

/**
 * Unset all widgets
 * from default blog sidebar
 */
add_action( 'merlin_widget_importer_before_widgets_import', 'arts_unset_default_sidebar_widgets' );
add_action( 'pt-ocdi/widget_importer_before_widgets_import', 'arts_unset_default_sidebar_widgets' );
function arts_unset_default_sidebar_widgets() {
	// empty default blog sidebar
	$widget_areas = array(
		'blog-sidebar' => array(),
	);
	update_option( 'sidebars_widgets', $widget_areas );

	// set menu to fullscreen style
	update_option( 'menu_style', 'fullscreen' );

	// register sidebar in fullscreen menu now
	// before the demo import starts
	// so the widgets will be actually imported
	register_sidebar(
		array(
			'name'          => esc_html__( 'Fullscreen Menu Widgets', 'rubenz' ),
			'id'            => 'header-sidebar',
			'description'   => esc_html__( 'Appears on desktop in the page header if menu type is set to "fullscreen".', 'rubenz' ),
			'before_widget' => '<div class="header__wrapper-property"><div class="figure-property split-text"><div class="widget widget_%2$s">',
			'after_widget'  => '</div></div></div>',
			'before_title'  => '<div class="figure-property__wrapper-heading split-text"><h6 class="widgettitle">',
			'after_title'   => '</h6></div>',
		)
	);
}
