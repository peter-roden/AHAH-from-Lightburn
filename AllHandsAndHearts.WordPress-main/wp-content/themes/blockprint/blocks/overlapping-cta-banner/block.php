<?php
/**
 * Overlapping CTA Banner Block
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

$allowed_blocks = [
    'core/heading',
    'core/paragraph',
    'core/buttons',
    'core/group',
    'core/image'
];

$template = [
    ['core/heading', [
        'content' => 'Overlapping CTA Banner',
        'level' => 2
    ]],
    ['core/paragraph', [
        'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque iaculis, purus at dignissim luctus, nulla nisl pharetra lacus, nec aliquam est erat nec elit. Nulla sagittis sapien eget urna hendrerit, quis fermentum tellus egestas.',
        'style' => [
            'spacing' => [
                'margin' => [
                    'top' => 'var:preset|spacing|2'
                ]
            ]
        ]
    ]],
    ['core/buttons', [],
        [
            ['core/button', [
                'text' => 'Button CTA'
            ]]
        ]
    ]
];

$image = get_field('image');
$video = get_field('video');
$image_aspect_ratio = get_field('image_aspect_ratio');
$image_border_radius = get_field('image_border_radius');
$image_border_radius = $image_border_radius ? $image_border_radius / 16 . 'rem' : 'var(--default-border-radius)';
$show_image_on_right = get_field('image_position') === 'right';
$content_border_radius = get_field('content_border_radius');
$content_border_radius = $content_border_radius ? $content_border_radius / 16 . 'rem' : 'var(--default-border-radius)';
$content_bg_color = get_field('content_bg_color');
$content_bg_image = get_field('content_bg_image');
$content_bg_image_opacity = get_field('content_bg_image_opacity') / 100;

if ($content_bg_image) {
    $content_bg_color = $content_bg_color ?: '';
} else {
    $content_bg_color = $content_bg_color ?: 'var(--color-gray-100)';
}
?>

<div id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr($style) . '"' : '' ?>>
    <div class="relative z-0 grid @2xl:grid-cols-6 items-center @2xl:py-12 @4xl:py-16">
        <div class="absolute top-0 left-0 -z-1 hidden @2xl:grid @2xl:grid-cols-6 size-full">
            <div class="h-full bg-(--bg-color) @2xl:col-span-5 rounded-(--border-radius) overflow-hidden<?php echo $show_image_on_right ? '' : ' @2xl:col-start-2' ?>" style="--bg-color:<?php echo $content_bg_color ?>;--border-radius:<?php echo $content_border_radius ?>">
                <?php if ($content_bg_image) {
                    echo wp_get_attachment_image( $content_bg_image['id'], 'large', false, [
                        'loading' => 'lazy',
                        'class' => 'size-full object-cover opacity-(--opacity)',
                        'style' => '--opacity:' . $content_bg_image_opacity
                    ] );
                } ?>
            </div>
        </div>

        <div class="relative z-1 @2xl:col-span-2 px-6 @2xl:px-0<?php echo $show_image_on_right ? ' order-1 @2xl:order-2' : '' ?>">
            <?php
                if ($video) {
                    echo '<video class="w-full object-cover rounded-(--border-radius)' . ($image_aspect_ratio ? ' aspect-(--aspect-ratio)' : '') . '" style="--aspect-ratio:' . $image_aspect_ratio . ';--border-radius:' . $image_border_radius . '" src="' . wp_get_attachment_url($video['id']) . '" autoplay playsinline muted loop></video>';
                } else if ($image) {
                    echo wp_get_attachment_image( $image['id'], 'medium_large', false, [
                        'loading' => 'lazy',
                        'class' => 'w-full object-cover rounded-(--border-radius)' . ($image_aspect_ratio ? ' aspect-(--aspect-ratio)' : ''),
                        'style' => '--aspect-ratio:' . $image_aspect_ratio . ';--border-radius:' . $image_border_radius
                    ] );
                } else {
                    echo '<div class="bg-gray-200 aspect-(--aspect-ratio) rounded-(--border-radius)" style="--aspect-ratio:' . ($image_aspect_ratio ?: 1) . ';--border-radius:' . $image_border_radius . '"></div>';
                }
            ?>
        </div>

        <div class="relative z-0 @2xl:col-span-4 py-8 @2xl:py-0 px-6 @3xl:px-12 @5xl:px-20<?php echo $show_image_on_right ? ' order-2 @2xl:order-1' : '' ?>">
            <div class="@2xl:hidden absolute -top-24 bottom-0 -z-1 left-0 w-full bg-(--bg-color) rounded-(--border-radius) overflow-hidden" style="--bg-color:<?php echo $content_bg_color ?>;--border-radius:<?php echo $content_border_radius ?>">
                <?php if ($content_bg_image) {
                    echo wp_get_attachment_image( $content_bg_image['id'], 'medium', false, [
                        'loading' => 'lazy',
                        'class' => 'size-full object-cover opacity-(--opacity)',
                        'style' => '--opacity:' . $content_bg_image_opacity
                    ] );
                } ?>
            </div>
            
            <InnerBlocks
                allowedBlocks="<?php echo esc_attr(wp_json_encode($allowed_blocks)) ?>"
                template="<?php echo esc_attr(wp_json_encode($template)) ?>"
                class="is-layout-constrained"
            />
        </div>
    </div>
</div>