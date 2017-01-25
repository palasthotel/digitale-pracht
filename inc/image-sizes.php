<?php
/**
 * Define some extra image formats and the post thumbnail size here.
 *
 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
 * @package digitale-pracht
 */


if ( ! function_exists( 'digitalepracht_get_content_width' ) ) :
	function digitalepracht_get_content_width() {
		return 846;
	}
endif;


if ( ! function_exists( 'digitalepracht_image_sizes' ) ) :
	function digitalepracht_image_sizes() {
		// All available image widths in px:
		//
		// - Teaser Illustrated @320px      : 72
		// - Teaser Illustrated @375px      : 84
		// - Teaser Illustrated @957px      : 216
		// - Teaser Illustrated @958px      : 119
		// - Teaser Illustrated @1199px     : 149
		// - Teaser Illustrated @1200px     : 96
		// - Teaser Illustrated @1398px+    : 112
		// - Teaser Big @320px              = 72
		// - Teaser Big @375px              = 84
		// - Teaser Big @957px              = 216
		// - Teaser Big @958px              : 272
		// - Teaser Big @1199px             : 341
		// - Teaser Big @1200px             : 341
		// - Teaser Big @1398px+            : 398
		// - Article Featured Image @320px  : 277
		// - Article Featured Image @375px  : 325
		// - Article Featured Image @499px  : 433
		// - Article Featured Image @500px  : 194
		// - Article Featured Image @957px  : 372
		// - Article Featured Image @958px  : 272
		// - Article Featured Image @1199px : 341
		// - Article Featured Image @1200px : 341
		// - Article Featured Image @1398px+: 398
		// - Article aligncenter @320px     : 277
		// - Article aligncenter @375px     : 325
		// - Article aligncenter @957px     : 834
		// - Article aligncenter @958px     : 732
		// - Article aligncenter @1199px    : 917
		// - Article aligncenter @1200px    : 726
		// - Article aligncenter @1398px+   : 846   equals content_width
		// - Article alignside @320px       : 123
		// - Article alignside @375px       : 145
		// - Article alignside @957px       : 372
		// - Article alignside @958px       : 196
		// - Article alignside @1199px      : 245
		// - Article alignside @1200px      : 245
		// - Article alignside @1398px+     : 286
		//
		// We only keep a minimum set of image sizes optimized for 375vw and
		// desktop, so that we don’t pollute the file system.
		$image_sizes = array(
			'digitalepracht-teaser-mobile'            => array(
				'width'  => 84,
				'height' => 84,
				'crop'   => true,
			),
			'digitalepracht-teaser-illustrated'       => array(
				'width'  => 112,
				'height' => 112,
				'crop'   => true,
			),
			'digitalepracht-teaser-big'               => array(
				'width'  => 398,
				'height' => 398,
				'crop'   => true,
			),
			'digitalepracht-featured-image'           => array(
				'width'  => 398,
				'height' => 398,
				'crop'   => true,
			),
			'digitalepracht-article-alignside-mobile' => array(
				'width'  => 145,
				'height' => 9999,
				'crop'   => false,
			),
			'digitalepracht-article-alignside'        => array(
				'width'  => 286,
				'height' => 9999,
				'crop'   => false,
			),
			'digitalepracht-article-aligncenter'      => array(
				'width'  => digitalepracht_get_content_width(),
				'height' => 9999,
				'crop'   => false,
			),
		);

		return $image_sizes;
	}
endif;


if ( ! function_exists( 'digitalepracht_image_definition' ) ) :
	function digitalepracht_image_definition() {
		$image_sizes = digitalepracht_image_sizes();
		foreach ( $image_sizes as $name => $attr ) {
			add_image_size( $name, $attr['width'], $attr['height'], $attr['crop'] );
		}
		// Default fallback is teaser big image size
		set_post_thumbnail_size(
			$image_sizes['digitalepracht-teaser-big']['width'],
			$image_sizes['digitalepracht-teaser-big']['height'],
			$image_sizes['digitalepracht-teaser-big']['crop']
		);
	}
endif;
add_action( 'after_setup_theme', 'digitalepracht_image_definition' );


if ( ! function_exists( 'digitalepracht_content_image_sizes_attr' ) ) :
	/**
	 * Add custom image sizes attribute to enhance responsive image functionality
	 * for content images. This function is called for every image.
	 */
	function digitalepracht_content_image_sizes_attr( $sizes, $size_array ) {
		$width = $size_array[0];  // Equals width attribute on img tag.

		// Assume that big images will be displayed as aligncenter or alignnone,
		// meaning in full width.
		if ( $width >= digitalepracht_get_content_width() ) {
			$sizes = '(max-width: 957px) 88vw, (max-width: 1199px) 77vw, (max-width: 1397px) 61vw, ' . digitalepracht_get_content_width() . 'px';
		}
		// All smaller images should be aligned left or right.
		else {
			$sizes = '(max-width: 957px) 39vw, (max-width: 1397px) 21vw, 286px';
		}

		// todo Define image sizes for teasers, which are placed inside a grid.

		return $sizes;
	}
endif;
add_filter( 'wp_calculate_image_sizes', 'digitalepracht_content_image_sizes_attr', 10, 2 );


if ( ! function_exists( 'digitalepracht_post_thumbnail_sizes_attr' ) ) :
	/**
	 * Add custom image sizes attribute to enhance responsive image functionality
	 * for post thumbnails. This function is only called for thumbnail images and
	 * after wp_calculate_image_sizes, so that it can override its values.
	 */
	function digitalepracht_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
		switch ( $size ) {
			case 'digitalepracht-teaser-illustrated':
				$attr['sizes'] = '(max-width: 957px) 23vw, (max-width: 1199px) 13vw, (max-width: 1397px) 8vw, 112px';
				break;
			case 'digitalepracht-teaser-big':
				$attr['sizes'] = '(max-width: 957px) 23vw, (max-width: 1397px) 29vw, 398px';
				break;
			case 'digitalepracht-featured-image':
				$attr['sizes'] = '(max-width: 499px) 87vw, (max-width: 957px) 39vw, (max-width: 1397px) 29vw, 398px';
				break;
		}

		return $attr;
	}
endif;
add_filter( 'wp_get_attachment_image_attributes', 'digitalepracht_post_thumbnail_sizes_attr', 10, 3 );
