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
define( 'CHILD_THEME_VER', '1.0' );
define( 'GA_CHILDTHEME_FIELD', 'genesisawesome_portlight_settings' );
define( 'GA_HOMEPAGE_FIELD', 'genesisawesome_portlight_homepage_settings' );

add_action( 'genesis_init', 'genesisawesome_childtheme_init', 20 );
/**
 * GenesisAwesome Child Theme init
 * 
 * @since 1.0
 * 
 * @return null
 */
function genesisawesome_childtheme_init() {

	/* Load HTML5 for Genesis Child Theme */
	require_once( CHILD_DIR . '/lib/genesisawesome-html5.php' );

	/* Load GenesisAwesome Settings Page class */
	require_once( CHILD_DIR . '/lib/genesisawesome-settings.php' );

	/* Load Genesis Awesome Widgets */
	require_once( CHILD_DIR . '/lib/widgets/widget-facebook-likebox.php' );
	require_once( CHILD_DIR . '/lib/widgets/widget-flickr.php' );

	add_theme_support( 'genesis-footer-widgets', 3 );
	add_theme_support( 'genesis-menus', array( 'primary' => __( 'Primary Navigation', 'genesisawesome' ) ) );

	/* Register new Image sizes */
	add_image_size( 'portlight-portfolio-thumbnail', 360, 260, true );
	add_image_size( 'portlight-post-image', 900, 250, true );
	
	/* Load Parent Theme Stylesheet */
	add_action( 'genesis_meta', 'genesisawesome_google_fonts', 0 );

	/* Load Styles and Stykes for Genesis Child Theme */
	add_action( 'wp_enqueue_styles', 'genesisawesome_childtheme_styles' );
	add_action( 'wp_enqueue_scripts', 'genesisawesome_childtheme_scripts' );

	/* Load inline Styles and Scripts for Genesis Child Theme */
	add_action( 'genesis_meta', 'genesisawesome_childtheme_inline_styles' );
	add_action( 'wp_footer', 'genesisawesome_childtheme_inline_scripts' );

	add_action( 'genesis_before_header', 'genesisawesome_do_before_header' );

	/* Remove Default Post Image */
	remove_action( 'genesis_post_content', 'genesis_do_post_image' );
	/* Add Custom Post Image */
	add_action( 'genesis_before_post_title', 'genesisawesome_do_post_image' );

	/* Init Custom GenesisAwesome Widgets */
	add_action( 'widgets_init', 'genesisawesome_custom_widgets' );

	/* Post Share and Sunscribe Boxes */
	remove_action( 'genesis_after_post', 'genesis_get_comments_template' );
	add_action( 'genesis_after_post', 'genesisawesome_subscribe_sharebox' );
	add_action( 'genesis_after_post', 'genesis_get_comments_template' );

	/* Remove Nav Right extras */
	remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

}

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
	$GLOBALS['_genesisawesome_portlight_homepage'] = new GenesisAwesome_Portlight_Homepage;

	/* Loalization */
	load_child_theme_textdomain( 'genesisawesome', CHILD_DIR . '/languages' );

}

/**
 * Print Google Fonts
 * 
 * @since 1.0
 * 
 * @return null
 */
function genesisawesome_google_fonts() {

	echo '<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Goudy+Bookletter+1911&text=%26|Open+Sans:300i,ri,bi,r,300,b|Open+Sans+Condensed:300,300i,b" type="text/css" />' . "\n";

}

/**
 * GenesisAwesome Childtheme Styles
 * 
 * @since 1.0
 * 
 * @return null
 */
function genesisawesome_childtheme_styles() {

}

/**
 * GenesisAwesome Childtheme Scripts
 * 
 * @since 1.0
 * 
 * @return null
 */
