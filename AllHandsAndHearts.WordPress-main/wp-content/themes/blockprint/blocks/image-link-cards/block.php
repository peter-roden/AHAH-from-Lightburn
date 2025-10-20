<?php
/**
 * Image Link Cards Block
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

$class_name = build_block_class_name( '@container [&.alignfull]:px-(--container-spacing-x)', $block );

$style = build_block_styles( $block );

$card_border_radius = get_field('card_border_radius');
$layout = get_field('layout');

$is_layout_grid_1 = $layout == 'grid-1';
$is_layout_grid_2 = $layout == 'grid-2';
$is_layout_grid_3 = $layout == 'grid-3';
$is_layout_carousel = $layout == 'carousel';

$card_class_name = '';
if ($is_layout_grid_1) {
    $card_class_name = '@2xl:col-span-2 @2xl:nth-[4n-4]:col-span-4 @2xl:nth-[4n-4]:aspect-[744/360] @2xl:nth-[4n-3]:col-span-4 @2xl:nth-[4n-3]:aspect-[744/360]';
} else if ($is_layout_grid_2) {
    $card_class_name = '@2xl:col-span-3';
} else if ($is_layout_grid_3) {
    $card_class_name = '@2xl:col-span-2';
} else if ($is_layout_carousel) {
    $card_class_name = 'swiper-slide';
}

$container_class_name = '';
if ($is_layout_carousel) {
    $class_name .= ' group/swiper swiper js-swiper';
    $container_class_name = 'swiper-wrapper';
} else {
    $container_class_name .= ' grid grid-cols-1 @lg:grid-cols-2 @2xl:grid-cols-6 gap-6';
}
?>

<div id="<?php echo esc_attr($anchor) ?>" class="<?php echo trim( esc_attr( $class_name) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '' ?>>
    <div class="<?php echo esc_attr( $container_class_name ) ?>">
        <?php if ( have_rows('items') ) : ?>
            <?php while ( have_rows('items') ) : the_row() ?>            
                <?php get_template_part( 'partials/image-link-card', null, [
                    'class_name' => $card_class_name,
                    'border_radius' => $card_border_radius,
                    'image' => get_sub_field('image'),
                    'link'  => get_sub_field('link')
                ] ); ?>
            <?php endwhile ?>
        <?php else : ?>
            <?php for ( $i = 0; $i < 4; $i++ ) : ?>
                <?php get_template_part( 'partials/image-link-card', null, [
                    'class_name' => $card_class_name,
                    'border_radius' => $card_border_radius
                ] ); ?>
            <?php endfor ?>
        <?php endif ?>
    </div>

    <?php if ( $is_layout_carousel ) {
        get_template_part('partials/swiper-controls', null, [
            'class_name' => 'mt-8'
        ] );
    } ?>
</div>

<?php if ($is_layout_carousel) : ?>
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
            block.dataset.options = JSON.stringify(swiperOptions);
        })();
    </script>
<?php endif ?>

<?php if ($is_preview) : ?>
    <script>
        (() => {
            const block = document.getElementById('<?php echo esc_attr( $anchor ); ?>');
            block.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', e => {
                    e.preventDefault();
                });
            });
        })();
    </script>
<?php endif ?>