<?php
/**
 * The template for displaying author information
 *
 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
 * @package digitale-pracht
 */

$curauth = get_query_var( 'author_name' ) ?
	get_user_by( 'slug', get_query_var( 'author_name' ) ) :
	get_userdata( get_query_var( 'author' ) );

$description = get_the_author_meta( 'description', $curauth->ID );

$mailto_link      = 'mailto:' . get_the_author_meta( 'user_email', $curauth->ID );
$website          = get_the_author_meta( 'url', $curauth->ID );
$twitter_username = wp_strip_all_tags( get_the_author_meta( 'twitter', $curauth->ID ) );
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
				<h1 class="ph-author-title"><?php echo esc_html( get_the_author_meta( 'display_name', $curauth->ID ) ); ?></h1>
				<div class="ph-author-text">
					<?php if ( ! empty( $description ) ): ?>
						<div class="ph-author-description"><?php
							echo wp_kses(
								$description,
								array(
									'a' => array(
										'href' => array(),
										'title' => array(),
										'target' => array(),
									),
									'br' => array(),
									'em' => array(),
									'strong' => array(),
								)
							); ?></div>
					<?php endif; ?>
					<dl class="ph-author-meta ph-clearfix">
						<dt class="ph-author-meta-label"><?php _e( 'E-Mail', 'digitale-pracht' ); ?></dt>
						<dd class="ph-author-meta-value"><a
								href="<?php echo esc_url( $mailto_link, array( 'mailto' ) ); ?>"><?php echo esc_html( get_the_author_meta( 'user_email', $curauth->ID ) ); ?></a>
						</dd>
						<?php if ( ! empty( $website ) ): ?>
							<dt class="ph-author-meta-label"><?php _e( 'Website', 'digitale-pracht' ); ?></dt>
							<dd class="ph-author-meta-value"><a
									href="<?php echo esc_url( $website ); ?>"
									target="_blank"><?php echo esc_html( $website ); ?></a>
							</dd>
						<?php endif; ?>
						<?php if ( ! empty( $twitter_username ) ): ?>
							<dt class="ph-author-meta-label"><?php _e( 'Twitter', 'digitale-pracht' ); ?></dt>
							<dd class="ph-author-meta-value"><a
									href="<?php echo esc_url( 'https://twitter.com/' . $twitter_username ); ?>"
									target="_blank">@<?php echo esc_html( $twitter_username ); ?></a>
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
