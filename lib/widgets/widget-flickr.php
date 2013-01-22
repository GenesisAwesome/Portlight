<?php
/**
 * Flickr widget for GenesisAwesome
 * 
 * @package    Genesis Child Theme
 * @subpackage Widgets
 * @author     Harish Dasari
 * @version    1.0
 * @link       http://wwww.genesisawesome.com/
 */

/**
 * Flickr Widget for GenesisAwesome.com
 */
class GA_Flickr_Widget extends WP_Widget {

	/**
	 * Constructor
	 */
	function __construct() {
		$widget_ops = array( 'classname' => 'ga-flickr', 'description' => __( 'Displays Flickr photos stream on sidebar', 'genesisawesome' ) );
		$this->WP_Widget( 'ga-flickr', __( 'GenesisAwesome : Flickr', 'genesisawesome' ), $widget_ops );
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

		$flickr = sprintf(
			'<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=%s&amp;display=%s&amp;&amp;layout=x&amp;source=%s&amp;%s=%s&amp;size=%s"></script>',
			urlencode( $instance['numberphotos'] ),
			urlencode( $instance['streamsorting'] ),
			urlencode( $instance['streamtype'] ),
			urlencode( $instance['streamtype'] ),
			urlencode( $instance['flickrid'] ),
			urlencode( $instance['photosize'] )
		);
		echo '<div class="widgetbody ga-widgetbody">' . $flickr . '</div>';

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

		$instance                  = $old_instance;
		$instance['title']         = wp_strip_all_tags( $new_instance['title'] );
		$instance['flickrid']      = wp_strip_all_tags( $new_instance['flickrid'] );
		$instance['numberphotos']  = absint( $new_instance['numberphotos'] );
		$instance['streamtype']    = $new_instance['streamtype'] == 'user' ? 'user' : 'group' ;
		$instance['streamsorting'] = $new_instance['streamsorting'] == 'latest' ? 'latest' : 'random' ;
		$instance['photosize']     = in_array( $new_instance['photosize'], array( 's', 'm', 'l' ) ) ? $new_instance['photosize'] : 's' ;

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
			'title'         => __( 'Flickr', 'genesisawesome' ),
			'flickrid'      => '',
			'numberphotos'  => '9',
			'streamtype'    => 'user',
			'streamsorting' => 'latest',
			'photosize'     => 's',
		);

		extract( wp_parse_args( $instance, $defaults ) );

		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ) ?>"><?php esc_html_e( 'Title', 'genesisawesome' ); ?></label>
			<input type="text" class="widefat" name="<?php echo $this->get_field_name( 'title' ) ?>" id="<?php echo $this->get_field_id( 'title' ) ?>" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'flickrid' ) ?>"><?php esc_html_e( 'Flickr ID', 'genesisawesome' ); ?> (<a href="http://www.idgettr.com" target="_blank">idGettr</a>)</label>
			<input type="text" class="widefat" name="<?php echo $this->get_field_name( 'flickrid' ) ?>" id="<?php echo $this->get_field_id( 'flickrid' ) ?>" value="<?php echo esc_attr( $flickrid ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'numberphotos' ) ?>"><?php esc_html_e( 'Number of Photos', 'genesisawesome' ); ?></label>
			<input type="text" class="widefat" name="<?php echo $this->get_field_name( 'numberphotos' ) ?>" id="<?php echo $this->get_field_id( 'numberphotos' ) ?>" value="<?php echo esc_attr( $numberphotos ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'streamtype' ) ?>"><?php esc_html_e( 'Type:', 'genesisawesome' ); ?></label>
			<select class="widefat" name="<?php echo $this->get_field_name( 'streamtype' ) ?>" id="<?php echo $this->get_field_id( 'streamtype' ) ?>">
				<option value="user"<?php selected( 'user', $streamtype ); ?>><?php esc_html_e( 'User', 'genesisawesome' ) ?></option>
				<option value="group"<?php selected( 'group', $streamtype ); ?>><?php esc_html_e( 'Group', 'genesisawesome' ) ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'streamsorting' ) ?>"><?php esc_html_e( 'Sorting:', 'genesisawesome' ); ?></label>
			<select class="widefat" name="<?php echo $this->get_field_name( 'streamsorting' ) ?>" id="<?php echo $this->get_field_id( 'streamsorting' ) ?>">
				<option value="latest"<?php selected( 'latest', $streamsorting ); ?>><?php esc_html_e( 'Latest', 'genesisawesome' ) ?></option>
				<option value="random"<?php selected( 'random', $streamsorting ); ?>><?php esc_html_e( 'Random', 'genesisawesome' ) ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'photosize' ) ?>"><?php esc_html_e( 'Size:', 'genesisawesome' ); ?></label>
			<select class="widefat" name="<?php echo $this->get_field_name( 'photosize' ) ?>" id="<?php echo $this->get_field_id( 'photosize' ) ?>">
				<option value="s"<?php selected( 's', $photosize ); ?>><?php esc_html_e( 'Small', 'genesisawesome' ) ?></option>
				<option value="l"<?php selected( 'l', $photosize ); ?>><?php esc_html_e( 'Medium', 'genesisawesome' ) ?></option>
				<option value="m"<?php selected( 'm', $photosize ); ?>><?php esc_html_e( 'Large', 'genesisawesome' ) ?></option>
			</select>
		</p>

		<?php

	}

}