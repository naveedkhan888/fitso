<?php

$post_show_readmore = get_theme_mod( 'post_show_read_more', true );
$post_show_info     = get_theme_mod( 'post_show_info', true );

$class_wrapper_meta    = 'col-lg-4';
$class_wrapper_content = 'col-lg-8';

if ( ! $post_show_info ) {
	$class_wrapper_content = 'col';
}

?>

<article <?php post_class( 'post post-preview' ); ?> id="post-<?php the_ID(); ?>">
	<?php if ( has_post_thumbnail() ) : ?>
		<a class="post-preview__media" href="<?php the_permalink(); ?>">
			<?php the_post_thumbnail(); ?>
		</a>
		<!-- - post media-->
	<?php endif; ?>

	<div class="row">
		<?php if ( $post_show_info ) : ?>
			<div class="<?php echo esc_attr( $class_wrapper_meta ); ?> post-preview__wrapper-meta">
				<?php get_template_part( 'template-parts/post/partials/post_info' ); ?>
			</div>
		<?php endif; ?>
		<div class="<?php echo esc_attr( $class_wrapper_content ); ?> post-preview__wrapper-content">
			<div class="post-preview__header">
				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			</div>
			<!-- - post header-->
			<?php get_template_part( 'template-parts/content/content', get_post_format() ); ?>
			<?php if ( $post_show_readmore ) : ?>
				<div class="post-preview__wrapper-readmore">
					<?php get_template_part( 'template-parts/post/partials/post_read_more' ); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<!-- - post content & meta-->
</article>
