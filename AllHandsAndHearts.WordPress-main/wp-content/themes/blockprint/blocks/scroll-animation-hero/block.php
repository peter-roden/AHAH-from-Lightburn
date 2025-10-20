<?php
/**
 * Scroll Animation Hero Block
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

$class_name = build_block_class_name( 'relative bg-secondary bg-fixed bg-center bg-cover js-scroll-animation-hero', $block );

$style = build_block_styles( $block );

$image = get_field('image');
$initial_heading = get_field('initial_heading');
$scroll_heading = get_field('scroll_heading');
$summary_text = get_field('summary_text');

if ($image) {
    $style .= '--bg-image:url(' . $image['url'] . ')';
    $class_name .= ' bg-(image:--bg-image)';
}
?>

<header id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '' ?>>
    <div class="size-full min-h-svh">
        <div class="flex flex-col">
            <div class="sm:min-h-svh z-2 container pt-50 pb-10 sm:py-20 flex items-center justify-center text-white text-center">
                <?php if ( $initial_heading ) : ?>
                    <h1 class="text-display-1 text-[clamp(4.5rem,20vw,10rem)] mb-0 text-shadow-[0_0_16rem_#000]">
                        <?php echo $initial_heading ?>
                    </h1>
                <?php endif ?>
            </div>

            <div class="sm:min-h-svh z-2 flex items-center justify-center text-white text-center js-scroll-animation-hero__scroll-content">
                <div class="container py-20">
                    <?php if ( $scroll_heading ) : ?>
                        <h2 class="text-display-3">
                            <?php echo $scroll_heading ?>
                        </h2>
                    <?php endif ?>

                    <?php if ( $summary_text ) : ?>
                        <div class="mx-auto max-w-[912px] mt-16 text-xl">
                            <?php echo $summary_text ?>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>

    <div class="js-scroll-animation-hero__background absolute inset-0 bg-black z-1" style="opacity:0;will-change:opacity"></div>
</header>