<?php
/**
 * GenesisAwesome Child Theme Settings 
 * 
 * @package    Genesis Child Theme
 * @subpackage Admin
 * @author     Harish Dasari
 * @version    1.0
 * @link       http://www.genesisawesome.com/
 */

/**
 * GenesisAwesome Childtheme Settings Class
 * 
 * @since 1.0
 */
class GenesisAwesome_Childtheme_Settings extends Genesis_Admin_Boxes {

	/**
	 * GenesisAwesome_Childtheme_Settings Constructor
	 */
	function __construct() {

		$page_id = 'genesisawesome-settings';

		$menu_ops = array(
			'submenu' => array(
				'parent_slug' => 'genesis',
				'page_title'  => __( 'GenesisAwesome - Portlight Theme Settings', 'genesisawesome' ),
				'menu_title'  => __( 'Portlight Settings', 'genesisawesome' )
			)
		);

		$page_ops = array(
			'screen_icon'       => 'options-general',
			'save_button_text'  => __( 'Save Settings', 'genesis' ),
			'reset_button_text' => __( 'Reset Settings', 'genesis' ),
			'saved_notice_text' => __( 'Settings saved.', 'genesis' ),
			'reset_notice_text' => __( 'Settings reset.', 'genesis' ),
			'error_notice_text' => __( 'Error saving settings.', 'genesis' ),
		);

		$settings_field = GA_CHILDTHEME_FIELD;

		$default_settings = array(
			'logo_url'                  => '',
			'logo_width'                => '',
			'logo_height'               => '',
			'enable_post_social_share'  => 1,
			'enable_post_subscribe_box' => 1,
			'enable_post_related_posts' => 1,
			'feedburner_id'             => '',
			'footer_left_text'          => '',
			'contact_email'             => '',
			'recaptcha_publickey'       => '',
			'recaptcha_privatekey'      => '',
			'recaptcha_colortheme'      => 'red',
			'rssfeed_url'               => '#',
			'facebook_url'              => '#',
			'twitter_url'               => '#',
			'dribbble_url'              => '#',
			'enable_ga_typography'      => 0,
			'ga_font_size'              => '',
			'ga_font_color'             => '',
			'ga_link_color'             => '',
			'ga_link_hover_color'       => '',
			'enable_ga_h1_typography'   => 0,
			'ga_h1_font_size'           => '',
			'ga_h1_font_color'          => '',
			'ga_h1_link_color'          => '',
			'ga_h1_link_hover_color'    => '',
			'enable_ga_h2_typography'   => 0,
			'ga_h2_font_size'           => '',
			'ga_h2_font_color'          => '',
			'ga_h2_link_color'          => '',
			'ga_h2_link_hover_color'    => '',
			'enable_ga_h3_typography'   => 0,
			'ga_h3_font_size'           => '',
			'ga_h3_font_color'          => '',
			'ga_h3_link_color'          => '',
			'ga_h3_link_hover_color'    => '',
			'enable_ga_h4_typography'   => 0,
			'ga_h4_font_size'           => '',
			'ga_h4_font_color'          => '',
			'ga_h4_link_color'          => '',
			'ga_h4_link_hover_color'    => '',
			'enable_ga_h5_typography'   => 0,
			'ga_h5_font_size'           => '',
			'ga_h5_font_color'          => '',
			'ga_h5_link_color'          => '',
			'ga_h5_link_hover_color'    => '',
		);

		$this->create( $page_id, $menu_ops, $page_ops, $settings_field, $default_settings );

		add_action( 'genesis_settings_sanitizer_init', array( $this, 'genesisawesome_childtheme_filters' ) );

		add_action( 'admin_init', array( $this, 'ga_load_scripts' ) );

	}

	/**
	 * Options Filters for Genesisawesome
	 * 
	 * @return null
	 */
	public function genesisawesome_childtheme_filters() {

		genesis_add_option_filter(
			'one_zero',
			$this->settings_field,
			array(
				'enable_homepage_slider',
				'enable_post_social_share',
				'enable_post_subscribe_box',
				'enable_post_related_posts',
				'enable_ga_typography',
				'enable_ga_h1_typography',
				'enable_ga_h2_typography',
				'enable_ga_h3_typography',
				'enable_ga_h4_typography',
				'enable_ga_h5_typography',
			)
		);

		genesis_add_option_filter(
			'no_html',
			$this->settings_field,
			array(
				'logo_url',
				'feedburner_id',
				'recaptcha_publickey',
				'recaptcha_privatekey',
				'recaptcha_colortheme',
				'rssfeed_url',
				'facebook_url',
				'twitter_url',
				'dribbble_url',
				'googleplus_url',
				'stumbleupon_url',
				'pinterest_url',
				'youtube_url',
				'ga_font_color',
				'ga_link_color',
				'ga_link_hover_color',
				'ga_h1_font_color',
				'ga_h1_link_color',
				'ga_h1_link_hover_color',
				'ga_h2_font_color',
				'ga_h2_link_color',
				'ga_h2_link_hover_color',
				'ga_h3_font_color',
				'ga_h3_link_color',
				'ga_h3_link_hover_color',
				'ga_h4_font_color',
				'ga_h4_link_color',
				'ga_h4_link_hover_color',
				'ga_h5_font_color',
				'ga_h5_link_color',
				'ga_h5_link_hover_color',
			)
		);

		genesis_add_option_filter(
			'requires_unfiltered_html',
			$this->settings_field,
			array(
				'footer_left_text',
			)
		);

		genesis_add_option_filter(
			'email',
			$this->settings_field,
			array(
				'contact_email'
			)
		);

		genesis_add_option_filter(
			'integer',
			$this->settings_field,
			array(
				'logo_width',
				'logo_height',
				'homepage_slider_category',
				'homepage_slider_number',
				'ga_font_size',
				'ga_h1_font_size',
				'ga_h2_font_size',
				'ga_h3_font_size',
				'ga_h4_font_size',
				'ga_h5_font_size',
			)
		);

	}

