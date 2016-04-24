<?php
/**
 * Add facebook open graph and twitter functionality.
 *
 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
 * @package digitale-pracht
 */

function digitalepracht_add_open_graph_metadata() {
	$open_graph_attributes                 = array();
	$open_graph_attributes['og:locale']    = get_locale();
	$open_graph_attributes['og:site_name'] = get_bloginfo( 'name' );

	if ( is_single() ) {
		$open_graph_attributes['og:type']         = 'article';
		$open_graph_attributes['og:title']        = get_the_title();
		$open_graph_attributes['og:description']  = digitalepracht_get_excerpt_or_content_until_more();
		$open_graph_attributes['og:url']          = get_permalink();
		// c = ISO 8601 date
		$open_graph_attributes['og:updated_time'] = get_the_modified_time( 'c' );

		$thumbnail_id = get_post_thumbnail_id();
		$open_graph_attributes['og:image'] = wp_get_attachment_url( $thumbnail_id );
	} else {
		$open_graph_attributes['og:title']        = get_bloginfo( 'name' );
		$open_graph_attributes['og:description']  = get_bloginfo( 'description' );
		$open_graph_attributes['og:url']          = home_url();
		$open_graph_attributes['og:type']         = 'website';
		if ( has_site_icon() ) {
			$open_graph_attributes['og:image']    = get_site_icon_url();
		}
	}

	foreach ( $open_graph_attributes as $attr => $value ) {
		echo '<meta property="' . esc_attr( $attr ) . '" content="' . esc_attr( $value ) . '" />' . "\n";
	}
}


function digitalepracht_add_twitter_metadata() {
	$twitter_attributes = array();

	// twitter uses og-tags as well, so we define only additional tags here
	if ( is_single() ) {
		$twitter_attributes['twitter:card'] = 'summary_large_image';
	}

	$twitter_username = get_theme_mod( 'twitter_username', '' );
	if ( ! empty( $twitter_username ) ) {
		$twitter_attributes['twitter:site']    = '@' . $twitter_username;
		$twitter_attributes['twitter:creator'] = '@' . $twitter_username;
	}

	foreach ( $twitter_attributes as $attr => $value ) {
		echo '<meta name="' . esc_attr( $attr ) . '" content="' . esc_attr( $value ) . '" />' . "\n";
	}
}


function digitalepracht_add_metadata_loop() {
	$include_open_graph = get_theme_mod( 'open_graph', false );
	$include_twitter_cards = get_theme_mod( 'twitter_cards', false );

	if ( $include_open_graph === true || $include_twitter_cards === true ) {
		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
				if ( $include_open_graph === true ) {
					digitalepracht_add_open_graph_metadata();
				}
				if ( $include_twitter_cards === true ) {
					digitalepracht_add_twitter_metadata();
				}
				break;
			}
			rewind_posts();
		}
	}
}

add_action( 'wp_head', 'digitalepracht_add_metadata_loop' );
