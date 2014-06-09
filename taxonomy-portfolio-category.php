<?php
/**
 * Portfolio Archive Template
 *
 * @since   1.0
 * @package Genesis Child Theme
 * @author  Harish Dasari
 * @link    http://www.genesisawesome.com/
 */

/* make full width layout */
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

/* remove breadcrumbs */
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

/* remove post info */
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

/* remove post content */
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );

/* remove post meta */
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

/* remove default thumbnail image */
remove_action( 'genesis_entry_header', 'genesis_do_post_image', 1 );

add_action( 'body_class', 'portlight_portfolio_grid_class' );
/**
 * Add Class to body
 *
 * @param  array $class Body classes
 * @return array        New Body classes
 */
function portlight_portfolio_grid_class( $class ){
	$class[] = 'portfolio-items';
	return $class;
}

add_action( 'genesis_entry_header', 'genesisawesome_custom_image', 1 );
/* Add custom portfolio thumbnail image */
function genesisawesome_custom_image( $image_size ) {

	$img = genesis_get_image( array(
		'format'  => 'html',
		'size'    => 'portlight-portfolio-thumbnail',
		'context' => 'archive',
		'attr'    => genesis_parse_attr( 'entry-image' ),
	) );

	if ( ! empty( $img ) )
		printf( '<a href="%s" title="%s">%s</a>', get_permalink(), the_title_attribute( 'echo=0' ), $img );

}

genesis();