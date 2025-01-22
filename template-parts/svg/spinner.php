<?php

$class_spinner = '';

$enable_spinner_desktop = get_theme_mod( 'enable_spinner_desktop', false );
$enable_spinner_mobile  = get_theme_mod( 'enable_spinner_mobile', true );

if ( $enable_spinner_desktop ) {
	$class_spinner .= ' d-lg-block';
} else {
	$class_spinner .= ' d-lg-none';
}

if ( $enable_spinner_mobile ) {
	$class_spinner .= ' d-block';
} else {
	$class_spinner .= ' d-none';
}

?>

<svg class="spinner js-spinner <?php echo esc_attr( $class_spinner ); ?>" width="65px" height="65px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
	<circle class="spinner__path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle>
</svg>
