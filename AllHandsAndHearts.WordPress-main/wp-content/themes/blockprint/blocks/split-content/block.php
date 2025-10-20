<?php
/**
 * Split Content Block
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

$template = [
    ['core/pattern', [
        'slug' => 'blockprint/hidden-split-content-innerblocks'
    ]]
];

$image = get_field('image');
$image_size = get_field('image_size') ?: 'large';
$image_fit = get_field('image_fit') ?: 'cover';
$video = get_field('video');
$image_aspect_ratio = get_field('image_aspect_ratio');
$image_border_radius = get_field('image_border_radius');
$image_border_radius = $image_border_radius ? $image_border_radius / 16 . 'rem' : 'var(--default-border-radius)';
$show_image_on_right = get_field('image_position') === 'right';
$video_autoplay = get_field('video_autoplay');
$video_loop = get_field('video_loop');
$video_controls = get_field('video_controls');

$is_align_full = $block['align'] === 'full';
$has_background = !empty($block['backgroundColor']) || !empty($block['style']['color']['background']);

$grid_class_name = 'grid @2xl:grid-cols-2 gap-y-6 items-center';
if (!$is_align_full) {
    $grid_class_name .= ' gap-x-4';
}

$image_col_class_name = 'h-full';
if ($show_image_on_right) {
    $image_col_class_name .= ' order-1 @2xl:order-2';
} else {
    $image_col_class_name .= '';
}

$content_col_class_name = '';
if ($has_background) {
    $content_col_class_name .= ' pb-6 @2xl:py-12';
}

if ($show_image_on_right) {
    $content_col_class_name .= ' order-2 @2xl:order-1' . ($is_align_full ? '' : ' @2xl:pr-2 @4xl:pr-4 @5xl:pr-10 @7xl:pr-16');

    if ($has_background && !$is_align_full) {
        $content_col_class_name .= ' px-6 @3xl:pl-8 @4xl:pl-10 @5xl:pl-16 @2xl:pr-0';
    }
} else {
    $content_col_class_name .= $is_align_full ? '' : ' @2xl:pl-2 @4xl:pl-4 @5xl:pl-10 @7xl:pl-16';

    if ($has_background && !$is_align_full) {
        $content_col_class_name .= ' px-6 @3xl:pr-8 @4xl:pr-10 @5xl:pr-16 @2xl:pl-0';
    }
}

$innerblocks_class_name = 'is-layout-constrained [&>*]:max-w-full';
if ($is_align_full) {
    $content_col_class_name .= ' px-(--container-spacing-x) @2xl:px-8 @4xl:px-10 @5xl:px-16';
}
?>

<div id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '' ?>>
    <div class="<?php echo trim(esc_attr($grid_class_name)) ?>">
        <div class="<?php echo trim(esc_attr($image_col_class_name)) ?>">
            <?php if ($video) : ?>
                <video class="size-full rounded-(--border-radius) <?php echo $image_aspect_ratio ? 'aspect-(--aspect-ratio)' : '' ?> <?php echo $image_fit === 'cover' ? 'object-cover' : 'object-contain' ?>" style="<?php echo $image_aspect_ratio ? '--aspect-ratio:' . $image_aspect_ratio . ';' : '' ?><?php '--border-radius:' . $image_border_radius ?>" src="<?php echo wp_get_attachment_url($video['id']) ?>" <?php echo $video_autoplay ? 'autoplay muted' : ''?> <?php echo $video_controls ? 'controls' : ''?> <?php echo $video_loop ? 'loop' : ''?> playsinline></video>
            <?php elseif ($image) : ?>
                <?php echo wp_get_attachment_image( $image['id'], $image_size, false, [
                    'loading' => 'lazy',
                    'class' => 'size-full rounded-(--border-radius)' . ($image_aspect_ratio ? ' aspect-(--aspect-ratio)' : '') . ($image_fit === 'cover' ? ' object-cover' : ' object-contain'),
                    'style' => ($image_aspect_ratio ? '--aspect-ratio:' . $image_aspect_ratio . ';' : '') . ('--border-radius:' . $image_border_radius)
                ] ); ?>
            <?php else : ?>
                <div class="aspect-square size-full rounded-(--border-radius) overflow-hidden" style="--border-radius:<?php echo $image_border_radius ?>">
                    <?php echo get_template_part('partials/placeholder-image'); ?>
                </div>
            <?php endif ?>
        </div>
        <div class="<?php echo trim(esc_attr($content_col_class_name)) ?>">
            <InnerBlocks
                template="<?php echo esc_attr(wp_json_encode($template)) ?>"
                class="<?php echo trim(esc_attr($innerblocks_class_name)) ?>"
            />
        </div>
    </div>
</div>