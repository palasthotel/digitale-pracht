<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
 * @package digitale-pracht
 */

get_header();
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php get_template_part( 'content', '404' ); ?>

	</main><!-- .site-main -->
</div><!-- .content-area -->

<?php get_footer(); ?>
