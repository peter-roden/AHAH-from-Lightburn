<?php
/**
 * Spacer Block
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or its parent block.
 */

$anchor = $block['id'];
if ( !empty($block['anchor']) ) {
    $anchor = $block['anchor'];
}

$class_name = build_block_class_name( 'mt-0 [&+*]:mt-0 h-(--spacer-height)', $block );

$style = build_block_styles( $block );

$height = get_field('height');
$height_md = get_field('height_md');
$height_lg = get_field('height_lg');
$height_xl = get_field('height_xl');

$style = "--spacer-height:calc(var(--spacing) * {$height});";

if ($height_md) {
    $class_name .= ' md:h-(--spacer-height-md)';
    $style .= "--spacer-height-md:calc(var(--spacing) * {$height_md});";
}

if ($height_lg) {
    $class_name .= ' lg:h-(--spacer-height-lg)';
    $style .= "--spacer-height-lg:calc(var(--spacing) * {$height_lg});";
}

if ($height_xl) {
    $class_name .= ' xl:h-(--spacer-height-xl)';
    $style .= "--spacer-height-xl:calc(var(--spacing) * {$height_xl});";
}
?>

<div class="<?php echo trim( esc_attr( $class_name ) ) ?>" style="<?php echo esc_attr($style) ?>" aria-hidden="true"></div>