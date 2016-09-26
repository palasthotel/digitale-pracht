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

// how many?
$max_articles = 4;

// counter
$result_count = 0;

$post__not_in = array( $post->ID );
if ( isset( $first_related_id ) && $first_related_id != 0 ) {
	$post__not_in[] = $first_related_id;
}

// get the tags
$article_tags = get_the_tags();
$tags = array();

if ( $article_tags ) {
	foreach ( $article_tags as $article_tag ) {
		$tags[] = $article_tag->slug;
	}
}

if ( count( $tags ) > 1 ) {

	// get the posts
	$args = array(
		'posts_per_page' => $max_articles,
		'post_type'      => 'post',          // posts only
		'meta_key'       => '_thumbnail_id', // with thumbnail
		'post__not_in'   => $post__not_in,   // exclude current post
		'orderby'        => 'post_date',
		'tag_slug__in'   => $tags
	);


	$the_query = new WP_Query( $args );

	if ( $the_query->have_posts() ) {
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$result_count ++;
			get_template_part( 'teaser', 'illustrated' );
			$post__not_in[] = get_the_id();
		}
		wp_reset_postdata();
	}
}

// Only if there's not enough tag related articles,
// we add some from the same category
if ( $result_count < $max_articles ) {

	// get the categories
	$article_categories = wp_get_post_categories( get_the_id() );
	$article_categories_diff = array_diff( $article_categories, array() );
	$args = array(
		'showposts'    => $max_articles,
		'post_type'    => 'post',          // posts only
		'meta_key'     => '_thumbnail_id', // with thumbnail
		'post__not_in' => $post__not_in,   // exclude current post
		'category__in' => $article_categories,
		'orderby'      => 'rand'
	);

	$the_query = new WP_Query( $args );
	if ( $the_query->have_posts() ) {
		while ( $the_query->have_posts() ) {
			$the_query->the_post();

			$result_count ++;
			if ( $result_count <= $max_articles ) {
				get_template_part( 'teaser', 'illustrated' );
			} else {
				break;
			}
		}
	}
	wp_reset_postdata();
}


// If there are still not enough posts, get some random posts
if ( $result_count < $max_articles ) {

	$args = array(
		'showposts'    => $max_articles,
		'post_type'    => 'post',          // posts only
		'meta_key'     => '_thumbnail_id', // with thumbnail
		'post__not_in' => $post__not_in,   // exclude current post
		'orderby'      => 'rand'
	);

	$the_query = new WP_Query( $args );
	if ( $the_query->have_posts() ) {
		while ( $the_query->have_posts() ) {
			$the_query->the_post();

			$result_count ++;
			if ( $result_count <= $max_articles ) {
				get_template_part( 'teaser', 'illustrated' );
			} else {
				break;
			}
		}
	}
	wp_reset_postdata();
}
