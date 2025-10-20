<?php
/**
 * Stats Spotlight Block
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

$class_name = build_block_class_name( '@container relative z-0', $block );

$style = build_block_styles( $block );

$heading = get_field('heading');
$button_link = get_field('button_link');
$image = get_field('image');
$stats = get_field('stats');
?>

<div id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '' ?>>
    <div class="@container container-wide">
        <div class="flex flex-col gap-y-8 @4xl:gap-y-12 text-center">
            <?php if ( $heading ) : ?>
                <h2 class="text-display-2 @xl:text-display-1 mb-0">
                    <?php echo $heading ?>
                </h2>
            <?php endif ?>

            <?php if ( $button_link ) : ?>
                <div class="wp-block-buttons">
                    <div class="wp-block-button">
                        <a class="wp-block-button__link wp-element-button" href="<?php echo $button_link['url'] ?>"<?php echo $button_link['target'] === '_blank' ? ' target="_blank" rel="noopener noreferrer"' : '' ?>>
                            <?php echo $button_link['title'] ?>
                        </a>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>

    <div class="relative -z-1 w-full max-h-[788px] aspect-[393/627] @2xl:aspect-[1440/788] -mt-26 -mb-22">
        <div class="absolute top-0 left-0 w-full h-40 bg-gradient-to-b from-white to-white/0"></div>
        <div class="absolute bottom-0 left-0 w-full h-66 bg-gradient-to-t from-white to-white/0"></div>
        <?php if ( $image ) {
            echo wp_get_attachment_image( $image['id'], '1920', false, ['class' => 'size-full object-cover'] );
        } else {
            get_template_part('partials/placeholder-image');
        } ?>
    </div>

    <?php if ( $stats ) : ?>
        <div class="@container container-wide">
            <div class="grid @2xl:grid-cols-3 gap-4">
                <?php foreach ( array_slice($stats, 0, 3) as $stat ) {
                    get_template_part( 'partials/stat-card', null, [ 'id' => $stat->ID ] );
                } ?>
            </div>
        </div>
    <?php endif ?>
</div>