	/**
	 * Register Metaboxes
	 * 
	 * Registers the metaboxes for GenesisAwesome Child Theme Options page.
	 * 
	 * @return null
	 */
	function metaboxes() {

		add_meta_box( 'genesisawesome-childtheme-info', __( 'Theme Information', 'genesisawesome' ), array( $this, 'childtheme_info' ), $this->pagehook, 'main', 'high' );
		add_meta_box( 'genesisawesome-general-settings', __( 'General Settings', 'genesisawesome' ), array( $this, 'general_settings' ), $this->pagehook, 'main', 'high' );
		add_meta_box( 'genesisawesome-social-settings', __( 'Social Settings', 'genesisawesome' ), array( $this, 'social_settings' ), $this->pagehook, 'main', 'high' );
		add_meta_box( 'genesisawesome-contact-settings', __( 'Contact Page Settings', 'genesisawesome' ), array( $this, 'contact_page_settings' ), $this->pagehook, 'main', 'high' );
		add_meta_box( 'genesisawesome-typography-settings', __( 'Typography Settings', 'genesisawesome' ), array( $this, 'typography_settings' ), $this->pagehook, 'main', 'high' );

	}

	/**
	 * Child Theme Information 
	 * 
	 * @return null
	 */
	function childtheme_info() {

		?>
		<table class="form-table">
			<tr>
				<td><?php _e( 'Theme Name', 'genesisawesome' );?></td>
				<td> : <strong><a href="<?php echo esc_url( CHILD_THEME_URL ); ?>" target="_blank"><?php esc_html_e( CHILD_THEME_NAME ); ?></a></strong></td>
			</tr>
			<tr>
				<td><?php _e( 'Theme Version', 'genesisawesome' );?></td>
				<td> : v<?php esc_html_e( CHILD_THEME_VER ); ?></td>
			</tr>
			<tr>
				<td><?php _e( 'Author', 'genesisawesome' );?></td>
				<td> : <strong>Harish Dasari</strong> / <a href="http://www.genesisawesome.com/" target="_blank">GenesisAwesome</a></td>
			</tr>
			<tr align="center">
				<td colspan="2">
					<a href="http://www.genesisawesome.com/donate/" title="Donate" target="_blank"><img src="http://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" alt="" /></a>
					<div>Your Donation will be used to future release of Free Child Themes :). Thank You! <div style="text-align:right;">-- <a href="http://about.me/harishdasari" target="_blank">Harish Dasari</a></div></div>
				</td>
			</tr>
		</table>
		<?php

	}

	/**
	 * General Settings Box
	 * 
	 * @return null 
	 */
	function general_settings() {

		?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->get_field_id( 'logo_url' ); ?>"><?php _e( 'Custom Logo URL', 'genesisawesome' ) ?></label></th>
				<td><input type="text" name="<?php echo $this->get_field_name( 'logo_url' ); ?>" id="<?php echo $this->get_field_id( 'logo_url' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'logo_url' ) ); ?>" class="widefat" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->get_field_id( 'logo_width' ); ?>"><?php _e( 'Logo Width', 'genesisawesome' ) ?></label></th>
				<td><input type="text" name="<?php echo $this->get_field_name( 'logo_width' ); ?>" id="<?php echo $this->get_field_id( 'logo_width' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'logo_width' ) ); ?>" size="4" /> px</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->get_field_id( 'logo_height' ); ?>"><?php _e( 'Logo Height', 'genesisawesome' ) ?></label></th>
				<td><input type="text" name="<?php echo $this->get_field_name( 'logo_height' ); ?>" id="<?php echo $this->get_field_id( 'logo_height' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'logo_height' ) ); ?>" size="4" /> px</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->get_field_id( 'enable_post_social_share' ); ?>"><?php _e( 'Enable Post Social Share ?', 'genesisawesome' ); ?></label></th>
				<td><input type="checkbox" name="<?php echo $this->get_field_name( 'enable_post_social_share' ); ?>" id="<?php echo $this->get_field_id( 'enable_post_social_share' ); ?>" value="1"<?php checked( '1', $this->get_field_value( 'enable_post_social_share' ) ); ?> /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->get_field_id( 'enable_post_subscribe_box' ); ?>"><?php _e( 'Enable Post Subscribe box ?', 'genesisawesome' ); ?></label></th>
				<td><input type="checkbox" name="<?php echo $this->get_field_name( 'enable_post_subscribe_box' ); ?>" id="<?php echo $this->get_field_id( 'enable_post_subscribe_box' ); ?>" value="1"<?php checked( '1', $this->get_field_value( 'enable_post_subscribe_box' ) ); ?> /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->get_field_id( 'enable_post_related_posts' ); ?>"><?php _e( 'Enable Related Posts ?', 'genesisawesome' ); ?></label></th>
				<td><input type="checkbox" name="<?php echo $this->get_field_name( 'enable_post_related_posts' ); ?>" id="<?php echo $this->get_field_id( 'enable_post_related_posts' ); ?>" value="1"<?php checked( '1', $this->get_field_value( 'enable_post_related_posts' ) ); ?> /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->get_field_id( 'feedburner_id' ); ?>"><?php _e( 'Feedburner ID', 'genesisawesome' ); ?></label></th>
				<td><input type="text" name="<?php echo $this->get_field_name( 'feedburner_id' ); ?>" id="<?php echo $this->get_field_id( 'feedburner_id' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'feedburner_id' ) ); ?>" class="widefat" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->get_field_id( 'footer_left_text' ); ?>"><?php _e( 'Footer Left Text', 'genesisawesome' ); ?></label></th>
				<td><textarea name="<?php echo $this->get_field_name( 'footer_left_text' ); ?>" id="<?php echo $this->get_field_id( 'footer_left_text' ); ?>"  class="widefat" rows="4"><?php echo esc_attr( $this->get_field_value( 'footer_left_text' ) ); ?></textarea></td>
			</tr>
		</table>
		<?php

	}

	/**
	 * Social Settings Box
	 * @return null
	 */
	function social_settings() {

		?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->get_field_id( 'rssfeed_url' ); ?>"><?php _e( 'Rss Feed URL', 'genesisawesome' ) ?></label></th>
				<td><input type="text" name="<?php echo $this->get_field_name( 'rssfeed_url' ); ?>" id="<?php echo $this->get_field_id( 'rssfeed_url' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'rssfeed_url' ) ); ?>" class="widefat" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->get_field_id( 'facebook_url' ); ?>"><?php _e( 'Facebook URL', 'genesisawesome' ) ?></label></th>
				<td><input type="text" name="<?php echo $this->get_field_name( 'facebook_url' ); ?>" id="<?php echo $this->get_field_id( 'facebook_url' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'facebook_url' ) ); ?>" class="widefat" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->get_field_id( 'twitter_url' ); ?>"><?php _e( 'Twitter URL', 'genesisawesome' ) ?></label></th>
				<td><input type="text" name="<?php echo $this->get_field_name( 'twitter_url' ); ?>" id="<?php echo $this->get_field_id( 'twitter_url' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'twitter_url' ) ); ?>" class="widefat" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->get_field_id( 'dribbble_url' ); ?>"><?php _e( 'Dribbble URL', 'genesisawesome' ) ?></label></th>
				<td><input type="text" name="<?php echo $this->get_field_name( 'dribbble_url' ); ?>" id="<?php echo $this->get_field_id( 'dribbble_url' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'dribbble_url' ) ); ?>" class="widefat" /></td>
			</tr>
		</table>
		<p class="description">
			<?php _e( 'Leave fields as blank to hide the icon/link', 'genesisawesome' ); ?>
		</p>
		<?php

	}

	/**
	 * Contact Page Settings Box
	 * 
	 * @return null
	 */
	function contact_page_settings() {

		?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->get_field_id( 'contact_email' ); ?>"><?php _e( 'Contact Email', 'genesisawesome' ) ?></label></th>
				<td><input type="text" name="<?php echo $this->get_field_name( 'contact_email' ); ?>" id="<?php echo $this->get_field_id( 'contact_email' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'contact_email' ) ); ?>" class="widefat" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->get_field_id( 'recaptcha_publickey' ); ?>"><?php _e( 'reCaptcha Public Key', 'genesisawesome' ) ?></label></th>
				<td><input type="text" name="<?php echo $this->get_field_name( 'recaptcha_publickey' ); ?>" id="<?php echo $this->get_field_id( 'recaptcha_publickey' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'recaptcha_publickey' ) ); ?>" class="widefat" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->get_field_id( 'recaptcha_privatekey' ); ?>"><?php _e( 'reCaptcha Private Key', 'genesisawesome' ) ?></label></th>
				<td><input type="text" name="<?php echo $this->get_field_name( 'recaptcha_privatekey' ); ?>" id="<?php echo $this->get_field_id( 'recaptcha_privatekey' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'recaptcha_privatekey' ) ); ?>" class="widefat"/></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->get_field_id( 'recaptcha_colortheme' ); ?>"><?php _e( 'reCaptcha Color Theme', 'genesisawesome' ) ?></label></th>
				<td>
					<select name="<?php echo $this->get_field_name( 'recaptcha_colortheme' ); ?>" id="<?php echo $this->get_field_id( 'recaptcha_colortheme' ); ?>">
						<option value="red"<?php selected( 'red', $this->get_field_value( 'recaptcha_colortheme' ) ); ?>><?php _e( 'Red', 'genesisawesome' ); ?></option>
						<option value="white"<?php selected( 'white', $this->get_field_value( 'recaptcha_colortheme' ) ); ?>><?php _e( 'White', 'genesisawesome' ); ?></option>
						<option value="blackglass"<?php selected( 'blackglass', $this->get_field_value( 'recaptcha_colortheme' ) ); ?>><?php _e( 'Blackglass', 'genesisawesome' ); ?></option>
						<option value="clean"<?php selected( 'clean', $this->get_field_value( 'recaptcha_colortheme' ) ); ?>><?php _e( 'Clean', 'genesisawesome' ); ?></option>
					</select>
				</td>
			</tr>
		</table>
		<p class="description">
			<?php _e( 'reCaptcha is free captch service from Google to prevent the Email Spams. <br/>To get reCaptcha public key and private key please visit <a href="https://www.google.com/recaptcha/admin/create" target="_blank">reCaptcha admin site</a>', 'genesisawesome' );?>
		</p>
		<?php

	}

	/**
	 * Typography Settings box
	 * 
	 * @return null
	 */
	function typography_settings() {

		?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><h4><label for=""><?php _e( 'Body', 'genesisawesome' ) ?></h4></label></th>
				<td><?php $this->ga_typography_options_form( 'ga' ); ?></td>
			</tr>
			<tr valign="top">
				<th scope="row"><h4><label for=""><?php _e( 'H1 Heading Typography', 'genesisawesome' ) ?></h4></label></th>
				<td><?php $this->ga_typography_options_form( 'ga_h1' ); ?></td>
			</tr>
			<tr valign="top">
				<th scope="row"><h4><label for=""><?php _e( 'H2 Heading Typography', 'genesisawesome' ) ?></h4></label></th>
				<td><?php $this->ga_typography_options_form( 'ga_h2' ); ?></td>
			</tr>
			<tr valign="top">
				<th scope="row"><h4><label for=""><?php _e( 'H3 Heading Typography', 'genesisawesome' ) ?></h4></label></th>
				<td><?php $this->ga_typography_options_form( 'ga_h3' ); ?></td>
			</tr>
			<tr valign="top">
				<th scope="row"><h4><label for=""><?php _e( 'H4 Heading Typography', 'genesisawesome' ) ?></h4></label></th>
				<td><?php $this->ga_typography_options_form( 'ga_h4' ); ?></td>
			</tr>
			<tr valign="top">
				<th scope="row"><h4><label for=""><?php _e( 'H5 Heading Typography', 'genesisawesome' ) ?></h4></label></th>
				<td><?php $this->ga_typography_options_form( 'ga_h5' ); ?></td>
			</tr>
		</table>
		<?php

	}

	/**
	 * Select field for Taxonomy
	 * 
	 * @since 1.0
	 * 
	 * @param  string $option_name Name of the Option
	 * @param  string $taxonomy    Name of the Taxonomy 
	 * @return string              Select field HTML for Taxonomy
	 */
	function ga_get_categories( $option_name, $taxonomy = 'category' ) {
		
		$args = array(
			'taxonomy' => $taxonomy
		);

		$cats = get_categories( $args );
		
		$field_html = '<select name="' . $this->get_field_name( $option_name ) . '" id="' . $this->get_field_id( $option_name ) . '">';
		foreach ( $cats as $cat ) {
			$field_html .= '<option value="' . $cat->term_id . '"' . selected( $cat->term_id, $this->get_field_value( $option_name ), false ) . '>' . $cat->name . '</option>';
		}
		$field_html .= '</select>';

		return $field_html;

	}

	/**
	 * Add action to load styles and scripts
	 * 
	 * @return null
	 */
	function ga_load_scripts() {

		add_action( 'load-' . $this->pagehook, array( $this, 'ga_scripts' ) );

	}

	/**
	 * Load styles and scripts for Option page.
	 * 
	 * @return null
	 */
	function ga_scripts() {

		wp_enqueue_style( 'ga-colorpicker', CHILD_URL . '/lib/css/jquery.miniColors.css' );
		wp_enqueue_script( 'ga-colorpicker', CHILD_URL . '/lib/scripts/jquery.miniColors.min.js', array( 'jquery' ), null, true );
		wp_enqueue_script( 'ga-custom', CHILD_URL . '/lib/scripts/ga-custom.js', array( 'ga-colorpicker' ), null, true );

	}

	/**
	 * Options table for typography
	 * 
	 * @param  string $option Options name
	 * @return null
	 */
	function ga_typography_options_form( $option ) {

		?>
		<table>
			<tr valign="top">
				<td><label for="<?php echo $this->get_field_id( 'enable_' . $option . '_typography' ); ?>"><?php _e( 'Enable ?', 'genesisawesome' );?></label></td>
				<td> <input type="checkbox" name="<?php echo $this->get_field_name( 'enable_' . $option . '_typography' ); ?>" id="<?php echo $this->get_field_id( 'enable_' . $option . '_typography' ); ?>" value="1"<?php checked( '1', $this->get_field_value( 'enable_' . $option . '_typography' ) ); ?>  /></td>
			</tr>
			<tr valign="top">
				<td><label for="<?php echo $this->get_field_id( $option . '_font_size' ); ?>"><?php _e( 'Font Size:', 'genesisawesome' );?></label></td>
				<td> <input type="text" name="<?php echo $this->get_field_name( $option . '_font_size' ); ?>" id="<?php echo $this->get_field_id( $option . '_font_size' ); ?>" value="<?php echo esc_attr( $this->get_field_value( $option . '_font_size' ) ); ?>" size="4" /> px</td>
			</tr>
			<tr valign="top">
				<td><label for="<?php echo $this->get_field_id( $option . '_font_color' ); ?>"><?php _e( 'Font Color:', 'genesisawesome' );?></label></td>
				<td> <input type="text" name="<?php echo $this->get_field_name( $option . '_font_color' ); ?>" id="<?php echo $this->get_field_id( $option . '_font_color' ); ?>" value="<?php echo esc_attr( $this->get_field_value( $option . '_font_color' ) ); ?>" size="6" class="ga-color" /> </td>
			</tr>
			<tr valign="top">
				<td><label for="<?php echo $this->get_field_id( $option . '_link_color' ); ?>"><?php _e( 'Link Color:', 'genesisawesome' );?></label></td>
				<td> <input type="text" name="<?php echo $this->get_field_name( $option . '_link_color' ); ?>" id="<?php echo $this->get_field_id( $option . '_link_color' ); ?>" value="<?php echo esc_attr( $this->get_field_value( $option . '_link_color' ) ); ?>" size="6" class="ga-color" /> </td>
			</tr>
			<tr valign="top">
				<td><label for="<?php echo $this->get_field_id( $option . '_link_hover_color' ); ?>"><?php _e( 'Link Hover Color:', 'genesisawesome' );?></label></td>
				<td> <input type="text" name="<?php echo $this->get_field_name( $option . '_link_hover_color' ); ?>" id="<?php echo $this->get_field_id( $option . '_link_hover_color' ); ?>" value="<?php echo esc_attr( $this->get_field_value( $option . '_link_hover_color' ) ); ?>" size="6" class="ga-color" /> </td>
			</tr>
		</table>
		<?php

	}

}


