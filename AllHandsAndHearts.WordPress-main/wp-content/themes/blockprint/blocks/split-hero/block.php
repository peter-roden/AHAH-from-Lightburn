<?php
/**
 * Split Hero Block
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

$class_name = build_block_class_name( '@container group mt-0', $block );

$style = build_block_styles( $block );

$template = [
    ['core/pattern', [
        'slug' => 'blockprint/hidden-hero-innerblocks'
    ]]
];

$size = get_field('size');
$media_type = get_field('media_type');
$image = get_field('image');
$video = get_field('video');
$show_media_on_right = get_field('show_media_on_right');

$container_class_name = 'grid @4xl:grid-cols-2';
if ($size === 'small') {
    $container_class_name .= ' @4xl:min-h-130';
} else if ($size === 'medium') {
    $container_class_name .= ' @4xl:min-h-160';
} else if ($size === 'large') {
    $container_class_name .= ' @4xl:min-h-[calc(100svh-var(--wp-admin--admin-bar--height,0px)-var(--header-height,0px))]';
}

$innerblocks_class_name = 'is-layout-constrained group-[.has-text-align-center]:[&_.wp-block-buttons]:justify-center group-[.has-text-align-right]:[&_.wp-block-buttons]:justify-end [&>*]:max-w-full';
?>

<header id="<?php echo esc_attr($anchor) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr($style) . '"' : '' ?>>
    <div class="<?php echo trim(esc_attr($container_class_name)) ?>">
        <div class="<?php echo $show_media_on_right ? ' order-1 @4xl:order-2' : '' ?>">
            <?php if ($video) : ?>
                <video class="size-full object-cover" src="<?php echo wp_get_attachment_url($video['id']) ?>" autoplay playsinline muted loop></video>
            <?php elseif ($image) : ?>
                <?php echo wp_get_attachment_image( $image['id'], '1920', false, [
                    'class' => 'size-full object-cover'
                ] ); ?>
            <?php else : ?>
                <div class="bg-gray-100 w-full h-full aspect-video"></div>
            <?php endif ?>
        </div>
        <div class="self-center px-(--container-spacing-x) @4xl:px-10 @6xl:px-20 py-10<?php echo $show_media_on_right ? ' order-2 @4xl:order-1' : '' ?>">
            <InnerBlocks
                template="<?php echo esc_attr(wp_json_encode($template)) ?>"
                class="<?php echo esc_attr($innerblocks_class_name) ?>"
            />
        </div>
    </div>
</header>