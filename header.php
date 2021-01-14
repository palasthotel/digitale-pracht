<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
 * @package digitale-pracht
 */

$show_sharing_button = is_single() &&
                       ( get_post_type() === 'page' || get_post_type() === 'post' ) &&
                       get_theme_mod( 'digitalepracht_show_sharing_button', false ) === true;

$page_title_class = 'ph-page-title';
$page_title_link_class = 'ph-page-title-link';
if ( function_exists( 'has_custom_logo' ) && has_custom_logo() ) {
	$page_title_class = 'ph-page-subtitle';
	$page_title_link_class = 'ph-page-subtitle-link';
}

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

<?php
// TODO deprecated in WP >= v5.2, remove if and else.
if ( function_exists( 'wp_body_open' ) ) {
    wp_body_open();
} else {
    do_action( 'wp_body_open' );
}
?>

<header id="masthead" class="ph-header site-header" role="banner">
	<div class="site-branding">
		<?php if ( function_exists( 'has_custom_logo' ) && has_custom_logo() ) : ?>
			<div class="ph-page-title"><?php the_custom_logo(); ?></div>
		<?php endif; ?>

		<?php if ( is_home() || ( is_front_page() && class_exists( 'grid_plugin' ) && isset( $post->grid ) ) ) : ?>
			<h1 class="<?php echo esc_attr( $page_title_class ); ?> site-title"><a class="<?php echo esc_attr( $page_title_link_class ); ?>" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		<?php else : ?>
			<p class="<?php echo esc_attr( $page_title_class ); ?> site-title"><a class="<?php echo esc_attr( $page_title_link_class ); ?>" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
		<?php endif; ?>
		<p class="ph-page-subtitle site-description"><?php bloginfo( 'description' ); ?></p>
	</div>

	<a class="ph-jumplink skip-link no-print" href="#content"><?php _e( 'Go to content', 'digitale-pracht' ); ?></a>

	<nav class="ph-actionbar no-print" aria-hidden="true">
		<a class="ph-icon-btn ph-icon ph-icon-search ph-actionbar-search-link" href="#search"><?php _ex( 'Search', 'verb', 'digitale-pracht' ); ?></a>
	</nav>

	<div class="ph-overlay ph-overlay-search no-print">
		<strong class="ph-overlay-title"><?php _ex( 'Search', 'noun', 'digitale-pracht' ); ?></strong>
		<?php get_search_form(); ?>
	</div>

	<div class="ph-floatingbar no-print" aria-hidden="true">
		<a class="ph-floatingbar-link ph-icon ph-floatingbar-link-top ph-icon-btn ph-icon-up-bold has-delay-1"
		   href="#top"><?php _e( 'Back to top', 'digitale-pracht' ); ?></a>
		<?php if ( $show_sharing_button ): ?>
			<a class="ph-floatingbar-link ph-icon ph-floatingbar-link-share ph-icon-btn ph-icon-share"
			   href="#share"><?php _ex( 'Share', 'verb', 'digitale-pracht' ); ?></a>
		<?php endif; ?>
	</div>

	<?php if ( $show_sharing_button ): ?>
		<?php get_template_part( 'social-share-overlay' ); ?>
	<?php endif; ?>
</header>

<div class="ph-main hfeed site site-content" id="content">
