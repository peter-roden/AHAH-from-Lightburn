<?php
/**
 * Page Header Block
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

$class_name = build_block_class_name( 'relative bg-secondary text-white overflow-hidden', $block );

$style = build_block_styles( $block );

$heading = get_field( 'heading' );
$text = get_field( 'text' );
$cta_button = get_field( 'cta_button' );
$secondary_cta_button = get_field( 'secondary_cta_button' );
$video = get_field( 'video' );
$video_transcript = get_field( 'video_transcript' );
$include_breadcrumbs = get_field( 'include_breadcrumbs' );
?>

<div id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '' ?>>
    <?php if ( $include_breadcrumbs ) : ?>
        <div class="absolute top-4 inset-x-0">
            <div class="yoast-breadcrumbs container-wide text-white [&_.breadcrumb\_last]:text-white/70">
                <?php echo do_shortcode('[wpseo_breadcrumb]') ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="pt-22 lg:pt-30 <?php echo $video ? 'pb-12 lg:pb-16' : 'pb-18 lg:pb-20'; ?> ">
        <div class="container-wide">
            <h1 class="mb-0 lg:px-5 text-center text-balance text-display-1 text-[clamp(4.5rem,20vw,10rem)]! [word-break:break-word]">
                <?php echo esc_html($heading); ?>
            </h1>

            <?php if ( $text ) : ?>
                <p class="mx-auto max-w-227.5 mt-8 lg:mt-10 text-center text-xl font-bold">
                    <?php echo $text; ?>
                </p>
            <?php endif; ?>

            <?php if ( $cta_button || $secondary_cta_button ) : ?>
                <div class="flex flex-col items-center gap-6 mt-10 lg:mt-12">
                    <?php if ( $cta_button ) : ?>
                        <div class="wp-block-buttons">
                            <div class="wp-block-button is-style-white">
                                <a class="wp-element-button wp-block-button__link" href="<?php echo esc_url( $cta_button['url'] ); ?>"<?php echo $cta_button['target'] === '_blank' ? ' target="_blank" rel="noopener noreferrer"' : '' ?>">
                                    <?php echo $cta_button['title']; ?>
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ( $secondary_cta_button ) {                        
                        get_template_part('partials/cta-link', null, [
                            'link' => $secondary_cta_button,
                            'mode' => 'dark',
                        ]);
                    } ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if ( $video ) : ?>
        <div class="w-full h-fit bg-linear-[to_bottom,var(--color-secondary),var(--color-secondary)_50%,white_50%]">
            <div class="container-wide relative w-full min-h-132.5 aspect-video bg-black js-video-container">
                <video class="size-full object-cover js-video" preload="none" data-src="<?php echo wp_get_attachment_url($video['id']) ?>" autoplay playsinline muted loop></video>
                <div class="wp-block-button is-style-secondary absolute bottom-4 left-4 lg:bottom-8 lg:left-8 xl:bottom-10 xl:left-10">
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
                <div class="wp-block-button is-style-secondary absolute bottom-4 right-4 lg:bottom-8 lg:right-8 xl:bottom-10 xl:right-10">
                    <a href="<?php echo '#' . $anchor . '-video-modal'; ?>"  class="wp-block-button__link has-sm-font-size has-custom-font-size wp-element-button rounded-full! hover:bg-white/70! gap-x-1! data-[state=hidden]:hidden! js-video-modal-btn">
                        Watch With Audio 
                    </a>
                </div>
                <?php
                    $video_html = '<video class="size-full object-cover js-modal-video" preload="none" data-src="' . wp_get_attachment_url($video['id']) . '" playsinline controls></video>';
                    if ( $video_transcript ) {
                        $video_transcript_title = $video_transcript['title'] ? $video_transcript['title'] : 'Read Transcript';
                        $video_transcript_target = $video_transcript['target'] ? $video_transcript['target'] : '_blank';
                        $video_transcript_html = '<div class="absolute top-0 lg:-left-5"><div class="wp-block-button is-style-white"><a href="' . $video_transcript['url'] . ' " target="' . $video_transcript_target . '_blank' .'" class="wp-block-button__link has-sm-font-size wp-element-button rounded-full!">' . $video_transcript_title . '</a></div></div>';
                        $video_html = $video_transcript_html . $video_html;
                    }
                ?>
                <?php if (!is_preview()) : ?>
                    <?php get_template_part('partials/modal', null, [
                        'id' => $anchor . '-video-modal',
                        'is_preview' => $is_preview,
                        'bg_color' => 'bg-transparent',
                        'html' => $video_html
                    ] ); ?>
                <?php endif; ?>
            </div>
        </div>
    <?php endif ?>
</div>