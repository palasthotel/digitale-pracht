<?php
/**
 * Theme backend settings for Customizer
 *
 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
 * @package digitale-pracht
 */

require_once get_template_directory() . '/inc/color-helper.php';


if ( ! function_exists( 'digitalepracht_customize_register' ) ) :
	function digitalepracht_customize_register( $wp_customize ) {
		$wp_customize->add_setting( 'digitalepracht_accent_color', array(
			'type'              => 'theme_mod',
			'default'           => '#facc00',
			'sanitize_callback' => 'sanitize_hex_color',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'digitalepracht_accent_color', array(
			'label'   => __( 'Accent Color', 'digitale-pracht' ),
			'section' => 'colors',
		) ) );

		$wp_customize->add_setting( 'digitalepracht_show_reading_indicator', array(
			'type'              => 'theme_mod',
			'default'           => true,
			'sanitize_callback' => 'digitalepracht_sanitize_boolean',
		) );

		$wp_customize->add_control( 'digitalepracht_show_reading_indicator', array(
			'label'       => __( 'Show reading indicator', 'digitale-pracht' ),
			'description' => __( 'Enables the the reading indicator on the left side of the screen, which visualises the current position.', 'digitale-pracht' ),
			'type'        => 'checkbox',
			'section'     => 'title_tagline',
		) );

		$wp_customize->add_setting( 'digitalepracht_show_sharing_button', array(
			'type'              => 'theme_mod',
			'default'           => false,
			'sanitize_callback' => 'digitalepracht_sanitize_boolean',
		) );

		$wp_customize->add_control( 'digitalepracht_show_sharing_button', array(
			'label'       => __( 'Show sharing button', 'digitale-pracht' ),
			'description' => __( 'Enables a small sharing button on posts, which appears on the bottom right corner when scrolling down.', 'digitale-pracht' ),
			'type'        => 'checkbox',
			'section'     => 'title_tagline',
		) );

		$wp_customize->add_setting( 'digitalepracht_twitter_username', array(
			'type'              => 'theme_mod',
			'default'           => '',
			'sanitize_callback' => 'digitalepracht_sanitize_twitter_username',
		) );

		$wp_customize->add_control( 'digitalepracht_twitter_username', array(
			'label'       => __( 'Twitter @Username', 'digitale-pracht' ),
			'description' => __( 'You can provide your Twitter username here, without the @ character. It will appear inside the Twitter sharing links.', 'digitale-pracht' ),
			'type'        => 'text',
			'section'     => 'title_tagline',
		) );

		$wp_customize->add_setting( 'digitalepracht_relateds_number', array(
			'type'              => 'theme_mod',
			'default'           => '4',
			'sanitize_callback' => 'absint',
		) );

		$wp_customize->add_control( 'digitalepracht_relateds_number', array(
			'label'       => __( 'Number of related articles', 'digitale-pracht' ),
			'description' => __( 'Control how many related articles will be displayed underneath each article. Disable with a value of 0.', 'digitale-pracht' ),
			'type'        => 'number',
			'section'     => 'title_tagline',
		) );
	}
endif;
add_action( 'customize_register', 'digitalepracht_customize_register' );


if ( ! function_exists( 'digitalepracht_sanitize_boolean' ) ) :
	/**
	 *
	 */
	function digitalepracht_sanitize_boolean( $bool ) {
		return $bool === true ? true : false;
	}
endif;


if ( ! function_exists( 'digitalepracht_sanitize_twitter_username' ) ) :
	/**
	 * Handles sanitization for Twitter username.
	 *
	 * Allowed is:
	 * - Length up to 15 characters
	 * - Alphanumeric characters (a-z, A-Z, 0-9)
	 * - Underscores (_)
	 *
	 * @see https://support.twitter.com/articles/115596
	 *
	 * @param string $value Twitter username.
	 *
	 * @return string Twitter username.
	 */
	function digitalepracht_sanitize_twitter_username( $username ) {
		if ( mb_strlen( $username ) > 15 &&
		     preg_match( '~^[a-zA-Z0-9_]+$~', $username ) !== 1
		) {
			return '';
		}

		return $username;
	}
endif;


if ( ! function_exists( 'digitalepracht_customizer_css' ) ) :
	/**
	 * Enqueues front-end CSS for color scheme.
	 */
	function digitalepracht_customizer_css() {
		// Custom accent color
		$accent_color = get_theme_mod( 'digitalepracht_accent_color', '#facc00' );
		// Don't do anything if the default accent color is selected.
		if ( $accent_color !== '#facc00' ) {
			$accent_color_css = digitalepracht_get_accent_color_css( $accent_color );
			wp_add_inline_style( 'digitalepracht-style', $accent_color_css );
		}

		// If the reading indicator is disabled
		if ( get_theme_mod( 'digitalepracht_show_reading_indicator', true ) === false ) {
			$remove_indicator_padding_style = 'body { padding-left: 0 !important; }';
			wp_add_inline_style( 'digitalepracht-style', esc_html( $remove_indicator_padding_style ) );
		}
	}
endif;
add_action( 'wp_enqueue_scripts', 'digitalepracht_customizer_css' );


