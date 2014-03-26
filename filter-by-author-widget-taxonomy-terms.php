<?php

/**
 * Filter widgets in sidebar to filter taxonomy terms by author when on the author template
 *
 * @link http://wordpress.stackexchange.com/questions/138097/author-template-filter-sidebar-widgets-by-author
 * @author codearachnid
 */


add_filter( 'widget_tag_cloud_args', 'wpse_138097_filter_categories_by_author' );
add_filter( 'widget_categories_dropdown_args', 'wpse_138097_filter_categories_by_author' );
add_filter( 'widget_categories_args', 'wpse_138097_filter_categories_by_author' );

function wpse_138097_filter_categories_by_author( $args ){
	// only process if on the author template
	if( is_author() ){
		// get the author ID from the template
		$author_id = get_the_author_meta( 'ID' );
		// define taxonomy by the supplied widget or assumed default
		$taxonomy = !empty( $args['taxonomy'] ) ? $args['taxonomy'] : 'category';
		// filter by including only IDs associated to the author
		$args['include'] = wpse_138097_get_term_ids_by_author( $author_id, $taxonomy );
	}
	return $args;
}

function wpse_138097_get_term_ids_by_author( $user_id, $taxonomy = 'category' ){
	global $wpdb;
	return $wpdb->get_col( $wpdb->prepare( "
		SELECT DISTINCT(terms.term_id) as ID
		FROM $wpdb->posts as posts
		LEFT JOIN $wpdb->term_relationships as relationships ON posts.ID = relationships.object_ID
		LEFT JOIN $wpdb->term_taxonomy as tax ON relationships.term_taxonomy_id = tax.term_taxonomy_id
		LEFT JOIN $wpdb->terms as terms ON tax.term_id = terms.term_id
		WHERE 1=1 AND (
			posts.post_status = 'publish' AND
			posts.post_author = %d AND
			tax.taxonomy = '%s' )
		ORDER BY terms.name ASC
	", $user_id, $taxonomy ) );
}
