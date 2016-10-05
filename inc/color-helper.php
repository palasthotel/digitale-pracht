<?php

/**
 * Some color helper, useful for checking color contrasts.
 * WCAG 2.0 level AA requires a contrast ratio of 4.5:1 for normal text and 3:1
 * for large text. Level AAA requires a contrast ratio of 7:1 for normal text and
 * 4.5:1 for large text. Large text is defined as 14 point (typically 18.66px)
 * and bold or larger, or 18 point (typically 24px) or larger.
 *
 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
 * @package digitale-pracht
 *
 * @see http://webaim.org/resources/contrastchecker/
 */


/**
 * @param string $hex_color_a HEX color
 * @param string $hex_color_b HEX color
 *
 * @return double Contrast ratio : 1 between $hex_color_a and $hex_color_b, e.g. 2.53…
 */
function digitalepracht_color_ratio( $hex_color_a, $hex_color_b ) {
	$lightness_a = digitalepracht_color_getL( $hex_color_a );
	$lightness_b = digitalepracht_color_getL( $hex_color_b );
	$ratio = ( max( $lightness_a, $lightness_b ) + 0.05 ) / ( min( $lightness_a, $lightness_b ) + 0.05 );

	return $ratio;
}


/**
 * @param string $hex_color HEX color
 *
 * @return double lightness of HEX color
 */
function digitalepracht_color_getL( $hex_color ) {
	$hex_color = str_replace( '#', '', $hex_color );

	$r = digitalepracht_color_getsRGB( substr( $hex_color, 0, 2 ) );
	$g = digitalepracht_color_getsRGB( substr( $hex_color, 2, 2 ) );
	$b = digitalepracht_color_getsRGB( substr( $hex_color, 4, 2 ) );
	$l = ( 0.2126 * $r + 0.7152 * $g + 0.0722 * $b );

	return $l;
}


/**
 * @param String $hex_base_color , e.g. 'ff' or '3a'. Must be two characters!
 *
 * @return double sRGB part
 */
function digitalepracht_color_getsRGB( $hex_base_color ) {
	$sRGB = hexdec( $hex_base_color );
	$sRGB = $sRGB / 255;
	$sRGB = ( $sRGB <= 0.03928 ) ? $sRGB / 12.92 : pow( ( ( $sRGB + 0.055 ) / 1.055 ), 2.4 );

	return $sRGB;
}


/**
 * Mixes two colors with an optional weight.
 *
 * @param string $hex_color_1 HEX color 1
 * @param string $hex_color_1 HEX color 2
 * @param double $weight A weight of 1 means $hex_color_2 will be returned, a
 * value of 0 will return $hex_color_1.
 * @return string HEX color including leading '#', resulting from mixing $hex_color_1
 * and $hex_color_2 dependent on $weight.
 */
function digitalepracht_color_blend( $hex_color_1, $hex_color_2, $weight = 0.5 ) {
	$hex_color_1 = str_replace( '#', '', $hex_color_1 );
	$hex_color_2 = str_replace( '#', '', $hex_color_2 );

	$r1 = hexdec( substr( $hex_color_1, 0, 2 ) );
	$g1 = hexdec( substr( $hex_color_1, 2, 2 ) );
	$b1 = hexdec( substr( $hex_color_1, 4, 2 ) );

	$r2 = hexdec( substr( $hex_color_2, 0, 2 ) );
	$g2 = hexdec( substr( $hex_color_2, 2, 2 ) );
	$b2 = hexdec( substr( $hex_color_2, 4, 2 ) );

	$r = round( $r1 * $weight + $r2 * ( 1 - $weight ) );
	$g = round( $g1 * $weight + $g2 * ( 1 - $weight ) );
	$b = round( $b1 * $weight + $b2 * ( 1 - $weight ) );

	$r_hex = dechex( $r );
	$g_hex = dechex( $g );
	$b_hex = dechex( $b );

	$hex_color_blended = sprintf( "#%02s%02s%02s", $r_hex, $g_hex, $b_hex );

	return $hex_color_blended;
}
