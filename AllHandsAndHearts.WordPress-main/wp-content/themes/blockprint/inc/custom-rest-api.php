<?php
/** 
 * Register custom REST API fields/endpoints.
 * 
 * @link https://developer.wordpress.org/reference/functions/register_rest_field/
 *
 * @package Blockprint
 */

function get_category_names( $object, $field_name, $request ) {
    return array_map('get_cat_name', $object['categories']);
}

function get_author_display_name( $object, $field_name, $request ) {
    return get_the_author_meta('display_name', $object['author']);
}

function get_featured_media_src( $object, $field_name, $request ) {
    $id = $object['featured_media'];
    $array = wp_get_attachment_image_src($id, 'medium_large');
    return $array[0] ?? '';
}

function add_to_rest_api() {
    register_rest_field( 'post', 'category_names', [
        'get_callback'    => 'get_category_names',
        'update_callback' => null,
        'schema'          => null,
    ] );

    register_rest_field( 'post', 'author_display_name', [
        'get_callback'    => 'get_author_display_name',
        'update_callback' => null,
        'schema'          => null,
    ] );

    register_rest_field( 'post', 'featured_media_src', [
        'get_callback'    => 'get_featured_media_src',
        'update_callback' => null,
        'schema'          => null,
    ] );
}
add_action( 'rest_api_init', 'add_to_rest_api' );