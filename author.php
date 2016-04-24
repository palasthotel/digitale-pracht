<?php
/**
 * The template for displaying author information
 *
 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
 * @package digitale-pracht
 */

$curauth = ( get_query_var( 'author_name' ) ) ?
	get_user_by( 'slug', get_query_var( 'author_name' ) ) :
	get_userdata( get_query_var( 'author' ) );

$description = get_the_author_meta( 'description', $curauth->ID );

$mailto_link = esc_url( 'mailto:' . get_the_author_meta( 'user_email', $curauth->ID ) );
$url         = get_the_author_meta( 'url', $curauth->ID );
$twitter     = get_the_author_meta( 'twitter', $curauth->ID );
get_header();

?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<div class="grid-container has-no-title">
			<div class="ph-author ph-clearfix">
				<div class="ph-author-image-wrapper">
					<?php echo get_avatar(
						$curauth->ID,
						512,
						get_option( 'avatar_default', 'mystery' ),
						false,
						array( 'force_display' => true )
					); ?>
				</div>
				<h1 class="ph-author-title"><?php the_author_meta( 'display_name', $curauth->ID ); ?></h1>
				<div class="ph-author-text">
					<?php if ( ! empty( $description ) ): ?>
						<div class="ph-author-description"><?php echo $description; ?></div>
					<?php endif; ?>
					<dl class="ph-author-meta ph-clearfix">
						<dt class="ph-author-meta-label">E-Mail</dt>
						<dd class="ph-author-meta-value"><a
								href="<?php echo $mailto_link; ?>"><?php echo esc_html( get_the_author_meta( 'user_email', $curauth->ID ) ); ?></a>
						</dd>
						<?php if ( ! empty( $url ) ): ?>
							<dt class="ph-author-meta-label"><?php esc_html_e( 'Website', 'digitale-pracht' ); ?></dt>
							<dd class="ph-author-meta-value"><a
									href="<?php echo esc_url( $url ); ?>"
									target="_blank"><?php echo esc_html( $url ); ?></a>
							</dd>
						<?php endif; ?>
						<?php if ( ! empty( $twitter ) ): ?>
							<dt class="ph-author-meta-label"><?php esc_html_e( 'Twitter', 'digitale-pracht' ); ?></dt>
							<dd class="ph-author-meta-value"><a
									href="<?php echo esc_url( 'https://twitter.com/' . wp_strip_all_tags( $twitter ) ); ?>"
									target="_blank">@<?php echo esc_html( wp_strip_all_tags( $twitter ) ); ?></a>
							</dd>
						<?php endif; ?>
					</dl>
				</div>
			</div>
		</div>

		<?php get_template_part( 'content', 'author' ); ?>

	</main><!-- .site-main -->
</div><!-- .content-area -->

<?php get_footer(); ?>
