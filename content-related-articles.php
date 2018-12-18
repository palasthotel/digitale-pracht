<?php

/**
 * Display related posts.
 *
 * First display tag related posts. If there are not enough of them, add some
 * more posts from the same category. If that is still not enough, add some
 * random posts.
 *
 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
 * @package digitale-pracht
 */


// Array with different methods of retrieving related articles. Returns a
// partial WP Query args array each.
$relateds_args = array(
	/**
	 * WP Query args for tag related posts in chronological order.
	 *
	 * @return array
	 */
	'tags' => function() {
		$tags = get_the_tags( get_the_id() );
		if ( empty( $tags ) || ! is_array( $tags ) ) {
			return array();
		}

		$tags_slugs = array_map( function( $tag_obj ) {
			return $tag_obj->slug;
		}, $tags );

		return array(
			'orderby'      => 'post_date',
			'tag_slug__in' => $tags_slugs,
		);
	},

	/**
	 * WP Query args for posts from the same category in random order.
	 *
	 * @return array
	 */
	'categories' => function() {
		$categories = wp_get_post_categories( get_the_id() );
		if ( empty( $categories ) || ! is_array( $categories ) ) {
			return array();
		}

		return array(
			'category__in' => $categories,
			'orderby'      => 'rand',
		);
	},

	/**
	 * WP Query args for random posts.
	 */
	'random' => function() {
		return array(
			'orderby' => 'rand',
		);
	},
);


// how many?
$relateds_max = 4;

// counter
$relateds_count = 0;

// exclude already processed posts
$relateds__not_in = array( get_the_ID() );

foreach ( $relateds_args as $slug => $get_args ) {
	// Continue until there are `$relateds_max` posts.
	if ( $relateds_count >= $relateds_max ) {
		break;
	}

	$args = $get_args();

	if ( empty( $args ) ) {
		continue;
	}

	$default_args = array(
		'posts_per_page' => $relateds_max - $relateds_count,
		'post_type'      => 'post',            // posts only
		'meta_key'       => '_thumbnail_id',   // with thumbnail
		'post__not_in'   => $relateds__not_in, // exclude current post
	);
	$args = wp_parse_args( $args, $default_args );

	$the_query = new WP_Query( $args );
	if ( $the_query->have_posts() ) {
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			get_template_part( 'teaser', 'illustrated' );
			$relateds_count ++;
			$relateds__not_in[] = get_the_id();
		}
	}
	wp_reset_postdata();
}
