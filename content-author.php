<?php
/**
 * The default template for author and posts
 *
 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
 * @package digitale-pracht
 */

$curauth = ( get_query_var( 'author_name' ) ) ?
	get_user_by( 'slug', get_query_var( 'author_name' ) ) :
	get_userdata( get_query_var( 'author' ) );

$grid_title = sprintf( esc_html__( 'All articles by %s', 'digitale-pracht' ), get_the_author_meta( 'display_name', $curauth->ID ) );

if ( have_posts() ) : ?>

	<section class="grid-container has-title">
		<div class="grid-container-before">
			<?php if ( ! empty( $grid_title ) ): ?>
				<h1 class="grid-container-title"><?php echo esc_html( $grid_title ); ?></h1>
			<?php endif; ?>
		</div>
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
	</section>

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
