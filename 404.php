<?php
	$page_title    = get_theme_mod( '404_title', esc_html__( 'Page not Found', 'rubenz' ) );
	$page_subtitle = get_theme_mod( '404_message', esc_html__( 'It looks like nothing found here. Try to navigate the menu or return to the home page.', 'rubenz' ) );
	$page_big      = get_theme_mod( '404_big', esc_html__( '404', 'rubenz' ) );
	$page_button   = get_theme_mod( '404_button', esc_html__( 'Back to homepage', 'rubenz' ) );
?>

<?php get_header(); ?>

<!-- section 404 -->
<section class="section section-404 section-fullheight">
	<div class="section-fullheight__inner">
		<div class="container">
			<div class="section-404__big"><?php echo esc_html( $page_big ); ?></div>
			<header class="row section__header section-404__header">
				<div class="col-lg-8">
					<h1><?php echo esc_html( $page_title ); ?></h1>
					<div class="section__headline"></div>
					<p><?php echo esc_html( $page_subtitle ); ?></p>
				</div>
			</header>
			<div class="row section-404__wrapper-button">
				<div class="col-12"><a class="button button button_solid button_dark" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( $page_button ); ?></a>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- - section 404 -->

<?php get_footer(); ?>
