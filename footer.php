<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
 * @package digitale-pracht
 */
?>

</div><!-- .site -->

<?php if ( is_active_sidebar( 'sidebar-bottom' ) ) : ?>
	<div id="sidebar-bottom" class="widget-area widget-area-bottom ph-clearfix"
	     role="complementary">
		<div class="grid-container has-no-title">
			<?php dynamic_sidebar( 'sidebar-bottom' ); ?>
		</div>
	</div>
<?php endif; ?>

<footer class="ph-footer-wrapper site-footer" role="contentinfo">
	<div class="ph-footer">
		<div class="ph-footer-copyright">
			<?php
			/**
			 * Fires before the digitalepracht footer text for footer customization.
			 */
			do_action( 'digitalepracht_credits' );
			?>
			<?php printf(
				wp_kses( __( 'Proudly powered by %s.', 'digitale-pracht' ), array(
					'a' => array(
						'href' => array(),
						'target' => array(),
						) )
				),
				'<a href="' . esc_url( __( 'https://wordpress.org', 'digitale-pracht' ) ) . '" target="_blank">' . __( 'WordPress', 'digitale-pracht' ) . '</a>'
			); ?>
			<?php printf(
				wp_kses( __( 'Theme %1$s by %2$s.', 'digitale-pracht'), array(
					'em' => array(),
					'a' => array(
						'href' => array(),
						'target' => array(),
					) )
				),
				'<em>' . __( 'digitale Pracht', 'digitale-pracht' ) . '</em>',
				'<a href="' . esc_url( __( 'http://palasthotel.de', 'digitale-pracht' ) ) . '" target="_blank">' . __( 'Palasthotel', 'digitale-pracht' ) . '</a>'
			); ?>
		</div>

		<?php if ( has_nav_menu( 'footer' ) ) : ?>
			<nav class="ph-footer-nav no-print">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'footer',
					'menu_class'     => 'footer-menu',
					'container'      => '',
					'depth'          => 1,
				) );
				?>
			</nav><!-- .main-navigation -->
		<?php endif; ?>
	</div>
</footer>

<?php if ( get_theme_mod( 'digitalepracht_show_reading_indicator', true ) === true ) : ?>
	<div class="ph-indicator-wrapper no-print">
		<div class="ph-indicator" id="indicator"></div>
	</div>
<?php endif; ?>

<?php wp_footer(); ?>

</body>
</html>
