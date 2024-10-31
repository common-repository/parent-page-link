<?php
/*
Plugin Name: Parent Page Link
Plugin URI: https://powie.de/wordpress/
Description: Adds a back link on subpages to the parent page
Author: Powie
Version: 0.9.0
Author URI: https://powie.de
Domain Path: /languages
Text Domain: ppl
*/
function ppl_content( $content ) {
	$post = get_post();
	if ( 'page' == $post->post_type && $post->post_parent > 0 ) {
		$parent = new WP_Query( array(
			'post_type' => 'page',
			'post__in' => array( $post->post_parent ),
		) );

		if ( $parent->have_posts() ) {
			$parent->the_post();
			$content .= sprintf( '<p><a href="%s">&larr; %s</a></p>', get_permalink(), get_the_title() );
		}
		wp_reset_postdata();
	}

	return $content;
}
add_filter( 'the_content', 'ppl_content' );