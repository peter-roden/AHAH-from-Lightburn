<?php
/**
 * Social Media Videos Block
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

$class_name = build_block_class_name( '@container flex flex-col gap-y-8', $block );

$style = build_block_styles( $block );

$heading = get_field('heading');
?>

<div id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '' ?>>
    <div class="flex flex-col @2xl:flex-row items-center gap-6 text-center @2xl:text-left w-full">
        <?php if ( $heading ) : ?>
            <h2 class="text-h4 mb-0 grow">
                <?php echo $heading ?>
            </h2>
        <?php endif ?>

        <?php if ( have_rows('social_media_links', 'option') ) : ?>
            <div class="flex flex-col @2xl:flex-row items-center gap-4 text-primary shrink-0 @2xl:ml-auto">
                Follow us
                <div class="flex flex-wrap gap-y-2 gap-x-6 @2xl:gap-x-2 items-center">
                    <?php while ( have_rows('social_media_links', 'option') ) : the_row(); ?>
                        <?php
                            $link = get_sub_field('link');
                            $svg_code = get_sub_field('svg_code');
                        ?>
                        <a aria-label="<?php echo $link['title'] ?> (opends in new tab)" class="block text-current [&_svg]:h-8 [&_svg]:w-auto" href="<?php echo $link['url'] ?>" target="_blank" rel="noopener noreferrer">
                            <?php echo $svg_code ?: $link['title']; ?>
                        </a>
                    <?php endwhile ?>
                </div>
            </div>
        <?php endif ?>
    </div>

    <div class="w-full">
        <?php if ( have_rows('videos') ) : ?>
            <div class="<?php echo $is_preview ? '' : esc_html('overflow-hidden mx-[calc(-1*var(--container-spacing-x))] @2xl:mx-0') ?>">
                <div class="<?php echo $is_preview ? '' : esc_html('swiper overflow-visible pl-(--container-spacing-x) pr-12 @2xl:px-0 js-swiper') ?>" data-options='{
                    "spaceBetween": 24,
                    "navigation": {
                        "nextEl": ".swiper-button-next",
                        "prevEl": ".swiper-button-prev"
                    },
                    "pagination": {
                        "el": ".swiper-pagination",
                        "bulletElement": "button",
                        "clickable": true
                    },
                    "breakpointsBase": "container",
                    "breakpoints": {
                        "480": {
                            "slidesPerView": 2,
                            "spaceBetween": 24
                        },
                        "576": {
                            "slidesPerView": 3,
                            "spaceBetween": 24
                        },
                        "768": {
                            "slidesPerView": 4,
                            "spaceBetween": 24
                        },
                        "1024": {
                            "slidesPerView": 4,
                            "spaceBetween": 32
                        }
                    }
                }'>
                    <div class="<?php echo $is_preview ? 'grid grid-cols-4 gap-x-6' : esc_html('swiper-wrapper') ?>">
                        <?php while ( have_rows('videos') ) :
                            the_row();
                            $image = get_sub_field('image');
                            $link = get_sub_field('link');
                        ?>
                            <div class="swiper-slide space-y-4 relative group @container">
                                <figure class="w-full aspect-[3/4]">
                                    <?php if ( $image ) {
                                        echo wp_get_attachment_image( $image['id'], 'medium_large', false, [
                                            'loading' => 'lazy',
                                            'class' => 'size-full object-cover'
                                        ] );
                                    } else {
                                        echo get_template_part('partials/placeholder-image');
                                    } ?>
                                </figure>

                                <div class="z-2 wp-block-button is-style-secondary absolute bottom-6 @6xl:bottom-10 left-6 @6xl:bottom-10">
                                    <button class="wp-block-button__link has-sm-font-size has-custom-font-size wp-element-button rounded-full! group-hover:text-purple-950! group-hover:bg-white/70! gap-x-1!">
                                        <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor" aria-hidden="true">
                                            <polygon points="5 3 19 12 5 21 5 3"/>
                                        </svg>
                                        Play <span class="sr-only">video</span>
                                    </button>
                                </div>
                                
                                <?php if ( $link ) : ?>
                                    <a class="<?php echo esc_html('text-current! no-underline!' . ($is_preview ? '' : ' after:absolute after:inset-0')) ?>" href="<?php echo $link['url'] ?>"<?php echo $link['target'] == '_blank' ? ' target="_blank" rel="noopener noreferrer"' : '' ?>>
                                        <?php echo $link['title'] ?>
                                    </a>
                                <?php endif ?>
                            </div>
                        <?php endwhile ?>
                    </div>

                    <?php get_template_part('partials/swiper-controls', null, [
                        'class_name' => 'mt-8'
                    ] ); ?>
                </div>
            </div>
        <?php elseif ( $is_preview ) : ?>
            <div class="grid grid-cols-4 gap-x-6">
                <?php for ( $i = 0; $i < 4; $i++ ) : ?>
                    <div class="w-full aspect-[3/4]">
                        <?php echo get_template_part('partials/placeholder-image'); ?>
                    </div>
                <?php endfor ?>
            </div>
        <?php endif ?>
    </div>
</div>