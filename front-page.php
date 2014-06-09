<?php
/**
 * Portlight Custom Homepage
 *
 * @since   1.0
 * @package Genesis Child Theme
 * @author  Harish Dasari
 * @link    http://www.genesisawesome.com/
 */

add_action( 'genesis_meta', 'genesisawesome_front_page' );
/**
 * Hook home page actions and filters conditinally.
 *
 * @return null
 */
function genesisawesome_front_page() {

	if ( is_active_sidebar( 'home-widgets-1' ) || is_active_sidebar( 'home-widgets-2' ) ) {

		/* Make full width layout */
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

		// Remove the Contet and breadcrumbs
		remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
		remove_action( 'genesis_loop', 'genesis_do_loop' );

		// Add Widgets Areas
		add_action( 'genesis_loop', 'genesisawesome_home_widgets' );

		// Add a home body class
		add_action( 'body_class', 'genesisawesome_home_page_class' );

	}

}

/**
 * Portlight home page widgets sections
 *
 * @return null
 */
function genesisawesome_home_widgets() {

	genesis_widget_area( 'home-widgets-1', array(
		'before' => '<div class="portlight-home-top">',
		'after' => '</div>',
	) );

	genesis_widget_area( 'home-widgets-2', array(
		'before' => '<div class="portlight-home-bottom">',
		'after' => '</div>',
	) );

}

/**
 * Portlight Homepage Body Class
 *
 * @param  array $class Body class names
 * @return array        New body class names
 */
function genesisawesome_home_page_class( $class ) {

	$class[] = 'portlight-home';

	return $class;
}

genesis();