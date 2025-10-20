<?php

/**
 * Builds a list of CSS class names based on block settings and styles.
 *
 * @param string $input_class_name Initial class name(s) passed into the block.
 * @param array $block Block settings from the WordPress block editor.
 *
 * @return string Compiled list of class names.
 */

function build_block_class_name( $input_class_name, $block ) {
    // Start with the initial class name(s).
    $class_name = $input_class_name;

    // Add custom className if defined in block settings.
    if ( !empty( $block['className'] ) ) {
        $class_name .= ' ' . $block['className'];
    }

    // Add alignment class if specified (e.g., alignwide, alignfull).
    if ( !empty( $block['align'] ) ) {
        $class_name .= ' align' . $block['align'];
    }

    // Add background color utility classes (preset background).
    if ( !empty( $block['backgroundColor'] ) ) {
        $class_name .= ' has-background has-' . $block['backgroundColor'] . '-background-color';
    }

    // Add generic has-background class if a custom background color is used.
    if ( !empty( $block['style']['color']['background'] ) ) {
        $class_name .= ' has-background';
    }

    // Add text color utility classes (preset text color).
    if ( !empty( $block['textColor'] ) ) {
        $class_name .= ' has-text-color has-' . $block['textColor'] . '-color';
    }

    // Add generic has-text-color class if a custom text color is used.
    if ( !empty( $block['style']['color']['text'] ) ) {
        $class_name .= ' has-text-color';
    }

    // Add text alignment.
    if ( !empty($block['alignText']) ) {
        $class_name .= ' has-text-align-' . $block['alignText'];
    }

    // Return the final class string, trimmed of any leading/trailing whitespace.
    return trim( $class_name );
}