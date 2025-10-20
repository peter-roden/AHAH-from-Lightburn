<?php
/**
 * Overlapping Hero Block
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

$class_name = build_block_class_name( '', $block );

$style = build_block_styles( $block );

$template = [
    ['core/pattern', [
        'slug' => 'blockprint/hidden-hero-innerblocks'
    ]]
];

$size = get_field('size');
$bg_media_type = get_field('bg_media_type');
$bg_image = get_field('bg_image');
$bg_video = get_field('bg_video');
$content_bg_color = get_field('content_bg_color');

$container_class_name = '';
if ($size === 'small') {
    $container_class_name .= ' min-h-122 md:min-h-130';
} else if ($size === 'medium') {
    $container_class_name .= ' min-h-136 md:min-h-160';
} else if ($size === 'large') {
    $container_class_name .= ' min-h-[calc(100svh-var(--wp-admin--admin-bar--height,0px)-var(--header-height,0px))]';
}
?>

<div id="<?php echo esc_attr($anchor) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr($style) . '"' : '' ?>>
    <div class="<?php echo trim(esc_attr($container_class_name)) ?>">
        
    </div>
</div>