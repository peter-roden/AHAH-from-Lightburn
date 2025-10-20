<?php
/**
 * Value Proposition Block
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

$class_name = build_block_class_name( 'group @container', $block );

$style = build_block_styles( $block );

$allowed_blocks = [
    'acf/value-prop-item'
];

$template = [
    ['acf/value-prop-item', [
        'data' => [
            'heading' => 'Value',
            'text' => 'Pellentesque iaculis, purus at dignissim luctus, nulla nisl pharetra lacus, nec aliquam est.',
        ]
    ]],
    ['acf/value-prop-item', [
        'data' => [
            'heading' => 'Value',
            'text' => 'Pellentesque iaculis, purus at dignissim luctus, nulla nisl pharetra lacus, nec aliquam est.',
        ]
    ]],
    ['acf/value-prop-item', [
        'data' => [
            'heading' => 'Value',
            'text' => 'Pellentesque iaculis, purus at dignissim luctus, nulla nisl pharetra lacus, nec aliquam est.',
        ]
    ]]
];

$heading = get_field('heading');
$text = get_field('text');
$text_align = get_field('text_align');
$image = get_field('image');
$items_per_row = get_field('items_per_row');

$innerblocks_class_name = 'grid gap-8 @3xl:gap-10';
if ($items_per_row === '2') {
    $innerblocks_class_name .= ' @2xl:grid-cols-2';
} else if ($items_per_row === '3') {
    $innerblocks_class_name .= ' @xl:grid-cols-3';
} else if ($items_per_row === '4') {
    $innerblocks_class_name .= ' @xl:grid-cols-2 @4xl:grid-cols-4';
} else {
    $innerblocks_class_name .= ' @xl:grid-cols-3';
}

$header_left_col_class_name = 'flex flex-col gap-y-6 w-full [&>*]:mb-0 px-2 self-center order-2 @2xl:order-1';
if ($image) {
    $header_left_col_class_name .= ' @2xl:pr-8 @4xl:pr-18 @2xl:w-1/2';
} elseif ($text_align === 'Center') {
    $header_left_col_class_name .= ' @2xl:w-9/10 @4xl:w-5/6 @5xl:w-2/3 text-center mx-auto';
} else {
    $header_left_col_class_name .= ' @2xl:w-3/4 @4xl:w-2/3 @5xl:w-1/2';
}
?>

<section id="<?php echo esc_attr($anchor) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr($style) . '"' : '' ?> data-items-per-row="<?php echo $items_per_row ?>">    
    <?php if ( $heading || $text || $image ) : ?>
        <header class="flex flex-wrap -mx-2 gap-y-6 mb-10">
            <div class="<?php echo esc_attr($header_left_col_class_name) ?>">
                <?php if ( $heading ) : ?>
                    <h2 class="text-h3 font-extrabold"><?php echo $heading ?></h2>
                <?php endif ?>

                <?php if ( $text ) : ?>
                    <div class="text-lg<?php echo $image ? ' pl-10 @5xl:pl-16' : '' ?>">
                        <?php echo $text ?>
                    </div>
                <?php endif ?>
            </div>

            <?php if ( $image ) : ?>
                <div class="w-full @2xl:w-1/2 px-2 order-1 @2xl:order-2 ml-auto">
                    <?php echo wp_get_attachment_image( $image['id'], 'large', false, [
                        'loading' => 'lazy',
                        'class' => 'w-full'
                    ] ); ?>
                </div>
            <?php endif ?>
        </header>
    <?php endif ?>

    <InnerBlocks
        class="<?php echo trim( esc_attr( $innerblocks_class_name ) ) ?>"
        allowedBlocks="<?php echo esc_attr(wp_json_encode($allowed_blocks)) ?>"
        template="<?php echo esc_attr(wp_json_encode($template)) ?>"
    />
</section>