/**
 * GenesisAwesome Portlight Homepage Settings class
 * 
 * @since 1.0
 */
class GenesisAwesome_Portlight_Homepage extends Genesis_Admin_Boxes {

	/**
	 * GenesisAwesome_Portlight_Homepage Constructor
	 */
	function __construct() {

		$page_id = 'genesisawesome-portlight-homepage-settings';

		$menu_ops = array(
			'submenu' => array(
				'parent_slug' => 'genesis',
				'page_title'  => __( 'GenesisAwesome - Portlight Homepage Settings', 'genesisawesome' ),
				'menu_title'  => __( 'Homepage Settings', 'genesisawesome' )
			)
		);

		$page_ops = array(
			'screen_icon'       => 'options-general',
			'save_button_text'  => __( 'Save Settings', 'genesis' ),
			'reset_button_text' => __( 'Reset Settings', 'genesis' ),
			'saved_notice_text' => __( 'Settings saved.', 'genesis' ),
			'reset_notice_text' => __( 'Settings reset.', 'genesis' ),
			'error_notice_text' => __( 'Error saving settings.', 'genesis' ),
		);

		$settings_field = GA_HOMEPAGE_FIELD;

		$default_settings = array(
			'enable_custom_homepage'    => 1,
			'enable_homepage_headlines' => 1,
			'headline_1'                => __( 'WordPress Developer <span class="amp">&amp;</span> Designer', 'genesisawesome'),
			'headline_2'                => __( 'Genesis Framework Expert', 'genesisawesome' ),
			'headline_desc'             => 'I design WordPress Themes and Plugins, Genesis Framework Expert, WordPress Consultent, SEO Specilist. <br/> Consequatur harum! Lectus facilis ipsam cumque ratione praesent, blanditiis doloremque accumsan cupiditate quidem, vel nonummy iure adipisicing sint, fugit gravida facere aenean eum vestibulum! Distinctio eget occaecati. Arcu. Quos maxime sem ipsam proident feugiat dictumst bibendum! Feugiat veniam pariatur fuga.' ,
			'enable_homepage_services'  => 1,
			'service_headline1'         => __( 'Web Design & Development', 'genesisawesome' ),
			'service_desc1'             => 'Senectus lorem omnis rhoncus nostrum magni. Cumque! Proin blanditiis ligula sociis, condimentum, perspiciatis ac veniam aliquid corporis fames nesciunt facilis.',
			'service_headline2'         => __( 'WordPress & Genesis Expert', 'genesisawesome' ),
			'service_desc2'             => 'Senectus lorem omnis rhoncus nostrum magni. Cumque! Proin blanditiis ligula sociis, condimentum, perspiciatis ac veniam aliquid corporis fames nesciunt facilis.',
			'service_headline3'         => __( 'Search Engine Optimization', 'genesisawesome' ),
			'service_desc3'             => 'Senectus lorem omnis rhoncus nostrum magni. Cumque! Proin blanditiis ligula sociis, condimentum, perspiciatis ac veniam aliquid corporis fames nesciunt facilis.',
			'enable_homepage_portfolio' => 1,
			'portfolio_headline'        => __( 'My Work', 'genesisawesome' ),
			'portfolio_items_number'    => 6,
			'enable_homepage_blog'      => 1,
			'blog_headline'             => __( 'Blog', 'genesisawesome' ),
			'blog_items_number'         => 4,
			'enable_homepage_twitter'   => 1,
			'twitter_username'          => 'genesisawesum',
			'tweet_items_number'        => 10
		);

		$this->create( $page_id, $menu_ops, $page_ops, $settings_field, $default_settings );

		add_action( 'genesis_settings_sanitizer_init', array( $this, 'genesisawesome_childtheme_filters' ) );

	}

