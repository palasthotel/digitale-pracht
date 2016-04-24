<?php
/**
 * @author Kim-Christian Meyer <kim.meyer@palasthotel.de>
 *
 * @package digitale-pracht
 */

if ( $this->content->viewmode === 'pure' ) {
    get_template_part( 'teaser', 'pure' );
}
elseif ( $this->content->viewmode === 'illustrated' ) {
    get_template_part( 'teaser', 'illustrated' );
}
else {
    get_template_part( 'teaser', 'big' );
}
