<?php
/**
 * The default template for non existing content
 *
 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
 * @package digitale-pracht
 */

?>
<div class="grid-container has-title">
	<div class="grid-container-before">
		<h1 class="grid-container-title"><?php _e( 'No content found', 'digitale-pracht' ); ?></h1>
	</div>
	<div class="grid-slots-wrapper">
		<div class="grid-slot grid-slot-1d1">
			<div class="grid-box is-indented grid-box-404">

				<h2 class="h404"><?php _e( 'Oops, nothing to show here.', 'digitale-pracht' ); ?></h2>
				<p><?php _e( 'Why not try the search function?', 'digitale-pracht' ); ?></p>

				<?php get_search_form(); ?>
			</div>
		</div>
	</div>
</div>