	/**
	 * Options Filters for Genesisawesome
	 * 
	 * @return null
	 */
	public function genesisawesome_childtheme_filters() {

		genesis_add_option_filter(
			'one_zero',
			$this->settings_field,
			array(
				'enable_custom_homepage',
				'enable_homepage_headlines',
				'enable_homepage_services',
				'enable_homepage_portfolio',
				'enable_homepage_blog',
				'enable_homepage_twitter'
			)
		);

		genesis_add_option_filter(
			'no_html',
			$this->settings_field,
			array(
				'portfolio_headline',
				'blog_headline'
			)
		);

		genesis_add_option_filter(
			'requires_unfiltered_html',
			$this->settings_field,
			array(
				'headline_1',
				'headline_2',
				'headline_desc',
				'service_headline1',
				'service_desc1',
				'service_headline2',
				'service_desc2',
				'service_headline3',
				'service_desc3',
			)
		);

		genesis_add_option_filter(
			'integer',
			$this->settings_field,
			array(
				'portfolio_items_number',
				'blog_items_number',
				'tweet_items_number'
			)
		);

	}

	/**
	 * Register Metaboxes
	 * 
	 * Registers the metaboxes for homepage settings
	 * 
	 * @return null
	 */
	function metaboxes() {

		add_meta_box( 'genesisawesome-home-general-settings', __( 'General Settings', 'genesisawesome' ), array( $this, 'general_settings' ), $this->pagehook, 'main', 'high' );
		add_meta_box( 'genesisawesome-home-headline-settings', __( 'Headlines Settings', 'genesisawesome' ), array( $this, 'headline_settings' ), $this->pagehook, 'main', 'high' );
		add_meta_box( 'genesisawesome-home-services-settings', __( 'Services Settings', 'genesisawesome' ), array( $this, 'services_settings' ), $this->pagehook, 'main', 'high' );
		add_meta_box( 'genesisawesome-home-portfolio-settings', __( 'Portfolio Settings', 'genesisawesome' ), array( $this, 'portfolio_settings' ), $this->pagehook, 'main', 'high' );
		add_meta_box( 'genesisawesome-home-blog-settings', __( 'Blog Settings', 'genesisawesome' ), array( $this, 'blog_settings' ), $this->pagehook, 'main', 'high' );
		add_meta_box( 'genesisawesome-home-twitter-settings', __( 'Twitter Settings', 'genesisawesome' ), array( $this, 'twitter_settings' ), $this->pagehook, 'main', 'high' );

	}

