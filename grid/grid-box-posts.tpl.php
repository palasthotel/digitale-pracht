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
if ( empty( $this->title ) ) {
	array_push( $classes, 'has-no-title' );
} else {
	array_push( $classes, 'has-title' );
}

?>
<div class="grid-box <?php echo esc_attr( implode( $classes, ' ' ) ); ?>">
	<?php if ( ! empty( $this->title ) ) : ?>
		<?php if ( ! empty( $this->titleurl ) ) : ?>
			<h2 class="grid-box-title"><a class="grid-box-title-link"
			                              href="<?php echo esc_attr( $this->titleurl ); ?>"><?php echo esc_html( $this->title ); ?></a>
			</h2>
		<?php else: ?>
			<h2 class="grid-box-title"><?php echo esc_html( $this->title ); ?></h2>
		<?php endif; ?>
	<?php endif; ?>

	<?php if ( ! empty( $this->prolog ) ) : ?>
		<div class="grid-box-prolog">
			<?php echo $this->prolog; ?>
		</div>
	<?php endif; ?>

	<?php
	// START of WordPress Loop
	$query = new WP_Query( $content );
	while ( $query->have_posts() ) {
		$query->the_post();

		/**
		 * if avoid doublets plugin is activated
		 */
		if ( function_exists( 'grid_avoid_doublets_add' ) ) {
			grid_avoid_doublets_add( get_the_ID(), $this->grid->gridid );
		}

		$found = false;
		// Checks if WordPress has a template for post content ...
		if ( $this->storage->templatesPath !== null ) {
			$template_path = trailingslashit( $this->storage->templatesPath );
			if ( file_exists( $template_path . 'post_content.tpl.php' ) ) {
				$found = true;
				include $template_path . 'post_content.tpl.php';
			}
		}
		// ... if not, uses Grid template for post content
		if ( ! $found ) {
			include dirname( __FILE__ ) . '/post_content.tpl.php';
		}
	}
	wp_reset_postdata();
	// END of WordPress Loop
	?>

	<?php if ( ! empty( $this->epilog ) ) : ?>
		<div class="grid-box-epilog">
			<?php echo $this->epilog ?>
		</div>
	<?php endif; ?>

	<?php if ( ! empty( $this->readmore ) ) : ?>
        <div class="grid-box-readmore">
            <a href="<?php echo esc_url( $this->readmoreurl ); ?>"
               class="grid-box-readmore-link"><?php echo esc_html( $this->readmore ); ?></a>
        </div>
	<?php endif; ?>

</div>
