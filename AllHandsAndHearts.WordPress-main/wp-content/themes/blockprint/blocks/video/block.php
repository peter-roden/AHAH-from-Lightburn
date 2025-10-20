<?php
/**
 * Video Block
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

$class_name = build_block_class_name( 'relative', $block );

$style = build_block_styles( $block );
$placeholder_img = get_field('placeholder_img');
$video_source = get_field('video_source');
?>

<div id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '' ?>>
    <div class="@container relative flex justify-center min-h-178 @2xl:min-h-183 size-full">
        <?php if ( $placeholder_img ) : ?>
            <div class="absolute inset-0">
                <?php echo wp_get_attachment_image( $placeholder_img, 'full', false, [
                    'class' => 'size-full object-cover',
                    'loading' => 'lazy'
                ] ); ?>
            </div>
        <?php else: ?>
            <div class="absolute inset-0">
                <?php echo get_template_part('partials/placeholder-image'); ?>
            </div>
        <?php endif; ?>
        <div class="relative container-wide">
            <div class="z-2 wp-block-button is-style-secondary absolute bottom-6 left-6 @6xl:bottom-10 @6xl:left-10">
                <a href="<?php echo '#' . $anchor . '-video-modal'; ?>" class="wp-block-button__link has-sm-font-size has-custom-font-size wp-element-button rounded-full! gap-x-1 hover:bg-white/70! gap-x-1! data-[state=hidden]:hidden! js-video-modal-btn">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor" aria-hidden="true">
                        <polygon points="5 3 19 12 5 21 5 3"/>
                    </svg>
                    Play the Video
                </a>
            </div>
            <?php if ( !$is_preview ) : ?>
                <?php $video_html = $video_source=='embed' ? get_field('embed') : '<video class="size-full object-cover" preload="none" data-src="' . wp_get_attachment_url(get_field('video_file')['id']) . '" playsinline controls></video>'; ?>
                <?php get_template_part('partials/modal', null, [
                    'id' => $anchor . '-video-modal',
                    'is_preview' => $is_preview,
                    'bg_color' => 'bg-transparent',
                    'html' => $video_html
                ] ); ?>
            <?php endif; ?>
        </div>
    </div>
</div>