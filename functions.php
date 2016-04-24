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


/**
 * Sets the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function digitalepracht_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'digitalepracht_content_width', 846 );
}
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


if ( ! function_exists( 'digitalepracht_javascript_detection' ) ) :
	/**
	 * JavaScript Detection.
	 *
	 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
	 *
	 * @since Twenty Fifteen 1.1
	 */
	function digitalepracht_javascript_detection() {
		echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
	}
endif;
add_action( 'wp_head', 'digitalepracht_javascript_detection', 0 );


if ( ! function_exists( 'digitalepracht_disable_emojicons_tinymce' ) ) :
	/**
	 * @see http://wordpress.stackexchange.com/a/185578/89870
	 */
	function digitalepracht_disable_emojicons_tinymce( $plugins ) {
		if ( is_array( $plugins ) ) {
			return array_diff( $plugins, array( 'wpemoji' ) );
		} else {
			return array();
		}
	}
endif;


if ( ! function_exists( 'digitalepracht_disable_wp_emojicons' ) ) :
	/**
	 * @see http://wordpress.stackexchange.com/a/185578/89870
	 */
	function digitalepracht_disable_wp_emojicons() {
		// all actions related to emojis
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

		// filter to remove TinyMCE emojis
		add_filter( 'tiny_mce_plugins', 'digitalepracht_disable_emojicons_tinymce' );
	}
endif;
add_action( 'init', 'digitalepracht_disable_wp_emojicons' );


