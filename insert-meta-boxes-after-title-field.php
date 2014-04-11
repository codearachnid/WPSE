<?php

/**
 * insert meta boxes before main editor below title
 */

// hook meta boxes after title
add_action( 'edit_form_after_title', 'wpse_140900_add_meta_boxes_after_title' );

function wpse_140900_add_meta_boxes_after_title( $post ){
	global $wp_meta_boxes;

	// filter by post type (define your own post types to enable this method)
	if( ! in_array( $post->post_type, array('post') ) )
		return false;

	$current_screen = get_current_screen();
	$registered_taxonomy = '{custom_taxonomy}'; // set this to be the same id as your registered taxonomy

	// move meta box to after_title position
	$wp_meta_boxes[$current_screen->id]['after_title']['core'][ $registered_taxonomy . 'div'] = $wp_meta_boxes[$current_screen->id]['side']['core'][ $registered_taxonomy . 'div' ];

	// display registered meta boxes for after_title
	do_meta_boxes( get_current_screen(), 'after_title', $post );

	// remove meta box from displaying in the "default"
	unset( $wp_meta_boxes[$current_screen->id]['side']['core'][ $registered_taxonomy . 'div' ] );
}
