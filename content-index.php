<?php
/**
 * The default template for posts list
 *
 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
 * @package digitale-pracht
 */

$post_count = 0;
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$first_page_on_home = is_home() && $paged === 1;

if ( have_posts() ) :

	// Start the loop.
	while ( have_posts() ) : the_post();

		// the first post on the first home index should get another teaser viewmode
		$first_post_on_first_page_has_thumbnail = $first_page_on_home && $post_count === 0 && has_post_thumbnail();
		if ( $first_post_on_first_page_has_thumbnail === true ) {
			// A bit confusing, but works. It‘s not about the title, but about the border top.
			$container_class = ' has-no-title';
		}

		if ( $post_count === 0 ): ?>
			<div class="grid-container grid-container-c-1d1 has-border-top-accent<?php echo $container_class; ?>">
				<div class="grid-slots-wrapper">
					<div class="grid-slot grid-slot-1d1">
						<div class="grid-box grid-box-posts has-no-title">
		<?php
		endif;

		if ( $first_post_on_first_page_has_thumbnail === true ) {
			get_template_part( 'teaser', 'big' );
		} else {
			get_template_part( 'teaser', 'illustrated' );
		}

		$post_count ++;
		// End the loop.
	endwhile;
	?>
				</div>
			</div>
		</div>
	</div>
	<?php

	// Previous/next page navigation.
	the_posts_pagination( array(
		'mid_size'           => 2,
		'prev_text'          => __( 'Previous', 'digitale-pracht' ),
		'next_text'          => __( 'Next', 'digitale-pracht' ),
		'screen_reader_text' => __( 'Posts navigation', 'digitale-pracht' ),
	) );
	?>

	<?php
// If no content, include the "No posts found" template.
else :
	get_template_part( 'content', 'none' );

endif;
