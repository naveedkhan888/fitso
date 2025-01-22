<?php while ( have_posts() ) :
	the_post(); ?>
	<div class="section-blog__wrapper-post">
		<?php if ( is_single() ) : ?>
			<?php get_template_part( 'template-parts/post/post', 'single' ); ?>
		<?php else : ?>
			<?php get_template_part( 'template-parts/post/post' ); ?>
		<?php endif; ?>
	</div>
<?php endwhile; ?>
