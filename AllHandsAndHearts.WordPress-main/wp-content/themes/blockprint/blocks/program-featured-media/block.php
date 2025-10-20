<?php
/**
 * Program Featured Media Block
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

$image = get_field('image');
$embed = get_field('embed');
?>

<div id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '' ?>>
    <?php if ( $embed ) : ?>
        <div class="<?php echo esc_attr('aspect-video size-full [&>iframe]:size-full bg-black') ?>">
            <?php echo $embed ?>
        </div>
    <?php else : ?>
        <div class="w-full min-h-[35rem] aspect-[2]">
            <?php if ( $image ) {
                echo wp_get_attachment_image( $image['id'], '1920', false, [
                    'class' => 'size-full object-cover',
                    'loading' => 'lazy'
                ] );
            } else {
                get_template_part('partials/placeholder-image');
            } ?>
        </div>
    <?php endif ?>
</div>