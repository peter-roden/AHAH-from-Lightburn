<?php
/**
 * Add head/body scripts.
 *
 * @package Blockprint
 */

function blockprint_head_scripts() {
    if ( function_exists('get_field') && get_field('head_body_scripts', 'option') ) {
        echo get_field('head_body_scripts_head_scripts', 'option');
    }
}
add_action( 'wp_head', 'blockprint_head_scripts' );

function blockprint_body_open_scripts() {
    if ( function_exists('get_field') && get_field('head_body_scripts', 'option') ) {
        echo get_field('head_body_scripts_body_open_scripts', 'option');
    }
}
add_action( 'wp_body_open', 'blockprint_body_open_scripts' );

function blockprint_footer_scripts() {
    if ( function_exists('get_field') && get_field('head_body_scripts', 'option') ) {
        echo get_field('head_body_scripts_footer_scripts', 'option');
    }
    echo "<script>var wpApiSettings={root:'" . esc_url_raw( rest_url() ) . "',nonce:'". wp_create_nonce( 'wp_rest' ) ."'};var userId=" . get_current_user_id() . ";</script>\n";
}
add_action( 'wp_footer', 'blockprint_footer_scripts' );