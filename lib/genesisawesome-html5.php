<?php
/**
 * GenesisAwesome HTML5 markup for Child themes.
 * 
 * @package    Genesis Child Theme
 * @subpackage Template
 * @author     Harish Dasari
 * @version    1.0
 * @link       http://www.genesisawesome.com/
 */

/* Remove Default Doctype */
remove_action( 'genesis_doctype', 'genesis_do_doctype' );

/* Remove Default Header Markup */
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );

/* Remove Default Footer Markup */
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );

add_action( 'genesis_doctype', 'genesisawesome_html5_doctype' );
/**
 * GenesisAwesome HTML5 Doctype
 * 
 * @since 1.0
 * 
 * @return null 
 */
function genesisawesome_html5_doctype() {

?>
<!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--><html class="no-js"> <!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" >
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width">
<?php

}

add_action( 'genesis_header', 'genesisawesome_html5_header_open', 5 );
/**
 * GenesisAwesome HTML5 Header open
 * 
 * @since 1.0
 * 
 * @return null
 */
function genesisawesome_html5_header_open() {
	
	echo '<header id="header">';
	genesis_structural_wrap( 'header' );

}

add_action( 'genesis_header', 'genesisawesome_html5_header_close', 15 );
/**
 * GenesisAwesome HTML5 Header close
 * 
 * @since 1.0
 * 
 * @return null
 */
function genesisawesome_html5_header_close() {
	
	genesis_structural_wrap( 'header', 'close' );
	echo '</header><!--end #header-->';

}

add_action( 'genesis_footer', 'genesisawesome_html5_footer_open', 5 );
/**
 * GenesisAwesome HTML5 Footer open
 * 
 * @since 1.0
 * 
 * @return null
 */
function genesisawesome_html5_footer_open() {
	
	echo '<footer id="footer" class="footer">';
	genesis_structural_wrap( 'footer', 'open' );

}

add_action( 'genesis_footer', 'genesisawesome_html5_footer_close', 15 );
/**
 * GenesisAwesome HTML5 Footer close
 * 
 * @since 1.0
 * 
 * @return null
 */
function genesisawesome_html5_footer_close() {

	genesis_structural_wrap( 'footer', 'close' );
	echo '</footer><!-- end #footer -->' . "\n";

}

add_filter( 'genesis_do_nav', 'genesisawesome_html5_nav', 10, 2 );
/**
 * GenesisAwesome HTML5 Nav Menu
 * 
 * @since 1.0
 * 
 * @param  string $nav_output default Nav Output (HTML4)
 * @param  string $nav        Nav Menu HTML string
 * @return string             HTML5 Nav Output.
 */
function genesisawesome_html5_nav( $nav_output, $nav ) {

	return sprintf( '<nav id="nav">%2$s%1$s%3$s</nav>', $nav, genesis_structural_wrap( 'nav', 'open', 0 ), genesis_structural_wrap( 'nav', 'close', 0 ) );

}