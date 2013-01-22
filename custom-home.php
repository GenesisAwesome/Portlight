<?php
/**
 * Portlight Custom Homepage
 * 
 * @since   1.0
 * @package Genesis Child Theme
 * @author  Harish Dasari
 * @link    http://www.genesisawesome.com/
 */

/* Make full width layout */
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

// Remove All Actions on Content. We need clean & empty content to work with..
remove_all_actions( 'genesis_before_loop' );
remove_all_actions( 'genesis_loop' );
remove_all_actions( 'genesis_after_loop' );

add_action( 'genesis_loop', 'genesisawesome_home_headlines' );
/**
 * Portlight Headlines
 * 
 * @return null
 */
function genesisawesome_home_headlines() {

	if ( ! genesis_get_option( 'enable_homepage_headlines', GA_HOMEPAGE_FIELD ) )
		return;

	$h1 = genesis_get_option( 'headline_1', GA_HOMEPAGE_FIELD );
	$h2 = genesis_get_option( 'headline_2', GA_HOMEPAGE_FIELD );
	$desc = genesis_get_option( 'headline_desc', GA_HOMEPAGE_FIELD );

	echo '<div class="ga-home-headlines">';
		if ( $h1 )
			echo '<h1 class="headline_1">' . $h1 . '</h1>';
		if ( $h2 )
			echo '<h2 class="headline_2">' . $h2 . '</h2>';
		if ( $desc )
			echo '<p class="headline_desc">' . $desc . '</p>';
	echo '</div>';

}

add_action( 'genesis_loop', 'genesisawesome_home_services' );
/**
 * Portlight Service boxes
 * 
 * @return null
 */
function genesisawesome_home_services() {

	if ( ! genesis_get_option( 'enable_homepage_services', GA_HOMEPAGE_FIELD ) )
		return;

	$headline1 = genesis_get_option( 'service_headline1', GA_HOMEPAGE_FIELD );
	$headline2 = genesis_get_option( 'service_headline2', GA_HOMEPAGE_FIELD );
	$headline3 = genesis_get_option( 'service_headline3', GA_HOMEPAGE_FIELD );

	$desc1 = genesis_get_option( 'service_desc1', GA_HOMEPAGE_FIELD );
	$desc2 = genesis_get_option( 'service_desc2', GA_HOMEPAGE_FIELD );
	$desc3 = genesis_get_option( 'service_desc3', GA_HOMEPAGE_FIELD );

	?>
	<div class="ga-home-services">
		<div class="service one-third first">
			<div class="service-icon service-icon1"></div>
			<h3 class="service-headline service-headline1"><?php echo $headline1 ?></h3>
			<div class="service-desc service-desc1"><?php echo $desc1 ?></div>
		</div>
		<div class="service one-third">
			<div class="service-icon service-icon2"></div>
			<h3 class="service-headline service-headline2"><?php echo $headline2 ?></h3>
			<div class="service-desc service-desc2"><?php echo $desc2 ?></div>
		</div>
		<div class="service one-third">
			<div class="service-icon service-icon3"></div>
			<h3 class="service-headline service-headline3"><?php echo $headline3 ?></h3>
			<div class="service-desc service-desc3"><?php echo $desc3 ?></div>
		</div>
	</div>
	<?php

}

add_action( 'genesis_loop', 'genesisawesome_home_portfolio' );
/**
 * Portlight Portfolio
 * 
 * @return null 
 */
function genesisawesome_home_portfolio() {

	if ( ! genesis_get_option( 'enable_homepage_portfolio', GA_HOMEPAGE_FIELD ) )
		return;

	$headline = genesis_get_option( 'portfolio_headline', GA_HOMEPAGE_FIELD );
	$items_number = genesis_get_option( 'portfolio_items_number', GA_HOMEPAGE_FIELD );

	?>
	<div class="ga-home-portfolio">
		<?php echo '<h4>' . $headline . '</h4><div class="clear"></div>'; genesisawesome_portfolio_loop( absint( $items_number ) ); ?>	
	</div>
	<?php

}

