<?php
/**
 * Pillars Block
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

$style = build_block_styles( $block );

$heading = get_field('heading');
$heading_style = get_field('heading_style');
$content = get_field('content');
$cta_button = get_field('cta_button');
?>

<div id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '' ?>>
    <div class="@container container-wide">
        <div class="<?php echo esc_attr('flex flex-col gap-y-18 @2xl:gap-y-24 [&>*]:w-full') ?>">
            <?php if ( $heading || $content || $cta_button ) : ?>
                <div class="<?php echo esc_attr('flex flex-col text-center [&>*]:w-full') ?>">
                    <div class="<?php echo esc_attr('flex flex-col items-center gap-y-8 [&>*]:w-full') ?>">
                        <?php if ( $heading ) : ?>
                            <h2 class="<?php echo $heading_style === 'Display 1' ? 'text-display-1 ' : ''?>mb-0">
                                <?php echo $heading ?>
                            </h2>
                        <?php endif; ?>

                        <?php if ( $content ) : ?>
                            <div class="font-semibold text-xl max-w-228">
                                <?php echo $content ?>
                            </div>
                        <?php endif; ?>

                        <?php if ( $cta_button ) : ?>
                            <div class="wp-block-buttons">
                                <div class="wp-block-button">
                                    <a class="wp-block-button__link wp-element-button" href="<?php echo $cta_button['url']; ?>"<?php echo $cta_button['target'] === '_blank' ? ' target="_blank" rel="noopener noreferrer"' : '' ?>>
                                        <?php echo $cta_button['title']; ?>
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ( have_rows('sections') ) : ?>
                <div class="flex flex-col justify-start gap-12 @2xl:gap-16">
                    <?php while ( have_rows('sections') ) :
                        the_row();
                        $section_type = get_sub_field('section_type');
                        $image = get_sub_field('image');
                        $icon = get_sub_field('icon');
                        $section_heading = get_sub_field('section_heading');
                        $section_summary = get_sub_field('section_summary');
                        $list = get_sub_field('list');
                        $section_cta = get_sub_field('section_cta');
                        $is_even = (get_row_index() - 1) % 2 == 0;
                    ?>
                        <div class="grid grid-cols-12 w-full gap-y-8 @2xl:gap-x-4 @4xl:gap-x-10">
                            <div class="col-span-12 @2xl:col-span-5 w-full flex items-center <?php echo $is_even ? '@2xl:order-1' : '@2xl:order-2' ?>">
                                <div class="w-full aspect-square">
                                    <?php if ( $image ) {
                                        echo wp_get_attachment_image($image, 'large', false, [
                                            'class' => 'size-full object-cover',
                                            'loading' => 'lazy'
                                        ]);
                                    } else {
                                        echo get_template_part('partials/placeholder-image');
                                    } ?>
                                </div>
                            </div>

                            <div class="col-span-12 @2xl:col-span-7 w-full @2xl:max-w-154 mx-auto relative flex items-center justify-center gap-4 <?php echo $is_even ? '@2xl:order-2' : '@2xl:order-1'; ?>">
                                <div class="flex gap-4 relative w-full">
                                    <?php if ( $icon ) : ?>
                                        <div class="mb-auto flex items-center justify-center after:absolute after:top-[3.25rem] after:bottom-0 after:w-0.5 after:bg-primary">
                                            <span class="text-primary text-[2.5rem] <?php echo $icon; ?>"></span>
                                        </div>
                                    <?php endif; ?>
                                    <div class="@container pt-11 @2xl:pt-13 @lg:pb-6 grow">
                                        <?php if ( $section_heading ) : ?>
                                            <h3 class="text-h4">
                                                <?php echo $section_heading; ?>
                                            </h3>
                                        <?php endif; ?>

                                        <div class="ml-8 @md:ml-16 mt-6">
                                            <div class="<?php echo esc_attr('@container flex flex-col gap-y-8 [&>*]:w-full') ?>">
                                                <?php if ( $section_summary ) : ?>
                                                    <div class="@sm:text-lg">
                                                        <?php echo $section_summary; ?>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if ( $list ) : ?>
                                                    <ul class="font-semibold pl-5 -mb-2 @sm:text-lg<?php echo count($list) > 3 ? ' @sm:columns-2 gap-x-8' : '' ?>">
                                                        <?php foreach ( $list as $item ) : ?>
                                                            <li class="mb-2 break-inside-avoid">
                                                                <?php echo $item['text']; ?>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                <?php endif; ?>

                                                <?php if ( $section_cta ) : ?>
                                                    <div class="wp-block-buttons hidden md:block">
                                                        <div class="wp-block-button is-style-outline">
                                                            <a class="wp-block-button__link wp-element-button" href="<?php echo $section_cta['url']; ?>"<?php echo $section_cta['target'] === '_blank' ? ' target="_blank" rel="noopener noreferrer"' : '' ?>>
                                                                <?php echo $section_cta['title']; ?>
                                                            </a>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php if ( $section_cta ) : ?>
                                <div class="wp-block-buttons col-span-12 w-full -mt-2 block md:hidden">
                                    <div class="wp-block-button is-style-outline w-full">
                                        <a class="wp-block-button__link wp-element-button w-full" href="<?php echo $section_cta['url']; ?>" target="<?php echo $section_cta['target'] ?: '_self'; ?>">
                                            <?php echo $section_cta['title']; ?>
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>