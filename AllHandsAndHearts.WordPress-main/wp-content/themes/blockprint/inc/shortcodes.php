<?php
/**
 * Custom shortcodes.
 * 
 * @link https://developer.wordpress.org/reference/functions/add_shortcode/
 *
 * @package Blockprint
 */

// Results Label
function results_label_shortcode() {
    global $wp_query;
    $count = $wp_query->found_posts;
    return $count . ' Result' . ($count == 1 ? '' : 's');
}
add_shortcode('results_label', 'results_label_shortcode');