<?php
/**
 * Theme backend settings for Customizer
 *
 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
 * @package digitale-pracht
 */

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

		$wp_customize->add_setting( 'digitalepracht_show_sharing_button', array(
			'type'        => 'theme_mod',
			'default'     => false,
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


if ( ! function_exists( 'digitalepracht_accent_color_css' ) ) :
	/**
	 * Enqueues front-end CSS for color scheme.
	 */
	function digitalepracht_accent_color_css() {
		$accent_color = get_theme_mod( 'digitalepracht_accent_color', '#facc00' );

		// Don't do anything if the default accent color is selected.
		if ( $accent_color === '#facc00' ) {
			return;
		}

		$accent_color_css = digitalepracht_get_accent_color_css( $accent_color );
		wp_add_inline_style( 'digitalepracht-style', $accent_color_css );
	}
endif;
add_action( 'wp_enqueue_scripts', 'digitalepracht_accent_color_css' );


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
		return <<<CSS
        /* Accent color */

        .comment-author a:hover, .comment-author a:focus {
            color: {$color};
        }
        .pagination {
            border-top: 2px solid {$color};
        }
        .comments-area.has-comments {
            border-color: {$color};
        }
        .required {
            color: {$color};
        }
        .grid-box-wordpress-menu-menu > .menu-item > a:hover {
            color: {$color};
        }
        .ph-debug-grid-slot {
            background-color: {$color};
        }
        .grid-container.has-title, .has-title.ph-article,
        .grid-container.has-border-top-accent{
            border-color: {$color};
        }
        .ph-article-title {
            border-color: {$color};
        }
        .ph-author-title {
            border-color: {$color};
        }
        .ph-btn:hover, input[type="button"]:hover,
        input[type="submit"]:hover,
        button:hover, .ph-pager-btn:hover, .ph-jumplink:hover:focus, .ph-btn-italic:hover, .grid-box-readmore-link:hover, .grid-container-title:hover, .comments-title:hover, .grid-container-readmore-link:hover, .ph-btn-transparent-bg:hover, .page-numbers:hover, .ph-btn:focus, input[type="button"]:focus,
        input[type="submit"]:focus,
        button:focus, .ph-pager-btn:focus, .ph-jumplink:focus, .ph-btn-italic:focus, .grid-box-readmore-link:focus, .grid-container-title:focus, .comments-title:focus, .grid-container-readmore-link:focus, .ph-btn-transparent-bg:focus, .page-numbers:focus, input.comments-title[type="button"],
        input.comments-title[type="submit"], .comments-title.ph-jumplink:focus, input.grid-container-title[type="button"],
        input.grid-container-title[type="submit"], .grid-container-title.ph-jumplink:focus, .grid-container-title, .comments-title, .is-active.ph-btn, input.is-active[type="button"],
        input.is-active[type="submit"],
        button.is-active, .is-active.ph-pager-btn, .is-active.ph-jumplink:focus, .is-active.ph-btn-italic, .is-active.grid-box-readmore-link, .is-active.grid-container-readmore-link, .is-active.ph-btn-transparent-bg, .is-active.page-numbers, .page-numbers.current {
            background-color: {$color} !important;
        }
        .ph-btn-submit, input[type="submit"],
        button[type="submit"], [href].grid-container-title, [href].comments-title, .ph-jumplink:focus {
            background-color: {$color};
        }
        .ph-icon-btn:hover, .ph-icon-btn:focus {
            background-color: {$color} !important;
        }
        .ph-indicator {
            background: {$color};
        }
        .ph-overlay-share-btn:hover .ph-overlay-share-label,
        .ph-overlay-share-btn:focus .ph-overlay-share-label {
            color: {$color};
        }
        .ph-overlay:after {
            color: {$color};
        }
        .ph-page-title-link:focus .ph-page-logo-svg > path {
            fill: {$color};
        }
        input[type="text"].ph-search-input:focus {
            border-color: {$color};
        }
        .grid-container.has-no-title .grid-slot:first-child.grid-slot-1d1 .grid-box:first-child.has-no-title .ph-teaser:first-child.ph-teaser-big .ph-teaser-title,
        .ph-search-input-page:focus {
            border-color: {$color} !important;
        }
        .ph-teaser-link:hover .ph-teaser-title,
        .ph-teaser-link:focus .ph-teaser-title {
            color: {$color};
        }
        .widget li > a:hover {
            color: {$color};
        }
		.byuser .comment-author:after {
			color: {$color};
		}
      }
    }

CSS;
	}
endif;
