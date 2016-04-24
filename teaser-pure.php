<?php
/**
 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
 * @package digitale-pracht
 */

$teaser_classes = array( 'ph-teaser', 'ph-teaser-pure' );

?>
<article id="<?php echo $post->ID; ?>" <?php post_class( $teaser_classes ); ?>>
	<a href="<?php echo get_permalink( $post->ID ); ?>" class="ph-teaser-link ph-clearfix"
	   title="<?php the_title(); ?>">
		<h3 class="ph-teaser-title"><?php the_title(); ?></h3>
		<div class="ph-teaser-text"><?php the_excerpt(); ?></div>
	</a>
</article>
