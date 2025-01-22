<?php

$post_show_info             = get_theme_mod( 'post_show_info', true );
$post_show_date             = get_theme_mod( 'post_show_date', true );
$post_show_categories       = get_theme_mod( 'post_show_categories', true );
$post_show_comments_counter = get_theme_mod( 'post_show_comments_counter', true );
$post_show_author           = get_theme_mod( 'post_show_author', true );
$date_link                  = get_month_link( get_post_time( 'Y' ), get_post_time( 'm' ) );
$author                     = arts_get_post_author();

?>

<?php if ( $post_show_info ) : ?>
	<?php if ( $post_show_date ) : ?>
		<div class="post-preview__meta post-preview__date">
			<a href="<?php echo esc_attr( $date_link ); ?>"><?php echo esc_html( get_the_date() ); ?></a>
		</div>
	<?php endif; ?>

	<?php if ( $post_show_categories ) : ?>
		<?php if ( has_category() ) : ?>
			<div class="post-preview__meta">
				<?php the_category( ',&nbsp;' ); ?>
			</div>
		<?php endif; ?>
	<?php endif; ?>

	<?php if ( $post_show_comments_counter ) : ?>
		<div class="post-preview__meta">
			<a href="<?php echo get_comments_link( get_the_ID() ); ?>"><?php comments_number(); ?></a>
		</div>
	<?php endif; ?>

	<?php if ( ! empty( $author['name'] ) && $post_show_author ) : ?>
		<div class="post-preview__meta">
			<span class="post-meta__item-text"><?php esc_html_e( 'by', 'rubenz' ); ?></span>
			<a href="<?php echo esc_url( $author['url'] ); ?>"><?php echo esc_html( $author['name'] ); ?></a>
		</div>
	<?php endif; ?>
<?php endif; ?>
