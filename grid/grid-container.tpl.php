<?php
/**
 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
 *
 * @package digitale-pracht
 */

$classes = $this->classes;
// We don't need type_id
// array_push($classes, 'grid-container-type-' . $this->type_id);

if ( ! empty( $this->style ) ) {
	array_push( $classes, $this->style );
}
if ( empty( $this->title ) ) {
	array_push( $classes, 'has-no-title' );
} else {
	array_push( $classes, 'has-title' );
}

if ( $this->type !== 'c-1d1' &&
     $this->type !== 'c-1d4-1d4-1d4-1d4'
) :
	?>
	<div class="grid-container">
		<p class="grid-container-warning">
			<?php printf(
				esc_html__( 'The container type %s is not supported by this theme.', 'digitale-pracht' ),
				esc_html( $this->type )
			); ?>
		</p>
	</div>
	<?php
else :

	$classes_wrapper = array();
	?>

	<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
		<?php if ( ! empty( $this->title ) || ! empty( $this->prolog ) ) : ?>
			<div class="grid-container-before">

				<?php if ( ! empty( $this->title ) ) : ?>
					<?php if ( ! empty( $this->titleurl ) ) : ?>
						<strong><a class="grid-container-title"
						           href="<?php echo esc_attr( $this->titleurl ); ?>"><?php echo esc_html( $this->title ); ?></a></strong>
					<?php else: ?>
						<strong class="grid-container-title"><?php echo esc_html( $this->title ); ?></strong>
					<?php endif; ?>
				<?php endif; ?>

				<?php if ( ! empty( $this->prolog ) ) : ?>
					<div class="grid-container-prolog">
						<?php echo $this->prolog; ?>
					</div>
				<?php endif; ?>

			</div>
		<?php endif; ?>

		<?php if ( ! empty( $slots ) && is_array( $slots ) ): ?>
			<div class="grid-slots-wrapper">
				<?php echo implode( "\n", $slots ); ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $this->epilog ) || ! empty( $this->readmore ) ): ?>
			<div class="grid-container-after">

				<?php if ( ! empty( $this->epilog ) ) : ?>
					<div class="grid-container-epilog">
						<?php echo $this->epilog; ?>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $this->readmore ) ) : ?>
					<a href="<?php echo esc_url( $this->readmoreurl ); ?>"
					   class="grid-container-readmore-link"><?php echo esc_html( $this->readmore ); ?></a>
				<?php endif; ?>

			</div>
		<?php endif; ?>
	</div>

<?php endif; ?>
