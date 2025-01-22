<?php

$footer_columns             = get_theme_mod( 'footer_columns', 3 );
$page_footer_settings       = arts_get_document_option( 'page_footer_settings' );
$footer_hide                = false;
$class_container            = get_theme_mod( 'footer_container', 'container-fluid' );
$class_row                  = 'align-items-center';
$class_col                  = '';
$col_copyright              = 'col-lg-6';
$footer_has_active_sidebars = arts_footer_has_active_sidebars();
$footer_has_bottom_row      = is_active_sidebar( 'footer-sidebar-bottom' );

if ( $class_container == 'container' ) {
	$col_copyright = 'col';
}

$enable_ajax = get_theme_mod( 'enable_ajax', false );

switch ( $footer_columns ) {
	case 1: {
		$class_col  = 'col text-center';
		$class_row .= ' justify-content-center';
		break;
	}
	case 2: {
		$class_col = 'col-lg-6';
		break;
	}
	case 3: {
		$class_col = 'col-lg-4';
		break;
	}
	default: {
		$class_col = 'col-lg-3';
		$class_row = '';
		break;
	}
}

/**
 * Use Individual Page Footer Settings from Elementor
 * Or Use Global Settings from Customizer
 */
if ( $page_footer_settings ) {

	if ( arts_get_document_option( 'page_footer_hide' ) ) {
		$footer_hide = true;
	}
}

?>
				<?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) : ?>
					<?php if ( ( $footer_has_active_sidebars || $footer_has_bottom_row ) && ! $footer_hide ) : ?>
						<footer class="footer">
							<div class="footer__container <?php echo esc_attr( $class_container ); ?>">
								<?php if ( $footer_has_active_sidebars ) : ?>
									<div class="footer__area-primary">
										<div class="footer__row row <?php echo esc_attr( $class_row ); ?>">
											<?php for ( $i = 1; $i <= $footer_columns; $i++ ) : ?>
												<?php
												if ( is_active_sidebar( 'footer-sidebar-' . $i ) ) {

													$class_col_order = ' order-lg-' . $i;
													if ( $footer_columns == 2 && $i == 1 ) {
														$class_col = 'col-lg-6 text-left';
													}
													if ( $footer_columns == 2 && $i == 2 ) {
														$class_col = 'col-lg-6 text-right';
													}
													if ( $footer_columns == 3 && $i == 1 ) {
														$class_col = 'col-lg-4 text-left';
													}
													if ( $footer_columns == 3 && $i == 2 ) {
														$class_col = 'col-lg-4 text-center';
													}
													if ( $footer_columns == 3 && $i == 3 ) {
														$class_col = 'col-lg-4 text-right';
													}
													if ( get_theme_mod( 'order_column_' . $i ) > 1 ) {
														$order           = get_theme_mod( 'order_column_' . $i );
														$class_col_order = ' order-lg-' . $i . ' order-' . $order;
													}
													?>
												<div class="<?php echo esc_attr( $class_col . $class_col_order ); ?> footer__column">
													<?php dynamic_sidebar( 'footer-sidebar-' . $i ); ?>
												</div>
												<?php } ?>
											<?php endfor; ?>
										</div>
									</div>
								<?php endif; ?>
								<?php if ( $footer_has_bottom_row ) : ?>
									<div class="footer__area-secondary">
										<div class="row justify-content-center align-items-center">
											<div class="footer__col <?php echo esc_attr( $col_copyright ); ?>">
												<?php dynamic_sidebar( 'footer-sidebar-bottom' ); ?>
											</div>
										</div>
									</div>
								<?php endif; ?>
							</div>
						</footer>
					<?php endif; ?>
				<?php endif; ?>
				<canvas id="js-webgl"></canvas>
			</main>
			<!-- - PAGE MAIN-->
		<?php if ( $enable_ajax ) : ?>
			</div>
			<!-- - Barba Wrapper-->
		<?php endif; ?>
		<?php wp_footer(); ?>
	</body>
</html>
