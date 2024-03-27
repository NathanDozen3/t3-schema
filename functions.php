<?php

namespace t3\schema;

/**
 * Minify an HTML string.
 *
 * @param string $buffer
 *
 * @return string
 */
function minify_html( string $buffer ) : string {
	$search = array(
		'/\>[^\S ]+/s',      // strip whitespaces after tags, except space
		'/[^\S ]+\</s',      // strip whitespaces before tags, except space
		'/(\s)+/s',          // shorten multiple whitespace sequences
		'/<!--(.|\s)*?-->/', // Remove HTML comments
		"/[\n\r]/"           // Remove newlines
	);

	$replace = array(
		'>',
		'<',
		'\\1',
		'',
		''
	);
	return preg_replace( $search, $replace, $buffer );
}


/**
 * Include the partial file.
 *
 * @param string $partial
 * @param array $args
 *
 * @return void
 */
function get_partial( string $partial, array $args = [] ) : void {
	$file = T3_DIR . '/partials/' . $partial . '.php';
	if( ! file_exists( $file ) ) {
		wp_die( "File does not exist. <br>\n $file");
	}
	require $file;
}


/**
 * Get the higher contrast color between white and black.
 *
 * @param string $hexColor
 * @see https://stackoverflow.com/a/42921358
 *
 * @return string
 */
function get_contrast_color( string $hexColor ) : string {
	$hexColor = ltrim( $hexColor, '#' );

	// hexColor RGB
	$R1 = hexdec(substr($hexColor, 0, 2));
	$G1 = hexdec(substr($hexColor, 2, 2));
	$B1 = hexdec(substr($hexColor, 4, 2));

	// Calculate Luminosity
	$L1 = 0.2126 * pow($R1 / 255, 2.2) +
		0.7152 * pow($G1 / 255, 2.2) +
		0.0722 * pow($B1 / 255, 2.2);

	$L2 = 0;

	$contrastRatio = 0;
	if ($L1 > $L2) {
		$contrastRatio = (int)(($L1 + 0.05) / ($L2 + 0.05));
	} else {
		$contrastRatio = (int)(($L2 + 0.05) / ($L1 + 0.05));
	}
	return $contrastRatio > 5 ? '#000000' : '#FFFFFF';
}


/**
 * Given an array of block attributes, return the block styles.
 *
 * @param array $attributes
 *
 * @return string
 */
function get_block_styles( array $attributes ) : string {
	$style = '';
	if( ! isset( $attributes[ 'button__background_color__active' ] ) ) {
		$attributes[ 'button__background_color__active' ] = $attributes[ 'button__background_color' ];
	}
	foreach( $attributes as $key => $value ) {
		$key = str_replace( '_', '-', $key );
		$style .= "--t3--faq--$key: $value;";
	}
	$value = get_contrast_color( $attributes[ 'button__background_color' ] );
	$style .= "--t3--faq--button--color: $value;";

	$value = get_contrast_color( $attributes[ 'button__background_color__active' ] ?? $attributes[ 'button__background_color' ] );
	$style .= "--t3--faq--button--color--active: $value;";
	return $style;
}


/**
 * Prepend namespace to string action callbacks.
 *
 * @param string $hook
 * @param string|array|callable $callback
 * @param int $priority
 * @param int $args
 *
 * @return void
 */
function add_action( string $hook, string|array|callable $callback, int $priority = 10, int $args = 1 ) : void {
	if(
		is_string( $callback ) &&
		! str_contains( $callback, __NAMESPACE__ ) &&
		function_exists( __NAMESPACE__ . '\\' . $callback )
	) {
		$callback = __NAMESPACE__ . '\\' . $callback;
	}
	if( is_callable( $callback ) ) {
		\add_action( $hook, $callback, $priority, $args );
	}
}


/**
 * Prepend namespace to string filter callbacks.
 *
 * @param string $hook
 * @param string|array|callable $callback
 * @param int $priority
 * @param int $args
 *
 * @return void
 */
function add_filter( string $hook, string|array|callable $callback, int $priority = 10, int $args = 1 ) : void {
	if(
		is_string( $callback ) &&
		! str_contains( $callback, __NAMESPACE__ ) &&
		function_exists( __NAMESPACE__ . '\\' . $callback )
	) {
		$callback = __NAMESPACE__ . '\\' . $callback;
	}
	if( is_callable( $callback ) ) {
		\add_filter( $hook, $callback, $priority, $args );
	}
}
