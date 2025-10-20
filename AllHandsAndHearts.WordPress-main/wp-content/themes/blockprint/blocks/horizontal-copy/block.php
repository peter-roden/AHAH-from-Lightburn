<?php
/**
 * Horizontal Copy Block
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

$class_name = build_block_class_name( '@container', $block );

$style = build_block_styles( $block );

$heading = get_field('heading');
$content = get_field('content');
?>

<div id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '' ?>>
    <div class="flex flex-col items-start justify-between gap-y-4 gap-x-16 py-27 @2xl:flex-row @4xl:gap-x-27 @4xl:py-36 @7xl:py-45.5">
        <div class="col-span-4 max-w-141">
            <h2 class="text-balance text-display-2">
                <?php echo $heading; ?>
            </h2>
        </div>
        <div class="col-span-8 text-lg @4xl:max-w-199">
            <?php echo $content; ?>
        </div>
    </div>
</div>