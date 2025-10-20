<?php
/**
 * FAQs Block
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

$class_name = build_block_class_name( '@container text-white bg-purple-700', $block );

$style = build_block_styles( $block );

$heading = get_field('heading');
$button_link = get_field('button_link');
$faqs = get_field('faqs');
$i = 1;
?>

<div id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '' ?>>
    <div class="container-wide grid @4xl:grid-cols-12 gap-x-4 gap-y-8 py-20 @6xl:py-30">
        <div class="flex flex-col gap-y-12 @4xl:col-span-5 6xl:col-span-4 @7xl:col-span-3 pr-8 @7xl:pr-0">
            <?php if ( $heading ) : ?>
                <h2 class="mb-0"><?php echo $heading ?></h2>
            <?php endif ?>

            <?php if ( $button_link ) : ?>
                <div class="hidden @4xl:block">
                    <div class="wp-block-button is-style-white">
                        <a class="wp-block-button__link has-lg-font-size has-custom-font-size wp-element-button" href="<?php echo $button_link['url'] ?>"<?php echo $button_link['target'] === '_blank' ? ' target="_blank" rel="noopener noreferrer"' : '' ?>>
                            <?php echo $button_link['title'] ?>
                        </a>
                    </div>
                </div>
            <?php endif ?>
        </div>

        <?php if ( $faqs ) : ?>
            <div class="@4xl:col-span-7 @7xl:col-span-8 @7xl:col-start-5 js-accordions [&_a]:text-white [&_a]:hover:text-purple-300" data-multi-expand="false">
                <?php foreach ( $faqs as $faq ) {
                    $title = $faq->post_title;
                    $content = get_field('content', $faq->ID);
                    echo do_blocks('<!-- wp:acf/accordion {"name":"acf/accordion","data":{"title":"' . $title . '"},"mode":"preview"} --><!-- wp:html --><!-- /wp:html -->' . $content . '<!-- /wp:acf/accordion -->');
                } ?>
            </div>

            <script type="application/ld+json">
                {
                    "@context": "https://schema.org",
                    "@type": "FAQPage",
                    "mainEntity": [
                        <?php foreach ( $faqs as $faq ) :
                            $title = $faq->post_title;
                            $content = get_field('content', $faq->ID);
                        ?>
                            {
                                "@type": "Question",
                                "name": "<?php echo $faq->post_title ?>",
                                "acceptedAnswer": {
                                    "@type": "Answer",
                                    "text": "<?php echo wp_strip_all_tags( get_field('content', $faq->ID), true ) ?>"
                                }
                            }<?php echo $i < count($faqs) ? ',' : ''; $i++; ?>
                        <?php endforeach ?>
                    ]
                }
            </script>
        <?php endif ?>

        <?php if ( $button_link ) : ?>
            <div class="@4xl:hidden text-center">
                <div class="wp-block-button is-style-white">
                    <a class="wp-block-button__link has-lg-font-size has-custom-font-size wp-element-button" href="<?php echo $button_link['url'] ?>"<?php echo $button_link['target'] === '_blank' ? ' target="_blank" rel="noopener noreferrer"' : '' ?>>
                        <?php echo $button_link['title'] ?>
                    </a>
                </div>
            </div>
        <?php endif ?>
    </div>
</div>