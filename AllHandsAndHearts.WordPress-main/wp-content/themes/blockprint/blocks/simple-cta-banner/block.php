<?php
/**
 * Simple CTA Banner Block
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

$class_name = build_block_class_name( 'relative z-0 flex items-center justify-center text-center px-6 rounded-(--border-radius) overflow-hidden', $block );

if ( !str_contains($class_name, 'has-background') ) {
    $class_name .= ' bg-gray-100';
}

$style = build_block_styles( $block );

$allowed_blocks = [
    'core/heading',
    'core/paragraph',
    'core/buttons',
    'core/list',
    'core/image'
];

$template = [
    ['core/pattern', [
        'slug' => 'blockprint/hidden-simple-cta-banner-innerblocks'
    ]]
];

$innerblocks_class_name = 'is-layout-constrained max-w-225 mx-auto [&>*]:max-w-full';

$size = get_field('size');
$bg_image = get_field('bg_image');
$bg_video = get_field('bg_video');
$bg_overlay_color = get_field('bg_overlay_color');
$bg_overlay_opacity = (get_field('bg_overlay_opacity') ?: 40) / 100;
$border_radius = get_field('border_radius');
$border_radius = $border_radius ? $border_radius / 16 . 'rem' : 'var(--default-border-radius)';

$style .= "--border-radius:{$border_radius}";

if ($size == 'small') {
    $class_name .= ' py-12';
} else if ($size == 'medium') {
    $class_name .= ' py-24';
} else if ($size == 'large') {
    $class_name .= ' py-24 lg:py-36';
}
?>

<div id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '' ?>>
    <?php if ( $bg_video || $bg_image ) : ?>
        <div class="absolute top-0 left-0 -z-1 size-full">
            <?php if ( $bg_video ) : ?>
                <video class="size-full object-cover" src="<?php echo wp_get_attachment_url($bg_video['id']) ?>" autoplay playsinline muted loop></video>
            <?php elseif ( $bg_image ) : ?>
                <?php echo wp_get_attachment_image( $bg_image['id'], '1920', false, [
                    'loading' => 'lazy',
                    'class' => 'size-full object-cover'
                ] ); ?>
            <?php endif ?>

            <?php if ( $bg_overlay_color ) : ?>
                <div class="absolute top-0 left-0 size-full" style="background-color:<?php echo $bg_overlay_color ?>;opacity:<?php echo $bg_overlay_opacity ?>"></div>
            <?php endif ?>
        </div>
    <?php endif ?>

    <InnerBlocks
        allowedBlocks="<?php echo esc_attr(wp_json_encode($allowed_blocks)) ?>"
        template="<?php echo esc_attr(wp_json_encode($template)) ?>"
        class="<?php echo esc_attr($innerblocks_class_name) ?>"
    />
</div>