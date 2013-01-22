<?php
/**
 * Portfolio Single Template
 * 
 * @since   1.0
 * @package Genesis Child Theme
 * @author  Harish Dasari
 * @link    http://www.genesisawesome.com/
 */

/* Make full width layout */
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

/* remove post info and meta */
remove_action( 'genesis_before_post_content', 'genesis_post_info' );
remove_action( 'genesis_after_post_content', 'genesis_post_meta' );
remove_action( 'genesis_after_post', 'genesis_do_author_box_single' );

add_action( 'genesis_before_post_content', 'genesiawesome_portfolio_image' );
/**
 * Add Post Featured image before content
 * 
 * @return null
 */
function genesiawesome_portfolio_image() {

	if ( has_post_thumbnail() ) {
		echo '<div class="ga-portfolio-image">';
		the_post_thumbnail( 'full', array( 'class' => 'algincenter' ) );
		echo '</div>';
	}

}

genesis();