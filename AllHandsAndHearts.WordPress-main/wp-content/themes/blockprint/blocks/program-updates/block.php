<?php
/**
 * Program Updates Block
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

$class_name = build_block_class_name( '@container bg-neutral-50 py-16 lg:py-20', $block );

$style = build_block_styles( $block );

$heading = get_field('heading');
$taxonomy_id = get_field('taxonomy');
$taxonomy = [];
$taxonomy_slug = '';

if ($taxonomy_id) {
    $taxonomy = get_term_by('id', $taxonomy_id, 'program-type');
    $taxonomy_slug = $taxonomy->slug;
}

$posts = $taxonomy_id ? get_posts([
    'numberposts' => 4,
    'post_status' => 'publish',
    'tax_query' => [
        [
            'taxonomy' => 'program-type',
            'field' => 'id',
            'terms' => $taxonomy_id
        ]
    ]
]) : [];
?>

<section id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '' ?>>
    <div class="container-wide flex flex-col gap-y-10">
        <header class="flex items-center gap-4 w-full">
            <?php if ( $heading ) : ?>
                <h2 class="text-h4 font-extrabold mb-0 grow">
                    <?php echo $heading ?>
                </h2>
            <?php endif ?>

            <?php if ( $taxonomy_slug ) : ?>
                <div class="shrink-0 ml-auto">
                    <?php get_template_part( 'partials/cta-link', null, [
                        'link' => [
                            'title' => 'See All <span class="sr-only @2xl:not-sr-only!">Updates</span>',
                            'url' => esc_url(home_url('/news?programType=' . $taxonomy_slug))
                        ]
                    ] ); ?>
                </div>
            <?php endif ?>
        </header>

        <?php if ( $posts ) : ?>
            <div class="overflow-hidden pl-(--container-spacing-x) pr-12 @5xl:px-0 mx-[calc(var(--container-spacing-x)*-1)] @5xl:mx-0">
                <div class="<?php echo $is_preview ? '' : 'swiper w-full overflow-visible js-swiper' ?>" data-options='{
                    "allowTouchMove": true,
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
                            "slidesPerView": 2
                        },
                        "768": {
                            "slidesPerView": 3
                        },
                        "1024": {
                            "slidesPerView": 4
                        }
                    }    
                }'>
                    <div class="<?php echo $is_preview ? 'grid grid-cols-4' : 'swiper-wrapper' ?>">
                        <?php foreach ( $posts as $post ) : ?>
                            <div class="swiper-slide">
                                <a class="group flex flex-col gap-y-6 text-current hover:text-purple-500 no-underline! transition-colors duration-300" href="<?php echo get_permalink($post->ID) ?>">
                                    <figure class="w-full aspect-[3/2] bg-neutral-100 overflow-hidden">
                                        <?php echo get_the_post_thumbnail($post->ID, 'medium', [
                                            'loading' => 'lazy',
                                            'class' => 'size-full object-cover group-hover:scale-110 transition-transform duration-300'
                                        ]); ?>
                                    </figure>

                                    <div class="flex items-start gap-x-4">
                                        <span class="text-h6 mb-0 grow">
                                            <?php echo $post->post_title ?>
                                        </span>
                                        <?php if ( has_tag('video', $post->ID) ) : ?>
                                            <span class="flex items-center justify-center text-center bg-green-100 text-green-950 rounded-full text-sm uppercase tracking-[.03em] leading-[1.2] font-extrabold shrink-0 px-3 py-1 min-h-7">
                                                Video
                                            </span>
                                        <?php endif ?>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach ?>
                    </div>

                    <?php if ( !$is_preview ) {
                        get_template_part('partials/swiper-controls', null, [
                            'class_name' => 'pl-6 mt-10'
                        ] );
                    } ?>
                </div>
            </div>
        <?php else : ?>
            <p>No posts found.</p>
        <?php endif ?>
    </div>
</section>