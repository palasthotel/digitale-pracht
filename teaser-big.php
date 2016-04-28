<?php
/**
 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
 * @package digitale-pracht
 */

$teaser_classes = array( 'ph-teaser', 'ph-teaser-big' );

$thumbnail_id = get_post_thumbnail_id();

// Default thumbnail image size
$image_format = 'teaser-big-desktop-2x';

// If original image is smaller than default thumbnail image size,
// get a smaller image size
$thumbnail_image_src = wp_get_attachment_image_src( $thumbnail_id, $image_format );
$min_width = digitalepracht_image_sizes()[ $image_format ][ 'width' ];
$min_height = digitalepracht_image_sizes()[ $image_format ][ 'height' ];

if ( $thumbnail_image_src[ 1 ] < $min_width ||
     $thumbnail_image_src[ 2 ] < $min_height ) {
	$image_format = 'teaser-illustrated-mobile-max-2x';
}

?>
<article id="<?php echo $post->ID; ?>" <?php post_class( $teaser_classes ); ?>>
	<a href="<?php echo get_permalink( $post->ID ); ?>" class="ph-teaser-link ph-clearfix"
	   title="<?php the_title(); ?>">
		<h2 class="ph-teaser-title"><?php the_title(); ?></h2>
		<?php if ( has_post_thumbnail() ) : ?>
			<figure class="ph-teaser-image-wrapper">
				<?php the_post_thumbnail( $image_format, array( 'class' => 'ph-teaser-image' ) ); ?>
			</figure>
		<?php endif; ?>
		<div class="ph-teaser-text"><?php the_excerpt(); ?></div>
	</a>
</article>
