<?php
/**
 * XXL CTA Banner Block
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

$class_name = build_block_class_name( 'relative z-0 bg-neutral-100 overflow-hidden', $block );

$style = build_block_styles( $block );

$heading = get_field('heading');
$button_link = get_field('button_link');
$button_link_2 = get_field('button_link_2');
$bg_image = get_field('bg_image');
$mobile_bg_image = get_field('mobile_bg_image');
?>

<div id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '' ?>>
    <?php if ( $bg_image ) : ?>
        <picture>
            <?php if ( $mobile_bg_image ) : ?>
                <source srcset="<?php echo $mobile_bg_image['url'] ?>" media="(width<768px)">
            <?php endif ?>            
            <?php echo wp_get_attachment_image( $bg_image['id'], '1920', false, [
                'loading' => 'lazy',
                'class' => 'absolute inset-0 -z-1 size-full object-cover'
            ] ); ?>
        </picture>
    <?php endif ?>

    <div class="flex flex-col justify-center gap-y-10 @container container-wide h-[804px] text-center ">
        <?php if ( $heading ) : ?>
            <h2 class="text-display-1 text-white w-full drop-shadow-[0_0_34px_rgba(0,0,0,.8),0_0_245px_rgba(0,0,0,.6),0_0_368px_rgba(0,0,0,1)] text-[clamp(calc(104rem/16),12cqw,11rem)] mb-0">
                <?php echo $heading ?>
            </h2>
        <?php endif ?>

        <?php if ( $button_link || $button_link_2 ) : ?>
            <div class="relative flex flex-wrap justify-center gap-4">
                <?php if ( $button_link ) : ?>
                    <div class="wp-block-button">
                        <a class="wp-block-button__link wp-element-button min-w-50" href="<?php echo $button_link['url'] ?>"<?php echo $button_link['target'] === '_blank' ? ' target="_blank" rel="noopener noreferrer"' : '' ?>>
                            <?php echo $button_link['title'] ?>
                        </a>
                    </div>
                <?php endif ?>

                <?php if ( $button_link_2 ) : ?>
                    <div class="wp-block-button is-style-white">
                        <a class="wp-block-button__link wp-element-button min-w-50" href="<?php echo $button_link_2['url'] ?>"<?php echo $button_link_2['target'] === '_blank' ? ' target="_blank" rel="noopener noreferrer"' : '' ?>>
                            <?php echo $button_link_2['title'] ?>
                        </a>
                    </div>
                <?php endif ?>
            </div>
        <?php endif ?>
    </div>
</div>