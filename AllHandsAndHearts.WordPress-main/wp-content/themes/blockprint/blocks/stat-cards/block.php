<?php
/**
 * Stat Cards Block
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

$class_name = build_block_class_name( '@container relative z-0', $block );

$style = build_block_styles( $block );

$heading = get_field( 'heading' );
$image = get_field( 'image' );
$cards = get_field( 'cards' );
$i = 0;
?>

<div id="<?php echo esc_attr( $anchor ) ?>" class="<?php echo trim( esc_attr( $class_name ) ) ?>"<?php echo !empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '' ?>>
    <div class="@container container-wide">
        <?php if ( $heading ) : ?>
            <h2 class="text-h4 text-center mb-10">
                <?php echo $heading; ?>
            </h2>
        <?php endif; ?>

        <?php if ( $cards ) :
            $num_cards = count($cards);
        ?>
            <div class="grid gap-4 <?php echo $num_cards <= 3 ? '@2xl:grid-cols-3' : '@2xl:grid-cols-12' ?>">
                <?php foreach ( $cards as $id ) :
                    $card_class_name = '';
                    $row_number = floor($i / 2);
                    $is_even_row = $row_number % 2 === 0;
                    $is_left_card = $i % 2 === 0;

                    if ($num_cards > 3) {
                        if (($is_even_row && $is_left_card) || (!$is_even_row && !$is_left_card)) {
                            $card_class_name = '@2xl:col-span-7';
                        } else {
                            $card_class_name = '@2xl:col-span-5';
                        }
                    }

                    echo '<div class="' . $card_class_name . '">';
                    get_template_part( 'partials/stat-card', null, [ 'id' => $id ] );
                    echo '</div>';
                    
                    $i++;
                endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <?php if ( $image ) : ?>
        <div class="-mt-30 relative -z-1 w-full">
            <div class="absolute inset-0 bg-gradient-to-b from-white/100 to-transparent"></div>
            <div class="w-full max-h-[708px] aspect-[393/488] @2xl:aspect-[1440/708]">
                <?php echo wp_get_attachment_image( $image, '1920', false, ['class' => 'size-full object-cover'] ); ?>
            </div>
        </div>
    <?php endif; ?>
</div>