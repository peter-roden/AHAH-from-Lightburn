<?php
/**
 * Logo Cloud Block
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

$class_name = build_block_class_name( 'text-center py-12 md:py-16', $block );
$style = build_block_styles( $block );

$heading = get_field('heading');
$logos = get_field('logos');

?>

<div id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '' ?>>
    <?php if ( $heading ) : ?>
        <h2 class="text-base leading-[1.6] mb-10 font-semibold">
            <?php echo $heading ?>
        </h2>
    <?php endif ?>

    <div class="flex flex-wrap items-center justify-center gap-12 md:gap-x-19">
        <?php if ( !empty( $logos ) ) : ?>
            <?php foreach ( $logos as $item ) :
                if ( ! is_array( $item ) ) continue;
                $logo = $item['logo'] ?? null;
                $link = $item['link'] ?? null;
            ?>
                <div class="relative">
                    <?php if ($logo): ?>
                        <?php echo wp_get_attachment_image( $logo['id'], 'medium', false, [
                            'class' => 'w-auto max-w-full h-19.25 object-contain',
                            'loading' => 'lazy'
                        ] ); ?>
                    <?php endif; ?>
                    <?php if ($link): ?>
                        <a href="<?php echo $link['url']; ?>" class="absolute inset-0" target="<?php echo $link['target'] ? $link['target'] : '_self'; ?>" rel="<?php echo $link['target'] === '_blank' ? 'noopener' : ''; ?>">
                            <span class="sr-only"><?php echo $link['title']; ?></span>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endforeach ?>
        <?php else : ?>
            <?php for ( $i = 0; $i < 6; $i++ ) : ?>
                <div class="w-16 aspect-square">
                    <?php get_template_part('partials/placeholder-image'); ?>
                </div>
            <?php endfor ?>
        <?php endif ?>
    </div>
</div>