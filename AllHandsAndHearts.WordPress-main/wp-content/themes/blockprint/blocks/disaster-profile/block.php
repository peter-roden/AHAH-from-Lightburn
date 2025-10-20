<?php
/**
 * Template Block
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

$overline = get_field('overline');
$heading = get_field('heading');
$cta_heading = get_field('cta_heading');
$cta_text = get_field('cta_text');
$cta_button_link = get_field('cta_button_link');
$cta_email = get_field('cta_email');
$cta_phone = get_field('cta_phone');

$has_cta = $cta_heading || $cta_text || $cta_button_link || $cta_email || $cta_phone;
?>

<section id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '' ?>>
    <div class="grid @2xl:grid-cols-12 gap-y-16 gap-x-4 @2xl:gap-x-6 @4xl:gap-x-4">
        <div class="@2xl:col-span-7 order-2 @2xl:order-1">
            <?php if ( $overline || $heading ) : ?>
                <header class="space-y-4! mb-12">
                    <?php if ( $overline ) : ?>
                        <p class="text-overline text-purple-500">
                            <?php echo $overline ?>
                        </p>
                    <?php endif ?>
                    
                    <?php if ( $heading ) : ?>
                        <h2 class="text-h3">
                            <?php echo $heading ?>
                        </h2>
                    <?php endif ?>
                </header>
            <?php endif ?>

            <InnerBlocks class="<?php echo esc_attr('is-layout-constrained [&>*]:max-w-full') ?>" />
        </div>

        <?php if ( $has_cta ) : ?>
            <div class="@2xl:col-span-5 @4xl:col-span-4 @4xl:col-start-9 @7xl:col-span-3 @7xl:col-start-10 order-1 @2xl:order-2">
                <aside class="<?php echo esc_attr('bg-green-100 text-green-950 text-center p-8 [&_a:not(.wp-element-button)]:text-current [&_a:not(.wp-element-button)]:hover:text-current space-y-6!') ?>">
                    <?php if ( $cta_heading ) : ?>
                        <h3 class="text-h6"><?php echo $cta_heading ?></h3>
                    <?php endif ?>

                    <?php if ( $cta_text ) : ?>
                        <p><?php echo $cta_text ?></p>
                    <?php endif ?>

                    <?php if ( $cta_button_link ) : ?>
                        <div class="wp-block-button block!">
                            <a class="wp-block-button__link wp-element-button bg-green-950! hover:bg-purple-500! w-full" href="<?php echo $cta_button_link['url'] ?>"<?php echo $cta_button_link['target'] === '_blank' ? ' target="_blank" rel="noopener noreferrer"' : '' ?>>
                                <?php echo $cta_button_link['title'] ?>
                            </a>
                        </div>
                    <?php endif ?>

                    <?php if ( $cta_email || $cta_phone ) : ?>
                        <ul class="list-none pl-0">
                            <?php if ( $cta_email ) : ?>
                                <li><a href="mailto:<?php echo $cta_email ?>"><?php echo esc_html_e('Email us', 'blockprint') ?></a></li>
                            <?php endif ?>

                            <?php if ( $cta_phone ) : ?>
                                <li><?php echo esc_html_e('Phone', 'blockprint') ?>: <a href="tel:<?php echo $cta_phone ?>"><?php echo $cta_phone ?></a></li>
                            <?php endif ?>
                        </ul>
                    <?php endif ?>
                </aside>
            </div>
        <?php endif ?>
    </div>
</section>