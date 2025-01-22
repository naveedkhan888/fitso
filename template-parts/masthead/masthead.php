<?php

$page_title                    = '';
$page_subtitle                 = '';
$class_section                 = '';
$attrs_backgorund              = '';
$attrs_section                 = '';
$class_background              = '';
$class_inner                   = '';
$class_overlay                 = '';
$thumbnail                     = '';
$masthead_layout               = '';
$masthead_color                = '';
$masthead_image_parallax       = '';
$masthead_image_parallax_speed = '';
$masthead_subheading           = '';
$class_alignment               = '';
$class_properties              = '';
$class_meta                    = '';
$is_elementor_page             = arts_is_built_with_elementor();
$blog_page_id                  = get_option( 'page_for_posts' );

if ( $is_elementor_page ) {

	$class_overlay                 = 'd-none';
	$thumbnail                     = get_post_thumbnail_id();
	$video_bg                      = arts_get_field( 'video', get_the_ID() );
	$masthead_layout               = arts_get_document_option( 'page_masthead_layout' );
	$masthead_color                = arts_get_document_option( 'page_masthead_color_theme' );
	$masthead_image_parallax       = arts_get_document_option( 'page_masthead_image_parallax' );
	$masthead_image_parallax_speed = arts_get_document_option( 'page_masthead_image_parallax_speed' )['size'];
	$masthead_subheading           = arts_get_field( 'subheading' );
	$class_alignment               = arts_get_document_option( 'page_masthead_alignment' );
	$class_properties              = $class_alignment;
	$attrs_section                 = 'data-os-animation=true';

} else {

	$class_section    = 'section_pt section_pb';
	$class_alignment  = get_theme_mod( 'masthead_alignment', 'text-left' );
	$class_properties = $class_alignment;
	$masthead_style   = get_theme_mod( 'masthead_style', 'solid_color' );

	if ( $masthead_style == 'background_image' ) {

		if ( is_singular( 'post' ) && has_post_thumbnail() ) {
			$thumbnail                     = get_post_thumbnail_id();
			$masthead_image_parallax       = get_theme_mod( 'masthead_image_parallax', true );
			$masthead_image_parallax_speed = get_theme_mod( 'masthead_image_parallax_speed', 0.1 );
			$class_background             .= ' section-masthead__background_fullscreen';
			$class_section                .= ' section-masthead_blog color-white';
		}

		if ( is_home() && has_post_thumbnail( $blog_page_id ) ) {
			$thumbnail                     = get_post_thumbnail_id( $blog_page_id );
			$masthead_image_parallax       = get_theme_mod( 'masthead_image_parallax', true );
			$masthead_image_parallax_speed = get_theme_mod( 'masthead_image_parallax_speed', 0.1 );
			$class_background             .= ' section-masthead__background_fullscreen';
			$class_section                .= ' section-masthead_blog color-white';
		}
	}
}

if ( is_category() ) {

	$page_title    = get_category( get_query_var( 'cat' ) )->name;
	$page_subtitle = esc_html__( 'Posts in category', 'rubenz' );

} elseif ( is_author() ) {

	$page_title    = get_userdata( get_query_var( 'author' ) )->display_name;
	$page_subtitle = esc_html__( 'Posts by author', 'rubenz' );

} elseif ( is_tag() ) {

	$page_title    = single_tag_title( '', false );
	$page_subtitle = esc_html__( 'Posts with tag', 'rubenz' );

} elseif ( is_day() ) {

	$page_title    = get_the_date();
	$page_subtitle = esc_html__( 'Day archive', 'rubenz' );

} elseif ( is_month() ) {

	$page_title    = get_the_date( 'F Y' );
	$page_subtitle = esc_html__( 'Month archive', 'rubenz' );

} elseif ( is_year() ) {

	$page_title    = get_the_date( 'Y' );
	$page_subtitle = esc_html__( 'Year archive', 'rubenz' );

} elseif ( is_home() ) {

	$page_title = wp_title( '', false );

} elseif ( is_search() ) {

	$default_title = esc_html__( 'Search', 'rubenz' );
	$page_title    = get_theme_mod( 'search_title', $default_title );

} else {

	$page_title    = get_the_title();
	$page_subtitle = '';

}

