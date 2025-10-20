<?php
/**
 * Section Header Block
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

$class_name = build_block_class_name( '@container mb-10', $block );

$style = build_block_styles( $block );

$overline = get_field('overline');
$heading = get_field('heading');
$heading_style = get_field('heading_style');
$heading_font_weight = get_field('heading_font_weight');
$text = get_field('text');
$button_link = get_field('button_link');
$button_style = get_field('button_style');
$text_align = get_field('text_align');

if ( $text_align === 'Center' ) {
    $class_name .= ' text-center';
}

$container_class_name = '';
if ( str_contains($class_name, 'has-background') ) {
    $container_class_name .= ' p-8' . ($text_align === 'Center' ? ' @2xl:px-0' : ' @xl:px-10 @4xl:px-12 @5xl:px-14');
}

$heading_class_name = '';
if ( $heading_style === 'H1' ) {
    $heading_class_name .= ' text-h1';
} else if ( $heading_style === 'H3' ) {
    $heading_class_name .= ' text-h3';
} else if ( $heading_style === 'H4' ) {
    $heading_class_name .= ' text-h4';
}
?>

<header id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '' ?>>
    <div class="<?php echo trim( esc_attr( $container_class_name ) ) ?>">
        <?php if ( $overline ) : ?>
            <p class="text-overline mb-2">
                <?php echo $overline ?>
            </p>
        <?php endif ?>

        <div class="flex flex-wrap -mx-2 gap-y-4">
            <div class="<?php echo esc_attr('flex flex-col gap-y-4 w-full [&>*]:mb-0 px-2' . ($text_align === 'Center' ? ' @2xl:w-9/10 @4xl:w-5/6 @5xl:w-2/3 mx-auto' : ' @2xl:w-3/4 @4xl:w-2/3')) ?>">
                <?php if ( $heading ) : ?>
                    <h2 class="<?php echo trim( esc_attr( $heading_class_name ) ) ?>"<?php echo !empty( $heading_font_weight ) ? ' style="font-weight:' . esc_attr( $heading_font_weight ) . '"' : '' ?>>
                        <?php echo $heading ?>
                    </h2>
                <?php endif ?>

                <?php if ( $text ) : ?>
                    <div class="text-lg"><?php echo $text ?></div>
                <?php endif ?>
            </div>

            <?php if ( $button_link ) : ?>
                <div class="<?php echo esc_attr('w-full px-2' . ($text_align === 'Center' ? ' @4xl:w-5/6 @5xl:w-2/3 mx-auto' : ' @2xl:w-auto @2xl:ml-auto')) ?>">
                    <div class="wp-block-buttons">
                        <div class="wp-block-button is-style-<?php echo $button_style ?>">
                            <a class="wp-block-button__link wp-element-button" href="<?php echo $button_link['url'] ?>" target="<?php echo $button_link['target'] ?: '_self' ?>">
                                <?php echo $button_link['title'] ?>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>
</header>