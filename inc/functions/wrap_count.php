<?php

/**
 * Filter the categories archive widget to add a span around post count
 */
add_filter( 'wp_list_categories', 'arr_cat_count_span' );
function arr_cat_count_span( $links ) {
	$links = str_replace( '</a> (', '</a><span>', $links );
	$links = str_replace( ')', '</span>', $links );
	return $links;
}

/**
 * Filter the archives widget to add a span around post count
 */
add_filter( 'get_archives_link', 'arr_archive_count_span' );
function arr_archive_count_span( $links ) {
	$links = str_replace( '</a>&nbsp;(', '</a><span>', $links );
	$links = str_replace( ')', '</span>', $links );
	return $links;
}
