<?php

/**
 * insert meta boxes before main editor below title
 */

// hook meta boxes after title
add_action( 'edit_form_after_title', 'wpse_140900_add_meta_boxes_after_title', 10, 1 );

function wpse_140900_add_meta_boxes_after_title( $post ){
	global $wp_meta_boxes;

	// you could create your own context and load meta boxes in context
	// in this case we are moving the side rail meta boxes below 
	// the title and above the content editor
	do_meta_boxes( get_current_screen(), 'side', $post );
	unset( $wp_meta_boxes['post']['side'] );
}
