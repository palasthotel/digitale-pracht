<?php
/**
 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
 * @package digitale-pracht
 */

$teaser_classes = array( 'ph-teaser', 'ph-teaser-big' );

?>
<article id="<?php echo $post->ID; ?>" <?php post_class( $teaser_classes ); ?>>
	<a href="<?php echo get_permalink( $post->ID ); ?>" class="ph-teaser-link ph-clearfix"
	   title="<?php the_title(); ?>">
		<h2 class="ph-teaser-title"><?php the_title(); ?></h2>
		<?php if ( has_post_thumbnail() ) : ?>
			<figure class="ph-teaser-image-wrapper">
				<?php the_post_thumbnail( 'digitalepracht-teaser-big', array( 'class' => 'ph-teaser-image' ) ); ?>
			</figure>
		<?php endif; ?>
		<div class="ph-teaser-text"><?php the_excerpt(); ?></div>
	</a>
</article>
