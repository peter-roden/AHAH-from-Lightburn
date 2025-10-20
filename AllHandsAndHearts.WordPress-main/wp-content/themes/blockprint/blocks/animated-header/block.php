<?php
/**
 * Animated Header Block
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

$class_name = build_block_class_name( '@container bg-primary js-animated-header', $block );

$style = build_block_styles( $block );

$overline = get_field( 'overline' );
$heading = get_field( 'heading' );
$animated_text = get_field( 'animated_text' );
$interval = get_field('interval') ?: 1000;
$i = 0;
?>

<div id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '' ?> data-interval="<?php echo esc_attr( $interval ); ?>">
    <div class="min-h-[28.75rem] py-20 @2xl:py-31 flex flex-col items-center justify-center container-wide my-auto">
        <?php if ( $overline ) : ?>
            <p class="text-overline text-white text-center mb-4.5 @2xl:mb-6">
                <?php echo $overline; ?>
            </p>
        <?php endif; ?>

        <?php if ( $heading || $animated_text ) : ?>
            <h1 class="text-white text-center text-display-1 text-[clamp(4.5rem,10vw,10rem)]! text-balance mb-0">
                <span class="block"><?php echo $heading; ?></span>
                <?php if ( $animated_text ) : ?>
                    <?php foreach ( $animated_text as $item ) : ?>
                        <span class="<?php echo $i == 0 ? 'block' : 'hidden' ?> js-animated-header__text">
                            <?php echo $item['text']; ?>
                        </span>
                    <?php $i++; endforeach; ?>
                <?php endif; ?>
            </h1>
        <?php endif; ?>
    </div>
</div>