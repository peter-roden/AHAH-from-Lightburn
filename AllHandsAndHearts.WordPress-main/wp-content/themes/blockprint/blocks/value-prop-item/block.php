<?php
/**
 * Value Prop Item Block
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or its parent block.
 */

$class_name = build_block_class_name( 'flex gap-y-4 gap-x-6', $block );

$image = get_field('image');
$image_width = get_field('image_width');
$image_position = get_field('image_position');
$heading = get_field('heading');
$text = get_field('text');

$class_name .= $image_position === 'top' ? ' flex-col' : '';
?>

<div class="<?php echo trim( esc_attr( $class_name ) ) ?>">
    <?php if ($image) : ?>
        <div class="shrink-0">
            <?php echo wp_get_attachment_image( $image['id'], 'medium_large', false, [
                'loading' => 'lazy',
                'class' => 'inline-block',
                'style' => $image_width ? "width:{$image_width}px" : ''
            ] ); ?>
        </div>
    <?php endif ?>

    <div class="flex flex-col gap-y-4">        
        <?php if ($heading) : ?>
            <h3 class="text-xl font-bold mb-0">
                <?php echo $heading ?>
            </h3>
        <?php endif ?>

        <?php if ($text) : ?>
            <p><?php echo $text ?></p>
        <?php endif ?>
    </div>
</div>