<?php
/**
 * Accordion Block
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

$class_name = build_block_class_name( 'group/accordion @container border-b text-left js-accordion', $block );

$title = get_field('title');
$open = get_field('open');
?>

<details id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>" data-state="<?php echo $open ? 'open' : 'closed' ?>"<?php echo $open ? ' open' : '' ?>>
    <summary class="flex justify-between items-center gap-x-2 text-lg font-semibold @xl:text-h6 @xl:font-bold mb-0 py-4 cursor-pointer [&::-webkit-details-marker]:hidden js-accordion__trigger" aria-expanded="<?php echo $open ? 'true' : 'false' ?>" aria-controls="<?php echo esc_attr( $anchor ) ?>">
        <span class="grow"><?php echo $title ?></span>
        <svg class="group-data-[state=open]/accordion:-rotate-180 transition-transform shrink-0" width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M5 8L10 13L15 8" stroke="currentColor" stroke-width="2.25" stroke-linecap="square" />
        </svg>
    </summary>
    <div class="transition-[height] h-(--height) overflow-hidden js-accordion__content">
        <InnerBlocks class="pb-4" />
    </div>
</details>

<?php if ( $is_preview && $open ) : ?>
    <script>
        (() => {
            const block = document.getElementById('<?php echo esc_attr( $anchor ) ?>');
            block.open = true;
        })();
    </script>
<?php endif ?>