	/**
	 * General Settings Box
	 * 
	 * @return null 
	 */
	function general_settings() {

		?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->get_field_id( 'enable_custom_homepage' ); ?>"><?php _e( 'Enable Custom Home Page ?', 'genesisawesome' ); ?></label></th>
				<td><input type="checkbox" name="<?php echo $this->get_field_name( 'enable_custom_homepage' ); ?>" id="<?php echo $this->get_field_id( 'enable_custom_homepage' ); ?>" value="1"<?php checked( '1', $this->get_field_value( 'enable_custom_homepage' ) ); ?> /></td>
			</tr>
		</table>
		<?php

	}

	/**
	 * Homepage Headlines Settings
	 * 
	 * @return null
	 */
	function headline_settings() {

		?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->get_field_id( 'enable_homepage_headlines' ); ?>"><?php _e( 'Enable Homepage Top Headlines ?', 'genesisawesome' ); ?></label></th>
				<td><input type="checkbox" name="<?php echo $this->get_field_name( 'enable_homepage_headlines' ); ?>" id="<?php echo $this->get_field_id( 'enable_homepage_headlines' ); ?>" value="1"<?php checked( '1', $this->get_field_value( 'enable_homepage_headlines' ) ); ?> /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->get_field_id( 'headline_1' ); ?>"><?php _e( 'Headline #1', 'genesisawesome' ); ?></label></th>
				<td><textarea name="<?php echo $this->get_field_name( 'headline_1' ); ?>" id="<?php echo $this->get_field_id( 'headline_1' ); ?>"  class="widefat" rows="4"><?php echo esc_attr( $this->get_field_value( 'headline_1' ) ); ?></textarea></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->get_field_id( 'headline_2' ); ?>"><?php _e( 'Headline #2', 'genesisawesome' ); ?></label></th>
				<td><textarea name="<?php echo $this->get_field_name( 'headline_2' ); ?>" id="<?php echo $this->get_field_id( 'headline_2' ); ?>"  class="widefat" rows="4"><?php echo esc_attr( $this->get_field_value( 'headline_2' ) ); ?></textarea></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->get_field_id( 'headline_desc' ); ?>"><?php _e( 'Headline description', 'genesisawesome' ); ?></label></th>
				<td><textarea name="<?php echo $this->get_field_name( 'headline_desc' ); ?>" id="<?php echo $this->get_field_id( 'headline_desc' ); ?>"  class="widefat" rows="4"><?php echo esc_attr( $this->get_field_value( 'headline_desc' ) ); ?></textarea></td>
			</tr>
		</table>
		<?php

	}

