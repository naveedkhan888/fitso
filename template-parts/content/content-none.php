<?php

/**
 * Content: None
 */

?>

<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
	<p><?php echo sprintf( '%1$s <a href="%2$s">%3$s</a>', esc_html__( 'Ready to publish your first post?', 'fitso' ), esc_url( admin_url( 'post-new.php' ) ), esc_html__( 'Get started here!', 'fitso' ) ); ?>
<?php elseif ( is_search() ) : ?>
	<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'fitso' ); ?></p>
	<?php get_search_form(); ?>
<?php else : ?>
	<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'fitso' ); ?></p>
	<?php get_search_form(); ?>
<?php endif; ?>
