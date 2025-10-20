<?php
/**
 * Two Image Split Content Block
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

$layout = get_field('layout') ?: '1';
$image_1 = get_field('image_1');
$image_2 = get_field('image_2');
$image_border_radius = get_field('image_border_radius');
$image_border_radius = $image_border_radius ? $image_border_radius / 16 . 'rem' : 'var(--default-border-radius)';

$allowed_blocks = [
    'core/heading',
    'core/paragraph',
    'core/buttons',
    'core/list',
    'acf/cta-link',
];

$template = [
    ['core/heading', [
        'content' => 'Two Image Split Content',
        'fontSize' => 'heading-4',
        'level' => 2,
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
                    'top' => 'var:preset|spacing|4'
                ]
            ]
        ]
    ]],
    ['core/buttons',
        [
            'style' => [
                'spacing' => [
                    'margin' => [
                        'top' => 'var:preset|spacing|4'
                    ]
                ]
            ]
        ],
        [
            ['core/button', [
                'text' => 'Button CTA'
            ]]
        ]
    ]
];
?>

<div id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '' ?>>
    <?php if ( $layout == '1' ) : ?>
        <div class="flex flex-wrap @xl:flex-nowrap items-center gap-y-12 gap-x-10 @2xl:gap-x-12 @3xl:gap-x-16 @5xl:gap-x-[5.875rem]">
            <InnerBlocks
                allowedBlocks="<?php echo esc_attr(wp_json_encode($allowed_blocks)) ?>"
                template="<?php echo esc_attr(wp_json_encode($template)) ?>"
                class="<?php echo esc_attr('is-layout-constrained text-center w-full @xl:w-[calc(430/1128*100%)] @3xl:w-[calc(393/1128*100%)] order-3 @xl:order-1 [&>*]:max-w-full [&_.wp-block-buttons]:justify-center') ?>"
            />

            <div class="bg-gray-100 w-[calc(50%-var(--spacing)*5)] @xl:w-[calc(294/1128*100%)] aspect-[294/446] order-1 @xl:order-2">
                <?php if ($image_1) {
                    echo wp_get_attachment_image( $image_1['id'], 'medium_large', false, [
                        'class' => 'size-full object-cover rounded-(--border-radius)',
                        'style' => "--border-radius:{$image_border_radius}"
                    ] );
                } ?>
            </div>

            <div class="bg-gray-100 w-[calc(50%-var(--spacing)*5)] @xl:w-[calc(241/1128*100%)] aspect-[241/343] order-2 @xl:order-3">
                <?php if ($image_2) {
                    echo wp_get_attachment_image( $image_2['id'], 'medium_large', false, [
                        'class' => 'size-full object-cover rounded-(--border-radius)',
                        'style' => "--border-radius:{$image_border_radius}"
                    ] );
                } ?>
            </div>
        </div>
    <?php else : ?>
        <div class="grid @xl:grid-cols-12 gap-y-12">
            <div class="@xl:col-span-6 self-center @5xl:mr-3">
                <div class="bg-gray-100 aspect-[390/285] @xl:aspect-[551/760] mx-[calc(var(--container-spacing-x)*-1)] @xl:mx-0">
                    <?php if ($image_1) {
                        echo wp_get_attachment_image( $image_1['id'], 'medium_large', false, [
                            'class' => 'size-full object-cover rounded-(--border-radius)',
                            'style' => "--border-radius:{$image_border_radius}"
                        ] );
                    } ?>
                </div>
            </div>
            <div class="flex flex-col gap-y-12 @5xl:gap-y-18 @xl:col-span-5 @xl:col-start-8 @5xl:col-span-4 @5xl:col-start-9 @5xl:-ml-4 self-end">
                <div class="bg-gray-100 aspect-[392/370] w-[69%] @xl:w-full mx-auto">
                    <?php if ($image_2) {
                        echo wp_get_attachment_image( $image_2['id'], 'medium_large', false, [
                            'class' => 'size-full object-cover rounded-(--border-radius)',
                            'style' => "--border-radius:{$image_border_radius}"
                        ] );
                    } ?>
                </div>

                <InnerBlocks
                    allowedBlocks="<?php echo esc_attr(wp_json_encode($allowed_blocks)) ?>"
                    template="<?php echo esc_attr(wp_json_encode($template)) ?>"
                    class="<?php echo esc_attr('is-layout-constrained [&>*]:max-w-full') ?>"
                />
            </div>
        </div>
    <?php endif ?>
</div>