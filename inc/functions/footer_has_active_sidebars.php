<?php

/**
 * Check if there is at least 1 active
 * sidebar in footer
 *
 * @return bool
 */
function arts_footer_has_active_sidebars() {
	$footer_columns = get_theme_mod( 'footer_columns', 3 );

	for ( $i = 1; $i <= $footer_columns; $i++ ) {
		if ( is_active_sidebar( 'footer-sidebar-' . $i ) ) {
			return true;
		}
	}

	return false;
}
