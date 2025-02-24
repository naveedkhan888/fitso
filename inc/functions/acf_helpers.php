<?php

/**
 * ACF Helper Functions
 */

if ( ! function_exists( 'xpertpoint_have_rows' ) ) {
	function xpertpoint_have_rows( $args, $options = '' ) {
		if ( function_exists( 'have_rows' ) ) {
			return have_rows( $args, $options );
		} else {
			return false;
		}
	}
}

if ( ! function_exists( 'xpertpoint_get_field' ) ) {
	function xpertpoint_get_field( $args, $options = '' ) {
		if ( function_exists( 'get_field' ) ) {
			return get_field( $args, $options );
		} else {
			return false;
		}
	}
}

if ( ! function_exists( 'xpertpoint_get_sub_field' ) ) {
	function xpertpoint_get_sub_field( $args, $options = '' ) {
		if ( function_exists( 'get_sub_field' ) ) {
			return get_sub_field( $args, $options );
		} else {
			return false;
		}
	}
}