if ( ! $page_title ) {
	$page_title = esc_html__( 'Blog', 'rubenz' );
}

if ( $masthead_image_parallax ) {

	$attrs_backgorund .= ' data-art-parallax=true';
	$attrs_backgorund .= " data-art-parallax-factor={$masthead_image_parallax_speed} ";

}

switch ( $masthead_layout ) {
	case 'content_top':
		$class_layout      = arts_get_document_option( 'page_masthead_image_layout' );
		$class_section    .= ' section_pt';
		$class_background .= ' section-masthead__background_bottom ' . $class_layout;
		break;
	case 'halfscreen_content_left':
		$class_section    .= ' section-masthead_fullheight section-fullheight section-masthead_fullheight-halfscreen';
		$class_inner      .= ' section-fullheight__inner';
		$class_background .= ' section-masthead__background_fullscreen';
		$class_properties .= ' section-masthead__properties_bottom';
		break;
	case 'halfscreen_content_right':
		$class_section    .= ' section-masthead_fullheight section-fullheight section-masthead_fullheight-halfscreen section-masthead_fullheight-halfscreen-reverse';
		$class_inner      .= ' section-fullheight__inner';
		$class_background .= ' section-masthead__background_fullscreen';
		$class_properties .= ' section-masthead__properties_bottom';
		break;
	case 'fullscreen':
		$class_section    .= ' section-masthead_fullheight section-fullheight color-white';
		$class_inner      .= ' section-fullheight__inner';
		$class_background .= ' section-masthead__background_fullscreen';
		$class_properties .= ' section-masthead__properties_bottom';
		$class_overlay     = '';
		break;
}

switch ( $class_alignment ) {
	case 'text-left':
		$class_properties .= ' justify-content-lg-start';
		break;
	case 'text-center':
		$class_properties .= ' justify-content-lg-center';
		break;
	case 'text-right':
		$class_properties .= ' justify-content-lg-end';
		break;
}

?>

<!-- section MASTHEAD -->
<section class="section section-masthead <?php echo esc_attr( $class_section ); ?>" <?php echo esc_attr( $attrs_section ); ?>>
	<div class="section-masthead__inner <?php echo esc_attr( $class_inner ); ?>">
		<div class="container-fluid">
			<header class="row section-masthead__header <?php echo esc_attr( $class_alignment ); ?>">
				<div class="col">
					<?php if ( $page_title ) : ?>
						<h1 class="entry-title split-chars"><?php echo esc_html( $page_title ); ?></h1>
						<div class="section__headline"></div>
					<?php endif; ?>
					<?php if ( $masthead_subheading ) : ?>
						<h2 class="heading-light split-text"><?php echo wp_kses( $masthead_subheading, wp_kses_allowed_html( 'post' ) ); ?></h2>
					<?php endif; ?>
					<?php if ( is_singular( 'post' ) ) : ?>
						<div class="section-masthead__meta <?php echo esc_attr( $class_properties ); ?>">
							<?php get_template_part( 'template-parts/post/partials/post_info' ); ?>
						</div>
					<?php endif; ?>
				</div>
			</header>
			<?php if ( arts_have_rows( 'properties' ) ) : ?>
				<div class="row section-masthead__properties <?php echo esc_attr( $class_properties ); ?>">
					<?php while ( have_rows( 'properties' ) ) : ?>
						<?php the_row(); ?>
						<div class="col-lg-auto col-sm-6 section-masthead__wrapper-property">
							<?php get_template_part( 'template-parts/property/property' ); ?>
						</div>
					<?php endwhile; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<?php if ( ! empty( $thumbnail ) ) : ?>
		<div class="section section-masthead__background <?php echo esc_attr( $class_background ); ?>" <?php echo esc_attr( $attrs_backgorund ); ?>>
			<?php
				arts_the_lazy_image(
					array(
						'id'    => $thumbnail,
						'class' => array(
							'image' => array( 'art-parallax__bg' ),
						),
					)
				);
			?>
			<div class="overlay overlay_dark section-masthead__overlay <?php echo esc_attr( $class_overlay ); ?>"></div>
		</div>
	<?php endif; ?>
</section>
<!-- - section MASTHEAD -->