function genesisawesome_childtheme_scripts() {

	wp_enqueue_script( 'ga-modernizr',  CHILD_URL . '/js/modernizr.min.js', '', null, false );
	wp_enqueue_script( 'ga-fitvids',    CHILD_URL . '/js/fitvids.min.js', array( 'jquery' ), null, true );
	if ( is_home() && genesis_get_option( 'enable_custom_homepage', GA_HOMEPAGE_FIELD ) )
		wp_enqueue_script( 'ga-homepage',    CHILD_URL . '/js/home.js', array( 'jquery' ), null, true );

}

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

	$logo_css    = ( $logo_url && $logo_width && $logo_height ) ? ".header-image #title-area #title a{ background: url('{$logo_url}') no-repeat;width: {$logo_width}px;height: {$logo_height}px;}\n" : '' ;

	// Typography CSS

	$the_css = ''; $enable_typography = false;

	$typography_classes = array(
		'enable_ga_typography',
		'body, p, select, textarea'     => array( 'color' => 'ga_font_color', 'fontsize' => 'ga_font_size' ),
		'a, a:link, a:visited'          => array( 'color' => 'ga_link_color' ),
		'a:hover, a:active'             => array( 'color' => 'ga_link_hover_color' ),
		'enable_ga_h1_typography',
		'h1'                            => array( 'fontsize' => 'ga_h1_font_size', 'color' => 'ga_h1_font_color' ),
		'h1 a, h1 a:link, h1 a:visited' => array( 'color' => 'ga_h1_link_color' ),
		'h1 a:hover, h1 a:active'       => array( 'color' => 'ga_h1_link_hover_color' ),
		'enable_ga_h2_typography',
		'h2'                            => array( 'fontsize' => 'ga_h2_font_size', 'color' => 'ga_h2_font_color' ),
		'h2 a, h2 a:link, h2 a:visited' => array( 'color' => 'ga_h2_link_color' ),
		'h2 a:hover, h2 a:active'       => array( 'color' => 'ga_h2_link_hover_color' ),
		'enable_ga_h3_typography',
		'h3'                            => array( 'fontsize' => 'ga_h3_font_size', 'color' => 'ga_h3_font_color' ),
		'h3 a, h3 a:link, h3 a:visited' => array( 'color' => 'ga_h3_link_color' ),
		'h3 a:hover, h3 a:active'       => array( 'color' => 'ga_h3_link_hover_color' ),
		'enable_ga_h4_typography',
		'h4'                            => array( 'fontsize' => 'ga_h4_font_size', 'color' => 'ga_h4_font_color' ),
		'h4 a, h4 a:link, h4 a:visited' => array( 'color' => 'ga_h4_link_color' ),
		'h4 a:hover, h4 a:active'       => array( 'color' => 'ga_h4_link_hover_color' ),
		'enable_ga_h5_typography',
		'h5'                            => array( 'fontsize' => 'ga_h5_font_size', 'color' => 'ga_h5_font_color' ),
		'h5 a, h5 a:link, h5 a:visited' => array( 'color' => 'ga_h5_link_color' ),
		'h5 a:hover, h5 a:active'       => array( 'color' => 'ga_h5_link_hover_color' )
	);

	foreach ( $typography_classes as $selector => $options ) {

		$css = '';

		if ( is_string( $options ) ) {
			$enable_typography = genesis_get_option( $options, GA_CHILDTHEME_FIELD );
			continue;
		}

		if ( is_array( $options ) && $enable_typography ) {

			foreach ( $options as $proeprty => $pro_opt ) {

				if ( $proeprty == 'color' && _ga_typography_color( $pro_opt ) )
					$css .= _ga_typography_color( $pro_opt );

				if (  $proeprty == 'fontsize' && _ga_typography_fontsize( $pro_opt ) )
					$css .= _ga_typography_fontsize( $pro_opt );

			}

			if ( ! empty( $css ) )
				$the_css .=  "$selector { $css }\n";

		}

	}

	if ( ! $logo_css && ! $the_css )
		return;
	?>
	<style type="text/css">
	/* <![CDATA[ */
	<?php echo $logo_css . $the_css; ?>
	/* ]]> */
	</style>
	<?php

}

/**
 * Helper function to get CSS font-size property
 * 
 * @access private
 * @param  string $option
 * @return string
 */
function _ga_typography_fontsize( $option ) {

	if ( ! ( $_size = genesis_get_option( $option, GA_CHILDTHEME_FIELD ) ) )
		return false;

	 return 'font-size: ' . absint( $_size ) . 'px;';

}

/**
 * Helper function to get CSS color property
 * 
 * @access private
 * @param  string $option
 * @return string
 */