if ( ! function_exists( 'digitalepracht_get_foreground_color_with_best_contrast' ) ) :
	/**
	 * Calculates, which foreground color has the best contrast to the given
	 * background-color.
	 *
	 * @see http://stackoverflow.com/a/8468448
	 * @param string $background_color_hex HEX color without leading #.
	 * @return string 'black' or 'white', depending on the given background-color.
	 */
	function digitalepracht_get_foreground_color_with_best_contrast( $background_color_hex ) {
		$ratio_black = digitalepracht_color_ratio( $background_color_hex, '000000' );
		$ratio_white = digitalepracht_color_ratio( $background_color_hex, 'ffffff' );

		if ($ratio_black > $ratio_white) {
			return 'black';
		}

		return 'white';
	}
endif;


if ( ! function_exists( 'digitalepracht_get_accent_color_css' ) ) :
	/**
	 * Returns CSS for the accent color.
	 *
	 * @param string $color HEX value of accent color, e.g. #facc00.
	 *
	 * @return string Accent color CSS.
	 */
	function digitalepracht_get_accent_color_css( $color ) {
		$color = esc_html( $color );
		$foreground_color = esc_html( digitalepracht_get_foreground_color_with_best_contrast( $color ) );
		$hover_color = esc_html( digitalepracht_color_blend( $color, '#ffffff', 0.8 ) );

		return <<<CSS
        /* Accent color */

		.comment-author a:hover,
		.comment-author a:focus,
		.required,
		.bypostauthor .comment-author:after,
		.byuser .comment-author:after,
		.grid-box-wordpress-menu-menu > .menu-item > a:hover,
		.widget li a:hover,
		.ph-overlay-share-btn:hover .ph-overlay-share-label,
		.ph-overlay-share-btn:focus .ph-overlay-share-label,
		.ph-overlay:after,
		.ph-teaser-link:hover .ph-teaser-title,
		.ph-teaser-link:focus .ph-teaser-title {
		  color: {$color};
		}
		
		.pagination,
		.comments-area.has-comments,
		.grid-container.has-title,
		.has-title.ph-article,
		.grid-container.has-border-top-accent,
		.has-border-top-accent.ph-article,
		.ph-article-title,
		.ph-author-title {
		  border-color: {$color};
		}
		
		.ph-debug-grid-slot,
		.ph-indicator {
		  background-color: {$color};
		}
		
		.ph-btn-submit,
		[type="submit"],
		[href].grid-container-title,
		[href].comments-title,
		.ph-jumplink:focus {
		  background-color: {$color} !important;
		  color: {$foreground_color} !important;
		}
		
		.custom-logo-link:focus .ph-page-dp-logo-svg > path {
		  fill: {$color};
		}
		
		[type="text"].ph-search-input:focus,
		.content-area [type="text"].ph-search-input:focus,
		.grid-container.has-no-title .grid-slot:first-child.grid-slot-1d1 .grid-box:first-child.has-no-title .ph-teaser:first-child.ph-teaser-big .ph-teaser-title,
		.ph-article .grid-slot:first-child.grid-slot-1d1 .grid-box:first-child.has-no-title .ph-teaser:first-child.ph-teaser-big .ph-teaser-title {
		  border-color: {$color} !important;
		}
		
		.ph-btn:hover,
		[type="button"]:hover,
		[type="submit"]:hover,
		button:hover,
		.ph-pager-btn:hover,
		.ph-jumplink:hover:focus,
		.ph-btn-italic:hover,
		.grid-box-readmore-link:hover,
		.grid-container-title:hover,
		.comments-title:hover,
		.grid-container-readmore-link:hover,
		.ph-btn-transparent-bg:hover,
		.page-numbers:hover,
		.ph-btn:focus,
		[type="button"]:focus,
		[type="submit"]:focus,
		button:focus,
		.ph-pager-btn:focus,
		.ph-jumplink:focus,
		.ph-btn-italic:focus,
		.grid-box-readmore-link:focus,
		.grid-container-title:focus,
		.comments-title:focus,
		.grid-container-readmore-link:focus,
		.ph-btn-transparent-bg:focus,
		.page-numbers:focus,
		.comments-title[type="button"],
		.comments-title[type="submit"],
		.comments-title.ph-jumplink:focus,
		.grid-container-title[type="button"],
		.grid-container-title[type="submit"],
		.grid-container-title.ph-jumplink:focus,
		.grid-container-title,
		.comments-title,
		.is-active.ph-btn,
		.is-active[type="button"],
		.is-active[type="submit"],
		button.is-active,
		.is-active.ph-pager-btn,
		.is-active.ph-jumplink:focus,
		.is-active.ph-btn-italic,
		.is-active.grid-box-readmore-link,
		.is-active.grid-container-readmore-link,
		.is-active.ph-btn-transparent-bg,
		.is-active.page-numbers,
		.page-numbers.current,
		.ph-icon-btn:hover,
		.ph-icon-btn:focus {
		  background-color: {$color} !important;
		  color: {$foreground_color} !important;
		}
		
		.ph-btn-submit:hover,
		[type="submit"]:hover,
		[href].grid-container-title:hover,
		[href].comments-title:hover,
		.ph-jumplink:hover:focus,
		.ph-btn-submit:focus,
		[type="submit"]:focus,
		[href].grid-container-title:focus,
		[href].comments-title:focus,
		.ph-jumplink:focus {
		  background-color: {$hover_color} !important;
		}

CSS;
	}
endif;
