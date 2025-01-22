<?php

/**
 * BEFORE: Extra markup for Elementor Canvas template
 */
add_action(
	'elementor/page_templates/canvas/before_content',
	function() {
		$theme_namespace            = 'light';
		$theme_page                 = arts_get_document_option( 'page_main_color_theme' );
		$theme_header               = '';
		$class_wrapper_menu         = '';
		$class_wrapper_burger       = '';
		$class_page                 = '';
		$attrs_wrapper              = '';
		$attrs_page                 = '';
		$class_header_controls      = get_theme_mod( 'header_container', 'container-fluid' );
		$class_header_col_left      = '';
		$class_header_col_right     = '';
		$class_wrapper_overlay_menu = '';
		$attrs_wrapper_widgets      = '';

		$locations   = get_nav_menu_locations();
		$has_menu    = has_nav_menu( 'main_menu' );
		$menu_style  = get_theme_mod( 'menu_style', 'classic' );
		$menu_name   = 'main_menu';
		$menu_object = wp_get_nav_menu_object( $locations[ $menu_name ] );
		$menu_items  = wp_get_nav_menu_items( $menu_object );

		$enable_smooth_scroll                            = get_theme_mod( 'enable_smooth_scroll', false );
		$enable_smooth_scroll_mobile                     = get_theme_mod( 'enable_smooth_scroll_mobile', false );
		$smooth_scroll_elementor_canvas_template_enabled = get_theme_mod( 'smooth_scroll_elementor_canvas_template_enabled', true );
		$enable_ajax                                     = get_theme_mod( 'enable_ajax', false );
		$enable_cursor                                   = get_theme_mod( 'enable_cursor', false );
		$enhance_header_contrast                         = get_theme_mod( 'enhance_header_contrast', false );
		$header_position                                 = get_theme_mod( 'header_position', 'header_absolute' );
		$ajax_prevent_header_widgets                     = get_theme_mod( 'ajax_prevent_header_widgets', false );

		$header_widgets_id        = 'header-sidebar';
		$header_has_widgets       = is_active_sidebar( $header_widgets_id );
		$header_has_lang_switcher = is_active_sidebar( 'lang-switcher-sidebar' );

		$theme_header = $header_position;

		$enable_spinner_desktop = get_theme_mod( 'enable_spinner_desktop', false );
		$enable_spinner_mobile  = get_theme_mod( 'enable_spinner_mobile', true );

		/**
		 * Set page namespace theme (dark/light)
		 */
		switch ( $theme_page ) {
			case 'bg-white':
				$theme_header .= ' header_theme-white';
				break;
			case 'bg-light-grey':
				$theme_header .= ' header_theme-light-grey';
				break;
			case 'bg-light':
				$theme_header .= ' header_theme-light';
				break;
			case 'bg-blue-grey':
				$theme_header .= ' header_theme-blue-grey';
				break;
			case 'bg-blue-grey-dark':
				$theme_header .= ' header_theme-blue-grey-dark';
				break;
			case 'bg-dark':
				$theme_namespace = 'dark';
				$theme_header   .= ' header_white header_theme-dark';
				$theme_page     .= ' color-white';
				break;
			case 'bg-dark-2':
				$theme_namespace = 'dark';
				$theme_header   .= ' header_white header_theme-dark-2';
				$theme_page     .= ' color-white';
				break;
			case 'bg-black':
				$theme_namespace = 'dark';
				$theme_header   .= ' header_white header_theme-black';
				$theme_page     .= ' color-white';
				break;
			default:
				$theme_header .= ' header_theme-light-grey';
				$theme_page    = 'bg-light-grey';
				break;
		}

		/**
		 * Generate list of posts with featured images
		 */
		$loop_has_thumbnails = new WP_Query(
			array(
				'post_type'      => array(
					'page',
					'arts_portfolio_item',
				),
				'posts_per_page' => -1,
				'meta_key'       => '_thumbnail_id',
			)
		);

		$posts_with_thumbnails = array();
		$counter               = 0;

		if ( $loop_has_thumbnails->have_posts() ) {

			while ( $loop_has_thumbnails->have_posts() ) {

				$loop_has_thumbnails->the_post();
				$posts_with_thumbnails[ $counter ]['id']  = get_the_ID();
				$posts_with_thumbnails[ $counter ]['img'] = get_post_thumbnail_id();

				$counter++;

			}

			wp_reset_postdata();

		}

		/**
		 * Setup Classic Menu
		 */
		$args_menu_classic = array(
			'theme_location' => $menu_name,
			'container'      => false,
		);

		/**
		 * Setup Fullscreen Menu
		 */
		$args_menu_fullscreen = array(
			'theme_location' => $menu_name,
			'container'      => false,
			'menu_class'     => 'menu-overlay js-menu-overlay',
			'link_before'    => '<div class="menu-overlay__item-wrapper"><span class="split-chars">',
			'link_after'     => '</span></div>',
			'walker'         => new Arts_Walker_Nav_Menu_Overlay(),
		);

		if ( $menu_style == 'classic' ) {

			$class_wrapper_menu   = 'd-none d-xl-block';
			$class_wrapper_burger = 'd-xl-none';
			$header_has_widgets   = false;

		}

		$class_page .= $theme_page;

		if ( $class_header_controls == 'container' ) {
			$class_wrapper_overlay_menu = 'header__wrapper-menu_container';
		}

		if ( $enable_smooth_scroll == true && $smooth_scroll_elementor_canvas_template_enabled == true ) {

			$class_page .= ' js-smooth-scroll';

			if ( $enable_smooth_scroll_mobile == true ) {

				$class_page .= ' js-smooth-scroll_enable-mobile';

			}
		}

		if ( $enable_ajax ) {

			$attrs_wrapper = 'data-barba=wrapper';
			$attrs_page    = 'data-barba=container data-barba-namespace=' . $theme_namespace;

		}

		if ( $enhance_header_contrast ) {
			$class_header_controls .= ' blend-difference';
		}

		if ( $ajax_prevent_header_widgets ) {
			$attrs_wrapper_widgets = 'data-barba-prevent=all';
		}
		?>
		<?php if ( $enable_ajax ) : ?>
		<div <?php echo esc_attr( $attrs_wrapper ); ?>>
			<?php if ( $enable_spinner_desktop || $enable_spinner_mobile ) : ?>
				<!-- Loading Spinner -->
				<?php get_template_part( 'template-parts/svg/spinner' ); ?>
				<!-- - Loading Spinner -->
			<?php endif; ?>
	<?php endif; ?>

		<?php if ( $enable_cursor ) : ?>
		<!-- Cursor follower-->
			<?php get_template_part( 'template-parts/cursor/cursor' ); ?>
		<!-- - Cursor follower-->
	<?php endif; ?>

	<!-- Project hover backgrounds-->
	<div class="project-backgrounds">
		<?php if ( ! empty( $posts_with_thumbnails ) ) : ?>
			<?php foreach ( $posts_with_thumbnails as $current_post ) : ?>
				<?php
					arts_the_lazy_image(
						array(
							'id'        => $current_post['img'],
							'class'     => array(
								'image' => array( 'project-backgrounds__background' ),
							),
							'attribute' => array(
								'image' => array( 'data-background-for=' . $current_post['id'] ),
							),
						)
					);
				?>
			<?php endforeach; ?>
			<div class="project-backgrounds__overlay overlay overlay_dark"></div>
		<?php endif; ?>
	</div>
	<!-- - Project hover backgrounds-->

	<!-- PAGE PRELOADER -->
	<div class="preloader">
		<div class="preloader__curtain bg-dark-2"></div>
	</div>
	<!-- - PAGE PRELOADER -->

	<!-- PAGE HEADER -->
	<header class="header hidden <?php echo esc_attr( $theme_header ); ?>">
		<div class="header__container header__controls <?php echo esc_attr( $class_header_controls ); ?>">
			<div class="row justify-content-between align-items-center">
				<div class="col header__col-left <?php echo esc_attr( $class_header_col_left ); ?>">
					<?php get_template_part( 'template-parts/logo/logo' ); ?>
				</div>
				<?php if ( $has_menu && $menu_style == 'classic' ) : ?>
					<div class="col-auto header__col-right <?php echo esc_attr( $class_wrapper_menu ); ?>">
						<?php wp_nav_menu( $args_menu_classic ); ?>
					</div>
				<?php endif; ?>
				<?php if ( $header_has_lang_switcher ) : ?>
					<div class="col-auto">
						<div class="lang-switcher">
							<?php dynamic_sidebar( 'lang-switcher-sidebar' ); ?>
						</div>
					</div>
				<?php endif; ?>
				<?php if ( $has_menu ) : ?>
					<div class="col-auto header__col-right <?php echo esc_attr( $class_wrapper_burger ); ?>">
						<div class="header__burger" id="js-burger">
							<div class="header__burger-line"></div>
							<div class="header__burger-line"></div>
						</div>
					</div>
					<!-- - burger -->
					<div class="header__overlay-menu-back material-icons" id="js-submenu-back">arrow_back</div>
					<!-- - back button -->
				<?php endif; ?>
			</div>
		</div>
		<div class="header__wrapper-overlay-menu" data-os-animation="true">
			<?php if ( $has_menu ) : ?>
				<div class="header__wrapper-menu <?php echo esc_attr( $class_wrapper_overlay_menu ); ?>">
					<?php wp_nav_menu( $args_menu_fullscreen ); ?>
				</div>
				<!-- - menu -->
			<?php endif; ?>
			<?php if ( $header_has_widgets && $menu_style == 'fullscreen' ) : ?>
				<aside class="header__wrapper-overlay-widgets color-white bg-dark" <?php echo esc_attr( $attrs_wrapper_widgets ); ?>>
					<?php dynamic_sidebar( $header_widgets_id ); ?>
				</aside>
				<!-- - information widgets -->
			<?php endif; ?>
		</div>
	</header>
	<!-- - PAGE HEADER -->

	<!-- PAGE MAIN-->
	<main class="page-wrapper page-wrapper_hidden <?php echo esc_attr( $class_page ); ?>" <?php echo esc_attr( $attrs_page ); ?>>

		<?php
	}
);

/**
 * AFTER: Extra markup for Elementor Canvas template
 */
add_action(
	'elementor/page_templates/canvas/after_content',
	function() {
		$enable_ajax = get_theme_mod( 'enable_ajax', false );
		?>
		<canvas id="js-webgl"></canvas>
	</main>
	<!-- - PAGE MAIN-->
		<?php if ( $enable_ajax ) : ?>
		</div>
		<!-- - Barba Wrapper-->
	<?php endif; ?>
		<?php
	}
);
