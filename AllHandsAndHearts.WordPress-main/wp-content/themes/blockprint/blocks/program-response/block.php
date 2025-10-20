<?php
/**
 * Program Response Block
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

$overline = get_field('overline');
$heading = get_field('heading');
$stats = get_field('stats') ?: get_field('stats', $post_id) ?: [];
?>

<section id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '' ?>>
    <div class="max-w-[57rem] mx-auto space-y-8 @xl:space-y-12">
        <?php if ( $overline || $headin ) : ?>
            <header class="space-y-4!">
                <?php if ( $overline ) : ?>
                    <p class="text-overline text-purple-500">
                        <?php echo $overline ?>
                    </p>
                <?php endif ?>

                <?php if ( $heading ) : ?>
                    <h2 class="text-h3">
                        <?php echo $heading ?>
                    </h2>
                <?php endif ?>
            </header>
        <?php endif ?>

        <?php if ( $stats ) : ?>
            <div class="flex flex-wrap justify-center gap-y-4 @xl:gap-y-6 @xl:text-center -mx-3">
                <?php foreach ( $stats as $stat ) : ?>
                    <div class="w-full <?php echo count($stats) == 4 ? '@xl:w-1/2 @3xl:w-1/4' : '@xl:w-1/3' ?> px-3">
                        <h3 class="text-display-3 text-[4.25rem] text-purple-500 break-words"><?php echo get_field('heading', $stat->ID) ?></h3>
                        <p class="@xl:max-w-[214px] mx-auto font-semibold"><?php echo get_field('description', $stat->ID) ?></p>
                    </div>
                <?php endforeach ?>
            </div>
        <?php endif ?>

        <InnerBlocks class="<?php echo esc_attr('is-layout-constrained [&>*]:max-w-full') ?>" />
        
        <?php if ( have_rows('program_history') ) : ?>
            <div class="js-accordions" data-multi-expand="false">
                <details class="group/accordion border-b data-[state=open]:border-b-0 text-left js-accordion" data-state="closed">
                    <summary class="<?php echo esc_attr('flex justify-between items-center gap-x-2 text-h6 mb-0 py-4 cursor-pointer [&::-webkit-details-marker]:hidden js-accordion__trigger') ?>" aria-expanded="false">
                        <span class="grow"><?php echo esc_html_e('Program History', 'blockprint') ?></span>
                        <svg class="group-data-[state=open]/accordion:-rotate-180 transition-transform shrink-0" width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M5 8L10 13L15 8" stroke="currentColor" stroke-width="2.25" stroke-linecap="square"></path>
                        </svg>
                    </summary>

                    <div class="transition-[height] h-(--height) overflow-hidden js-accordion__content">
                        <div class="js-accordions" data-multi-expand="false">
                            <?php while ( have_rows('program_history') ) : the_row(); ?>
                                <details class="group/accordion-child border-b text-left js-accordion" data-state="closed">
                                    <summary class="<?php echo esc_attr('flex justify-between items-center gap-x-2 text-lg font-bold mb-0 py-4 cursor-pointer [&::-webkit-details-marker]:hidden js-accordion__trigger') ?>" aria-expanded="false">
                                        <span class="grow"><?php echo get_sub_field('heading') ?></span>
                                        <svg class="group-data-[state=open]/accordion-child:-rotate-180 transition-transform shrink-0" width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path d="M5 8L10 13L15 8" stroke="currentColor" stroke-width="2.25" stroke-linecap="square"></path>
                                        </svg>
                                    </summary>

                                    <div class="transition-[height] h-(--height) overflow-hidden js-accordion__content">
                                        <div class="pb-4">
                                            <p class="@xl:text-lg border-l border-purple-500 pl-4 ml-4 @xl:ml-6"><?php echo get_sub_field('description') ?></p>
                                        </div>
                                    </div>
                                </details>
                            <?php endwhile ?>
                        </div>
                    </div>
                </details>
            </div>
        <?php endif ?>
    </div>
</section>