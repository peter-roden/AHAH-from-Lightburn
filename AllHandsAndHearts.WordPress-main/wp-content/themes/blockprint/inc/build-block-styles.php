<?php

/**
 * Builds an inline style string from block style settings.
 *
 * @param array $block Block settings from the WordPress block editor.
 *
 * @return string CSS style declarations to be used inline.
 */

function build_block_styles( $block ) {
    // Initialize the final style string.
    $output_style = '';

    // Helper function to convert block CSS variable notation to valid CSS syntax.
    $parse_css_value = function( $value ) {
        // Example input: var:preset|spacing|40
        // Output: var(--wp--preset--spacing--40)
        if ( str_starts_with( $value, 'var' ) ) {
            $value = str_replace( '|', '--', $value );             // Replace '|' with '--'
            $value = str_replace( ':', '(--wp--', $value ) . ')';   // Replace ':' with '(--wp--' and close with ')'
        }
        return $value;
    };

    // Handle margin styles (e.g., top, right, bottom, left).
    if ( !empty( $block['style']['spacing']['margin'] ) ) {
        foreach ( $block['style']['spacing']['margin'] as $side => $value ) {
            $output_style .= "margin-{$side}:" . $parse_css_value( $value ) . ';';
        }
    }

    // Handle padding styles (e.g., top, right, bottom, left).
    if ( !empty( $block['style']['spacing']['padding'] ) ) {
        foreach ( $block['style']['spacing']['padding'] as $side => $value ) {
            $output_style .= "padding-{$side}:" . $parse_css_value( $value ) . ';';
        }
    }

    // Handle block gap (used in layout grids or flex containers).
    if ( !empty( $block['style']['spacing']['blockGap'] ) ) {
        $gap = $parse_css_value( $block['style']['spacing']['blockGap'] );
        $output_style .= "gap:{$gap};";
    }

    // Handle background color (custom color value).
    if ( !empty( $block['style']['color']['background'] ) ) {
        $output_style .= 'background-color:' . $block['style']['color']['background'] . ';';
    }

    // Handle text color (custom color value).
    if ( !empty( $block['style']['color']['text'] ) ) {
        $output_style .= 'color:' . $block['style']['color']['text'] . ';';
    }

    // Return the compiled style string, trimming extra whitespace.
    return trim( $output_style );
}