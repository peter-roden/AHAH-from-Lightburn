<?php
/**
 * Add block categories.
 *
 * @package Blockprint
 */

function blockprint_block_categories( $categories ) {
    $categories = array_merge(
        $categories, [
            [
                'slug'  => 'blockprint',
                'title' => 'Blockprint'
            ]
        ]
    );

    return $categories;
}
add_filter( 'block_categories', 'blockprint_block_categories' );