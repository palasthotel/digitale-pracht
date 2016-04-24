<?php
/**
 * Customize Grid to the needs of this theme
 *
 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
 * @package digitale-pracht
 */


if ( ! function_exists( 'digitalepracht_grid_containers' ) ) :
	/**
	 * Define digitale Prach container types in Backend.
	 *
	 * @param $container_types
	 *
	 * @return array digitale Pracht container types
	 */
	function digitalepracht_grid_containers( $container_types ) {
		$allowed_container_types   = array();
		$allowed_container_types[] = array(
			'type'           => 'i-0',
			'space_to_left'  => null,
			'space_to_right' => null,
			'numslots'       => '0',
		);
		$allowed_container_types[] = array(
			'type'           => 'c-1d1',
			'space_to_left'  => null,
			'space_to_right' => null,
			'numslots'       => '1',
		);
		$allowed_container_types[] = array(
			'type'           => 'c-1d4-1d4-1d4-1d4',
			'space_to_left'  => null,
			'space_to_right' => null,
			'numslots'       => '4',
		);

		return $allowed_container_types;
	}
endif;
add_filter( 'grid_containers', 'digitalepracht_grid_containers' );


if ( ! function_exists( 'digitalepracht_grid_style_backend' ) ) :
	/**
	 * Show unsupported grid container types in Grid backend editor.
	 */
	function digitalepracht_grid_style_backend() {
		wp_enqueue_style(
			'digitalepracht-grid-style-backend',
			get_template_directory_uri() . '/css-sass/grid-support-backend.css',
			array(),
			@filemtime( get_template_directory() . '/css-sass/grid-support-backend.css' )
		);
	}
endif;
add_action( 'admin_enqueue_scripts', 'digitalepracht_grid_style_backend' );


if ( ! function_exists( 'digitalepracht_post_viewmodes' ) ) :
	/**
	 * Define Grid ViewModes.
	 *
	 * @param $view_modes
	 *
	 * @return array digitale Pracht viewmodes
	 */
	function digitalepracht_post_viewmodes( $view_modes ) {
		$dp_view_modes = array(
			array(
				'key'  => 'big',
				'text' => __( 'Teaser Big', 'digitale-pracht' ),
			),
			array(
				'key'  => 'illustrated',
				'text' => __( 'Teaser Illustrated', 'digitale-pracht' ),
			),
			array(
				'key'  => 'pure',
				'text' => __( 'Teaser Pure', 'digitale-pracht' ),
			),
		);

		return $dp_view_modes;
	}
endif;
add_filter( 'grid_post_viewmodes', 'digitalepracht_post_viewmodes' );
