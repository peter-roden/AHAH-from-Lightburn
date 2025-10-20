<?php
/**
 * Cards Block
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

$allowed_blocks = [
    'acf/card'
];

$template = [
    ['acf/card'],
    ['acf/card'],
    ['acf/card']
];

$layout = get_field('layout');
$cards_per_row = get_field('cards_per_row');

$innerblocks_class_name = '';

if ($layout === 'carousel') {
    $class_name .= ' group/swiper swiper js-swiper';
    $innerblocks_class_name = esc_attr('swiper-wrapper [&>*]:h-auto');
} else {
    $innerblocks_class_name = 'grid gap-6';

    if ($cards_per_row === '2') {
        $innerblocks_class_name .= ' @xl:grid-cols-2';
    } else if ($cards_per_row === '3') {
        $innerblocks_class_name .= ' @xl:grid-cols-3';
    } else if ($cards_per_row === '4') {
        $innerblocks_class_name .= ' @xl:grid-cols-2 @4xl:grid-cols-4';
    } else if ($cards_per_row === '5') {
        $innerblocks_class_name .= ' @xl:grid-cols-2 @2xl:grid-cols-3 @4xl:grid-cols-5';
    } else {
        $innerblocks_class_name .= ' @xl:grid-cols-3';
    }
}
?>

<div id="<?php echo esc_attr($anchor) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr($style) . '"' : '' ?>>
    <InnerBlocks
        allowedBlocks="<?php echo esc_attr(wp_json_encode($allowed_blocks)) ?>"
        template="<?php echo esc_attr(wp_json_encode($template)) ?>"
        class="<?php echo trim(esc_attr($innerblocks_class_name)) ?>"
    />

    <?php if ( $layout === 'carousel' ) {
        get_template_part('partials/swiper-controls', null, [
            'class_name' => 'mt-8'
        ] );
    } ?>
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