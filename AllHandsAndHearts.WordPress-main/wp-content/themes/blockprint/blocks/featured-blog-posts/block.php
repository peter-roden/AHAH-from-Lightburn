<?php
/**
 * Featured Blog Posts Block
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

$featured_posts = get_field('posts');
$layout = get_field('layout');
$image_aspect_ratio = get_field('image_aspect_ratio') ?: 'var(--card-image-aspect-ratio)';
$show_date = get_field('show_date');
$show_category = get_field('show_category');
$show_excerpt = get_field('show_excerpt');
$show_author_name = get_field('show_author_name');
$posts = $featured_posts ?: get_posts([
    'numberposts' => 3,
    'post_status' => 'publish',
    'category__in' => is_single() ? wp_get_post_categories($post_id) : [],
    'post__not_in' => is_single() ? [ $post_id ] : []
]);

$innerblocks_class_name = '';

if ($layout === 'carousel') {
    $class_name .= ' swiper js-swiper';
    $innerblocks_class_name = esc_attr('swiper-wrapper [&>*]:h-auto');
} else {
    $innerblocks_class_name = 'hidden @xl:grid @xl:grid-cols-3 gap-6';
}
?>

<div id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>">
    <div class="<?php echo $innerblocks_class_name ?>">
        <?php foreach ( $posts as $post ) {
            echo do_blocks('<!-- wp:acf/blog-post-card {
                "name": "acf/blog-post-card",
                "data": {
                    "post": '. $post->ID . ',
                    "_post": "field_68167fd144679",
                    "image_aspect_ratio": "'. $image_aspect_ratio . '",
                    "_image_aspect_ratio": "field_68167ff24467a",
                    "show_date": "'. $show_date . '",
                    "_show_date": "field_6816893767729",
                    "show_category": "'. $show_category . '",
                    "_show_category": "field_681680174467b",
                    "show_excerpt": "'. $show_excerpt . '",
                    "_show_excerpt": "field_681680334467c",
                    "show_author_name": "'. $show_author_name . '",
                    "_show_author_name": "field_6816804f4467e"
                },
                "mode":"preview"
            } /-->');
         } ?>
    </div>

    <?php if ( $layout === 'carousel' ) :
        get_template_part('partials/swiper-controls', null, [ 'class_name' => 'mt-8' ] );
    else : ?>
        <div class="flex @xl:hidden flex-col gap-y-10">
            <?php foreach ( $posts as $post ) :
                $post_title = $post->post_title;
                $post_id = $post->ID;
                $post_permalink = get_permalink($post_id);
                $post_excerpt = get_the_excerpt($post_id);
                $news_sources = wp_get_post_terms($post_id, 'news-source');
                $news_source_logo = '';
                $has_external_link = !empty(get_field('external_link', $post_id));
                
                if ($news_sources) {
                    $news_source = $news_sources[0];
                    $news_source_logo = get_field('logo', $news_source);
                }
            ?>
                <article class="flex flex-row-reverse items-start gap-x-5 relative">
                    <?php if ( has_post_thumbnail($post_id) ) : ?>
                        <figure class="w-24 h-auto shrink-0 bg-neutral-100 aspect-(--aspect-ratio) overflow-hidden" style="--aspect-ratio:<?php echo $image_aspect_ratio ?>">
                            <?php echo get_the_post_thumbnail($post_id, 'medium', [
                                'loading' => 'lazy',
                                'class' => 'size-full object-cover'
                            ]) ?>
                        </figure>
                    <?php endif ?>

                    <div class="flex flex-col gap-y-3 grow">
                        <?php if ( $news_source_logo ) : ?>
                            <?php echo wp_get_attachment_image( $news_source_logo['id'], 'medium', false, [
                                'loading' => 'lazy',
                                'class' => 'size-full max-w-47.5 max-h-10 object-contain object-left'
                            ] ); ?>
                            <p class="text-sm mb-0">
                                <a class="text-current! no-underline! after:absolute after:inset-0" href="<?php echo $post_permalink ?>"<?php echo $has_external_link ? ' target="_blank" rel="noopener noreferrer"' : '' ?>>
                                    <?php echo $post_title ?>
                                </a>
                            </p>
                        <?php else : ?>
                            <p class="font-bold mb-0">
                                <a class="text-current! no-underline! after:absolute after:inset-0" href="<?php echo $post_permalink ?>"<?php echo $has_external_link ? ' target="_blank" rel="noopener noreferrer"' : '' ?>>
                                    <?php echo $post_title ?>
                                </a>
                            </p>
                            <p class="text-sm line-clamp-2 mb-0">
                                <?php echo $post_excerpt ?>
                            </p>
                        <?php endif ?>

                        <time class="text-sm opacity-70" datetime="<?php echo get_the_date('c', $post_id) ?>">
                            <?php echo get_the_date('', $post_id) ?>
                        </time>
                    </div>
                </article>
            <?php endforeach ?>
        </div>
    <?php endif ?>
</div>

<?php if ( $layout === 'carousel' ) : ?>
    <script>
        (() => {
            const block = document.getElementById('<?php echo esc_attr( $anchor ); ?>');
            const swiperOptions = {
                allowTouchMove: <?php echo $is_preview ? 'false' : 'true' ?>,
                speed: 500,
                spaceBetween: 16,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev'
                },
                pagination: {
                    el: '.swiper-pagination',
                    bulletElement: 'button',
                    clickable: true
                },
                breakpoints: {
                    576: {
                        slidesPerView: 2,
                        slidesPerGroup: 2
                    },
                    768: {
                        slidesPerView: 3,
                        slidesPerGroup: 3
                    },
                    992: {
                        slidesPerView: 3,
                        slidesPerGroup: 3,
                        spaceBetween: 24
                    }
                }                
            };
            
            block.querySelectorAll('.swiper-wrapper > *').forEach(x => x.classList.add('swiper-slide'));
            block.dataset.options = JSON.stringify(swiperOptions);
        })();
    </script>
<?php endif ?>