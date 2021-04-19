<?php
/**
 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
 *
 * @package digitale-pracht
 */

$classes = $this->classes;
if ( ! empty( $this->style ) ) {
	array_push( $classes, $this->style );
}
array_push( $classes, 'grid-slot-' . $this->dimension );

?>
<div class="grid-slot <?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<?php echo implode( "\n", $boxes ); ?>
</div>
