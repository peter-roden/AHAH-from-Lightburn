<?php
/**
 * Donate Hero Block
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

$class_name = build_block_class_name( 'relative @container ', $block );

$style = build_block_styles( $block );

$bg_image = get_field('bg_image');
$bg_image_mobile = get_field('bg_image_mobile');
$heading = get_field('heading');
$content = get_field('content');
$button_link = get_field('button_link');
$form_caption = get_field('form_caption');
$form_embed = get_field('form_embed');

?>

<header id="<?php echo esc_attr($anchor) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr($style) . '"' : '' ?>>
    <div class="hidden @2xl:block absolute top-0 left-0 z-0 size-full">
        <?php if (!empty($bg_image)) : ?>
            <picture>
                <?php if ($bg_image_mobile) : ?>
                    <source srcset="<?php echo $bg_image_mobile['url']; ?>" media="(max-width: 767px)">
                <?php endif; ?>
                <img
                    width="<?php echo esc_attr($bg_image['sizes']['1920-width']); ?>"
                    height="<?php echo esc_attr($bg_image['sizes']['1920-height']); ?>"
                    src="<?php echo esc_url($bg_image['sizes']['1920']); ?>"
                    alt="<?php echo esc_attr($bg_image['alt']); ?>"
                    class="size-full object-cover"
                    loading="lazy"
                >
            </picture>
        <?php else: ?>
            <?php echo get_template_part('partials/placeholder-image') ?>;
        <?php endif ?>
    </div>
    <div class="hidden @2xl:block bg-black/25 absolute inset-0"></div>

    <div class="container-wide ">
        <div class="relative @2xl:py-10 hidden @2xl:grid grid-cols-2 gap-4">
            <div class="col-span-1 text-white flex flex-col justify-center items-start gap-10">
                <?php if ($heading): ?>
                    <h1 class="text-[clamp(4.5rem,15vw,10rem)]! text-display-1"><?php echo $heading; ?></h1>
                <?php endif; ?>
                <?php if ($content): ?>
                    <div>
                        <?php echo $content; ?>
                    </div>
                <?php endif; ?>
                <?php if ($button_link): ?>
                    <div class="wp-block-buttons">
                        <div class="wp-block-button is-style-white">
                            <a href="<?php echo $button_link['url']; ?>" class="wp-block-button__link wp-element-button" <?php echo $button_link['target'] === '_blank' ? ' target="_blank" rel="noopener noreferrer"' : '' ?>>
                                <?php echo $button_link['title']; ?>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-span-1">
                <div class="max-w-[421px] mx-auto bg-white rounded-2xl mb-6">
                    <?php if ($form_embed): ?>
                        <div>
                            <?php echo $form_embed; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if ($form_caption): ?>
                    <div class="text-xs text-white">
                        <?php echo $form_caption; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="relative block @2xl:hidden">
            <?php if ($heading): ?>
                <h1 class="text-center mb-6 text-display-1"><?php echo $heading; ?></h1>
            <?php endif; ?>
            <div class="mx-auto bg-white rounded-2xl p-1 mb-6 border">
                <?php if ($form_embed): ?>
                    <div>
                        <?php echo $form_embed; ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php if ($button_link): ?>
                <div class="wp-block-buttons flex justify-center mb-6">
                    <div class="wp-block-button is-style-outline">
                        <a href="<?php echo $button_link['url']; ?>" class="wp-block-button__link wp-element-button" <?php echo $button_link['target'] === '_blank' ? ' target="_blank" rel="noopener noreferrer"' : '' ?>>
                            <?php echo $button_link['title']; ?>
                        </a>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($form_caption): ?>
                <div class="text-xs text-purple-950/70 text-center">
                    <?php echo $form_caption; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="block @2xl:hidden relative size-full mt-12">
        <?php if (!empty($bg_image)) : ?>
            <picture>
                <?php if ($bg_image_mobile) : ?>
                    <source srcset="<?php echo wp_get_attachment_image_url( $bg_image_mobile['id'], 'medium_large' ) ?>" media="(width < 768px)">
                <?php endif ?>
                <?php echo wp_get_attachment_image( $bg_image['id'], '1920', false, [
                    'class' => 'size-full object-cover aspect-square',
                ] ); ?>
            </picture>
        <?php else: ?>
            <?php echo get_template_part('partials/placeholder-image') ?>;
        <?php endif ?>
    </div>
</header>