	/**
	 * Homepage Services Settings
	 * 
	 * @return null
	 */
	function services_settings() {

		?>
		<table class="form-table">

			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->get_field_id( 'enable_homepage_services' ); ?>"><?php _e( 'Enable Homepage Service Boxes ?', 'genesisawesome' ); ?></label></th>
				<td><input type="checkbox" name="<?php echo $this->get_field_name( 'enable_homepage_services' ); ?>" id="<?php echo $this->get_field_id( 'enable_homepage_services' ); ?>" value="1"<?php checked( '1', $this->get_field_value( 'enable_homepage_services' ) ); ?> /></td>
			</tr>

			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->get_field_id( 'service_headline1' ); ?>"><?php _e( 'Service Headline #1', 'genesisawesome' ); ?></label></th>
				<td><textarea name="<?php echo $this->get_field_name( 'service_headline1' ); ?>" id="<?php echo $this->get_field_id( 'service_headline1' ); ?>"  class="widefat" rows="4"><?php echo esc_attr( $this->get_field_value( 'service_headline1' ) ); ?></textarea></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->get_field_id( 'service_desc1' ); ?>"><?php _e( 'Service description #1', 'genesisawesome' ); ?></label></th>
				<td><textarea name="<?php echo $this->get_field_name( 'service_desc1' ); ?>" id="<?php echo $this->get_field_id( 'service_desc1' ); ?>"  class="widefat" rows="4"><?php echo esc_attr( $this->get_field_value( 'service_desc1' ) ); ?></textarea></td>
			</tr>

			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->get_field_id( 'service_headline2' ); ?>"><?php _e( 'Service Headline #2', 'genesisawesome' ); ?></label></th>
				<td><textarea name="<?php echo $this->get_field_name( 'service_headline2' ); ?>" id="<?php echo $this->get_field_id( 'service_headline2' ); ?>"  class="widefat" rows="4"><?php echo esc_attr( $this->get_field_value( 'service_headline2' ) ); ?></textarea></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->get_field_id( 'service_desc2' ); ?>"><?php _e( 'Service description #2', 'genesisawesome' ); ?></label></th>
				<td><textarea name="<?php echo $this->get_field_name( 'service_desc2' ); ?>" id="<?php echo $this->get_field_id( 'service_desc2' ); ?>"  class="widefat" rows="4"><?php echo esc_attr( $this->get_field_value( 'service_desc2' ) ); ?></textarea></td>
			</tr>

			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->get_field_id( 'service_headline3' ); ?>"><?php _e( 'Service Headline #3', 'genesisawesome' ); ?></label></th>
				<td><textarea name="<?php echo $this->get_field_name( 'service_headline3' ); ?>" id="<?php echo $this->get_field_id( 'service_headline3' ); ?>"  class="widefat" rows="4"><?php echo esc_attr( $this->get_field_value( 'service_headline3' ) ); ?></textarea></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->get_field_id( 'service_desc3' ); ?>"><?php _e( 'Service description #3', 'genesisawesome' ); ?></label></th>
				<td><textarea name="<?php echo $this->get_field_name( 'service_desc3' ); ?>" id="<?php echo $this->get_field_id( 'service_desc3' ); ?>"  class="widefat" rows="4"><?php echo esc_attr( $this->get_field_value( 'service_desc3' ) ); ?></textarea></td>
			</tr>

		</table>
		<?php

	}

