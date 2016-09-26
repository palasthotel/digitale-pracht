<?php
/**
 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
 * @package digitale-pracht
 */

global $wp_query;

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php

		if ( $wp_query->post_count > 1 ) :
			get_template_part( 'content', 'index' );

		else:

			if ( have_posts() ) :

				// Start the loop.
				while ( have_posts() ) : the_post();

					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					if ( class_exists( 'grid_plugin' ) && isset( $post->grid ) ) {
						get_template_part( 'content', 'landingpage' );
					} else {
						if ( $post->post_type === 'page' ) {
							get_template_part( 'content', 'page' );
						} else {
							get_template_part( 'content', 'single' );
						}
					}

					// End the loop.
				endwhile;

				// Previous/next page navigation.
				the_posts_pagination( array(
					'mid_size'           => 2,
					'prev_text'          => __( 'Previous', 'digitale-pracht' ),
					'next_text'          => __( 'Next', 'digitale-pracht' ),
					'screen_reader_text' => __( 'Posts navigation', 'digitale-pracht' ),
				) );

			// If no content, include the "No posts found" template.
			else :
				get_template_part( 'content', 'none' );

			endif;
		endif;
		?>

	</main><!-- .site-main -->
</div><!-- .content-area -->

<?php get_footer(); ?>
