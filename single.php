<?php

$is_elementor_page    = arts_is_built_with_elementor();
$enable_portfolio_nav = get_theme_mod( 'enable_portfolio_nav', true );
$post_type            = get_post_type();

get_header();
get_template_part( 'template-parts/masthead/masthead' );
the_post();
?>

<?php if ( ! $is_elementor_page ) : ?>
	<section class="section section_pt section_pb bg-light-grey section-blog">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col">
					<div class="post">
						<div class="post__content clearfix">
							<?php the_content(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php else : ?>
	<?php the_content(); ?>
<?php endif; ?>

<?php

if ( $post_type == 'arts_portfolio_item' && $is_elementor_page && $enable_portfolio_nav ) {
	get_template_part( 'template-parts/nav/nav', 'portfolio' );
}

get_footer();
