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

$class_name = build_block_class_name( '@container flex flex-col gap-y-10', $block );

$style = build_block_styles( $block );

$heading = get_field('heading');
?>

<div id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '' ?>>
    <div class="flex flex-col gap-y-10 w-full max-w-360 mx-auto">
        <?php if ( $heading ) : ?>
            <h2 class="text-center container-wide mb-0">
                <?php echo $heading ?>
            </h2>
        <?php endif ?>

        <?php if ( have_rows('stories') ) : ?>
            <div class="group/tabs js-tabs">
                <div class="container-wide mb-6">
                    <div role="tablist" class="hidden @2xl:flex bg-neutral-100 p-1 w-fit mx-auto max-w-full js-tabs-list">
                        <?php while ( have_rows('stories') ) :
                            the_row();
                            $index = get_row_index();
                            $tab_id = "{$anchor}_tab_{$index}";
                            $panel_id = "{$anchor}_tabpanel_{$index}";
                            $tab_name = get_sub_field('tab_name') ?: "Tab {$index}";
                        ?>
                            <a class="flex items-center justify-center min-h-12 w-64 py-2 px-6 text-center leading-[1.2] text-secondary! [.is-selected]:text-white! hover:bg-black/5 [.is-selected]:bg-secondary no-underline! transition-colors js-tabs-trigger" href="#<?php echo $panel_id ?>" id="<?php echo $tab_id ?>" aria-controls="<?php echo $panel_id ?>" role="tab">
                                <span class="pointer-events-none line-clamp-2"><?php echo $tab_name ?></span>
                            </a>
                        <?php endwhile ?>
                    </div>

                    <div class="relative @2xl:hidden">
                        <select class="w-full bg-secondary text-white text-lg font-extrabold h-16 pl-6 pr-12 appearance-none js-tabs-dropdown">
                            <?php while ( have_rows('stories') ) :
                                the_row();
                                $index = get_row_index();
                                $panel_id = "{$anchor}_tabpanel_{$index}";
                                $tab_name = get_sub_field('tab_name') ?: "Tab {$index}";
                            ?>
                                <option class="bg-white text-secondary" value="#<?php echo $panel_id ?>"><?php echo $tab_name ?></option>
                            <?php endwhile ?>
                        </select>
                        <svg class="absolute top-1/2 right-6 -translate-y-1/2 text-white" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="square"/>
                        </svg>
                    </div>
                </div>

                <div class="flex flex-col group-not-[.is-initialized]/tabs:gap-y-12">
                    <?php while ( have_rows('stories') ) :
                        the_row();
                        $tab_id = $anchor . '_tab_' . get_row_index();
                        $panel_id = $anchor . '_tabpanel_' . get_row_index();
                        $tab_name = get_sub_field('tab_name');
                        $heading = get_sub_field('heading');
                        $text = get_sub_field('text');
                        $cta_link = get_sub_field('cta_link');
                        $image = get_sub_field('image');
                        $image_caption = get_sub_field('image_caption');
                    ?>
                        <div id="<?php echo $panel_id ?>" class="group/tabs-panel js-tabs-panel" role="tabpanel" aria-labeledby="<?php echo $tab_id ?>">
                            <button class="hidden js-accordion-trigger">
                                <?php echo $tab_name ?>
                            </button>

                            <div class="content [.is-hidden]:hidden">
                                <div class="flex flex-col @2xl:flex-row">
                                    <figure class="relative size-full @2xl:w-1/2 @7xl:w-[56%] shrink-0">
                                        <div class="size-full aspect-square">
                                            <?php if ( $image ) {
                                                echo wp_get_attachment_image( $image['id'], 'large', false, [
                                                    'loading' => 'lazy',
                                                    'class' => 'size-full object-cover'
                                                ] );
                                            } else {
                                                echo get_template_part('partials/placeholder-image'); 
                                            } ?>
                                        </div>

                                        <?php if ( $image_caption ) : ?>
                                            <figcaption class="@4xl:absolute bottom-0 left-0 bg-purple-950 @4xl:bg-purple-950/70 text-white w-full @4xl:max-w-[400px] p-6">
                                                <?php echo $image_caption ?>
                                            </figcaption>
                                        <?php endif ?>
                                    </figure>

                                    <div class="py-12 px-(--container-spacing-x) @2xl:pl-6 @5xl:px-8 @7xl:px-16 self-center">
                                        <div class="flex flex-col gap-y-6">
                                            <?php if ( $heading ) : ?>
                                                <h3 class="text-h4 mb-0">
                                                    <?php echo $heading ?>
                                                </h3>
                                            <?php endif ?>

                                            <?php if ( $text ) : ?>
                                                <div>
                                                    <?php echo $text ?>
                                                </div>
                                            <?php endif ?>

                                            <?php if ( $cta_link ) : ?>
                                                <div>
                                                    <?php get_template_part( 'partials/cta-link', null, [
                                                        'link' => $cta_link
                                                    ] ); ?>
                                                </div>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile ?>
                </div>
            </div>
        <?php elseif ( $is_preview ) : ?>
            <div class="flex flex-col @2xl:flex-row">
                <div class="relative size-full @2xl:w-[50%] @7xl:w-[56%] shrink-0">
                    <div class="aspect-[806/742]">
                        <?php echo get_template_part('partials/placeholder-image'); ?>
                    </div>
                </div>
            </div>
        <?php endif ?>
    </div>
</div>