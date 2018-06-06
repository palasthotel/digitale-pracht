<?php
/**
 * digitale Pracht functions and definitions
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
 * @package digitale-pracht
 */


if ( ! function_exists( 'digitalepracht_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 * @since Twenty Fifteen 1.0
	 */
	function digitalepracht_setup() {

		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on digitalepracht, use a find and replace
		 * to change 'digitale-pracht' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'digitale-pracht', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for custom logo.
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 200,
			'width'       => 200,
			'flex-width'  => true,
			'header-text' => array( 'site-title', 'site-description' ),
		) );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus( array(
			'footer' => __( 'Footer Menu', 'digitale-pracht' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption'
		) );
	}
endif;
add_action( 'after_setup_theme', 'digitalepracht_setup' );


if ( ! function_exists( 'digitalepracht_content_width' ) ) :
	/**
	 * Sets the content width in pixels, based on the theme's design and stylesheet.
	 *
	 * Priority 0 to make it available to lower priority callbacks.
	 *
	 * @global int $content_width
	 */
	function digitalepracht_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'digitalepracht_content_width', digitalepracht_get_content_width() );
	}
endif;
add_action( 'after_setup_theme', 'digitalepracht_content_width', 0 );


if ( ! function_exists( 'digitalepracht_widgets_init' ) ) :
	/**
	 * Registers a widget area.
	 */
	function digitalepracht_widgets_init() {
		register_sidebar( array(
			'name'          => __( 'Widget Area Bottom', 'digitale-pracht' ),
			'id'            => 'sidebar-bottom',
			'description'   => __( 'Appears at the bottom of the content on posts and pages.', 'digitale-pracht' ),
			'before_widget' => '<section id="%1$s" class="widget widget-bottom %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
	}
endif;
add_action( 'widgets_init', 'digitalepracht_widgets_init' );


if ( ! function_exists( 'digitalepracht_scripts' ) ) :
	/**
	 * Enqueue scripts and styles.
	 *
	 * @since Twenty Fifteen 1.0
	 */
	function digitalepracht_scripts() {

		// Check if grid plugin is active
		if ( class_exists( 'grid_plugin' ) ) {
			// Remove default grid css
			wp_dequeue_style( 'grid_frontend' );
		}

		// Must have top priority
		wp_enqueue_script(
			'digitalepracht-javascript-detection',
			get_template_directory_uri() . '/js/ph-javascript-detection.js'
		);

		wp_enqueue_style(
			'digitalepracht-style',
			get_template_directory_uri() . '/css/all.css'
		);

		wp_enqueue_script(
			'digitalepracht-general-first',
			get_template_directory_uri() . '/js/ph-general-first.js'
		);

		// Load the html5 shiv.
		wp_enqueue_script(
			'digitalepracht-html5',
			get_template_directory_uri() . '/js/contrib/html5.js',
			array(),
			'3.7.3'
		);
		wp_script_add_data( 'digitalepracht-html5', 'conditional', 'lt IE 9' );

		wp_enqueue_script(
			'digitalepracht-class-helper',
			get_template_directory_uri() . '/js/lib/ph-class-helper.js'
		);

		wp_enqueue_script(
			'digitalepracht-debounce',
			get_template_directory_uri() . '/js/lib/ph-debounce.js'
		);

		wp_enqueue_script(
			'digitalepracht-scroll-class',
			get_template_directory_uri() . '/js/lib/ph-scroll-class.js',
			array( 'digitalepracht-class-helper', 'digitalepracht-debounce' ),
			false,
			true
		);

		wp_enqueue_script(
			'digitalepracht-toggle-class',
			get_template_directory_uri() . '/js/lib/ph-toggle-class.js',
			array( 'digitalepracht-class-helper' ),
			false,
			true
		);

		wp_enqueue_script(
			'digitalepracht-scroll-to',
			get_template_directory_uri() . '/js/lib/ph-scroll-to.js',
			array(),
			false,
			true
		);

		if ( get_theme_mod( 'digitalepracht_show_reading_indicator', true ) === true ) {
			wp_enqueue_script(
				'digitalepracht-indicator',
				get_template_directory_uri() . '/js/ph-indicator.js',
				array( 'digitalepracht-debounce' ),
				false,
				true
			);
		}

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		wp_enqueue_script(
			'digitalepracht-general-last',
			get_template_directory_uri() . '/js/ph-general-last.js',
			array(
				'digitalepracht-class-helper',
				'digitalepracht-scroll-to',
				'digitalepracht-toggle-class',
				'digitalepracht-scroll-class'
			),
			false,
			true
		);
	}
endif;
add_action( 'wp_enqueue_scripts', 'digitalepracht_scripts' );


if ( ! function_exists( 'digitalepracht_embed_oembed_html' ) ) :
	/**
	 * KM wrap embedded videos in div, so that we can make that responsive
	 * @url https://wordpress.org/support/topic/adding-a-wrapping-div-to-video-embeds
	 */
	function digitalepracht_embed_oembed_html( $html, $url, $attr, $post_id ) {
		$classes = array( 'ph-article-oembed-wrapper' );
		if ( mb_strpos( $url, '//www.youtube.com/' ) !== false ) {
			$classes[] = 'is-youtube';
			$classes[] = 'is-16to9-ratio';
		} elseif ( mb_strpos( $url, '//twitter.com/' ) !== false ) {
			$classes[] = 'is-twitter';
		} elseif ( mb_strpos( $url, '//vimeo.com/' ) !== false ) {
			$classes[] = 'is-vimeo';
			$classes[] = 'is-16to9-ratio';
		} elseif ( mb_strpos( $url, '//www.dailymotion.com/' ) !== false ) {
			$classes[] = 'is-dailymotion';
			$classes[] = 'is-16to9-ratio';
		}

		return '<div class="' . implode( ' ', $classes ) . '">' . $html . '</div>';
	}
endif;
add_filter( 'embed_oembed_html', 'digitalepracht_embed_oembed_html', 99, 4 );


if ( ! function_exists( 'digitalepracht_excerpt_length' ) ) :
	/**
	 * Limit excerpt to 40 words
	 */
	function digitalepracht_excerpt_length( $length ) {
		return 40;
	}
endif;
add_filter( 'excerpt_length', 'digitalepracht_excerpt_length', 999 );


if ( ! function_exists( 'digitalepracht_excerpt_more' ) ) :
	/**
	 * Replace excerpt […] with …
	 */
	function digitalepracht_excerpt_more( $more ) {
		return '…';
	}
endif;
add_filter( 'excerpt_more', 'digitalepracht_excerpt_more' );


if ( ! function_exists( 'digitalepracht_shorten_string_by_words_and_length' ) ) :
	/**
	 * Shorten a string by words, so that it fits inside a maximum number of
	 * $max_chars characters including … at the end.
	 *
	 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
	 */
	function digitalepracht_shorten_string_by_words_and_length( $string, $max_chars ) {
		if ( $max_chars <= 0 ) {
			return '';
		}

		if ( mb_strlen( $string ) <= $max_chars ) {
			return $string;
		}

		$words  = explode( ' ', $string );
		$return = '';

		for ( $i = 0; $i < count( $words ); $i ++ ) {
			// Subtract 1 from $max_chars because we add the char … later
			if ( mb_strlen( $return ) + mb_strlen( $words[ $i ] ) <= $max_chars - 1 ) {
				$return .= $words[ $i ] . ' ';
			} else {
				break;
			}
		}

		$return = rtrim( $return ) . '…';

		return $return;
	}
endif;


if ( ! function_exists( 'digitalepracht_compose_tweet_text' ) ) :
	function digitalepracht_compose_tweet_text() {
		$twitter_char_count_total = 140;
		$twitter_char_count_url   = 22;
		$minimum_title_length     = 50;
		$twitter_char_count_left  = $twitter_char_count_total - $twitter_char_count_url;

		$twitter_username     = esc_html( get_theme_mod( 'digitalepracht_twitter_username', '' ) );
		$twitter_user_credits = '';
		if ( ! empty( $twitter_username ) &&
		     mb_strlen( $twitter_username ) < $twitter_char_count_left - $minimum_title_length
		) {
			$twitter_user_credits    = sprintf( ' ' . __( 'via %s', 'digitale-pracht' ), '@' . $twitter_username );
			$twitter_char_count_left = $twitter_char_count_left - mb_strlen( $twitter_user_credits );
		}

		$tweet = sprintf( '%1$s: %2$s%3$s',
			digitalepracht_shorten_string_by_words_and_length( get_the_title(), $twitter_char_count_left - 2 ),
			get_permalink(),
			$twitter_user_credits
		);

		return $tweet;
	}
endif;


/**
 * The first post on the first home index should get a different teaser viewmode.
 * @return bool
 */
function digitalepracht_first_post_on_first_page_on_home_has_thumbnail() {
	return is_home() &&
	       get_query_var( 'paged', 0 ) === 0 &&
	       digitalepracht_is_first_post_in_loop() &&
	       has_post_thumbnail();
}


function digitalepracht_is_first_post_in_loop() {
	global $wp_query;

	return $wp_query->current_post === 0;
}


/**
 * Load Inc files.
 */
require_once get_template_directory() . '/inc/customizer.php';
require_once get_template_directory() . '/inc/image-sizes.php';

if ( class_exists( 'grid_plugin' ) ) {
	require_once get_template_directory() . '/inc/setup-grid.php';
}
