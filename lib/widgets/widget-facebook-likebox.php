<?php
/**
 * Facebook like box widget for GenesisAwesome
 * 
 * @package    Genesis Child Theme
 * @subpackage Widgets
 * @author     Harish Dasari
 * @version    1.0
 * @link       http://wwww.genesisawesome.com/
 */

/**
 * Facebook Likebox widget for GenesisAwesome.com
 */
class GA_Facebook_Likebox_Widget extends WP_Widget {

	/**
	 * Constructor
	 */
	function __construct() {
		$widget_ops = array( 'classname' => 'ga-facebook-likebox', 'description' => __( 'Displays Facebook Page Likebox', 'genesisawesome' ) );
		$this->WP_Widget( 'ga-facebook-likebox', __( 'GenesisAwesome : Facebook Likebox', 'genesisawesome' ), $widget_ops );
	}

	/**
	 * Display Widget on Front End.
	 * 
	 * @param  array $args     widget args
	 * @param  array $instance widget settings
	 * @return null
	 */
	function widget( $args, $instance ) {

		extract( $args );

		echo $before_widget;

		if ( ! empty( $instance['title'] ) )
			echo $before_title . apply_filters( 'widget_title', $instance['title'], $args, $instance ) . $after_title ;

		$likebox = sprintf( 
			'<iframe src="//www.facebook.com/plugins/likebox.php?href=%s&amp;width=%s&amp;height=%s&amp;show_faces=%s&amp;colorscheme=%s&amp;stream=%s&amp;border_color=%s&amp;header=%s" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:%spx; height:%spx;" allowTransparency="true"></iframe>',
			urlencode( $instance['pageurl'] ),
			urlencode( $instance['width'] ),
			urlencode( $instance['height'] ),
			urlencode( $instance['showfaces'] ),
			urlencode( $instance['colorscheme'] ),
			urlencode( $instance['showstream'] ),
			urlencode( $instance['bordercolor'] ),
			urlencode( $instance['showheader'] ),
			absint( $instance['width'] ),
			absint( $instance['height'] )
		);
		
		echo '<div class="widgetbody ga-widgetbody">' . $likebox . '</div>';

		echo $after_widget;

	}

	/**
	 * Update settings upon save.
	 * 
	 * @param  array $new_instance Submitted Settings
	 * @param  array $old_instance Old Settings
	 * @return array               New Settings
	 */
	function update( $new_instance, $old_instance ) {

		$instance                = $old_instance;
		$instance['title']       = wp_strip_all_tags( $new_instance['title'] );
		$instance['pageurl']     = esc_url_raw( $new_instance['pageurl'] );
		$instance['width']       = absint( $new_instance['width'] );
		$instance['height']      = absint( $new_instance['height'] );
		$instance['colorscheme'] = $new_instance['colorscheme'] == 'light' ? 'light' : 'dark' ;
		$instance['showfaces']   = $new_instance['showfaces'] == 'true' ? 'true' : 'false' ;
		$instance['showstream']  = $new_instance['showstream'] == 'true' ? 'true' : 'false' ;
		$instance['showheader']  = $new_instance['showheader'] == 'true' ? 'true' : 'false' ;
		$instance['bordercolor'] = preg_match( '/^\#[a-fA-f0-9]{3,6}/', $new_instance['bordercolor'] ) ? $new_instance['bordercolor'] : '' ;

		return $instance;
	}

	/**
	 * Displays Widget fron on backend.
	 * 
	 * @param  array $instance Saved Settings
	 * @return null
	 */
	function form( $instance ) {

		$defaults = array(
			'title'       => __( 'Like us on Facebook', 'genesisawesome' ),
			'pageurl'     => 'http://facebook.com/genesisawesome',
			'width'       => 240,
			'height'      => 240,
			'colorscheme' => 'light',
			'showfaces'   => 'true',
			'showstream'  => 'false',
			'showheader'  => 'false',
			'bordercolor' => '',
		);
		
		extract( wp_parse_args( $instance, $defaults ) );

		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ) ?>"><?php esc_html_e( 'Title', 'genesisawesome' ); ?></label>
			<input type="text" class="widefat" name="<?php echo $this->get_field_name( 'title' ) ?>" id="<?php echo $this->get_field_id( 'title' ) ?>" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'pageurl' ) ?>"><?php esc_html_e( 'Facebook Page URL', 'genesisawesome' ); ?></label>
			<input type="text" class="widefat" name="<?php echo $this->get_field_name( 'pageurl' ) ?>" id="<?php echo $this->get_field_id( 'pageurl' ) ?>" value="<?php echo esc_attr( $pageurl ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'width' ) ?>"><?php esc_html_e( 'Width', 'genesisawesome' ); ?></label>
			<input type="text" class="widefat" name="<?php echo $this->get_field_name( 'width' ) ?>" id="<?php echo $this->get_field_id( 'width' ) ?>" value="<?php echo esc_attr( $width ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'height' ) ?>"><?php esc_html_e( 'Height', 'genesisawesome' ); ?></label>
			<input type="text" class="widefat" name="<?php echo $this->get_field_name( 'height' ) ?>" id="<?php echo $this->get_field_id( 'height' ) ?>" value="<?php echo esc_attr( $height ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'colorscheme' ) ?>"><?php esc_html_e( 'Color Scheme', 'genesisawesome' ); ?></label>
			<select class="widefat" name="<?php echo $this->get_field_name( 'colorscheme' ) ?>" id="<?php echo $this->get_field_id( 'colorscheme' ) ?>">
				<option value="light"<?php selected( 'light', $colorscheme ); ?>><?php esc_html_e( 'Light', 'genesisawesome' ) ?></option>
				<option value="dark"<?php selected( 'dark', $colorscheme ); ?>><?php esc_html_e( 'Dark', 'genesisawesome' ) ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'bordercolor' ) ?>"><?php esc_html_e( 'Border Color', 'genesisawesome' ); ?></label>
			<input type="text" class="widefat" name="<?php echo $this->get_field_name( 'bordercolor' ) ?>" id="<?php echo $this->get_field_id( 'bordercolor' ) ?>" value="<?php echo esc_attr( $bordercolor ); ?>" />
		</p>
		<p>
			<input type="checkbox" name="<?php echo $this->get_field_name( 'showfaces' ) ?>" id="<?php echo $this->get_field_id( 'showfaces' ) ?>" value="true"<?php checked( 'true', $showfaces ); ?>/>
			<label for="<?php echo $this->get_field_id( 'showfaces' ) ?>"><?php esc_html_e( 'Show Faces', 'genesisawesome' ); ?></label>
		</p>
		<p>
			<input type="checkbox" name="<?php echo $this->get_field_name( 'showstream' ) ?>" id="<?php echo $this->get_field_id( 'showstream' ) ?>" value="true"<?php checked( 'true', $showstream ); ?>/>
			<label for="<?php echo $this->get_field_id( 'showstream' ) ?>"><?php esc_html_e( 'Show Stream', 'genesisawesome' ); ?></label>
		</p>
		<p>
			<input type="checkbox" name="<?php echo $this->get_field_name( 'showheader' ) ?>" id="<?php echo $this->get_field_id( 'showheader' ) ?>" value="true"<?php checked( 'true', $showheader ); ?>/>
			<label for="<?php echo $this->get_field_id( 'showheader' ) ?>"><?php esc_html_e( 'Show Header', 'genesisawesome' ); ?></label>
		</p>

		<?php

	}

}