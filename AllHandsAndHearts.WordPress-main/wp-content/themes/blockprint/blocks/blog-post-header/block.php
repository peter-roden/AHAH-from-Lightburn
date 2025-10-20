<?php
/**
 * Blog Post Header Block
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

$class_name = build_block_class_name( 'flex flex-col pt-4 md:pt-10 pb-12 md:pb-24 gap-y-12 md:gap-y-24', $block );

$style = build_block_styles( $block );

$short_description = get_field('short_description', $post_id);
?>

<header id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '' ?>>
    <div class="@container container-wide">
        <p class="mb-10 @5xl:mb-16">
            <a class="flex items-center w-fit gap-x-0.5 text-purple-950 hover:text-purple-700 no-underline!" href="<?php echo get_site_url(null, '/news') ?>">
                <svg class="text-purple-700" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Back
            </a>
        </p>

        <div class="grid @3xl:grid-cols-12 items-start gap-x-4 gap-y-8">
            <div class="@3xl:col-span-6 @3xl:-mr-6">
                <h1 class="mb-0"><?php the_title() ?></h1>
            </div>
            <div class="@3xl:col-span-5 @3xl:col-start-8">
                <?php if ( $short_description ) : ?>
                    <p class="mb-6">
                        <?php echo $short_description ?>
                    </p>
                <?php endif ?>

                <div class="flex gap-4 justify-between items-center">
                    <?php get_template_part('partials/share-button', null, [ 'position' => 'right' ]) ?>
                    <time class="opacity-70" datetime="<?php echo get_the_date('c') ?>">
                        <?php echo get_the_date() ?>
                    </time>
                </div>
            </div>
        </div>
    </div>

    <?php if ( has_post_thumbnail($post_id) ) : ?>
        <figure class="mx-auto w-full max-w-360 aspect-[1.8]">
            <?php echo get_the_post_thumbnail($post_id, '1440', [ 'class' => 'size-full object-cover' ]); ?>
        </figure>
    <?php endif ?>
</header>