<?php

$next_post  = get_previous_post();
$prev_post  = get_next_post();
$current_id = get_the_ID();
$next_link;
$next_title;
$next_img;
$prev_link;
$prev_title;
$prev_img;
$attr_link                          = '';
$class_link                         = 'col';
$class_link_prev                    = '';
$prev_label                         = get_theme_mod( 'portfolio_nav_prev_title', esc_html__( 'Prev', 'rubenz' ) );
$next_label                         = get_theme_mod( 'portfolio_nav_next_title', esc_html__( 'Next', 'rubenz' ) );
$enable_portfolio_loop              = get_theme_mod( 'enable_portfolio_loop', true );
$enable_portfolio_next_first_mobile = get_theme_mod( 'enable_portfolio_next_first_mobile', false );

$args  = array(
	'post_type'      => 'arts_portfolio_item',
	'posts_per_page' => -1,
);
$posts = get_posts( $args );

$first_post = current( $posts );
$last_post  = end( $posts );

if ( $next_post ) {
	$next_link  = get_permalink( $next_post );
	$next_title = $next_post->post_title;
	$next_img   = get_post_thumbnail_id( $next_post->ID );
}

if ( ! $next_post && $enable_portfolio_loop ) {
	$next_post  = $first_post;
	$next_link  = get_permalink( $next_post );
	$next_title = $next_post->post_title;
	$next_img   = get_post_thumbnail_id( $next_post->ID );
}

if ( $prev_post ) {
	$prev_link  = get_permalink( $prev_post );
	$prev_title = $prev_post->post_title;
	$prev_img   = get_post_thumbnail_id( $prev_post->ID );
}

if ( ! $prev_post && $enable_portfolio_loop ) {
	$prev_post  = $last_post;
	$prev_link  = get_permalink( $prev_post );
	$prev_title = $prev_post->post_title;
	$prev_img   = get_post_thumbnail_id( $prev_post->ID );
}

if ( $next_post && $prev_post ) {
	$class_link = 'col-md-6';
}

if ( $enable_portfolio_next_first_mobile ) {
	$class_link_prev = 'order-md-0 order-2';
}

?>

<?php if ( $next_post || $prev_post ) : ?>
	<!-- section NAV PROJECTS -->
	<section class="section section-nav-projects container-fluid no-gutters">
		<div class="row no-gutters h-100">
			<?php if ( $prev_post ) : ?>
				<?php
				if ( $prev_img ) {
					$attr_link = 'data-pjax-link=navProjects';
				}
				?>
				<a class="section-nav-projects__inner section-nav-projects__inner_prev <?php echo esc_attr( $class_link ); ?> <?php echo esc_attr( $class_link_prev ); ?>" href="<?php echo esc_url( $prev_link ); ?>" <?php echo esc_attr( $attr_link ); ?> data-post-id="<?php echo esc_attr( $prev_post->ID ); ?>">
					<?php if ( ! empty( $prev_label ) ) : ?>
						<div class="section-nav-projects__label section-nav-projects__label_prev"><?php echo esc_html( $prev_label ); ?></div>
					<?php endif; ?>
					<div class="section-nav-projects__arrow"><i class="material-icons">keyboard_arrow_left</i></div>
					<h3><?php echo esc_html( $prev_title ); ?></h3>
				</a>
			<?php endif; ?>
			<?php if ( $next_post ) : ?>
				<?php
				if ( $next_img ) {
					$attr_link = 'data-pjax-link=navProjects';
				}
				?>
				<a class="section-nav-projects__inner section-nav-projects__inner_next <?php echo esc_attr( $class_link ); ?>" href="<?php echo esc_url( $next_link ); ?>" <?php echo esc_attr( $attr_link ); ?> data-post-id="<?php echo esc_attr( $next_post->ID ); ?>">
					<?php if ( ! empty( $next_label ) ) : ?>
						<div class="section-nav-projects__label section-nav-projects__label_next"><?php echo esc_html( $next_label ); ?></div>
					<?php endif; ?>
					<h3><?php echo esc_html( $next_title ); ?></h3>
					<div class="section-nav-projects__arrow"><i class="material-icons">keyboard_arrow_right</i></div>
				</a>
			<?php endif; ?>
		</div>
		<div class="section-nav-projects__backgrounds">
			<?php if ( $prev_post && ! empty( $prev_img ) ) : ?>
				<?php
					arts_the_lazy_image(
						array(
							'id'        => $prev_img,
							'class'     => array(
								'image' => array( 'section-nav-projects__background', 'section-nav-projects__background_prev' ),
							),
							'attribute' => array(
								'image' => array( 'data-background-for=' . $prev_post->ID ),
							),
						)
					);
				?>
			<?php endif; ?>
			<?php if ( $next_post && ! empty( $next_img ) ) : ?>
				<?php
					arts_the_lazy_image(
						array(
							'id'        => $next_img,
							'class'     => array(
								'image' => array( 'section-nav-projects__background', 'section-nav-projects__background_next' ),
							),
							'attribute' => array(
								'image' => array( 'data-background-for=' . $next_post->ID ),
							),
						)
					);
				?>
			<?php endif; ?>
			<div class="overlay overlay_dark section-nav-projects__overlay"></div>
		</div>
	</section>
	<!-- - section NAV PROJECTS -->
<?php endif; ?>
