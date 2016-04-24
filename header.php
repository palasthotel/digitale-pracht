<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
 * @package digitale-pracht
 */

$show_share_btns = is_single() && ( get_post_type() === 'page' || get_post_type() === 'post' );

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=yes"/>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>
	<?php wp_head(); ?>
</head>

<body id="top" <?php body_class(); ?>>

<header id="masthead" class="ph-header site-header" role="banner">
	<div class="site-branding">
		<?php if ( is_home() || ( is_front_page() && isset( $post->grid ) ) ) : ?>
			<h1 class="ph-page-title site-title">
				<a class="ph-page-title-link"
				   href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<?php bloginfo( 'name' ); ?>
				</a>
			</h1>
		<?php else : ?>
			<p class="ph-page-title site-title">
				<a class="ph-page-title-link"
				   href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<?php bloginfo( 'name' ); ?>
				</a>
			</p>
		<?php endif; ?>
		<p class="ph-page-subtitle site-description"><?php bloginfo( 'description' ); ?></p>
	</div>

	<a class="ph-jumplink skip-link no-print" href="#content"><?php esc_html_e( 'Go to content', 'digitale-pracht' ); ?></a>

	<nav class="ph-actionbar no-print" aria-hidden="true">
		<a class="ph-icon-btn ph-icon ph-icon-search ph-actionbar-search-link" href="#search"><?php echo esc_html_x( 'Search', 'verb', 'digitale-pracht' ); ?></a>
	</nav>

	<div class="ph-overlay ph-overlay-search no-print">
		<strong class="ph-overlay-title"><?php echo esc_html_x( 'Search', 'noun', 'digitale-pracht' ); ?></strong>
		<form method="get" action="/" role="search"
		      class="ph-search-form ph-search-form-overlay ph-overlay-content">
			<input type="text" name="s" value="" placeholder="<?php esc_attr_e( 'Find me…', 'digitale-pracht' ); ?>"
			       class="ph-search-input ph-search-input-overlay">
			<button type="submit" class="ph-search-btn ph-search-btn-overlay">
				<?php esc_html_e( 'Submit search', 'digitale-pracht' ); ?>
			</button>
		</form>
	</div>

	<div class="ph-floatingbar no-print" aria-hidden="true">
		<a class="ph-floatingbar-link ph-icon ph-floatingbar-link-top ph-icon-btn ph-icon-up-bold has-delay-1"
		   href="#top"><?php esc_html_e( 'Back to top', 'digitale-pracht' ); ?></a>
		<?php if ( $show_share_btns ): ?>
			<a class="ph-floatingbar-link ph-icon ph-floatingbar-link-share ph-icon-btn ph-icon-share"
			   href="#share"><?php echo esc_html_x( 'Share', 'verb', 'digitale-pracht' ); ?></a>
		<?php endif; ?>
	</div>

	<?php if ( $show_share_btns ): ?>
		<?php get_template_part( 'widget', 'social-share-overlay' ); ?>
	<?php endif; ?>
</header>

<div class="ph-main hfeed site site-content" id="content">
