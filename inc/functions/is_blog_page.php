<?php

/**
 * Check if the current page belongs to WordPress blog
 */
function arts_is_blog_page() {
	global $post;

	// Post type must be 'post'.
	$post_type = get_post_type( $post );

	// Check all blog-related conditional tags, as well as the current post type,
	// to determine if we're viewing a blog page.
	return (
	  ( is_home() || is_archive() || is_single() )
	  && ( $post_type == 'post' )
	) ? true : false;
}
