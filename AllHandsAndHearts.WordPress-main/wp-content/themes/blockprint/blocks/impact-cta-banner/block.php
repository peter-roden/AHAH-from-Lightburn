<?php
/**
 * Impact CTA Banner Block
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

$class_name = build_block_class_name( '@container bg-purple-700 text-white py-18 md:py-24', $block );

$style = build_block_styles( $block );

$heading = get_field('heading');
?>

<div id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '' ?>>
    <div class="container flex flex-col gap-y-10">
        <?php if ( $heading ) : ?>
            <h2 class="text-display-2 text-center mb-0">
                <?php echo $heading ?>
            </h2>
        <?php endif ?>

        <?php if ( have_rows('items') ) : ?>
            <div class="grid @2xl:grid-cols-3 gap-x-6 gap-y-4">
                <?php while ( have_rows('items') ) :
                    the_row();
                    $heading = get_sub_field('heading');
                    $link = get_sub_field('link');
                ?>
                    <div class="group relative flex flex-col justify-between gap-y-8 h-full bg-purple-500 p-8 @2xl:hover:scale-103 transition-transform">
                        <?php if ( $heading ) : ?>
                            <h3 class="flex items-center @2xl:items-start justify-between gap-x-4 text-h4 @2xl:min-h-[1.5lh] mb-0">
                                <?php echo $heading ?>
                                <svg class="@2xl:hidden shrink-0" width="26" height="26" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path d="M1.832 8H13.004" stroke="currentColor" stroke-width="2" stroke-linecap="square" stroke-linejoin="round"/>
                                    <path d="M8.867 3.035L13.833 8.001 8.867 12.966" stroke="currentColor" stroke-width="2" stroke-linecap="square"/>
                                </svg>
                            </h3>
                        <?php endif ?>

                        <?php if ( $link ) : ?>
                            <?php get_template_part( 'partials/cta-link', null, [
                                'class_name' => 'absolute @2xl:static inset-0 after:absolute after:inset-0 [&_svg]:opacity-0 @2xl:[&_svg]:opacity-100',
                                'link' => [
                                    'title' => '<span class="opacity-0 @2xl:group-hover/cta-link:opacity-100 @2xl:group-focus-within/cta-link:opacity-100 transition-opacity">' . $link['title'] . '</span>',
                                    'url' => $link['url'],
                                    'target' => $link['target']
                                ],
                                'mode' => 'dark',
                                'arrow_position' => 'start'
                            ] ); ?>
                        <?php endif ?>
                    </div>
                <?php endwhile ?>
            </div>
        <?php endif ?>
    </div>
</div>