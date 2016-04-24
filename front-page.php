<?php
/**
 * Override front page.
 *
 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
 * @package digitale-pracht
 */

get_header();
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<?php
		// Is the front page a static page?
		if ( get_option( 'show_on_front' ) === 'page' ) {
			// If yes, is it a grid?
			if ( isset( $post->grid ) ) {
				the_content();
			} else {
				get_template_part( 'content', 'page' );
			}
		} else {
			get_template_part( 'content', 'index' );
		}
		?>
	</main><!-- .site-main -->
</div><!-- .content-area -->

<?php get_footer(); ?>
