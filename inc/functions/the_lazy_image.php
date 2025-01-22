<?php

/**
 * Markup for lazy background/image/video
 */
if ( ! function_exists( 'arts_the_lazy_image' ) ) {
	function arts_the_lazy_image( $args ) {
		$defaults = array(
			'id'        => null,
			'type'      => 'background',
			'size'      => 'full',
			'class'     => array(
				'section' => array(),
				'wrapper' => array(),
				'image'   => array(),
			),
			'attribute' => array(
				'image' => array(),
			),
			'parallax'  => array(
				'enabled' => false,
				'factor'  => 0.1,
			),
		);

		$class_section = '';
		$attrs_section = '';

		$attrs_wrapper = '';
		$class_wrapper = '';

		$class_media = '';
		$attrs_media = '';

		$lazy_placeholder_src       = '#';
		$lazy_placeholder_type      = get_theme_mod( 'lazy_placeholder_type', 'inline' );
		$lazy_placeholder_inline    = get_theme_mod( 'lazy_placeholder_inline', 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAHCGzyUAAAABGdBTUEAALGPC/xhBQAAADhlWElmTU0AKgAAAAgAAYdpAAQAAAABAAAAGgAAAAAAAqACAAQAAAABAAAAAaADAAQAAAABAAAAAQAAAADa6r/EAAAAC0lEQVQI12NolQQAASYAn89qhTcAAAAASUVORK5CYII=' );
		$lazy_placeholder_image_url = get_theme_mod( 'lazy_placeholder_image_url', '' );

		if ( $lazy_placeholder_type === 'inline' && ! empty( $lazy_placeholder_inline ) ) {
			$lazy_placeholder_src = $lazy_placeholder_inline;
		}

		if ( $lazy_placeholder_type === 'custom_image' && ! empty( $lazy_placeholder_image_url ) ) {
			$lazy_placeholder_src = $lazy_placeholder_image_url;
		}

		$lazy_placeholder_src = apply_filters( 'arts/lazy/placeholder', $lazy_placeholder_src );

		$args = wp_parse_args( $args, $defaults );

		if ( ! $args['id'] || ! $args['type'] ) {
			return;
		}

		// section
		if ( array_key_exists( 'section', $args['class'] ) && is_array( $args['class']['section'] ) && ! empty( $args['class']['section'] ) ) {
			$class_section = implode( ' ', $args['class']['section'] );
		}

		// wrapper
		if ( array_key_exists( 'wrapper', $args['class'] ) && is_array( $args['class']['wrapper'] ) && ! empty( $args['class']['wrapper'] ) ) {
			$class_wrapper = implode( ' ', $args['class']['wrapper'] );
		}

		// image class
		if ( array_key_exists( 'image', $args['class'] ) && is_array( $args['class']['image'] ) && ! empty( $args['class']['image'] ) ) {
			$class_media = implode( ' ', $args['class']['image'] );
		}

		// image attributes
		if ( array_key_exists( 'image', $args['attribute'] ) && is_array( $args['attribute']['image'] ) && ! empty( $args['attribute']['image'] ) ) {
			$attrs_media = implode( ' ', $args['attribute']['image'] );
		}

		// parallax
		if ( array_key_exists( 'parallax', $args ) && is_array( $args['parallax'] ) && $args['parallax']['enabled'] ) {
			$attrs_wrapper .= ' data-art-parallax=true';
			$attrs_wrapper .= ' data-art-parallax-factor=' . floatval( $args['parallax']['factor'] );
		}

		switch ( $args['type'] ) {
			case 'background':
				$class_media .= ' lazy-bg of-cover';
				break;
			case 'image':
				if ( $args['class']['wrapper'] !== false ) {
					$class_wrapper .= ' lazy';
				}
				break;
			case 'background-video':
				$class_media .= ' of-cover';
				break;
			case 'video':
				break;
		}

		if ( $args['type'] === 'background' || $args['type'] === 'image' ) {
			$attrs                    = wp_get_attachment_image_src( $args['id'], $args['size'] );
			$srcset                   = '';
			$sizes                    = '';
			$alt                      = get_post_meta( $args['id'], '_wp_attachment_image_alt', true );
			$full_size_images_enabled = get_theme_mod( 'full_size_images_enabled', false );
			$enable_optimized_sizes   = apply_filters( 'arts/lazy/enable_optimized_sizes', ! $full_size_images_enabled );

			if ( $enable_optimized_sizes ) {
				$srcset = wp_get_attachment_image_srcset( $args['id'], $args['size'] );
				$sizes  = wp_get_attachment_image_sizes( $args['id'], $args['size'] );
			}
		}

		?>
		<?php if ( ! empty( $class_section ) || ! empty( $attrs_section ) ) : ?>
			<div class="<?php echo esc_attr( $class_section ); ?>" <?php echo esc_attr( $attrs_section ); ?>>
		<?php endif; ?>
			<?php if ( ! empty( $class_wrapper ) || ! empty( $attrs_wrapper ) ) : ?>
				<?php if ( $args['type'] === 'image' ) : ?>
					<div class="d-inline-block lazy-wrapper overflow" style="max-height: <?php echo esc_attr( $attrs[2] ); ?>px;">
						<div class="<?php echo esc_attr( $class_wrapper ); ?>" <?php echo esc_attr( $attrs_wrapper ); ?> style="padding-bottom: calc( (<?php echo esc_attr( $attrs[2] ); ?> / <?php echo esc_attr( $attrs[1] ); ?>) * 100% ); height: 0;">
				<?php else : ?>
					<div class="<?php echo esc_attr( $class_wrapper ); ?>" <?php echo esc_attr( $attrs_wrapper ); ?>>
				<?php endif; ?>
			<?php endif; ?>
				<?php
				switch ( $args['type'] ) {
					case 'background':
						?>
							<img class="<?php echo esc_attr( $class_media ); ?>" src="<?php echo esc_attr( $lazy_placeholder_src ); ?>" data-src="<?php echo esc_attr( $attrs[0] ); ?>" data-srcset="<?php echo esc_attr( $srcset ); ?>" data-sizes="<?php echo esc_attr( $sizes ); ?>" alt="<?php echo esc_attr( $alt ); ?>" <?php echo esc_attr( $attrs_media ); ?> />
							<?php
						break;
					case 'image':
						?>
							<img class="<?php echo esc_attr( $class_media ); ?>" src="<?php echo esc_attr( $lazy_placeholder_src ); ?>" data-src="<?php echo esc_attr( $attrs[0] ); ?>" width="<?php echo esc_attr( $attrs[1] ); ?>" height="<?php echo esc_attr( $attrs[2] ); ?>" data-srcset="<?php echo esc_attr( $srcset ); ?>" data-sizes="<?php echo esc_attr( $sizes ); ?>" alt="<?php echo esc_attr( $alt ); ?>"/>
							<?php
						break;
					case 'background-video':
						?>
							<video class="<?php echo esc_attr( $class_media ); ?>" src="<?php echo esc_url( wp_get_attachment_url( $args['id'] ) ); ?>" playsinline loop muted autoplay></video>
							<?php
						break;
					case 'video':
						?>
							<video class="<?php echo esc_attr( $class_media ); ?>" src="<?php echo esc_url( wp_get_attachment_url( $args['id'] ) ); ?>" playsinline loop muted autoplay></video>
							<?php
						break;
				}
				?>
			<?php if ( ! empty( $class_wrapper ) ) : ?>
				</div>
				<?php if ( $args['type'] === 'image' ) : ?>
					</div>
				<?php endif; ?>
			<?php endif; ?>
		<?php if ( ! empty( $class_section ) || ! empty( $attrs_section ) ) : ?>
			</div>
		<?php endif; ?>
		<?php
	}
}
