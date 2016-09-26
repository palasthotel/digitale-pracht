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
	<strong class="ph-overlay-title"><?php _e( 'Share content', 'digitale-pracht' ); ?></strong>
	<div class="ph-overlay-content">
		<ul class="ph-overlay-share-list">
			<li class="ph-overlay-share-list-item"><a
					class="ph-overlay-share-btn ph-social-media-icon is-solid is-huge ph-social-media-icon-mail"
					href="<?php echo esc_url( 'mailto:?subject=' . $mail_subject . '&amp;body=' . $mail_body, array( 'mailto' ) ); ?>"><span
						class="ph-overlay-share-label"><?php _e( 'E-Mail', 'digitale-pracht' ); ?></span></a></li>
			<li class="ph-overlay-share-list-item"><a
					class="ph-overlay-share-btn ph-social-media-icon is-solid is-huge ph-social-media-icon-whatsapp"
					href="<?php echo esc_url( 'whatsapp://send?text=' . $whatsapp, array( 'whatsapp' ) ); ?>"><span
						class="ph-overlay-share-label"><?php _e( 'Whatsapp', 'digitale-pracht' ); ?></span></a></li>
			<li class="ph-overlay-share-list-item"><a
					class="ph-overlay-share-btn ph-social-media-icon is-solid is-huge ph-social-media-icon-googleplus"
					href="<?php echo esc_url( 'https://plus.google.com/share?url=' . $social_share_url ); ?>"
					target="_blank"><span
						class="ph-overlay-share-label"><?php _e( 'Google+', 'digitale-pracht' ); ?></span></a></li>
			<li class="ph-overlay-share-list-item"><a
					class="ph-overlay-share-btn ph-social-media-icon is-solid is-huge ph-social-media-icon-twitter"
					href="<?php echo esc_url( 'https://twitter.com/intent/tweet?text=' . $tweet ); ?>"
					target="_blank"><span
						class="ph-overlay-share-label"><?php _e( 'Twitter', 'digitale-pracht' ); ?></span></a></li>
			<li class="ph-overlay-share-list-item"><a
					class="ph-overlay-share-btn ph-social-media-icon is-solid is-huge ph-social-media-icon-facebook"
					href="<?php echo esc_url( 'https://www.facebook.com/sharer.php?u=' . $social_share_url ); ?>"
					target="_blank"><span class="ph-overlay-share-label"><?php _e( 'Facebook', 'digitale-pracht' ); ?></span></a>
			</li>
		</ul>
	</div>
</div>
