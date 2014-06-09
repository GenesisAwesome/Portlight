<?php
/**
 * Portlight Child Theme functions
 *
 * Child Theme functions for Genesis by GenesisAwesome.com
 *
 * @package Genesis Child Theme
 * @author  Harish Dasari
 * @version 1.0
 * @link    http://www.genesisawesome.com/
 */

/**
 * GenesisAwesome Constents
 *
 * @since 1.0
 */
define( 'CHILD_THEME_NAME', 'Portlight' );
define( 'CHILD_THEME_URL', 'http://www.genesisawesome.com/themes/portlight-genesis-child-theme/' );
define( 'CHILD_THEME_VERSION', '1.1' );
define( 'GA_CHILDTHEME_FIELD', 'genesisawesome_portlight_settings' );

require_once( get_template_directory() . '/lib/init.php' );

/* Load GenesisAwesome Settings Page class */
require_once( CHILD_DIR . '/lib/genesisawesome-settings.php' );

/* Load Genesis Awesome Widgets */
require_once( CHILD_DIR . '/lib/widgets/widget-facebook-likebox.php' );
require_once( CHILD_DIR . '/lib/widgets/widget-flickr.php' );

add_theme_support( 'html5' );
add_theme_support( 'genesis-responsive-viewport' );
add_theme_support( 'genesis-footer-widgets', 3 );
add_theme_support( 'genesis-menus', array( 'primary' => __( 'Primary Navigation', 'genesisawesome' ) ) );

/* Register new Image sizes */
add_image_size( 'portlight-portfolio-thumbnail', 360, 260, true );
add_image_size( 'portlight-post-image', 900, 250, true );

genesis_register_sidebar( array(
	'id'           => 'home-widgets-1',
	'name'         => __( 'Home Widgets 1', 'genesisawesome' ),
	'description'  => __( 'This is home page widget section #1', 'genesisawesome' ),
	'before_title' => '<h4 class="widget-title widgettitle">',
	'after_title'  => '</h4><div class="clear"></div>',
) );

genesis_register_sidebar( array(
	'id'           => 'home-widgets-2',
	'name'         => __( 'Home Widgets 2', 'genesisawesome' ),
	'description'  => __( 'This is home page widget section #2', 'genesisawesome' ),
	'before_title' => '<h4 class="widget-title widgettitle">',
	'after_title'  => '</h4><div class="clear"></div>',
) );

add_action( 'after_setup_theme', 'genesisawesome_childtheme_setup' );
/**
 * GensisAwesome Child Theme Setup
 *
 * Instantiate Child theme settings page and Localization.
 *
 * @since 1.0
 *
 * @return null
 */
function genesisawesome_childtheme_setup() {

	$GLOBALS['_genesisawesome_childtheme_settings'] = new GenesisAwesome_Childtheme_Settings;

	/* Loalization */
	load_child_theme_textdomain( 'genesisawesome', CHILD_DIR . '/languages' );

}

/* Init Custom GenesisAwesome Widgets */
add_action( 'widgets_init', 'genesisawesome_custom_widgets' );
/**
 * GenesisAwesome Custom Widgets Register.
 *
 * @since 1.0
 *
 * @return null
 */
function genesisawesome_custom_widgets() {

	/* Unregister Header Right widget area */
	unregister_sidebar( 'header-right' );

	/* Register Custom Widgets */
	register_widget( 'GA_Facebook_Likebox_Widget' );
	register_widget( 'GA_Flickr_Widget' );

}

/* Remove Nav Right extras */
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

/* Load Styles and Stykes for Genesis Child Theme */
add_action( 'wp_print_styles', 'genesisawesome_childtheme_styles' );
/**
 * GenesisAwesome Childtheme Styles
 *
 * @since 1.0
 *
 * @return null
 */
function genesisawesome_childtheme_styles() {

	wp_enqueue_style( 'google-font', '//fonts.googleapis.com/css?family=Goudy+Bookletter+1911|Open+Sans:400,300,700,300i,400i,700i|Open+Sans+Condensed:300,300i,700', null, null );
	wp_enqueue_style( 'font-awesome', '//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css', null, null );

}

