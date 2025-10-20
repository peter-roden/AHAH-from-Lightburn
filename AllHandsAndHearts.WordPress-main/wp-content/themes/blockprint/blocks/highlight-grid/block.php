<?php
/**
 * Highlight Grid Block
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

$class_name = build_block_class_name( '', $block );

$style = build_block_styles( $block );
$overline = get_field('overline');
$heading = get_field('heading');
$content = get_field('content');

?>

<div id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '' ?>>
    <div class="@container container-wide">
        <div class="@5xl:grid grid-cols-12 gap-12">
            <div class="@5xl:col-span-4 @5xl:max-w-[447px] @5xl:mr-auto mb-12 @5xl:mb-0">
                <?php if ( $heading ) : ?>
                    <h3 class="mb-10 text-balance">
                        <?php echo $heading; ?>
                    </h3>
                <?php endif; ?>

                <?php if ( $content ) : ?>
                    <div class="text-lg text-purple-950">
                        <?php echo $content; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="flex flex-col @5xl:col-span-8 @3xl:grid grid-cols-2 @4xl:grid-cols-3 @5xl:grid-cols-2 gap-4 @5xl:max-w-[796px] mx-auto">
                <?php
                    if ( have_rows('items') ) :
                        while ( have_rows('items') ) : 
                            the_row();
                            $icon = get_sub_field('icon');
                            $item_heading = get_sub_field('item_heading');
                            $item_content = get_sub_field('item_content');
                ?>
                    <div class="@3xl:col-span-1 flex gap-4 items-start bg-neutral-50 px-4 py-6">
                        <?php if ($icon) : ?>
                            <span class="<?php echo $icon; ?> text-2xl"></span>
                        <?php endif; ?>

                        <div>
                            <?php if ($item_heading) : ?>
                                <p class="text-lg font-bold mb-2"><?php echo $item_heading; ?></p>
                            <?php endif; ?>

                            <?php if ($item_content) : ?>
                                <div class="text-sm"><?php echo $item_content; ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php
                        endwhile;
                    endif;
                ?>
            </div>
        </div>
    </div>
</div>