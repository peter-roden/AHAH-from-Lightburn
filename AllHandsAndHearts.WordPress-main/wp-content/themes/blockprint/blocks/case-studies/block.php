<?php
/**
 * Case Studies Block
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

$class_name = build_block_class_name( 'overflow-hidden', $block );

$style = build_block_styles( $block );

$heading = get_field('heading');
$posts = get_field('posts');
$posts = $posts ?: get_posts([
    'numberposts' => 3,
    'post_status' => 'publish',
    'post_type' => 'case-study'
]);
?>

<div id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '' ?>>
    <div class="@container container-wide">
        <?php if ( $heading ) : ?>
            <h2 class="text-h4 text-center mb-10 @2xl:mb-14">
                <?php echo $heading ?>
            </h2>
        <?php endif ?>

        <?php if ( $posts ) : ?>
            <div class="swiper overflow-visible @2xl:pr-[8.333%] @6xl:pr-[16.667%] js-swiper" data-options='{
                "navigation": {
                    "nextEl": ".swiper-button-next",
                    "prevEl": ".swiper-button-prev"
                },
                "pagination": {
                    "el": ".swiper-pagination",
                    "bulletElement": "button",
                    "clickable": true
                },
                "spaceBetween": 32,
                "speed": 500
            }'>
                <div class="swiper-wrapper">
                    <?php foreach ( $posts as $post ) :
                        $cta_link = get_field('cta_link', $post->ID);
                    ?>
                        <div class="swiper-slide @2xl:grid @2xl:grid-cols-2 bg-neutral-100 h-auto">
                            <figure class="w-full @2xl:size-full aspect-square">
                                <?php echo get_the_post_thumbnail($post->ID, 'medium_large', [
                                    'loading' => 'lazy',
                                    'class' => 'size-full object-cover'
                                ]) ?>
                            </figure>

                            <div class="p-8 @6xl:p-14 @6xl:text-lg self-center">
                                <h3 class="text-h5 mb-8">
                                    <?php echo $post->post_title ?>
                                </h3>

                                <?php if ( have_rows('bullet_points', $post->ID) ) : ?>
                                    <ul class="flex flex-col gap-y-6 list-none pl-0">
                                        <?php while ( have_rows('bullet_points', $post->ID) ) :
                                            the_row();
                                            $icon = get_sub_field('icon');
                                            $text = get_sub_field('text');
                                        ?>
                                            <li class="flex items-start gap-x-3">
                                                <div class="shrink-0 rounded-full bg-purple-500 text-white size-9 flex items-center justify-center">
                                                    <?php echo $icon ?>
                                                </div>
                                                <div class="mt-1 @6xl:mt-0.5 grow">
                                                    <?php echo $text ?>
                                                </div>
                                            </li>
                                        <?php endwhile ?>
                                    </ul>
                                <?php endif ?>

                                <?php if ( $cta_link ) : ?>
                                    <div class="mt-6">
                                        <?php get_template_part( 'partials/cta-link', null, [
                                            'link' => $cta_link
                                        ] ); ?>
                                    </div>
                                <?php endif ?>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>

                <div class="flex items-center justify-between @lg:justify-center gap-6 mt-8 has-[.swiper-button-lock]:hidden @2xl:pl-[8.333%] @6xl:pl-[16.667%]">
                    <button class="<?php echo esc_attr('swiper-button-prev text-purple-950/50 not-disabled:hover:text-purple-950 not-disabled:cursor-pointer transition-colors shrink-0') ?>">
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <polyline points="15 18 9 12 15 6"></polyline>
                        </svg>
                    </button>
                    <div class="<?php echo esc_attr('swiper-pagination [counter-reset:section] flex flex-wrap justify-center gap-2.5 [&_.swiper-pagination-bullet]:size-8 [&_.swiper-pagination-bullet]:rounded-full [&_.swiper-pagination-bullet]:text-sm [&_.swiper-pagination-bullet]:font-bold [&_.swiper-pagination-bullet]:cursor-pointer [&_.swiper-pagination-bullet]:transition-colors [&_.swiper-pagination-bullet-active]:bg-purple-100 [&_.swiper-pagination-bullet::before]:[counter-increment:section] [&_.swiper-pagination-bullet::before]:[content:counter(section,decimal-leading-zero)]') ?>"></div>
                    <button class="<?php echo esc_attr('swiper-button-next text-purple-950/50 not-disabled:hover:text-purple-950 not-disabled:cursor-pointer transition-colors shrink-0') ?>">
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </button>
                </div>
            </div>
        <?php else : ?>
            <p class="text-center">No case studies found.</p>
        <?php endif ?>
    </div>
</div>