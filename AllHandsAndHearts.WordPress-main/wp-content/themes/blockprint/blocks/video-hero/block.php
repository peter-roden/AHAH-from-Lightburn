<?php
/**
 * Video Hero Block
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

$class_name = build_block_class_name( 'relative text-white text-center h-svh', $block );

$style = build_block_styles( $block );

$video = get_field('video');
$overline = get_field('overline');
$heading = get_field('heading');
$show_scroll_button = get_field('show_scroll_button');
?>

<div id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '' ?>>
    <div class="@container relative flex justify-center min-h-178 @2xl:min-h-183 size-full after:absolute after:inset-0 after:bg-gradient-to-t after:from-black/60 after:to-transparent">
        <div class="absolute inset-0 js-video-container">
            <?php if ( $video ) : ?>
                <video class="size-full object-cover js-video" src="<?php echo esc_url($video['url']); ?>" autoplay muted loop playsinline></video>

                <div class="relative container-wide">
                    <div class="z-2 wp-block-button is-style-secondary absolute bottom-6 @6xl:bottom-10 left-0">
                        <button class="wp-block-button__link has-sm-font-size has-custom-font-size wp-element-button rounded-full! hover:bg-white/70! gap-x-1! data-[state=hidden]:hidden! js-video-pause" data-state="visible">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <rect x="7" y="5" width="3" height="14"/>
                                <rect x="14" y="5" width="3" height="14"/>
                            </svg>
                            Pause <span class="sr-only">video</span>
                        </button>

                        <button class="wp-block-button__link has-sm-font-size has-custom-font-size wp-element-button rounded-full! hover:bg-white/70! gap-x-1! data-[state=hidden]:hidden! js-video-play" data-state="hidden">
                            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor" aria-hidden="true">
                                <polygon points="5 3 19 12 5 21 5 3"/>
                            </svg>
                            Play <span class="sr-only">video</span>
                        </button>
                    </div>

                    <?php /* <div class="z-2 wp-block-button is-style-secondary absolute bottom-6 @6xl:bottom-10 right-0">
                        <a href="<?php echo '#' . $anchor . '-video-modal'; ?>" class="wp-block-button__link has-sm-font-size has-custom-font-size wp-element-button rounded-full! hover:bg-white/70! gap-x-1! data-[state=hidden]:hidden! js-video-modal-btn">
                            Watch With Audio 
                        </a>
                    </div>

                    <?php if ( !$is_preview ) : ?>
                        <?php $video_html = '<video class="size-full object-cover" preload="none" data-src="' . wp_get_attachment_url($video['id']) . '" playsinline controls></video>'; ?>
                        <?php get_template_part('partials/modal', null, [
                            'id' => $anchor . '-video-modal',
                            'is_preview' => $is_preview,
                            'bg_color' => 'bg-transparent',
                            'html' => $video_html
                        ] ); ?>
                    <?php endif; */ ?>
                </div>
            <?php endif; ?>
        </div>

        <?php if ( $heading ) : ?>
            <h1 class="container-wide text-balance text-display-1 text-[clamp(6.5625rem,16vw,12rem)]! leading-[.9] w-full z-1 mt-auto mb-20 @2xl:mb-14">
                <?php echo esc_html($heading); ?>
            </h1>
        <?php endif; ?>
    </div>
    
    <?php if ( $show_scroll_button ) : ?>
        <a class="z-1 absolute bottom-4 left-1/2 flex items-center justify-center rounded-full text-current! size-10 -translate-x-1/2" href="#<?php echo esc_attr($anchor) ?>_after" aria-label="Scroll down">
            <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <polyline points="19 12 12 19 5 12"></polyline>
            </svg>
        </a>
        <div id="<?php echo esc_attr($anchor) ?>_after"></div>
    <?php endif ?>
</div>