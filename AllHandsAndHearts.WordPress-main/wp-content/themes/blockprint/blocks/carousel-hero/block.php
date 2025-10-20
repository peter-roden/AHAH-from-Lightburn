<?php
/**
 * Carousel Hero Block
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

$class_name = build_block_class_name( '@container text-white', $block );

$style = build_block_styles( $block );
?>

<header id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '' ?>>
    <div class="group/swiper swiper js-carousel-hero-swiper" data-swiper-autoplay="true">
        <?php if ( have_rows('slides') ) : ?>
            <div class="swiper-wrapper">
                <?php while ( have_rows('slides') ) : the_row();
                    $heading = get_sub_field('heading');
                    $button_link = get_sub_field('button_link');
                    $cta_link = get_sub_field('cta_link');
                    $bg_media = get_sub_field('bg_media');
                ?>
                    <div class="swiper-slide relative flex items-end min-h-[100svh]">
                        <div class="absolute top-0 left-0 -z-1 size-full">
                            <?php if ( $bg_media ) {
                                if ( $bg_media['mime_type'] === 'video/mp4' ) {
                                    echo '<video class="size-full object-cover" preload="none" data-src="' . wp_get_attachment_url($bg_media['id']) . '" autoplay playsinline muted loop></video>';
                                } else {
                                    echo wp_get_attachment_image( $bg_media['id'], '1920', false, [
                                        'class' => 'size-full object-cover',
                                        'loading' => get_row_index() > 1 ? 'lazy' : ''
                                    ] );
                                }
                            } ?>
                            <div class="absolute top-0 left-0 size-full bg-[linear-gradient(180deg,rgba(0,0,0,0)60%,rgba(0,0,0,.2)70%,rgba(0,0,0,.5)95%)]"></div>
                        </div>

                        <div class="w-full bg-linear-to-b from-transparent to-black/50 pt-5 pb-16">
                            <div class="container-wide grid @4xl:grid-cols-2 gap-x-4 @4xl:py-8.5">
                                <div class="flex flex-col gap-y-8">
                                    <h1 class="text-display-3 mb-0">
                                        <?php echo $heading ?>
                                    </h1>

                                    <?php if ( $button_link || $cta_link ) : ?>
                                        <div class="flex flex-wrap items-center gap-y-4 gap-x-6">
                                            <?php if ( $button_link ) : ?>
                                                <div class="wp-block-button">
                                                    <a class="wp-block-button__link wp-element-button @4xl:text-lg @4xl:min-h-16! @4xl:px-8!" href="<?php echo $button_link['url'] ?>"<?php echo $button_link['target'] === '_blank' ? ' target="_blank" rel="noopener noreferrer"' : '' ?>>
                                                        <?php echo $button_link['title'] ?>
                                                    </a>
                                                </div>
                                            <?php endif ?>

                                            <?php if ( $cta_link ) : ?>
                                                <div>
                                                    <?php get_template_part( 'partials/cta-link', null, [
                                                        'link' => $cta_link,
                                                        'mode' => 'dark',
                                                        'class_name' => 'hover:text-purple-500!'
                                                    ] ); ?>
                                                </div>
                                            <?php endif ?>
                                        </div>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile ?>
            </div>
        <?php endif ?>

        <div class="absolute bottom-0 @4xl:bottom-16 right-0 z-1 w-full @4xl:w-1/2 pb-5 @4xl:pb-8.5 px-(--container-spacing-x) @4xl:pl-0">
            <div class="flex items-center @4xl:items-start gap-x-6 @4xl:w-full @4xl:max-w-[calc(var(--wide-width)/2)] @4xl:pl-6">
                <div class="flex grow-1 w-auto gap-2.5 @4xl:grid @4xl:grid-cols-3 @4xl:gap-6 js-carousel-hero-swiper__pagination">
                    <?php while ( have_rows('slides') ) :
                        the_row();
                        $heading = get_sub_field('heading');
                    ?>
                        <button class="group/swiper-pagination-button flex flex-col gap-y-2.5 w-2 h-2 @4xl:h-auto aria-current:w-6 @4xl:w-full! text-left cursor-pointer" aria-label="Go to slide <?php the_row_index() ?>">
                            <div class="relative h-full @4xl:h-[0.125rem] bg-white/50 rounded-full overflow-hidden @4xl:overflow-visible w-full">
                                <div class="absolute top-0 @4xl:-top-0.25 left-0 h-full @4xl:h-1 bg-white rounded-full js-carousel-hero-swiper__pagination-button-progress-bar"></div>
                            </div>

                            <div class="hidden @4xl:flex items-center gap-4 grow">
                                <div class="text-h6 mb-0">
                                    0<?php the_row_index() ?>
                                </div>
                                <div class="line-clamp-2 group-aria-current/swiper-pagination-button:font-bold">
                                    <?php echo $heading ?>
                                </div>
                            </div>
                        </button>
                    <?php endwhile ?>
                </div>

                <div class="swiper-pagination hidden"></div>

                <div class="flex items-center gap-x-6 shrink-0 ms-auto">
                    <button class="swiper-button-prev @4xl:hidden">
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <polyline points="15 18 9 12 15 6"></polyline>
                        </svg>
                    </button>
                    <button class="swiper-button-next @4xl:hidden">
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </button>
                    <div>
                        <button type="button" class="hidden group-data-[swiper-autoplay=true]/swiper:flex items-center justify-center size-6 cursor-pointer js-carousel-hero-swiper__pause-button" aria-label="Pause">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <rect x="7" y="5" width="3" height="14"/>
                                <rect x="14" y="5" width="3" height="14"/>
                            </svg>
                        </button>
                        <button type="button" class="hidden group-data-[swiper-autoplay=false]/swiper:flex items-center justify-center size-6 cursor-pointer js-carousel-hero-swiper__play-button" aria-label="Play">
                            <svg width="18" height="16" viewBox="0 0 18 16" fill="currentColor" aria-hidden="true">
                                <path d="M3.75 2L14.25 8L3.75 14V2Z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>