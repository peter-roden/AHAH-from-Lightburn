<?php
/**
 * Tabbed Values Block
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

$class_name = build_block_class_name( 'bg-purple-950', $block );

$style = build_block_styles( $block );

$heading = get_field('heading');
?>

<div id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '' ?>>
    <div class="@container container-wide">
        <?php if ( $heading ) : ?>
            <h2 class="text-white text-overline font-semibold text-center my-12 @4xl:my-16">
                <?php echo $heading; ?>
            </h2>
        <?php endif ?>

        <?php if ( have_rows('values') ) : ?>
            <div class="group/tabs js-tabs">
                <div role="tablist" class="flex justify-between p-1 w-full js-tabs-list pb-13 overflow-x-auto">
                    <?php while ( have_rows('values') ) :
                        the_row();
                        $index = get_row_index();
                        $tab_id = "{$anchor}_tab_{$index}";
                        $panel_id = "{$anchor}_tabpanel_{$index}";
                        $value = get_sub_field('value');
                    ?>
                        <div class="relative size-full flex justify-center after:content-[''] after:w-full after:bg-purple-400  after:absolute after:bottom-0 after:h-[1px] [&:has(.is-selected)]:after:h-[4px] [&:has(.is-selected)]:after:bottom-[-3px]">
                            <a class="size-full mx-auto py-3.5 px-8 text-center text-nowrap js-tabs-trigger text-white [&.is-selected]:text-purple-400 font-bold hover:text-white no-underline hover:no-underline" href="#<?php echo $panel_id ?>" id="<?php echo $tab_id ?>" aria-controls="<?php echo $panel_id ?>" role="tab">
                                <span class="pointer-events-none"><?php echo $value ?></span>
                            </a>
                        </div>
                    <?php endwhile ?>
                </div>

                <div class="flex flex-col group-not-[.is-initialized]/tabs:gap-y-12">
                    <?php while ( have_rows('values') ) :
                        the_row();
                        $index = get_row_index();
                        $tab_id = "{$anchor}_tab_{$index}";
                        $panel_id = "{$anchor}_tabpanel_{$index}";
                        $content = get_sub_field('content');
                        $value = get_sub_field('value');
                    ?>
                        <button class="hidden js-accordion-trigger">
                            <?php echo $value ?>
                        </button>

                        <div id="<?php echo $panel_id ?>" class="group/tabs-panel js-tabs-panel" role="tabpanel" aria-labelledby="<?php echo $tab_id ?>">
                            <div class="content [.is-hidden]:hidden">
                                <div class="max-w-[910px] mx-auto text-white text-center pb-12 @2xl:pb-16">
                                    <?php echo $content; ?>
                                </div>
                            </div>
                        </div>
                    <?php endwhile ?>
                </div>
            </div>
        <?php endif ?>
    </div>
</div>