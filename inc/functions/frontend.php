<?php

/**
 * Enqueue Theme CSS Files
 */
add_action( 'wp_enqueue_scripts', 'arts_enqueue_styles', 20 );
function arts_enqueue_styles() {
	$typography_primary      = get_theme_mod( 'font_primary', true );
	$typography_secondary    = get_theme_mod( 'font_secondary', true );
	$enable_smooth_scroll    = get_theme_mod( 'enable_smooth_scroll', false );
	$enable_cf_7_modals      = get_theme_mod( 'enable_cf_7_modals', true );
	$enable_loading_progress = get_theme_mod( 'enable_loading_progress', true );
	$enable_ajax             = get_theme_mod( 'enable_ajax', false );

	if ( ! arts_is_elementor_feature_active( 'e_optimized_assets_loading' ) || arts_is_elementor_editor_active() || arts_is_blog_page() || post_password_required() ) {
		wp_enqueue_style( 'swiper' );
	}

	// Force load Elementor assets
	// on non-Elementor pages with AJAX turned on
	if ( class_exists( '\Elementor\Frontend' ) && ( ( ! arts_is_built_with_elementor() && $enable_ajax ) || post_password_required() ) ) {
		\Elementor\Frontend::instance()->enqueue_styles();
		wp_enqueue_style( 'elementor-post-holder', ARTS_THEME_URL . '/css/elementor-post-holder.min.css', array( 'elementor-common' ), ARTS_THEME_VERSION );
		wp_add_inline_style( 'elementor-post-holder', ' ' );
	}

	wp_enqueue_style( 'bootstrap-reboot', ARTS_THEME_URL . '/css/bootstrap-reboot.min.css', array(), '4.1.2' );
	wp_enqueue_style( 'bootstrap-grid', ARTS_THEME_URL . '/css/bootstrap-grid.min.css', array(), '4.1.2' );
	wp_enqueue_style( 'font-awesome', ARTS_THEME_URL . '/css/font-awesome.min.css', array(), '4.7.0' );
	wp_enqueue_style( 'material-icons', ARTS_THEME_URL . '/css/material-icons.min.css', array(), '3.0.1' );
	wp_enqueue_style( 'magnific-popup', ARTS_THEME_URL . '/css/magnific-popup.min.css', array(), '1.1.0' );
	wp_enqueue_style( 'fitso-main-style', ARTS_THEME_URL . '/css/main.css', array(), ARTS_THEME_VERSION );
	wp_enqueue_style( 'fitso-theme-style', ARTS_THEME_URL . '/style.css', array(), ARTS_THEME_VERSION );

	// fallback font if fonts are not set
	if ( ! class_exists( 'Kirki' ) || ! $typography_primary || ! $typography_secondary ) {
		wp_enqueue_style( 'fitso-fonts', '//fonts.googleapis.com/css?family=Oswald:500%7CPoppins:200,300,300i,400,400i,600,600i', array(), null );

		$css = "
		:root {
			--font-primary: 'Poppins', sans-serif;
			--font-secondary: 'Oswald', sans-serif;
		}
		";

		wp_add_inline_style( 'fitso-main-style', trim( $css ) );
	}

	// hide default Contact Form 7 response boxes if custom modals are enabled
	if ( $enable_cf_7_modals ) {
		wp_enqueue_script( 'bootstrap-modal', ARTS_THEME_URL . '/js/bootstrap-modal.min.js', array( 'jquery', 'bootstrap-util' ), '4.1.3', true );
		wp_enqueue_script( 'bootstrap-util', ARTS_THEME_URL . '/js/bootstrap-util.min.js', array( 'jquery' ), '4.1.3', true );
		wp_add_inline_style( 'contact-form-7', trim( '.wpcf7-mail-sent-ok, .wpcf7 form.sent .wpcf7-response-output, .wpcf7-mail-sent-ng, .wpcf7 form.failed .wpcf7-response-output { display: none !important; }' ) );
	}

	if ( $enable_loading_progress ) {
		wp_add_inline_style( 'fitso-main-style', trim( '.cursor-progress, .cursor-progress * { cursor: progress; }' ) );
	}
}