	/**
	 * Homepage Portfolio settings
	 * 
	 * @return null
	 */
	function portfolio_settings() {

		?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->get_field_id( 'enable_homepage_portfolio' ); ?>"><?php _e( 'Enable Homepage Portfolio ?', 'genesisawesome' ); ?></label></th>
				<td><input type="checkbox" name="<?php echo $this->get_field_name( 'enable_homepage_portfolio' ); ?>" id="<?php echo $this->get_field_id( 'enable_homepage_portfolio' ); ?>" value="1"<?php checked( '1', $this->get_field_value( 'enable_homepage_portfolio' ) ); ?> /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->get_field_id( 'portfolio_headline' ); ?>"><?php _e( 'Portfolio Headline', 'genesisawesome' ) ?></label></th>
				<td><input type="text" name="<?php echo $this->get_field_name( 'portfolio_headline' ); ?>" id="<?php echo $this->get_field_id( 'portfolio_headline' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'portfolio_headline' ) ); ?>" class="widefat" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->get_field_id( 'portfolio_items_number' ); ?>"><?php _e( 'Number of Portfolio Items to show', 'genesisawesome' ) ?></label></th>
				<td><input type="text" name="<?php echo $this->get_field_name( 'portfolio_items_number' ); ?>" id="<?php echo $this->get_field_id( 'portfolio_items_number' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'portfolio_items_number' ) ); ?>" size="4" /></td>
			</tr>
		</table>
		<?php

	}

