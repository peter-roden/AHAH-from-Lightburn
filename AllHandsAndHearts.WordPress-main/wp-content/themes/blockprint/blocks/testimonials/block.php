<?php
/**
 * Testimonials Block
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

$class_name = build_block_class_name( 'relative z-0 text-center', $block );

$style = build_block_styles( $block );

$testimonials = get_field('testimonials') ?: get_posts([
    'post_type' => 'testimonial',
    'numberposts' => 1,
    'post_status' => 'publish'
]);
$content_width = ((get_field('content_width') ?: 550) / 16) . 'rem';
$background_image = get_field('background_image');
$background_overlay_opacity = get_field('background_overlay_opacity') / 100;
?>

<div id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '' ?>>
    <?php if ( $background_image ) : ?>
        <div class="absolute inset-0 -z-1">
            <?php echo wp_get_attachment_image( $background_image['id'], '1920', false, [
                'loading' => 'lazy',
                'class' => 'size-full object-cover'
            ] ); ?>
            <div class="absolute inset-0 bg-black" style="opacity:<?php echo $background_overlay_opacity ?>"></div>
        </div>
    <?php endif ?>

    <div class="group/swiper w-full py-12 md:py-16 swiper js-swiper" data-options='{
        "allowTouchMove": <?php echo $is_preview ? 'false' : 'true' ?>,
        "speed": 500,
        "navigation": {
            "nextEl": ".swiper-button-next",
            "prevEl": ".swiper-button-prev"
        },
        "pagination": {
            "el": ".swiper-pagination",
            "bulletElement": "button",
            "clickable": true
        },
        "loop": true
    }'>
        <div class="swiper-wrapper items-center">
            <?php foreach ( $testimonials as $testimonial ) :
                $quote = get_field('quote', $testimonial->ID);
                $name = get_field('name', $testimonial->ID);
                $title = get_field('title', $testimonial->ID);
                $image = get_field('image', $testimonial->ID);
            ?>
                <div class="swiper-slide h-auto">
                    <div class="container flex flex-col items-center gap-y-6" style="--content-width:<?php echo $content_width ?>">
                        <?php if ( $image ) {
                            echo wp_get_attachment_image( $image['id'], 'thumbnail', false, [
                                'loading' => 'lazy',
                                'class' => 'w-[130px] aspect-square rounded-full overflow-hidden object-cover'
                            ] );
                        } ?>

                        <q class="text-h3 font-bold block"><?php echo $quote ?></q>

                        <?php if ( $name || $title ) : ?>
                            <p class="flex flex-col uppercase font-bold">
                                <?php echo $name ? "<span>{$name}</span>" : '' ?>
                                <?php echo $title ? "<span>{$title}</span>" : '' ?>
                            </p>
                        <?php endif ?>
                    </div>
                </div>
            <?php endforeach ?>
        </div>

        <?php get_template_part('partials/swiper-controls', null, [
            'class_name' => 'mt-12 -mb-5 md:-mb-2',
            'prev_btn_class_name' => 'md:absolute md:top-1/2 md:left-(--container-spacing-x) md:z-1 md:-translate-y-1/2',
            'next_btn_class_name' => 'md:absolute md:top-1/2 md:right-(--container-spacing-x) md:z-1 md:-translate-y-1/2'
        ] ); ?>
    </div>
</div>