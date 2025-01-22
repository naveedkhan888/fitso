<div class="figure-property">
	<div class="figure-property__wrapper-heading">
		<h6 class="split-text"><?php echo wp_kses_post( get_sub_field( 'name' ) ); ?></h6>
	</div>
	<?php if ( have_rows( 'list' ) ) : ?>
		<div class="figure-property__content">
			<ul class="figure-property__list">
			<?php while ( have_rows( 'list' ) ) : ?>
				<?php the_row(); ?>
				<li class="figure-property__item">
					<div class="split-text"><?php echo wp_kses_post( get_sub_field( 'value' ) ); ?></div>
				</li>
				<?php endwhile; ?>
			</ul>
		</div>
	<?php endif; ?>
</div>