if ( ! function_exists( 'digitalepracht_scripts' ) ) :
	/**
	 * Enqueue scripts and styles.
	 *
	 * @since Twenty Fifteen 1.0
	 */
	function digitalepracht_scripts() {
		wp_dequeue_style( 'grid_frontend' ); // remove default grid css

		wp_enqueue_style(
			'digitalepracht-googlefonts',
			'http://fonts.googleapis.com/css?family=Lato:300,400,700,900,300italic,400italic|Lora:400,400italic,700,700italic'
		);

		wp_enqueue_style(
			'digitalepracht-style',
			get_template_directory_uri() . '/css-sass/all.css',
			array(),
			@filemtime( get_template_directory() . '/css-sass/all.css' )
		);

		wp_enqueue_script(
			'digitalepracht-general-first',
			get_template_directory_uri() . '/js/ph-general-first.js',
			array(),
			filemtime( get_template_directory() . '/js/ph-general-first.js' ),
			false
		);

		// Load the html5 shiv.
		wp_enqueue_script(
			'digitalepracht-html5',
			get_template_directory_uri() . '/js/contrib/html5.js',
			array(),
			'3.7.3',
			false
		);
		wp_script_add_data( 'digitalepracht-html5', 'conditional', 'lt IE 9' );

		wp_enqueue_script(
			'digitalepracht-base',
			get_template_directory_uri() . '/js/lib/ph-base.js',
			array(),
			filemtime( get_template_directory() . '/js/lib/ph-base.js' ),
			false
		);

		wp_enqueue_script(
			'digitalepracht-facebook-init',
			get_template_directory_uri() . '/js/ph-facebook-init.js',
			array(),
			filemtime( get_template_directory() . '/js/ph-facebook-init.js' ),
			false
		);

		wp_enqueue_script(
			'digitalepracht-scroll-class',
			get_template_directory_uri() . '/js/lib/ph-scroll-class.js',
			array(),
			filemtime( get_template_directory() . '/js/lib/ph-scroll-class.js' ),
			true
		);

		wp_enqueue_script(
			'digitalepracht-toggle-class',
			get_template_directory_uri() . '/js/lib/ph-toggle-class.js',
			array(),
			filemtime( get_template_directory() . '/js/lib/ph-toggle-class.js' ),
			true
		);

		wp_enqueue_script(
			'digitalepracht-scroll-to',
			get_template_directory_uri() . '/js/lib/ph-scroll-to.js',
			array(),
			filemtime( get_template_directory() . '/js/lib/ph-scroll-to.js' ),
			true
		);

		wp_enqueue_script(
			'digitalepracht-indicator',
			get_template_directory_uri() . '/js/ph-indicator.js',
			array(),
			filemtime( get_template_directory() . '/js/ph-indicator.js' ),
			true
		);

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		wp_enqueue_script(
			'digitalepracht-general-last',
			get_template_directory_uri() . '/js/ph-general-last.js',
			array(),
			filemtime( get_template_directory() . '/js/ph-general-last.js' ),
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


if ( ! function_exists( 'digitalepracht_edit_mce_block_formats' ) ) :
	/**
	 * Customize MCE WYSIWYG Editor
	 */
	function digitalepracht_edit_mce_block_formats( $init_array ) {
		// Limit our block formats and remove h1 headlines
		$block_formats = array(
			__( 'Paragraph', 'digitale-pracht' ) . '=p',
			sprintf( __( 'Headline %d', 'digitale-pracht' ), 1 ) . '=h2',
			sprintf( __( 'Headline %d', 'digitale-pracht' ), 2 ) . '=h3',
			__( 'Preformatted', 'digitale-pracht' ) . '=pre',
		);
		$init_array['block_formats'] = implode( ';', $block_formats );

		// Remove alignjustify and forecolor
		$init_array['toolbar2'] = str_replace( 'alignjustify', '', $init_array['toolbar2'] );
		$init_array['toolbar2'] = str_replace( 'forecolor', '', $init_array['toolbar2'] );
		$init_array['toolbar2'] = str_replace( ',,', ',', $init_array['toolbar2'] ); // Correct double commas

		return $init_array;
	}
endif;
add_filter( 'tiny_mce_before_init', 'digitalepracht_edit_mce_block_formats' );


if ( ! function_exists( 'digitalepracht_get_excerpt_or_content_until_more' ) ) :
	/**
	 * returns excerpt, if it has one, otherwise returns the content until more tag,
	 * but limited to $max_words words.
	 */
	function digitalepracht_get_excerpt_or_content_until_more( $max_words = null ) {
		if ( has_excerpt() ) {
			$excerpt = get_the_excerpt();
		} else {
			// @see http://codex.wordpress.org/Customizing_the_Read_More#How_to_use_Read_More_in_Pages
			global $more;
			$more = 0;
			$excerpt = wp_trim_excerpt();
		}
		// trim words?
		if ( ! empty( $max_words ) ) {
			$excerpt = digitalepracht_shorten_string_by_words( $excerpt, $max_words );
		}

		return $excerpt;
	}
endif;


if ( ! function_exists( 'digitalepracht_excerpt_length' ) ) :
	/**
	 * limit excerpt to 40 words
	 */
	function digitalepracht_excerpt_length( $length ) {
		return 40;
	}
endif;
add_filter( 'excerpt_length', 'digitalepracht_excerpt_length', 999 );


if ( ! function_exists( 'digitalepracht_the_excerpt' ) ) :
	/**
	 * replace excerpt […] with …
	 */
	function digitalepracht_the_excerpt( $text ) {
		$text = str_replace( '[...]', '…', $text );
		$text = str_replace( '[…]', '…', $text );
		$text = str_replace( '[&hellip;]', '…', $text );

		return $text;
	}
endif;
add_filter( 'the_excerpt', 'digitalepracht_the_excerpt' );


if ( ! function_exists( 'digitalepracht_exclude_all_pages_search' ) ) :
	/**
	 * exclude pages from frontend search
	 */
	function digitalepracht_exclude_all_pages_search( $query ) {
		if ( ! is_admin() // user is in backend
		     && $query->is_main_query()
		     && $query->is_search
		) {
			$query->set( 'post_type', 'post' );
		}
	}
endif;
add_action( 'pre_get_posts', 'digitalepracht_exclude_all_pages_search' );


if ( ! function_exists( 'digitalepracht_shorten_string_by_words' ) ) :
	/**
	 * Shorten a string by words, so that there remains a maximum number of
	 * $max_words words. There will be added a … char at the end of the string.
	 *
	 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
	 */
	function digitalepracht_shorten_string_by_words( $string, $max_words ) {
		$words = explode( ' ', $string, $max_words );
		if ( count( $words ) >= $max_words ) {
			array_pop( $words );
			return implode( ' ', $words ) . '…';
		}
		return $string;
	}
endif;


if ( ! function_exists( 'digitalepracht_shorten_string_by_words_and_length' ) ) :
	/**
	 * Shorten a string by words, so that it fits inside a maximum number of
	 * $limit characters including … at the end.
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

		$words = explode( ' ', $string );
		$return = '';

		for ( $i = 0; $i < count( $words ); $i ++ ) {
			// subtract 1 from $max_chars because we add the char … later
			if ( mb_strlen( $return ) + mb_strlen( $words [ $i ] ) <= $max_chars - 1 ) {
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

		$twitter_username     = get_theme_mod( 'twitter_username', '' );
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
 * Load Inc files.
 */
require_once get_template_directory() . '/inc/customizer.php';
require_once get_template_directory() . '/inc/setup-grid.php';
require_once get_template_directory() . '/inc/image-sizes.php';
require_once get_template_directory() . '/inc/open-graph.php';
