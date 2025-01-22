<?php $masthead_style = get_theme_mod( 'masthead_style', 'solid_color' ); ?>

<article <?php post_class( 'post' ); ?> id="post-<?php the_ID(); ?>">
	<div class="post__content clearfix">		
		<?php if ( has_post_thumbnail() && $masthead_style == 'solid_color' ) : ?>
			<div class="post__media" href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail(); ?>
			</div>
			<!-- - post media-->
		<?php endif; ?>
		<?php the_content(); ?>
		<?php
			wp_link_pages(
				array(
					'before'      => '<div class="page-links">' . esc_html__( 'Pages:', 'rubenz' ),
					'after'       => '</div>',
					'link_before' => '<span class="page-number">',
					'link_after'  => '</span>',
				)
			);
			?>
	</div>
	<!-- .post__content -->

	<?php if ( wp_get_post_tags( $post->ID ) ) : ?>
		<div class="post__tags">
			<div class="tagcloud">
				<?php the_tags( '', '', '' ); ?>
			</div>
		</div>
		<!-- .post__tags -->
	<?php endif; ?>

	<?php if ( comments_open() || get_comments_number() ) : ?>
		<div class="post__comments">
			<?php comments_template(); ?>
		</div>
		<!-- .post__comments -->
	<?php endif; ?>
</article>