/**
 * Enqueue Modernizr & Polyfills
 */
add_action( 'wp_enqueue_scripts', 'arts_enqueue_polyfills', 20 );
function arts_enqueue_polyfills() {
	$outdated_browsers_enabled = get_theme_mod( 'outdated_browsers_enabled', true );

	if ( $outdated_browsers_enabled ) {
		wp_enqueue_script( 'outdated-browser-rework', ARTS_THEME_URL . '/js/outdated-browser-rework.min.js', array(), '1.1.0', false );
	}

	wp_enqueue_script( 'modernizr', ARTS_THEME_URL . '/js/modernizr.custom.min.js', array(), '3.6.0', false );

}

/**
 * Enqueue Theme JS Files
 */
add_action( 'wp_enqueue_scripts', 'arts_enqueue_scripts', 50 );
function arts_enqueue_scripts() {
	$enable_ajax               = get_theme_mod( 'enable_ajax', false );
	$enable_smooth_scroll      = get_theme_mod( 'enable_smooth_scroll', false );
	$gmap                      = get_option( 'arts_gmap' );
	$main_script_deps          = array( 'modernizr', 'jquery', 'isotope', 'imagesloaded' );
	$ajax_load_missing_scripts = get_theme_mod( 'ajax_load_missing_scripts', false );

	// Force load Google Maps script
	// on all the pages with AJAX turned on
	if ( $enable_ajax && ! $ajax_load_missing_scripts && isset( $gmap['key'] ) && ! empty( $gmap['key'] ) ) {
		wp_enqueue_script( 'googlemap', '//maps.googleapis.com/maps/api/js?callback=Function.prototype&key=' . $gmap['key'], array(), null, true );
		$main_script_deps [] = 'googlemap';
	}

	// Force load Elementor assets
	// on non-Elementor pages with AJAX turned on
	if ( class_exists( '\Elementor\Frontend' ) && ( ( ! arts_is_built_with_elementor() && $enable_ajax ) || post_password_required() ) ) {
		\Elementor\Frontend::instance()->enqueue_scripts();
	}

	if ( is_singular() && comments_open() ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( $enable_ajax ) {
		wp_enqueue_script( 'barba', ARTS_THEME_URL . '/js/barba.umd.min.js', array( 'jquery' ), '2.9.7', true );
		$main_script_deps [] = 'barba';
	}

	if ( $enable_smooth_scroll ) {
		wp_enqueue_script( 'smooth-scrollbar', ARTS_THEME_URL . '/js/smooth-scrollbar.min.js', array( 'jquery' ), '8.5.1', true );
		wp_enqueue_script( 'lockscroll', ARTS_THEME_URL . '/js/lockscroll.min.js', array( 'smooth-scrollbar' ), '1.0.0', true );
		wp_enqueue_script( 'edge-easing', ARTS_THEME_URL . '/js/edgeEasing.min.js', array( 'smooth-scrollbar' ), '8.5.1', true );
	}

	if ( ! arts_is_elementor_feature_active( 'e_optimized_assets_loading' ) || arts_is_elementor_editor_active() || arts_is_blog_page() || post_password_required() ) {
		wp_enqueue_script( 'swiper' );
	}

	wp_enqueue_script( 'imagesloaded' );
	wp_enqueue_script( 'animation-gsap', ARTS_THEME_URL . '/js/animation.gsap.min.js', array( 'scrollmagic', 'tweenmax' ), '2.0.5', true );
	wp_enqueue_script( 'drawsvg-plugin', ARTS_THEME_URL . '/js/DrawSVGPlugin.min.js', array( 'tweenmax' ), '0.2.0', true );
	wp_enqueue_script( 'isotope', ARTS_THEME_URL . '/js/isotope.pkgd.min.js', array( 'jquery' ), '3.0.6', true );
	wp_enqueue_script( 'jquery-lazy', ARTS_THEME_URL . '/js/jquery.lazy.min.js', array( 'jquery' ), '1.7.10', true );
	wp_enqueue_script( 'jquery-lazy-plugins', ARTS_THEME_URL . '/js/jquery.lazy.plugins.min.js', array( 'jquery', 'jquery-lazy' ), '1.7.10', true );
	wp_enqueue_script( 'jquery-magnific-popup', ARTS_THEME_URL . '/js/jquery.magnific-popup.min.js', array( 'jquery' ), '1.1.0', true );
	wp_enqueue_script( 'jquery-scrollmagic', ARTS_THEME_URL . '/js/jquery.ScrollMagic.min.js', array( 'scrollmagic' ), '2.0.5', true );
	wp_enqueue_script( 'scrollmagic', ARTS_THEME_URL . '/js/ScrollMagic.min.js', array(), '2.0.5', true );
	wp_enqueue_script( 'split-text', ARTS_THEME_URL . '/js/SplitText.min.js', array( 'tweenmax' ), '3.2.4', true );
	wp_enqueue_script( 'tweenmax', ARTS_THEME_URL . '/js/TweenMax.min.js', array(), '2.1.2', true );
	wp_enqueue_script( 'fitso-components', ARTS_THEME_URL . '/js/components.js', $main_script_deps, ARTS_THEME_VERSION, true );

	/**
	 * Enqueue Elementor Frontend Editor Script
	 */
	if ( arts_is_elementor_editor_active() ) {
		wp_enqueue_script( 'fitso-elementor-preview', ARTS_THEME_URL . '/js/elementor-preview.min.js', array( 'elementor-frontend', 'elementor-inline-editor' ), ARTS_THEME_VERSION, true );
	}
}

/**
 * Localize Theme Options
 */
add_action( 'wp_enqueue_scripts', 'arts_localize_data', 60 );
function arts_localize_data() {

	$typography_primary   = get_theme_mod( 'font_primary', array( 'font-family' => 'Poppins' ) );
	$typography_secondary = get_theme_mod( 'font_secondary', array( 'font-family' => 'Oswald' ) );
	$fonts                = array( $typography_primary['font-family'], $typography_secondary['font-family'] );

	// filter out system fonts and CSS fallbacks
	$fonts = array_values(
		array_filter(
			$fonts,
			function( $key ) {
				return $key !== 'initial' &&
				! empty( $key ) &&
				$key !== 'inherit' &&
				$key !== 'Georgia,Times,"Times New Roman",serif' &&
				! strpos( $key, 'sans-serif' ) &&
				! strpos( $key, 'monospace' );
			}
		)
	);

	$fonts = apply_filters( 'fitso/frontend/fonts', $fonts );

	$enable_ajax                        = get_theme_mod( 'enable_ajax', false );
	$ajax_prevent_rules                 = get_theme_mod( 'ajax_prevent_rules' );
	$ajax_prevent_woocommerce_pages     = get_theme_mod( 'ajax_prevent_woocommerce_pages', false );
	$ajax_update_head_nodes             = get_theme_mod( 'ajax_update_head_nodes' );
	$ajax_update_script_nodes           = get_theme_mod( 'ajax_update_script_nodes' );
	$ajax_eval_inline_container_scripts = get_theme_mod( 'ajax_eval_inline_container_scripts', false );
	$ajax_load_missing_scripts          = get_theme_mod( 'ajax_load_missing_scripts', false );
	$ajax_load_missing_styles           = get_theme_mod( 'ajax_load_missing_styles', false );

	$smooth_scroll_damping          = get_theme_mod( 'smooth_scroll_damping', 0.06 );
	$smooth_scroll_render_by_pixels = get_theme_mod( 'smooth_scroll_render_by_pixels', true );
	$smooth_scroll_plugin_easing    = get_theme_mod( 'smooth_scroll_plugin_easing', false );

	$custom_js_init              = get_theme_mod( 'custom_js_init' );
	$enable_cf_7_modals          = get_theme_mod( 'enable_cf_7_modals', true );
	$enable_fix_mobile_vh        = get_theme_mod( 'enable_fix_mobile_vh', true );
	$enable_fix_mobile_vh_update = get_theme_mod( 'enable_fix_mobile_vh_update', true );

	if ( $enable_ajax &&
		$ajax_prevent_woocommerce_pages &&
		class_exists( 'woocommerce' ) &&
		function_exists( 'arts_get_woocommerce_urls' ) ) {

		// add AJAX rules that prevents all "TO" WooCommerce pages
		$woocommerce_urls        = arts_get_woocommerce_urls();
		$woocommerce_urls_string = '';

		foreach ( $woocommerce_urls as $url ) {
			$woocommerce_urls_string .= 'a[href*="' . $url . '"],';
		}

		$ajax_prevent_rules .= $woocommerce_urls_string;

		// add AJAX rule that prevents all the links "FROM" WooCommerce pages to other website pages
		$ajax_prevent_rules .= '.woocommerce-page a';

	}

	wp_localize_script(
		'fitso-components',
		'theme',
		array(
			'themeURL'          => esc_js( ARTS_THEME_URL ),
			'fonts'             => $fonts,
			'ajax'              => array(
				'enabled'                    => esc_js( $enable_ajax ),
				'preventRules'               => $ajax_prevent_rules,
				'evalInlineContainerScripts' => esc_js( $ajax_eval_inline_container_scripts ),
				'loadMissingScripts'         => esc_js( $ajax_load_missing_scripts ),
				'loadMissingStyles'          => esc_js( $ajax_load_missing_styles ),
			),
			'smoothScroll'      => array(
				'damping'             => esc_js( $smooth_scroll_damping ),
				'renderByPixels'      => esc_js( $smooth_scroll_render_by_pixels ),
				'continuousScrolling' => $smooth_scroll_plugin_easing ? false : true,
				'plugins'             => array(
					'edgeEasing' => esc_js( $smooth_scroll_plugin_easing ),
				),
			),
			'contactForm7'      => array(
				'customModals' => esc_js( $enable_cf_7_modals ),
			),
			'customJSInit'      => $custom_js_init,
			'updateHeadNodes'   => esc_js( $ajax_update_head_nodes ),
			'updateScriptNodes' => esc_js( $ajax_update_script_nodes ),
			'mobileBarFix'      => array(
				'enabled' => esc_js( $enable_fix_mobile_vh ),
				'update'  => esc_js( $enable_fix_mobile_vh_update ),
			),
			'assets'            => array(
				'promises' => array(),
			),
		)
	);

	$css = "
		:root {
			--font-primary: {$typography_primary['font-family']};
			--font-secondary: {$typography_secondary['font-family']};
		}
	";
	wp_add_inline_style( 'fitso-main-style', trim( $css ) );
}

/**
 * Enqueue Customizer Live Preview Script
 */
add_action( 'customize_preview_init', 'arts_customize_preview_script' );
function arts_customize_preview_script() {
	wp_enqueue_script( 'fitso-customizer-preview', ARTS_THEME_URL . '/js/customizer.min.js', array(), ARTS_THEME_VERSION, true );
}

/**
 * Exclude certain JS from the aggregation
 * function of Autoptimize plugin
 */
add_filter( 'autoptimize_filter_js_exclude', 'arts_ao_override_jsexclude', 10, 1 );
/**
 * JS optimization exclude strings, as configured in admin page.
 *
 * @param $exclude: comma-seperated list of exclude strings
 * @return: comma-seperated list of exclude strings
 */
function arts_ao_override_jsexclude( $exclude ) {
	return $exclude . ', outdated-browser-rework';
}

/**
 * Force disable HTML minification for Autoptimize plugin
 * if AJAX transitions are enabled to avoid incorrect
 * page rendering.
 */
add_filter( 'autoptimize_filter_html_noptimize', 'arts_ao_disable_html_minification_ajax', 10, 1 );
function arts_ao_disable_html_minification_ajax( $value ) {
	$enable_ajax = get_theme_mod( 'enable_ajax', false );

	if ( $enable_ajax ) {
		$value = true;
	}

	return $value;
}

/**
 * Enqueue JS in WP admin panel
 */
add_action( 'admin_enqueue_scripts', 'arts_enqueue_admin_assets' );
if ( ! function_exists( 'arts_enqueue_admin_assets' ) ) {
	function arts_enqueue_admin_assets() {
		wp_enqueue_script(
			'fitso-admin-notices',
			esc_url( ARTS_THEME_URL . '/js/admin-notices.min.js' ),
			array(),
			ARTS_THEME_VERSION,
			true
		);
	}
}
