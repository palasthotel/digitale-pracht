<?php
/**
 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
 * @package digitale-pracht
 */

$social_share_url = rawurlencode( get_permalink() );
$title            = rawurlencode( get_the_title() );
$tweet            = rawurlencode( digitalepracht_compose_tweet_text() );
$mail_subject     = $title . rawurlencode( sprintf( ' (' . __( 'Article from %s', 'digitale-pracht' )  . ')', get_bloginfo( 'name' ) ) );
$mail_body        = rawurlencode( __( 'Maybe that would be something interesting for you:', 'digitale-pracht' ) . "\r\n" ) . $social_share_url;
$whatsapp         = rawurlencode( __( 'Maybe that would be something interesting for you:', 'digitale-pracht' ) . "\r\n" ) . $social_share_url;

?>
<div id="share" class="ph-overlay ph-overlay-share no-print">
	<strong class="ph-overlay-title">Inhalt teilen</strong>
	<div class="ph-overlay-content">
		<ul class="ph-overlay-share-list">
			<li class="ph-overlay-share-list-item"><a
					class="ph-overlay-share-btn ph-social-media-icon is-solid is-huge ph-social-media-icon-mail"
					href="mailto:?subject=<?php echo esc_attr( $mail_subject ); ?>&amp;body=<?php echo esc_attr( $mail_body ); ?>"><span
						class="ph-overlay-share-label"><?php esc_html_e( 'E-Mail', 'digitale-pracht' ); ?></span></a></li>
			<li class="ph-overlay-share-list-item"><a
					class="ph-overlay-share-btn ph-social-media-icon is-solid is-huge ph-social-media-icon-whatsapp"
					href="whatsapp://send?text=<?php echo esc_attr( $whatsapp ); ?>"><span
						class="ph-overlay-share-label"><?php esc_html_e( 'Whatsapp', 'digitale-pracht' ); ?></span></a></li>
			<li class="ph-overlay-share-list-item"><a
					class="ph-overlay-share-btn ph-social-media-icon is-solid is-huge ph-social-media-icon-googleplus"
					href="https://plus.google.com/share?url=<?php echo esc_attr( $social_share_url ); ?>"
					target="_blank"><span
						class="ph-overlay-share-label"><?php esc_html_e( 'Google+', 'digitale-pracht' ); ?></span></a></li>
			<li class="ph-overlay-share-list-item"><a
					class="ph-overlay-share-btn ph-social-media-icon is-solid is-huge ph-social-media-icon-twitter"
					href="https://twitter.com/intent/tweet?text=<?php echo esc_attr( $tweet ); ?>"
					target="_blank"><span
						class="ph-overlay-share-label"><?php esc_html_e( 'Twitter', 'digitale-pracht' ); ?></span></a></li>
			<li class="ph-overlay-share-list-item"><a
					class="ph-overlay-share-btn ph-social-media-icon is-solid is-huge ph-social-media-icon-facebook"
					href="https://www.facebook.com/sharer.php?u=<?php echo esc_attr( $social_share_url ); ?>"
					target="_blank"><span class="ph-overlay-share-label"><?php esc_html_e( 'Facebook', 'digitale-pracht' ); ?></span></a>
			</li>
		</ul>
	</div>
</div>
