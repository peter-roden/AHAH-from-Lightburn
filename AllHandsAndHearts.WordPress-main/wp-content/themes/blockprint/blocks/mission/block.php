<?php
/**
 * Mission Block
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

$overline = get_field('overline');
$heading = get_field('heading');
$content_overline = get_field('content_overline');
$content = get_field('content');

?>

<div id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '' ?>>
    <div class="@container container-wide py-20 @2xl:py-30">
        <div class="flex flex-col gap-16 @2xl:gap-24">
            <div>
                <?php if ($overline) : ?>
                    <p class="text-overline mb-4"><?php echo $overline; ?></p>
                <?php endif; ?>
                <?php if ($heading): ?>
                    <h2 class="text-display-2 text-balance text-primary"><?php echo $heading; ?></h2>
                <?php endif; ?>
            </div>
            <div class="max-w-[796px] ml-10 @2xl:ml-auto">
                <?php if ($content_overline): ?>
                    <p class="text-overline mb-4"><?php echo $content_overline; ?></p>
                <?php endif; ?>
                <?php if ($content): ?>
                    <div class="text-lg text-secondary">
                        <?php echo $content; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>