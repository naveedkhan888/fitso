<?php

/**
 * Wrapper for Plugin Function
 * for Elementor
 */
if ( ! function_exists( 'arts_get_document_option' ) ) {
	function arts_get_document_option( $option, $post_id = null, $option_default = false ) {
		if ( did_action( 'elementor/loaded' ) && function_exists( 'arts_elementor_get_document_option' ) ) {
			return arts_elementor_get_document_option( $option, $post_id, $option_default );
		}
	}
}

/**
 * Check if the current post/page
 * is built using Elementor
 *
 * @param string $post_id
 * @return bool
 */
function arts_is_built_with_elementor( $post_id = null ) {
	if ( ! class_exists( '\Elementor\Plugin' ) ) {
		return false;
	}

	// blog page
	if ( is_home() ) {
		$post_id = get_option( 'page_for_posts' );
	}

	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	if ( is_singular() && \Elementor\Plugin::$instance->documents->get( $post_id ) && \Elementor\Plugin::$instance->documents->get( $post_id )->is_built_with_elementor() ) {
		return true;
	}

	return false;
}

/**
 * Check if Elementor editor
 * is active
 *
 * @return bool
 */
function arts_is_elementor_editor_active() {
	if ( class_exists( '\Elementor\Plugin' ) && \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
		return true;
	}
	return false;
}

/**
 * Check if Elementor's experimental feature
 * is supported and active
 *
 * @return bool
 */
function arts_is_elementor_feature_active( $feature_name ) {
	return class_exists( '\Elementor\Plugin' ) && isset( \Elementor\Plugin::instance()->experiments ) && \Elementor\Plugin::instance()->experiments->is_feature_active( $feature_name );
}
