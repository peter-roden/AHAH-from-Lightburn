<?php
/**
 * Tab Block
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

$class_name = build_block_class_name( 'group/tabs-panel mt-0 group-data-[mobile-layout=accordion]/tabs:border-b md:group-data-[mobile-layout=accordion]/tabs:border-b-0 js-tabs-panel', $block );

$name = get_field('name');
?>

<div class="<?php echo trim( esc_attr( $class_name ) ); ?>" id="<?php echo esc_attr( $anchor ); ?>" role="tabpanel" aria-labelledby="<?php echo $anchor ?>_tab" data-tab-name="<?php echo esc_attr($name) ?>">    
    <button class="hidden group-data-[mobile-layout=accordion]/tabs:block md:hidden! text-lg font-bold py-4 cursor-pointer w-full text-left js-accordion-trigger" aria-controls="<?php echo $anchor ?>">
        <span class="flex justify-between gap-x-2 pointer-events-none">
            <span class="grow">
                <?php echo $name ?>
            </span>
            <svg class="group-has-[.is-open]/tabs-panel:-rotate-180 shrink-0 viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <polyline points="6 9 12 15 18 9" />
            </svg>
        </span>
    </button>

    <div class="content [.is-hidden]:hidden">
        <InnerBlocks class="group-data-[mobile-layout=accordion]/tabs:pb-4 md:group-data-[mobile-layout=accordion]/tabs:pb-0" />
    </div>
</div>