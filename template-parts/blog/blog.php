<?php

$sidebar_position = get_theme_mod( 'sidebar_position', 'right_side' );

$posts_col_class   = 'col-lg-8 order-lg-1';
$sidebar_col_class = 'col-lg-3 order-lg-2';
$section_class     = '';

if ( $sidebar_position == 'left_side' ) {
	$posts_col_class   = 'col-lg-8 order-lg-2';
	$sidebar_col_class = 'col-lg-3 order-lg-1';
}

if ( is_active_sidebar( 'blog-sidebar' ) ) {
	$blog_row_class = 'row justify-content-between';
} else {
	$blog_row_class = 'row justify-content-center';
}
?>

<section class="section section_pt section_pb section-blog bg-light-grey <?php echo esc_attr( $section_class ); ?>">
	<div class="container">
		<div class="<?php echo esc_attr( $blog_row_class ); ?>">
			<div class="<?php echo esc_attr( $posts_col_class ); ?>">
				<?php if ( have_posts() ) : ?>
					<div class="section-blog__posts">
						<?php get_template_part( 'template-parts/loop/loop', 'blog' ); ?>
					</div>
					<!-- - posts -->
				<?php else : ?>
					<?php get_template_part( 'template-parts/content/content', 'none' ); ?>
				<?php endif; ?>
				<?php if ( get_the_posts_pagination() ) : ?>
					<div class="section-blog__wrapper-pagination">
						<?php arts_posts_pagination(); ?>
					</div>
					<!-- - pagination -->
				<?php endif; ?>
			</div>
			<?php if ( is_active_sidebar( 'blog-sidebar' ) ) : ?>
				<div class="<?php echo esc_attr( $sidebar_col_class ); ?>">
					<div class="section-blog__sidebar">
						<?php get_sidebar(); ?>
					</div>
				</div>
				<!-- - sidebar -->
			<?php endif; ?>
		</div>
	</div>
</section>
