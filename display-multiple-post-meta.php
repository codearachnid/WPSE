<?php

/**
 * Display custom meta group of fields for a custom post type
 * 
 * @link http://wordpress.stackexchange.com/a/140906/28798
 * @author codearachnid
 * @example
 
 // get the meta group for the current post (for a specific post 
 // just supply the $post_id as the second argument)
 $field_group = array(
    'property_name' => 'Property Name',
    'property_address' => 'Property Address',
    'property_value' => 'Property Value'
    );
 wpse_157410_custom_meta_box( $field_group );
 
 */
 
wpse_157410_custom_meta_box( $display_fields = array(), $ID = null, $echo = true ) {

    // if provided $ID is null fetch the current post
    $ID = is_null( $ID ) ? get_the_ID() : $ID;
    $output = '';
    $row_template = apply_filters( 'wpse_157410_custom_meta_box/row_template', '<div><label>%s</label><span>%</span></div>' );
    $values_delimiter = apply_filter( 'wpse_157410_custom_meta_box/values_delimiter', ',' ):
    $custom_post_meta = get_post_custom( $ID );
    
    foreach( $custom_post_meta as $key => $values ){
    
        $title = '';
        if( array_key_exists( $key, $display_fields ) || empty( $display_fields ) ){
            $title = empty( $display_fields ) ? $key : $display_fields[ $key ];
        }
        
        // skip to the next record if we can't display a title
        if( empty( $title ) )
            continue;
        
        $value = implode( $values_delimiter, $values );
        $output .= apply_filters( 'wpse_157410_custom_meta_box/row_template', 
            sprintf( $row_template, $title, $value ), 
            $values, 
            $key, 
            $ID,
            $custom_post_meta, 
            $display_fields
            );
    }
    
    output = apply_filter( 'wpse_157410_custom_meta_box/output', $output, $custom_post_meta, $ID, $display_fields, $echo ):
    
    if( $echo ) {
        echo $output;
    } else {
        return $output;
    }
}
