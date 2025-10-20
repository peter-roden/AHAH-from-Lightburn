<?php
/**
 * Active Programs Mini Carousel Block
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

$class_name = build_block_class_name( '@container bg-neutral-50 py-16 lg:py-20 overflow-hidden', $block );

$style = build_block_styles( $block );

$posts = get_posts([
    'post_type' => 'program',
    'numberposts' => 12,
    'meta_query'  => [
        'relation' => 'AND',
        [
            'key'     => 'active',
            'value'   => '1',
            'compare' => '='
        ]
    ],
]);

usort($posts, fn($a, $b) => (int) get_field('urgent', $b->ID) <=> (int) get_field('urgent', $a->ID));
?>

<section id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '' ?>>
    <div class="container-wide flex flex-col gap-y-10">
        <header class="flex items-center gap-4 w-full">
            <h2 class="text-h4 font-extrabold mb-0 grow">
                Active Programs
            </h2>

            <div class="shrink-0 ml-auto">
                <?php get_template_part( 'partials/cta-link', null, [
                    'link' => [
                        'title' => 'See All <span class="sr-only @2xl:not-sr-only!">Active Programs</span>',
                        'url' => '/our-work/active-programs'
                    ]
                ] ); ?>
            </div>
        </header>

        <?php if ( $posts ) : ?>
            <div class="swiper w-full overflow-visible js-swiper" data-options='{
                "allowTouchMove": <?php echo $is_preview ? 'false' : 'true' ?>,
                "spaceBetween": 24,
                "navigation": {
                    "nextEl": ".swiper-button-next",
                    "prevEl": ".swiper-button-prev"
                },
                "pagination": {
                    "el": ".swiper-pagination",
                    "bulletElement": "button",
                    "clickable": true
                },
                "breakpointsBase": "container",
                "breakpoints": {
                    "576": {
                        "slidesPerView": 2,
                        "slidesPerGroup": 2
                    },
                    "1024": {
                        "slidesPerView": 3,
                        "slidesPerGroup": 3
                    }
                }
            }'>
                <div class="swiper-wrapper">
                    <?php foreach ( $posts as $post ) :
                        $title = $post->post_title;
                        $link = get_permalink($post->ID);
                        $excerpt = $post->post_excerpt ?: get_field('short_description', $post->ID);
                        $urgent = get_field('urgent', $post->ID);
                    ?>
                        <div class="group/swiper-slide swiper-slide relative flex items-start gap-x-4.5">
                            <figure class="shrink-0 aspect-square w-[21.5%] max-w-[92px] bg-neutral-100">
                                <?php if ( has_post_thumbnail($post->ID) ) {
                                    echo get_the_post_thumbnail($post->ID, 'thumbnail', [
                                        'loading' => 'lazy',
                                        'class' => 'size-full object-cover'
                                    ]);
                                } else {
                                    echo get_template_part('partials/placeholder-image');
                                } ?>
                            </figure>

                            <div class="grow">
                                <h3 class="text-xl">
                                    <a class="text-current hover:text-purple-500 font-semibold no-underline! transition-colors after:content-[''] after:absolute after:inset-0" href="<?php echo $link ?>">
                                        <?php echo $title ?>
                                    </a>
                                </h3>

                                <p class="line-clamp-2">
                                    <?php echo $excerpt ?>
                                </p>

                                <div class="flex flex-wrap items-center gap-y-2 gap-x-4">
                                    <div class="flex items-center gap-x-2 grow leading-[1.2] text-sm">
                                        <span class="shrink-0 w-4 overflow-hidden">
                                            <span class="flex -translate-x-full group-hover/swiper-slide:translate-x-0 transition-transform pointer-events-none">
                                                <svg class="shrink-0 text-purple-500" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                    <path d="M1.832 8H13.004" stroke="currentColor" stroke-width="1.5" stroke-linecap="square" stroke-linejoin="round"/>
                                                    <path d="M8.867 3.035L13.833 8.001 8.867 12.966" stroke="currentColor" stroke-width="1.5" stroke-linecap="square"/>
                                                </svg>
                                                <svg class="shrink-0 opacity-80" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                    <path d="M1.832 8H13.004" stroke="currentColor" stroke-width="1.5" stroke-linecap="square" stroke-linejoin="round"/>
                                                    <path d="M8.867 3.035L13.833 8.001 8.867 12.966" stroke="currentColor" stroke-width="1.5" stroke-linecap="square"/>
                                                </svg>
                                            </span>
                                        </span>
                                        <span class="[@media(hover:hover)]:opacity-0 group-hover/swiper-slide:opacity-100 transition-opacity">
                                            Learn More
                                        </span>
                                    </div>

                                    <?php if ( $urgent ) : ?>
                                        <div class="flex items-center justify-center bg-green-100 text-green-950 uppercase text-xs leading-[1.2] tracking-[0.05em] font-extrabold rounded-full min-h-[1.75rem] py-1 px-3 shrink-0">
                                            Urgent need
                                        </div>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>

                <?php get_template_part('partials/swiper-controls', null, [
                    'class_name' => 'mt-10'
                ] ); ?>
            </div>
        <?php else : ?>
            <p>No active programs found.</p>
        <?php endif ?>
    </div>
</section>