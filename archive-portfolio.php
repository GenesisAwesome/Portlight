<?php
/**
 * Portfolio Archive Template
 * 
 * @since   1.0
 * @package Genesis Child Theme
 * @author  Harish Dasari
 * @link    http://www.genesisawesome.com/
 */

/* Make full width layout */
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

/* Remove Default Loop */
remove_action( 'genesis_loop', 'genesis_do_loop' );

add_action( 'genesis_loop', 'genesisawesome_portfolio_archive_loop' );
/**
 * add custom portfolio loop
 * @return null
 */
function genesisawesome_portfolio_archive_loop() {

	genesisawesome_portfolio_loop(-1);

}

genesis();