add_action( 'genesis_loop', 'genesisawesome_home_blog' );
/**
 * Portlight Home Blog loop
 * 
 * @return null
 */
function genesisawesome_home_blog() {

	if ( ! genesis_get_option( 'enable_homepage_blog', GA_HOMEPAGE_FIELD ) )
		return;

	$headline = genesis_get_option( 'blog_headline', GA_HOMEPAGE_FIELD );
	$items_number = genesis_get_option( 'blog_items_number', GA_HOMEPAGE_FIELD );
	
	$include = genesis_get_option( 'blog_cat' );
	$exclude = genesis_get_option( 'blog_cat_exclude' ) ? explode( ',', str_replace( ' ', '', genesis_get_option( 'blog_cat_exclude' ) ) ) : '';

	$query_args = array(
		'cat'              => $include,
		'category__not_in' => $exclude,
		'showposts'        => absint( $items_number ),
	);

	$homeblog = new WP_Query( $query_args );

	if ( $homeblog->have_posts() ) {
		
		echo '<div class="ga-home-blog">';
		echo '<h4>' . $headline . '</h4><div class="clear"></div>';
		$count = 0;
		while ( $homeblog->have_posts() ) {
			$homeblog->the_post();
			?>
			<div class="post entry hentry one-half<?php if( $count%2 == 0 ) echo ' first'; ?>">
				<?php the_post_thumbnail( array( 100, 100 ), array( 'class' => 'alignleft' ) ); genesis_do_post_title(); genesis_post_info(); ?>
			</div>
			<?php
			$count++;
		}

		echo '<div class="clear"></div></div>';

	}

}

add_action( 'genesis_loop', 'genesisawesome_home_twitter' );
/**
 * Portlight Twitter updates
 * 
 * @return null
 */
function genesisawesome_home_twitter() {

	if ( ! genesis_get_option( 'enable_homepage_twitter', GA_HOMEPAGE_FIELD ) )
		return;

	$username = genesis_get_option( 'twitter_username', GA_HOMEPAGE_FIELD );
	$items_number = genesis_get_option( 'tweet_items_number', GA_HOMEPAGE_FIELD );

	echo '<div class="ga-home-twitter">';

		$tweets = get_transient( 'ga-homepage-tweets' );

		if ( $tweets )
			echo $tweets;
		else {

			$tweets_request = wp_remote_get( sprintf( 'http://api.twitter.com/1/statuses/user_timeline.json?screen_name=%s&count=%s&trim_user=1', $username, (absint( $items_number ) + 100) ) );
			if ( wp_remote_retrieve_response_code( $tweets_request ) == 200 ) {
				$tweets = json_decode( wp_remote_retrieve_body( $tweets_request ) );

				$tweets_html = '<ul>';
				$num_tweets = 0;
				foreach ( (array) $tweets as $tweet ) {

					if ( $tweet->in_reply_to_user_id )
						continue;

					if ( $num_tweets >= $items_number )
						break;

					$timeago = sprintf( __( 'about %s ago', 'genesis' ), human_time_diff( strtotime( $tweet->created_at ) ) );
					$timeago_link = sprintf( '<a href="%s" rel="nofollow">%s</a>', esc_url( sprintf( 'http://twitter.com/%s/status/%s', $username, $tweet->id_str ) ), esc_html( $timeago ) );
					$tweets_html .= '<li>' . genesis_tweet_linkify( $tweet->text ) . ' <span style="font-size: 85%;">' . $timeago_link . '</span></li>' . "\n";
					$num_tweets++;

				}
				
				$tweets_html .= '</ul>';
				$tweets_html .= sprintf( '<a class="twitter-button" href="http://twitter.com/%1$s">@%1$s</a>', $username );

				set_transient( 'ga-homepage-tweets', $tweets_html, 60*60*1 );
				update_option( 'ga-homepage-tweets', $tweets_html );

				echo $tweets_html;

			} else {

				if ( $tweets_html = get_option( 'ga-homepage-tweets', false ) )
					echo $tweets_html;

			}

		}
		
	echo '</div>';

}


genesis();