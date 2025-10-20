<?php
/**
 * Mantra Block
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
$text = get_field('text');
$cta_link = get_field('cta_link');
$video = get_field('video');
?>

<div id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '' ?>>
    <div class="grid @4xl:grid-cols-2 border-t border-purple-950/10 @4xl:border-t-0">
        <div class="order-1 @4xl:order-2 py-20 @4xl:py-6 px-(--container-spacing-x) @4xl:px-12 @7xl:px-16 self-center">
            <div class="@4xl:max-w-[590px]">
                <?php if ( $heading ) : ?>
                    <h2 class="text-display-1 lg:text-display-2 @6xl:text-display-1 text-balance mb-12 @4xl:mb-16">
                        <?php echo $heading ?>
                    </h2>
                <?php endif ?>

                <?php if ( $text || $cta_link ) : ?>
                    <div class="space-y-8 pl-10 @4xl:pl-24">
                        <?php if ( $text ) : ?>
                            <div class="text-lg">
                                <?php echo $text ?>
                            </div>
                        <?php endif ?>
                        
                        <?php if ( $cta_link ) {
                            get_template_part( 'partials/cta-link', null, [
                                'link' => $cta_link
                            ] );
                        } ?>
                    </div>
                <?php endif ?>
            </div>
        </div>
        <div class="order-2 @4xl:order-1">
            <div class="relative bg-neutral-100 w-full h-[610px] @4xl:h-auto @4xl:aspect-square js-video-container">
                <?php if ( $video ) : ?>
                    <video class="size-full object-cover js-video" preload="none" data-src="<?php echo wp_get_attachment_url($video['id']) ?>" autoplay playsinline muted loop></video>
                    <div class="wp-block-button is-style-secondary absolute bottom-6 left-6 @6xl:bottom-10 @6xl:left-10">
                        <button class="wp-block-button__link has-sm-font-size has-custom-font-size wp-element-button rounded-full! hover:bg-white/70! gap-x-1! data-[state=hidden]:hidden! js-video-pause" data-state="visible">
                            <span class="flex items-center justify-center size-6">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <rect x="7" y="5" width="3" height="14"/>
                                    <rect x="14" y="5" width="3" height="14"/>
                                </svg>
                            </span>
                            Pause <span class="sr-only">video</span>
                        </button>
                        <button class="wp-block-button__link has-sm-font-size has-custom-font-size wp-element-button rounded-full! hover:bg-white/70! gap-x-1! data-[state=hidden]:hidden! js-video-play" data-state="hidden">
                            <span class="flex items-center justify-center size-6">
                                <svg width="18" height="16" viewBox="0 0 18 16" fill="currentColor" aria-hidden="true">
                                    <path d="M3.75 2L14.25 8L3.75 14V2Z"/>
                                </svg>
                            </span>
                            Play <span class="sr-only">video</span>
                        </button>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>