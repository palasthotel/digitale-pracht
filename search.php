<?php
/**
 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
 * @package digitale-pracht
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<div class="grid-container grid-container-c-1d1 has-title">
				<div class="grid-container-before">
					<h1 class="grid-container-title"><?php esc_html_e( 'Search and find', 'digitale-pracht' ) ?></h1>
				</div>
				<div class="grid-slots-wrapper">
					<div class="grid-slot grid-slot-1d1">
						<div class="grid-box is-indented">
                            <?php get_search_form(); ?>
						</div>
					</div>
				</div>
			</div>

			<?php if ( have_posts() ) : ?>

				<div class="grid-container grid-container-c-1d1 has-no-title has-no-border-top has-no-padding-top">
					<div class="grid-slots-wrapper">
						<div class="grid-slot grid-slot-1d1">
							<div class="grid-box grid-box-posts has-no-title">

								<?php
									// Start the loop.
									while ( have_posts() ) : the_post();

										get_template_part( 'teaser', 'illustrated' );

									// End the loop.
									endwhile;
								?>

							</div>
						</div>
					</div>
				</div>

				<?php // Previous/next page navigation.
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
				get_template_part( 'content', 'no-search-result' );

			endif;
			?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
