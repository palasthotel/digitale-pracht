<?php
/**
 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
 * @package digitale-pracht
 */

$a = 20;

?>
<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search" class="ph-search-form">
	<label for="search"
	       class="screen-reader-text"><?php printf( esc_html__( 'Search in %s', 'digitale-pracht' ), home_url( '/' ) ); ?></label>
	<input id="search" type="text" name="s"
	       value="<?php echo get_search_query(); ?>"
	       placeholder="<?php esc_attr_e( 'Find me…', 'digitale-pracht' ); ?>"
	       class="ph-search-input"/>
	<button type="submit"
	        class="ph-search-btn ph-btn-transparent-bg ph-icon ph-icon-search">
		<span class="ph-hide"><?php _e( 'Submit search', 'digitale-pracht' ); ?></span>
	</button>
</form>
