<?php
/**
 * Define some extra image formats and the post thumbnail size here.
 *
 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
 * @package digitale-pracht
 */

if ( ! function_exists( 'digitalepracht_image_sizes' ) ) :
	function digitalepracht_image_sizes() {
		$image_sizes = array(
			'digitalepracht-teaser-big-desktop-2x' => array(
				'width'  => 786,
				'height' => 786,
				'crop'   => true,
			),
			'digitalepracht-teaser-illustrated-desktop-2x' => array(
				'width'  => 224,
				'height' => 224,
				'crop'   => true,
			),
			'digitalepracht-teaser-illustrated-mobile-max-2x' => array(
				'width'  => 432,
				'height' => 432,
				'crop'   => true,
			),
			'digitalepracht-teaser-illustrated-mobile-min-2x' => array(
				'width'  => 144,
				'height' => 144,
				'crop'   => true,
			),
		);
		return $image_sizes;
	}
endif;


if ( ! function_exists( 'digitalepracht_image_definition' ) ) :
	function digitalepracht_image_definition() {
		$image_sizes = digitalepracht_image_sizes();
		foreach ( $image_sizes as $name => $attr ) {
			add_image_size( $name, $attr[ 'width' ], $attr[ 'height' ], $attr[ 'crop' ] );
		}
		set_post_thumbnail_size(
			$image_sizes[ 'digitalepracht-teaser-big-desktop-2x' ][ 'width' ],
			$image_sizes[ 'digitalepracht-teaser-big-desktop-2x' ][ 'height' ],
			$image_sizes[ 'digitalepracht-teaser-big-desktop-2x' ][ 'crop' ]
		);
	}
endif;
add_action( 'after_setup_theme', 'digitalepracht_image_definition' );
