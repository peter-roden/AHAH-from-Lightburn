<?php
/**
 * Two-Column Content Block
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

$class_name = build_block_class_name( 'bg-gray-100', $block );

$style = build_block_styles( $block );

$allowed_blocks = [
    'core/group'
];

$template = [
    ['core/pattern', [
        'slug' => 'blockprint/hidden-two-col-content-innerblocks'
    ]]
];

$overline = get_field('overline');
$overline_color = get_field('overline_color') ?: 'inherit';
$heading = get_field('heading');
$heading_style = get_field('heading_style');
$heading_font_weight = get_field('heading_font_weight');
$subheading = get_field('subheading');
$subheading_font_weight = get_field('subheading_font_weight');
$image = get_field('image');
$image_border_radius = get_field('image_border_radius');
$image_border_radius = $image_border_radius ? $image_border_radius / 16 . 'rem' : 'var(--default-border-radius)';

if ($image) {
    $class_name .= ' pt-12 md:pt-16 lg:pt-20';
} else {
    $class_name .= ' py-12 md:py-16 lg:py-20';
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

<div id="<?php echo esc_attr($anchor) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr($style) . '"' : '' ?>>
    <div class="container-wide flex flex-col gap-y-6">
        <?php if ( $overline || $heading || $subheading ) : ?>
            <div class="<?php echo esc_attr('flex flex-col gap-y-6 [&>*]:mb-0') ?>">
                <?php if ( $overline || $heading ) : ?>
                    <div class="<?php echo esc_attr('flex flex-col gap-y-6 [&>*]:mb-0') ?>">
                        <?php if ( $overline ) : ?>
                            <p class="text-overline" style="color:<?php echo $overline_color ?>">
                                <?php echo $overline ?>
                            </p>
                        <?php endif ?>

                        <?php if ( $heading ) : ?>
                            <h2 class="<?php echo trim( esc_attr( $heading_class_name ) ) ?>"<?php echo !empty( $heading_font_weight ) ? ' style="font-weight:' . esc_attr( $heading_font_weight ) . '"' : '' ?>>
                                <?php echo $heading ?>
                            </h2>
                        <?php endif ?>
                    </div>
                <?php endif ?>

                <?php if ( $subheading ) : ?>
                    <p class="text-xl md:w-4/5 lg:w-1/2 md:pr-5 lg:pr-8 xl:pr-10"<?php echo !empty( $subheading_font_weight ) ? ' style="font-weight:' . esc_attr( $subheading_font_weight ) . '"' : '' ?>>
                        <?php echo $subheading ?>
                    </p>
                <?php endif ?>
            </div>
        <?php endif ?>

        <InnerBlocks
            allowedBlocks="<?php echo esc_attr(wp_json_encode($allowed_blocks)) ?>"
            template="<?php echo esc_attr(wp_json_encode($template)) ?>"
            class="grid md:grid-cols-2 gap-y-6 gap-x-8 md:gap-x-10 lg:gap-x-16 xl:gap-x-20"
        />

        <?php if ($image) : ?>
            <?php echo wp_get_attachment_image( $image['id'], '1920', false, [
                'class' => 'w-full aspect-square sm:aspect-[1128/597] object-cover rounded-(--border-radius) mt-6 lg:mt-10 -mb-46 sm:-mb-22',
                'style' => "--border-radius:{$image_border_radius}"
            ] ); ?>
        <?php endif ?>
    </div>
</div>

<?php if ($image) : ?>
    <div class="mt-0 h-46 sm:h-22"></div>
<?php endif ?>