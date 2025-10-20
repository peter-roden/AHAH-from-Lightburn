<?php
/**
 * Register block pattern categories.
 * 
 * @link https://developer.wordpress.org/reference/functions/register_block_pattern_category/
 *
 * @package Blockprint
 */

function blockprint_register_block_pattern_categories() {
	$block_pattern_categories = [
		'templates' => [ 'label' => 'Templates' ]
	];

	/**
	 * Filters the theme block pattern categories.
	 *
	 * @param array[] $block_pattern_categories {
	 *     An associative array of block pattern categories, keyed by category name.
	 *
	 *     @type array[] $properties {
	 *         An array of block category properties.
	 *
	 *         @type string $label A human-readable label for the pattern category.
	 *     }
	 * }
	 */
	$block_pattern_categories = apply_filters( 'blockprint_block_pattern_categories', $block_pattern_categories );

	foreach ( $block_pattern_categories as $name => $properties ) {
		if ( ! WP_Block_Pattern_Categories_Registry::get_instance()->is_registered( $name ) ) {
			register_block_pattern_category( $name, $properties );
		}
	}
}
add_action( 'init', 'blockprint_register_block_pattern_categories', 9 );
