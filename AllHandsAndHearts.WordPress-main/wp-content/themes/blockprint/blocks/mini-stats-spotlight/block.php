<?php
/**
 * Mini Stats Spotlight Block
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

$heading = get_field('heading');
$stats = get_field('stats');
$image = get_field('image');
?>

<div id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '' ?>>
    <div class="pt-16 @3xl:pt-24 @6xl:pt-36">
        <?php if ( $heading ) : ?>
            <h2 class="container text-center mb-8 @2xl:mb-10">
                <?php echo $heading ?>
            </h2>
        <?php endif ?>
    </div>
    
    <div class="relative">
        <div class="relative z-0">
            <div class="absolute top-1/2 left-0 -z-1 w-full h-1/2 bg-green-100"></div>

            <div class="container relative">
                <figure class="w-full aspect-square max-h-[480px] @3xl:max-h-none @3xl:h-[620px] bg-neutral-100">
                    <?php if ( $image ) {
                        echo wp_get_attachment_image( $image['id'], '1920', false, [
                            'class' => 'size-full object-cover',
                            'loading' => 'lazy'
                        ] );
                    } else {
                        get_template_part('partials/placeholder-image');
                    } ?>
                </figure>
            </div>
        </div>

        <?php if ( $stats ) : ?>
            <div class="text-green-950 bg-green-100">
                <div class="@3xl:absolute bottom-0 left-0 w-full">
                    <div class="container">
                        <div class="grid grid-cols-2 @xl:grid-cols-4 gap-8 @3xl:gap-4 pt-6 @3xl:p-4">
                            <?php foreach ( array_slice($stats, 0, 4) as $stat ) : ?>
                                <div class="@3xl:bg-green-950 @3xl:text-green-100 @3xl:p-6">
                                    <h3 class="font-futura-pt-cond break-words mb-1"><?php echo get_field('heading', $stat->ID) ?></h3>
                                    <p class=""><?php echo get_field('description', $stat->ID) ?></p>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif ?>
    </div>

    <div class="bg-green-100 pb-16 @3xl:pb-24 @6xl:pb-36"></div>
</div>