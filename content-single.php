<?php
/**
 * The default template for displaying content
 *
 * Used for posts.
 *
 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
 * @package digitale-pracht
 */

$article_classes = array( 'ph-article' );

$title        = get_the_title();
$thumbnail_id = get_post_thumbnail_id();

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( $article_classes ); ?>>

	<header class="entry-header ph-article-header">
		<h1 class="entry-title ph-article-title"><?php the_title(); ?></h1>
		<div class="ph-article-date-author">
			<time class="entry-date published ph-article-date"
			      datetime="<?php echo esc_attr( get_the_date( 'Y-m-d' ) ); ?>">
				<?php echo get_the_date( get_option( 'date_format' ) ); ?>
			</time>
			<time class="entry-updated updated"
			      datetime="<?php echo esc_attr( get_the_modified_date( 'Y-m-d' ) ); ?>">
				<?php the_modified_date(); ?>
			</time>
			<span class="entry-author author vcard ph-article-author">
				<?php printf(
					wp_kses( __( 'by %s', 'digitale-pracht' ), array(
						'a' => array(
							'href' => array(),
							'title' => array(),
							'class' => array(),
						) )
					),
					'<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . sprintf( esc_attr__( 'All articles by %s', 'digitale-pracht' ), get_the_author() ) . '" class="fn url">' . get_the_author() . '</a>'
				); ?>
			</span><!-- end .entry-author -->
			<?php edit_post_link( __( 'Edit article', 'digitale-pracht' ), '– <span class="edit-link">', '</span>' ); ?>
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

		// Default thumbnail image size
		$image_format = 'digitalepracht-teaser-big-desktop-2x';

		// If original image is smaller than default thumbnail image size,
		// get a smaller image size
		$thumbnail_image_src = wp_get_attachment_image_src( $thumbnail_id, $image_format );
		$sizes = digitalepracht_image_sizes();
		$min_width = $sizes[ $image_format ][ 'width' ];
		$min_height = $sizes[ $image_format ][ 'height' ];

		if ( $thumbnail_image_src[ 1 ] < $min_width ||
		     $thumbnail_image_src[ 2 ] < $min_height ) {
			$image_format = 'digitalepracht-teaser-illustrated-mobile-max-2x';
		}

		?>
		<div class="entry-thumbnail ph-article-image-wrapper ph-article-featured-image">
			<?php if ( ! empty( $large_image_url ) ) : ?>
				<a class="ph-article-image-link" href="<?php echo esc_url( $large_image_url[0] ); ?>" title="<?php echo esc_attr( $large_image_title ); ?>">
					<?php echo wp_get_attachment_image( $thumbnail_id, $image_format, 0, array( 'class' => 'ph-article-image' ) ); ?>
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

	<footer class="entry-meta ph-article-meta">
		<?php $category_list = get_the_category_list();
		if ( ! empty( $category_list ) ): ?>
			<div class="entry-tags ph-article-categories">
				<span class="ph-article-categories-label"><?php _e( 'Category', 'digitale-pracht' ); ?>:</span>
				<?php the_category( ', ', '' ); ?>
			</div>
		<?php
		endif; // get_the_category_list()

		$tags_list = get_the_tag_list();
		if ( ! empty( $tags_list ) ): ?>
			<div class="entry-tags ph-article-tags">
				<span class="ph-article-tags-label"><?php _e( 'Tags', 'digitale-pracht' ); ?>:</span>
				<?php the_tags( '', ', ', '' ); ?>
			</div>
		<?php endif; // get_the_tag_list() ?>
	</footer><!-- end .entry-meta -->

	<?php comments_template(); ?>

</article><!-- #post-## -->

<div class="grid ph-article-relateds no-print">
	<section class="grid-container grid-container-c-1d1 has-title">
		<div class="grid-container-before">
			<h2 class="grid-container-title"><?php _e( 'Related articles', 'digitale-pracht' ); ?></h2>
		</div>
		<div class="grid-slots-wrapper">
			<div class="grid-slot grid-slot-1d1">
				<div class="grid-box grid-box-posts has-no-title">
					<?php get_template_part( 'content', 'related-articles' ); ?>
				</div>
			</div>
		</div>
		<div class="grid-container-after">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="grid-container-readmore-link ph-btn-submit"><?php _e( 'Read more stories on our homepage', 'digitale-pracht' ); ?></a>
		</div>
	</section>
</div>
