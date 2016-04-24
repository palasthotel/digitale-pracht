<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
 * @package digitale-pracht
 */

?>
<div class="grid-container has-title">
	<div class="grid-container-before">
		<h1 class="grid-container-title"><?php esc_html_e( '404 not found', 'digitale-pracht' ); ?></h1>
	</div>
	<div class="grid-slots-wrapper">
		<div class="grid-slot grid-slot-1d1">
			<div class="grid-box is-indented grid-box-404">

				<h2 class="h404"><?php esc_html_e( 'Oops, something went wrong here.', 'digitale-pracht' ); ?></h2>
				<p><?php esc_html_e( 'Why not try the search function?', 'digitale-pracht' ); ?></p>

				<?php get_search_form(); ?>
			</div>
		</div>
	</div>
</div>
