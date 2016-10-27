<?php
/**
 * The default template for posts list
 *
 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
 * @package digitale-pracht
 */

$grid_archive_title = is_archive() ? get_the_archive_title() : null;

if ( have_posts() ) :

	// Start the loop.
	while ( have_posts() ) : the_post();

		$container_class = '';
		if ( digitalepracht_first_post_on_first_page_on_home_has_thumbnail() === true ) {
			// A bit confusing, but works. It‘s not about the title, but about the border top.
			$container_class = ' has-no-title';
		}

		if ( digitalepracht_is_first_post_in_loop() === true ): ?>
			<div class="grid-container grid-container-c-1d1 has-border-top-accent<?php echo esc_attr( $container_class ); ?>">
				<?php if ( ! empty( $grid_archive_title ) ): ?>
					<div class="grid-container-before">
						<h1 class="grid-container-title"><?php echo esc_html( $grid_archive_title  ); ?></h1>
					</div>
				<?php endif; ?>
				<div class="grid-slots-wrapper">
					<div class="grid-slot grid-slot-1d1">
						<div class="grid-box grid-box-posts has-no-title">
		<?php
		endif;

		if ( digitalepracht_first_post_on_first_page_on_home_has_thumbnail() === true ) {
			get_template_part( 'teaser', 'big' );
		} else {
			get_template_part( 'teaser', 'illustrated' );
		}

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

// If no content, include the "No posts found" template.
else :
	get_template_part( 'content', 'none' );

endif;
