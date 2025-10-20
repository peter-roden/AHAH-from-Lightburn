<?php
/**
 * Simple Hero Block
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

$class_name = build_block_class_name( 'relative z-1 overflow-hidden px-(--container-spacing-x) mt-0', $block );

$style = build_block_styles( $block );

if ( empty($block['textColor']) ) {
    $class_name .= ' text-white';
}

$template = [
    ['core/pattern', [
        'slug' => 'blockprint/hidden-hero-innerblocks'
    ]]
];

$size = get_field('size');
$bg_media_type = get_field('bg_media_type');
$bg_image = get_field('bg_image');
$bg_image_mobile = get_field('bg_image_mobile');
$bg_video = get_field('bg_video');
$bg_image_focal_point_left = get_field('bg_image_focal_point_left');
$bg_image_focal_point_top = get_field('bg_image_focal_point_top');
$bg_image_object_position = "{$bg_image_focal_point_left}% {$bg_image_focal_point_top}%";
$bg_overlay_color = get_field('bg_overlay_color') ?: '#000000';
$bg_overlay_opacity = (get_field('bg_overlay_opacity') ?: 0) / 100;
$justify_content = get_field('justify_content');
$content_bg_color = get_field('content_bg_color');
$content_max_width = get_field('content_max_width');
$content_max_width = $content_max_width ? "{$content_max_width}px" : ($content_bg_color ? 'calc(var(--spacing) * 208)' : 'calc(var(--spacing) * 168)');
$content_bg_opacity = (get_field('content_bg_opacity') ?: 0) / 100;
$show_scroll_button = get_field('show_scroll_button');

$container_class_name = 'flex items-center py-12';
if ($size === 'small') {
    $container_class_name .= ' min-h-122 md:min-h-130';
} else if ($size === 'medium') {
    $container_class_name .= ' min-h-136 md:min-h-160';
} else if ($size === 'large') {
    $container_class_name .= ' min-h-[calc(100svh-var(--wp-admin--admin-bar--height,0px)-var(--header-height,0px))]';
}

if ($justify_content === 'left') {
    $container_class_name .= '';
} else if ($justify_content === 'center') {
    $container_class_name .= ' text-center justify-center [&_.wp-block-buttons:not([class*=is-content-justification])]:justify-center';
} else if ($justify_content === 'right') {
    $container_class_name .= ' justify-end';
}
?>

<header id="<?php echo esc_attr($anchor) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr($style) . '"' : '' ?>>
    <div class="absolute top-0 left-0 -z-1 size-full">
        <?php if ($bg_video) : ?>
            <video class="size-full object-cover" src="<?php echo wp_get_attachment_url($bg_video['id']) ?>" autoplay playsinline muted loop></video>
        <?php elseif ($bg_image) : ?>
            <picture>
                <?php if ($bg_image_mobile) : ?>
                    <source srcset="<?php echo wp_get_attachment_image_url( $bg_image_mobile['id'], 'medium_large' ) ?>" media="(width < 768px)">
                <?php endif ?>
                <?php echo wp_get_attachment_image( $bg_image['id'], '1920', false, [
                    'class' => 'size-full object-cover ' . ($bg_image_mobile ? 'md:object-(--object-position)' : 'object-(--object-position)'),
                    'style' => "--object-position:{$bg_image_object_position}"
                ] ); ?>
            </picture>
        <?php endif ?>
        
        <div class="absolute top-0 left-0 size-full" style="background-color:<?php echo $bg_overlay_color ?>;opacity:<?php echo $bg_overlay_opacity ?>"></div>
    </div>

    <div class="<?php echo trim(esc_attr($container_class_name)) ?>">
        <div class="relative z-0 w-full max-w-(--max-width)<?php echo $content_bg_color ? ' p-6 md:p-12 lg:p-20' : '' ?>" style="--max-width:<?php echo $content_max_width ?>">
            <?php if ($content_bg_color) : ?>
                <div class="absolute top-0 left-0 -z-1 size-full" style="background-color:<?php echo $content_bg_color ?>;opacity:<?php echo $content_bg_opacity ?>"></div>
            <?php endif ?>

            <InnerBlocks
                template="<?php echo esc_attr(wp_json_encode($template)) ?>"
                class="<?php echo esc_attr('is-layout-constrained [&>*]:max-w-full') ?>"
            />
        </div>
    </div>

    <?php if ($show_scroll_button) : ?>
        <a class="absolute bottom-10 left-1/2 flex items-center justify-center rounded-full text-black! bg-white border w-10 h-10 -translate-x-1/2" href="#<?php echo esc_attr($anchor) ?>_after" aria-label="Scroll down">
            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <polyline points="6 9 12 15 18 9" />
            </svg>
        </a>
        <div id="<?php echo esc_attr($anchor) ?>_after"></div>
    <?php endif ?>
</header>