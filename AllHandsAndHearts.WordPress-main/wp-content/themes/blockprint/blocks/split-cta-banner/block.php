<?php
/**
 * Split CTA Banner Block
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

$class_name = build_block_class_name( '@container bg-purple-100 text-purple-700', $block );

$style = build_block_styles( $block );

$image = get_field('image');
$image_aspect_ratio = get_field('image_aspect_ratio');
$heading = get_field('heading');
$text = get_field('text');
$cta_link = get_field('cta_link');
?>

<div id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '' ?>>
    <div class="grid @2xl:grid-cols-2">
        <div class="size-full<?php echo $image_aspect_ratio ? ' aspect-(--aspect-ratio)' : '' ?>"<?php echo $image_aspect_ratio ? 'style="--aspect-ratio:' . $image_aspect_ratio . '"' : '' ?>>
            <?php if ( $image ) {
                echo wp_get_attachment_image( $image['id'], 'medium_large', false, [
                    'loading' => 'lazy',
                    'class' => 'size-full object-cover'
                ] );
            } else {
                echo get_template_part('partials/placeholder-image');
            } ?>
        </div>
        <div class="<?php echo esc_attr('flex flex-col gap-y-6 @4xl:gap-y-8 self-center p-8 @2xl:py-12 @4xl:py-18 @4xl:px-16') ?>">
            <?php if ( $heading ) : ?>
                <h2 class="text-h4 mb-0">
                    <?php echo $heading ?>
                </h2>
            <?php endif ?>

            <?php if ( $text ) : ?>
                <div class="text-lg">
                    <?php echo $text ?>
                </div>
            <?php endif ?>

            <?php if ( $cta_link ) : ?>
                <div>
                    <?php get_template_part( 'partials/cta-link', null, [
                        'link' => $cta_link
                    ] ); ?>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>