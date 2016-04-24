<?php
/**
 * The default template for category list
 *
 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
 * @package digitale-pracht
 */

$grid_title = get_the_archive_title();

if ( have_posts() ) : ?>

	<div class="grid-container grid-container-c-1d1<?php echo empty( ! $grid_title ) ? ' has-title' : ' has-no-title'; ?>">
		<?php if ( ! empty( $grid_title ) ): ?>
			<div class="grid-container-before">
				<h1 class="grid-container-title"><?php echo esc_html( $grid_title ); ?></h1>
			</div>
		<?php endif; ?>
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
	get_template_part( 'content', 'none' );

endif;
