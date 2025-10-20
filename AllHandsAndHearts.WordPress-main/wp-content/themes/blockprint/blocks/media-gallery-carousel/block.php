<?php
/**
 * Media Gallery Carousel Block
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

$class_name = build_block_class_name( 'overflow-hidden', $block );

$style = build_block_styles( $block );
$slide_transition_speed = 800;
?>

<div id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '' ?>>
    <div class="container-wide">
        <div class="md:max-w-5/6 mx-[calc(-1*var(--container-spacing-x))] md:mx-auto">
            <?php if ( have_rows('slides') ) : ?>
                <div class="swiper js-swiper overflow-visible" style="--swiper-slide-transition-duration:<?php echo $slide_transition_speed ?>ms" data-options='{
                    "allowTouchMove": false,
                    "speed": <?php echo $slide_transition_speed ?>,
                    "navigation": {
                        "nextEl": ".swiper-button-next",
                        "prevEl": ".swiper-button-prev"
                    },
                    "pagination": {
                        "el": ".swiper-pagination",
                        "bulletElement": "button",
                        "clickable": true
                    }
                }'>
                    <div class="swiper-wrapper">
                        <?php while ( have_rows('slides')  ) :
                            the_row();
                            $image = get_sub_field('image');
                            $after_image = get_sub_field('after_image');
                            $embed = get_sub_field('embed');
                            $caption = get_sub_field('caption');
                        ?>
                            <div class="group/swiper-slide swiper-slide">
                                <figure class="w-full aspect-[7/4] md:group-not-[.swiper-slide-active]/swiper-slide:scale-86 transition-transform duration-(--swiper-slide-transition-duration)">
                                    <?php if ( $image ) : ?>
                                        <?php if ( $after_image ) : ?>
                                            <div class="relative size-full js-before-after">
                                                <div class="absolute top-0 left-0 z-1 size-full [clip-path:inset(0_50%_0_0)] select-none js-before-after__before">
                                                    <?php echo wp_get_attachment_image( $image['id'], '1920', false, [
                                                        'class' => 'size-full object-cover',
                                                        'loading' => 'lazy'
                                                    ] ); ?>
                                                    <div class="absolute bottom-0 left-4 text-white md:text-1.5xl font-bold">
                                                        <?php echo esc_html_e('Before', 'blockprint') ?>
                                                    </div>
                                                </div>

                                                <div class="absolute inset-0 select-none">
                                                    <?php echo wp_get_attachment_image( $after_image['id'], '1920', false, [
                                                        'class' => 'size-full object-cover',
                                                        'loading' => 'lazy'
                                                    ] ); ?>
                                                    <div class="absolute bottom-0 right-4 text-white md:text-1.5xl font-bold">
                                                        <?php echo esc_html_e('After', 'blockprint') ?>
                                                    </div>
                                                </div>

                                                <div class="absolute top-0 left-1/2 z-2 h-full w-px bg-white touch-pan-y js-before-after__handle">
                                                    <div class="absolute top-1/2 left-1/1 -translate-1/2 flex items-center justify-center bg-white rounded-full w-14.5 h-8 cursor-ew-resize">
                                                        <svg width="46" height="20" viewBox="0 0 46 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                            <path d="M12.3996 15.0795L7.59961 10.2795L12.3996 5.47949" stroke="#120445" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M33.2 15.0795L38 10.2795L33.2 5.47949" stroke="#120445" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else : ?>
                                            <?php echo wp_get_attachment_image( $image['id'], '1920', false, [
                                                'class' => 'size-full object-cover',
                                                'loading' => 'lazy'
                                            ] ); ?>
                                        <?php endif ?>
                                    <?php elseif ( $embed ) : ?>
                                        <div class="<?php echo esc_attr('size-full [&>iframe]:size-full') ?>">
                                            <?php echo $embed ?>
                                        </div>
                                    <?php else : ?>
                                        <?php get_template_part('partials/placeholder-image'); ?>
                                    <?php endif ?>
                                </figure>

                                <?php if ( $caption ) : ?>
                                    <figcaption class="<?php echo esc_attr('md:group-not-[.swiper-slide-active]/swiper-slide:opacity-0 transition-opacity duration-(--swiper-slide-transition-duration) group-[.swiper-slide-active]/swiper-slide:delay-(--swiper-slide-transition-duration) text-center mt-8 mx-auto max-w-[47rem]') ?>">
                                        <?php echo $caption ?>
                                    </figcaption>
                                <?php endif ?>
                            </div>
                        <?php endwhile ?>
                    </div>

                    <?php get_template_part('partials/swiper-controls', null, [
                        'class_name' => 'mt-6'
                    ] ); ?>
                </div>
            <?php else : ?>
                <div class="w-full aspect-[7/4]">
                    <?php get_template_part('partials/placeholder-image'); ?>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>