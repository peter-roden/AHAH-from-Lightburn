<?php
/**
 * Cards Block
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

$class_name = build_block_class_name( 'group/card relative border border-gray-300 bg-white overflow-hidden rounded-(--border-radius)', $block );

$style = build_block_styles( $block );

$allowed_blocks = [
    'core/heading',
    'core/paragraph',
    'core/buttons',
    'core/list',
    'core/image'
];

$template = [
    ['core/heading', [
        'content' => 'Card Heading',
        'fontSize' => 'lg',
        'level' => 3,
        'style' => [
            'typography' => [
                'fontStyle' => 'normal',
                'fontWeight' => '700'
            ]
        ]
    ]],
    ['core/paragraph', [
        'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque iaculis, purus at dignissim luctus.',
        'style' => [
            'spacing' => [
                'margin' => [
                    'top' => 'var:preset|spacing|2'
                ]
            ]
        ]
    ]],
    ['core/buttons',
        [],
        [
            ['core/button', [
                'text' => 'Button CTA'
            ]]
        ]
    ]
];

$image = get_field('image');
$image_size = get_field('image_size') ?: 'medium';
$image_fit = get_field('image_fit') ?: 'cover';
$image_aspect_ratio = get_field('image_aspect_ratio') ?: 'var(--card-image-aspect-ratio)';
$border_radius = get_field('border_radius');
$border_radius = $border_radius ? $border_radius / 16 . 'rem' : 'var(--card-border-radius)';

$style .= "--border-radius:{$border_radius};";
?>

<div id="<?php echo esc_attr($anchor) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty($style) ? ' style="' . esc_attr($style) . '"' : '' ?>>
    <?php if ($image) : ?>
        <figure class="aspect-(--aspect-ratio) overflow-hidden" style="--aspect-ratio:<?php echo $image_aspect_ratio ?>">
            <?php echo wp_get_attachment_image( $image['id'], $image_size, false, [
                'loading' => 'lazy',
                'class' => 'size-full' . ($image_fit === 'cover' ? ' object-cover' : ' object-contain')
            ] ); ?>
        </figure>
    <?php endif ?>

    <InnerBlocks
        allowedBlocks="<?php echo esc_attr(wp_json_encode($allowed_blocks)) ?>"
        template="<?php echo esc_attr(wp_json_encode($template)) ?>"
        class="is-layout-constrained p-4"
    />
</div>