<?php
/**
 * Announcement Banner Block
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or its parent block.
 */

$class_name = build_block_class_name( 'relative z-3 py-2 flex items-center justify-center bg-secondary', $block );

$visible = get_field('announcement_banner_visible', 'option');
$text = get_field('announcement_banner_text', 'option');
?>

<?php if ( $visible && have_rows('announcement_banner_items', 'option') ) : ?>
    <div class="<?php echo trim( esc_attr( $class_name ) ) ?>">
        <div class="container-wide">
            <div class="swiper js-swiper" data-options="{
                'autoHeight': false,
                'slidesPerView': 1,
                'loop': <?php echo have_rows('announcement_banner_items', 'option') ? 'true' : 'false'; ?>,
                'autoplay': {
                    'delay': 5000,
                    'disableOnInteraction': false
                },
                'effect': 'fade',
                'fadeEffect': { 'crossFade': true }
            }">
                <div class="swiper-wrapper">
                    <?php while ( have_rows('announcement_banner_items', 'option') ) : the_row(); ?>
                        <?php $text = get_sub_field('text'); ?>
                        <div class="swiper-slide">
                            <?php if ($text): ?>
                                <div class="mx-auto text-white [&_a]:text-current [&_a]:hover:text-current text-center text-sm "><?php echo $text; ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                </div> 
            </div>
        </div>
    </div>
<?php endif ?>