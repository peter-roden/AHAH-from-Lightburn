<?php
/**
 * CTA Link Block
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

$class_name = build_block_class_name( '', $block );

$text_color = $block['textColor'] ?? '';
if ( !$text_color ) {
    $text_color = 'purple-950';
}

$style = build_block_styles( $block );

$link = get_field('link') ?: ['title' => 'CTA Link', 'url' => '#'];
$arrow_position = get_field('arrow_position');
?>

<div id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr($style) . '"' : '' ?>>
    <?php get_template_part( 'partials/cta-link', null, [
        'link' => $link,
        'mode' => $text_color === 'purple-950' ? 'light' : 'dark',
        'arrow_position' => $arrow_position
    ] ); ?>
</div>