function _ga_typography_color( $option ) {

	if ( ! ( $_color = genesis_get_option( $option, GA_CHILDTHEME_FIELD ) ) )
		return false;

	 return 'color: ' . $_color . ';';

}

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
	<script src='http://assets.pinterest.com/js/pinit.js' type='text/javascript'></script>
	<script type='text/javascript'>
	/* <![CDATA[ */
		!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
		function run_pinmarklet() {var e=document.createElement('script'); e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','http://assets.pinterest.com/js/pinmarklet.js?r=' + Math.random()*99999999);document.body.appendChild(e);}
		(function() {var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;po.src = 'https://apis.google.com/js/plusone.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);})();
		(function() {var li = document.createElement('script'); li.type = 'text/javascript'; li.async = true;li.src = ('https:' == document.location.protocol ? 'https:' : 'http:') + '//platform.stumbleupon.com/1/widgets.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(li, s);})();
		(function() {var s = document.createElement('SCRIPT'), s1 = document.getElementsByTagName('SCRIPT')[0];s.type = 'text/javascript';s.async = true;s.src = 'http://widgets.digg.com/buttons.js';s1.parentNode.insertBefore(s, s1);})();
	/* ]]> */
	</script>
		<?php
	}

}

/**
 * Before Header ( Social Icons and Search Box )
 * 
 * @since 1.0
 * 
 * @return null
 */
function genesisawesome_do_before_header() {

	echo '<div id="ga-topbar">';
		echo '<div class="wrap">';

			echo '<ul id="social-profiles">';
			$soc_urls = array(
				'rssfeed_url'     => __( 'Rss Feeds', 'genesisawesome' ),
				'twitter_url'     => __( 'Twitter', 'genesisawesome' ),
				'facebook_url'    => __( 'Facebook', 'genesisawesome' ),
				'dribbble_url'    => __( 'Dribbble', 'genesisawesome' ),
			);
			foreach ( $soc_urls as $soc_opt => $soc_name ) {

				if ( ! $soc_url = genesis_get_option( $soc_opt, GA_CHILDTHEME_FIELD ) )
					continue;
				?>
				<li class='<?php echo sanitize_title( $soc_name );?>'>
					<a href='<?php echo esc_url( $soc_url ) ?>' target='_blank' title='<?php echo esc_attr( $soc_name );?>'><?php echo esc_attr( $soc_name );?></a>
				</li>
				<?php

			}
			echo '</ul>';
			
			get_search_form();

		echo '</div>';
	echo '</div>';

}

/**
 * Featured Post Image 
 * 
 * @since 1.0
 * 
 * @return null
 */
function genesisawesome_do_post_image() {

	if ( ! is_singular() && genesis_get_option( 'content_archive_thumbnail' ) ) {
		$img = genesis_get_image( array( 'format' => 'html', 'size' => genesis_get_option( 'image_size' ), 'attr' => array( 'class' => 'aligncenter post-image' ) ) );
		printf( '<div class="ga-post-img"><a href="%s" title="%s">%s</a></div>', get_permalink(), the_title_attribute( 'echo=0' ), $img );
	}

}

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
	$right_text = sprintf( '<div class="one-half text-right">[footer_copyright before="%s "] &middot; [footer_childtheme_link before="" after=" %s"] [footer_genesis_link url="http://www.genesisawesome.com/recommends/genesis" before=""] &middot; [footer_wordpress_link]</div>', __( 'Copyright', 'genesis' ), __( 'on', 'genesis' ) );

	return $left_text . $right_text;

}

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
	?>

	<?php if ( genesis_get_option( 'enable_post_subscribe_box', GA_CHILDTHEME_FIELD ) ) : ?>
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
	<?php endif; ?>

	<?php if ( genesis_get_option( 'enable_post_social_share', GA_CHILDTHEME_FIELD ) ) : ?>
<div id="ga-sharebox">
	<h4><?php _e( 'Share this article!', 'genesisawesome' );?></h4>
	<table width='100%'>
		<tr>
			<td><iframe allowTransparency='true' src='//www.facebook.com/plugins/like.php?href=<?php echo urlencode( get_permalink() ); ?>&amp;send=false&amp;layout=box_count&amp;width=50&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=65' frameborder='0' scrolling='no' style='border:none; overflow:hidden; width:50px; height:65px;'></iframe></td>
			<td><a class='twitter-share-button' data-count='vertical' data-lang='en' data-title='<?php the_title_attribute(); ?>' data-url='<?php the_permalink(); ?>' href='https://twitter.com/share'>Tweet</a></td>
			<td>	
				<div style='position:relative;'>
					<a class='pin-it-button' count-layout='vertical' href='http://pinterest.com/pin/create/button/?url=<?php echo urldecode( get_permalink() ); ?>'>Pin It now!</a>
					<a href='javascript:void(run_pinmarklet())' style='position:absolute;top:0;bottom:0;left:0;right:0;'></a>
				</div>
			</td>
			<td><g:plusone href='<?php the_permalink(); ?>' size='tall'></g:plusone></td>
			<td>
				<su:badge layout="5" location="<?php get_permalink();?>"></su:badge>
			</td>
			<td><a class='DiggThisButton DiggMedium'></a></td>
			<td>
				<script src='//platform.linkedin.com/in.js' type='text/javascript'></script>
				<script data-counter='top' data-url='<?php the_permalink(); ?>' type='IN/Share'></script>
			</td>
		</tr>
	</table>
</div>
	<?php endif; ?>

	<?php if ( genesis_get_option( 'enable_post_related_posts', GA_CHILDTHEME_FIELD ) ) :?>
<div id='ga-relatedposts'>
	 <h4><?php _e( 'Related Posts', 'genesisawesome' );?></h4>
	 <?php genesisawesome_related_posts(); ?>
</div>
	<?php endif; ?>

	<?php

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

	if ( ! $categories ) {
		echo '<p>' . __( 'No Related Posts!', 'genesisawesome' ) . '</p>';
		return;
	}

	foreach ( $categories as $cat ) {
		$cat_ids[] = $cat->term_id;
	}

	$args = array(
		'category__in'        => $cat_ids,
		'post__not_in'        => array( $post->ID ),
		'posts_per_page'      => absint( $number ),
		'ignore_sticky_posts' => 1,
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

	wp_reset_query();

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
	$options['portlighthomepage'] = array(
		'label'          => __( 'Portlight Homepage Settings', 'genesisawesome' ),
		'settings-field' => GA_HOMEPAGE_FIELD,
	);

	return $options;

}

add_action( 'genesis_before_post_title', 'genesisawesome_post_data_stamp' );
/**
 * Add custom date type
 * 
 * @since 1.0
 * 
 * @return null
 */
function genesisawesome_post_data_stamp() {

	if ( get_post_type() == 'post' )
		printf( '<div class="ga-date published" title="%s"><span class="datenum">%s</span><span class="monthname">%s</span></div>', get_the_date('c'), get_the_date( 'd' ), get_the_date( 'M' ) );

}

add_action( 'template_redirect', 'genesisawesome_cond_actions' );
/**
 * Remove Post Meta on Archiv pages
 * 
 * @since 1.0
 * 
 * @return null
 */
function genesisawesome_cond_actions() {

	if ( ! is_single() )
		remove_action( 'genesis_after_post_content', 'genesis_post_meta' );

}

add_action( 'genesis_before_footer', 'genesisawesome_fullwidth_footer', 1 );
/**
 * A Tweak for Full Width Footer
 * 
 * @return null 
 */
function genesisawesome_fullwidth_footer() {

	?>
	</div> <!-- end .wrap -->
	<div class="ga-footer-fullwidth">
	<?php

}

add_filter( 'home_template', 'genesisawesome_home_template' );
/**
 * Custom Home Page Template
 * 
 * @since 1.0
 * 
 * @param  string $template PATH to Default Homepage Template
 * @return string           PATH to Default or Custom Homepage Template
 */
function genesisawesome_home_template( $template ) {
	if ( genesis_get_option( 'enable_custom_homepage', GA_HOMEPAGE_FIELD ) )
		return locate_template( array( 'custom-home.php' ) );
	else
		return $template;

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
		'name'               => _x( 'Portfolio', 'Portfolio Labels ', 'genesisawesome' ),
		'singular_name'      => _x( 'Portfolio', 'Portfolio Label', 'genesisawesome' ),
		'menu_name'          => _x( 'Portfolio', 'Portfolio Label', 'genesisawesome' ),
		'add_new_item'       => _x( 'Add New Portfolio', 'Portfolio Label', 'genesisawesome' ),
		'edit_item'          => _x( 'Edit Portfolio', 'Portfolio Label', 'genesisawesome' ),
		'new_item'           => _x( 'New Portfolio', 'Portfolio Label', 'genesisawesome' ),
		'view_item'          => _x( 'View Portfolio', 'Portfolio Label', 'genesisawesome' ),
		'search_items'       => _x( 'Search Portfolio', 'Portfolio Label', 'genesisawesome' ),
		'not_found'          => _x( 'No Portfolio items found', 'Portfolio Label', 'genesisawesome' ),
		'not_found_in_trash' => _x( 'No Portfolio items found in trash', 'Portfolio Label', 'genesisawesome' ),

	);

	$args = array(
		'label'               => _x( 'Portfolio', 'Portfolio Label', 'genesisawesome' ),
		'labels'              => $labels,
		'public'              => true,
		'exclude_from_search' => true,
		'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'custom-fields', 'genesis-seo' ),
		'has_archive'         => true
	);

	register_post_type( 'portfolio', $args );

	$labels = array(
		'name'          => _x( 'Portfolio Categories', 'Portfolio category labels', 'genesisawesome' ),
		'singular_name' => _x( 'Portfolio Category', 'Portfolio category labels', 'genesisawesome' ),
		'all_items'     => _x( 'All Portfolio Categories', 'Portfolio category labels', 'genesisawesome' ),
		'edit_item'     => _x( 'Edit Portfolio Category', 'Portfolio category labels', 'genesisawesome' ),
		'update_item'   => _x( 'Update Portfolio Category', 'Portfolio category labels', 'genesisawesome' ),
		'add_new_item'  => _x( 'Add Portfolio Category', 'Portfolio category labels', 'genesisawesome' ),
		'new_item_name' => _x( 'New Portfolio Category Name', 'Portfolio category labels', 'genesisawesome' ),
		'parent_item'   => _x( 'Parent Portfolio Category', 'Portfolio category labels', 'genesisawesome' ),
		'search_items'  => _x( 'Search Portfolio Categories', 'Portfolio category labels', 'genesisawesome' ),
		'popular_items' => _x( 'Popular Portfolio Categories', 'Portfolio category labels', 'genesisawesome' ),

	);
	
	$args = array(
		'label'        => _x( 'Portfolio Categories', 'Portfolio category labels', 'genesisawesome' ),
		'labels'       => $labels,
		'hierarchical' => true
	);

	register_taxonomy( 'portfolio-category', array( 'portfolio' ), $args );

}

add_action( 'pre_get_posts', 'genesisawesome_portfolio_items' );
/**
 * Show all Portfolio Items
 * 
 * @since 1.0
 * 
 * @param  object $query Query object
 * @return null
 */
function genesisawesome_portfolio_items( $query ) {

    if( $query->is_main_query() && is_post_type_archive( 'portfolio' ) && ! is_admin() ) {
        $query->set( 'nopaging', true );
    }

}

/**
 * Portfolio Custom Loop
 * 
 * @since 1.0
 * 
 * @param  int $number_of_posts Number of portfolio items to show
 * @return null
 */
function genesisawesome_portfolio_loop( $number_of_posts ) {

	$portfolio_args = array(
		'post_type'      => 'portfolio',
		'posts_per_page' => $number_of_posts
	);

	$portfolio = new WP_Query( $portfolio_args );

	$count = 0;

	if ( $portfolio->have_posts() ) {
		while ( $portfolio->have_posts() ) {
			$portfolio->the_post(); global $post;
			if ( ! has_post_thumbnail() )
				return;
			?>
			<div class="portfolio portfolio-showcase one-third<?php if( $count%3 == 0 ) echo ' first'; ?>">
				<div class="portfolio-image"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'portlight-portfolio-thumbnail' ); ?></a></div>
				<div class="portfolio-headline"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
			</div>
			<?php
			$count++;
		}
	}

}