add_action( 'wp_enqueue_scripts', 'genesisawesome_childtheme_scripts' );
/**
 * GenesisAwesome Childtheme Scripts
 *
 * @since 1.0
 *
 * @return null
 */
function genesisawesome_childtheme_scripts() {

	wp_enqueue_script( 'ga-modernizr', CHILD_URL . '/js/modernizr.min.js', null, null, false );
	wp_enqueue_script( 'ga-fitvids',   CHILD_URL . '/js/fitvids.min.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'ga-custom',    CHILD_URL . '/js/custom.js', array( 'jquery' ), null, true );

}

/* Load inline Styles and Scripts for Genesis Child Theme */
add_action( 'wp_head', 'genesisawesome_childtheme_inline_styles' );
/**
 * GenesisAwesome Custom Stylings
 *
 * @since 1.0
 *
 * @return null
 */
function genesisawesome_childtheme_inline_styles() {

	// Logo CSS
	$logo_url    = esc_url_raw( genesis_get_option( 'logo_url', GA_CHILDTHEME_FIELD ) );
	$logo_width  = absint( genesis_get_option( 'logo_width', GA_CHILDTHEME_FIELD ) );
	$logo_height = absint( genesis_get_option( 'logo_height', GA_CHILDTHEME_FIELD ) );

	$logo_css    = ( $logo_url && $logo_width && $logo_height ) ? ".header-image .site-title a { background: url({$logo_url}) no-repeat;width: {$logo_width}px;height: {$logo_height}px;}\n" : '' ;

	// Typography CSS
	$typo_css = '';

	$typography_classes = array(
		'body, p, select, textarea' => array( 'color' => 'ga_font_color', 'fontsize' => 'ga_font_size' ),
		'a, a:visited'              => array( 'color' => 'ga_link_color' ),
		'a:hover'                   => array( 'color' => 'ga_link_hover_color' ),
		'h1'                        => array( 'color' => 'ga_h1_font_color', 'fontsize' => 'ga_h1_font_size', ),
		'h1 a, h1 a:visited'        => array( 'color' => 'ga_h1_link_color' ),
		'h1 a:hover'                => array( 'color' => 'ga_h1_link_hover_color' ),
		'h2'                        => array( 'color' => 'ga_h2_font_color', 'fontsize' => 'ga_h2_font_size', ),
		'h2 a, h2 a:visited'        => array( 'color' => 'ga_h2_link_color' ),
		'h2 a:hover'                => array( 'color' => 'ga_h2_link_hover_color' ),
		'h3'                        => array( 'color' => 'ga_h3_font_color', 'fontsize' => 'ga_h3_font_size', ),
		'h3 a, h3 a:visited'        => array( 'color' => 'ga_h3_link_color' ),
		'h3 a:hover'                => array( 'color' => 'ga_h3_link_hover_color' ),
		'h4'                        => array( 'color' => 'ga_h4_font_color', 'fontsize' => 'ga_h4_font_size', ),
		'h4 a, h4 a:visited'        => array( 'color' => 'ga_h4_link_color' ),
		'h4 a:hover'                => array( 'color' => 'ga_h4_link_hover_color' ),
		'h5'                        => array( 'color' => 'ga_h5_font_color', 'fontsize' => 'ga_h5_font_size', ),
		'h5 a, h5 a:visited'        => array( 'color' => 'ga_h5_link_color' ),
		'h5 a:hover'                => array( 'color' => 'ga_h5_link_hover_color' ),
	);

	foreach ( $typography_classes as $selector => $options ) {

		$css = '';

		foreach ( $options as $proeprty => $pro_opt ) {
			switch ( $proeprty ) {
				case 'color' :
					$color = genesis_get_option( $pro_opt, GA_CHILDTHEME_FIELD );
					if ( ! empty( $color ) )
						$css .= sprintf( 'color: %s;', $color );
					break;
				case 'fontsize' :
					$fontsize = genesis_get_option( $pro_opt, GA_CHILDTHEME_FIELD );
					if ( ! empty( $fontsize ) )
						$css .= sprintf( 'font-size: %dpx;', $fontsize );
					break;
			}
		}

		if ( ! empty( $css ) )
			$typo_css .=  "$selector { $css }\n";

	}

	if ( ! $logo_css && ! $typo_css )
		return;

	echo '<style type="text/css">' . $logo_css . $typo_css . '</style>';

}

add_action( 'wp_footer', 'genesisawesome_childtheme_inline_scripts' );
/**
 * GenesisAwesome Custom Scripts at Footer
 *
 * @since 1.0
 *
 * @return null
 */
function genesisawesome_childtheme_inline_scripts() {

	if ( is_singular( 'post' ) && genesis_get_option( 'enable_post_social_share', GA_CHILDTHEME_FIELD ) ) {
		?>
		<script type="text/javascript" async src="//assets.pinterest.com/js/pinit.js"></script>
		<script type="text/javascript" src="https://d389zggrogs7qo.cloudfront.net/js/button.js"></script>
		<script type="text/javascript" src="//platform.linkedin.com/in.js"></script>
		<script type='text/javascript'>
		/*<![CDATA[*/
			!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
			function run_pinmarklet() {var e=document.createElement('script'); e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','http://assets.pinterest.com/js/pinmarklet.js?r=' + Math.random()*99999999);document.body.appendChild(e);}
			(function() {var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;po.src = 'https://apis.google.com/js/plusone.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);})();
		/*]]>*/
		</script>
		<?php
	}

}

add_action( 'genesis_before_header', 'genesisawesome_do_before_header' );
/**
 * Before Header ( Social Icons and Search Box )
 *
 * @since 1.0
 *
 * @return null
 */
function genesisawesome_do_before_header() {

	echo '<div id="ga-top-nav">';
		echo '<div class="wrap">';

			$socials = array(
				'twitter_url'     => 'Twitter',
				'facebook_url'    => 'Facebook',
				'linkedin_url'    => 'LinkedIn',
				'pinterest_url'   => 'Pinterest',
				'googleplus_url'  => 'Google Plus',
				'instagram_url'   => 'Instagram',
				'youtube_url'     => 'Youtube',
				'stumbleupon_url' => 'Stumbleupon',
				'flickr_url'      => 'Flickr',
			);

			echo '<ul class="social-profiles">';

			foreach ( $socials as $social_opt => $social_name ) {
				if ( $social_url = genesis_get_option( $social_opt, GA_CHILDTHEME_FIELD ) ) :
				?>
				<li><a href="<?php echo esc_url( $social_url ) ?>" target="_blank" title="<?php echo esc_attr( $social_name );?>" class="fa fa-<?php echo sanitize_html_class( sanitize_title( $social_name ) ); ?>"> <span><?php echo esc_html( $social_name );?></span> </a></li>
				<?php
				endif;
			}

			echo '</ul>';

			get_search_form();

		echo '</div>';
	echo '</div>';

}

/* Remove Default Post Image */
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
/* Move Image to before title */
add_action( 'genesis_entry_header', 'genesis_do_post_image', 1 );

add_filter( 'the_content_more_link', 'genesisawesome_more_link' );
add_filter( 'get_the_content_more_link', 'genesisawesome_more_link' );
/**
 * More Link
 *
 * @since 1.0
 *
 * @param  string $html Default More Link
 * @return string       Custom More link
 */
function genesisawesome_more_link( $html ) {

	global $post;
	$morelink = '<a href="' . get_permalink() . '#more-' . $post->ID . '" class="more-link">' . __( 'Read More', 'genesisawesome' ) . '</a>';
	return $morelink;

}

add_filter( 'genesis_footer_output', 'genesisawesome_footer_output', 10, 3 );
/**
 * Portlight Custom Footer output
 *
 * @since 1.0
 *
 * @param  string $output      Default Footer HTML
 * @param  string $backtoptext BacktoTop HTML (Left)
 * @param  string $creds_text  Credits HTML (Right)
 * @return string              Custom Footer HTML
 */
function genesisawesome_footer_output( $output, $backtoptext, $creds_text ) {

	$left_text  = ! genesis_get_option( 'footer_left_text', GA_CHILDTHEME_FIELD ) ? $backtoptext : genesis_get_option( 'footer_left_text', GA_CHILDTHEME_FIELD ) ;
	$left_text  = sprintf( '<div class="one-half first">%s</div>', $left_text );
	$right_text = sprintf( '<div class="one-half alignright"> [footer_childtheme_link before="" after=" %s"] [footer_genesis_link url="http://www.genesisawesome.com/recommends/genesis" before=""] &middot; [footer_wordpress_link]</div>', __( 'on', 'genesis' ) );

	return $left_text . $right_text;

}

/* Post Share and Sunscribe Boxes */
add_action( 'genesis_after_entry', 'genesisawesome_subscribe_sharebox', 8 );
/**
 * GenesisAwesome Subscribe and Shareing boxes.
 *
 * @since 1.0
 *
 * @return null
 */
function genesisawesome_subscribe_sharebox() {

	if ( ! is_singular( 'post' ) )
		return;

	if ( genesis_get_option( 'enable_post_subscribe_box', GA_CHILDTHEME_FIELD ) ) : ?>
		<div id='ga-subscribebox'>
			<h4><?php _e( 'Subscribe to Our Blog Updates!', 'genesisawesome' );?></h4>
			<p class='message'><?php _e( 'Subscribe to Our Free Email Updates!', 'genesisawesome' );?></p>
			<form action='http://feedburner.google.com/fb/a/mailverify' class='subscribeform' method='post' onsubmit='window.open("http://feedburner.google.com/fb/a/mailverify?uri=<?php echo esc_attr( genesis_get_option( 'feedburner_id', GA_CHILDTHEME_FIELD ) );?>", "popupwindow", "scrollbars=yes,width=550,height=520");return true' target='popupwindow'>
				<input name='uri' type='hidden' value='<?php echo esc_attr( genesis_get_option( 'feedburner_id', GA_CHILDTHEME_FIELD ) );?>'/>
				<input name='loc' type='hidden' value='en_US'/>
				<input class='einput' name='email' onblur='if (this.value == "") {this.value = "Enter your email...";}' onfocus='if (this.value == "Enter your email...") {this.value = ""}' type='text' value='Enter your email...'/>
				<input class='ebutton' title='' type='submit' value='<?php _e( 'Subscribe', 'genesisawesome' );?>'/>
			</form>
		</div>
	<?php endif;

	if ( genesis_get_option( 'enable_post_social_share', GA_CHILDTHEME_FIELD ) ) : ?>
		<div id="ga-sharebox">
			<h4><?php _e( 'Share this article!', 'genesisawesome' );?></h4>
			<table width='100%'>
				<tr>
					<td><iframe allowTransparency='true' src='//www.facebook.com/plugins/like.php?href=<?php echo urlencode( get_permalink() ); ?>&amp;send=false&amp;layout=box_count&amp;width=50&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=65' frameborder='0' scrolling='no' style='border:none; overflow:hidden; width:50px; height:65px;'></iframe></td>
					<td><a class='twitter-share-button' data-count='vertical' data-lang='en' data-title='<?php the_title_attribute(); ?>' data-url='<?php the_permalink(); ?>' href='https://twitter.com/share'>Tweet</a></td>
					<td>
						<div style='position:relative;padding-top: 30px;display: inline-block;'>
							<a class='pin-it-button' count-layout='vertical' href='http://pinterest.com/pin/create/button/?url=<?php echo urldecode( get_permalink() ); ?>'>Pin It now!</a>
							<a href='javascript:void(run_pinmarklet())' style='position:absolute;top:0;bottom:0;left:0;right:0;'></a>
						</div>
					</td>
					<td><g:plusone href='<?php the_permalink(); ?>' size='tall'></g:plusone></td>
					<td><su:badge layout="5" location="<?php the_permalink();?>"></su:badge></td>
					<td><script data-counter='top' data-url='<?php the_permalink(); ?>' type='IN/Share'></script></td>
					<td><a href="http://bufferapp.com/add" class="buffer-add-button" data-text="<?php the_title_attribute() ?>" data-url="<?php the_permalink() ?>" data-count="vertical" >Buffer</a></td>
				</tr>
			</table>
		</div>
	<?php endif;

	if ( genesis_get_option( 'enable_post_related_posts', GA_CHILDTHEME_FIELD ) ) :?>
		<div id='ga-relatedposts'>
			 <h4><?php _e( 'Related Posts', 'genesisawesome' );?></h4>
			 <?php genesisawesome_related_posts(); ?>
		</div>
	<?php endif;

}


add_filter( 'genesis_available_sanitizer_filters', 'genesisawesome_custom_filters' );
/**
 * GenesisAwesome Custom Option Filters for Genesis
 *
 * @since 1.0
 *
 * @param  array $filters Default Genesis Options Filters
 * @return array          Custom and Default Genesis Options Filters
 */
function genesisawesome_custom_filters( $filters ) {

	$filters['email']   = 'sanitize_email';
	$filters['integer'] = 'genesisawesome_intval';

	return $filters;

}

/**
 * Helper intval function for sanitization
 *
 * @since 1.0
 *
 * @param  mixed    $new_val submitted value
 * @param  mixed    $old_val old value
 * @return integeer          Integer value
 */
function genesisawesome_intval( $new_val, $old_val ) {

	return intval( $new_val );

}

/**
 * GenesisAwesome Related Posts Query
 *
 * @since 1.0
 *
 * @param  integer $number Number of related posts to show
 * @return null
 */
function genesisawesome_related_posts( $number = 5 ) {

	global $post;

	$categories = get_categories( $post->ID );
	$cat_ids = array();

	if ( ! $categories )
		return;

	foreach ( $categories as $cat )
		$cat_ids[] = $cat->term_id;

	$args = array(
		'category__in'   => $cat_ids,
		'post__not_in'   => array( $post->ID ),
		'posts_per_page' => absint( $number ),
	);

	$ga_related = new WP_Query( $args );

	if ( $ga_related->have_posts() ) {
		echo '<ul>';
		while ( $ga_related->have_posts() ) {
			$ga_related->the_post();
			printf(
				'<li><a href="%s" class="related-image">%s</a><a href="%s" title="%s" class="related-title">%s</a></li>',
				get_permalink(),
				get_the_post_thumbnail( get_the_ID(), 'thumbnail' ),
				get_permalink(),
				the_title_attribute( 'echo=0' ),
				get_the_title()
			);
		}
		echo '</ul>';
	}

	wp_reset_postdata();

}

add_filter( 'genesis_export_options', 'genesiawesome_childtheme_export_options' );
/**
 * Add to Genesis Import & Export Options
 *
 * @since 1.0
 *
 * @param  array $options Default Import & Export support
 * @return array          Portlight and Default Import & Exoirt support
 */
function genesiawesome_childtheme_export_options( $options ) {

	$options['portlight'] = array(
		'label'          => __( 'Portlight Child Theme Settings', 'genesisawesome' ),
		'settings-field' => GA_CHILDTHEME_FIELD,
	);

	return $options;

}

add_action( 'genesis_entry_header', 'genesisawesome_post_data_stamp' );
/**
 * Add custom date type
 *
 * @since 1.0
 *
 * @return null
 */
function genesisawesome_post_data_stamp() {

	if ( 'post' == get_post_type() )
		printf( '<time %s><span class="datenum">%s</span><span class="monthname">%s</span></time>', genesis_attr( 'entry-fancytime' ), get_the_date( 'd' ), get_the_date( 'M' ) );

}

/* Add schema.org snippets */
add_filter( 'genesis_attr_entry-fancytime', 'genesis_attributes_entry_time' );


add_action( 'template_redirect', 'genesisawesome_remove_post_meta' );
/**
 * Remove Post Meta on Archiv pages
 *
 * @since 1.0
 *
 * @return null
 */
function genesisawesome_remove_post_meta() {

	if ( ! is_single() )
		remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

}


add_action( 'init', 'genesisawesome_register_portfolio' );
/**
 * Register Portfolio Post Type and Taxonomy
 *
 * @since 1.0
 *
 * @return null
 */
function genesisawesome_register_portfolio() {

	$labels = array(
		'name'               => _x( 'Portfolio', 'Portfolio label plural name', 'genesisawesome' ),
		'singular_name'      => _x( 'Portfolio', 'Portfolio label singular name', 'genesisawesome' ),
		'menu_name'          => __( 'Portfolio', 'genesisawesome' ),
		'add_new_item'       => __( 'Add New Portfolio', 'genesisawesome' ),
		'edit_item'          => __( 'Edit Portfolio', 'genesisawesome' ),
		'new_item'           => __( 'New Portfolio', 'genesisawesome' ),
		'view_item'          => __( 'View Portfolio', 'genesisawesome' ),
		'search_items'       => __( 'Search Portfolio', 'genesisawesome' ),
		'not_found'          => __( 'No Portfolio items found', 'genesisawesome' ),
		'not_found_in_trash' => __( 'No Portfolio items found in trash', 'genesisawesome' ),

	);

	$args = array(
		'label'               => __( 'Portfolio', 'genesisawesome' ),
		'labels'              => $labels,
		'public'              => true,
		'exclude_from_search' => true,
		'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'custom-fields', 'genesis-seo' ),
		'has_archive'         => true
	);

	register_post_type( 'portfolio', $args );

	$labels = array(
		'name'          => _x( 'Portfolio Categories', 'Portfolio category label plural name', 'genesisawesome' ),
		'singular_name' => _x( 'Portfolio Category', 'Portfolio category label singular name', 'genesisawesome' ),
		'all_items'     => __( 'All Portfolio Categories', 'genesisawesome' ),
		'edit_item'     => __( 'Edit Portfolio Category', 'genesisawesome' ),
		'update_item'   => __( 'Update Portfolio Category', 'genesisawesome' ),
		'add_new_item'  => __( 'Add Portfolio Category', 'genesisawesome' ),
		'new_item_name' => __( 'New Portfolio Category Name', 'genesisawesome' ),
		'parent_item'   => __( 'Parent Portfolio Category', 'genesisawesome' ),
		'search_items'  => __( 'Search Portfolio Categories', 'genesisawesome' ),
		'popular_items' => __( 'Popular Portfolio Categories', 'genesisawesome' ),

	);

	$args = array(
		'label'        => __( 'Portfolio Categories', 'genesisawesome' ),
		'labels'       => $labels,
		'hierarchical' => true
	);

	register_taxonomy( 'portfolio-category', array( 'portfolio' ), $args );

}

add_action( 'pre_get_posts', 'genesisawesome_portfolio_items' );
/**
 * Show 9 Portfolio Items in archive page
 *
 * @since 1.0
 *
 * @param  object $query Query object
 * @return null
 */
function genesisawesome_portfolio_items( $query ) {

	if( $query->is_main_query() && is_post_type_archive( 'portfolio' ) && ! is_admin() )
		$query->set( 'posts_per_page', 9 );

}

add_shortcode( 'portfolio', 'genesisawesome_posts_shortcode' );
/**
 * Portfolio Shortcode (Code taken from Genesis Featured Posts widgets).
 *
 * @version 1.1
 *
 * @param  array $atts List of shortcode variables
 * @return string       Shortcode executed HTML
 */
function genesisawesome_posts_shortcode( $atts ) {

	global $wp_query;

	$defaults = array(
		'posts_num'       => 9,
		'show_image'      => 1,
		'show_title'      => 1,
		'show_byline'     => 0,
		'show_content'    => 0,
		'image_size'      => 'portlight-portfolio-thumbnail',
		'image_alignment' => 'alignnone',
		'post_info'       => '',
		'content_limit'   => 100,
		'more_text'       => '',
	);

	$atts = shortcode_atts( $defaults, $atts );

	$query_args = array(
		'post_type' => 'portfolio',
		'showposts' => $atts['posts_num'],
	);

	$wp_query = new WP_Query( $query_args );

	$output = '<div class="portfolio-items">';

	if ( have_posts() ) : while ( have_posts() ) : the_post();

		$output .= genesis_markup( array(
			'html5'   => '<article %s>',
			'xhtml'   => sprintf( '<div class="%s">', implode( ' ', get_post_class() ) ),
			'context' => 'entry',
			'echo'    => false
		) );

		$image = genesis_get_image( array(
			'format'  => 'html',
			'size'    => $atts['image_size'],
			'context' => 'featured-post-widget',
			'attr'    => genesis_parse_attr( 'entry-image-widget' ),
		) );

		if ( $atts['show_image'] && $image )
			$output .= sprintf( '<a href="%s" title="%s" class="%s">%s</a>', get_permalink(), the_title_attribute( 'echo=0' ), esc_attr( $atts['image_alignment'] ), $image );

		if ( $atts['show_title'] )
			$output .= genesis_html5() ? '<header class="entry-header">' : '';

			if ( ! empty( $atts['show_title'] ) ) {

				if ( genesis_html5() )
					$output .= sprintf( '<h2 class="entry-title"><a href="%s" title="%s">%s</a></h2>', get_permalink(), the_title_attribute( 'echo=0' ), get_the_title() );
				else
					$output .= sprintf( '<h2><a href="%s" title="%s">%s</a></h2>', get_permalink(), the_title_attribute( 'echo=0' ), get_the_title() );

			}

			if ( ! empty( $atts['show_byline'] ) && ! empty( $atts['post_info'] ) )
				$output .= sprintf( genesis_html5() ? '<p class="entry-meta">%s</p>' : '<p class="byline post-info">%s</p>', do_shortcode( $atts['post_info'] ) );

		if ( $atts['show_title'] )
			$output .= genesis_html5() ? '</header>' : '';

		if ( ! empty( $atts['show_content'] ) ) {

			$output .= genesis_html5() ? '<div class="entry-content">' : '';

			ob_start(); // Sorry!!

			if ( 'excerpt' == $atts['show_content'] ) {
				the_excerpt();
			}
			elseif ( 'content-limit' == $atts['show_content'] ) {
				the_content_limit( (int) $atts['content_limit'], esc_html( $atts['more_text'] ) );
			}
			else {
				global $more;
				$orig_more = $more;
				$more = 0;
				the_content( esc_html( $atts['more_text'] ) );
				$more = $orig_more;
			}

			$output .= ob_get_clean();

			$output .= genesis_html5() ? '</div>' : '';

		}

		$output .= genesis_markup( array(
			'html5' => '</article>',
			'xhtml' => '</div>',
			'echo'  => false
		) );

	endwhile; endif;

	//* Restore original query
	wp_reset_query();

	$output .= '</div>';

	return $output;

}

/* Execute shortcodes on text widgets */
add_filter( 'widget_text', 'do_shortcode' );

/**
 * Add custom metabox to portfolio
 * Using a light weight fully secured library for adding WordPress post metaboxes.
 */
require_once( CHILD_DIR . '/lib/hd-wp-metabox-api/class-hd-wp-metabox-api.php' );

$portfolio_meta_options = array(
    'metabox_title' => __( 'Portfolio Options', 'genesisawesome' ),
    'metabox_id'    => 'portlight_portfolio_options',
    'post_type'     => 'portfolio',
    'context'       => 'normal',
    'priority'      => 'high',
);

$portfolio_meta_fields = array(
    '_project_title' => array(
		'title' => __( 'Project title', 'genesisawesome' ),
		'type'  => 'text',
		'desc'  => __( 'Enter the title of the project', 'genesisawesome' ),
		'sanit' => 'nohtml',
    ),
    '_project_work' => array(
		'title' => __( 'Project work name', 'genesisawesome' ),
		'type'  => 'text',
		'desc'  => __( 'Enter the work done in this project', 'genesisawesome' ),
		'sanit' => 'nohtml'
    ),
    '_project_url' => array(
		'title' => __( 'Project URI', 'genesisawesome' ),
		'type'  => 'text',
		'desc'  => __( 'Enter the url of the project', 'genesisawesome' ),
		'sanit' => 'url'
    ),
    '_project_client' => array(
		'title' => __( 'Project clinet name', 'genesisawesome' ),
		'type'  => 'text',
		'desc'  => __( 'Enter the name of the project clinet', 'genesisawesome' ),
		'sanit' => 'nohtml'
    ),
);

$portfolio_metabox = new HD_WP_Metabox_API( $portfolio_meta_options, $portfolio_meta_fields );