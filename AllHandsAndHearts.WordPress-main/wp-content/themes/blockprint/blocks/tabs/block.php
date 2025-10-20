<?php
/**
 * Tabs Block
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

$class_name = build_block_class_name( 'group/tabs @container js-tabs', $block );

$style = build_block_styles( $block );

$mobile_layout = get_field('mobile_layout');
$update_hash = get_field('update_hash');

$allowed_blocks = [
    'acf/tab'
];

$template = [
    ['acf/tab', [
        'data' => [
            'name' => 'Tab 1'
        ]
    ], [
        ['core/paragraph', [
            'content' => 'Tab 1 content. Non sint magna do in sint enim ad officia labore laborum. Nostrud tempor ipsum ad nostrud ipsum minim do ad enim nulla. Voluptate ea pariatur commodo reprehenderit pariatur pariatur amet proident quis quis fugiat veniam nisi. Officia labore eu velit do irure aliqua.'
        ]]
    ]],
    ['acf/tab', [
        'data' => [
            'name' => 'Tab 2'
        ]
    ], [
        ['core/paragraph', [
            'content' => 'Tab 2 content. Non sint magna do in sint enim ad officia labore laborum. Nostrud tempor ipsum ad nostrud ipsum minim do ad enim nulla. Voluptate ea pariatur commodo reprehenderit pariatur pariatur amet proident quis quis fugiat veniam nisi. Officia labore eu velit do irure aliqua.'
        ]]
    ]],
    ['acf/tab', [
        'data' => [
            'name' => 'Tab 3'
        ]
    ], [
        ['core/paragraph', [
            'content' => 'Tab 3 content. Non sint magna do in sint enim ad officia labore laborum. Nostrud tempor ipsum ad nostrud ipsum minim do ad enim nulla. Voluptate ea pariatur commodo reprehenderit pariatur pariatur amet proident quis quis fugiat veniam nisi. Officia labore eu velit do irure aliqua.'
        ]]
    ]]
];
?>

<div id="<?php echo trim( esc_attr( $anchor ) ); ?>" class="<?php echo esc_attr( $class_name ); ?>"<?php echo !empty($style) ? ' style="' . esc_attr($style) . '"' : '' ?> data-update-hash="<?php echo $update_hash ? 'true' : 'false' ?>" data-mobile-layout="<?php echo $mobile_layout ?>">
    <div class="mb-6 group-not-[.is-initialized]/tabs:hidden">        
        <div class="hidden @2xl:block group-data-[mobile-layout=tabs]/tabs:flex">
            <div role="tablist" class="<?php echo esc_attr('hidden has-[a]:flex mx-auto w-fit max-w-full overflow-auto bg-neutral-100 p-1 [&>a]:flex [&>a]:items-center [&>a]:justify-center [&>a]:min-w-38 [&>a]:min-h-12 [&>a]:px-6 [&>a]:py-2 [&>a]:text-inherit [&>a]:text-center [&>a]:leading-[1.2] [&>a]:rounded-[inherit] [&>a]:hover:text-inherit [&>a]:hover:bg-black/5 [&>a]:no-underline! [&>a]:shrink-0 [&>a]:transition-colors [&>a.is-selected]:bg-secondary [&>a.is-selected]:text-white') ?> js-tabs-list"></div>
        </div>

        <?php if ( $mobile_layout === 'dropdown' ) : ?>
            <div class="@2xl:hidden relative">
                <select class="w-full bg-secondary text-white text-lg font-extrabold h-16 pl-6 pr-12 appearance-none [&_option]:bg-white [&_option]:text-black js-tabs-dropdown" aria-label="Select a tab"></select>
                <svg class="absolute top-1/2 right-6 -translate-y-1/2 text-white" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="square"/>
                </svg>
            </div>
        <?php endif ?>
    </div>

    <InnerBlocks
        allowedBlocks="<?php echo esc_attr(wp_json_encode($allowed_blocks)) ?>"
        template="<?php echo esc_attr(wp_json_encode($template)) ?>"
        class="flex flex-col group-not-[.is-initialized]/tabs:gap-y-6"
    />
</div>