<?php
/**
 * The default template for displaying content
 *
 * Used for pages.
 *
 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
 * @package digitale-pracht
 */

$article_classes = array( 'ph-article' );

$title = get_the_title();
$thumbnail_id = get_post_thumbnail_id();

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( $article_classes ); ?>>

	<header class="entry-header ph-article-header">
		<h1 class="entry-title ph-article-title"><?php the_title(); ?></h1>
		<div class="ph-article-date-author">
			<?php edit_post_link( __( 'Edit article', 'digitale-pracht' ), '<span class="edit-link">', '</span>' ); ?>
		</div>
	</header><!-- .entry-header -->

	<?php
	if ( has_post_thumbnail() ):

		// Link to large thumbnail image, not original
		$large_image_url        = wp_get_attachment_image_src( $thumbnail_id, 'large' );
		$large_image_attachment = get_post( $thumbnail_id );
		$large_image_title      = '';
		$large_image_caption    = '';

		if ( ! empty( $large_image_attachment ) ) {
			$large_image_title   = $large_image_attachment->post_title;
			$large_image_caption = $large_image_attachment->post_excerpt;
		}

		?>
		<div class="entry-thumbnail ph-article-image-wrapper ph-article-featured-image">
			<?php if ( ! empty( $large_image_url ) ) : ?>
				<a class="ph-article-image-link" href="<?php echo esc_attr( $large_image_url[0] ); ?>" title="<?php echo esc_attr( $large_image_title ); ?>">
					<?php echo wp_get_attachment_image( $thumbnail_id, 'digitalepracht-featured-image', 0, array( 'class' => 'ph-article-image' ) ); ?>
				</a>
			<?php endif; ?>
			<?php if ( ! empty( $large_image_caption ) ): ?>
				<p class="ph-article-image-caption entry-thumbnail"><?php echo $large_image_caption; ?></p>
			<?php endif; ?>
		</div><!-- end .entry-thumbnail -->
	<?php endif; ?>

	<div class="entry-content ph-article-text">
		<?php
		// Check for the more tag and wrap html before more tag inside wrapper
		if ( mb_strpos( get_the_content(), '<span id="more-' ) ) : ?>
			<div class="ph-article-text-lead">
				<?php global $more;
				$more = 0;
				the_content( '', true );
				$more = 1; ?>
			</div>
			<div class="ph-article-text-body">
				<?php the_content( '', true ); ?>
			</div>
		<?php else: ?>
			<div class="ph-article-text-body">
				<?php the_content(); ?>
			</div>
		<?php
		endif;

		wp_link_pages( array(
			'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'digitale-pracht' ) . '</span>',
			'after'       => '</div>',
			'link_before' => '<span class="page-links-item">',
			'link_after'  => '</span>',
			'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'digitale-pracht' ) . ' </span>%',
			'separator'   => '<span class="screen-reader-text">, </span>',
		) );
		?>
	</div><!-- .entry-content -->

	<?php comments_template(); ?>

</article><!-- #post-## -->