	/**
	 * Homepage Blog Settings
	 * 
	 * @return null
	 */
	function blog_settings() {

		?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->get_field_id( 'enable_homepage_blog' ); ?>"><?php _e( 'Enable Homepage Blog ?', 'genesisawesome' ); ?></label></th>
				<td><input type="checkbox" name="<?php echo $this->get_field_name( 'enable_homepage_blog' ); ?>" id="<?php echo $this->get_field_id( 'enable_homepage_blog' ); ?>" value="1"<?php checked( '1', $this->get_field_value( 'enable_homepage_blog' ) ); ?> /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->get_field_id( 'blog_headline' ); ?>"><?php _e( 'Blog Headline', 'genesisawesome' ) ?></label></th>
				<td><input type="text" name="<?php echo $this->get_field_name( 'blog_headline' ); ?>" id="<?php echo $this->get_field_id( 'blog_headline' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'blog_headline' ) ); ?>" class="widefat" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->get_field_id( 'blog_items_number' ); ?>"><?php _e( 'Number of Blog Items to show', 'genesisawesome' ) ?></label></th>
				<td><input type="text" name="<?php echo $this->get_field_name( 'blog_items_number' ); ?>" id="<?php echo $this->get_field_id( 'blog_items_number' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'blog_items_number' ) ); ?>" size="4" /></td>
			</tr>
		</table>
		<?php

	}

	/**
	 * Homepage Twitter Settings
	 * 
	 * @return null
	 */
	function twitter_settings() {

		?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->get_field_id( 'enable_homepage_twitter' ); ?>"><?php _e( 'Enable Homepage Twitter updates ?', 'genesisawesome' ); ?></label></th>
				<td><input type="checkbox" name="<?php echo $this->get_field_name( 'enable_homepage_twitter' ); ?>" id="<?php echo $this->get_field_id( 'enable_homepage_twitter' ); ?>" value="1"<?php checked( '1', $this->get_field_value( 'enable_homepage_twitter' ) ); ?> /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->get_field_id( 'twitter_username' ); ?>"><?php _e( 'Twitter handle', 'genesisawesome' ) ?></label></th>
				<td><input type="text" name="<?php echo $this->get_field_name( 'twitter_username' ); ?>" id="<?php echo $this->get_field_id( 'twitter_username' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'twitter_username' ) ); ?>" class="widefat" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->get_field_id( 'tweet_items_number' ); ?>"><?php _e( 'Number of Tweet Items to show', 'genesisawesome' ) ?></label></th>
				<td><input type="text" name="<?php echo $this->get_field_name( 'tweet_items_number' ); ?>" id="<?php echo $this->get_field_id( 'tweet_items_number' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'tweet_items_number' ) ); ?>" size="4" /></td>
			</tr>
		</table>
		<?php

	}

}