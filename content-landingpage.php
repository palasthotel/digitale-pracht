<?php
/**
 * The template used for displaying page content of landingpage post type (Grid)
 *
 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
 * @package digitale-pracht
 */

?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php the_content(); ?>
</div><!-- #post-## -->
