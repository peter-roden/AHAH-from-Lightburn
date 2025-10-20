<?php
/**
 * Active Programs Carousel Block
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

$class_name = build_block_class_name( '@container overflow-hidden', $block );

$style = build_block_styles( $block );

$posts = get_posts([
    'post_type' => 'program',
    'numberposts' => 12,
    'meta_query'  => [
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
        <header class="flex items-center gap-4">
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
            <div class="w-full -mt-4">
                <div class="mr-7 @2xl:mr-10 @6xl:mr-16 2xl:mr-0!">
                    <div class="swiper overflow-visible js-swiper" data-options='{
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
                            "896": {
                                "slidesPerView": 3,
                                "slidesPerGroup": 3
                            },
                            "1280": {
                                "slidesPerView": 4,
                                "slidesPerGroup": 4
                            }
                        }
                    }'>
                        <div class="swiper-wrapper">
                            <?php foreach ( $posts as $post ) :
                                $title = $post->post_title;
                                $link = get_permalink($post->ID);
                                $excerpt = $post->post_excerpt ?: get_field('short_description', $post->ID);
                                $urgent = get_field('urgent', $post->ID);
                                $location = get_field('location', $post->ID);
                                $donate_url = get_field('donate_url', $post->ID);
                            ?>
                                <div class="group/swiper-slide swiper-slide h-auto pt-4 hover:scale-103 transition-transform">
                                    <div class="relative flex flex-col h-full">
                                        <div>
                                            <figure class="aspect-[2] w-full">
                                                <?php if ( has_post_thumbnail($post->ID) ) {
                                                    echo get_the_post_thumbnail($post->ID, 'medium', [
                                                        'loading' => 'lazy',
                                                        'class' => 'size-full object-cover'
                                                    ]);
                                                } else {
                                                    echo get_template_part('partials/placeholder-image');
                                                } ?>
                                            </figure>
                                        </div>

                                        <div class="flex flex-col gap-y-6 w-full p-6 grow bg-neutral-50 group-hover/swiper-slide:bg-neutral-100 transition-colors">
                                            <div class="text-center">
                                                <p class="text-xs font-semibold mb-3">
                                                    <?php echo $location ?>
                                                </p>
                                                
                                                <h3 class="text-lg mb-3">
                                                    <a class="text-current group-hover/swiper-slide:text-purple-500 font-semibold no-underline! transition-colors after:content-[''] after:absolute after:inset-0" href="<?php echo $link ?>">
                                                        <?php echo $title ?>
                                                    </a>
                                                </h3>

                                                <p class="text-sm line-clamp-3">
                                                    <?php echo $excerpt ?>
                                                </p>

                                                <?php if ( $urgent ) : ?>
                                                    <div class="absolute top-0 left-1/2 -translate-y-1/2 -translate-x-1/2 flex items-center justify-center text-center bg-green-100 text-green-950 uppercase text-xs leading-[1.2] tracking-[0.05em] font-extrabold text-nowrap rounded-full min-h-[1.75rem] px-3 pointer-events-none">
                                                        Urgent need
                                                    </div>
                                                <?php endif ?>
                                            </div>

                                            <div class="flex items-center gap-x-4 mt-auto">
                                                <?php if ( $donate_url ) : ?>
                                                    <div class="wp-block-button is-style-outline">
                                                        <a class="wp-block-button__link has-sm-font-size has-custom-font-size wp-element-button relative" href="<?php echo $donate_url ?>" target="_blank" rel="noopener noreferrer">
                                                            Donate
                                                        </a>
                                                    </div>
                                                <?php endif ?>

                                                <div class="ml-auto">
                                                    <?php get_template_part( 'partials/cta-link', null, [
                                                        'class_name' => 'relative',
                                                        'link' => [
                                                            'title' => 'Learn More',
                                                            'url' => $link
                                                        ]
                                                    ] ); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>

                        <?php get_template_part('partials/swiper-controls', null, [
                            'class_name' => 'mt-10 ml-7 @2xl:ml-10 @6xl:ml-16 2xl:ml-0!'
                        ] ); ?>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <p>No active programs found.</p>
        <?php endif ?>
    </div>
</section>