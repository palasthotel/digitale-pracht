<?php
/**
 * The default template for empty search results
 *
 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
 * @package digitale-pracht
 */

?>
<div class="grid-container grid-container-c-1d1 has-no-title has-no-margin-top has-no-padding-top has-no-border-top">
	<div class="grid-slots-wrapper">
		<div class="grid-slot grid-slot-1d1">
			<div class="grid-box is-indented grid-box-404">
				<h2 class="h404"><?php esc_html_e( 'Sorry, no content found', 'digitale-pracht' ); ?></h2>
				<p><?php esc_html_e( 'Why not try another search term?', 'digitale-pracht' ); ?></p>
			</div>
		</div>
	</div>
</div>
