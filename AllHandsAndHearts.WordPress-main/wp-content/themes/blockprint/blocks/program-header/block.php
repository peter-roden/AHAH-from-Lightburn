<?php
/**
 * Program Header Block
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

$heading = get_the_title() === 'Auto Draft' ? 'Program Name' : get_the_title();
$location = get_field('location', $post_id);
$start_date = get_field('start_date', $post_id);
$end_date = get_field('end_date', $post_id);
$short_description = get_field('short_description', $post_id);
$featured_video = get_field('featured_video', $post_id);
$urgent = get_field('urgent', $post_id);
$donate_url = get_field('donate_url', $post_id);
$volunteer_application = get_field('volunteer_application', $post_id);
?>

<header id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '' ?>>
    <div class="container-wide py-4">
        <div class="yoast-breadcrumbs">
            <?php echo do_shortcode('[wpseo_breadcrumb]') ?>
        </div>
    </div>

    <div class="grid @2xl:grid-cols-2">
        <?php if ( $featured_video ) : ?>
            <div class="<?php echo esc_attr('aspect-video size-full [&>iframe]:size-full bg-black') ?>">
                <?php echo $featured_video ?>
            </div>
        <?php else : ?>
            <div class="aspect-[72/52] size-full">
                <?php
                    echo get_the_post_thumbnail($post_id, 'large', [ 'class' => 'size-full object-cover', 'loading' => 'eager' ]);
                    
                    if ( !has_post_thumbnail($post_id) ) {
                        get_template_part('partials/placeholder-image');
                    }
                ?>
            </div>
        <?php endif ?>

        <div class="py-10 pr-(--container-spacing-x) @7xl:pr-20 self-center">
            <div class="max-w-[calc(var(--wide-width)/2)] pl-(--container-spacing-x) @4xl:pl-10 @6xl:pl-14 @7xl:pl-20">
                <div class="flex flex-col gap-y-4 text-purple-950/70 space-y-0!">
                    <div class="flex gap-x-4 order-1">
                        <?php if ( $location ) : ?>
                            <p class="self-center mb-0"><?php echo $location ?></p>
                        <?php endif ?>
                        
                        <div class="ml-auto">
                            <?php get_template_part('partials/share-button') ?>
                        </div>
                    </div>

                    <h1 class="text-h4 text-purple-950 order-2">
                        <?php echo $heading ?>
                    </h1>

                    <?php if ( $start_date ) : ?>
                        <p class="font-semibold order-3<?php echo $short_description || $is_preview ? ' @2xl:-mb-2!' : '' ?>">
                            <?php echo date_format(date_create($start_date), 'F Y') ?>
                            <?php if ( $end_date ) {
                                echo '&ndash; ' . date_format(date_create($end_date), 'F Y');
                            } ?>
                        </p>
                    <?php endif ?>

                    <?php if ( $short_description || ($is_preview && $heading === 'Program Name') ) : ?>
                        <?php if ( $short_description ) : ?>
                            <p class="order-7 @2xl:order-4"><?php echo $short_description ?></p>
                        <?php elseif ( $heading === 'Program Name' ) : ?>
                            <p class="order-4">Add a title above and fill out program details at the bottom of the page.</p>
                        <?php endif ?>
                    <?php endif ?>

                    <?php if ( $urgent ) : ?>
                        <p class="flex items-center justify-center text-center w-fit bg-green-100 text-green-950 uppercase text-xs leading-[1.2] tracking-[0.05em] font-extrabold rounded-full min-h-[1.75rem] py-1.5 px-3 order-5">
                            Urgent need for volunteers
                        </p>
                    <?php endif ?>

                    <?php if ( $donate_url || $volunteer_application ) : ?>
                        <div class="wp-block-buttons flex flex-col @4xl:flex-row flex-wrap gap-4 @2xl:mt-4 @4xl:mt-8 order-6">
                            <?php if ( $donate_url ) : ?>
                                <div class="wp-block-button">
                                    <a class="wp-block-button__link wp-element-button w-full" href="<?php echo $donate_url ?>" target="_blank" rel="noopener noreferrer">
                                        Donate Now
                                    </a>
                                </div>
                            <?php endif ?>

                            <?php if ( $volunteer_application ) : ?>
                                <div class="wp-block-button is-style-outline">
                                    <a class="wp-block-button__link wp-element-button w-full" href="<?php echo get_permalink($volunteer_application) ?>">
                                        Apply to Volunteer
                                    </a>
                                </div>
                            <?php endif ?>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</header>