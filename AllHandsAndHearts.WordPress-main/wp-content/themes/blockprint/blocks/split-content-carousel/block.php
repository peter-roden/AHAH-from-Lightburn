<?php
/**
 * Split Content Carousel Block
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

$heading = get_field('heading' );
$button_link = get_field('button_link');

$style = build_block_styles( $block );
?>

<div id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '' ?>>
    <div class="container-wide @container">
        <div class="flex flex-col gap-y-10 @6xl:gap-y-20 py-24 @6xl:py-35">
            <?php if ( $heading ) : ?>
                <h2 class="text-display-1 text-center mb-0">
                    <?php echo $heading; ?>
                </h2>
            <?php endif; ?>

            <?php if ( have_rows('slides') ) : ?>
                <div class="relative hidden @2xl:block">
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-6 @6xl:col-span-5 self-center">
                            <div class="swiper js-swiper" data-options='{
                                "allowTouchMove": false,
                                "effect": "fade",
                                "fadeEffect": {
                                    "crossFade": true
                                },
                                "navigation": {
                                    "nextEl": ".<?php echo esc_attr( $anchor ) ?>-swiper-button-next",
                                    "prevEl": ".<?php echo esc_attr( $anchor ) ?>-swiper-button-prev"
                                },
                                "pagination": {
                                    "el": ".<?php echo esc_attr( $anchor ) ?>-swiper-pagination",
                                    "bulletElement": "button",
                                    "clickable": true
                                },
                                "speed": 500,
                            }'>
                                <div class="swiper-wrapper">
                                    <?php while ( have_rows('slides') ) :
                                        the_row();
                                        $heading = get_sub_field('heading');
                                        $text = get_sub_field('text');
                                    ?>
                                        <div class="swiper-slide flex flex-col gap-y-6 @4xl:gap-y-10">
                                            <?php if ( $heading ) : ?>
                                                <h3 class="max-w-[11.333em] mb-0">
                                                    <?php echo $heading ?>
                                                </h3>
                                            <?php endif ?>

                                            <?php if ( $text ) : ?>
                                                <div class="px-10 @4xl:px-16">
                                                    <?php echo $text ?>
                                                </div>
                                            <?php endif ?>
                                        </div>
                                    <?php endwhile ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-span-5 col-start-7 [clip-path:polygon(500%_0,500%_100%,0_100%,0_0)]">
                            <div class="swiper [.swiper-initialized]:overflow-visible @6xl:pr-6 js-swiper" data-options='{
                                "allowTouchMove": false,
                                "spaceBetween": 32,
                                "navigation": {
                                    "nextEl": ".<?php echo esc_attr( $anchor ) ?>-swiper-button-next",
                                    "prevEl": ".<?php echo esc_attr( $anchor ) ?>-swiper-button-prev"
                                },
                                "pagination": {
                                    "el": ".<?php echo esc_attr( $anchor ) ?>-swiper-pagination",
                                    "bulletElement": "button",
                                    "clickable": true
                                },
                                "speed": 500,
                            }'>
                                <div class="swiper-wrapper">
                                    <?php while ( have_rows('slides') ) :
                                        the_row();
                                        $image = get_sub_field('image');
                                    ?>
                                        <div class="swiper-slide">
                                            <div class="w-full aspect-square bg-neutral-100">
                                                <?php if ( $image ) {
                                                    echo wp_get_attachment_image( $image['id'], 'large', false, [
                                                        'loading' => 'lazy',
                                                        'class' => 'size-full object-cover'
                                                    ] );
                                                } ?>
                                            </div>
                                        </div>
                                    <?php endwhile ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="@5xl:absolute bottom-0 left-0 flex items-center justify-center gap-6 mt-10 has-[.swiper-button-lock]:hidden">
                        <button class="<?php echo esc_attr( $anchor ) ?>-swiper-button-prev swiper-button-prev  text-purple-950/50 not-disabled:hover:text-purple-950 not-disabled:cursor-pointer transition-colors shrink-0">
                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <polyline points="15 18 9 12 15 6"></polyline>
                            </svg>
                        </button>
                        <div class="<?php echo esc_attr($anchor . '-swiper-pagination swiper-pagination [counter-reset:section] flex flex-wrap justify-center gap-2.5 [&_.swiper-pagination-bullet]:size-8 [&_.swiper-pagination-bullet]:rounded-full [&_.swiper-pagination-bullet]:text-sm [&_.swiper-pagination-bullet]:font-bold [&_.swiper-pagination-bullet]:cursor-pointer [&_.swiper-pagination-bullet]:transition-colors [&_.swiper-pagination-bullet-active]:bg-purple-100 [&_.swiper-pagination-bullet::before]:[counter-increment:section] [&_.swiper-pagination-bullet::before]:[content:counter(section,decimal-leading-zero)]') ?>"></div>
                        <button class="<?php echo esc_attr( $anchor ) ?>-swiper-button-next swiper-button-next  text-purple-950/50 not-disabled:hover:text-purple-950 not-disabled:cursor-pointer transition-colors shrink-0">
                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="swiper w-full @2xl:hidden js-swiper" data-options='{
                    "spaceBetween": 20,
                    "navigation": {
                        "nextEl": ".<?php echo esc_attr( $anchor ) ?>1-swiper-button-next",
                        "prevEl": ".<?php echo esc_attr( $anchor ) ?>1-swiper-button-prev"
                    },
                    "pagination": {
                        "el": ".<?php echo esc_attr( $anchor ) ?>1-swiper-pagination",
                        "bulletElement": "button",
                        "clickable": true
                    },
                    "speed": 500,
                }'>
                    <div class="swiper-wrapper">
                        <?php while ( have_rows('slides') ) :
                            the_row();
                            $heading = get_sub_field('heading');
                            $text = get_sub_field('text');
                            $image = get_sub_field('image');
                        ?>
                            <div class="swiper-slide flex flex-col gap-y-10">
                                <div class="w-full aspect-square bg-neutral-100">
                                    <?php if ( $image ) {
                                        echo wp_get_attachment_image( $image['id'], 'medium', false, [
                                            'loading' => 'lazy',
                                            'class' => 'size-full object-cover'
                                        ] );
                                    } ?>
                                </div>

                                <?php if ( $heading || $text ) : ?>
                                    <div class="flex flex-col gap-y-6">
                                        <?php if ( $heading ) : ?>
                                            <h3 class="mb-0">
                                                <?php echo $heading ?>
                                            </h3>
                                        <?php endif ?>

                                        <?php if ( $text ) : ?>
                                            <div class="px-10">
                                                <?php echo $text ?>
                                            </div>
                                        <?php endif ?>
                                    </div>
                                <?php endif ?>
                            </div>
                        <?php endwhile ?>
                    </div>

                    <div class="flex items-center justify-between @lg:justify-center gap-6 mt-10 has-[.swiper-button-lock]:hidden">
                        <button class="<?php echo esc_attr( $anchor ) ?>1-swiper-button-prev swiper-button-prev text-purple-950/50 not-disabled:hover:text-purple-950 not-disabled:cursor-pointer transition-colors shrink-0">
                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <polyline points="15 18 9 12 15 6"></polyline>
                            </svg>
                        </button>
                        <div class="<?php echo esc_attr($anchor . '1-swiper-pagination swiper-pagination [counter-reset:section] flex flex-wrap justify-center gap-2.5 [&_.swiper-pagination-bullet]:size-8 [&_.swiper-pagination-bullet]:rounded-full [&_.swiper-pagination-bullet]:text-sm [&_.swiper-pagination-bullet]:font-bold [&_.swiper-pagination-bullet]:cursor-pointer [&_.swiper-pagination-bullet]:transition-colors [&_.swiper-pagination-bullet-active]:bg-purple-100 [&_.swiper-pagination-bullet::before]:[counter-increment:section] [&_.swiper-pagination-bullet::before]:[content:counter(section,decimal-leading-zero)]') ?>"></div>
                        <button class="<?php echo esc_attr( $anchor ) ?>1-swiper-button-next swiper-button-next text-purple-950/50 not-disabled:hover:text-purple-950 not-disabled:cursor-pointer transition-colors shrink-0">
                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </button>
                    </div>
                </div>
            <?php elseif ( $is_preview ) : ?>
                <div class="@2xl:grid @2xl:grid-cols-12 gap-4">
                    <div class="@2xl:col-span-5 @2xl:col-start-7 @2xl:order-2">
                        <div class="w-full aspect-square">
                            <?php get_template_part('partials/placeholder-image'); ?>
                        </div>
                    </div>
                    <div class="@2xl:col-span-6 @6xl:col-span-5 @2xl:order-1"></div>
                </div>
            <?php endif ?>

            <?php if ( $button_link ) : ?>
                <div class="text-center mt-4 @6xl:mt-0">
                    <div class="wp-block-button">
                        <a class="wp-block-button__link wp-element-button" href="<?php echo $button_link['url'] ?>"<?php echo $button_link['target'] === '_blank' ? ' target="_blank" rel="noopener noreferrer"' : '' ?>>
                            <?php echo $button_link['title'] ?>
                        </a>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>