<?php
/**
 * Accordions Block
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

$class_name = build_block_class_name( 'js-accordions', $block );

$style = build_block_styles( $block );

$multiexpand = get_field('multiexpand');

$allowed_blocks = [
    'acf/accordion'
];

$template = [
    ['acf/accordion',
        ['data' => [
            'title' => 'Accordion 1 Title'
        ]],
        [['core/paragraph', [
            'content' => 'In fugiat ut magna excepteur ea cupidatat voluptate officia quis incididunt. Ullamco culpa deserunt minim amet aliqua minim. Dolore elit ea nostrud aute cupidatat enim culpa laboris tempor aliquip reprehenderit veniam.'
        ]]]
    ],
    ['acf/accordion',
        ['data' => [
            'title' => 'Accordion 2 Title'
        ]],
        [['core/paragraph', [
            'content' => 'Esse Lorem id aute occaecat do aliqua laboris. Tempor pariatur sint irure nulla. Lorem nisi esse ad pariatur deserunt nulla minim voluptate. Incididunt quis aliqua cillum nulla nulla nulla duis aliquip nisi esse est culpa ut Lorem.'
        ]]]
    ],
    ['acf/accordion',
        ['data' => [
            'title' => 'Accordion 3 Title'
        ]],
        [['core/paragraph', [
            'content' => 'Commodo sint ea sit nisi cillum reprehenderit veniam excepteur. Deserunt id culpa magna qui Lorem cillum. Magna pariatur in do ad. Et exercitation fugiat fugiat culpa consectetur in consectetur tempor pariatur aute duis ut eiusmod.'
        ]]]
    ]
];
?>

<div id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr($style) . '"' : '' ?> data-multi-expand="<?php echo $multiexpand ? 'true' : 'false' ?>">
    <InnerBlocks
        class="flex flex-col gap-[inherit]"
        allowedBlocks="<?php echo esc_attr(wp_json_encode($allowed_blocks)) ?>"
        template="<?php echo esc_attr(wp_json_encode($template)) ?>" />
</div>