<?php
/**
 * Overlapping Content Block
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

$class_name = build_block_class_name( '@container overflow-hidden', $block );

$style = build_block_styles( $block );

$template = [
    ['core/pattern', [
        'slug' => 'blockprint/hidden-split-content-innerblocks'
    ]]
];

$image = get_field('image');
$image_aspect_ratio = get_field('image_aspect_ratio') ?: '228/307';
$image_border_radius = get_field('image_border_radius');
$image_border_radius = $image_border_radius ? $image_border_radius / 16 . 'rem' : 'var(--default-border-radius)';
$show_image_on_right = get_field('image_position') === 'right';
$content_bg_color = get_field('content_bg_color') ?: 'oklch(98.5% 0 0)';
$content_border_radius = get_field('content_border_radius');
$content_border_radius = $content_border_radius ? $content_border_radius / 16 . 'rem' : 'var(--default-border-radius)';
$content_border_radius = $show_image_on_right ? "0 {$content_border_radius} {$content_border_radius} 0" : "{$content_border_radius} 0 0 {$content_border_radius}";

$innerblocks_class_name = 'is-layout-constrained [&>*]:max-w-full @3xl:max-w-116 @3xl:mx-auto';
?>

<div id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '' ?>>
    <div class="relative z-0 container-wide">
        <div class="hidden absolute top-0 left-0 -z-1 size-full @3xl:grid @3xl:grid-cols-12">
            <div class="relative col-span-8 rounded-(--border-radius) after:absolute after:top-0 after:h-full after:w-[999rem] after:bg-inherit<?php echo $show_image_on_right ? ' after:right-full' : '  col-start-5 after:left-full' ?>"
                style="background-color:<?php echo $content_bg_color ?>;<?php echo '--border-radius:' . $content_border_radius ?>">
            </div>
        </div>

        <div class="grid items-center gap-x-6 @3xl:grid-cols-12 @3xl:py-20">
            <div class="relative z-1 @3xl:col-span-5<?php echo $show_image_on_right ? ' order-1 @3xl:order-2' : '' ?>">
                <?php if ( $image ) {
                    echo wp_get_attachment_image( $image['id'], 'medium_large', false, [
                        'loading' => 'lazy',
                        'class' => 'size-full aspect-(--aspect-ratio) rounded-(--border-radius) object-cover',
                        'style' => '--aspect-ratio:' . $image_aspect_ratio . ';' . '--border-radius:' . $image_border_radius
                    ] );
                } else {
                    echo '<div class="aspect-(--aspect-ratio) rounded-(--border-radius)" style="--aspect-ratio:228/307;--border-radius:'. $image_border_radius . '">';
                    get_template_part('partials/placeholder-image');
                    echo '</div>';
                } ?>
            </div>
            <div class="relative z-0 @3xl:col-span-7 py-12 @3xl:py-0<?php echo $show_image_on_right ? ' order-2 @3xl:order-1' : '' ?>">
                <div class="absolute -top-48 bottom-0 -inset-x-(--container-spacing-x) -z-1 rounded-(--border-radius) @3xl:hidden" style="background-color:<?php echo $content_bg_color ?>;<?php echo $content_border_radius ? "--border-radius:{$content_border_radius}" : '' ?>"></div>
                <InnerBlocks
                    template="<?php echo esc_attr(wp_json_encode($template)) ?>"
                    class="<?php echo trim(esc_attr($innerblocks_class_name)) ?>"
                />
            </div>
        </div>
    </div>
</div>