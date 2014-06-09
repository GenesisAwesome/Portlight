<?php
/**
 * Portfolio Single Template
 *
 * @since   1.0
 * @package Genesis Child Theme
 * @author  Harish Dasari
 * @link    http://www.genesisawesome.com/
 */

/* Make full width layout */
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

/* remove post info and meta */
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

remove_action( 'genesis_after_entry', 'genesis_do_author_box_single', 8 );
remove_action( 'genesis_after_entry', 'genesis_get_comments_template' );

add_action( 'genesis_entry_content', 'genesiawesome_portfolio_image', 5 );
/**
 * Add Post Featured image before content
 *
 * @return null
 */
function genesiawesome_portfolio_image() {

	echo '<div class="profolio-project-info">';

	$img = genesis_get_image( array(
		'format'  => 'html',
		'size'    => 'full',
		'context' => 'archive',
		'attr'    => genesis_parse_attr( 'entry-image' ),
	) );

	if ( ! empty( $img ) )
		printf( '<a href="%s" title="%s" class="project-image">%s</a>', get_permalink(), the_title_attribute( 'echo=0' ), $img );

	$project_meta = array(
		'project_title'  => get_post_meta( get_the_ID(), '_project_title', true ),
		'project_work'   => get_post_meta( get_the_ID(), '_project_work', true ),
		'project_url'    => get_post_meta( get_the_ID(), '_project_url', true ),
		'project_client' => get_post_meta( get_the_ID(), '_project_client', true ),
	);

	extract( $project_meta );

	?>
	<table class="project-meta">
		<?php if ( ! empty( $project_title ) ) : ?>
		<tr>
			<th><?php _e( 'Project Title', 'genesisawesome' );?></th>
			<td><?php echo esc_html( $project_title );?></td>
		</tr>
		<?php endif; ?>
		<?php if ( ! empty( $project_work ) ) : ?>
		<tr>
			<th><?php _e( 'Project Work', 'genesisawesome' );?></th>
			<td><?php echo esc_html( $project_work );?></td>
		</tr>
		<?php endif; ?>
		<?php if ( ! empty( $project_url ) ) : ?>
		<tr>
			<th><?php _e( 'Project URI', 'genesisawesome' );?></th>
			<td><a href="<?php echo esc_url( $project_url );?>"><?php echo esc_html( $project_url );?></a></td>
		</tr>
		<?php endif; ?>
		<?php if ( ! empty( $project_client ) ) : ?>
		<tr>
			<th><?php _e( 'Project Client', 'genesisawesome' );?></th>
			<td><?php echo esc_html( $project_client );?></td>
		</tr>
		<?php endif; ?>
	</table>
	<?php

	echo '</div>';
}


add_action( 'genesis_entry_content', 'genesisawesome_profolio_do_meta', 6 );
/**
 * Project Info
 *
 * @return null
 */
function genesisawesome_profolio_do_meta() {


}

genesis();