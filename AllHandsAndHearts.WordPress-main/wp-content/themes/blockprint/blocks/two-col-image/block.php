<?php
/**
 * Two-Column Image Block
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

$class_name = build_block_class_name( '@container js-two-col-img overflow-hidden', $block );

$style = build_block_styles( $block );

$image_1 = get_field('image_1');
$image_2 = get_field('image_2');
?>

<div id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '' ?>>
    <div class="grid grid-cols-2 overflow-hidden js-two-col-img__wrapper min-w-[600px]">
        <div class="w-full aspect-[1.1]">
            <?php if ( $image_1 ) {
                echo wp_get_attachment_image( $image_1['id'], 'large', false, [
                    'loading' => 'lazy',
                    'class' => 'size-full object-cover'
                ] );
            } else {
                get_template_part('partials/placeholder-image');
            } ?>
        </div>
        <div class="w-full aspect-[1.1]">
            <?php if ( $image_2 ) {
                echo wp_get_attachment_image( $image_2['id'], 'large', false, [
                    'loading' => 'lazy',
                    'class' => 'size-full object-cover'
                ] );
            } else {
                get_template_part('partials/placeholder-image');
            } ?>
        </div>
    </div>
</div>